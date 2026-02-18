<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $approvedReviews = \App\Models\PublicReview::approved()->latest()->take(6)->get();
    $activeVideo = \App\Models\HomepageVideo::active()->first();
    $activeMusic = \App\Models\BackgroundMusic::active()->first();
    $galleryImages = \App\Models\GalleryImage::orderBy('display_order')->take(6)->get();

    return view('public.home', compact('approvedReviews', 'activeVideo', 'activeMusic', 'galleryImages'));
})->name('home');


Route::get('/schools', function () {
    return view('public.schools.index');
})->name('schools');

Route::get('/schools/{slug}', function (string $slug) {
    $schools = config('schools.schools');
    $school = collect($schools)->firstWhere('slug', $slug);

    if (!$school) {
        abort(404);
    }

    return view('public.schools.show', ['school' => $school, 'allSchools' => $schools]);
})->name('schools.show');

Route::get('/gallery', function () {
    return view('public.gallery');
})->name('gallery');

Route::get('/approach', function () {
    return view('public.approach');
})->name('approach');

Route::get('/staff', function () {
    $staffBySchool = \App\Models\Staff::visibleOnWebsite()
        ->with('school')
        ->orderBy('school_id')
        ->orderBy('designation')
        ->orderBy('name')
        ->get()
        ->groupBy('school_id');

    $schools = \App\Models\School::whereIn('id', $staffBySchool->keys())->get()->keyBy('id');

    return view('public.staff', compact('staffBySchool', 'schools'));
})->name('staff');

Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');

