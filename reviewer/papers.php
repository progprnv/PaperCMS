<?php
require_once __DIR__ . '/../config/config.php';
require_role(['reviewer', 'admin']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Papers - PaperCMS</title>
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
                    <li><a href="papers.php" class="active">All Papers</a></li>
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
    <div class="container" style="padding: 2rem 1.5rem;">
        <h1>All Papers</h1>
        <p class="text-muted">Review and manage submissions</p>
        
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
    
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    
    <script src="../assets/js/app.js"></script>
    <script>
        checkSession();
        
        // Get filter from URL
        const urlParams = new URLSearchParams(window.location.search);
        const filterParam = urlParams.get('filter');
        if (filterParam) {
            document.getElementById('statusFilter').value = filterParam;
        }
        
        let allPapers = [];
        
        // Load papers
        async function loadPapers() {
            showLoading();
            try {
                const response = await fetch('../api/reviewer.php?action=list');
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
                            <p class="text-muted">No papers found</p>
                        </div>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = papers.map(paper => `
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div style="flex: 1;">
                                <h3 class="card-title">${paper.title}</h3>
                                <p class="card-subtitle">
                                    By: <strong>${paper.author_name}</strong>
                                    ${paper.author_affiliation ? ` - ${paper.author_affiliation}` : ''}
                                </p>
                            </div>
                            ${getStatusBadge(paper.status)}
                        </div>
                    </div>
                    <div class="card-body">
                        <p><strong>Abstract:</strong></p>
                        <p style="color: var(--text-secondary);">${paper.abstract || 'No abstract provided'}</p>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
                            <div>
                                <small class="text-muted">Submitted:</small><br>
                                <strong>${formatDate(paper.submission_date)}</strong>
                            </div>
                            <div>
                                <small class="text-muted">Reviews:</small><br>
                                <strong>${paper.review_count || 0}</strong>
                            </div>
                            <div>
                                <small class="text-muted">Author Email:</small><br>
                                <strong>${paper.author_email}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="review.php?id=${paper.paper_id}" class="btn btn-sm btn-primary">
                                👁️ Review
                            </a>
                            <button class="btn btn-sm btn-secondary" onclick="downloadPaper(${paper.paper_id})">
                                📥 Download PDF
                            </button>
                            ${paper.status !== 'published' ? `
                                <button class="btn btn-sm btn-success" onclick="quickUpdate(${paper.paper_id}, 'published')">
                                    ✓ Publish
                                </button>
                            ` : ''}
                        </div>
                        <small class="text-muted">Paper ID: #${paper.paper_id}</small>
                    </div>
                </div>
            `).join('');
        }
        
        // Download paper
        function downloadPaper(paperId) {
            window.open(`../api/reviewer.php?action=download&paper_id=${paperId}`, '_blank');
        }
        
        // Quick status update
        async function quickUpdate(paperId, status) {
            if (!confirm(`Are you sure you want to mark this paper as ${status}?`)) {
                return;
            }
            
            showLoading();
            try {
                const response = await fetch('../api/reviewer.php?action=update_status', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ paper_id: paperId, status: status })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Status updated successfully', 'success');
                    loadPapers();
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Update failed', 'error');
            } finally {
                hideLoading();
            }
        }
        
        // Event listeners
        document.getElementById('statusFilter').addEventListener('change', filterPapers);
        
        // Load papers
        loadPapers();
    </script>
</body>
</html>
