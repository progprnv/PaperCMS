// Global JavaScript Functions for PaperCMS

// Show loading overlay
function showLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.classList.add('show');
    }
}

// Hide loading overlay
function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.classList.remove('show');
    }
}

// Show alert message
function showAlert(message, type = 'info') {
    const container = document.getElementById('alertContainer');
    if (!container) return;
    
    const alertClass = `alert-${type === 'error' ? 'error' : type}`;
    const icons = {
        success: '✓',
        error: '✕',
        warning: '⚠',
        info: 'ℹ'
    };
    
    const alert = document.createElement('div');
    alert.className = `alert ${alertClass}`;
    alert.innerHTML = `
        <span style="font-size: 1.25rem;">${icons[type] || icons.info}</span>
        <span>${message}</span>
    `;
    
    container.innerHTML = '';
    container.appendChild(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// Format date
function formatDate(dateString) {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Format file size
function formatFileSize(bytes) {
    if (!bytes) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
}

// Get status badge HTML
function getStatusBadge(status) {
    const statusMap = {
        pending: { class: 'status-pending', text: 'Pending' },
        in_process: { class: 'status-inprocess', text: 'In Process' },
        published: { class: 'status-published', text: 'Published' },
        rejected: { class: 'status-rejected', text: 'Rejected' }
    };
    
    const statusInfo = statusMap[status] || statusMap.pending;
    return `<span class="badge ${statusInfo.class}">${statusInfo.text}</span>`;
}

// Modal functions
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
    }
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
    }
}

// Close modal on overlay click
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('show');
    }
});

// Logout function
async function logout() {
    if (!confirm('Are you sure you want to logout?')) return;
    
    try {
        const response = await fetch('../api/auth.php?action=logout');
        const data = await response.json();
        
        if (data.success) {
            window.location.href = '../auth/login.php';
        }
    } catch (error) {
        console.error('Logout failed:', error);
        window.location.href = '../auth/login.php';
    }
}

// Check session on page load
async function checkSession() {
    try {
        const response = await fetch('../api/auth.php?action=check');
        const data = await response.json();
        
        if (!data.logged_in) {
            window.location.href = '../auth/login.php';
        }
    } catch (error) {
        console.error('Session check failed:', error);
    }
}

// User dropdown toggle
document.addEventListener('DOMContentLoaded', () => {
    const userAvatar = document.querySelector('.user-avatar');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    
    if (userAvatar && dropdownMenu) {
        userAvatar.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });
        
        document.addEventListener('click', () => {
            dropdownMenu.classList.remove('show');
        });
    }
});

// File upload with drag and drop
function initFileUpload(uploadAreaId, fileInputId, previewId) {
    const uploadArea = document.getElementById(uploadAreaId);
    const fileInput = document.getElementById(fileInputId);
    const preview = document.getElementById(previewId);
    
    if (!uploadArea || !fileInput) return;
    
    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });
    
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            updateFilePreview(fileInput, preview);
        }
    });
    
    fileInput.addEventListener('change', () => {
        updateFilePreview(fileInput, preview);
    });
}

function updateFilePreview(fileInput, preview) {
    if (!fileInput.files.length || !preview) return;
    
    const file = fileInput.files[0];
    preview.innerHTML = `
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <strong>📄 ${file.name}</strong><br>
                <small>${formatFileSize(file.size)}</small>
            </div>
            <button type="button" class="btn btn-sm btn-danger" onclick="clearFileUpload('${fileInput.id}', '${preview.id}')">
                Remove
            </button>
        </div>
    `;
    preview.classList.add('show');
}

function clearFileUpload(fileInputId, previewId) {
    const fileInput = document.getElementById(fileInputId);
    const preview = document.getElementById(previewId);
    
    if (fileInput) {
        fileInput.value = '';
    }
    
    if (preview) {
        preview.innerHTML = '';
        preview.classList.remove('show');
    }
}

// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Confirm dialog
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Copy to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showAlert('Copied to clipboard!', 'success');
    }).catch(() => {
        showAlert('Failed to copy', 'error');
    });
}

// Export functions globally
window.showLoading = showLoading;
window.hideLoading = hideLoading;
window.showAlert = showAlert;
window.formatDate = formatDate;
window.formatFileSize = formatFileSize;
window.getStatusBadge = getStatusBadge;
window.showModal = showModal;
window.hideModal = hideModal;
window.logout = logout;
window.checkSession = checkSession;
window.initFileUpload = initFileUpload;
window.clearFileUpload = clearFileUpload;
window.debounce = debounce;
window.confirmAction = confirmAction;
window.copyToClipboard = copyToClipboard;
