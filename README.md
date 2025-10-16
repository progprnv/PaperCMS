# 📄 PaperCMS - Research Paper Repository System

<div align="center">

![PaperCMS Banner](https://img.shields.io/badge/PaperCMS-v1.0.0-blue?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**A professional web-based research paper repository system with role-based access control**

[Features](#-features) • [Installation](#-installation) • [Usage](#-usage) • [Documentation](#-documentation) • [Demo](#-demo-accounts)

</div>

---

## 📖 About PaperCMS

**PaperCMS** is a complete, production-ready research paper management system designed for academic institutions, research organizations, and educational platforms. It provides a streamlined workflow for authors to submit their research papers and reviewers to evaluate and publish them.

### 🎯 Key Highlights

- **Role-Based Access**: Separate interfaces for Authors and Reviewers
- **Secure & Robust**: Built with security best practices
- **Professional UI/UX**: Modern, responsive design
- **Easy Setup**: Get started in 5 minutes with XAMPP
- **Well Documented**: Comprehensive guides and documentation
- **Production Ready**: Can be deployed immediately after setup

### 🎓 Perfect For

- 📚 Academic Institutions
- 🔬 Research Organizations
- 🏫 University Departments
- 📝 Conference Paper Management
- 🎓 Student Project Submissions

---

## ✨ Features

### 👨‍💼 Author Features
- 📝 Submit research papers with PDF upload (max 10MB)
- 📊 Personal dashboard with submission statistics
- 👀 View all submissions with real-time status updates
- 💬 Track reviews and detailed feedback from reviewers
- 🗑️ Delete pending submissions before review
- 📈 Monitor paper downloads and engagement
- 🔍 Filter papers by status (Pending, In Process, Published, Rejected)
- 📄 View detailed paper information with review history

### 👨‍🏫 Reviewer Features
- 📋 View all submitted papers across all authors
- ✅ Review and approve papers with detailed interface
- 🔄 Update paper status (Pending → In Process → Published/Rejected)
- 💭 Provide comprehensive feedback and comments to authors
- 📥 Download papers for thorough review
- 📊 Comprehensive dashboard with review statistics
- 🔍 Filter and search papers by various criteria
- ⚡ Quick publish/reject actions for efficient workflow
- 📧 View author information and contact details

### 🔒 Security & Access Control
- 🔐 Secure authentication system with bcrypt password hashing
- 👥 Role-based access control (Author/Reviewer/Admin)
- 🛡️ Session management with configurable timeout (default: 1 hour)
- 📝 Complete activity logging for audit trails
- ✔️ Input validation and sanitization (XSS protection)
- 🚫 SQL injection prevention using PDO prepared statements
- 📁 Secure file upload with validation
- 🔑 Password strength requirements

---

## 🛠️ Tech Stack

<table>
<tr>
<td align="center"><b>Frontend</b></td>
<td align="center"><b>Backend</b></td>
<td align="center"><b>Database</b></td>
<td align="center"><b>Server</b></td>
</tr>
<tr>
<td>HTML5<br>CSS3<br>JavaScript (Vanilla)</td>
<td>PHP 7.4+<br>PDO<br>Sessions</td>
<td>MySQL 5.7+<br>InnoDB Engine<br>UTF8MB4</td>
<td>Apache<br>XAMPP<br>mod_rewrite</td>
</tr>
</table>

---

## 📋 Prerequisites

Before installing PaperCMS, ensure you have:

- ✅ **XAMPP** (Apache + MySQL + PHP) - [Download from here](https://www.apachefriends.org/)
- ✅ **Web Browser** (Chrome, Firefox, Edge, Safari)
- ✅ **Basic knowledge** of localhost and XAMPP
- ✅ **10 MB free space** for installation

### System Requirements

| Component | Minimum | Recommended |
|-----------|---------|-------------|
| **PHP** | 7.4.0 | 8.0+ |
| **MySQL** | 5.7 | 8.0+ |
| **RAM** | 512 MB | 1 GB+ |
| **Storage** | 10 MB | 50 MB+ |

---

## 🚀 Installation Guide

### Quick Installation (5 Minutes)

Follow these simple steps to get PaperCMS running:

```
┌─────────────────────────────────────────────────┐
│  Step 1: Install XAMPP                          │
│  Step 2: Copy Project Files                     │
│  Step 3: Import Database                        │
│  Step 4: Access Application                     │
│  Step 5: Login & Start Using                    │
└─────────────────────────────────────────────────┘
```

---

### 📦 Step 1: Install XAMPP

#### Download XAMPP
1. Go to: **https://www.apachefriends.org/**
2. Download the latest version for Windows
3. Run the installer (`xampp-windows-x64-installer.exe`)

#### Install XAMPP
```
Installation Path: C:\xampp
Components to Install:
  ✓ Apache
  ✓ MySQL
  ✓ PHP
  ✓ phpMyAdmin
```

#### Start Services
1. Open **XAMPP Control Panel** (from Start Menu or Desktop)
2. Click **"Start"** button next to **Apache**
3. Click **"Start"** button next to **MySQL**
4. Both should show **green "Running"** status

```
╔═══════════════════════════════════════════╗
║  XAMPP Control Panel v3.3.0               ║
╠═══════════════════════════════════════════╣
║  Module    │  Status   │  Actions         ║
╟───────────────────────────────────────────╢
║  Apache    │  Running  │  [Stop] [Admin]  ║ ← Should be GREEN
║  MySQL     │  Running  │  [Stop] [Admin]  ║ ← Should be GREEN
╚═══════════════════════════════════════════╝
```

---

### 📁 Step 2: Setup Project Files

#### Copy Project to XAMPP Directory

**Option A: Move from Desktop to htdocs (Recommended)**

```bash
# From:
C:\Users\kannapi64x\Desktop\Git projects\PaperCMS

# To:
C:\xampp\htdocs\PaperCMS
```

**Manual Steps:**
1. Open File Explorer
2. Navigate to: `C:\Users\kannapi64x\Desktop\Git projects\`
3. **Copy** the entire `PaperCMS` folder
4. Navigate to: `C:\xampp\htdocs\`
5. **Paste** the folder here
6. Final path should be: `C:\xampp\htdocs\PaperCMS\`

**Verify File Structure:**
```
C:\xampp\htdocs\PaperCMS\
├── 📁 api/
├── 📁 assets/
├── 📁 auth/
├── 📁 author/
├── 📁 config/
├── 📁 database/
├── 📁 reviewer/
├── 📁 uploads/
├── 📄 index.php
├── 📄 install.php
└── 📄 README.md
```

---

### 🗄️ Step 3: Create Database

#### Method 1: Using phpMyAdmin Import (Recommended)

1. **Open phpMyAdmin**
   ```
   URL: http://localhost/phpmyadmin
   ```

2. **Import Database File**
   - Click on **"Import"** tab at the top
   - Click **"Choose File"** button
   - Navigate to: `C:\xampp\htdocs\PaperCMS\database\papercms.sql`
   - Select the file
   - Scroll to bottom
   - Click **"Go"** button
   - Wait for success message: ✅ **"Import has been successfully finished"**

3. **Verify Database**
   - Click **"Databases"** tab
   - You should see **"papercms"** in the list
   - Click on **"papercms"**
   - You should see **5 tables**:
     - `users`
     - `papers`
     - `reviews`
     - `activity_log`
     - `paper_comments`

#### Method 2: Using SQL Query

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click **"New"** in the left sidebar
3. Database name: `papercms`
4. Collation: `utf8mb4_general_ci`
5. Click **"Create"**
6. Click on the newly created database
7. Go to **"SQL"** tab
8. Open `database/papercms.sql` in a text editor
9. Copy the entire content
10. Paste in the SQL query box
11. Click **"Go"**

#### Database Structure

```
┌─────────────────────────────────────────────┐
│  Database: papercms                         │
├─────────────────────────────────────────────┤
│                                             │
│  📊 users (4 rows)                          │
│     ├─ user_id, username, email            │
│     ├─ password, full_name, role           │
│     └─ affiliation, created_at             │
│                                             │
│  📄 papers (0 rows initially)              │
│     ├─ paper_id, author_id, title          │
│     ├─ abstract, keywords, pdf_filename    │
│     └─ status, submission_date             │
│                                             │
│  ✍️ reviews (0 rows initially)             │
│     ├─ review_id, paper_id, reviewer_id    │
│     ├─ status, comments                    │
│     └─ review_date                         │
│                                             │
│  📝 activity_log (0 rows initially)        │
│     └─ Tracks all user actions             │
│                                             │
│  💬 paper_comments (0 rows initially)      │
│     └─ Comments on papers                  │
│                                             │
└─────────────────────────────────────────────┘
```

---

### 🔧 Step 4: Configuration (Optional)

The default configuration works perfectly with standard XAMPP installation.

**Default Settings:**
```
Database Host:     localhost
Database Name:     papercms
Database User:     root
Database Password: (empty)
Port:              3306
```

**Only modify if you have custom XAMPP settings!**

**File Location:** `config/database.php`

```php
<?php
class Database {
    private $host = "localhost";      // ← Change if using custom host
    private $db_name = "papercms";    // ← Change if different database name
    private $username = "root";        // ← Change if custom MySQL user
    private $password = "";            // ← Add if MySQL has password
    private $conn;
    // ...
}
```

**Configuration Checklist:**
- ✅ Using default XAMPP? → No changes needed!
- ⚠️ Custom MySQL password? → Update `$password`
- ⚠️ Different database name? → Update `$db_name`
- ⚠️ Remote database? → Update `$host`

---

### 🎯 Step 5: Access the Application

#### First-Time Setup Verification

1. **Run Installation Checker** (Optional but recommended)
   ```
   URL: http://localhost/PaperCMS/install.php
   ```
   
   This will verify:
   - ✅ PHP version
   - ✅ Required PHP extensions
   - ✅ Database connection
   - ✅ File permissions
   - ✅ Directory structure

2. **Access Main Application**
   ```
   URL: http://localhost/PaperCMS/
   ```
   
   Or directly to login:
   ```
   URL: http://localhost/PaperCMS/auth/login.php
   ```

---

### 👤 Default Login Credentials

The system comes with **4 pre-configured demo accounts** for testing:

#### 🔐 Administrator Account
```
Username: admin
Password: admin123
Role:     Admin (Full System Access)

Features:
  ✓ Access all papers
  ✓ Review all submissions
  ✓ Manage users
  ✓ View all activity logs
```

#### ✍️ Author Account #1
```
Username: author1
Password: password123
Role:     Author

Features:
  ✓ Submit papers
  ✓ Upload PDF files
  ✓ Track submission status
  ✓ View reviews
```

#### 👨‍💼 Author Account #2
```
Username: johndoe
Password: password123
Role:     Author
```

#### 🔍 Reviewer Account
```
Username: reviewer1
Password: password123
Role:     Reviewer

Features:
  ✓ Review papers
  ✓ Accept/Reject submissions
  ✓ Update paper status
  ✓ Download papers
  ✓ Add review comments
```

---

### 🔒 Security Notice

**⚠️ CRITICAL: Change Default Passwords Immediately!**

For production use or public deployment:

1. **Change all default passwords**
   - Login with each account
   - Go to profile settings
   - Update to strong passwords

2. **Create new admin account**
   - Login as admin
   - Create new admin with secure credentials
   - Delete default admin account

3. **Security Best Practices:**
   ```
   ✓ Use passwords with 12+ characters
   ✓ Include uppercase, lowercase, numbers, symbols
   ✓ Never reuse passwords across accounts
   ✓ Enable HTTPS if hosting publicly
   ✓ Regular database backups
   ```

4. **For Production Deployment:**
   ```php
   // config/config.php - Update these settings:
   define('ENVIRONMENT', 'production');
   ini_set('display_errors', 0);
   error_reporting(0);
   ```

---

## � Project Structure

Complete file organization of PaperCMS:

```
C:\xampp\htdocs\PaperCMS\
│
├── 📁 api/                          # Backend API Endpoints
│   ├── 📄 auth.php                  # Authentication (login, register, logout)
│   ├── 📄 author.php                # Author operations (submit, list, delete)
│   └── 📄 reviewer.php              # Reviewer operations (review, update status)
│
├── 📁 assets/                       # Static Resources
│   ├── 📁 css/
│   │   └── 📄 style.css            # Main stylesheet (~4500 lines)
│   ├── 📁 js/
│   │   └── 📄 app.js               # JavaScript utilities
│   └── 📁 images/
│       └── (Your images here)
│
├── 📁 auth/                         # Authentication Pages
│   ├── 📄 login.php                 # Login page with role-based redirect
│   └── 📄 register.php              # Registration with role selection
│
├── 📁 author/                       # Author Portal
│   ├── 📄 dashboard.php             # Author dashboard with statistics
│   ├── 📄 submit.php                # Paper submission form (PDF upload)
│   ├── 📄 my-papers.php             # List all author's papers
│   └── 📄 view-paper.php            # View paper details and reviews
│
├── 📁 config/                       # Configuration Files
│   ├── 📄 config.php                # Main config (security, helpers)
│   └── 📄 database.php              # Database connection (PDO)
│
├── 📁 database/                     # Database Files
│   └── 📄 papercms.sql              # Complete database schema + sample data
│
├── 📁 reviewer/                     # Reviewer Portal
│   ├── 📄 dashboard.php             # Reviewer dashboard with stats
│   ├── 📄 papers.php                # List all papers with filters
│   └── 📄 review.php                # Review interface (accept/reject/comment)
│
├── 📁 uploads/                      # File Storage (Auto-created)
│   └── 📄 papers/                   # Uploaded PDF files
│       └── (Generated filename format: paperID_timestamp_random.pdf)
│
├── 📁 docs/                         # Documentation (Optional)
│   ├── 📄 SETUP.md                  # Quick setup guide
│   ├── 📄 ARCHITECTURE.md           # System architecture
│   ├── 📄 PROJECT_SUMMARY.md        # Complete project overview
│   ├── 📄 VISUAL_GUIDE.md           # UI/UX guide
│   └── 📄 CHANGELOG.md              # Version history
│
├── 📄 index.php                     # Entry point (role-based redirect)
├── 📄 install.php                   # Installation checker/verifier
├── 📄 .htaccess                     # Apache configuration
├── 📄 .gitignore                    # Git ignore rules
├── 📄 LICENSE                       # MIT License
├── 📄 README.md                     # This file
└── 📄 readme.txt                    # Quick reference

```

### Key Files Explained

| File Path | Purpose | Dependencies |
|-----------|---------|--------------|
| `index.php` | Entry point, redirects based on login status | config.php |
| `config/config.php` | Core configuration, helper functions | database.php |
| `config/database.php` | PDO database connection singleton | None |
| `api/auth.php` | Authentication API (JSON responses) | config.php |
| `api/author.php` | Author operations API | config.php, auth check |
| `api/reviewer.php` | Reviewer operations API | config.php, role check |
| `assets/css/style.css` | Complete styling for all pages | None |
| `assets/js/app.js` | Shared JavaScript utilities | None |
| `database/papercms.sql` | Database schema + demo data | MySQL 5.7+ |

---

## ⚙️ Advanced Configuration

### File Upload Settings

**Location:** `config/config.php`

```php
// Maximum file size for PDF uploads
define('MAX_FILE_SIZE', 10485760);  // 10MB in bytes (10 × 1024 × 1024)

// Allowed file extensions
define('ALLOWED_EXTENSIONS', ['pdf']);  // Only PDF files allowed

// Upload directory
define('UPLOAD_DIR', __DIR__ . '/../uploads/papers/');
```

**To change max upload size:**
```php
// For 20MB limit:
define('MAX_FILE_SIZE', 20971520);

// For 50MB limit:
define('MAX_FILE_SIZE', 52428800);
```

**Note:** Also update `php.ini` for larger files:
```ini
; File: C:\xampp\php\php.ini
upload_max_filesize = 20M
post_max_size = 25M
max_execution_time = 300
```

### Session Timeout

**Location:** `config/config.php`

```php
// Session timeout in seconds
define('SESSION_TIMEOUT', 3600);  // 1 hour (60 × 60)

// For different timeouts:
define('SESSION_TIMEOUT', 1800);   // 30 minutes
define('SESSION_TIMEOUT', 7200);   // 2 hours
define('SESSION_TIMEOUT', 86400);  // 24 hours
```

### Error Reporting

**Development Mode:**
```php
// config/config.php
define('ENVIRONMENT', 'development');
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

**Production Mode:**
```php
// config/config.php
define('ENVIRONMENT', 'production');
ini_set('display_errors', 0);
error_reporting(0);
// Errors logged to file instead
```

---

## 📖 Usage Guide

### 🎓 For Authors

#### Step 1: Register/Login

**New User Registration:**
```
1. Navigate to: http://localhost/PaperCMS/
2. Click "Register" button
3. Fill in registration form:
   - Username (unique)
   - Email address
   - Password (min 8 characters)
   - Full name
   - Affiliation/Institution
   - Select "Author" role ← Important!
4. Click "Register"
5. Login with your credentials
```

**Using Demo Account:**
```
Username: author1
Password: password123
```

#### Step 2: Access Author Dashboard

```
URL: http://localhost/PaperCMS/author/dashboard.php
```

**Dashboard Features:**
- 📊 **Statistics Card**: View total papers, pending reviews, accepted papers
- 📝 **Quick Actions**: Submit new paper, view all papers
- 📋 **Recent Papers**: See your latest submissions

#### Step 3: Submit a Paper

```
Navigation: Dashboard → Submit Paper
URL: http://localhost/PaperCMS/author/submit.php
```

**Submission Process:**
1. **Enter Paper Details:**
   ```
   Title:      Research paper title
   Abstract:   Brief summary (500-1000 words)
   Keywords:   Comma-separated (e.g., "AI, Machine Learning, NLP")
   ```

2. **Upload PDF:**
   ```
   Requirements:
   - File format: PDF only
   - Maximum size: 10 MB
   - Drag & drop or click to browse
   ```

3. **Submit for Review:**
   - Click "Submit Paper"
   - Confirmation message appears
   - Paper status: "Pending Review"

**Paper Submission Flow:**
```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│  Fill Form   │ ──> │  Upload PDF  │ ──> │   Submit     │
│  (Required)  │     │  (Max 10MB)  │     │ (Pending)    │
└──────────────┘     └──────────────┘     └──────────────┘
```

#### Step 4: Track Your Submissions

```
Navigation: Dashboard → My Papers
URL: http://localhost/PaperCMS/author/my-papers.php
```

**Features:**
- 🔍 **Search**: Find papers by title or keywords
- 🎯 **Filter by Status**:
  - All Papers
  - Pending Review
  - Under Review
  - Accepted
  - Rejected
- 👁️ **View Details**: See paper info and review comments
- 🗑️ **Delete**: Remove pending papers (before review)

**Paper Status Meanings:**
| Status | Color | Description |
|--------|-------|-------------|
| Pending | 🟡 Yellow | Waiting for reviewer assignment |
| Under Review | 🔵 Blue | Reviewer is evaluating |
| Accepted | 🟢 Green | Paper approved for publication |
| Rejected | 🔴 Red | Paper not accepted (see comments) |

#### Step 5: View Paper Details & Reviews

```
Click "View" button on any paper
URL: http://localhost/PaperCMS/author/view-paper.php?id=X
```

**Details Page Shows:**
- 📄 Complete paper information
- 📥 Download PDF link
- 💬 Reviewer comments (if reviewed)
- ⏰ Submission and review dates
- 📊 Current status

---

### 🔍 For Reviewers

#### Step 1: Login

**Using Demo Account:**
```
Username: reviewer1
Password: password123
URL: http://localhost/PaperCMS/auth/login.php
```

#### Step 2: Access Reviewer Dashboard

```
URL: http://localhost/PaperCMS/reviewer/dashboard.php
```

**Dashboard Shows:**
- 📊 **Statistics**: Total papers, pending reviews, accepted/rejected counts
- 📋 **Recent Papers**: Latest submissions to review
- 🎯 **Quick Actions**: View all papers, start reviewing

#### Step 3: View All Papers

```
Navigation: Dashboard → All Papers
URL: http://localhost/PaperCMS/reviewer/papers.php
```

**Features:**
- 🔍 **Search Papers**: By title, author, or keywords
- 🎯 **Filter by Status**:
  - All Papers
  - Pending Review
  - Under Review
  - Accepted
  - Rejected
- 👁️ **View Details**: Click to review
- 📥 **Download PDF**: Get paper file

**Paper List View:**
```
╔═══════════════════════════════════════════════════════════╗
║  Title         │  Author      │  Date      │  Status     ║
╟───────────────────────────────────────────────────────────╢
║  Paper Title   │  John Doe    │  Jan 15    │  Pending    ║ [Review]
║  Another Paper │  Jane Smith  │  Jan 14    │  Reviewed   ║ [View]
╚═══════════════════════════════════════════════════════════╝
```

#### Step 4: Review a Paper

```
Click "Review" button on any paper
URL: http://localhost/PaperCMS/reviewer/review.php?id=X
```

**Review Interface:**

1. **Read Paper Details**
   ```
   - Title and abstract
   - Keywords
   - Author information
   - Submission date
   ```

2. **Download PDF**
   ```
   Click "Download PDF" button
   Read the full paper
   Make your evaluation
   ```

3. **Update Paper Status**
   ```
   Select one:
   ○ Pending Review   (Initial state)
   ○ Under Review     (Currently reviewing)
   ○ Accepted         (Approve paper)
   ○ Rejected         (Decline paper)
   ```

4. **Add Review Comments**
   ```
   Required fields:
   - Detailed feedback
   - Strengths of the paper
   - Areas for improvement
   - Recommendation justification
   
   Best practices:
   ✓ Be specific and constructive
   ✓ Provide actionable feedback
   ✓ Cite specific sections if needed
   ✓ Remain professional and respectful
   ```

5. **Submit Review**
   ```
   Click "Submit Review" button
   Confirmation message appears
   Author can now see your feedback
   ```

**Review Workflow:**
```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│   Select    │ ──> │  Download   │ ──> │  Evaluate   │ ──> │   Submit    │
│   Paper     │     │     PDF     │     │  & Comment  │     │   Review    │
└─────────────┘     └─────────────┘     └─────────────┘     └─────────────┘
```

---

### 🔐 For Administrators

Admin accounts have **full access** to both author and reviewer features:

```
Username: admin
Password: admin123
```

**Admin Capabilities:**
- ✅ Submit papers (as author)
- ✅ Review papers (as reviewer)
- ✅ View all users' papers
- ✅ Access activity logs
- ✅ Manage system settings

---
   - View pending papers from dashboard
   - Click "Review" on any paper
   - Download and read the PDF
   - Provide feedback and update status

3. **Manage Papers**
   - Filter papers by status
   - Quick publish/reject options
   - Track review history

## 🗄️ Database Schema

### Tables

- **users** - User accounts (authors, reviewers, admins)
- **papers** - Research paper submissions
- **reviews** - Paper reviews and status changes
- **activity_log** - System activity tracking
- **paper_comments** - Comments and feedback

## 🔒 Security Features

---

## 🎨 System Architecture

### Application Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                         USER ACCESS                             │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │   index.php          │
              │   (Entry Point)      │
              └──────────┬───────────┘
                         │
         ┌───────────────┴───────────────┐
         │                               │
         ▼                               ▼
┌─────────────────┐            ┌─────────────────┐
│  Not Logged In  │            │   Logged In     │
└────────┬────────┘            └────────┬────────┘
         │                              │
         ▼                              │
┌─────────────────┐            ┌────────┴────────────────┐
│  Login/Register │            │   Check User Role       │
│  auth/login.php │            └──┬──────────────┬───────┘
└─────────────────┘               │              │
                                  ▼              ▼
                        ┌──────────────┐  ┌──────────────┐
                        │   AUTHOR     │  │   REVIEWER   │
                        │   Portal     │  │   Portal     │
                        └──────┬───────┘  └──────┬───────┘
                               │                 │
                ┌──────────────┼─────────┐      │
                ▼              ▼         ▼       ▼
         ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐
         │Dashboard │  │ Submit   │  │Dashboard │  │  Review  │
         └──────────┘  │  Paper   │  └──────────┘  │  Papers  │
                       └──────────┘                └──────────┘
```

### Database Schema Relationships

```
┌─────────────────┐
│     USERS       │
│─────────────────│
│ user_id (PK)    │◄──┐
│ username        │   │
│ email           │   │
│ password        │   │
│ role            │   │
└─────────────────┘   │
                      │
        ┌─────────────┼─────────────┐
        │             │             │
        ▼             │             ▼
┌─────────────────┐   │     ┌─────────────────┐
│     PAPERS      │   │     │    REVIEWS      │
│─────────────────│   │     │─────────────────│
│ paper_id (PK)   │   │     │ review_id (PK)  │
│ author_id (FK)  │───┘     │ paper_id (FK)   │──┐
│ title           │         │ reviewer_id(FK) │──┼──┐
│ abstract        │         │ status          │  │  │
│ pdf_filename    │         │ comments        │  │  │
│ status          │◄────────│ review_date     │  │  │
└─────────────────┘         └─────────────────┘  │  │
        │                                         │  │
        │                ┌────────────────────────┘  │
        │                │        ┌──────────────────┘
        ▼                ▼        ▼
┌──────────────────────────────────┐
│       ACTIVITY_LOG               │
│──────────────────────────────────│
│ log_id (PK)                      │
│ user_id (FK)                     │
│ action                           │
│ details                          │
│ timestamp                        │
└──────────────────────────────────┘
```

### API Structure

```
api/
├── auth.php          → Authentication operations
│   ├── POST /login       (username, password)
│   ├── POST /register    (user details, role)
│   ├── POST /logout      (session destroy)
│   └── GET  /check       (session validation)
│
├── author.php        → Author operations
│   ├── POST /submitPaper     (title, abstract, pdf)
│   ├── GET  /listMyPapers    (author's papers)
│   ├── GET  /getPaperDetails (paper_id)
│   ├── DELETE /deletePaper   (paper_id)
│   └── GET  /getAuthorStats  (statistics)
│
└── reviewer.php      → Reviewer operations
    ├── GET  /listPapers      (all papers, with filters)
    ├── GET  /getPaperDetails (paper_id)
    ├── POST /submitReview    (paper_id, status, comments)
    ├── POST /updateStatus    (paper_id, status)
    ├── GET  /downloadPaper   (paper_id)
    └── GET  /getReviewerStats(statistics)
```

---

## 🐛 Troubleshooting

### Common Issues and Solutions

#### ❌ Problem: Database Connection Error

**Error Message:**
```
SQLSTATE[HY000] [1049] Unknown database 'papercms'
Could not connect to database
```

**Solutions:**
1. **Check XAMPP Services**
   ```
   Open XAMPP Control Panel
   Ensure MySQL shows "Running" (green)
   If not, click "Start" button
   ```

2. **Verify Database Exists**
   ```
   1. Open: http://localhost/phpmyadmin
   2. Look for "papercms" in left sidebar
   3. If missing, import database/papercms.sql
   ```

3. **Check Database Credentials**
   ```php
   // File: config/database.php
   private $host = "localhost";    ← Should be localhost
   private $db_name = "papercms";  ← Check spelling
   private $username = "root";     ← Default XAMPP user
   private $password = "";         ← Usually empty for XAMPP
   ```

4. **Test Connection**
   ```
   Visit: http://localhost/PaperCMS/install.php
   This will verify database connectivity
   ```

---

#### ❌ Problem: File Upload Not Working

**Error Message:**
```
Failed to upload file
File too large
Invalid file type
```

**Solutions:**
1. **Check Upload Directory**
   ```
   Path: C:\xampp\htdocs\PaperCMS\uploads\papers\
   
   If folder doesn't exist:
   - Create manually: uploads/papers/
   - Or let application create it automatically
   ```

2. **Verify Permissions (Windows)**
   ```
   Right-click PaperCMS folder
   → Properties
   → Security tab
   → Edit button
   → Select "Users"
   → Check "Full Control"
   → Apply → OK
   ```

3. **Increase Upload Limits**
   ```
   File: C:\xampp\php\php.ini
   
   Find and update these lines:
   upload_max_filesize = 20M      ← From 2M
   post_max_size = 25M            ← From 8M
   max_execution_time = 300       ← From 30
   
   Save file
   Restart Apache in XAMPP
   ```

4. **Check File Type**
   ```
   Only PDF files allowed
   Max size: 10 MB (configurable)
   ```

---

#### ❌ Problem: Session Issues / Auto Logout

**Symptoms:**
```
Randomly logged out
Session timeout too soon
Login doesn't persist
```

**Solutions:**
1. **Clear Browser Data**
   ```
   Chrome/Edge:
   - Press Ctrl + Shift + Delete
   - Select "Cookies and site data"
   - Clear data
   - Try login again
   ```

2. **Check Session Settings**
   ```php
   // File: config/config.php
   define('SESSION_TIMEOUT', 3600); // 1 hour in seconds
   
   // Increase if needed:
   define('SESSION_TIMEOUT', 7200); // 2 hours
   ```

3. **Verify PHP Session Path**
   ```
   File: C:\xampp\php\php.ini
   
   session.save_path = "C:\xampp\tmp"
   
   Make sure this folder exists and is writable
   ```

4. **Restart Apache**
   ```
   XAMPP Control Panel → Stop Apache → Start Apache
   Clear browser cache
   Login again
   ```

---

#### ❌ Problem: Page Not Found (404 Error)

**Error Message:**
```
Object not found!
The requested URL was not found on this server
```

**Solutions:**
1. **Verify Project Location**
   ```
   Correct path: C:\xampp\htdocs\PaperCMS\
   
   Wrong locations:
   ❌ Desktop
   ❌ Documents
   ❌ C:\PaperCMS
   
   Must be in htdocs folder!
   ```

2. **Check Apache Status**
   ```
   XAMPP Control Panel
   → Apache should show "Running" (green)
   → If not, click "Start"
   → Check port 80 is not used by other apps
   ```

3. **Use Correct URL**
   ```
   ✅ Correct: http://localhost/PaperCMS/
   ✅ Correct: http://localhost/PaperCMS/auth/login.php
   
   ❌ Wrong: C:\xampp\htdocs\PaperCMS\index.php
   ❌ Wrong: file:///C:/xampp/htdocs/PaperCMS/
   ❌ Wrong: http://PaperCMS/
   ```

4. **Check .htaccess (if used)**
   ```
   Ensure mod_rewrite is enabled in Apache
   File: C:\xampp\apache\conf\httpd.conf
   
   Find and uncomment:
   LoadModule rewrite_module modules/mod_rewrite.so
   
   Restart Apache
   ```

---

#### ❌ Problem: Login Not Working

**Symptoms:**
```
"Invalid credentials" error
Can't login with demo accounts
Password incorrect
```

**Solutions:**
1. **Use Correct Credentials**
   ```
   Author:
   Username: author1
   Password: password123
   
   Reviewer:
   Username: reviewer1
   Password: password123
   
   Admin:
   Username: admin
   Password: admin123
   ```

2. **Check Database Has Users**
   ```
   1. Open: http://localhost/phpmyadmin
   2. Click "papercms" database
   3. Click "users" table
   4. Should see 4 demo accounts
   5. If empty, re-import database/papercms.sql
   ```

3. **Verify Password Hashing**
   ```
   Passwords in database should look like:
   $2y$10$... (bcrypt hash)
   
   If passwords look like plain text, database import failed
   ```

4. **Clear Form Cache**
   ```
   Browser may have cached old credentials
   - Clear browser cache
   - Use Incognito/Private window
   - Try different browser
   ```

---

#### ❌ Problem: PDF Download Not Working

**Error Message:**
```
File not found
Cannot download PDF
```

**Solutions:**
1. **Check Upload Folder**
   ```
   Path: C:\xampp\htdocs\PaperCMS\uploads\papers\
   
   Verify folder exists and contains PDF files
   ```

2. **Check File Permissions**
   ```
   Folder and files must be readable
   Right-click → Properties → Security
   Ensure "Read" permission is granted
   ```

3. **Verify Database Path**
   ```
   phpMyAdmin → papercms → papers table
   Check "pdf_filename" column
   Should contain: paperID_timestamp_random.pdf
   ```

---

#### ❌ Problem: Blank/White Page

**Symptoms:**
```
Page loads but shows nothing
No error message
```

**Solutions:**
1. **Enable Error Display**
   ```php
   // Add to top of problematic file:
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   ```

2. **Check PHP Errors**
   ```
   File: C:\xampp\apache\logs\error.log
   Open in text editor
   Look for recent errors
   ```

3. **Verify Include Paths**
   ```php
   // Common issue in config files:
   require_once '../config/config.php';  // Check path is correct
   ```

4. **Check Browser Console**
   ```
   Press F12 in browser
   → Console tab
   → Look for JavaScript errors
   ```

---

#### ❌ Problem: CSS/JS Not Loading

**Symptoms:**
```
Page loads but has no styling
Buttons don't work
Looks broken
```

**Solutions:**
1. **Check File Paths**
   ```html
   <!-- In HTML files, verify: -->
   <link rel="stylesheet" href="../assets/css/style.css">
   <script src="../assets/js/app.js"></script>
   
   Path should be relative to current file location
   ```

2. **Verify Files Exist**
   ```
   C:\xampp\htdocs\PaperCMS\assets\css\style.css
   C:\xampp\htdocs\PaperCMS\assets\js\app.js
   
   Both files should exist
   ```

3. **Clear Browser Cache**
   ```
   Hard refresh:
   - Windows: Ctrl + F5
   - Mac: Cmd + Shift + R
   ```

4. **Check Network Tab**
   ```
   Press F12 → Network tab
   Reload page
   Look for red (failed) requests
   Click to see error details
   ```

---

### 🆘 Quick Diagnostic Commands

**Check Apache Status:**
```cmd
netstat -ano | findstr :80
```

**Check MySQL Status:**
```cmd
netstat -ano | findstr :3306
```

**Test PHP:**
```cmd
C:\xampp\php\php.exe -v
```

**Verify Database:**
```cmd
C:\xampp\mysql\bin\mysql.exe -u root -e "SHOW DATABASES;"
```

---

## 🔄 Development Guide

### Adding New Features

#### Creating New API Endpoint

```php
// File: api/new_endpoint.php
<?php
require_once '../config/config.php';
require_once '../config/database.php';

// Check authentication
require_login();

// Get action from request
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'myAction':
        myActionFunction();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function myActionFunction() {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Your logic here
    
    echo json_encode(['success' => true, 'data' => $result]);
}
?>
```

#### Creating New Page

```php
// File: author/new_page.php
<?php
require_once '../config/config.php';
require_author(); // or require_reviewer()
?>
<!DOCTYPE html>
<html>
<head>
    <title>Page Title - PaperCMS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container">
        <!-- Your content here -->
    </div>
    
    <script src="../assets/js/app.js"></script>
</body>
</html>
```

#### Adding Database Tables

```sql
-- Execute in phpMyAdmin
CREATE TABLE new_table (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    column_name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

#### Adding CSS Styles

```css
/* File: assets/css/style.css */
/* Add at the end of file */

.my-new-class {
    /* Your styles */
}
```

#### Adding JavaScript Functions

```javascript
// File: assets/js/app.js
// Add new function

function myNewFunction() {
    // Your code
}

// Export to window object
window.myNewFunction = myNewFunction;
```

---

### Database Modifications

**Workflow:**
1. ✏️ **Make changes** in phpMyAdmin
2. ✅ **Test changes** thoroughly
3. 📥 **Export schema**: Database → Export → Go
4. 📝 **Update** `database/papercms.sql`
5. 📋 **Document** changes in CHANGELOG.md

**Common Modifications:**

**Add New Column:**
```sql
ALTER TABLE papers 
ADD COLUMN publication_date DATE AFTER status;
```

**Add Index for Performance:**
```sql
CREATE INDEX idx_status ON papers(status);
CREATE INDEX idx_author ON papers(author_id);
```

**Modify Column:**
```sql
ALTER TABLE users 
MODIFY COLUMN bio TEXT;
```

---

### Project Structure Best Practices

```
PaperCMS/
│
├── api/                    ← All backend logic (JSON responses)
│   └── *.php              ← No HTML output, only JSON
│
├── auth/                   ← Public pages (login, register)
│   └── *.php              ← No authentication required
│
├── author/                 ← Author-only pages
│   └── *.php              ← Must call require_author()
│
├── reviewer/               ← Reviewer-only pages
│   └── *.php              ← Must call require_reviewer()
│
├── admin/                  ← Admin-only pages (future)
│   └── *.php              ← Must call require_admin()
│
├── assets/
│   ├── css/               ← Shared styles
│   ├── js/                ← Shared JavaScript
│   └── images/            ← Shared images
│
├── config/
│   ├── config.php         ← Add global functions here
│   └── database.php       ← Database connection only
│
└── uploads/
    └── papers/            ← Never commit actual files to Git
```

---

## 📊 Performance Optimization

### Database Optimization

```sql
-- Add indexes for frequently queried columns
CREATE INDEX idx_papers_status ON papers(status);
CREATE INDEX idx_papers_author ON papers(author_id);
CREATE INDEX idx_reviews_paper ON reviews(paper_id);

-- Optimize tables periodically
OPTIMIZE TABLE papers, reviews, users;
```

### PHP Performance

```php
// config/config.php - For production

// Enable OPcache
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000

// Disable development features
display_errors=Off
error_reporting=0
```

### File Upload Optimization

```php
// Compress PDF if needed (requires Ghostscript)
function compressPDF($inputFile, $outputFile) {
    $command = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 " .
               "-dPDFSETTINGS=/ebook -dNOPAUSE -dQUIET -dBATCH " .
               "-sOutputFile=$outputFile $inputFile";
    exec($command);
}
```

---

## 🧪 Testing Guide

### Manual Testing Checklist

**Authentication:**
- [ ] Register new user (all roles)
- [ ] Login with valid credentials
- [ ] Login with invalid credentials
- [ ] Session timeout after inactivity
- [ ] Logout functionality

**Author Features:**
- [ ] Submit new paper with PDF
- [ ] View all papers
- [ ] Filter papers by status
- [ ] Search papers
- [ ] View paper details
- [ ] Delete pending paper
- [ ] Cannot delete reviewed paper

**Reviewer Features:**
- [ ] View all papers
- [ ] Filter by status
- [ ] Download PDF
- [ ] Submit review
- [ ] Update paper status
- [ ] Add comments

**Security:**
- [ ] Author cannot access reviewer pages
- [ ] Reviewer cannot access author submission
- [ ] SQL injection attempts fail
- [ ] XSS attempts are sanitized
- [ ] File upload only accepts PDFs

### Browser Testing

Test in multiple browsers:
- ✅ Chrome
- ✅ Firefox
- ✅ Edge
- ✅ Safari (if available)

### Responsive Testing

Test on different screen sizes:
- 📱 Mobile (320px - 480px)
- 📱 Tablet (481px - 768px)
- 💻 Desktop (769px - 1024px)
- 🖥️ Large Desktop (1025px+)

---

## 📝 License

```
MIT License

Copyright (c) 2025 PaperCMS

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

This project is **open source** and available for:
- ✅ Educational purposes
- ✅ Personal projects
- ✅ Commercial use (with attribution)
- ✅ Modification and distribution

---

## 👨‍💻 Technical Specifications

### Backend

| Technology | Version | Purpose |
|------------|---------|---------|
| **PHP** | 7.4+ | Server-side logic |
| **MySQL** | 5.7+ | Database management |
| **PDO** | Latest | Database abstraction layer |
| **Apache** | 2.4+ | Web server |

**Key Features:**
- ✅ Password hashing with `password_hash()` (bcrypt algorithm)
- ✅ SQL injection protection via PDO prepared statements
- ✅ XSS protection with `htmlspecialchars()` sanitization
- ✅ Session management with configurable timeout
- ✅ Role-based access control (RBAC)
- ✅ File upload validation (type, size, extension)
- ✅ Activity logging for audit trails
- ✅ RESTful API design pattern

### Frontend

| Technology | Purpose |
|------------|---------|
| **HTML5** | Semantic markup |
| **CSS3** | Modern styling |
| **JavaScript (ES6+)** | Client-side interactivity |
| **Fetch API** | AJAX requests |

**Design Features:**
- ✅ Fully responsive (mobile-first approach)
- ✅ CSS Grid & Flexbox layouts
- ✅ CSS Variables for theming
- ✅ No external frameworks (vanilla JS)
- ✅ Gradient backgrounds
- ✅ Card-based UI design
- ✅ Status badges with color coding
- ✅ Modal dialogs
- ✅ Drag-and-drop file upload

### Database

**Engine:** InnoDB  
**Charset:** UTF8MB4 (full Unicode support)  
**Collation:** utf8mb4_general_ci

**Tables:**
```
users (4 demo records)           - User accounts
papers (0 initial)               - Submitted papers
reviews (0 initial)              - Paper reviews
activity_log (0 initial)         - Audit trail
paper_comments (0 initial)       - Comments system
```

**Relationships:**
- Papers ← Users (author_id foreign key)
- Reviews ← Papers (paper_id foreign key)
- Reviews ← Users (reviewer_id foreign key)
- Activity Log ← Users (user_id foreign key)

**Indexes:**
- Primary keys on all tables
- Foreign key indexes for relationships
- Created_at indexes for sorting

---

## 🎓 Educational Use

This project is **perfect for learning**:

### Web Development Concepts
- ✅ **PHP Fundamentals**: Variables, functions, OOP, sessions, file handling
- ✅ **MySQL**: Database design, relationships, queries, joins
- ✅ **Security**: Authentication, authorization, input validation
- ✅ **API Development**: RESTful design, JSON responses
- ✅ **Frontend Development**: HTML, CSS, JavaScript integration

### Best Practices Demonstrated
- ✅ Separation of concerns (API, views, config)
- ✅ DRY principle (Don't Repeat Yourself)
- ✅ Secure coding practices
- ✅ Responsive web design
- ✅ Code documentation
- ✅ Version control ready (.gitignore)

### Suitable For
- 🎓 **Students**: Computer Science, Web Development courses
- 👨‍🏫 **Teachers**: As teaching material or assignment base
- 💼 **Beginners**: Learning full-stack development
- 🚀 **Intermediate**: Studying role-based systems
- 📚 **Portfolio Projects**: Showcase your skills

---

## 🆘 Getting Help

### Before Asking for Help

1. ✅ **Check Troubleshooting Section** (above)
2. ✅ **Verify XAMPP is running** (Apache + MySQL green)
3. ✅ **Check browser console** (F12 → Console tab)
4. ✅ **Review PHP error logs** (`C:\xampp\apache\logs\error.log`)
5. ✅ **Test with demo accounts** (fresh database import)

### Debugging Steps

```
Step 1: Check services
→ XAMPP Control Panel
→ Apache = Running ✓
→ MySQL = Running ✓

Step 2: Verify database
→ http://localhost/phpmyadmin
→ Database "papercms" exists ✓
→ Tables visible (5 tables) ✓

Step 3: Check project location
→ Path: C:\xampp\htdocs\PaperCMS\ ✓
→ Files present (index.php, etc.) ✓

Step 4: Test URL
→ http://localhost/PaperCMS/ ✓
→ Page loads ✓

Step 5: Try installation checker
→ http://localhost/PaperCMS/install.php
→ All checks pass ✓
```

### Common Error Messages

| Error | Most Likely Cause | Quick Fix |
|-------|-------------------|-----------|
| "Database connection failed" | MySQL not running | Start MySQL in XAMPP |
| "Unknown database papercms" | Database not imported | Import papercms.sql |
| "Page not found" | Wrong folder location | Move to htdocs |
| "Session expired" | Timeout too short | Increase SESSION_TIMEOUT |
| "File upload failed" | Permissions issue | Check folder permissions |
| "Invalid credentials" | Wrong password | Use demo accounts |

### Resources

- 📖 **PHP Manual**: https://www.php.net/manual/
- 📖 **MySQL Docs**: https://dev.mysql.com/doc/
- 📖 **XAMPP FAQ**: https://www.apachefriends.org/faq.html
- 💬 **Stack Overflow**: Tag questions with `php`, `mysql`, `xampp`

---

## 🔮 Future Enhancements

Potential features for future versions:

### v2.0 Planned Features
- [ ] Email notifications for paper status updates
- [ ] Admin panel for user management
- [ ] Multi-file upload (supporting images, supplementary files)
- [ ] Advanced search with filters
- [ ] Paper versioning system
- [ ] Commenting system on papers
- [ ] Export reports to PDF/Excel
- [ ] Dashboard analytics charts
- [ ] Dark mode toggle
- [ ] Multi-language support

### v3.0 Ideas
- [ ] Real-time notifications (WebSockets)
- [ ] Collaborative review system
- [ ] Integration with external APIs (ORCID, Crossref)
- [ ] Plagiarism detection
- [ ] AI-powered paper recommendations
- [ ] Mobile app (React Native / Flutter)

**Want to contribute?** Fork the project and submit pull requests!

---

## 📊 Project Statistics

```
Total Files:         32
Lines of Code:       ~6,000+
PHP Files:           15
HTML/PHP Pages:      11
JavaScript Files:    1 (app.js)
CSS Lines:           ~4,500
Database Tables:     5
API Endpoints:       14
Demo Accounts:       4
Default Roles:       3 (Author, Reviewer, Admin)
```

---

## 🌟 Acknowledgments

**Built with:**
- ☕ Lots of coffee
- 💻 VS Code
- 🐘 PHP & MySQL
- 🎨 CSS3 Magic
- ❤️ Passion for education

**Inspired by:**
- Academic paper submission systems
- Research repository platforms
- Content management systems (CMS)

---

## 📞 Contact & Contribution

### Contributing

We welcome contributions! Here's how:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/AmazingFeature`)
3. **Commit** your changes (`git commit -m 'Add some AmazingFeature'`)
4. **Push** to the branch (`git push origin feature/AmazingFeature`)
5. **Open** a Pull Request

### Code Style Guidelines

- Use **4 spaces** for indentation (no tabs)
- Follow **PSR-12** coding standard for PHP
- Use **camelCase** for JavaScript functions
- Use **snake_case** for database columns
- Comment your code where necessary
- Keep functions small and focused

### Reporting Issues

Found a bug? Please include:
- 🐛 Description of the bug
- 📋 Steps to reproduce
- 💻 Your environment (OS, PHP version, XAMPP version)
- 📸 Screenshots (if applicable)
- 📝 Error messages from console/logs

---

## ⭐ Show Your Support

If this project helped you learn or build something cool:

- ⭐ Star the repository
- 🍴 Fork it for your own projects
- 📢 Share it with others
- 💬 Provide feedback
- 🐛 Report bugs
- 🔧 Contribute improvements

---

<div align="center">

**Made with ❤️ for Research & Education**

*PaperCMS - Making Paper Management Simple*

**Version 1.0.0** | **2025** | **MIT License**

---

### Quick Links

[🏠 Home](#papercms---research-paper-repository-system) • 
[📦 Installation](#-installation-guide) • 
[📖 Usage](#-usage-guide) • 
[🐛 Troubleshooting](#-troubleshooting) • 
[📝 License](#-license)

---

*Built as a learning project • Perfect for education • Open for improvements*

**⚡ Powered by XAMPP • 🐘 PHP • 🗄️ MySQL • 🎨 CSS3 • ⚡ JavaScript**

</div>
