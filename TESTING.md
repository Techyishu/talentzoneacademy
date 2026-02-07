# SchoolSuite Testing Checklist

This document provides a comprehensive testing checklist for all features in SchoolSuite.

## Prerequisites

- [ ] Database seeded with test data (`php artisan migrate:fresh --seed`)
- [ ] Storage linked (`php artisan storage:link`)
- [ ] Test credentials available (see CLAUDE.md)

## Authentication & Authorization

### Login System
- [ ] Super admin can log in (`admin@schoolsuite.com`)
- [ ] School admin can log in (`admin@sch001.com`)
- [ ] Invalid credentials show error
- [ ] Password reset functionality works
- [ ] Logout works correctly

### Authorization
- [ ] Super admin can access all schools
- [ ] Super admin can access Schools Management
- [ ] School admin cannot access Schools Management
- [ ] School admin is locked to their assigned school
- [ ] Unauthorized access shows 403 error page

## Super Admin Features

### School Management
- [ ] View all schools in grid layout
- [ ] See school stats (students, staff, users)
- [ ] Create new school with logo upload
- [ ] Upload school signature for receipts
- [ ] Set primary and secondary colors
- [ ] Edit school information
- [ ] View school details page
- [ ] Delete school (with confirmation)
- [ ] School code validation (uppercase only)
- [ ] Receipt prefix validation

### School Switching
- [ ] Super admin sees school switcher dropdown
- [ ] Can switch between schools
- [ ] Data scopes correctly after switch
- [ ] Active school persists across pages

## Student Management

### CRUD Operations
- [ ] View students list with pagination
- [ ] Search students by name, admission no, or guardian
- [ ] Filter by class, section, and status
- [ ] Create new student with photo upload
- [ ] Photo resizes to 400x400 automatically
- [ ] Edit student information
- [ ] View student profile
- [ ] Delete student (with confirmation)
- [ ] Admission number unique per school

### CSV Import/Export
- [ ] Download CSV template
- [ ] Import students from CSV
- [ ] See import summary (success/failed)
- [ ] Export students to CSV
- [ ] Import validates data correctly
- [ ] Failed rows show error messages

## Staff Management

### CRUD Operations
- [ ] View staff list with pagination
- [ ] Search staff by name, code, or phone
- [ ] Filter by designation and status
- [ ] Create new staff member with photo
- [ ] Photo resizes correctly
- [ ] Edit staff information
- [ ] View staff profile
- [ ] Delete staff (with confirmation)
- [ ] Staff code unique per school

### CSV Import/Export
- [ ] Download CSV template
- [ ] Import staff from CSV
- [ ] See import summary
- [ ] Export staff to CSV
- [ ] Validation works correctly

## Fee Receipts Management

### Receipt Operations
- [ ] View receipts list with filters
- [ ] See summary stats (total receipts, total collected)
- [ ] Create new receipt
- [ ] Auto-generate receipt number (PREFIX-YYYYMM-XXXX)
- [ ] Receipt numbers are sequential
- [ ] No duplicate receipt numbers (atomic transaction)
- [ ] View receipt details
- [ ] Generate PDF with school branding
- [ ] Download PDF receipt
- [ ] Cancel receipt (with audit trail)
- [ ] Cancelled receipts show watermark
- [ ] Export receipts to CSV

### PDF Generation
- [ ] PDF shows school logo
- [ ] PDF uses school primary color
- [ ] PDF shows signature image
- [ ] PDF shows correct receipt details
- [ ] PDF shows student information
- [ ] "CANCELLED" watermark on cancelled receipts

## Gallery Management

### Image Operations
- [ ] View gallery images in grid
- [ ] Filter by category
- [ ] Search by title
- [ ] Upload multiple images (up to 10)
- [ ] Images resize to max 1200px width
- [ ] Thumbnails generate (400x400)
- [ ] Drag-drop upload works
- [ ] Preview images before upload
- [ ] Edit image metadata
- [ ] Change display order
- [ ] Delete image (with confirmation)
- [ ] Images organized by school code

