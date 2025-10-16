# PaperCMS System Architecture

## System Overview

```
┌─────────────────────────────────────────────────────────────────────┐
│                         PaperCMS System                             │
│                  Research Paper Repository                          │
└─────────────────────────────────────────────────────────────────────┘

┌──────────────┐                                    ┌──────────────┐
│              │                                    │              │
│   AUTHOR     │                                    │  REVIEWER    │
│              │                                    │              │
└──────┬───────┘                                    └──────┬───────┘
       │                                                   │
       │ Login/Register                   Login/Register  │
       │                                                   │
       └───────────────────┬───────────────────────────────┘
                           │
                           ▼
              ┌────────────────────────┐
              │  Authentication Layer  │
              │  (Session Management)  │
              └────────────────────────┘
                           │
              ┌────────────┴────────────┐
              │                         │
              ▼                         ▼
    ┌──────────────────┐      ┌──────────────────┐
    │  Author Portal   │      │ Reviewer Portal  │
    ├──────────────────┤      ├──────────────────┤
    │ • Dashboard      │      │ • Dashboard      │
    │ • Submit Paper   │      │ • View Papers    │
    │ • My Papers      │      │ • Review Papers  │
    │ • View Status    │      │ • Update Status  │
    │ • Track Reviews  │      │ • Download PDFs  │
    └──────────────────┘      └──────────────────┘
              │                         │
              └────────────┬────────────┘
                           │
                           ▼
              ┌────────────────────────┐
              │     API Layer (PHP)    │
              ├────────────────────────┤
              │ • auth.php             │
              │ • author.php           │
              │ • reviewer.php         │
              └────────────────────────┘
                           │
              ┌────────────┴────────────┐
              │                         │
              ▼                         ▼
    ┌──────────────────┐      ┌──────────────────┐
    │  MySQL Database  │      │  File Storage    │
    ├──────────────────┤      ├──────────────────┤
    │ • users          │      │ uploads/papers/  │
    │ • papers         │      │ • PDF files      │
    │ • reviews        │      │                  │
    │ • activity_log   │      │                  │
    │ • comments       │      │                  │
    └──────────────────┘      └──────────────────┘
```

## User Roles & Permissions

### Author Role
```
┌─────────────────────────────────────┐
│          AUTHOR PERMISSIONS         │
├─────────────────────────────────────┤
│ ✓ Submit new papers                 │
│ ✓ Upload PDF files (max 10MB)       │
│ ✓ View own submissions               │
│ ✓ Track paper status                │
│ ✓ Read reviewer feedback             │
│ ✓ Delete pending papers              │
│ ✓ View submission statistics         │
│ ✗ Review papers                      │
│ ✗ Change paper status                │
│ ✗ View other authors' papers         │
└─────────────────────────────────────┘
```

### Reviewer Role
```
┌─────────────────────────────────────┐
│        REVIEWER PERMISSIONS         │
├─────────────────────────────────────┤
│ ✓ View all submitted papers          │
│ ✓ Download PDFs for review           │
│ ✓ Submit reviews & feedback          │
│ ✓ Update paper status:               │
│   - Pending                          │
│   - In Process                       │
│   - Published                        │
│   - Rejected                         │
│ ✓ View author information            │
│ ✓ Add review comments                │
│ ✓ View review statistics             │
│ ✗ Submit papers                      │
│ ✗ Delete papers                      │
└─────────────────────────────────────┘
```

## Data Flow

### Paper Submission Flow
```
Author Action                 System                    Database
─────────────                 ──────                    ────────

Fill Form
  ├─ Title
  ├─ Abstract                 Validate Input
  ├─ Keywords                      │
  └─ Upload PDF                    ▼
       │                    Check File Type
       │                    Check File Size
       │                           │
       ▼                           ▼
  Submit ───────────────►  Move File to uploads/
                                   │
                                   ▼
                          Insert into 'papers'
                                   │
                                   ▼
                          Log Activity
                                   │
                                   ▼
                          Return Success
                                   │
                                   ▼
Redirect to                Show Confirmation
Dashboard                         │
                                  ▼
                          Email Notification
                          (Future Enhancement)
```

### Review Process Flow
```
Reviewer Action              System                    Database
───────────────              ──────                    ────────

View Papers
     │
     ▼
Select Paper ────────►   Fetch Paper Details
     │                         │
     │                         ▼
     │                   Fetch Author Info
     │                         │
     ▼                         ▼
Download PDF            Increment Download Count
     │                         │
     ▼                         ▼
Read & Evaluate         Show Review Form
     │
     ▼
Submit Review
  ├─ Status           ────────►  Validate Input
  └─ Comments                         │
                                      ▼
                              Insert into 'reviews'
                                      │
                                      ▼
                              Update 'papers' status
                                      │
                                      ▼
                              Log Activity
                                      │
                                      ▼
                              Return Success
                                      │
                                      ▼
Redirect to                  Show Confirmation
Papers List                         │
                                    ▼
                            Notify Author
                            (Future Enhancement)
```

## Database Schema Relationships

