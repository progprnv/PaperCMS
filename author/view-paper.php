<?php
require_once __DIR__ . '/../config/config.php';
require_role(['author']);

$paper_id = $_GET['id'] ?? null;
if (!$paper_id) {
    header('Location: my-papers.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Paper - PaperCMS</title>
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
                    <li><a href="submit.php">Submit Paper</a></li>
                    <li><a href="my-papers.php" class="active">My Papers</a></li>
                    <li>
                        <div class="user-menu">
                            <div class="user-avatar" title="<?php echo htmlspecialchars($_SESSION['full_name']); ?>">
                                <?php echo strtoupper(substr($_SESSION['full_name'], 0, 1)); ?>
                            </div>
                            <div class="dropdown-menu">
                                <div class="dropdown-item">
                                    <strong><?php echo htmlspecialchars($_SESSION['full_name']); ?></strong><br>
                                    <small class="badge badge-author">Author</small>
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
            <a href="my-papers.php" class="btn btn-secondary">← Back to My Papers</a>
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
        
        <!-- Reviews Section -->
        <div class="card" id="reviewsCard" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Reviews & Feedback</h3>
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
                const response = await fetch(`../api/author.php?action=details&paper_id=${paperId}`);
                const data = await response.json();
                
                if (data.success) {
                    displayPaper(data.paper);
                    displayReviews(data.reviews);
                } else {
                    showAlert(data.message || 'Failed to load paper details', 'error');
                    setTimeout(() => {
                        window.location.href = 'my-papers.php';
                    }, 2000);
                }
            } catch (error) {
                showAlert('Failed to load paper', 'error');
                setTimeout(() => {
                    window.location.href = 'my-papers.php';
                }, 2000);
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
                                <div>
                                    <small class="text-muted">Size:</small><br>
                                    <strong>${formatFileSize(paper.file_size)}</strong>
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
                        
                        <div style="margin-bottom: 1rem;">
                            <h4>Statistics</h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-top: 1rem;">
                                <div style="background-color: var(--bg-tertiary); padding: 1rem; border-radius: var(--radius-md); text-align: center;">
                                    <small class="text-muted">Downloads</small><br>
                                    <strong style="font-size: 1.5rem;">${paper.download_count || 0}</strong>
                                </div>
                            </div>
                        </div>
                        
                        ${paper.status === 'pending' ? `
                            <div style="margin-top: 2rem;">
                                <button class="btn btn-danger" onclick="deletePaper(${paper.paper_id}, '${paper.title.replace(/'/g, "\\'")}')">
                                    🗑️ Delete Paper
                                </button>
                            </div>
                        ` : ''}
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
                            <small class="text-muted">Reviewed on: ${formatDate(review.review_date)}</small>
                        </div>
                        ${getStatusBadge(review.status)}
                    </div>
                    ${review.comments ? `
                        <div style="margin-top: 1rem; padding: 1rem; background-color: var(--bg-primary); border-radius: var(--radius-sm);">
                            <strong>Reviewer Comments:</strong>
                            <p style="margin-top: 0.5rem; color: var(--text-secondary); line-height: 1.6;">${review.comments}</p>
                        </div>
                    ` : '<p class="text-muted">No comments provided</p>'}
                </div>
            `).join('');
        }
        
        // Delete paper
        async function deletePaper(paperId, title) {
            if (!confirm(`Are you sure you want to delete "${title}"?\n\nThis action cannot be undone.`)) {
                return;
            }
            
            showLoading();
            try {
                const response = await fetch('../api/author.php?action=delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ paper_id: paperId })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Paper deleted successfully', 'success');
                    setTimeout(() => {
                        window.location.href = 'my-papers.php';
                    }, 1500);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Delete failed', 'error');
            } finally {
                hideLoading();
            }
        }
        
        // Load paper details on page load
        loadPaperDetails();
    </script>
</body>
</html>
