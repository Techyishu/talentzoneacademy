#!/bin/bash
# ========================================
# SchoolSuite Hostinger Deployment Script
# ========================================

set -e  # Exit on error

echo "🚀 Starting SchoolSuite deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
DEPLOY_PATH="/home/username/schoolsuite"  # Change 'username' to your Hostinger username
PUBLIC_HTML="/home/username/domains/yourdomain.com/public_html"  # Change to your domain
BACKUP_PATH="/home/username/backups"

echo -e "${YELLOW}📋 Deployment Configuration:${NC}"
echo "   Deploy Path: $DEPLOY_PATH"
echo "   Public HTML: $PUBLIC_HTML"
echo ""

# ========================================
# 1. BACKUP EXISTING INSTALLATION
# ========================================
if [ -d "$DEPLOY_PATH" ]; then
    echo -e "${YELLOW}📦 Creating backup...${NC}"
    BACKUP_NAME="schoolsuite-backup-$(date +%Y%m%d-%H%M%S)"
    mkdir -p "$BACKUP_PATH"

    # Backup .env file
    if [ -f "$DEPLOY_PATH/.env" ]; then
        cp "$DEPLOY_PATH/.env" "$BACKUP_PATH/$BACKUP_NAME.env"
        echo "   ✅ Backed up .env file"
    fi

    # Backup database (optional)
    # mysqldump -u DB_USER -p DB_NAME > "$BACKUP_PATH/$BACKUP_NAME.sql"

    echo -e "${GREEN}   ✅ Backup completed${NC}"
fi

# ========================================
# 2. INSTALL DEPENDENCIES
# ========================================
echo -e "${YELLOW}📦 Installing Composer dependencies...${NC}"
cd "$DEPLOY_PATH"

# Use Hostinger's Composer (usually in /usr/local/bin/composer or /opt/alt/php82/usr/bin/composer)
# Or download composer.phar if not available
if command -v composer &> /dev/null; then
    composer install --no-dev --optimize-autoloader --no-interaction
else
    echo "   ℹ️  Composer not found, using composer.phar"
    php composer.phar install --no-dev --optimize-autoloader --no-interaction
fi

echo -e "${GREEN}   ✅ Dependencies installed${NC}"

# ========================================
# 3. ENVIRONMENT SETUP
# ========================================
echo -e "${YELLOW}⚙️  Setting up environment...${NC}"

if [ ! -f "$DEPLOY_PATH/.env" ]; then
    echo -e "${RED}   ❌ .env file not found! Please create it manually.${NC}"
    exit 1
fi

# Generate APP_KEY if not set
if ! grep -q "APP_KEY=base64:" "$DEPLOY_PATH/.env"; then
    echo "   Generating APP_KEY..."
    php artisan key:generate --force
fi

echo -e "${GREEN}   ✅ Environment configured${NC}"

# ========================================
# 4. DATABASE MIGRATION
# ========================================
echo -e "${YELLOW}🗄️  Running database migrations...${NC}"

read -p "   Run migrations? (yes/no): " RUN_MIGRATIONS
if [ "$RUN_MIGRATIONS" = "yes" ]; then
    php artisan migrate --force
    echo -e "${GREEN}   ✅ Migrations completed${NC}"
else
    echo "   ⏭️  Skipped migrations"
fi

# ========================================
# 5. STORAGE SYMLINK
# ========================================
echo -e "${YELLOW}🔗 Creating storage symlink...${NC}"

# Remove old symlink if exists
if [ -L "$PUBLIC_HTML/storage" ]; then
    rm "$PUBLIC_HTML/storage"
    echo "   Removed old symlink"
fi

# Create new symlink
ln -sf "$DEPLOY_PATH/storage/app/public" "$PUBLIC_HTML/storage"

if [ -L "$PUBLIC_HTML/storage" ]; then
    echo -e "${GREEN}   ✅ Storage symlink created: $PUBLIC_HTML/storage -> $DEPLOY_PATH/storage/app/public${NC}"
else
    echo -e "${RED}   ❌ Failed to create storage symlink${NC}"
fi

# ========================================
# 6. FILE PERMISSIONS
# ========================================
echo -e "${YELLOW}🔒 Setting file permissions...${NC}"

# Laravel requires write access to storage and cache
chmod -R 755 "$DEPLOY_PATH/storage"
chmod -R 755 "$DEPLOY_PATH/bootstrap/cache"

# Make .env readable only by owner (security)
chmod 600 "$DEPLOY_PATH/.env"

echo -e "${GREEN}   ✅ Permissions set${NC}"

# ========================================
# 7. OPTIMIZE FOR PRODUCTION
# ========================================
echo -e "${YELLOW}⚡ Optimizing for production...${NC}"

# Clear old cache
php artisan optimize:clear

# Cache config, routes, views
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo -e "${GREEN}   ✅ Optimization complete${NC}"

# ========================================
# 8. COPY .htaccess FILES
# ========================================
echo -e "${YELLOW}🔐 Installing security .htaccess files...${NC}"

# Copy production .htaccess to public_html
if [ -f "$DEPLOY_PATH/public/.htaccess.production" ]; then
    cp "$DEPLOY_PATH/public/.htaccess.production" "$PUBLIC_HTML/.htaccess"
    echo "   ✅ Production .htaccess installed in public_html"
fi

# Copy root .htaccess to Laravel app directory (prevent direct access)
if [ -f "$DEPLOY_PATH/.htaccess.root" ]; then
    cp "$DEPLOY_PATH/.htaccess.root" "$DEPLOY_PATH/.htaccess"
    echo "   ✅ Root .htaccess installed (prevents direct access to app)"
fi

echo -e "${GREEN}   ✅ Security files installed${NC}"

# ========================================
# 9. FINAL CHECKS
# ========================================
echo -e "${YELLOW}🔍 Running final checks...${NC}"

# Check if .env exists
if [ -f "$DEPLOY_PATH/.env" ]; then
    echo "   ✅ .env file exists"
else
    echo -e "${RED}   ❌ .env file missing${NC}"
fi

# Check if APP_KEY is set
if grep -q "APP_KEY=base64:" "$DEPLOY_PATH/.env"; then
    echo "   ✅ APP_KEY is set"
else
    echo -e "${RED}   ❌ APP_KEY not set${NC}"
fi

# Check if APP_DEBUG is false
if grep -q "APP_DEBUG=false" "$DEPLOY_PATH/.env"; then
    echo "   ✅ APP_DEBUG is false (production mode)"
else
    echo -e "${YELLOW}   ⚠️  Warning: APP_DEBUG is not set to false${NC}"
fi

# Check storage symlink
if [ -L "$PUBLIC_HTML/storage" ]; then
    echo "   ✅ Storage symlink exists"
else
    echo -e "${RED}   ❌ Storage symlink missing${NC}"
fi

# ========================================
# DEPLOYMENT COMPLETE
# ========================================
echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}✅ DEPLOYMENT SUCCESSFUL!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "${YELLOW}📝 Post-Deployment Tasks:${NC}"
echo "   1. Test the website: https://yourdomain.com"
echo "   2. Login to admin panel"
echo "   3. Check logs: tail -f $DEPLOY_PATH/storage/logs/laravel.log"
echo "   4. Monitor for errors"
echo ""
echo -e "${YELLOW}📍 Important Paths:${NC}"
echo "   App: $DEPLOY_PATH"
echo "   Public: $PUBLIC_HTML"
echo "   Logs: $DEPLOY_PATH/storage/logs/"
echo ""