```
┌──────────────┐
│    users     │
├──────────────┤
│ user_id (PK) │◄───┐
│ username     │    │
│ email        │    │  Foreign Key
│ password     │    │  Relationship
│ role         │    │
└──────────────┘    │
                    │
        ┌───────────┴─────────────┐
        │                         │
        │                         │
┌───────┴────────┐      ┌─────────┴──────┐
│     papers     │      │    reviews     │
├────────────────┤      ├────────────────┤
│ paper_id (PK)  │◄─────┤ review_id (PK) │
│ author_id (FK) │      │ paper_id (FK)  │
│ title          │      │ reviewer_id(FK)│
│ abstract       │      │ status         │
│ pdf_path       │      │ comments       │
│ status         │      │ review_date    │
└────────────────┘      └────────────────┘
        │
        │
┌───────┴─────────────┐
│  paper_comments     │
├─────────────────────┤
│ comment_id (PK)     │
│ paper_id (FK)       │
│ user_id (FK)        │
│ comment             │
└─────────────────────┘
```

## Security Layers

```
┌─────────────────────────────────────────────────┐
│              Security Measures                  │
├─────────────────────────────────────────────────┤
│                                                 │
│  1. Authentication Layer                        │
│     ├─ Password Hashing (bcrypt)                │
│     ├─ Session Management                       │
│     └─ Login/Logout Control                     │
│                                                 │
│  2. Authorization Layer                         │
│     ├─ Role-based Access Control                │
│     ├─ Permission Checks                        │
│     └─ Session Timeout (1 hour)                 │
│                                                 │
│  3. Input Validation                            │
│     ├─ SQL Injection Prevention (PDO)           │
│     ├─ XSS Protection (Sanitization)            │
│     └─ File Upload Validation                   │
│                                                 │
│  4. Data Protection                             │
│     ├─ Prepared Statements                      │
│     ├─ CSRF Token (Future)                      │
│     └─ HTTPS Ready                              │
│                                                 │
└─────────────────────────────────────────────────┘
```

## Technology Stack

```
┌────────────────────────────────────────────┐
│            Frontend Layer                  │
├────────────────────────────────────────────┤
│  HTML5      │  Semantic markup             │
│  CSS3       │  Modern styling, flexbox     │
│  JavaScript │  Vanilla JS, AJAX, fetch API │
└────────────────────────────────────────────┘
                      │
                      ▼
┌────────────────────────────────────────────┐
│            Backend Layer                   │
├────────────────────────────────────────────┤
│  PHP 7.4+   │  Server-side logic           │
│  PDO        │  Database abstraction         │
│  Sessions   │  State management            │
└────────────────────────────────────────────┘
                      │
                      ▼
┌────────────────────────────────────────────┐
│            Database Layer                  │
├────────────────────────────────────────────┤
│  MySQL 5.7+ │  Relational database         │
│  InnoDB     │  Storage engine              │
│  UTF8MB4    │  Character set               │
└────────────────────────────────────────────┘
                      │
                      ▼
┌────────────────────────────────────────────┐
│            Server Layer                    │
├────────────────────────────────────────────┤
│  Apache     │  Web server                  │
│  XAMPP      │  Development environment     │
│  mod_rewrite│  URL handling                │
└────────────────────────────────────────────┘
```

## File Organization

```
PaperCMS/
│
├── 🔐 Authentication & Security
│   ├── auth/login.php          (Login interface)
│   ├── auth/register.php       (Registration interface)
│   └── config/config.php       (Security functions)
│
├── 👨‍💼 Author Features
│   ├── author/dashboard.php    (Overview & stats)
│   ├── author/submit.php       (Paper submission)
│   └── author/my-papers.php    (View submissions)
│
├── 👨‍🏫 Reviewer Features
│   ├── reviewer/dashboard.php  (Overview & stats)
│   ├── reviewer/papers.php     (All papers list)
│   └── reviewer/review.php     (Review interface)
│
├── 🔌 API Endpoints
│   ├── api/auth.php            (Authentication API)
│   ├── api/author.php          (Author operations)
│   └── api/reviewer.php        (Reviewer operations)
│
├── 🎨 Frontend Assets
│   ├── assets/css/style.css    (Unified stylesheet)
│   └── assets/js/app.js        (Shared functions)
│
├── ⚙️ Configuration
│   ├── config/config.php       (App configuration)
│   └── config/database.php     (DB connection)
│
├── 🗄️ Database
│   └── database/papercms.sql   (Schema & sample data)
│
└── 📦 Storage
    └── uploads/papers/         (PDF storage)
```

## Deployment Architecture (XAMPP)

```
┌──────────────────────────────────────────────┐
│           User's Computer                    │
│                                              │
│  ┌────────────────────────────────────┐    │
│  │         Web Browser                 │    │
│  │  http://localhost/PaperCMS          │    │
│  └──────────────┬─────────────────────┘    │
│                 │                           │
│                 │ HTTP Request              │
│                 ▼                           │
│  ┌────────────────────────────────────┐    │
│  │     XAMPP Control Panel            │    │
│  ├────────────────────────────────────┤    │
│  │  Apache (Port 80)                  │    │
│  │    ├─ Serves PHP files             │    │
│  │    ├─ Routes requests              │    │
│  │    └─ Handles sessions             │    │
│  │                                     │    │
│  │  MySQL (Port 3306)                 │    │
│  │    ├─ Stores data                  │    │
│  │    ├─ Manages transactions         │    │
│  │    └─ Enforces constraints         │    │
│  │                                     │    │
│  │  phpMyAdmin (Database Admin)       │    │
│  └────────────────────────────────────┘    │
│                                              │
│  📁 C:\xampp\htdocs\PaperCMS\              │
│     ├─ PHP Application Files                │
│     ├─ CSS, JavaScript                      │
│     └─ Uploaded PDFs                        │
│                                              │
└──────────────────────────────────────────────┘
```

---

This architecture diagram provides a complete visual overview of the PaperCMS system structure, data flows, and component relationships.
