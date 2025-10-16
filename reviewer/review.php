<?php
require_once __DIR__ . '/../config/config.php';
require_role(['reviewer', 'admin']);

$paper_id = $_GET['id'] ?? null;
if (!$paper_id) {
    header('Location: papers.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Paper - PaperCMS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="dashboard.php" class="navbar-brand">📄 PaperCMS</a>
                <ul class="navbar-menu">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="papers.php">All Papers</a></li>
                    <li>
                        <div class="user-menu">
                            <div class="user-avatar" title="<?php echo htmlspecialchars($_SESSION['full_name']); ?>">
                                <?php echo strtoupper(substr($_SESSION['full_name'], 0, 1)); ?>
                            </div>
                            <div class="dropdown-menu">
                                <div class="dropdown-item">
                                    <strong><?php echo htmlspecialchars($_SESSION['full_name']); ?></strong><br>
                                    <small class="badge badge-reviewer">Reviewer</small>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item" onclick="logout(); return false;">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container" style="padding: 2rem 1.5rem; max-width: 1000px;">
        <div style="margin-bottom: 2rem;">
            <a href="papers.php" class="btn btn-secondary">← Back to Papers</a>
        </div>
        
        <div id="alertContainer"></div>
        
        <div id="paperContainer">
            <div class="card">
                <div class="card-body text-center">
                    <div class="spinner" style="margin: 2rem auto;"></div>
                    <p class="text-muted">Loading paper details...</p>
                </div>
            </div>
        </div>
        
        <!-- Review Form -->
        <div class="card" id="reviewFormCard" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Submit Review</h3>
                <p class="card-subtitle">Provide your review and update paper status</p>
            </div>
            <div class="card-body">
                <form id="reviewForm">
                    <input type="hidden" id="paperId" value="<?php echo htmlspecialchars($paper_id); ?>">
                    
                    <div class="form-group">
                        <label for="status" class="form-label required">Status Decision</label>
                        <select id="status" class="form-control" required>
                            <option value="">Select status...</option>
                            <option value="in_process">In Process</option>
                            <option value="published">Publish</option>
                            <option value="rejected">Reject</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="comments" class="form-label">Review Comments</label>
                        <textarea id="comments" class="form-control" rows="6" placeholder="Enter your review comments, feedback, or reasons for the decision..."></textarea>
                        <small class="form-text">These comments will be visible to the author</small>
                    </div>
                    
                    <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                        <button type="submit" class="btn btn-primary btn-lg">
                            ✓ Submit Review
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg" onclick="window.location.href='papers.php'">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Previous Reviews -->
        <div class="card" id="reviewsCard" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Previous Reviews</h3>
            </div>
            <div class="card-body" id="reviewsContainer">
            </div>
        </div>
    </div>
    
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    
    <script src="../assets/js/app.js"></script>
    <script>
        checkSession();
        
        const paperId = <?php echo json_encode($paper_id); ?>;
        
        // Load paper details
        async function loadPaperDetails() {
            try {
                const response = await fetch(`../api/reviewer.php?action=details&paper_id=${paperId}`);
                const data = await response.json();
                
                if (data.success) {
                    displayPaper(data.paper);
                    displayReviews(data.reviews);
                    document.getElementById('reviewFormCard').style.display = 'block';
                } else {
                    showAlert('Failed to load paper details', 'error');
                }
            } catch (error) {
                showAlert('Failed to load paper', 'error');
            }
        }
        
        // Display paper
        function displayPaper(paper) {
            const container = document.getElementById('paperContainer');
            container.innerHTML = `
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <h2 class="card-title">${paper.title}</h2>
                                <p class="card-subtitle">Paper ID: #${paper.paper_id}</p>
                            </div>
                            ${getStatusBadge(paper.status)}
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 1.5rem;">
                            <h4>Author Information</h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1rem;">
                                <div>
                                    <small class="text-muted">Name:</small><br>
                                    <strong>${paper.author_name}</strong>
                                </div>
                                ${paper.author_affiliation ? `
                                    <div>
                                        <small class="text-muted">Affiliation:</small><br>
                                        <strong>${paper.author_affiliation}</strong>
                                    </div>
                                ` : ''}
                                <div>
                                    <small class="text-muted">Email:</small><br>
                                    <strong>${paper.author_email}</strong>
                                </div>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <h4>Submission Details</h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1rem;">
                                <div>
                                    <small class="text-muted">Submitted:</small><br>
                                    <strong>${formatDate(paper.submission_date)}</strong>
                                </div>
                                ${paper.published_date ? `
                                    <div>
                                        <small class="text-muted">Published:</small><br>
                                        <strong>${formatDate(paper.published_date)}</strong>
                                    </div>
                                ` : ''}
                                <div>
                                    <small class="text-muted">File:</small><br>
                                    <strong>${paper.pdf_filename}</strong>
                                </div>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <h4>Abstract</h4>
                            <p style="color: var(--text-secondary); margin-top: 0.5rem; line-height: 1.8;">
                                ${paper.abstract || 'No abstract provided'}
                            </p>
                        </div>
                        
                        ${paper.keywords ? `
                            <div style="margin-bottom: 1.5rem;">
                                <h4>Keywords</h4>
                                <p style="color: var(--text-secondary); margin-top: 0.5rem;">
                                    ${paper.keywords}
                                </p>
                            </div>
                        ` : ''}
                        
                        <div style="margin-top: 2rem;">
                            <button class="btn btn-primary btn-lg" onclick="downloadPaper(${paper.paper_id})">
                                📥 Download PDF
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Display reviews
        function displayReviews(reviews) {
            if (reviews.length === 0) {
                return;
            }
            
            document.getElementById('reviewsCard').style.display = 'block';
            const container = document.getElementById('reviewsContainer');
            
            container.innerHTML = reviews.map(review => `
                <div style="background-color: var(--bg-tertiary); padding: 1.5rem; border-radius: var(--radius-md); margin-bottom: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <strong>${review.reviewer_name}</strong><br>
                            <small class="text-muted">${review.reviewer_email}</small>
                        </div>
                        ${getStatusBadge(review.status)}
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <small class="text-muted">Reviewed on: ${formatDate(review.review_date)}</small>
                    </div>
                    ${review.comments ? `
                        <div style="margin-top: 1rem; padding: 1rem; background-color: var(--bg-primary); border-radius: var(--radius-sm);">
                            <strong>Comments:</strong>
                            <p style="margin-top: 0.5rem; color: var(--text-secondary);">${review.comments}</p>
                        </div>
                    ` : '<p class="text-muted">No comments provided</p>'}
                </div>
            `).join('');
        }
        
        // Download paper
        function downloadPaper(paperId) {
            window.open(`../api/reviewer.php?action=download&paper_id=${paperId}`, '_blank');
        }
        
        // Submit review
        document.getElementById('reviewForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const status = document.getElementById('status').value;
            const comments = document.getElementById('comments').value;
            
            if (!status) {
                showAlert('Please select a status', 'error');
                return;
            }
            
            showLoading();
            
            try {
                const response = await fetch('../api/reviewer.php?action=review', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        paper_id: paperId,
                        status: status,
                        comments: comments
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Review submitted successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = 'papers.php';
                    }, 1500);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Review submission failed', 'error');
            } finally {
                hideLoading();
            }
        });
        
        // Load paper details on page load
        loadPaperDetails();
    </script>
</body>
</html>
