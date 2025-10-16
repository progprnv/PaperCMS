<?php
require_once __DIR__ . '/../config/config.php';
require_role(['author']);

/**
 * Author API - Paper Submission and Management
 */

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

switch ($action) {
    case 'submit':
        if ($method === 'POST') {
            submitPaper();
        }
        break;
        
    case 'list':
        listMyPapers();
        break;
        
    case 'delete':
        if ($method === 'POST') {
            deletePaper();
        }
        break;
        
    case 'details':
        getPaperDetails();
        break;
        
    case 'stats':
        getAuthorStats();
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function submitPaper() {
    // Check if file was uploaded
    if (!isset($_FILES['pdf']) || $_FILES['pdf']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'PDF file upload failed']);
        return;
    }
    
    // Validate file
    $file = $_FILES['pdf'];
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if ($file_ext !== 'pdf') {
        echo json_encode(['success' => false, 'message' => 'Only PDF files are allowed']);
        return;
    }
    
    if ($file['size'] > MAX_FILE_SIZE) {
        echo json_encode(['success' => false, 'message' => 'File size exceeds maximum allowed (' . format_file_size(MAX_FILE_SIZE) . ')']);
        return;
    }
    
    // Get form data
    $title = sanitize_input($_POST['title'] ?? '');
    $abstract = sanitize_input($_POST['abstract'] ?? '');
    $keywords = sanitize_input($_POST['keywords'] ?? '');
    
    if (empty($title)) {
        echo json_encode(['success' => false, 'message' => 'Paper title is required']);
        return;
    }
    
    try {
        // Generate unique filename
        $filename = uniqid() . '_' . time() . '.pdf';
        $filepath = UPLOAD_DIR . $filename;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to save file']);
            return;
        }
        
        // Insert into database
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO papers (author_id, title, abstract, keywords, pdf_filename, pdf_path, file_size) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            get_user_id(),
            $title,
            $abstract,
            $keywords,
            $file['name'],
            $filepath,
            $file['size']
        ]);
        
        $paper_id = $db->lastInsertId();
        
        // Log activity
        log_activity(get_user_id(), 'submit_paper', 'paper', $paper_id, $title);
        
        echo json_encode([
            'success' => true,
            'message' => 'Paper submitted successfully',
            'paper_id' => $paper_id
        ]);
        
    } catch (Exception $e) {
        // Delete uploaded file if database insert fails
        if (isset($filepath) && file_exists($filepath)) {
            unlink($filepath);
        }
        echo json_encode(['success' => false, 'message' => 'Submission failed: ' . $e->getMessage()]);
    }
}

function listMyPapers() {
    try {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT 
                p.*,
                (SELECT COUNT(*) FROM reviews WHERE paper_id = p.paper_id) as review_count,
                (SELECT MAX(review_date) FROM reviews WHERE paper_id = p.paper_id) as last_review_date
            FROM papers p
            WHERE p.author_id = ?
            ORDER BY p.submission_date DESC
        ");
        $stmt->execute([get_user_id()]);
        $papers = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true,
            'papers' => $papers
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch papers: ' . $e->getMessage()]);
    }
}

function deletePaper() {
    $data = json_decode(file_get_contents('php://input'), true);
    $paper_id = $data['paper_id'] ?? null;
    
    if (!$paper_id) {
        echo json_encode(['success' => false, 'message' => 'Paper ID required']);
        return;
    }
    
    try {
        $db = getDB();
        
        // Get paper details and verify ownership
        $stmt = $db->prepare("SELECT * FROM papers WHERE paper_id = ? AND author_id = ?");
        $stmt->execute([$paper_id, get_user_id()]);
        $paper = $stmt->fetch();
        
        if (!$paper) {
            echo json_encode(['success' => false, 'message' => 'Paper not found or unauthorized']);
            return;
        }
        
        // Only allow deletion of pending papers
        if ($paper['status'] !== 'pending') {
            echo json_encode(['success' => false, 'message' => 'Cannot delete papers that are being reviewed or published']);
            return;
        }
        
        // Delete file
        if (file_exists($paper['pdf_path'])) {
            unlink($paper['pdf_path']);
        }
        
        // Delete from database
        $stmt = $db->prepare("DELETE FROM papers WHERE paper_id = ?");
        $stmt->execute([$paper_id]);
        
        log_activity(get_user_id(), 'delete_paper', 'paper', $paper_id, $paper['title']);
        
        echo json_encode(['success' => true, 'message' => 'Paper deleted successfully']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Delete failed: ' . $e->getMessage()]);
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
        $stmt = $db->prepare("
            SELECT p.*, u.full_name as author_name, u.affiliation
            FROM papers p
            JOIN users u ON p.author_id = u.user_id
            WHERE p.paper_id = ? AND p.author_id = ?
        ");
        $stmt->execute([$paper_id, get_user_id()]);
        $paper = $stmt->fetch();
        
        if (!$paper) {
            echo json_encode(['success' => false, 'message' => 'Paper not found']);
            return;
        }
        
        // Get reviews
        $stmt = $db->prepare("
            SELECT r.*, u.full_name as reviewer_name
            FROM reviews r
            JOIN users u ON r.reviewer_id = u.user_id
            WHERE r.paper_id = ?
            ORDER BY r.review_date DESC
        ");
        $stmt->execute([$paper_id]);
        $reviews = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true,
            'paper' => $paper,
            'reviews' => $reviews
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch details: ' . $e->getMessage()]);
    }
}

function getAuthorStats() {
    try {
        $db = getDB();
        
        // Get counts by status
        $stmt = $db->prepare("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'in_process' THEN 1 ELSE 0 END) as in_process,
                SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                SUM(download_count) as total_downloads
            FROM papers
            WHERE author_id = ?
        ");
        $stmt->execute([get_user_id()]);
        $stats = $stmt->fetch();
        
        echo json_encode([
            'success' => true,
            'stats' => $stats
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch stats: ' . $e->getMessage()]);
    }
}
?>
