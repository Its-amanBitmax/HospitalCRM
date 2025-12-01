<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\WardBedController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PatientVisitController;
use App\Http\Controllers\HospitalVisitController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\EmployeeLoginController;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AttendanceController;

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/login-selection', function () {
    $admin = \App\Models\Admin::first();
    $logo = $admin && $admin->logo ? asset('storage/' . $admin->logo) : asset('image/Gemini_Generated_Image_xxqbl3xxqbl3xxqb.png');
    $hospital_name = $admin ? $admin->hospital_name : 'Hospital';
    return view('website.login-selection', compact('logo', 'hospital_name'));
})->name('login.selection');



Route::get('/login', function () {
    return redirect()->route('admin.login.form');
})->name('login');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/employees/{employee}/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/employees/{employee}/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/employees/{employee}/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');

    Route::get('/appointments', [AppointmentController::class, 'index'])
        ->name('admin.appointments');
    Route::put('/appointments/{appointment}/accept', [AppointmentController::class, 'accept'])
        ->name('admin.appointments.accept');

    Route::put('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])
        ->name('admin.appointments.reject');

    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])
        ->name('admin.appointments.destroy');

    Route::get('/video-consultations', [AppointmentController::class, 'videoConsultations'])
        ->name('admin.video-consultations');
    // Forgot password routes
    Route::post('/forgot-password', [AdminController::class, 'sendOTP'])->name('admin.send.otp');
    Route::post('/verify-otp', [AdminController::class, 'verifyOTP'])->name('admin.verify.otp');
    Route::post('/reset-password', [AdminController::class, 'resetPassword'])->name('admin.reset.password');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
        Route::post('/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('/profile/change-password', [AdminProfileController::class, 'changePassword'])->name('admin.profile.change-password');
        Route::get('/ward-bed', [WardBedController::class, 'index'])->name('admin.ward-bed');
        Route::post('/ward-bed/store-ward', [WardBedController::class, 'storeWard'])->name('admin.store-ward');
        Route::post('/ward-bed/store-bed', [WardBedController::class, 'storeBed'])->name('admin.store-bed');
        Route::get('/ward-bed/get-wards', [WardBedController::class, 'getWards'])->name('admin.get-wards');
        Route::get('/ward-bed/get-beds', [WardBedController::class, 'getBeds'])->name('admin.get-beds');
        Route::put('/ward-bed/update-ward/{id}', [WardBedController::class, 'updateWard'])->name('admin.update-ward');
        Route::delete('/ward-bed/delete-ward/{id}', [WardBedController::class, 'deleteWard'])->name('admin.delete-ward');
        Route::put('/ward-bed/update-bed/{id}', [WardBedController::class, 'updateBed'])->name('admin.update-bed');
        Route::delete('/ward-bed/delete-bed/{id}', [WardBedController::class, 'deleteBed'])->name('admin.delete-bed');
        Route::post('/ward-bed/assign-bed', [WardBedController::class, 'assignBed'])->name('admin.assign-bed');
        Route::get('/ward-bed/get-bed-assignments/{userId}', [WardBedController::class, 'getBedAssignments'])->name('admin.get-bed-assignments');
        Route::put('/ward-bed/update-bed-assignment/{id}', [WardBedController::class, 'updateBedAssignment'])->name('admin.update-bed-assignment');
        Route::delete('/ward-bed/remove-bed-assignment/{id}', [WardBedController::class, 'removeBedAssignment'])->name('admin.remove-bed-assignment');
        Route::put('/ward-bed/transfer-bed/{assignmentId}', [WardBedController::class, 'transferBed'])->name('admin.transfer-bed');

        Route::get('/stock', [StockController::class, 'index'])->name('admin.stock');
        Route::post('/stock/store-supplier', [StockController::class, 'storeSupplier'])->name('admin.store-supplier');
        Route::post('/stock/store-item', [StockController::class, 'storeItem'])->name('admin.store-item');
        Route::get('/stock/get-suppliers', [StockController::class, 'getSuppliers'])->name('admin.get-suppliers');
        Route::get('/stock/get-items', [StockController::class, 'getItems'])->name('admin.get-items');
        Route::put('/stock/update-supplier/{id}', [StockController::class, 'updateSupplier'])->name('admin.update-supplier');
        Route::delete('/stock/delete-supplier/{id}', [StockController::class, 'deleteSupplier'])->name('admin.delete-supplier');
        Route::put('/stock/update-item/{id}', [StockController::class, 'updateItem'])->name('admin.update-item');
        Route::delete('/stock/delete-item/{id}', [StockController::class, 'deleteItem'])->name('admin.delete-item');

        Route::get('/faq', [FaqController::class, 'index'])->name('admin.faq');
        Route::post('/faq/store', [FaqController::class, 'store'])->name('admin.store-faq');
        Route::get('/faq/get-faqs', [FaqController::class, 'getFaqs'])->name('admin.get-faqs');
        Route::put('/faq/update/{id}', [FaqController::class, 'update'])->name('admin.update-faq');
        Route::delete('/faq/delete/{id}', [FaqController::class, 'delete'])->name('admin.delete-faq');

        Route::get('/banner', [BannerController::class, 'index'])->name('admin.banner');
        Route::post('/banner/store', [BannerController::class, 'store'])->name('admin.store-banner');
        Route::get('/banner/get-banners', [BannerController::class, 'getBanners'])->name('admin.get-banners');
        Route::post('/banner/update/{id}', [BannerController::class, 'update'])->name('admin.update-banner');
        Route::delete('/banner/delete/{id}', [BannerController::class, 'delete'])->name('admin.delete-banner');

        Route::get('/departments', [DepartmentController::class, 'index'])->name('admin.departments');
        Route::get('/get-departments', [DepartmentController::class, 'getDepartments'])->name('admin.get-departments');
        Route::post('/store-department', [DepartmentController::class, 'store'])->name('admin.store-department');
        Route::get('/department/{id}', [DepartmentController::class, 'show'])->name('admin.show-department');
        Route::put('/update-department/{id}', [DepartmentController::class, 'update'])->name('admin.update-department');
        Route::delete('/delete-department/{id}', [DepartmentController::class, 'destroy'])->name('admin.delete-department');

        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('admin.users.show');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::get('/users/{id}/visits', [PatientVisitController::class, 'index'])->name('admin.users.visits');
        Route::get('/users/{id}/visits/create', [PatientVisitController::class, 'create'])->name('admin.users.visits.create');
        Route::post('/users/{id}/visits', [PatientVisitController::class, 'store'])->name('admin.users.visits.store');
        Route::get('/users/{id}/visits/{visitId}/edit', [PatientVisitController::class, 'edit'])->name('admin.users.visits.edit');
        Route::put('/users/{id}/visits/{visitId}', [PatientVisitController::class, 'update'])->name('admin.users.visits.update');
        Route::delete('/users/{id}/visits/{visitId}', [PatientVisitController::class, 'destroy'])->name('admin.users.visits.destroy');
        Route::get('/users/{id}/checkups/create', [PatientVisitController::class, 'createCheckup'])->name('admin.users.checkups.create');
        Route::post('/users/{id}/checkups', [PatientVisitController::class, 'storeCheckup'])->name('admin.users.checkups.store');
        Route::get('/users/{id}/checkups/{checkupId}/edit', [PatientVisitController::class, 'editCheckup'])->name('admin.users.checkups.edit');
        Route::put('/users/{id}/checkups/{checkupId}', [PatientVisitController::class, 'updateCheckup'])->name('admin.users.checkups.update');
        Route::delete('/users/{id}/checkups/{checkupId}', [PatientVisitController::class, 'destroyCheckup'])->name('admin.users.checkups.destroy');
        Route::get('/users/{id}/documents/create', [PatientVisitController::class, 'createDocument'])->name('admin.users.documents.create');
        Route::post('/users/{id}/documents', [PatientVisitController::class, 'storeDocument'])->name('admin.users.documents.store');
        Route::delete('/users/{id}/documents/{documentId}', [PatientVisitController::class, 'destroyDocument'])->name('admin.users.documents.destroy');

        Route::get('/registered-users', [AdminController::class, 'registeredUsers'])->name('admin.registered-users');
        Route::get('/get-registered-users', [AdminController::class, 'getRegisteredUsers'])->name('admin.get-registered-users');
        Route::post('/add-registered-user', [AdminController::class, 'addRegisteredUser'])->name('admin.add-registered-user');
        Route::post('/update-registered-user/{id}', [AdminController::class, 'updateRegisteredUser'])->name('admin.update-registered-user');
        Route::delete('/delete-registered-user/{id}', [AdminController::class, 'deleteRegisteredUser'])->name('admin.delete-registered-user');

        Route::get('/ipd-patients', [AdminController::class, 'ipdPatients'])->name('admin.ipd-patients');
        Route::get('/get-ipd-patients', [AdminController::class, 'getIpdPatients'])->name('admin.get-ipd-patients');
        Route::put('/update-ipd-patient/{id}', [AdminController::class, 'updateIpdPatient'])->name('admin.update-ipd-patient');
        Route::delete('/delete-ipd-patient/{id}', [AdminController::class, 'deleteIpdPatient'])->name('admin.delete-ipd-patient');

        Route::get('/opd-patients', [AdminController::class, 'opdPatients'])->name('admin.opd-patients');
        Route::get('/get-opd-patients', [AdminController::class, 'getOpdPatients'])->name('admin.get-opd-patients');
        Route::put('/update-opd-patient/{id}', [AdminController::class, 'updateOpdPatient'])->name('admin.update-opd-patient');
        Route::delete('/delete-opd-patient/{id}', [AdminController::class, 'deleteOpdPatient'])->name('admin.delete-opd-patient');

        Route::get('/patient-registration', [AdminController::class, 'patientRegistration'])->name('admin.patient-registration');

        Route::get('/emergency-patients', [AdminController::class, 'emergencyPatients'])->name('admin.emergency-patients');
        Route::get('/get-emergency-patients', [AdminController::class, 'getEmergencyPatients'])->name('admin.get-emergency-patients');
        Route::put('/update-emergency-patient/{id}', [AdminController::class, 'updateEmergencyPatient'])->name('admin.update-emergency-patient');
        Route::delete('/delete-emergency-patient/{id}', [AdminController::class, 'deleteEmergencyPatient'])->name('admin.delete-emergency-patient');

        Route::get('/discharged-patients', [AdminController::class, 'dischargedPatients'])->name('admin.discharged-patients');
        Route::get('/get-discharged-patients', [AdminController::class, 'getDischargedPatients'])->name('admin.get-discharged-patients');
        Route::put('/update-discharged-patient/{id}', [AdminController::class, 'updateDischargedPatient'])->name('admin.update-discharged-patient');
        Route::delete('/delete-discharged-patient/{id}', [AdminController::class, 'deleteDischargedPatient'])->name('admin.delete-discharged-patient');

        Route::resource('employees', EmployeeController::class)->names([
            'index' => 'admin.employees.index',
            'create' => 'admin.employees.create',
            'store' => 'admin.employees.store',
            'show' => 'admin.employees.show',
            'edit' => 'admin.employees.edit',
            'update' => 'admin.employees.update',
            'destroy' => 'admin.employees.destroy',
        ]);

        Route::get('/doctors', [EmployeeController::class, 'doctors'])->name('admin.doctors');
        Route::get('/nurses', [EmployeeController::class, 'nurses'])->name('admin.nurses');
        Route::post('/employees/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('admin.employees.toggle-status');

        Route::resource('specialities', SpecialityController::class)->names([
            'index' => 'admin.specialities.index',
            'create' => 'admin.specialities.create',
            'store' => 'admin.specialities.store',
            'show' => 'admin.specialities.show',
            'edit' => 'admin.specialities.edit',
            'update' => 'admin.specialities.update',
            'destroy' => 'admin.specialities.destroy',
        ]);

        Route::get('/rooms', [App\Http\Controllers\RoomController::class, 'index'])->name('admin.rooms');
        Route::get('/get-rooms', [App\Http\Controllers\RoomController::class, 'getRooms'])->name('admin.get-rooms');
        Route::post('/store-room', [App\Http\Controllers\RoomController::class, 'store'])->name('admin.store-room');
        Route::get('/room/{id}', [App\Http\Controllers\RoomController::class, 'show'])->name('admin.show-room');
        Route::put('/update-room/{id}', [App\Http\Controllers\RoomController::class, 'update'])->name('admin.update-room');
        Route::delete('/delete-room/{id}', [App\Http\Controllers\RoomController::class, 'destroy'])->name('admin.delete-room');
        Route::post('/assign-room', [App\Http\Controllers\RoomController::class, 'assign'])->name('admin.assign-room');
        Route::get('/get-room-assignments/{id}', [App\Http\Controllers\RoomController::class, 'getAssignments'])->name('admin.get-room-assignments');
        Route::put('/update-room-assignment/{id}', [App\Http\Controllers\RoomController::class, 'updateAssignmentStatus'])->name('admin.update-room-assignment');
        Route::get('/get-professions', [App\Http\Controllers\RoomController::class, 'getProfessions'])->name('admin.get-professions');
        Route::get('/get-employees', [App\Http\Controllers\RoomController::class, 'getEmployees'])->name('admin.get-employees');
        Route::get('/get-employees-by-department/{departmentId}', [App\Http\Controllers\RoomController::class, 'getEmployeesByDepartment'])->name('admin.get-employees-by-department');
        Route::get('/get-assigned-rooms', [App\Http\Controllers\RoomController::class, 'getAssignedRooms'])->name('admin.get-assigned-rooms');
        Route::delete('/remove-room-assignment/{id}', [App\Http\Controllers\RoomController::class, 'removeAssignment'])->name('admin.remove-room-assignment');

        // Hospital Visits routes
        Route::resource('visits', HospitalVisitController::class)->names([
            'index' => 'admin.visits.index',
            'create' => 'admin.visits.create',
            'store' => 'admin.visits.store',
            'show' => 'admin.visits.show',
            'edit' => 'admin.visits.edit',
            'update' => 'admin.visits.update',
            'destroy' => 'admin.visits.destroy',
        ]);

        // Additional visit actions
        Route::post('/visits/{visit}/check-in', [HospitalVisitController::class, 'checkIn'])->name('admin.visits.check-in');
        Route::post('/visits/{visit}/check-out', [HospitalVisitController::class, 'checkOut'])->name('admin.visits.check-out');
        Route::post('/visits/{visit}/accept-invite', [HospitalVisitController::class, 'acceptInvite'])->name('admin.visits.accept-invite');
        Route::post('/visits/{visit}/decline-invite', [HospitalVisitController::class, 'declineInvite'])->name('admin.visits.decline-invite');
        Route::get('/visits/{visit}/invitation-pdf', [HospitalVisitController::class, 'generateInvitationPDF'])->name('admin.visits.invitation-pdf');

        // Attendance routes
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
        Route::post('/attendance/mark', [AttendanceController::class, 'markAttendance'])->name('admin.attendance.mark');
        Route::get('/attendance/{employeeId}', [AttendanceController::class, 'show'])->name('admin.attendance.show');
        Route::post('/attendance/bulk-mark', [AttendanceController::class, 'bulkMark'])->name('admin.attendance.bulk-mark');
        Route::get('/attendance-report', [AttendanceController::class, 'report'])->name('admin.attendance.report');
    });
});
Route::get('attendance/monthly-view', [AttendanceController::class, 'monthlyView'])->name('admin.attendance.monthly-view');


