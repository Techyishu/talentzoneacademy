# 🔒 HOSTINGER DEPLOYMENT - SECURITY CHECKLIST

## ✅ PRE-DEPLOYMENT SECURITY

### **1. Environment Configuration**
- [ ] `APP_ENV=production` in .env
- [ ] `APP_DEBUG=false` in .env
- [ ] `APP_URL` uses `https://` (not `http://`)
- [ ] `SESSION_SECURE_COOKIE=true` (HTTPS-only cookies)
- [ ] Strong `DB_PASSWORD` (minimum 16 characters, mixed)
- [ ] `APP_KEY` generated (`php artisan key:generate`)

### **2. File Permissions**
- [ ] `.env` file: `chmod 600` (owner read/write only)
- [ ] `storage/` directory: `chmod 755`
- [ ] `bootstrap/cache/` directory: `chmod 755`
- [ ] All other files: `chmod 644` (files), `chmod 755` (directories)

### **3. Files to NEVER Upload**
- [ ] `.env.local` or `.env.example` with real credentials
- [ ] `.git/` folder (if using Git on server, ensure `.git` is outside web root)
- [ ] `node_modules/` (not needed in production)
- [ ] `.DS_Store`, `Thumbs.db`
- [ ] Development tools (PHPUnit, PHPStan, etc.)

---

## 🛡️ HOSTINGER-SPECIFIC SECURITY

### **1. Directory Structure Security**

**✅ CORRECT Structure:**
```
/home/username/
├── schoolsuite/           ← Laravel app (NOT web-accessible)
│   ├── .env              ← Contains secrets
│   ├── app/
│   ├── config/
│   ├── storage/
│   └── vendor/
└── domains/
    └── yourdomain.com/
        └── public_html/   ← ONLY public/ contents or symlink
```

**❌ WRONG Structure:**
```
/home/username/domains/yourdomain.com/public_html/
└── schoolsuite/           ← NEVER put Laravel app here!
    └── .env              ← Exposed to web! DANGEROUS!
```

**Verification:**
```bash
# Test if .env is accessible (should return 403 or 404)
curl https://yourdomain.com/../../../schoolsuite/.env

# Should NOT be able to access:
curl https://yourdomain.com/vendor/autoload.php
curl https://yourdomain.com/../composer.json
```

---

### **2. .htaccess Security**

**In public_html/.htaccess:**
- [ ] HTTPS redirect enabled
- [ ] Directory listing disabled (`Options -Indexes`)
- [ ] Security headers configured
- [ ] `.env` file access blocked

**In /home/username/schoolsuite/.htaccess:**
- [ ] Root .htaccess installed (denies all access)
- [ ] Prevents directory traversal

**Verify:**
```bash
# Check HTTPS redirect
curl -I http://yourdomain.com
# Should return: Location: https://yourdomain.com

# Check directory listing disabled
curl https://yourdomain.com/build/
# Should return 403 Forbidden, NOT file list
```

---

### **3. Storage Symlink Security**

**✅ CORRECT Symlink:**
```bash
/home/username/domains/yourdomain.com/public_html/storage/
  → /home/username/schoolsuite/storage/app/public/
```

**❌ WRONG Symlink:**
```bash
# NEVER symlink to storage/ root (exposes .env, logs, etc.)
/home/username/domains/yourdomain.com/public_html/storage/
  → /home/username/schoolsuite/storage/  ← DANGEROUS!
```

**Verification:**
```bash
# Verify symlink target
ls -la /home/username/domains/yourdomain.com/public_html/storage
# Should point to: /home/username/schoolsuite/storage/app/public

# Test that logs are NOT accessible
curl https://yourdomain.com/storage/../logs/laravel.log
# Should return 404 or 403

# Test that uploads ARE accessible
curl -I https://yourdomain.com/storage/test.txt
# Should return 200 OK (if file exists)
```

---

