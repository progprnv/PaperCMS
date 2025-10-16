<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PaperCMS</title>
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
            max-width: 500px;
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
        
        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }
        
        .role-option {
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 1rem;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }
        
        .role-option input[type="radio"] {
            display: none;
        }
        
        .role-option:hover {
            border-color: var(--primary-light);
            background-color: rgba(37, 99, 235, 0.05);
        }
        
        .role-option input[type="radio"]:checked + .role-content {
            color: var(--primary-color);
        }
        
        .role-option input[type="radio"]:checked ~ .role-option {
            border-color: var(--primary-color);
            background-color: rgba(37, 99, 235, 0.1);
        }
        
        .role-option.selected {
            border-color: var(--primary-color);
            background-color: rgba(37, 99, 235, 0.1);
        }
        
        .role-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .role-title {
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .role-desc {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <h1>📄 PaperCMS</h1>
                <p>Create your account</p>
            </div>
            
            <div id="alertContainer"></div>
            
            <form id="registerForm">
                <div class="form-group">
                    <label class="form-label required">Select Role</label>
                    <div class="role-selector">
                        <label class="role-option" data-role="author">
                            <input type="radio" name="role" value="author" required>
                            <div class="role-content">
                                <div class="role-icon">✍️</div>
                                <div class="role-title">Author</div>
                                <div class="role-desc">Submit research papers</div>
                            </div>
                        </label>
                        <label class="role-option" data-role="reviewer">
                            <input type="radio" name="role" value="reviewer" required>
                            <div class="role-content">
                                <div class="role-icon">👨‍🏫</div>
                                <div class="role-title">Reviewer</div>
                                <div class="role-desc">Review submissions</div>
                            </div>
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="fullName" class="form-label required">Full Name</label>
                    <input type="text" id="fullName" class="form-control" placeholder="Enter your full name" required>
                </div>
                
                <div class="form-group">
                    <label for="username" class="form-label required">Username</label>
                    <input type="text" id="username" class="form-control" placeholder="Choose a username" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" id="email" class="form-control" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="affiliation" class="form-label">Affiliation</label>
                    <input type="text" id="affiliation" class="form-control" placeholder="University or Organization">
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label required">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Choose a strong password" required minlength="8">
                    <small class="form-text">Minimum 8 characters</small>
                </div>
                
                <div class="form-group">
                    <label for="confirmPassword" class="form-label required">Confirm Password</label>
                    <input type="password" id="confirmPassword" class="form-control" placeholder="Re-enter your password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    Create Account
                </button>
            </form>
            
            <div class="auth-footer">
                Already have an account? <a href="login.php">Sign in here</a>
            </div>
        </div>
    </div>
    
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    
    <script src="../assets/js/app.js"></script>
    <script>
        // Role selection visual feedback
        document.querySelectorAll('.role-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.role-option').forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
            });
        });
        
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                showAlert('Passwords do not match', 'error');
                return;
            }
            
            const formData = {
                full_name: document.getElementById('fullName').value,
                username: document.getElementById('username').value,
                email: document.getElementById('email').value,
                affiliation: document.getElementById('affiliation').value,
                password: password,
                role: document.querySelector('input[name="role"]:checked')?.value
            };
            
            if (!formData.role) {
                showAlert('Please select a role', 'error');
                return;
            }
            
            showLoading();
            
            try {
                const response = await fetch('../api/auth.php?action=register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Registration successful! Redirecting to login...', 'success');
                    setTimeout(() => {
                        window.location.href = 'login.php';
                    }, 2000);
                } else {
                    showAlert(data.message, 'error');
                }
            } catch (error) {
                showAlert('Registration failed. Please try again.', 'error');
            } finally {
                hideLoading();
            }
        });
    </script>
</body>
</html>
