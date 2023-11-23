<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PagesController::class, 'homepage'])->name('pages.homepage');
Route::get('/about', [PagesController::class, 'about'])->name('pages.about');
Route::prefix('contact')->group(function () {
    Route::get('/', [PagesController::class, 'contact'])->name('pages.contact');
    Route::post('/', [PagesController::class, 'contactSubmit'])->name('pages.contact.create');
});
Route::get('/privacy-policy', [PagesController::class, 'privacyPolicy'])->name('pages.policy');
Route::prefix('recruiter')->group(function () {
    Route::get('detail/{uniqueId}/{name}', [PagesController::class, 'employerDetails'])->name('pages.recruiter.detail');
});
Route::prefix('candidate')->group(function () {
    Route::get('detail/{uniqueId}', [PagesController::class, 'candidateDetails'])->name('pages.candidate.detail');
});
Route::prefix('jobs')->group(function () {
    Route::get('search', [PagesController::class, 'jobSearch'])->name('pages.search');
    Route::get('detail/{uniqueId}/{titleSlug}', [PagesController::class, 'jobDetails'])->name('pages.jobs.detail');
    Route::get('apply/{uniqueId}', [PagesController::class, 'jobApplyIndex'])->name('pages.jobs.apply');
});

Route::redirect('login', '/auth/login', 301);
Route::redirect('register', '/auth/register', 301);
Route::redirect('admin', '/admin/login', 301);

