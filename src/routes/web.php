<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SchoolSubjectController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HeadWorkerController;


Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/', '/login');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

Route::middleware(['Zástupca firmy alebo organizácie'])->group(function () {

});

Route::middleware(['Vedúci pracoviska'])->group(function () {
    Route::get('/headworker/internship-details', [HeadWorkerController::class, 'index'])->name('headworker.internship_details');
    Route::post('/headworker/internship-details/update-status', [HeadWorkerController::class, 'update_status'])->name('headworker.internship_details.update_status');
    Route::post('/headworker/internship-details/update-worker', [HeadWorkerController::class, 'update_worker'])->name('headworker.internship_details.update_worker');
    Route::get('/headworker/internship-show/{id}', [HeadWorkerController::class, 'show'])->name('headworker.internship_show');
    Route::get('/headworker/company', [HeadWorkerController::class, 'company_index'])->name('headworker.company');
    Route::get('/headworker/company/{id}', [HeadWorkerController::class, 'company_show'])->name('headworker.company_show');
    Route::get('/headworker/report', [HeadWorkerController::class, 'report'])->name('headworker.report');
});

Route::middleware(['Poverený pracovník pracoviska'])->group(function () {
    Route::get('/worker/company', [WorkerController::class, 'company_index'])->name('worker.company');
    Route::post('/worker/company', [WorkerController::class, 'company_store'])->name('worker.company_store');
    Route::get('/worker/company/{id}', [WorkerController::class, 'company_show'])->name('worker.company_show');
    Route::get('/worker/company/{id}/edit', [WorkerController::class, 'company_edit'])->name('worker.company_edit');
    Route::put('/worker/company/{id}', [WorkerController::class, 'company_update'])->name('worker.company_update');
    Route::delete('/worker/company/{id}', [WorkerController::class, 'company_destroy'])->name('worker.company_destroy');
});

Route::middleware(['Študent'])->group(function () {
    Route::get('/student/subject', [StudentController::class, 'index'])->name('student.program_and_subject');
    Route::get('/student/subject/select_program', [StudentController::class, 'selectProgram'])->name('select-program');
    Route::post('/student/subject/select_program', [StudentController::class, 'selectProgram']);
    Route::post('/student/subject/assign_subject', [StudentController::class, 'assignSubject'])->name('assign-subject');
    Route::get('/student/internship-details', [StudentController::class, 'internshipDetails'])->name('student.internship_details');
    Route::post('/student/add-custom-internship', [StudentController::class, 'addCustomInternship'])->name('student.add_custom_internship');
    Route::get('/student/report', [StudentController::class, 'report'])->name('student.report');
    Route::get('/student/company', [StudentController::class, 'company_index'])->name('student.company');
    Route::post('/student/company', [StudentController::class, 'company_store'])->name('student.company_store');
    Route::get('/student/company/{id}', [StudentController::class, 'company_show'])->name('student.company_show');
    Route::get('/student/documents', [StudentController::class, 'documents'])->name('student.documents');
    Route::put('/student/documents', [StudentController::class, 'documents_update'])->name('student.documents_update');
    Route::get('student/documents/download/{id}', [StudentController::class, 'documents_download'])->name('student.documents_download');
    Route::delete('/student/documents/{id}', [StudentController::class, 'documents_destroy'])->name('student.documents_destroy');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/study_program', [StudyProgramController::class, 'index'])->name('study_program.index');
    Route::get('/study_program/{id}', [StudyProgramController::class, 'show'])->name('study_program.show');
    Route::get('/study_program/{id}/edit', [StudyProgramController::class, 'edit'])->name('study_program.edit');
    Route::put('/study_program/{id}', [StudyProgramController::class, 'update'])->name('study_program.update');
    Route::delete('/study_program/{id}', [StudyProgramController::class, 'destroy'])->name('study_program.destroy');
    Route::post('/study_program', [StudyProgramController::class, 'store'])->name('study_program.store');
    Route::get('/user_role', [UserRoleController::class, 'index'])->name('user_role.index');
    Route::post('/user_role', [UserRoleController::class, 'store'])->name('user_role.store');
    Route::get('/user_role/{id}', [UserRoleController::class, 'show'])->name('user_role.show');
    Route::get('/user_role/{id}/edit', [UserRoleController::class, 'edit'])->name('user_role.edit');
    Route::put('/user_role/{id}', [UserRoleController::class, 'update'])->name('user_role.update');
    Route::delete('/user_role/{id}', [UserRoleController::class, 'destroy'])->name('user_role.destroy');
    Route::get('/contract', [ContractController::class, 'index'])->name('contract.index');
    Route::get('/contract/{id}', [ContractController::class, 'show'])->name('contract.show');
    Route::get('/contract/{id}/edit', [ContractController::class, 'edit'])->name('contract.edit');
    Route::put('/contract/{id}', [ContractController::class, 'update'])->name('contract.update');
    Route::delete('/contract/{id}', [ContractController::class, 'destroy'])->name('contract.destroy');
    Route::post('/contract', [ContractController::class, 'store'])->name('contract.store');
    Route::get('/documents', [DocumentsController::class, 'index'])->name('documents.index');
    Route::post('/documents', [DocumentsController::class, 'store'])->name('documents.store');
    Route::get('/documents/{id}', [DocumentsController::class, 'show'])->name('documents.show');
    Route::get('/documents/{id}/edit', [DocumentsController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{id}', [DocumentsController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{id}', [DocumentsController::class, 'destroy'])->name('documents.destroy');
    Route::get('/download/{id}', [DocumentsController::class, 'download'])->name('download');
    Route::get('/address', [AddressController::class, 'index'])->name('address.index');
    Route::post('/address', [AddressController::class, 'store'])->name('address.store');
    Route::get('/address/{id}', [AddressController::class, 'show'])->name('address.show');
    Route::get('/address/{id}/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/address/{id}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/address/{id}', [AddressController::class, 'destroy'])->name('address.destroy');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::put('/user/{id}/password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/company', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/company/{id}', [CompanyController::class, 'show'])->name('company.show');
    Route::get('/company/{id}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('/company/{id}', [CompanyController::class, 'update'])->name('company.update');
    Route::delete('/company/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');
    Route::get('/school_subject', [SchoolSubjectController::class, 'index'])->name('school_subject.index');
    Route::get('/school_subject/{id}', [SchoolSubjectController::class, 'show'])->name('school_subject.show');
    Route::post('/school_subject', [SchoolSubjectController::class, 'store'])->name('school_subject.store');
    Route::get('/school_subject/create', [SchoolSubjectController::class, 'create'])->name('school_subject.create');
    Route::get('/school_subject/{id}/edit', [SchoolSubjectController::class, 'edit'])->name('school_subject.edit');
    Route::put('/school_subject/{id}', [SchoolSubjectController::class, 'update'])->name('school_subject.update');
    Route::delete('/school_subject/{id}', [SchoolSubjectController::class, 'destroy'])->name('school_subject.destroy');
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/{id}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::get('/feedback/{id}/edit', [FeedbackController::class, 'edit'])->name('feedback.edit');
    Route::put('/feedback/{id}', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
});