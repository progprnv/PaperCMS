# 🚀 QUICK SETUP GUIDE - PaperCMS

## 5-Minute Setup for XAMPP

### Step 1: Install XAMPP (if not already installed)
1. Download XAMPP from: https://www.apachefriends.org/
2. Run installer and follow the wizard
3. Install to default location: `C:\xampp`

### Step 2: Start Services
1. Open **XAMPP Control Panel**
2. Click **Start** for **Apache**
3. Click **Start** for **MySQL**
4. Both should show green "Running" status

### Step 3: Setup Database
1. Open browser and go to: **http://localhost/phpmyadmin**
2. Click **"Import"** tab at the top
3. Click **"Choose File"**
4. Navigate to: `C:\Users\kannapi64x\Desktop\Git projects\PaperCMS\database\papercms.sql`
5. Click **"Go"** button at bottom
6. Wait for success message
7. You should see **"papercms"** database in left sidebar

### Step 4: Access Application
1. Open browser
2. Go to: **http://localhost/PaperCMS**
3. You'll be redirected to login page

### Step 5: Login

**Test as Author:**
- Email: `author@example.com`
- Password: `password`

**Test as Reviewer:**
- Email: `reviewer@example.com`
- Password: `password`

## ✅ Verification Checklist

- [ ] XAMPP Control Panel shows Apache running (green)
- [ ] XAMPP Control Panel shows MySQL running (green)
- [ ] phpMyAdmin accessible at http://localhost/phpmyadmin
- [ ] Database "papercms" appears in phpMyAdmin
- [ ] PaperCMS accessible at http://localhost/PaperCMS
- [ ] Can login with demo credentials
- [ ] Upload folder permissions set (auto-created on first upload)

## 🎯 What to Try

### As Author:
1. Login with author credentials
2. Click "Submit Paper"
3. Fill in paper details
4. Upload a PDF file
5. View submission in "My Papers"

### As Reviewer:
1. Logout and login with reviewer credentials
2. View submitted papers in dashboard
3. Click "Review" on any paper
4. Download and review PDF
5. Submit review with status update

## ⚠️ Common Issues & Fixes

### Issue: "Database connection failed"
**Fix:** 
- Make sure MySQL is running in XAMPP
- Check database was imported correctly
- Verify database name is "papercms"

### Issue: "Port 80 already in use" (Apache won't start)
**Fix:**
- Stop Skype or other apps using port 80
- Or change Apache port in XAMPP config

### Issue: File upload doesn't work
**Fix:**
- Make sure you're logged in as author
- Check file is PDF and under 10MB
- Folder permissions will be set automatically

### Issue: Page not found (404)
**Fix:**
- Access via: http://localhost/PaperCMS (not http://localhost:8080)
- Make sure folder is in C:\xampp\htdocs\PaperCMS

## 📞 Need Help?

1. Check main README.md for detailed documentation
2. Verify all XAMPP services are running
3. Check browser console for errors (F12)
4. Look at XAMPP Apache error logs

## 🎓 Default Accounts

All default passwords are: **password**

| Role | Email | Password |
|------|-------|----------|
| Author | author@example.com | password |
| Reviewer | reviewer@example.com | password |
| Admin | admin@papercms.com | password |

**Remember to change these in production!**

---

## Next Steps

1. **Customize**: Edit colors in `assets/css/style.css`
2. **Add Users**: Register new accounts via registration page
3. **Test Workflow**: Submit papers as author, review as reviewer
4. **Explore Code**: Check `api/` folder for backend logic

Happy coding! 🎉
