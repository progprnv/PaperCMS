<?php
require_once __DIR__ . '/../config/config.php';
require_role(['reviewer', 'admin']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviewer Dashboard - PaperCMS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="dashboard.php" class="navbar-brand">📄 PaperCMS</a>
                <ul class="navbar-menu">
                    <li><a href="dashboard.php" class="active">Dashboard</a></li>
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
    <div class="container" style="padding: 2rem 1.5rem;">
        <h1>Reviewer Dashboard</h1>
        <p class="text-muted">Review and manage research paper submissions</p>
        
        <div id="alertContainer"></div>
        
        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Papers</div>
                <div class="stat-value" id="totalPapers">0</div>
                <div class="stat-description">All submissions</div>
            </div>
            
            <div class="stat-card warning">
                <div class="stat-label">Pending Review</div>
                <div class="stat-value" id="pendingPapers">0</div>
                <div class="stat-description">Awaiting review</div>
            </div>
            
            <div class="stat-card info">
                <div class="stat-label">In Process</div>
                <div class="stat-value" id="inProcessPapers">0</div>
                <div class="stat-description">Under review</div>
            </div>
            
            <div class="stat-card success">
                <div class="stat-label">Published</div>
                <div class="stat-value" id="publishedPapers">0</div>
                <div class="stat-description">Accepted papers</div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="papers.php?filter=pending" class="btn btn-warning btn-lg">
                        📋 Review Pending Papers
                    </a>
                    <a href="papers.php" class="btn btn-outline btn-lg">
                        📚 View All Papers
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Recent Submissions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Submissions</h3>
                <p class="card-subtitle">Latest papers awaiting review</p>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Submitted</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="recentPapersTable">
                            <tr>
                                <td colspan="5" class="text-center text-muted">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    
    <script src="../assets/js/app.js"></script>
    <script>
        checkSession();
        
        // Load stats
        async function loadStats() {
            try {
                const response = await fetch('../api/reviewer.php?action=stats');
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('totalPapers').textContent = data.stats.total || 0;
                    document.getElementById('pendingPapers').textContent = data.stats.pending || 0;
                    document.getElementById('inProcessPapers').textContent = data.stats.in_process || 0;
                    document.getElementById('publishedPapers').textContent = data.stats.published || 0;
                }
            } catch (error) {
                console.error('Failed to load stats:', error);
            }
        }
        
        // Load recent papers
        async function loadRecentPapers() {
            try {
                const response = await fetch('../api/reviewer.php?action=list&status=pending');
                const data = await response.json();
                
                if (data.success) {
                    const tbody = document.getElementById('recentPapersTable');
                    
                    if (data.papers.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No pending papers</td></tr>';
                        return;
                    }
                    
                    const recentPapers = data.papers.slice(0, 5);
                    tbody.innerHTML = recentPapers.map(paper => `
                        <tr>
                            <td><strong>${paper.title}</strong></td>
                            <td>
                                ${paper.author_name}<br>
                                <small class="text-muted">${paper.author_affiliation || ''}</small>
                            </td>
                            <td>${formatDate(paper.submission_date)}</td>
                            <td>${getStatusBadge(paper.status)}</td>
                            <td>
                                <a href="review.php?id=${paper.paper_id}" class="btn btn-sm btn-primary">Review</a>
                            </td>
                        </tr>
                    `).join('');
                }
            } catch (error) {
                console.error('Failed to load papers:', error);
                document.getElementById('recentPapersTable').innerHTML = '<tr><td colspan="5" class="text-center text-danger">Failed to load papers</td></tr>';
            }
        }
        
        // Load data
        document.addEventListener('DOMContentLoaded', () => {
            loadStats();
            loadRecentPapers();
        });
    </script>
</body>
</html>
