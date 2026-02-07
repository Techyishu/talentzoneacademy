# 🚀 HOSTINGER SHARED HOSTING DEPLOYMENT GUIDE
## SchoolSuite Laravel 12 Application

---

## 📋 PREREQUISITES

### **Required:**
- ✅ Hostinger Business or Premium plan (SSH access required)
- ✅ PHP 8.2+ enabled
- ✅ MySQL database created
- ✅ Domain pointed to Hostinger
- ✅ SSL certificate (free Let's Encrypt)
- ✅ SSH client (Terminal/PuTTY)

### **Check Your Hostinger Plan:**
1. Login to Hostinger hPanel: https://hpanel.hostinger.com
2. Go to **Hosting → Manage**
3. Verify:
   - PHP Version: **8.2 or higher**
   - SSH Access: **Enabled** (if not, upgrade plan)
   - SSL: **Enabled** (free Let's Encrypt)

---

## 🗄️ STEP 1: CREATE MYSQL DATABASE

### **1.1 Create Database in hPanel**

1. Login to **Hostinger hPanel**
2. Go to **Databases → MySQL Databases**
3. Click **Create New Database**

**Database Details:**
```
Database Name: u123456_schoolsuite
Username:      u123456_schoolsuite
Password:      [Generate Strong Password]
```

**Important:** Write down these credentials! You'll need them for `.env` file.

### **1.2 Test Database Connection**

1. Go to **phpMyAdmin** (from hPanel)
2. Login with database credentials
3. Verify connection works

---

## 📦 STEP 2: PREPARE PROJECT FILES

### **2.1 Build Assets Locally (BEFORE Upload)**

Run on your **LOCAL** machine:

```bash
# Navigate to project
cd /path/to/schoolsuite

# Install Node.js dependencies
npm install

# Build production assets
npm run build

# This creates /public/build/ folder with compiled CSS/JS
```

### **2.2 Create Production .env File**

Create `.env.production` on your local machine:

```bash
cp .env.production.example .env.production
```

Edit `.env.production` with your Hostinger details:

```dotenv
APP_NAME="SchoolSuite"
APP_ENV=production
APP_KEY=  # Leave blank, will generate on server
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# Hostinger Database Credentials
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456_schoolsuite
DB_USERNAME=u123456_schoolsuite
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true

CACHE_STORE=database
QUEUE_CONNECTION=database

# Hostinger Mail (optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### **2.3 Exclude Unnecessary Files**

Make sure `.gitignore` includes:

```gitignore
/node_modules
/public/build
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.env.production
```

---

## 🔐 STEP 3: UPLOAD FILES TO HOSTINGER

### **Option A: Upload via FTP (Recommended for First Deploy)**

**3.1 Connect to FTP**

Use **FileZilla** or any FTP client:

```
Host:     ftp.yourdomain.com
Username: your_hostinger_ftp_username
Password: your_hostinger_ftp_password
Port:     21
```

**3.2 Upload Structure**

Upload to: `/home/username/`

```
/home/username/
├── schoolsuite/              ← Upload Laravel app HERE
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/              ← Upload this! (or use Composer on server)
│   ├── .env.production      ← Upload as .env
│   ├── composer.json
│   └── composer.lock
└── domains/
    └── yourdomain.com/
        └── public_html/      ← Will symlink to schoolsuite/public
```

**Important:**
- Upload Laravel app to `/home/username/schoolsuite/` (OUTSIDE public_html)
- Rename `.env.production` to `.env` after upload

**3.3 Verify Upload**

Check that these files exist on server:
- `/home/username/schoolsuite/.env`
- `/home/username/schoolsuite/artisan`
- `/home/username/schoolsuite/public/index.php`

---

### **Option B: Upload via Git (Recommended for Updates)**

**3.1 Connect via SSH**

```bash
ssh username@yourdomain.com
# OR
ssh username@serverIP
```

**3.2 Clone Repository (if using Git)**

```bash
cd /home/username

# Clone from GitHub/GitLab/Bitbucket
git clone https://github.com/yourusername/schoolsuite.git

# OR upload as ZIP and extract
unzip schoolsuite.zip
```

---

## ⚙️ STEP 4: SERVER CONFIGURATION

### **4.1 Connect via SSH**

```bash
ssh username@yourdomain.com
```

**First Time SSH Access:**
- If SSH disabled, enable in: **hPanel → Advanced → SSH Access**
- Use provided SSH credentials

### **4.2 Navigate to Project**

```bash
cd /home/username/schoolsuite
pwd  # Verify path: /home/username/schoolsuite
```

### **4.3 Install Composer Dependencies**

```bash
# Check if Composer is installed
composer --version

# If not found, download Composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# Install dependencies
php composer.phar install --no-dev --optimize-autoloader --no-interaction

# OR if composer is in PATH
composer install --no-dev --optimize-autoloader --no-interaction
```

**Expected output:**
```
Installing dependencies from lock file
Generating optimized autoload files
```

### **4.4 Set File Permissions**

```bash
cd /home/username/schoolsuite

# Laravel requires write access to storage and bootstrap/cache
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Secure .env file (read-only for owner)
chmod 600 .env

# Verify permissions
ls -la storage/
ls -la bootstrap/cache/
```

### **4.5 Generate Application Key**

```bash
php artisan key:generate --force
```

**Output:**
```
Application key set successfully.
```

**Verify in .env:**
```bash
grep APP_KEY .env
# Should show: APP_KEY=base64:randomstring...
```

---

## 🔗 STEP 5: CREATE STORAGE SYMLINK

**Critical:** Laravel's storage needs to be publicly accessible for uploads (photos, receipts, etc.)

### **5.1 Understand Symlink**

```
/home/username/schoolsuite/storage/app/public/
    ↓ (symlink)
/home/username/domains/yourdomain.com/public_html/storage/
```

### **5.2 Create Symlink Manually**

```bash
# Navigate to public_html
cd /home/username/domains/yourdomain.com/public_html

# Remove old symlink if exists
rm -f storage

# Create new symlink (USE ABSOLUTE PATHS!)
ln -sf /home/username/schoolsuite/storage/app/public storage

# Verify symlink
ls -la storage
# Output: storage -> /home/username/schoolsuite/storage/app/public
```

### **5.3 Alternative: Use Artisan Command (May Not Work on Shared Hosting)**

```bash
cd /home/username/schoolsuite
php artisan storage:link
```

**If this fails**, use manual method above.

### **5.4 Test Symlink**

```bash
# Create test file in storage
echo "Symlink test" > /home/username/schoolsuite/storage/app/public/test.txt

# Try accessing via browser
# Visit: https://yourdomain.com/storage/test.txt
# Should display: "Symlink test"
```

---

## 🌐 STEP 6: POINT DOMAIN TO LARAVEL

### **Method 1: Symlink public_html to Laravel public/ (RECOMMENDED)**

```bash
# Backup existing public_html
cd /home/username/domains/yourdomain.com
mv public_html public_html.backup

# Create symlink
ln -sf /home/username/schoolsuite/public public_html

# Verify
ls -la public_html
# Output: public_html -> /home/username/schoolsuite/public
```

**After this:**
- Your domain → `/home/username/schoolsuite/public/`
- All Laravel routes work correctly

---

### **Method 2: Copy Files to public_html (Alternative)**

**Only use if Method 1 doesn't work!**

```bash
# Delete public_html contents
rm -rf /home/username/domains/yourdomain.com/public_html/*

# Copy Laravel public folder contents
cp -R /home/username/schoolsuite/public/* /home/username/domains/yourdomain.com/public_html/

# Update index.php to point to Laravel
nano /home/username/domains/yourdomain.com/public_html/index.php
```

**Edit `index.php` line 17-18:**

```php
// Old:
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// New:
require '/home/username/schoolsuite/vendor/autoload.php';
$app = require_once '/home/username/schoolsuite/bootstrap/app.php';
```

**This method requires updating index.php after every deployment!**

---

## 🛡️ STEP 7: SECURITY HARDENING

### **7.1 Install Production .htaccess**

```bash
cd /home/username/domains/yourdomain.com/public_html

# Copy production .htaccess
cp /home/username/schoolsuite/public/.htaccess.production .htaccess

# Verify
cat .htaccess | head -20
```

### **7.2 Protect Laravel App Directory**

```bash
cd /home/username/schoolsuite

# Copy root .htaccess (denies web access to app files)
cp .htaccess.root .htaccess

# Verify
ls -la .htaccess
```

### **7.3 Verify .env is Secure**

```bash
chmod 600 /home/username/schoolsuite/.env

# Verify cannot be accessed via web
# Try: https://yourdomain.com/../../../schoolsuite/.env
# Should return 403 Forbidden
```

### **7.4 Disable Directory Listing**

Already included in `.htaccess.production`:

```apache
Options -Indexes
```

---

## 🗄️ STEP 8: RUN DATABASE MIGRATIONS

### **8.1 Test Database Connection**

```bash
cd /home/username/schoolsuite

# Test connection
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit;
```

**Success:** Returns PDO object
**Error:** Check `.env` database credentials

### **8.2 Run Migrations**

```bash
# Run migrations (creates all tables)
php artisan migrate --force

# Seed initial data (schools, admin user)
php artisan db:seed --force
```

**Output:**
```
Running migrations...
Migration: 2024_01_01_000000_create_schools_table ........ DONE
Migration: 2024_01_02_000000_create_users_table .......... DONE
...
Seeding: DatabaseSeeder
Seeded:  DatabaseSeeder (XX.XXms)
```

### **8.3 Verify Data**

```bash
# Check tables created
php artisan tinker
>>> \App\Models\School::count();
>>> \App\Models\User::count();
>>> exit;
```

---

## ⚡ STEP 9: OPTIMIZE FOR PRODUCTION

### **9.1 Cache Configuration**

```bash
cd /home/username/schoolsuite

# Clear old cache
php artisan optimize:clear

# Cache config, routes, views
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Verify cache files created
ls -la bootstrap/cache/
# Should see: config.php, routes-v7.php, etc.
```

**Note:** After changing `.env` or config files, re-run:
```bash
php artisan config:cache
```

### **9.2 Optimize Composer Autoload**

```bash
composer dump-autoload --optimize --no-dev
```

---

## 🔒 STEP 10: ENABLE SSL (HTTPS)

### **10.1 Install Free Let's Encrypt SSL**

1. Go to **Hostinger hPanel**
2. Navigate to **SSL → Manage SSL**
3. Select your domain
4. Click **Install Free SSL** (Let's Encrypt)
5. Wait 10-15 minutes for activation

### **10.2 Force HTTPS**

Already configured in `.htaccess.production`:

```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### **10.3 Update .env**

```bash
nano /home/username/schoolsuite/.env
```

Change:
```dotenv
APP_URL=https://yourdomain.com  # Add https://
SESSION_SECURE_COOKIE=true
```

Recache config:
```bash
php artisan config:cache
```

---

## 🎯 STEP 11: FINAL CHECKS

### **11.1 Verify Website is Live**

Visit: `https://yourdomain.com`

**Expected:** SchoolSuite homepage with proper styling

**If broken CSS/JS:**
- Check `/public/build/` folder exists
- Run `npm run build` locally and re-upload

### **11.2 Test Admin Login**

1. Visit: `https://yourdomain.com/login`
2. Login with seeded credentials:
   ```
   Email: admin@schoolsuite.com
   Password: password
   ```
3. You should see admin dashboard

### **11.3 Test File Uploads**

1. Login to admin
2. Try uploading a student photo
3. Verify image displays correctly

**If images don't show:**
- Check storage symlink: `ls -la /home/username/domains/yourdomain.com/public_html/storage`
- Recreate symlink (see Step 5)

### **11.4 Check Logs for Errors**

```bash
# View recent errors
tail -n 50 /home/username/schoolsuite/storage/logs/laravel.log

# Monitor live (Ctrl+C to stop)
tail -f /home/username/schoolsuite/storage/logs/laravel.log
```

### **11.5 Test Key Features**

- [ ] Homepage loads
- [ ] Admin login works
- [ ] Student CRUD operations
- [ ] Fee receipt generation
- [ ] Image uploads work
- [ ] PDF downloads work
- [ ] Email sending (if configured)

---

## 🔄 UPDATING THE APPLICATION

### **For Future Deployments:**

**Option A: Manual Update via FTP**

1. Backup database (export from phpMyAdmin)
2. Backup `.env` file
3. Upload new files via FTP
4. SSH into server:
   ```bash
   cd /home/username/schoolsuite
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

**Option B: Git Pull (if using Git)**

```bash
ssh username@yourdomain.com
cd /home/username/schoolsuite

# Stash local changes
git stash

# Pull latest code
git pull origin main

# Restore .env
git stash pop

# Update dependencies & optimize
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Option C: Use Deployment Script**

```bash
cd /home/username/schoolsuite
chmod +x deploy.sh
./deploy.sh
```

---

## 🐛 TROUBLESHOOTING

### **Problem: "500 Internal Server Error"**

**Fix:**
```bash
# Check PHP version
php -v  # Should be 8.2+

# Check logs
tail -50 /home/username/schoolsuite/storage/logs/laravel.log

# Check Apache error log
tail -50 ~/logs/error_log

# Fix permissions
chmod -R 755 /home/username/schoolsuite/storage
chmod -R 755 /home/username/schoolsuite/bootstrap/cache

# Clear & recache
php artisan optimize:clear
php artisan config:cache
```

---

### **Problem: "Symlink Not Working" (storage/images not loading)**

**Fix:**
```bash
# Remove old symlink
rm -f /home/username/domains/yourdomain.com/public_html/storage

# Recreate with ABSOLUTE path
ln -sf /home/username/schoolsuite/storage/app/public /home/username/domains/yourdomain.com/public_html/storage

# Verify
ls -la /home/username/domains/yourdomain.com/public_html/storage

# Test
echo "test" > /home/username/schoolsuite/storage/app/public/test.txt
# Visit: https://yourdomain.com/storage/test.txt
```

---

### **Problem: "CSS/JS Not Loading"**

**Fix:**
```bash
# On LOCAL machine (not server!):
npm run build

# Upload /public/build/ folder to server via FTP

# Clear cache on server:
php artisan view:clear
```

---

### **Problem: "Database Connection Failed"**

**Fix:**
```bash
# Verify database credentials
cat /home/username/schoolsuite/.env | grep DB_

# Test connection
php artisan tinker
>>> DB::connection()->getPdo();

# If fails, check:
# 1. Database exists in hPanel
# 2. Username/password correct
# 3. DB_HOST=localhost (not 127.0.0.1)
```

---

### **Problem: "Permission Denied" Errors**

**Fix:**
```bash
# Fix storage permissions
chmod -R 755 /home/username/schoolsuite/storage
chmod -R 755 /home/username/schoolsuite/bootstrap/cache

# If still fails, try 775
chmod -R 775 /home/username/schoolsuite/storage
```

---

### **Problem: "APP_KEY Not Set"**

**Fix:**
```bash
cd /home/username/schoolsuite
php artisan key:generate --force
php artisan config:cache
```

---

## 📝 POST-DEPLOYMENT CHECKLIST

### **Security:**
- [ ] APP_DEBUG=false in .env
- [ ] APP_ENV=production in .env
- [ ] Strong database password
- [ ] .env file chmod 600
- [ ] SSL certificate installed
- [ ] Force HTTPS enabled
- [ ] Storage symlink working

### **Performance:**
- [ ] Config cached (`php artisan config:cache`)
- [ ] Routes cached (`php artisan route:cache`)
- [ ] Views cached (`php artisan view:cache`)
- [ ] Composer optimized (`--optimize-autoloader --no-dev`)

### **Functionality:**
- [ ] Homepage loads correctly
- [ ] Admin login works
- [ ] Database migrations completed
- [ ] File uploads working
- [ ] PDF generation working
- [ ] Email sending configured

### **Monitoring:**
- [ ] Check logs regularly: `tail -f storage/logs/laravel.log`
- [ ] Set up backups (database + files)
- [ ] Monitor disk space usage

---

## 📞 SUPPORT

### **Hostinger Support:**
- Live Chat: Available 24/7 in hPanel
- Knowledge Base: https://support.hostinger.com

### **Laravel Documentation:**
- Deployment: https://laravel.com/docs/12.x/deployment

### **SchoolSuite Issues:**
- Check logs: `/home/username/schoolsuite/storage/logs/laravel.log`
- Enable debug mode temporarily (only for troubleshooting):
  ```bash
  nano .env
  # Change: APP_DEBUG=true
  php artisan config:cache
  # REMEMBER to set back to false!
  ```

---

## ✅ DEPLOYMENT COMPLETE!

Your SchoolSuite application is now live at:
**https://yourdomain.com**

Default admin credentials:
```
Email: admin@schoolsuite.com
Password: password
```

**⚠️ IMPORTANT:** Change the default admin password immediately!

---

## 📊 MAINTENANCE

### **Regular Tasks:**

**Weekly:**
- Check error logs
- Monitor disk space

**Monthly:**
- Backup database
- Update dependencies: `composer update`
- Check for Laravel updates

**As Needed:**
- Update .env settings
- Run new migrations
- Clear cache after config changes

---

**End of Deployment Guide** 🚀
