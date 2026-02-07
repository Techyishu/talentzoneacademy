# SchoolSuite

A comprehensive multi-tenant school management system (ERP) built with Laravel 12. Designed for managing multiple schools with role-based access control, student/staff management, fee receipts, and a public website CMS.

![Laravel](https://img.shields.io/badge/Laravel-12.49.0-red)
![PHP](https://img.shields.io/badge/PHP-8.5.0-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## Features

### 🏫 Multi-School Management
- Single-database multi-tenancy with school_id scoping
- Automatic data isolation per school
- Super admin can manage all schools
- School admins limited to assigned school
- Easy school switching for super admins

### 👥 Student Management
- Complete CRUD operations
- Photo upload with automatic resizing (400x400)
- CSV import/export
- Search and filter capabilities
- Unique admission numbers per school
- Guardian information tracking

### 👨‍🏫 Staff Management
- Staff member CRUD operations
- Photo management
- CSV import/export
- Designation and employment status tracking
- Salary information
- Unique staff codes per school

### 💰 Fee Receipts
- Auto-generated receipt numbers (PREFIX-YYYYMM-XXXX)
- PDF generation with school branding
- Receipt cancellation with audit trail
- Multiple payment modes support
- Receipt export functionality
- School logo and signature on PDFs

### 🖼️ Gallery Management
- Multi-file image upload (up to 10 at once)
- Automatic image optimization
- Thumbnail generation (400x400)
- Category organization
- Drag-drop upload interface
- Display order management

### 📄 CMS - Content Management
- Custom page creation with slug generation
- Draft/Published status system
- Rich text content support
- SEO meta descriptions
- Contact form submission management
- Read/Unread tracking for submissions

### 🎨 Branding System
- Custom school logos
- Primary and secondary color configuration
- Signature images for receipts
- Consistent branding across all documents

### 🔔 UX Polish
- Toast notifications (success, error, warning, info)
- Custom error pages (404, 403, 500, 503)
- Loading states for async operations
- Responsive design (mobile-friendly)
- Beautiful glass morphism UI

## Technology Stack

- **Framework:** Laravel 12.49.0
- **PHP:** 8.5.0
- **Database:** MySQL
- **Authentication:** Laravel Breeze
- **Frontend:** Tailwind CSS 3.1.0, Alpine.js 3.4.2
- **PDF Generation:** DomPDF
- **Image Processing:** Intervention Image
- **Build Tool:** Vite 7.0.7

## Installation

### Prerequisites

- PHP 8.5 or higher
- Composer
- Node.js & NPM
- MySQL 8.0 or higher

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd schoolsuite
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=schoolsuite
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

6. **Create database**
   ```bash
   mysql -uroot -p -e "CREATE DATABASE schoolsuite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   ```

7. **Run migrations and seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

8. **Link storage**
   ```bash
   php artisan storage:link
   ```

9. **Build assets**
   ```bash
   npm run build
   # Or for development with hot reload:
   npm run dev
   ```

10. **Start the server**
    ```bash
    php artisan serve
    ```

Visit `http://localhost:8000` to access the application.

## Test Credentials

After running the seeder, use these credentials:

### Super Admin (Full System Access)
- **Email:** admin@schoolsuite.com
- **Password:** password
- **Access:** All schools, Schools Management

### School Admins (School-Specific Access)
- **Green Valley School**
  - Email: admin@sch001.com
  - Password: password

- **Sunshine Academy**
  - Email: admin@sch002.com
  - Password: password

- **Royal Public School**
  - Email: admin@sch003.com
  - Password: password

## Usage Guide

### For Super Admins

1. **Managing Schools**
   - Navigate to Admin → Schools
   - Create/Edit/Delete schools
   - Upload school logos and signatures
   - Set branding colors
   - Configure receipt prefixes

2. **Switching Schools**
   - Use the school dropdown in the header
   - All data automatically scopes to selected school

### For School Admins

1. **Student Management**
   - Add students manually or via CSV import
   - Upload student photos
   - Export student data

2. **Staff Management**
   - Manage staff members
   - Track employment details
   - Import/Export staff data

3. **Fee Receipts**
   - Generate fee receipts
   - Print branded PDFs
   - Cancel receipts with audit trail

4. **Gallery**
   - Upload event photos
   - Organize by categories
   - Manage display order

5. **CMS**
   - Create custom pages
   - Manage contact submissions
   - Publish/Unpublish content

## Project Structure

```
schoolsuite/
├── app/
│   ├── Http/
│   │   ├── Controllers/Admin/    # Admin controllers
│   │   ├── Middleware/           # Custom middleware
│   │   └── Requests/             # Form requests
│   ├── Models/                   # Eloquent models
│   │   └── Concerns/             # BelongsToSchool trait
│   └── Services/                 # Business logic services
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── public/
│   └── uploads/                  # User uploads
├── resources/
│   ├── css/                      # Tailwind CSS
│   ├── js/                       # Alpine.js
│   └── views/
│       ├── admin/                # Admin panel views
│       ├── components/           # Blade components
│       ├── errors/               # Custom error pages
│       └── public/               # Public website
├── routes/
│   └── web.php                   # Route definitions
├── CLAUDE.md                     # Development guidelines
├── TESTING.md                    # Testing checklist
├── FEATURES.md                   # Complete feature list
└── prd.md                        # Product requirements
```

## Key Concepts

### Multi-Tenancy Architecture

SchoolSuite uses **single-database multi-tenancy** with automatic query scoping:

- All school-specific models use the `BelongsToSchool` trait
- Global scopes automatically filter queries by `school_id`
- Creating records auto-sets the active school
- Super admins bypass scoping restrictions

### Receipt Number Generation

Receipt numbers follow the format: `PREFIX-YYYYMM-XXXX`

- PREFIX: Configured per school (e.g., RCP, FEE)
- YYYYMM: Year and month
- XXXX: Sequential 4-digit number

Atomic transactions ensure no duplicate numbers.

### Image Processing

All uploaded images are automatically optimized:

- **Student/Staff photos:** Resized to 400x400 (square crop)
- **School logos:** Max width 400px (aspect ratio maintained)
- **Gallery images:** Max width 1200px + 400x400 thumbnail
- **Signatures:** Max width 300px

## Development

### Running Tests

```bash
php artisan test
```

### Code Formatting

```bash
./vendor/bin/pint
```

### Clear Caches

```bash
php artisan optimize:clear
```

### Database Reset

```bash
php artisan migrate:fresh --seed
```

## Deployment (Hostinger)

1. **Upload files** to public_html
2. **Point domain** to `/public` directory
3. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with production values
   ```

4. **Run migrations**
   ```bash
   php artisan migrate --force
   ```

5. **Optimize for production**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan storage:link
   ```

6. **Set permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

## Security

- CSRF protection on all forms
- Password hashing with bcrypt
- File upload validation
- SQL injection protection
- XSS prevention
- Role-based authorization
- School data isolation

## Support

For issues and questions:
- Check [TESTING.md](TESTING.md) for testing guidelines
- Check [FEATURES.md](FEATURES.md) for complete feature list
- Review [CLAUDE.md](CLAUDE.md) for development notes
- See [prd.md](prd.md) for detailed requirements

## License

This project is open-sourced software licensed under the MIT license.

## Credits

Built with Laravel 12 and modern web technologies for efficient school management.

---

**Version:** 1.0.0
**Last Updated:** February 2026
