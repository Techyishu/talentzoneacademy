# PRD — SchoolSuite (Working name)

## 1) Overview
Build a single web application that:
1) Shows a public informational website for a school group (home/about/campus/gallery/staff/contact).
2) Provides a secure multi-school (3 schools) management portal with a Super Admin who can view/manage all schools and School Admins who can only manage their own school.

Deployment target: Hostinger hosting.

## 2) Goals
- One login system with role-based access.
- Multi-school separation (no data leakage between schools).
- Core ERP modules: Students, Staff, Fees (receipts), ID Cards, basic content management (gallery/staff pages).
- Easy to operate: backups, exports, printable PDFs.

## 3) Non-goals (for MVP)
- Full LMS (online classes, exams, homework).
- Payment gateway integration (can be Phase 2).
- Parent mobile app (Phase 2).

## 4) Users & Roles
### Super Admin (Group owner)
- Can create/edit/deactivate schools.
- Can view aggregated reports across all schools.
- Can impersonate/switch into any school context.

### School Admin (Per school)
- Can manage only their school’s students/staff/fees/content.
- Cannot see other schools or global reports.

### Staff (Optional later)
- Limited features (attendance, marks, etc.) — not in MVP unless requested.

## 5) Tenancy Model (Multi-school)
- “Tenant” model: School
- A user can belong to multiple schools (Super Admin belongs to all; School Admin belongs to one).
- Inside the admin panel, user can switch active school (tenant switcher).
- All school-owned records must have `school_id`.

## 6) Modules (MVP scope)

### 6.1 School Setup
- School profile: name, code, address, phone, email
- Branding: logo, signature image (optional), receipt prefix, primary color
- Academic session settings (optional for MVP)

### 6.2 Students
- CRUD students with unique admission no. per school
- Fields: name, gender, DOB, class/section, roll no., guardian details, address, status (active/inactive)
- Import/export CSV
- Student profile page

### 6.3 Staff
- CRUD staff: name, role/designation, phone, joining date, salary (optional), status
- Staff directory (for public website if required)

### 6.4 Fees + Receipts
- Fee heads (tuition, transport, etc.) per school
- Fee structure per class (optional MVP, can do per-student first if faster)
- Payment entry (cash/online/manual)
- Auto receipt number per school (prefix + running number)
- Generate PDF receipt (print-friendly)
- Receipt list, reprint, cancellation (with audit log)

### 6.5 ID Cards
- ID card template per school (layout: logo, student photo, name, class, roll, address, phone)
- Generate PDF: single + bulk by class
- QR code (Phase 2, optional)

### 6.6 Public Website CMS
- Pages: Home, About, Contact (editable content blocks)
- Gallery: upload images with categories
- Notices/News (optional)
- Public staff listing (optional)
- SEO basics: title/meta/OG per page

## 7) Reporting (MVP)
- Students count by class/section
- Fee collection summary (daily/monthly range)
- Pending dues list

## 8) Security & Compliance
- Strict tenant scoping: school data must not leak via URL guessing.
- Audit logs for fee edits/receipt cancellation.
- Backups (DB + uploaded files), restore drill.

## 9) Performance & Reliability
- Pagination everywhere for large lists
- PDF generation should not time out for bulk jobs (queue later if needed)
- Image uploads optimized (max size + compression later)

## 10) Integrations (Optional / Phase 2)
- SMS/WhatsApp notices
- Payment gateway
- Biometric attendance sync

## 11) Milestones
M1: Project skeleton + auth + schools + tenancy + super admin (1–2 days)
M2: Students + Staff CRUD (2–4 days)
M3: Fees + receipts PDF (3–6 days)
M4: ID cards PDF bulk (2–4 days)
M5: Public website CMS + gallery (2–4 days)
M6: Deployment + training + backup plan (1–2 days)

## 12) Acceptance Criteria (MVP)
- Super Admin can create 3 schools and switch between them.
- School Admin cannot access other schools’ records.
- Fee receipt PDF prints correctly with school branding.
- Gallery uploads show on public website.
- Deployed on Hostinger and working with SSL + domain.
