<?php
require_once __DIR__ . '/../config/config.php';
require_role(['author']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author Dashboard - PaperCMS</title>
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
                    <li><a href="submit.php">Submit Paper</a></li>
                    <li><a href="my-papers.php">My Papers</a></li>
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
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
        <p class="text-muted">Manage your research paper submissions</p>
        
        <div id="alertContainer"></div>
        
        <!-- Stats Grid -->
        <div class="stats-grid" id="statsContainer">
            <div class="stat-card">
                <div class="stat-label">Total Submissions</div>
                <div class="stat-value" id="totalPapers">0</div>
                <div class="stat-description">All time papers</div>
            </div>
            
            <div class="stat-card warning">
                <div class="stat-label">Pending Review</div>
                <div class="stat-value" id="pendingPapers">0</div>
                <div class="stat-description">Awaiting reviewer</div>
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
                    <a href="submit.php" class="btn btn-primary btn-lg">
                        ➕ Submit New Paper
                    </a>
                    <a href="my-papers.php" class="btn btn-outline btn-lg">
                        📋 View All Submissions
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Recent Papers -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Submissions</h3>
                <p class="card-subtitle">Your latest paper submissions</p>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Submitted</th>
                                <th>Status</th>
                                <th>Reviews</th>
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
        // Check session
        checkSession();
        
        // Load stats
        async function loadStats() {
            try {
                const response = await fetch('../api/author.php?action=stats');
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
                const response = await fetch('../api/author.php?action=list');
                const data = await response.json();
                
                if (data.success) {
                    const tbody = document.getElementById('recentPapersTable');
                    
                    if (data.papers.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No submissions yet. <a href="submit.php">Submit your first paper</a></td></tr>';
                        return;
                    }
                    
                    const recentPapers = data.papers.slice(0, 5);
                    tbody.innerHTML = recentPapers.map(paper => `
                        <tr>
                            <td>
                                <strong>${paper.title}</strong>
                            </td>
                            <td>${formatDate(paper.submission_date)}</td>
                            <td>${getStatusBadge(paper.status)}</td>
                            <td>${paper.review_count || 0} review(s)</td>
                            <td>
                                <a href="view-paper.php?id=${paper.paper_id}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    `).join('');
                }
            } catch (error) {
                console.error('Failed to load papers:', error);
                document.getElementById('recentPapersTable').innerHTML = '<tr><td colspan="5" class="text-center text-danger">Failed to load papers</td></tr>';
            }
        }
        
        // Load data on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadStats();
            loadRecentPapers();
        });
    </script>
</body>
</html>
