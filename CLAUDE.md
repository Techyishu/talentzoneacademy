# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**SchoolSuite** is a Laravel 12-based multi-tenant school management system (ERP) designed for managing multiple schools (3 schools initially) with role-based access control. The system includes:
- Multi-school management with tenant isolation
- Student/Staff/Fees management
- ID card and receipt PDF generation
- Public website CMS per school
- Gallery management

**Deployment Target**: Hostinger shared hosting (MySQL + PHP)

## Multi-Tenancy Architecture

**CRITICAL**: This project uses a **single-database multi-tenancy** approach with `school_id` foreign keys, NOT separate databases per tenant. This is simpler for 3 schools and easier to deploy on shared hosting.

### How Tenancy Works

1. **BelongsToSchool Trait** ([app/Models/Concerns/BelongsToSchool.php](app/Models/Concerns/BelongsToSchool.php))
   - Automatically scopes all queries to the active school
   - Auto-sets `school_id` when creating records
   - Only applies scoping if user is NOT a super admin
   - All school-specific models (Student, Staff, FeeReceipt, GalleryImage, Page) use this trait

2. **Active School Context**
   - Stored in session as `active_school_id`
   - Set automatically by `SetSchoolContext` middleware
   - Super admins can switch between schools
   - School admins are locked to their assigned school

3. **Critical Security Rule**: Always ensure queries are properly scoped. The global scope handles this automatically, but when using `withoutGlobalScope()` or raw queries, manually filter by `school_id`.

## Authentication & Roles

Two user roles defined in `users.role` enum:
- **super_admin**: Can access all schools, switch contexts, manage schools
- **school_admin**: Limited to their assigned school (users.school_id)

Helper methods on User model:
- `isSuperAdmin()`: Check if user is super admin
- `isSchoolAdmin()`: Check if user is school admin

### Middleware

Registered in [bootstrap/app.php](bootstrap/app.php):
- `super_admin`: Ensures user is super admin
- `school_admin`: Ensures authenticated user with school context
- `set_school`: Auto-sets school context (applied to all web routes)

## Database Schema

All school-specific tables have:
- `school_id` foreign key (with cascade on delete)
- Unique constraints scoped per school (e.g., `admission_no` unique per school, not globally)

Key tables:
- **schools**: Multi-tenant root with branding (logo, colors, receipt_prefix)
- **users**: role + school_id (nullable for super_admin)
- **students**: admission_no unique per school
- **staff**: staff_code unique per school
- **fee_receipts**: receipt_no unique per school, with cancellation audit trail
- **gallery_images**: For public website galleries
- **pages**: CMS content (slug unique per school)

## Development Commands

### Initial Setup
```bash
# Create database
mysql -uroot -e "CREATE DATABASE schoolsuite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations and seed test data
php artisan migrate:fresh --seed

# Start development server
php artisan serve
```

### Database Management
```bash
# Reset database with fresh test data
php artisan migrate:fresh --seed

# Run migrations only
php artisan migrate

# Create new migration
php artisan make:migration create_table_name

# Create model with migration
php artisan make:model ModelName -m
```

### Code Generation
```bash
# Create controller
php artisan make:controller Admin/StudentController --resource

# Create middleware
php artisan make:middleware MiddlewareName

# Create seeder
php artisan make:seeder TableNameSeeder
```

### Testing & Maintenance
```bash
# Run tests
php artisan test

# Clear all caches
php artisan optimize:clear

# Code formatting (Laravel Pint)
./vendor/bin/pint
```

## Test Credentials

After running `php artisan migrate:fresh --seed`:

**Super Admin** (can manage all schools):
- Email: `admin@talentzoneacademy.com`
- Password: `password`

**School Admins** (one per school):
- Talent Zone Academy Karnal: `admin@tak.com` / `password`
- Talent Zone Academy Kurukshetra: `admin@takk.com` / `password`

## Key Packages & Purpose

- **laravel/breeze**: Simple authentication scaffolding (Blade templates)
- **barryvdh/laravel-dompdf**: PDF generation for receipts and ID cards
- **intervention/image-laravel**: Image processing for uploads and ID card photos
- **maatwebsite/excel**: CSV import/export for students/staff data

## File Uploads

Upload directories in `public/uploads/`:
- `logos/` - School logos
- `gallery/` - Gallery images for public website
- `student-photos/` - Student photos for ID cards
- `staff-photos/` - Staff photos
- `signatures/` - School signature images for receipts

## Important Implementation Notes

### When Creating Controllers

1. Always use the `school_admin` middleware for school-specific routes
2. Don't manually filter by `school_id` - the BelongsToSchool trait handles this automatically
3. For super admin routes, use `super_admin` middleware

Example:
```php
Route::middleware(['auth', 'school_admin'])->group(function () {
    Route::resource('students', StudentController::class);
    // Queries automatically scoped to active school
});
```

### When Generating Receipts/PDFs

- Use school branding: `logo`, `primary_color`, `signature_image`
- Receipt numbers use school's `receipt_prefix` + sequential number
- Check for existing receipt numbers within the same school

### When Switching School Context

Super admins can switch schools by updating `session('active_school_id')`. Create a dropdown in the admin layout that POSTs to a school-switcher route.

## Project Status

**Current Milestone**: M1 Complete ✅
- ✅ Laravel setup with authentication
- ✅ Multi-tenancy with school switching
- ✅ Database migrations for all tables
- ✅ Models with tenant scoping
- ✅ Middleware for role-based access
- ✅ Test data seeded

**Remaining Work**:
- M2: Student/Staff CRUD with CSV import/export
- M3: Fee receipts with PDF generation
- M4: ID card PDF generation (single + bulk)
- M5: Public website CMS and gallery
- M6: Hostinger deployment + backups

## Deployment Notes (Hostinger)

When deploying to Hostinger:
1. Point domain to `public/` directory (Laravel public folder)
2. Update `.env` with production database credentials
3. Run `php artisan migrate --force` on production
4. Set proper permissions: 755 for directories, 644 for files
5. Storage and cache directories need write permissions
6. Enable production optimizations:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## See Also

- [prd.md](prd.md) - Complete product requirements document with all modules and milestones
