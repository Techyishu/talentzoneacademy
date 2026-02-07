# 🚀 HOSTINGER DEPLOYMENT - QUICK REFERENCE

## 📁 FILE PATHS

```bash
# Laravel App
/home/username/schoolsuite/

# Public Web Root
/home/username/domains/yourdomain.com/public_html/

# Storage (via symlink)
/home/username/schoolsuite/storage/app/public/
  ↓
/home/username/domains/yourdomain.com/public_html/storage/

# Logs
/home/username/schoolsuite/storage/logs/laravel.log
~/logs/error_log  # Apache logs
```

---

## 🔧 COMMON COMMANDS

### **Connect via SSH**
```bash
ssh username@yourdomain.com
cd /home/username/schoolsuite
```

### **Clear All Cache**
```bash
php artisan optimize:clear
```

### **Recache Everything (After Config Changes)**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### **Run Migrations**
```bash
php artisan migrate --force
```

### **Create Storage Symlink**
```bash
ln -sf /home/username/schoolsuite/storage/app/public /home/username/domains/yourdomain.com/public_html/storage
```

### **Fix Permissions**
```bash
chmod -R 755 /home/username/schoolsuite/storage
chmod -R 755 /home/username/schoolsuite/bootstrap/cache
chmod 600 /home/username/schoolsuite/.env
```

### **View Logs (Live)**
```bash
tail -f /home/username/schoolsuite/storage/logs/laravel.log
```

### **Update Dependencies**
```bash
composer install --no-dev --optimize-autoloader
```

---

## 🔍 DEBUGGING

### **Check PHP Version**
```bash
php -v  # Should be 8.2+
```

### **Test Database Connection**
```bash
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit;
```

### **Check Symlink**
```bash
ls -la /home/username/domains/yourdomain.com/public_html/storage
# Should show: storage -> /home/username/schoolsuite/storage/app/public
```

### **View Last 50 Log Lines**
```bash
tail -n 50 /home/username/schoolsuite/storage/logs/laravel.log
```

### **Check Disk Space**
```bash
df -h
du -sh /home/username/schoolsuite
```

---

## 🔒 SECURITY CHECKLIST

```bash
# Verify APP_DEBUG=false
grep APP_DEBUG /home/username/schoolsuite/.env

# Verify .env permissions
ls -la /home/username/schoolsuite/.env
# Should show: -rw------- (600)

# Verify HTTPS force
curl -I http://yourdomain.com
# Should redirect to https://

# Test symlink isolation
curl https://yourdomain.com/../../../schoolsuite/.env
# Should return 403 Forbidden
```

---

## 🔄 DEPLOYMENT WORKFLOW

### **Standard Deployment**
```bash
# 1. Connect
ssh username@yourdomain.com
cd /home/username/schoolsuite

# 2. Backup
cp .env .env.backup

# 3. Update code (git or FTP)
git pull origin main

# 4. Update dependencies
composer install --no-dev --optimize-autoloader

# 5. Run migrations
php artisan migrate --force

# 6. Clear & recache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Fix permissions
chmod -R 755 storage bootstrap/cache

# 8. Test
curl -I https://yourdomain.com
```

### **Automated Deployment (Using Script)**
```bash
cd /home/username/schoolsuite
chmod +x deploy.sh
./deploy.sh
```

---

## 🛠️ TROUBLESHOOTING

### **500 Error**
```bash
tail -50 /home/username/schoolsuite/storage/logs/laravel.log
chmod -R 755 storage bootstrap/cache
php artisan optimize:clear
php artisan config:cache
```

### **Images Not Loading**
```bash
rm -f /home/username/domains/yourdomain.com/public_html/storage
ln -sf /home/username/schoolsuite/storage/app/public /home/username/domains/yourdomain.com/public_html/storage
```

### **CSS/JS Not Loading**
```bash
# On local machine:
npm run build

# Upload /public/build/ to server
# Then on server:
php artisan view:clear
```

### **Database Connection Failed**
```bash
cat .env | grep DB_
php artisan tinker
>>> DB::connection()->getPdo();
```

---

## 📦 BACKUP

### **Backup Database (via SSH)**
```bash
mysqldump -u DB_USER -p DB_NAME > backup-$(date +%Y%m%d).sql
```

### **Backup .env**
```bash
cp .env .env.backup-$(date +%Y%m%d)
```

### **Backup Uploads**
```bash
tar -czf storage-backup-$(date +%Y%m%d).tar.gz storage/app/public/
```

---

## 🔐 CREDENTIALS

### **Database**
```
Host:     localhost
Database: u123456_schoolsuite
Username: u123456_schoolsuite
Password: [from hPanel]
```

### **FTP**
```
Host:     ftp.yourdomain.com
Username: [from hPanel]
Password: [from hPanel]
Port:     21
```

### **SSH**
```
ssh username@yourdomain.com
Password: [from hPanel → SSH Access]
```

### **Default Admin (Change Immediately!)**
```
Email:    admin@schoolsuite.com
Password: password
```

---

## 📞 SUPPORT

**Hostinger Support:** 24/7 Live Chat in hPanel
**Laravel Docs:** https://laravel.com/docs/12.x
**Project Issues:** Check `storage/logs/laravel.log`

---

## ⚡ QUICK FIXES

| Problem | Solution |
|---------|----------|
| 500 Error | `chmod -R 755 storage && php artisan config:cache` |
| Images not loading | Recreate symlink (see above) |
| CSRF token mismatch | Clear browser cookies + `php artisan config:cache` |
| Route not found | `php artisan route:cache` |
| View not updating | `php artisan view:clear` |
| Config not updating | `php artisan config:cache` |

---

**End of Quick Reference** 📋