Route::post('/contact', [\App\Http\Controllers\Public\ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect()->route(auth()->user()->getDashboardRoute());
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolSwitchController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\AcademicSessionController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentImportController;
use App\Http\Controllers\Admin\ParentStudentController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StaffImportController;
use App\Http\Controllers\Admin\FeeReceiptController;
use App\Http\Controllers\Admin\FeeHeadController;
use App\Http\Controllers\Admin\FeeStructureController;
use App\Http\Controllers\Admin\IdCardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\DuesReportController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\StudentAttendanceController;
use App\Http\Controllers\Admin\StaffAttendanceController;
use App\Http\Controllers\Admin\PortalUserController;
use App\Http\Controllers\Admin\SalarySlipController;
use App\Http\Controllers\Admin\SalaryAdvanceController;
use App\Http\Controllers\Admin\FeeGenerationController;
use App\Http\Controllers\Admin\PublicReviewController;
use App\Http\Controllers\Admin\BackgroundMusicController;
use App\Http\Controllers\Admin\HomepageVideoController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\SchoolAdminController;


Route::middleware(['auth', 'set_school'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Change Own Password (all admin users)
    Route::get('password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Portal Users Management
    Route::resource('portal-users', PortalUserController::class);

    // Salary Management
    Route::resource('salary-slips', SalarySlipController::class)->except(['edit', 'update']);
    Route::post('salary-slips/{salary_slip}/mark-paid', [SalarySlipController::class, 'markPaid'])->name('salary-slips.mark-paid');
    Route::get('salary-slips/{salary_slip}/download', [SalarySlipController::class, 'downloadPdf'])->name('salary-slips.download');

    Route::resource('salary-advances', SalaryAdvanceController::class)->except(['edit', 'update']);
    Route::post('salary-advances/{salary_advance}/approve', [SalaryAdvanceController::class, 'approve'])->name('salary-advances.approve');
    Route::post('salary-advances/{salary_advance}/reject', [SalaryAdvanceController::class, 'reject'])->name('salary-advances.reject');



    // School Switcher (Super Admin only)
    Route::middleware('super_admin')->group(function () {
        Route::post('/switch-school', [SchoolSwitchController::class, 'switch'])->name('switch-school');

        // Reset School Admin Passwords
        Route::get('users/{user}/password', [PasswordController::class, 'editUser'])->name('users.password.edit');
        Route::put('users/{user}/password', [PasswordController::class, 'updateUser'])->name('users.password.update');

        // Schools Management
        Route::resource('schools', SchoolController::class)->except(['create', 'store', 'destroy']);
        Route::get('/schools/{school}/users', [SchoolController::class, 'users'])->name('schools.users');
        Route::get('/schools/{school}/admins/create', [SchoolAdminController::class, 'create'])->name('schools.admins.create');
        Route::post('/schools/{school}/admins', [SchoolAdminController::class, 'store'])->name('schools.admins.store');

        // Website Content Management (Super Admin)
        Route::get('/public-reviews', [PublicReviewController::class, 'index'])->name('public-reviews.index');
        Route::get('/public-reviews/{publicReview}', [PublicReviewController::class, 'show'])->name('public-reviews.show');
        Route::post('/public-reviews/{publicReview}/approve', [PublicReviewController::class, 'approve'])->name('public-reviews.approve');
        Route::post('/public-reviews/{publicReview}/reject', [PublicReviewController::class, 'reject'])->name('public-reviews.reject');
        Route::delete('/public-reviews/{publicReview}', [PublicReviewController::class, 'destroy'])->name('public-reviews.destroy');

        Route::resource('background-music', BackgroundMusicController::class);
        Route::post('/background-music/{backgroundMusic}/toggle-active', [BackgroundMusicController::class, 'toggleActive'])->name('background-music.toggle-active');

        Route::resource('homepage-videos', HomepageVideoController::class);
        Route::post('/homepage-videos/{homepageVideo}/toggle-active', [HomepageVideoController::class, 'toggleActive'])->name('homepage-videos.toggle-active');
    });


    // School Admin Routes (requires school context)
    Route::middleware('school_admin')->group(function () {
        // Students Management
        Route::resource('students', StudentController::class);
        Route::get('/students-export', [StudentController::class, 'export'])->name('students.export');
        Route::get('/students-import', [StudentImportController::class, 'create'])->name('students.import.create');
        Route::post('/students-import', [StudentImportController::class, 'import'])->name('students.import');
        Route::get('/students-import-template', [StudentImportController::class, 'downloadTemplate'])->name('students.import.template');

        // Parent-Student Management (Batch)
        Route::get('/parent-students/create', [ParentStudentController::class, 'create'])->name('parent-students.create');
        Route::post('/parent-students', [ParentStudentController::class, 'store'])->name('parent-students.store');

        // Staff Management
        Route::resource('staff', StaffController::class);
        Route::get('/staff-export', [StaffController::class, 'export'])->name('staff.export');
        Route::get('/staff-import', [StaffImportController::class, 'create'])->name('staff.import.create');
        Route::post('/staff-import', [StaffImportController::class, 'import'])->name('staff.import');
        Route::get('/staff-import-template', [StaffImportController::class, 'downloadTemplate'])->name('staff.import.template');

        // Academic Sessions Management
        Route::resource('academic-sessions', AcademicSessionController::class);
        Route::post('/academic-sessions/{academicSession}/toggle-current', [AcademicSessionController::class, 'toggleCurrent'])->name('academic-sessions.toggle-current');

        // Classes Management
        Route::resource('classes', ClassController::class);

        // Sections Management (Nested under classes)
        Route::get('/classes/{class}/sections', [SectionController::class, 'index'])->name('sections.index');
        Route::get('/classes/{class}/sections/create', [SectionController::class, 'create'])->name('sections.create');
        Route::post('/classes/{class}/sections', [SectionController::class, 'store'])->name('sections.store');
        Route::get('/classes/{class}/sections/{section}', [SectionController::class, 'show'])->name('sections.show');
        Route::get('/classes/{class}/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
        Route::put('/classes/{class}/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
        Route::delete('/classes/{class}/sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');

        // Fee Heads Management
        Route::resource('fee-heads', FeeHeadController::class)->except(['show']);
        Route::post('/fee-heads/{feeHead}/toggle-status', [FeeHeadController::class, 'toggleStatus'])->name('fee-heads.toggle-status');

        // Fee Structures Management
        Route::get('/fee-structures', [FeeStructureController::class, 'index'])->name('fee-structures.index');
        Route::post('/fee-structures/bulk-update', [FeeStructureController::class, 'bulkUpdate'])->name('fee-structures.bulk-update');
        Route::post('/fee-structures/clone', [FeeStructureController::class, 'clone'])->name('fee-structures.clone');

        // Fee Receipts Management
        Route::get('/fee-receipts', [FeeReceiptController::class, 'index'])->name('fee-receipts.index');
        Route::get('/fee-receipts/create', [FeeReceiptController::class, 'create'])->name('fee-receipts.create');
        Route::post('/fee-receipts', [FeeReceiptController::class, 'store'])->name('fee-receipts.store');
        Route::get('/fee-receipts/{feeReceipt}', [FeeReceiptController::class, 'show'])->name('fee-receipts.show');
        Route::get('/fee-receipts/{feeReceipt}/pdf', [FeeReceiptController::class, 'pdf'])->name('fee-receipts.pdf');
        Route::get('/fee-receipts/{feeReceipt}/download', [FeeReceiptController::class, 'download'])->name('fee-receipts.download');
        Route::post('/fee-receipts/{feeReceipt}/cancel', [FeeReceiptController::class, 'cancel'])->name('fee-receipts.cancel');
        Route::get('/fee-receipts-export', [FeeReceiptController::class, 'export'])->name('fee-receipts.export');
        // Family Payment AJAX endpoint
        Route::get('/fee-receipts/family-balance/{parent}', [FeeReceiptController::class, 'loadFamilyBalance'])->name('fee-receipts.family-balance');

        // Monthly Fee Generation
        Route::get('/fees/generate-monthly', [FeeGenerationController::class, 'showForm'])->name('fees.generate-monthly.form');
        Route::post('/fees/generate-monthly', [FeeGenerationController::class, 'generateMonthly'])->name('fees.generate-monthly');

        // ID Cards Generation
        Route::get('/id-cards/students/{student}', [IdCardController::class, 'generateStudent'])->name('id-cards.student');
        Route::get('/id-cards/students/bulk/form', [IdCardController::class, 'showBulkStudentForm'])->name('id-cards.bulk-student-form');
        Route::post('/id-cards/students/bulk', [IdCardController::class, 'generateBulkByClass'])->name('id-cards.bulk-student');
        Route::get('/id-cards/staff/{staff}', [IdCardController::class, 'generateStaff'])->name('id-cards.staff');
        Route::get('/id-cards/staff/bulk-all', [IdCardController::class, 'generateAllStaff'])->name('id-cards.bulk-staff');

        // Gallery Management
        Route::resource('gallery', GalleryController::class)->except(['show']);
        Route::post('/gallery/update-order', [GalleryController::class, 'updateOrder'])->name('gallery.update-order');

        // Contact Submissions
        Route::get('/contact-submissions', [ContactSubmissionController::class, 'index'])->name('contact-submissions.index');
        Route::get('/contact-submissions/{contactSubmission}', [ContactSubmissionController::class, 'show'])->name('contact-submissions.show');
        Route::delete('/contact-submissions/{contactSubmission}', [ContactSubmissionController::class, 'destroy'])->name('contact-submissions.destroy');
        Route::post('/contact-submissions/{contactSubmission}/toggle-read', [ContactSubmissionController::class, 'toggleRead'])->name('contact-submissions.toggle-read');
        Route::post('/contact-submissions/bulk-delete', [ContactSubmissionController::class, 'bulkDelete'])->name('contact-submissions.bulk-delete');

        // Student Attendance
        Route::get('/student-attendance', [StudentAttendanceController::class, 'index'])->name('student-attendance.index');
        Route::get('/student-attendance/create', [StudentAttendanceController::class, 'create'])->name('student-attendance.create');
        Route::post('/student-attendance', [StudentAttendanceController::class, 'store'])->name('student-attendance.store');
        Route::get('/student-attendance/{date}', [StudentAttendanceController::class, 'show'])->name('student-attendance.show')->where('date', '\d{4}-\d{2}-\d{2}');
        Route::get('/students/{student}/attendance', [StudentAttendanceController::class, 'studentHistory'])->name('student-attendance.history');
        Route::get('/student-attendance/quick/{class}/{section}', [StudentAttendanceController::class, 'quickAttendance'])->name('student-attendance.quick');
        Route::post('/student-attendance/quick', [StudentAttendanceController::class, 'storeQuick'])->name('student-attendance.store-quick');

        // Staff Attendance
        Route::get('/staff-attendance', [StaffAttendanceController::class, 'index'])->name('staff-attendance.index');
        Route::get('/staff-attendance/create', [StaffAttendanceController::class, 'create'])->name('staff-attendance.create');
        Route::post('/staff-attendance', [StaffAttendanceController::class, 'store'])->name('staff-attendance.store');
        Route::get('/staff/{staff}/attendance', [StaffAttendanceController::class, 'staffHistory'])->name('staff-attendance.history');

        // Reports
        Route::get('/reports/dues', [DuesReportController::class, 'index'])->name('reports.dues');
        Route::get('/reports/dues/export', [DuesReportController::class, 'export'])->name('reports.dues.export');
        Route::get('/reports/student/{student}/dues', [DuesReportController::class, 'studentDues'])->name('reports.student-dues');
        Route::get('/reports/fee-collection', [ReportsController::class, 'feeCollection'])->name('reports.fee-collection');
        Route::get('/reports/fee-collection/export', [ReportsController::class, 'feeCollectionExport'])->name('reports.fee-collection.export');
        Route::get('/reports/students-by-class', [ReportsController::class, 'studentsByClass'])->name('reports.students-by-class');
        Route::get('/reports/students-by-class/export', [ReportsController::class, 'studentsByClassExport'])->name('reports.students-by-class.export');
        Route::get('/classes/{class}/sections-json', [DuesReportController::class, 'getSections'])->name('classes.sections-json');
    });
});

/*
|--------------------------------------------------------------------------
| Staff Portal Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\AttendanceController as StaffAttendanceHistoryController;

Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    Route::get('/attendance', [StaffAttendanceHistoryController::class, 'index'])->name('attendance');
});

/*
|--------------------------------------------------------------------------
| Student Portal Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\FeeController as StudentFeeController;

Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/fees', [StudentFeeController::class, 'index'])->name('fees');
    Route::get('/fees/{receipt}/download', [StudentFeeController::class, 'downloadReceipt'])->name('fees.download');
});

/*
|--------------------------------------------------------------------------
| Parent Portal Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ParentPortal\DashboardController as ParentDashboardController;
use App\Http\Controllers\ParentPortal\ChildController as ParentChildController;

Route::middleware(['auth', 'parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/children/{student}', [ParentChildController::class, 'show'])->name('children.show');
    Route::get('/children/{student}/receipt/{receipt}', [ParentChildController::class, 'downloadReceipt'])->name('children.receipt');
});
