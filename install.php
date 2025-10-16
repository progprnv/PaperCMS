<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PaperCMS - Installation Checker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
        }
        
        h1 {
            color: #2563eb;
            margin-bottom: 0.5rem;
        }
        
        .subtitle {
            color: #64748b;
            margin-bottom: 2rem;
        }
        
        .check-item {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            border-left: 4px solid #e2e8f0;
            background-color: #f8fafc;
        }
        
        .check-item.success {
            background-color: #d1fae5;
            border-left-color: #10b981;
        }
        
        .check-item.error {
            background-color: #fee2e2;
            border-left-color: #ef4444;
        }
        
        .check-item.warning {
            background-color: #fef3c7;
            border-left-color: #f59e0b;
        }
        
        .check-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .check-message {
            font-size: 0.875rem;
            color: #475569;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 2rem 0 1rem;
            color: #0f172a;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 500;
            margin-top: 1rem;
        }
        
        .btn:hover {
            background-color: #1e40af;
        }
        
        .code {
            background-color: #1e293b;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 0.5rem;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            margin: 1rem 0;
            overflow-x: auto;
        }
        
        .status-icon {
            font-size: 1.25rem;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📄 PaperCMS Installation Checker</h1>
        <p class="subtitle">Verify your system meets all requirements</p>
        
        <div class="section-title">PHP Requirements</div>
        
        <?php
        // PHP Version Check
        $php_version = phpversion();
        $php_ok = version_compare($php_version, '7.4.0', '>=');
        ?>
        <div class="check-item <?php echo $php_ok ? 'success' : 'error'; ?>">
            <div class="check-title">
                <span class="status-icon"><?php echo $php_ok ? '✅' : '❌'; ?></span>
                PHP Version
            </div>
            <div class="check-message">
                Current: <?php echo $php_version; ?> | Required: 7.4.0 or higher
                <?php if (!$php_ok): ?>
                <br><strong>Action:</strong> Please upgrade PHP to version 7.4 or higher
                <?php endif; ?>
            </div>
        </div>
        
        <?php
        // PDO MySQL Extension
        $pdo_mysql = extension_loaded('pdo_mysql');
        ?>
        <div class="check-item <?php echo $pdo_mysql ? 'success' : 'error'; ?>">
            <div class="check-title">
                <span class="status-icon"><?php echo $pdo_mysql ? '✅' : '❌'; ?></span>
                PDO MySQL Extension
            </div>
            <div class="check-message">
                <?php echo $pdo_mysql ? 'Installed' : 'Not installed'; ?>
                <?php if (!$pdo_mysql): ?>
                <br><strong>Action:</strong> Enable PDO MySQL extension in php.ini
                <?php endif; ?>
            </div>
        </div>
        
        <?php
        // File Upload Settings
        $upload_enabled = ini_get('file_uploads');
        $max_upload = ini_get('upload_max_filesize');
        $max_post = ini_get('post_max_size');
        ?>
        <div class="check-item <?php echo $upload_enabled ? 'success' : 'warning'; ?>">
            <div class="check-title">
                <span class="status-icon"><?php echo $upload_enabled ? '✅' : '⚠️'; ?></span>
                File Upload Settings
            </div>
            <div class="check-message">
                Enabled: <?php echo $upload_enabled ? 'Yes' : 'No'; ?><br>
                Max Upload Size: <?php echo $max_upload; ?><br>
                Max Post Size: <?php echo $max_post; ?>
                <?php if (!$upload_enabled): ?>
                <br><strong>Action:</strong> Enable file uploads in php.ini
                <?php endif; ?>
            </div>
        </div>
        
        <div class="section-title">Database Connection</div>
        
        <?php
        $db_connected = false;
        $db_message = '';
        
        try {
            $dsn = "mysql:host=localhost;charset=utf8mb4";
            $pdo = new PDO($dsn, 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $db_connected = true;
            $db_message = 'Successfully connected to MySQL';
            
            // Check if database exists
            $stmt = $pdo->query("SHOW DATABASES LIKE 'papercms'");
            $db_exists = $stmt->rowCount() > 0;
            
        } catch (PDOException $e) {
            $db_message = 'Connection failed: ' . $e->getMessage();
        }
        ?>
        <div class="check-item <?php echo $db_connected ? 'success' : 'error'; ?>">
            <div class="check-title">
                <span class="status-icon"><?php echo $db_connected ? '✅' : '❌'; ?></span>
                MySQL Connection
            </div>
            <div class="check-message">
                <?php echo $db_message; ?>
                <?php if (!$db_connected): ?>
                <br><strong>Action:</strong> Make sure MySQL is running in XAMPP Control Panel
                <?php endif; ?>
            </div>
        </div>
        
        <?php if ($db_connected): ?>
        <div class="check-item <?php echo $db_exists ? 'success' : 'warning'; ?>">
            <div class="check-title">
                <span class="status-icon"><?php echo $db_exists ? '✅' : '⚠️'; ?></span>
                PaperCMS Database
            </div>
            <div class="check-message">
                <?php if ($db_exists): ?>
                    Database 'papercms' exists
                <?php else: ?>
                    Database 'papercms' not found
                    <br><strong>Action:</strong> Import database/papercms.sql via phpMyAdmin
                    <div class="code">
                        1. Open http://localhost/phpmyadmin<br>
                        2. Click "Import" tab<br>
                        3. Choose file: database/papercms.sql<br>
                        4. Click "Go"
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="section-title">Directory Permissions</div>
        
        <?php
        $uploads_dir = __DIR__ . '/uploads';
        $uploads_writable = is_writable($uploads_dir) || @mkdir($uploads_dir, 0755, true);
        ?>
        <div class="check-item <?php echo $uploads_writable ? 'success' : 'error'; ?>">
            <div class="check-title">
                <span class="status-icon"><?php echo $uploads_writable ? '✅' : '❌'; ?></span>
                Uploads Directory
            </div>
            <div class="check-message">
                Path: <?php echo $uploads_dir; ?><br>
                Status: <?php echo $uploads_writable ? 'Writable' : 'Not writable'; ?>
                <?php if (!$uploads_writable): ?>
                <br><strong>Action:</strong> Grant write permissions to uploads/ folder
                <?php endif; ?>
            </div>
        </div>
        
        <div class="section-title">Installation Status</div>
        
        <?php
        $all_ok = $php_ok && $pdo_mysql && $upload_enabled && $db_connected && ($db_exists ?? false) && $uploads_writable;
        ?>
        
        <?php if ($all_ok): ?>
            <div class="check-item success">
                <div class="check-title">
                    <span class="status-icon">🎉</span>
                    All checks passed!
                </div>
                <div class="check-message">
                    Your system is ready to run PaperCMS.
                </div>
            </div>
            <a href="index.php" class="btn">Launch PaperCMS →</a>
        <?php else: ?>
            <div class="check-item error">
                <div class="check-title">
                    <span class="status-icon">⚠️</span>
                    Installation incomplete
                </div>
                <div class="check-message">
                    Please fix the issues above before proceeding.
                </div>
            </div>
        <?php endif; ?>
        
        <div class="section-title">Quick Links</div>
        <div style="margin-top: 1rem;">
            <a href="http://localhost/phpmyadmin" target="_blank" style="color: #2563eb; margin-right: 1rem;">📊 phpMyAdmin</a>
            <a href="README.md" style="color: #2563eb; margin-right: 1rem;">📖 Documentation</a>
            <a href="SETUP.md" style="color: #2563eb;">🚀 Setup Guide</a>
        </div>
    </div>
</body>
</html>
