╔═══════════════════════════════════════════════════════════════════════╗
║                                                                       ║
║                      📄 PaperCMS v1.0.0                              ║
║              Research Paper Repository System                         ║
║                                                                       ║
╚═══════════════════════════════════════════════════════════════════════╝

A professional, full-featured research paper repository system with 
role-based access control for authors and reviewers.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📋 QUICK START
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

1. Install XAMPP from https://www.apachefriends.org/
2. Copy PaperCMS folder to C:\xampp\htdocs\
3. Start Apache and MySQL in XAMPP Control Panel
4. Import database/papercms.sql via phpMyAdmin
5. Access http://localhost/PaperCMS in your browser

📖 For detailed setup instructions, see SETUP.md

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

✨ FEATURES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Author Features:
  ✓ Submit research papers with PDF upload
  ✓ Track submission status
  ✓ View reviewer feedback
  ✓ Manage all submissions
  ✓ Delete pending papers

Reviewer Features:
  ✓ Review all submitted papers
  ✓ Approve/Reject submissions
  ✓ Provide detailed feedback
  ✓ Download papers for review
  ✓ Update paper status (Pending/In Process/Published/Rejected)

System Features:
  ✓ Role-based access control
  ✓ Secure authentication
  ✓ Session management
  ✓ Activity logging
  ✓ Professional UI/UX

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

🔑 DEFAULT LOGIN CREDENTIALS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Author Account:
  Email: author@example.com
  Password: password

Reviewer Account:
  Email: reviewer@example.com
  Password: password

⚠️ IMPORTANT: Change these passwords after first login!

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

🛠️ TECH STACK
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Frontend: HTML5, CSS3, Vanilla JavaScript
Backend:  PHP 7.4+
Database: MySQL 5.7+
Server:   XAMPP (Apache + MySQL)

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📁 PROJECT STRUCTURE
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

PaperCMS/
  ├── api/              → Backend API endpoints
  ├── assets/           → CSS, JavaScript, images
  ├── auth/             → Login & registration
  ├── author/           → Author dashboard & features
  ├── reviewer/         → Reviewer dashboard & features
  ├── config/           → Configuration files
  ├── database/         → SQL schema
  ├── uploads/          → PDF file storage
  ├── index.php         → Entry point
  ├── README.md         → Full documentation
  └── SETUP.md          → Quick setup guide

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📚 DOCUMENTATION
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

README.md  - Complete documentation and features
SETUP.md   - Quick 5-minute setup guide
Database   - See database/papercms.sql for schema

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

🆘 TROUBLESHOOTING
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Issue: Database connection failed
Fix:   Ensure MySQL is running in XAMPP & database is imported

Issue: Page not found (404)
Fix:   Access via http://localhost/PaperCMS (case-sensitive)

Issue: File upload fails
Fix:   Check uploads/papers/ folder exists & has permissions

For more help, see README.md troubleshooting section

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

🎓 EDUCATIONAL USE
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

This project demonstrates:
  • Role-based access control
  • Secure authentication & session management
  • File upload handling
  • RESTful API design
  • Modern UI/UX principles
  • MySQL database design
  • PHP best practices

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Made with ❤️ for research paper management

Version 1.0.0
