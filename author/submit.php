<?php
require_once __DIR__ . '/../config/config.php';
require_role(['author']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Paper - PaperCMS</title>
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
                    <li><a href="submit.php" class="active">Submit Paper</a></li>
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
    <div class="container" style="padding: 2rem 1.5rem; max-width: 900px;">
        <h1>Submit Research Paper</h1>
        <p class="text-muted">Upload your research paper for review</p>
        
        <div id="alertContainer"></div>
        
        <div class="card">
            <form id="submitForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title" class="form-label required">Paper Title</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter paper title" required>
                </div>
                
                <div class="form-group">
                    <label for="abstract" class="form-label required">Abstract</label>
                    <textarea id="abstract" name="abstract" class="form-control" rows="6" placeholder="Enter paper abstract" required></textarea>
                    <small class="form-text">Provide a brief summary of your research</small>
                </div>
                
                <div class="form-group">
                    <label for="keywords" class="form-label">Keywords</label>
                    <input type="text" id="keywords" name="keywords" class="form-control" placeholder="machine learning, AI, neural networks">
                    <small class="form-text">Separate keywords with commas</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label required">Upload PDF</label>
                    <div class="file-upload" id="fileUploadArea">
                        <div class="file-upload-icon">📄</div>
                        <div class="file-upload-text">
                            <strong>Click to upload</strong> or drag and drop
                        </div>
                        <div class="file-upload-hint">PDF only (Max 10MB)</div>
                    </div>
                    <input type="file" id="pdfFile" name="pdf" accept=".pdf" style="display: none;" required>
                    <div class="file-preview" id="filePreview"></div>
                </div>
                
                <div class="card-footer" style="margin-top: 2rem; padding-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary btn-lg">
                        🚀 Submit Paper
                    </button>
                    <a href="dashboard.php" class="btn btn-secondary btn-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    
    <script src="../assets/js/app.js"></script>
    <script>
        // Check session
        checkSession();
        
        // Initialize file upload
        initFileUpload('fileUploadArea', 'pdfFile', 'filePreview');
        
        // Handle form submission
        document.getElementById('submitForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const fileInput = document.getElementById('pdfFile');
            if (!fileInput.files.length) {
                showAlert('Please select a PDF file', 'error');
                return;
            }
            
            const file = fileInput.files[0];
            if (file.size > 10485760) { // 10MB
                showAlert('File size must be less than 10MB', 'error');
                return;
            }
            
            const formData = new FormData();
            formData.append('title', document.getElementById('title').value);
            formData.append('abstract', document.getElementById('abstract').value);
            formData.append('keywords', document.getElementById('keywords').value);
            formData.append('pdf', file);
            
            showLoading();
            
            try {
                const response = await fetch('../api/author.php?action=submit', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Paper submitted successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = 'my-papers.php';
                    }, 1500);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Submission failed. Please try again.', 'error');
            } finally {
                hideLoading();
            }
        });
    </script>
</body>
</html>