## CMS - Pages Management

### Page Operations
- [ ] View pages list
- [ ] Filter by status (draft/published)
- [ ] Search by title or slug
- [ ] Create new page
- [ ] Auto-generate slug from title
- [ ] Manual slug override works
- [ ] Edit page content
- [ ] View page preview
- [ ] Toggle draft/published status
- [ ] Delete page (with confirmation)
- [ ] Meta description character counter (160 max)
- [ ] Slug validation (lowercase, hyphens only)

## CMS - Contact Submissions

### Submission Management
- [ ] View submissions inbox
- [ ] See unread count badge
- [ ] Filter by read/unread status
- [ ] Search by name, email, or subject
- [ ] Unread messages highlighted
- [ ] View submission details
- [ ] Auto-mark as read when viewing
- [ ] Reply via email link works
- [ ] Call phone number link works (if provided)
- [ ] Delete submission
- [ ] Bulk delete (if implemented)

## UI/UX Features

### Toast Notifications
- [ ] Success notifications appear (green)
- [ ] Error notifications appear (red)
- [ ] Warning notifications appear (amber)
- [ ] Info notifications appear (blue)
- [ ] Auto-dismiss after 5 seconds
- [ ] Manual close button works
- [ ] Validation errors display
- [ ] Smooth animations

### Error Pages
- [ ] 404 page displays for missing pages
- [ ] 403 page displays for unauthorized access
- [ ] 500 page displays for server errors
- [ ] 503 page displays in maintenance mode
- [ ] All error pages have "Go Back" button
- [ ] All error pages have "Home" button

### Loading States
- [ ] Form submission shows loading state
- [ ] Buttons disable during loading
- [ ] Loading spinner appears
- [ ] Loading text displays

### General UI
- [ ] Responsive on mobile devices
- [ ] Sidebar collapses on mobile
- [ ] Mobile menu works
- [ ] Empty states show helpful messages
- [ ] Pagination works correctly
- [ ] Forms validate properly
- [ ] Color pickers work in school branding

## Multi-Tenancy

### Data Isolation
- [ ] Each school sees only their own students
- [ ] Each school sees only their own staff
- [ ] Each school sees only their own receipts
- [ ] Each school sees only their own gallery
- [ ] Each school sees only their own pages
- [ ] Each school sees only their own submissions

### School Scoping
- [ ] BelongsToSchool trait works on all models
- [ ] Global scopes apply automatically
- [ ] Creating records auto-sets school_id
- [ ] Editing records maintains school_id
- [ ] Deleting school cascades to all data

## Performance & Security

### Performance
- [ ] Pages load in reasonable time
- [ ] Images are optimized
- [ ] Pagination prevents large data loads
- [ ] Database queries are efficient

### Security
- [ ] CSRF protection works
- [ ] File upload validation works
- [ ] File size limits enforced (images)
- [ ] XSS protection in place
- [ ] SQL injection protection
- [ ] Authorization checks on all routes
- [ ] No sensitive data in URLs
- [ ] Passwords are hashed

## Browser Compatibility

- [ ] Works in Chrome
- [ ] Works in Firefox
- [ ] Works in Safari
- [ ] Works in Edge
- [ ] Mobile Safari works
- [ ] Mobile Chrome works

## Final Checks

- [ ] All forms submit successfully
- [ ] All delete confirmations work
- [ ] All file uploads work
- [ ] All exports download correctly
- [ ] All PDFs generate correctly
- [ ] No console errors in browser
- [ ] No PHP errors in logs
- [ ] All flash messages display
- [ ] All links work correctly

## Test Data Cleanup

After testing, you can reset the database:
```bash
php artisan migrate:fresh --seed
```

## Reporting Issues

If you find any issues during testing:
1. Note the steps to reproduce
2. Check browser console for errors
3. Check Laravel logs in `storage/logs/`
4. Document expected vs actual behavior
