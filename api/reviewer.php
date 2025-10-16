<?php
require_once __DIR__ . '/../config/config.php';
require_role(['reviewer', 'admin']);

/**
 * Reviewer API - Paper Review and Status Management
 */

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

switch ($action) {
    case 'list':
        listPapers();
        break;
        
    case 'details':
        getPaperDetails();
        break;
        
    case 'review':
        if ($method === 'POST') {
            submitReview();
        }
        break;
        
    case 'update_status':
        if ($method === 'POST') {
            updatePaperStatus();
        }
        break;
        
    case 'stats':
        getReviewerStats();
        break;
        
    case 'download':
        downloadPaper();
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function listPapers() {
    $status_filter = $_GET['status'] ?? 'all';
    
    try {
        $db = getDB();
        
        $sql = "
            SELECT 
                p.*,
                u.full_name as author_name,
                u.affiliation as author_affiliation,
                u.email as author_email,
                (SELECT COUNT(*) FROM reviews WHERE paper_id = p.paper_id) as review_count
            FROM papers p
            JOIN users u ON p.author_id = u.user_id
        ";
        
        $params = [];
        
        if ($status_filter !== 'all') {
            $sql .= " WHERE p.status = ?";
            $params[] = $status_filter;
        }
        
        $sql .= " ORDER BY p.submission_date DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $papers = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true,
            'papers' => $papers
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch papers: ' . $e->getMessage()]);
    }
}

function getPaperDetails() {
    $paper_id = $_GET['paper_id'] ?? null;
    
    if (!$paper_id) {
        echo json_encode(['success' => false, 'message' => 'Paper ID required']);
        return;
    }
    
    try {
        $db = getDB();
        
        // Get paper details
        $stmt = $db->prepare("
            SELECT p.*, u.full_name as author_name, u.affiliation as author_affiliation, u.email as author_email
            FROM papers p
            JOIN users u ON p.author_id = u.user_id
            WHERE p.paper_id = ?
        ");
        $stmt->execute([$paper_id]);
        $paper = $stmt->fetch();
        
        if (!$paper) {
            echo json_encode(['success' => false, 'message' => 'Paper not found']);
            return;
        }
        
        // Get all reviews
        $stmt = $db->prepare("
            SELECT r.*, u.full_name as reviewer_name, u.email as reviewer_email
            FROM reviews r
            JOIN users u ON r.reviewer_id = u.user_id
            WHERE r.paper_id = ?
            ORDER BY r.review_date DESC
        ");
        $stmt->execute([$paper_id]);
        $reviews = $stmt->fetchAll();
        
        // Get comments
        $stmt = $db->prepare("
            SELECT c.*, u.full_name as user_name, u.role
            FROM paper_comments c
            JOIN users u ON c.user_id = u.user_id
            WHERE c.paper_id = ?
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$paper_id]);
        $comments = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true,
            'paper' => $paper,
            'reviews' => $reviews,
            'comments' => $comments
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch details: ' . $e->getMessage()]);
    }
}

function submitReview() {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $paper_id = $data['paper_id'] ?? null;
    $status = $data['status'] ?? null;
    $comments = $data['comments'] ?? '';
    
    if (!$paper_id || !$status) {
        echo json_encode(['success' => false, 'message' => 'Paper ID and status required']);
        return;
    }
    
    if (!in_array($status, ['pending', 'in_process', 'published', 'rejected'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid status']);
        return;
    }
    
    try {
        $db = getDB();
        
        // Start transaction
        $db->beginTransaction();
        
        // Insert review
        $stmt = $db->prepare("INSERT INTO reviews (paper_id, reviewer_id, status, comments) VALUES (?, ?, ?, ?)");
        $stmt->execute([$paper_id, get_user_id(), $status, $comments]);
        
        // Update paper status
        $stmt = $db->prepare("UPDATE papers SET status = ? WHERE paper_id = ?");
        $stmt->execute([$status, $paper_id]);
        
        // If published, set published date
        if ($status === 'published') {
            $stmt = $db->prepare("UPDATE papers SET published_date = NOW() WHERE paper_id = ?");
            $stmt->execute([$paper_id]);
        }
        
        // Add comment if provided
        if (!empty($comments)) {
            $stmt = $db->prepare("INSERT INTO paper_comments (paper_id, user_id, comment, is_internal) VALUES (?, ?, ?, ?)");
            $stmt->execute([$paper_id, get_user_id(), $comments, true]);
        }
        
        $db->commit();
        
        // Log activity
        log_activity(get_user_id(), 'review_paper', 'paper', $paper_id, "Status: $status");
        
        echo json_encode([
            'success' => true,
            'message' => 'Review submitted successfully'
        ]);
        
    } catch (Exception $e) {
        $db->rollBack();
        echo json_encode(['success' => false, 'message' => 'Review failed: ' . $e->getMessage()]);
    }
}

function updatePaperStatus() {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $paper_id = $data['paper_id'] ?? null;
    $status = $data['status'] ?? null;
    
    if (!$paper_id || !$status) {
        echo json_encode(['success' => false, 'message' => 'Paper ID and status required']);
        return;
    }
    
    if (!in_array($status, ['pending', 'in_process', 'published', 'rejected'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid status']);
        return;
    }
    
    try {
        $db = getDB();
        
        $stmt = $db->prepare("UPDATE papers SET status = ? WHERE paper_id = ?");
        $stmt->execute([$status, $paper_id]);
        
        if ($status === 'published') {
            $stmt = $db->prepare("UPDATE papers SET published_date = NOW() WHERE paper_id = ?");
            $stmt->execute([$paper_id]);
        }
        
        log_activity(get_user_id(), 'update_paper_status', 'paper', $paper_id, "New status: $status");
        
        echo json_encode([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Update failed: ' . $e->getMessage()]);
    }
}

function getReviewerStats() {
    try {
        $db = getDB();
        
        // Get review counts
        $stmt = $db->prepare("
            SELECT COUNT(*) as total_reviews
            FROM reviews
            WHERE reviewer_id = ?
        ");
        $stmt->execute([get_user_id()]);
        $review_stats = $stmt->fetch();
        
        // Get paper counts by status
        $stmt = $db->prepare("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'in_process' THEN 1 ELSE 0 END) as in_process,
                SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
            FROM papers
        ");
        $stmt->execute();
        $paper_stats = $stmt->fetch();
        
        echo json_encode([
            'success' => true,
            'stats' => array_merge($review_stats, $paper_stats)
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch stats: ' . $e->getMessage()]);
    }
}

function downloadPaper() {
    $paper_id = $_GET['paper_id'] ?? null;
    
    if (!$paper_id) {
        die('Paper ID required');
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT pdf_path, pdf_filename FROM papers WHERE paper_id = ?");
        $stmt->execute([$paper_id]);
        $paper = $stmt->fetch();
        
        if (!$paper || !file_exists($paper['pdf_path'])) {
            die('Paper not found');
        }
        
        // Increment download count
        $stmt = $db->prepare("UPDATE papers SET download_count = download_count + 1 WHERE paper_id = ?");
        $stmt->execute([$paper_id]);
        
        // Log activity
        log_activity(get_user_id(), 'download_paper', 'paper', $paper_id);
        
        // Send file
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $paper['pdf_filename'] . '"');
        header('Content-Length: ' . filesize($paper['pdf_path']));
        readfile($paper['pdf_path']);
        exit;
        
    } catch (Exception $e) {
        die('Download failed: ' . $e->getMessage());
    }
}
?>
