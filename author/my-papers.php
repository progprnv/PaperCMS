<?php
require_once __DIR__ . '/../config/config.php';
require_role(['author']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Papers - PaperCMS</title>
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
    <div class="container" style="padding: 2rem 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h1>My Papers</h1>
                <p class="text-muted">Manage all your submissions</p>
            </div>
            <a href="submit.php" class="btn btn-primary">
                ➕ Submit New Paper
            </a>
        </div>
        
        <div id="alertContainer"></div>
        
        <!-- Filter -->
        <div class="card">
            <div class="card-body">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="statusFilter" class="form-label">Filter by Status</label>
                    <select id="statusFilter" class="form-control" style="max-width: 300px;">
                        <option value="all">All Papers</option>
                        <option value="pending">Pending</option>
                        <option value="in_process">In Process</option>
                        <option value="published">Published</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Papers List -->
        <div id="papersContainer"></div>
    </div>
    
    <!-- View Details Modal -->
    <div class="modal-overlay" id="viewModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Paper Details</h3>
                <button class="modal-close" onclick="hideModal('viewModal')">×</button>
            </div>
            <div class="modal-body" id="modalBody">
                <p class="text-center text-muted">Loading...</p>
            </div>
        </div>
    </div>
    
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    
    <script src="../assets/js/app.js"></script>
    <script>
        checkSession();
        
        let allPapers = [];
        
        // Load papers
        async function loadPapers() {
            showLoading();
            try {
                const response = await fetch('../api/author.php?action=list');
                const data = await response.json();
                
                if (data.success) {
                    allPapers = data.papers;
                    filterPapers();
                }
            } catch (error) {
                showAlert('Failed to load papers', 'error');
            } finally {
                hideLoading();
            }
        }
        
        // Filter papers
        function filterPapers() {
            const filter = document.getElementById('statusFilter').value;
            const filtered = filter === 'all' ? allPapers : allPapers.filter(p => p.status === filter);
            displayPapers(filtered);
        }
        
        // Display papers
        function displayPapers(papers) {
            const container = document.getElementById('papersContainer');
            
            if (papers.length === 0) {
                container.innerHTML = `
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted">No papers found. <a href="submit.php">Submit your first paper</a></p>
                        </div>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = papers.map(paper => `
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <h3 class="card-title">${paper.title}</h3>
                                <p class="card-subtitle">Submitted: ${formatDate(paper.submission_date)}</p>
                            </div>
                            ${getStatusBadge(paper.status)}
                        </div>
                    </div>
                    <div class="card-body">
                        <p><strong>Abstract:</strong></p>
                        <p style="color: var(--text-secondary);">${paper.abstract || 'No abstract provided'}</p>
                        ${paper.keywords ? `<p><strong>Keywords:</strong> <span class="text-muted">${paper.keywords}</span></p>` : ''}
                        <p><strong>File:</strong> ${paper.pdf_filename} (${formatFileSize(paper.file_size)})</p>
                        <p><strong>Reviews:</strong> ${paper.review_count || 0} review(s)</p>
                        ${paper.download_count ? `<p><strong>Downloads:</strong> ${paper.download_count}</p>` : ''}
                    </div>
                    <div class="card-footer">
                        <div>
                            <button class="btn btn-sm btn-primary" onclick="viewDetails(${paper.paper_id})">
                                👁️ View Details
                            </button>
                            ${paper.status === 'pending' ? `
                                <button class="btn btn-sm btn-danger" onclick="deletePaper(${paper.paper_id}, '${paper.title}')">
                                    🗑️ Delete
                                </button>
                            ` : ''}
                        </div>
                        <small class="text-muted">Paper ID: #${paper.paper_id}</small>
                    </div>
                </div>
            `).join('');
        }
        
        // View paper details
        async function viewDetails(paperId) {
            showModal('viewModal');
            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = '<p class="text-center text-muted">Loading...</p>';
            
            try {
                const response = await fetch(`../api/author.php?action=details&paper_id=${paperId}`);
                const data = await response.json();
                
                if (data.success) {
                    const paper = data.paper;
                    const reviews = data.reviews;
                    
                    modalBody.innerHTML = `
                        <div style="margin-bottom: 1.5rem;">
                            <h4>${paper.title}</h4>
                            <p class="text-muted">Paper ID: #${paper.paper_id}</p>
                        </div>
                        
                        <div style="margin-bottom: 1rem;">
                            <strong>Status:</strong> ${getStatusBadge(paper.status)}
                        </div>
                        
                        <div style="margin-bottom: 1rem;">
                            <strong>Submitted:</strong> ${formatDate(paper.submission_date)}
                        </div>
                        
                        ${paper.published_date ? `
                            <div style="margin-bottom: 1rem;">
                                <strong>Published:</strong> ${formatDate(paper.published_date)}
                            </div>
                        ` : ''}
                        
                        <div style="margin-bottom: 1rem;">
                            <strong>Abstract:</strong>
                            <p style="color: var(--text-secondary); margin-top: 0.5rem;">${paper.abstract}</p>
                        </div>
                        
                        ${reviews.length > 0 ? `
                            <div style="margin-top: 2rem;">
                                <h5>Reviews (${reviews.length})</h5>
                                ${reviews.map(review => `
                                    <div style="background-color: var(--bg-tertiary); padding: 1rem; border-radius: var(--radius-md); margin-top: 1rem;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                            <strong>${review.reviewer_name}</strong>
                                            ${getStatusBadge(review.status)}
                                        </div>
                                        <small class="text-muted">${formatDate(review.review_date)}</small>
                                        ${review.comments ? `<p style="margin-top: 0.5rem; color: var(--text-secondary);">${review.comments}</p>` : ''}
                                    </div>
                                `).join('')}
                            </div>
                        ` : '<p class="text-muted" style="margin-top: 2rem;">No reviews yet</p>'}
                    `;
                }
            } catch (error) {
                modalBody.innerHTML = '<p class="text-center text-danger">Failed to load details</p>';
            }
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
                    loadPapers();
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Delete failed', 'error');
            } finally {
                hideLoading();
            }
        }
        
        // Event listeners
        document.getElementById('statusFilter').addEventListener('change', filterPapers);
        
        // Load papers on page load
        loadPapers();
    </script>
</body>
</html>