## 🔐 DATABASE SECURITY

### **1. MySQL User Privileges**
- [ ] Database user has access ONLY to SchoolSuite database
- [ ] Database user has NO access to other databases
- [ ] `localhost` connection only (not `%` or `0.0.0.0`)

**Verify in Hostinger hPanel:**
1. Go to **Databases → MySQL Databases**
2. Check user privileges: Should show only `u123456_schoolsuite` database

### **2. Database Password**
- [ ] Minimum 16 characters
- [ ] Contains uppercase, lowercase, numbers, symbols
- [ ] NOT the same as FTP/SSH password
- [ ] Generated randomly (not "password123")

**Generate Strong Password:**
```bash
openssl rand -base64 24
```

---

## 🌐 SSL/HTTPS SECURITY

### **1. SSL Certificate**
- [ ] Free Let's Encrypt SSL installed via hPanel
- [ ] Certificate auto-renews (check in hPanel)
- [ ] All pages force HTTPS redirect

### **2. Cookie Security**
- [ ] `SESSION_SECURE_COOKIE=true` (cookies only via HTTPS)
- [ ] `SESSION_HTTP_ONLY=true` (JavaScript cannot access)
- [ ] `SESSION_SAME_SITE=lax` (CSRF protection)

**Verify:**
```bash
# Check cookies in browser DevTools
# Should see: Secure; HttpOnly; SameSite=Lax
```

---

## 🚫 ACCESS CONTROL

### **1. Admin Credentials**
- [ ] Default admin password changed immediately after deployment
- [ ] Strong passwords enforced (min 8 characters)
- [ ] Super admin email changed from `admin@schoolsuite.com`

**Change Default Admin:**
```bash
php artisan tinker
>>> $admin = App\Models\User::where('email', 'admin@schoolsuite.com')->first();
>>> $admin->email = 'youremail@yourdomain.com';
>>> $admin->password = Hash::make('YourStrongPassword123!');
>>> $admin->save();
>>> exit;
```

### **2. Test User Accounts**
- [ ] All seeded test accounts reviewed
- [ ] Test school admin accounts deleted or password changed
- [ ] No default "password" passwords in production

**List All Users:**
```bash
php artisan tinker
>>> App\Models\User::all(['name', 'email', 'role']);
```

---

## 📝 LOGGING & MONITORING

### **1. Error Logging**
- [ ] `LOG_LEVEL=error` (not `debug` in production)
- [ ] Logs stored outside web root (`storage/logs/`)
- [ ] No sensitive data logged (passwords, tokens)

### **2. Failed Login Attempts**
- [ ] Rate limiting enabled (5 attempts, already configured)
- [ ] Failed logins logged by Laravel Breeze

**Monitor Failed Logins:**
```bash
grep "failed" /home/username/schoolsuite/storage/logs/laravel.log
```

---

## 🔍 SECURITY TESTING

### **1. Manual Penetration Testing**

**Test 1: Directory Traversal**
```bash
curl https://yourdomain.com/../../../schoolsuite/.env
curl https://yourdomain.com/../../.env
curl https://yourdomain.com/storage/../logs/laravel.log
# All should return 403 or 404
```

**Test 2: Sensitive File Access**
```bash
curl https://yourdomain.com/.env
curl https://yourdomain.com/composer.json
curl https://yourdomain.com/vendor/autoload.php
# All should return 403 or 404
```

**Test 3: Directory Listing**
```bash
curl https://yourdomain.com/build/
curl https://yourdomain.com/storage/
# Should return 403, NOT file list
```

**Test 4: SQL Injection (Login Form)**
```
Email: admin@test.com' OR '1'='1
Password: anything
# Should NOT bypass authentication
```

**Test 5: XSS (Student Name Field)**
```html
<script>alert('XSS')</script>
<!-- Should be escaped when displayed -->
```

### **2. Automated Security Scan (Optional)**

