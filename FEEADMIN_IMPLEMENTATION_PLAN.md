# FeeAdmin Feature Implementation Plan

This document outlines the plan to implement features from [FeeAdmin](https://feeadmin.com) that are not yet available in SchoolSuite.

---

## 1. Feature Gap Analysis

| Feature | FeeAdmin | SchoolSuite | Priority |
|---------|----------|-------------|----------|
| Fee collection + PDF receipts | ✅ | ✅ | Done |
| Multi-school / tenancy | ✅ | ✅ | Done |
| Custom fee structures | ✅ | ❌ Flat amount only | High |
| Partial fee payments | ✅ | ❌ | High |
| Salary management | ✅ | ❌ Staff has salary field only | High |
| Salary slips (PDF) | ✅ | ❌ | High |
| Advances & deductions | ✅ | ❌ | Medium |
| Student attendance | ✅ | ❌ | High |
| Staff attendance | ✅ | ❌ | High |
| ID card generation | ✅ | ❌ | High |
| Parent/Student portal | ✅ | ❌ | High |
| Staff portal | ✅ | ❌ | Medium |
| Role-based dashboards | ✅ | ✅ Partial | Medium |
| Reports & analytics | ✅ | ❌ Basic stats only | Medium |

---

## 2. Implementation Phases

### Phase 1: Foundation (Weeks 1–2)
*Prerequisites for later features*

### Phase 2: Fee Enhancements (Weeks 2–3)
*Fee structure and partial payments*

### Phase 3: ID Cards & Salary (Weeks 3–5)
*ID cards and salary management*

### Phase 4: Attendance (Weeks 5–6)
*Student and staff attendance*

### Phase 5: Portals & Roles (Weeks 6–8)
*Parent, student, and staff portals*

### Phase 6: Reporting (Week 8+)
*Reports and analytics*

---

## 3. Phase 1: Foundation

**Goal:** Academic session, class/section master, and new user roles.

### 3.1 Academic Session
- **Purpose:** Fee periods, attendance, and reports by session.
- **Migrations:**
  - `academic_sessions` table: `school_id`, `name`, `start_date`, `end_date`, `is_current`
- **Models:** `AcademicSession` (BelongsToSchool)
- **Admin UI:** CRUD in School Settings; set active session.
- **Effort:** 1–2 days

### 3.2 Class & Section Master
- **Purpose:** Standardized class/section list for fees, attendance, reports.
- **Migrations:**
  - `classes` table: `school_id`, `name` (e.g. Class 1, Class 2), `display_order`
  - `sections` table: `school_id`, `class_id`, `name` (e.g. A, B, C)
- **Models:** `SchoolClass`, `Section` (BelongsToSchool)
- **Admin UI:** Manage classes and sections per school.
- **Effort:** 1–2 days

### 3.3 New User Roles
- **Purpose:** Separate portals for staff, students, parents.
- **Changes:**
  - Extend `users.role` enum: `super_admin`, `school_admin`, `staff`, `student`, `parent`
  - Add `users.staff_id` (nullable, for staff)
  - Add `users.student_id` (nullable, for student)
  - Add `parent_students` pivot: `parent_user_id`, `student_id`, `relationship`
  - Add `guardian_email` to students for parent account linking
- **Middlewares:** `staff`, `student`, `parent`
- **Effort:** 2–3 days

**Phase 1 Total:** ~5–7 days

---

## 4. Phase 2: Fee Enhancements

**Goal:** Custom fee structure and partial payments.

### 4.1 Fee Heads
- **Migrations:**
  - `fee_heads` table: `school_id`, `name` (Tuition, Transport, Lab, etc.), `code`, `is_active`
- **Models:** `FeeHead` (BelongsToSchool)
- **Admin UI:** CRUD fee heads per school.
- **Effort:** 0.5–1 day

### 4.2 Fee Structure (Per Class)
- **Migrations:**
  - `fee_structures` table: `school_id`, `academic_session_id`, `class_id`, `fee_head_id`, `amount`
- **Models:** `FeeStructure` (BelongsToSchool)
- **Logic:** Compute total due per student from class and fee structure.
- **Effort:** 1–2 days

### 4.3 Fee Dues & Partial Payments
- **Migrations:**
  - Add to `fee_receipts`: `fee_head_id` (nullable for backward compat), or
  - `fee_receipt_items` table: `fee_receipt_id`, `fee_head_id`, `amount`
- **Logic:**
  - Calculate due per student per period (from fee structure).
  - Allow payments against specific fee heads or general payment.
  - Track running balance per student per session.
- **Admin UI:** Fee dues list, partial payment entry, dues vs paid view.
- **Effort:** 2–3 days

### 4.4 Pending Dues Report
- **Purpose:** List students with unpaid amounts.
- **Implementation:** Query students with outstanding balance.
- **Admin UI:** Report page with filters (class, section, date range).
- **Effort:** 0.5–1 day

**Phase 2 Total:** ~4–7 days

---

## 5. Phase 3: ID Cards & Salary

**Goal:** ID card PDFs and full salary management with slips.

### 5.1 ID Card Generation
- **Migrations:** None (use existing student/staff photos).
- **New Files:**
  - `app/Services/IdCardPdfService.php`
  - `resources/views/pdf/id-card-student.blade.php`
  - `resources/views/pdf/id-card-staff.blade.php`
- **Controller:** `Admin/IdCardController`
  - `generateSingle($student|$staff)` – single ID
  - `generateBulkByClass($classId)` – all students in class
  - `generateAllStaff()` – all staff
- **UI:** Buttons on student/staff show pages; bulk from class list.
- **Layout:** Logo, photo, name, class/roll or designation, address, phone.
- **Effort:** 2–3 days

### 5.2 Salary Slips
- **Migrations:**
  - `salary_slips` table: `school_id`, `staff_id`, `month`, `year`, `basic_salary`, `allowances`, `deductions`, `net_salary`, `paid_at`, `remarks`
  - `salary_advances` table: `school_id`, `staff_id`, `amount`, `month`, `year`, `status`, `remarks`
  - `salary_deductions` table: `school_id`, `staff_id`, `amount`, `month`, `year`, `reason`, `remarks`
- **Models:** `SalarySlip`, `SalaryAdvance`, `SalaryDeduction` (BelongsToSchool)
- **Service:** `SalarySlipPdfService` (reuse ReceiptPdfService pattern).
- **Admin UI:** Generate slips, record advances/deductions, view history.
- **Effort:** 3–4 days

### 5.3 Salary Report
- **Purpose:** Total salary payout by month, by staff.
- **Admin UI:** Summary report and per-staff detail.
- **Effort:** 0.5 day

**Phase 3 Total:** ~6–8 days

---

## 6. Phase 4: Attendance

**Goal:** Daily student and staff attendance.

### 6.1 Student Attendance
- **Migrations:**
  - `student_attendances` table: `school_id`, `student_id`, `date`, `status` (present/absent/late/leave), `remarks`
  - Unique: `(school_id, student_id, date)`
- **Models:** `StudentAttendance` (BelongsToSchool)
- **Admin UI:**
  - Date picker + class/section filter
  - Bulk mark: present/absent/late
  - Per-student override
- **Effort:** 2–3 days

### 6.2 Staff Attendance
- **Migrations:**
  - `staff_attendances` table: `school_id`, `staff_id`, `date`, `status`, `check_in`, `check_out`, `remarks`
- **Models:** `StaffAttendance` (BelongsToSchool)
- **Admin UI:** Similar to student, plus optional check-in/check-out.
- **Effort:** 2–3 days

### 6.3 Attendance Reports
- **Purpose:** Daily summary, monthly reports, patterns.
- **Admin UI:** Report by date range, class, staff; absence trends.
- **Effort:** 1–2 days

**Phase 4 Total:** ~5–8 days

---

## 7. Phase 5: Portals & Roles

**Goal:** Separate portals for staff, students, and parents.

### 7.1 Staff Portal
- **Route prefix:** `/staff` (or `/portal/staff`)
- **Middleware:** `auth`, `staff` (must have `staff_id`)
- **Features:**
  - Dashboard: own attendance, salary summary
  - Salary slips: list and download PDF
  - Attendance: view own history
  - Assigned classes (optional, for teachers)
- **Layout:** `resources/views/layouts/staff-portal.blade.php`
- **Effort:** 2–3 days

### 7.2 Student Portal
- **Route prefix:** `/student` (or `/portal/student`)
- **Middleware:** `auth`, `student` (must have `student_id`)
- **Features:**
  - Dashboard: fee dues, recent receipts
  - Fee dues: amount due, payment history
  - Receipts: list and download
  - Attendance: own attendance
- **Effort:** 2–3 days

### 7.3 Parent Portal
- **Route prefix:** `/parent`
- **Middleware:** `auth`, `parent`
- **Linking:** Parent user linked to students via `parent_students` (guardian email or manual link).
- **Features:**
  - Dashboard: linked students
  - Per-student: fees, receipts, attendance
  - Download receipts
- **Effort:** 3–4 days

### 7.4 Account Creation Flow
- **Staff:** Admin creates user, selects staff record, role = staff.
- **Student:** Admin creates user, selects student, role = student.
- **Parent:** Self-register with email matching guardian email, or admin invites/links.
- **Effort:** 1–2 days

**Phase 5 Total:** ~8–12 days

---

## 8. Phase 6: Reporting

**Goal:** Reports similar to FeeAdmin.

### 8.1 Reports to Implement
| Report | Description | Effort |
|--------|-------------|--------|
| Students by class/section | Count and list | 0.5 day |
| Fee collection summary | Daily/monthly totals | 1 day |
| Pending dues list | Students with outstanding fees | 0.5 day |
| Attendance summary | Daily/monthly by class | 1 day |
| Salary summary | Monthly payout | 0.5 day |
| Staff attendance report | By staff, date range | 0.5 day |

### 8.2 Reports Dashboard
- **Admin UI:** Reports section with filters and export (CSV/PDF).
- **Effort:** 1–2 days

**Phase 6 Total:** ~4–5 days

---

## 9. Database Migration Summary

```
Phase 1:
- academic_sessions
- classes
- sections
- users (add role values, staff_id, student_id)
- parent_students (pivot)

Phase 2:
- fee_heads
- fee_structures
- fee_receipt_items (optional, for itemized receipts)

Phase 3:
- salary_slips
- salary_advances
- salary_deductions

Phase 4:
- student_attendances
- staff_attendances

(Phase 5 & 6 use existing tables + new reports)
```

---

## 10. New Controllers

| Controller | Purpose |
|------------|---------|
| `Admin/AcademicSessionController` | Manage sessions |
| `Admin/ClassController` | Manage classes |
| `Admin/SectionController` | Manage sections |
| `Admin/FeeHeadController` | Fee heads CRUD |
| `Admin/FeeStructureController` | Fee structure CRUD |
| `Admin/IdCardController` | ID card PDF generation |
| `Admin/SalarySlipController` | Salary slips, advances, deductions |
| `Admin/StudentAttendanceController` | Student attendance |
| `Admin/StaffAttendanceController` | Staff attendance |
| `Admin/ReportController` | All reports |
| `Staff/DashboardController` | Staff portal |
| `Student/DashboardController` | Student portal |
| `Parent/DashboardController` | Parent portal |

---

## 11. Route Structure

```
/admin (existing + new)
  /academic-sessions
  /classes
  /sections
  /fee-heads
  /fee-structures
  /id-cards
  /salary-slips
  /student-attendance
  /staff-attendance
  /reports

/portal/staff   (staff middleware)
/portal/student (student middleware)
/portal/parent  (parent middleware)
```

---

## 12. Estimated Timeline

| Phase | Duration | Cumulative |
|-------|----------|------------|
| Phase 1: Foundation | 5–7 days | 1–2 weeks |
| Phase 2: Fee Enhancements | 4–7 days | 2–3 weeks |
| Phase 3: ID Cards & Salary | 6–8 days | 4–5 weeks |
| Phase 4: Attendance | 5–8 days | 5–6 weeks |
| Phase 5: Portals | 8–12 days | 7–8 weeks |
| Phase 6: Reporting | 4–5 days | 8–9 weeks |

**Total:** ~8–9 weeks for a single developer.

---

## 13. Dependencies

```
Phase 1 (Foundation)
    ├── Phase 2 (Fee Enhancements) — needs classes, academic session
    ├── Phase 3 (ID Cards & Salary) — independent
    ├── Phase 4 (Attendance) — needs classes/sections for student
    └── Phase 5 (Portals) — needs Phase 1 roles
            └── Phase 6 (Reporting) — needs Phases 2, 3, 4
```

---

## 14. Quick Wins (Can Start Immediately)

1. **ID Cards** — No schema changes, reuse existing student/staff data.
2. **Fee Heads** — Simple CRUD; fee structure can follow.
3. **Students by Class Report** — Simple query on existing data.
4. **Pending Dues List** — Needs fee structure; can start with “students with no receipts in period” as MVP.

---

## 15. References

- [FeeAdmin](https://feeadmin.com) — Reference product
- [prd.md](prd.md) — SchoolSuite PRD
- [FEATURES.md](FEATURES.md) — Current feature list
- [CLAUDE.md](CLAUDE.md) — Development guidelines
