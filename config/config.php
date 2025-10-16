<?php
/**
 * Global Configuration for PaperCMS
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Application Settings
define('APP_NAME', 'PaperCMS');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/PaperCMS');

// File Upload Settings
define('UPLOAD_DIR', __DIR__ . '/../uploads/papers/');
define('MAX_FILE_SIZE', 10485760); // 10MB in bytes
define('ALLOWED_EXTENSIONS', ['pdf']);

// Security Settings
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds
define('PASSWORD_MIN_LENGTH', 8);

// Pagination
define('ITEMS_PER_PAGE', 10);

// Timezone
date_default_timezone_set('UTC');

// Include database configuration
require_once __DIR__ . '/database.php';

// Auto-create upload directories if they don't exist
$directories = [
    __DIR__ . '/../uploads',
    __DIR__ . '/../uploads/papers',
    __DIR__ . '/../uploads/temp'
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Helper Functions
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function is_logged_in() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

function check_session_timeout() {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
        session_unset();
        session_destroy();
        return false;
    }
    $_SESSION['last_activity'] = time();
    return true;
}

function require_login() {
    if (!is_logged_in() || !check_session_timeout()) {
        header('Location: ' . BASE_URL . '/auth/login.php');
        exit();
    }
}

function require_role($allowed_roles) {
    require_login();
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        header('Location: ' . BASE_URL . '/index.php?error=unauthorized');
        exit();
    }
}

function get_user_id() {
    return $_SESSION['user_id'] ?? null;
}

function get_user_role() {
    return $_SESSION['role'] ?? null;
}

function log_activity($user_id, $action, $entity_type = null, $entity_id = null, $details = null) {
    try {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO activity_log (user_id, action, entity_type, entity_id, details, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $user_id,
            $action,
            $entity_type,
            $entity_id,
            $details,
            $_SERVER['REMOTE_ADDR'] ?? null
        ]);
    } catch (Exception $e) {
        error_log("Failed to log activity: " . $e->getMessage());
    }
}

function format_file_size($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

function get_status_badge_class($status) {
    switch ($status) {
        case 'published':
            return 'status-published';
        case 'in_process':
            return 'status-inprocess';
        case 'rejected':
            return 'status-rejected';
        default:
            return 'status-pending';
    }
}

function get_status_display($status) {
    switch ($status) {
        case 'in_process':
            return 'In Process';
        case 'published':
            return 'Published';
        case 'rejected':
            return 'Rejected';
        default:
            return 'Pending';
    }
}
?>