**OWASP ZAP (Run on Staging):**
```bash
# Download: https://www.zaproxy.org/
# Scan: https://yourdomain.com
```

---

## 🔄 REGULAR SECURITY MAINTENANCE

### **Daily**
- [ ] Monitor error logs for suspicious activity
- [ ] Check failed login attempts

### **Weekly**
- [ ] Review user accounts (delete unused)
- [ ] Check disk space (logs can grow large)
- [ ] Verify SSL certificate is valid

### **Monthly**
- [ ] Update Laravel & dependencies (`composer update`)
- [ ] Check for security advisories (`composer audit`)
- [ ] Review and rotate API keys (if any)
- [ ] Backup database and files

### **After Any Incident**
- [ ] Review logs for unauthorized access
- [ ] Check file modifications: `find . -mtime -1 -type f`
- [ ] Reset all admin passwords
- [ ] Regenerate `APP_KEY` and re-login all users

---

## 📊 SECURITY AUDIT COMMANDS

```bash
# Check file permissions
find /home/username/schoolsuite -type f ! -perm 644
find /home/username/schoolsuite -type d ! -perm 755

# Find files with wrong ownership
find /home/username/schoolsuite ! -user username

# Check for suspicious files
find /home/username/schoolsuite -name "*.php" -mtime -1

# Check for common malware signatures
grep -r "base64_decode" /home/username/schoolsuite --include="*.php" | grep -v vendor

# Check .env is not web-accessible
curl -I https://yourdomain.com/.env

# Verify HTTPS redirect
curl -I http://yourdomain.com
```

---

## 🚨 SECURITY INCIDENT RESPONSE

### **If Compromised:**

**1. Immediate Actions:**
```bash
# Change all passwords (database, FTP, SSH, admin)
# Regenerate APP_KEY
php artisan key:generate --force

# Force logout all users
php artisan session:flush

# Check for backdoors
find /home/username/schoolsuite -name "*.php" -mtime -7 | xargs grep -l "eval\|base64_decode\|system\|exec"

# Restore from clean backup
# Review logs for entry point
```

**2. Contact Hostinger Support:**
- Report incident to Hostinger
- Request security scan
- Check server logs

**3. Post-Incident:**
- Conduct full security audit
- Update all dependencies
- Implement additional monitoring

---

## ✅ FINAL SECURITY VERIFICATION

**Before Going Live:**

```bash
# 1. Environment
grep -E "APP_ENV|APP_DEBUG|APP_KEY" /home/username/schoolsuite/.env

# 2. HTTPS
curl -I http://yourdomain.com | grep "Location: https"

# 3. .env not accessible
curl -I https://yourdomain.com/.env | grep "403\|404"

# 4. Symlink correct
ls -la /home/username/domains/yourdomain.com/public_html/storage

# 5. Permissions
ls -la /home/username/schoolsuite/.env

# 6. Cache optimized
ls -la /home/username/schoolsuite/bootstrap/cache/config.php

# 7. Logs clean (no test data)
tail -20 /home/username/schoolsuite/storage/logs/laravel.log
```

**Expected Output:**
```
✅ APP_ENV=production
✅ APP_DEBUG=false
✅ APP_KEY=base64:...
✅ HTTPS redirect: 301 → https://
✅ .env: 403 Forbidden
✅ Symlink: storage -> .../storage/app/public
✅ .env permissions: -rw-------
✅ Config cached
✅ No errors in logs
```

---

## 📞 SECURITY RESOURCES

**Laravel Security:**
- https://laravel.com/docs/12.x/security

**OWASP Top 10:**
- https://owasp.org/www-project-top-ten/

**Hostinger Security:**
- https://support.hostinger.com/en/collections/1715867-security

**Report Vulnerabilities:**
- Laravel: security@laravel.com
- Hostinger: security@hostinger.com

---

**🔒 Security is not a one-time task. Stay vigilant!**