// Employee routes
Route::prefix('employee')->group(function () {

    Route::post('/userlogin', [EmployeeLoginController::class, 'login'])
        ->name('employee.userlogin');

    Route::post('/logout', [EmployeeLoginController::class, 'logout'])
        ->name('employee.logout');

    // Accept/Reject routes for appointments
    Route::put('/appointments/{appointment}/accept', [AppointmentController::class, 'accept'])
        ->name('employee.appointments.accept')->middleware('auth:doctor');

    Route::put('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])
        ->name('employee.appointments.reject')->middleware('auth:doctor');

    Route::get('/dashboard', function () {
        return view('employee.dashboard');
    })->name('employee.dashboard')->middleware('auth:doctor');

    Route::get('/doctor-dashboard', function () {
        return view('employee.doctor-dashboard');
    })->name('employee.doctor.dashboard')->middleware('auth:doctor');

    Route::get('/doctor/appointments', [AppointmentController::class, 'doctorAppointments'])
        ->name('employee.doctor_appointments')->middleware('auth:doctor');

    Route::get('/doctor/consultations', [AppointmentController::class, 'doctorConsultations'])
        ->name('employee.doctor_consultations')->middleware('auth:doctor');

    Route::get('/doctor/patients', [AppointmentController::class, 'doctorPatients'])
        ->name('employee.doctor_patients')->middleware('auth:doctor');

    Route::get('/receptionist-dashboard', function () {
        return view('receptionist.dashboard');
    })->name('employee.receptionist.dashboard')->middleware('auth:receptionist');
    //   Route::get('/users/{id}/checkups', [PatientVisitController::class, 'doctor_checkup'])->name('employee.users.checkups');
    Route::get(
        'doctor/users/{userId}/summary',
        [PatientVisitController::class, 'doctor_visit_summary']
    )->name('employee.users.summary');

    Route::get('doctor/reports', [PatientVisitController::class, 'reports'])
        ->name('employee.report');
});




Route::prefix('admin')->group(function () {
    Route::get('/reception/index', [ReceptionController::class, 'index'])->name('admin.reception.index');
    Route::get('create', [ReceptionController::class, 'create'])->name('admin.reception.create');
    Route::post('/reception/store', [ReceptionController::class, 'store'])->name('admin.reception.store');
    Route::post('/reception/update', [ReceptionController::class, 'update'])->name('admin.reception.update');
    Route::post('/reception/{id}/delete', [ReceptionController::class, 'destroy'])->name('admin.reception.destroy');
    Route::post('/receptions/{receptionId}/assign', [ReceptionController::class, 'assignReceptionEmployee'])->name('receptions.assign');
    Route::post('/receptions/{id}/unassign', [ReceptionController::class, 'unassignReceptionEmployee'])->name('reception.unassign');
    Route::get('/receptions/visit', [ReceptionController::class, 'reception_visit'])->name('admin.receptions.visit');
    Route::get('/receptions/{id}/visits', [ReceptionController::class, 'reception_visit_users'])->name('admin.receptions.visits');
});




Route::get('/doctor/users/{userId}/checkup/create', [PatientVisitController::class, 'doctorCreateCheckup'])
    ->name('employee.users.checkups.create');

Route::post('/doctor/users/{userId}/checkup/store', [PatientVisitController::class, 'storePatientCheckup'])
    ->name('employee.users.checkups.store');



Route::get(
    'doctor/users/{userId}/checkups/{checkupId}/edit',
    [PatientVisitController::class, 'doctor_Edit_Checkup']
)->name('employee.users.checkups.edit');

Route::post(
    'doctor/users/{userId}/checkups/{checkupId}/update',
    [PatientVisitController::class, 'doctor_update_Checkup']
)->name('employee.users.checkups.update');


Route::delete(
    'doctor/users/{userId}/checkups/{checkupId}',
    [PatientVisitController::class, 'doctor_delete_Checkup']
)->name('employee.users.checkups.delete');




Route::get(
    'doctor/users/{userId}/documents/create',
    [PatientVisitController::class, 'doctorCreateDocument']
)->name('employee.users.documents.create');

Route::post(
    'doctor/users/{userId}/documents',
    [PatientVisitController::class, 'doctorStoreDocument']
)->name('employee.users.documents.store');
Route::delete(
    'doctor/users/{userId}/documents/{documentId}',
    [PatientVisitController::class, 'doctorDeleteDocument']
)->name('employee.users.documents.delete');







Route::get(
    'doctor/profile/settings',
    [PatientVisitController::class, 'doctor_profile_settings']
)->name('employee.profile.settings');



Route::post('doctor/profile-settings', [PatientVisitController::class, 'update_doctor_profile'])
    ->name('doctor.update.profile');
// Show password change form
Route::get('/doctor/settings', [PatientVisitController::class, 'settings'])
    ->name('doctor.settings');

// Update password
Route::post('/doctor/update/settings', [PatientVisitController::class, 'updateSettings'])
    ->name('doctor.update.settings');

// Receptionist Dashboard
Route::get('/receptionists', [ReceptionController::class, 'get_receptions'])
    ->name('receptionists.dashboard');

Route::get('/receptionist/appointments', [ReceptionController::class, 'get_appointments'])
    ->name('receptionist.appointments');

Route::get('/receptionist/patients', [ReceptionController::class, 'get_patients'])
    ->name('receptionist.patients');




Route::get('receptionist/{user}/visits', [ReceptionController::class, 'showUserVisits'])->name('visits.show');


Route::get('receptionist/{user}/visits/create', [ReceptionController::class, 'createUserVisit'])->name('visits.create');
Route::post('receptionist/{user}/visits', [ReceptionController::class, 'storeUserVisit'])->name('visits.store');

// Edit visit
Route::get('receptionist/{user}/visits/{visit}/edit', [ReceptionController::class, 'editUserVisit'])->name('visits.edit');
Route::post('receptionist/{user}/visits/{visit}', [ReceptionController::class, 'updateUserVisit'])->name('visits.update');

// Delete visit
Route::delete('receptionist/{user}/visits/{visit}', [ReceptionController::class, 'deleteUserVisit'])->name('visits.delete');





Route::get('/patients/create', [ReceptionController::class, 'patient_create'])->name('patients.create');
Route::post('/patients/save', [ReceptionController::class, 'patient_save'])->name('patients.save');

Route::get('/patients/{id}/edit', [ReceptionController::class, 'patient_edit'])
    ->name('patients.edit');

Route::put('/patients/{id}/update', [ReceptionController::class, 'patient_update'])
    ->name('patients.update');

Route::get('/patients/{id}/delete', [ReceptionController::class, 'patient_delete'])
    ->name('patients.delete');