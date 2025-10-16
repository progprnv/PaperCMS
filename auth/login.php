<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PaperCMS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
        }
        
        .auth-card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            padding: 2.5rem;
        }
        
        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .auth-logo h1 {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .auth-logo p {
            color: var(--text-muted);
            font-size: 0.875rem;
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <h1>📄 PaperCMS</h1>
                <p>Research Paper Repository System</p>
            </div>
            
            <div id="alertContainer"></div>
            
            <form id="loginForm">
                <div class="form-group">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" id="email" class="form-control" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label required">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    Sign In
                </button>
            </form>
            
            <div class="auth-footer">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
            
            <div class="auth-footer mt-3">
                <small>
                    <strong>Demo Accounts:</strong><br>
                    Author: author@example.com / password<br>
                    Reviewer: reviewer@example.com / password
                </small>
            </div>
        </div>
    </div>
    
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    
    <script src="../assets/js/app.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            showLoading();
            
            try {
                const response = await fetch('../api/auth.php?action=login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Login successful! Redirecting...', 'success');
                    
                    setTimeout(() => {
                        if (data.user.role === 'author') {
                            window.location.href = '../author/dashboard.php';
                        } else if (data.user.role === 'reviewer' || data.user.role === 'admin') {
                            window.location.href = '../reviewer/dashboard.php';
                        } else {
                            window.location.href = '../index.php';
                        }
                    }, 1000);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Login failed. Please try again.', 'error');
            } finally {
                hideLoading();
            }
        });
    </script>
</body>
</html>