Route::prefix('auth')->group(function () {
    Route::prefix('email')->group(function () {
        Route::get('verify', [AuthController::class, 'emailVerificationIndex'])->middleware(['auth'])->name('verification.notice');
        Route::get('verify/{id}/{hash}', [AuthController::class, 'emailVerification'])->middleware(['signed'])->name('verification.verify');
        Route::post('verification-notification', [AuthController::class, 'emailVerificationResend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    });
    Route::prefix('login')->group(function () {
        Route::get('/', [AuthController::class, 'login'])->name('login');
        Route::post('/', [AuthController::class, 'authenticate'])->name('login.authenticate');
    });
    Route::prefix('register')->group(function () {
        Route::get('/', [AuthController::class, 'register'])->name('register');
        Route::post('/', [AuthController::class, 'createAccount'])->name('register.account');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['verified', 'profile.completion'])->group(function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
            Route::prefix('candidate')->group(function () {
                Route::get('/', [CandidateController::class, 'index'])->name('dashboard.candidate.index');
                Route::prefix('profile')->group(function () {
                    Route::get('index', [CandidateController::class, 'profileIndex'])->name('dashboard.candidate.profile.index');
                    Route::post('index', [CandidateController::class, 'profileIndexUpdate'])->name('dashboard.candidate.profile.update');
                });
                Route::prefix('jobs')->group(function () {
                    Route::get('/', [CandidateController::class, 'jobsManage'])->name('dashboard.candidate.job.manage');
                    Route::get('/saved', [CandidateController::class, 'manageSavedJobs'])->name('dashboard.candidate.job.saved');
                    Route::post('/apply', [CandidateController::class, 'jobApplicationSubmission'])->name('dashboard.candidate.job.apply');
                    Route::post('/feedback', [CandidateController::class, 'jobApplicationFeedback'])->name('dashboard.candidate.job.feedback');
                    Route::post('/withdraw/{applicationId}', [CandidateController::class, 'withdrawApplication'])->name('dashboard.candidate.job.withdraw');
                });
                Route::prefix('resume')->group(function () {
                    Route::get('/', [CandidateController::class, 'resumeIndex'])->name('dashboard.candidate.resume');
                    Route::post('/', [CandidateController::class, 'resumeUpdate'])->name('dashboard.candidate.resume.update');
                    Route::prefix('education')->group(function () {
                        Route::get('/', [CandidateController::class, 'educationIndex'])->name('dashboard.candidate.resume.education.index');
                        Route::post('/', [CandidateController::class, 'educationUpdate'])->name('dashboard.candidate.resume.education.update');
                    });
                    Route::prefix('experience')->group(function () {
                        Route::get('/', [CandidateController::class, 'experienceIndex'])->name('dashboard.candidate.resume.experience.index');
                        Route::post('/', [CandidateController::class, 'experienceUpdate'])->name('dashboard.candidate.resume.experience.update');
                    });
                });
                Route::prefix('cv')->group(function () {
                    Route::get('/', [CandidateController::class, 'cvIndex'])->name('dashboard.candidate.cv.index');
                    Route::post('/', [CandidateController::class, 'cvUpdate'])->name('dashboard.candidate.cv.update');
                    Route::delete('{cvId}/delete', [CandidateController::class, 'cvDelete'])->name('dashboard.candidate.cv.delete');
                });
                Route::prefix('bookmark')->group(function () {
                    Route::post('{jobId}/add', [CandidateController::class, 'bookmarkJobAdd'])->name('dashboard.candidate.bookmark.add');
                    Route::post('{jobId}/remove', [CandidateController::class, 'bookmarkJobRemove'])->name('dashboard.candidate.bookmark.remove');
                });
            });
            Route::prefix('employer')->group(function () {
                Route::get('/', [EmployerController::class, 'index'])->name('dashboard.employer.index');
                Route::prefix('profile')->group(function () {
                    Route::get('index', [EmployerController::class, 'profileIndex'])->name('dashboard.employer.profile.index');
                    Route::post('index', [EmployerController::class, 'profileIndexUpdate'])->name('dashboard.employer.profile.update');
                });
                Route::prefix('jobs')->group(function () {
                    Route::get('create', [EmployerController::class, 'jobCreateIndex'])->name('dashboard.employer.job.index');
                    Route::post('create', [EmployerController::class, 'jobCreate'])->name('dashboard.employer.job.create');
                    Route::prefix('manage')->group(function () {
                        Route::get('/', [EmployerController::class, 'jobsManage'])->name('dashboard.employer.job.manage');
                        Route::get('/posted', [EmployerController::class, 'jobsPostedManage'])->name('dashboard.employer.job.posted');
                        Route::get('applications', [EmployerController::class, 'jobsApplicationManage'])->name('dashboard.employer.job.applications');
                        Route::get('applications/{jobReference}/applicants', [EmployerController::class, 'jobsApplicantManage'])->name('dashboard.employer.job.manage.applicant');
                        Route::delete('delete', [EmployerController::class, 'jobListingDelete'])->name('dashboard.employer.job.delete');
                    });
                    Route::prefix('decision')->group(function () {
                        Route::post('/', [EmployerController::class, 'jobsApplicantManageDecision'])->name('dashboard.employer.job.manage.decision');
                    });
                });
            });
            Route::prefix('notifications')->group(function () {
                Route::get('/', [DashboardController::class, 'jobNotification'])->name('dashboard.notification.index');
                Route::get('/option/{mode}/{notificationId}', [DashboardController::class, 'jobNotificationUpdate'])->name('dashboard.notification.update');
            });
            Route::prefix('password')->group(function () {
                Route::get('index', [DashboardController::class, 'passwordIndex'])->name('dashboard.password.index');
                Route::post('change', [DashboardController::class, 'passwordChange'])->name('dashboard.password.change');
            });
        });
    });
    Route::post('logout', [AuthController::class, 'logout'])->name('dashboard.logout');
});

Route::prefix('admin')->group(function () {
    Route::prefix('login')->group(function () {
        Route::get('/', [AuthController::class, 'adminLogin'])->name('admin.login');
        Route::post('/', [AuthController::class, 'adminAuthenticate'])->name('admin.login.authenticate');
    });
    Route::middleware(['auth:admin'])->group(function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('dashboard.admin.index');
            Route::prefix('feedbacks')->group(function () {
                Route::get('/', [AdminController::class, 'feedbacksIndex'])->name('dashboard.admin.feedbacks');
                Route::delete('/', [AdminController::class, 'feedbacksDelete'])->name('dashboard.admin.feedbacks.delete');
            });
            Route::get('/joblistings', [AdminController::class, 'joblistingsIndex'])->name('dashboard.admin.joblistings');
            Route::get('/jobseekers', [AdminController::class, 'jobseekersIndex'])->name('dashboard.admin.jobseekers');
            Route::get('/recruiters', [AdminController::class, 'recruitersIndex'])->name('dashboard.admin.recruiters');
            Route::prefix('member')->group(function () {
                Route::post('status', [AdminController::class, 'memberStatusUpdate'])->name('dashboard.admin.member.status');
                Route::delete('delete', [AdminController::class, 'memberDelete'])->name('dashboard.admin.member.delete');
            });
            Route::prefix('users')->group(function () {
                Route::get('list', [AdminController::class, 'adminsIndex'])->name('dashboard.admin.list');
                Route::post('status', [AdminController::class, 'adminStatusUpdate'])->name('dashboard.admin.list.status');
                Route::delete('delete', [AdminController::class, 'adminDelete'])->name('dashboard.admin.list.delete');
                Route::get('create', [AdminController::class, 'adminsCreateIndex'])->name('dashboard.admin.create.index');
                Route::post('create', [AdminController::class, 'adminsCreate'])->name('dashboard.admin.create');
            });
            Route::post('logout', [AuthController::class, 'adminLogout'])->name('dashboard.admin.logout');
            Route::prefix('password')->group(function () {
                Route::get('index', [AdminController::class, 'passwordIndex'])->name('dashboard.admin.password.index');
                Route::post('change', [AdminController::class, 'passwordChange'])->name('dashboard.admin.password.change');
            });
        });
    });
});
