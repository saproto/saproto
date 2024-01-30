<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AliasController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CodexController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DinnerformController;
use App\Http\Controllers\DinnerformOrderlineController;
use App\Http\Controllers\DmxController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EmailListController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HeaderImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IsAlfredThereController;
use App\Http\Controllers\JobofferController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\LeaderboardEntryController;
use App\Http\Controllers\MemberCardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MollieController;
use App\Http\Controllers\NarrowcastingController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OmNomController;
use App\Http\Controllers\OrderLineController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PhotoAdminController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfilePictureController;
use App\Http\Controllers\ProtubeController;
use App\Http\Controllers\QrAuthController;
use App\Http\Controllers\QueryController;
// use App\Http\Controllers\RadioController;
use App\Http\Controllers\RegistrationHelperController;
use App\Http\Controllers\RfidCardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\SmartXpScreenController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\StockMutationController;
use App\Http\Controllers\SurfConextController;
use App\Http\Controllers\TempAdminController;
use App\Http\Controllers\TFAController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TIPCieController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WallstreetController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

require 'minisites.php';

// Convention
/*
 * Route::controller(C::class)->prefix('section')->name('section::')->middleware(['some:middleware'])->group( function () {
 *      /. --- #perm# only ---. /
 *      Route::middleware(['permission:#perm#'])->group(function () {
 *          Route::post('delete', 'delete')->name('delete');
 *      });
 *
 *      /. --- Public Routes --- ./
 *      Route::#method#('url', 'controllerFn')->name('name');
 *  
 *      /. --- Catch alls  ---./ 
 *      Route::#method#('{id}', 'show')->('show')
 *
 * });
 *
 * */

/* Pass view name to body class */
View::composer('*', function ($view) {
    View::share('viewName', $view->getName());
});

Route::middleware('forcedomain')->group(function () {
    /* The main route for the frontpage. */
    Route::controller(HomeController::class)->group(function () {
        Route::get('developers', 'developers');
        Route::get('', 'show')->name('homepage');
        Route::get('fishcam', 'fishcam')->middleware(['member'])->name('fishcam');
    });

    Route::get('becomeamember', [UserDashboardController::class, 'becomeAMemberOf'])->name('becomeamember');

    /* Routes related to the header images. */
    Route::controller(HeaderImageController::class)->prefix('headerimage')->name('headerimage::')->middleware(['auth', 'permission:header-image'])->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'create')->name('add');
        Route::post('add', 'store')->name('add');
        Route::get('delete/{id}', 'destroy')->name('delete');
    });

    /* Routes for the search function. All public*/
    Route::controller(SearchController::class)->group(function () {
        Route::get('search', 'search')->name('search');
        Route::post('search', 'search')->name('search');
        Route::get('opensearch', 'openSearch')->name('search::opensearch');
        /* Routes for the UTwente address book. */
        Route::prefix('ldap')->name('ldap::')->middleware(['utwente'])->group(function () {
            Route::get('search', 'ldapSearch')->name('search');
            Route::post('search', 'ldapSearch')->name('search');
        });
    });

    /* Routes related to authentication. All public */
    Route::controller(AuthController::class)->name('login::')->group(function () {
        Route::get('login', 'getLogin')->name('show');
        Route::post('login', 'postLogin')->middleware(['throttle:5,1'])->name('post');
        Route::get('logout', 'getLogout')->name('logout');
        Route::get('logout/redirect', 'getLogoutRedirect')->name('logout::redirect');

        Route::get('password/reset/{token}', 'getPasswordReset')->name('resetpass::token');
        Route::post('password/reset', 'postPasswordReset')->middleware(['throttle:5,1'])->name('resetpass::submit');

        Route::get('password/email', 'getPasswordResetEmail')->name('resetpass');
        Route::post('password/email', 'postPasswordResetEmail')->middleware(['throttle:5,1'])->name('resetpass::send');

        Route::get('password/sync', 'getPasswordSync')->middleware(['auth'])->name('password::sync');
        Route::post('password/sync', 'postPasswordSync')->middleware(['throttle:5,1', 'auth'])->name('password::sync');

        Route::get('password/change', 'getPasswordChange')->middleware(['auth'])->name('password::change');
        Route::post('password/change', 'postPasswordChange')->middleware(['throttle:5,1', 'auth'])->name('password::change');

        Route::get('register', 'getRegister')->name('register');
        Route::post('register', 'postRegister')->middleware(['throttle:5,1'])->name('register');
        Route::post('register/surfconext', 'postRegisterSurfConext')->middleware(['throttle:5,1'])->name('register::surfconext');

        Route::get('surfconext', 'startSurfConextAuth')->name('edu');
        Route::get('surfconext/post', 'postSurfConextAuth')->name('edupost');

        Route::get('username', 'requestUsername')->name('requestusername');
        Route::post('username', 'requestUsername')->middleware(['throttle:5,1'])->name('requestusername');
    });

    /* Routes related to user profiles. */
    Route::prefix('user')->name('user::')->middleware(['auth'])->group(function () {

        /* --- Public routes ---- */
        Route::controller(AuthController::class)->group(function () {
            Route::post('delete', 'deleteUser')->name('delete'); // AuthController
            Route::post('password', 'updatePassword')->name('changepassword'); // AuthController
        });

        Route::get('personal_key', [UserDashboardController::class, 'generateKey'])->name('personal_key::generate'); // UserDashboardController

        Route::controller(UserDashboardController::class)->prefix('memberprofile')->name('memberprofile::')->middleware('auth')->group(function () {
            Route::get('complete', 'getCompleteProfile')->name('complete'); // UserDashboardController
            Route::post('complete', 'postCompleteProfile')->name('complete'); // UserDashboardController
            Route::get('clear', 'getClearProfile')->name('clear'); // UserDashboardController
            Route::post('clear', 'postClearProfile')->name('clear'); // UserDashboardController
        });

        Route::controller(UserDashboardController::class)->group(function () {
            Route::post('change_email', 'updateMail')->middleware(['throttle:3,1'])->name('changemail'); // UserDashboardController
            Route::get('dashboard', 'show')->name('dashboard'); // UserDashboardController
            Route::post('dashboard', 'update')->name('dashboard'); // UserDashboardController
        });

        Route::get('quit_impersonating', [UserAdminController::class, 'quitImpersonating'])->name('quitimpersonating'); // UserAdminController

        /* Routes related to addresses. */
        Route::controller(AddressController::class)->prefix('address')->name('address::')->group(function () {
            Route::get('add', 'add')->name('add'); // AddressController
            Route::post('add', 'store')->name('add'); // AddressController
            Route::get('delete', 'destroy')->name('delete'); // AddressController
            Route::get('edit', 'edit')->name('edit'); // AddressController
            Route::post('edit', 'update')->name('edit'); // AddressController
            Route::get('togglehidden', 'toggleHidden')->name('togglehidden'); // AddressController
        });

        /* Route(s) related to diet. */
        Route::post('diet/edit', [UserDashboardController::class, 'editDiet'])->name('diet::edit'); // UserDashboardController

        /* Routes related to bank accounts. */
        Route::controller(BankController::class)->prefix('bank')->name('bank::')->group(function () {
            Route::get('add', 'add')->name('add'); // BankController
            Route::post('add', 'store')->name('add'); // BankController
            Route::post('delete', 'destroy')->name('delete'); // BankController
            Route::get('edit', 'edit')->name('edit'); // BankController
            Route::post('edit', 'update')->name('edit'); // BankController
        });

        /* Routes related to RFID cards. */
        Route::controller(RfidCardController::class)->prefix('rfidcard/{id}')->name('rfid::')->group(function () {
            Route::get('delete', 'destroy')->name('delete'); // RfidCardController
            Route::get('edit', 'edit')->name('edit'); // RfidCardController
            Route::post('edit', 'update')->name('edit'); // RfidCardController
        });

        /* Routes related to profile pictures. */
        Route::controller(ProfilePictureController::class)->prefix('profilepic')->name('pic::')->group(function () {
            Route::post('update', 'update')->name('update'); // ProfilePictureController
            Route::get('delete', 'destroy')->name('delete'); // ProfilePictureController
        });

        /* Routes related to UT accounts. */
        Route::controller(SurfConextController::class)->prefix('edu')->name('edu::')->group(function () {
            Route::get('delete', 'destroy')->name('delete'); // SurfConextController
            Route::get('add', 'create')->name('add'); // SurfConextController
            Route::post('add', 'store')->name('add'); // SurfConextController
        });

        /* Routes related to 2FA. */
        Route::controller(TFAController::class)->prefix('2fa')->name('2fa::')->group(function () {
            Route::post('add', 'create')->name('add'); // TFAController
            Route::post('delete', 'destroy')->name('delete'); // TFAController
            Route::post('delete/{id}', 'adminDestroy')->middleware(['permission:board'])->name('admindelete'); // TFAController
        });

        /* --- Restricted routes ---- */

        /* Registration helper */
        Route::controller(RegistrationHelperController::class)->prefix('registrationhelper')->name('registrationhelper::')->middleware(['auth', 'permission:registermembers'])->group(function () {
            Route::get('', 'index')->name('list'); // RegistrationHelperController
            Route::get('{id}', 'details')->name('details'); // RegistrationHelperController
        });

        /* Routes related to member administration */
        Route::controller(UserAdminController::class)->prefix('{id}/member')->name('member::')->middleware(['auth', 'permission:registermembers'])->group(function () {
            /* Board only */
            // Impersonation
            Route::get('impersonate', 'impersonate')->middleware(['auth', 'permission:board'])->name('impersonate'); // UserAdminController
            // OmNomCom sound
            Route::prefix('omnomcomsound')->name('omnomcomsound::')->middleware(['auth', 'permission:board'])->group(function () {
                Route::post('update', 'uploadOmnomcomSound')->name('update'); // UserAdminController
                Route::get('delete', 'deleteOmnomcomSound')->name('delete'); // UserAdminController
            });
            Route::post('add', 'addMembership')->name('add'); // UserAdminController
            Route::post('remove', 'endMembership')->name('remove'); // UserAdminController
            Route::post('end_in_september', 'EndMembershipInSeptember')->name('endinseptember'); // UserAdminController
            Route::post('remove_end', 'removeMembershipEnd')->name('removeend'); // UserAdminController
            Route::post('settype', 'setMembershipType')->name('settype'); // UserAdminController

        });

        // User admin: Board only
        Route::controller(UserAdminController::class)->prefix('admin')->name('admin::')->middleware(['auth', 'permission:board'])->group(function () {
            Route::get('list', 'index')->name('list'); // UserAdminController

            Route::get('studied_create/{id}', 'toggleStudiedCreate')->name('toggle_studied_create'); // UserAdminController
            Route::get('studied_itech/{id}', 'toggleStudiedITech')->name('toggle_studied_itech'); // UserAdminController
            Route::get('nda/{id}', 'toggleNda')->middleware(['permission:board'])->name('toggle_nda'); // UserAdminController
            Route::get('unblock_omnomcom/{id}', 'unblockOmnomcom')->name('unblock_omnomcom'); // UserAdminController

            Route::get('{id}', 'details')->name('details'); // UserAdminController
            Route::post('{id}', 'update')->name('update'); // UserAdminController
        });

        Route::get('{id?}', [UserProfileController::class, 'show'])->middleware(['member'])->name('profile'); // UserProfileController

    });

    /* Routes related to the Membership Forms */
    Route::prefix('memberform')->name('memberform::')->middleware(['auth'])->group(function () {
        Route::controller(UserDashboardController::class)->group(function () {
            Route::get('sign', 'getMemberForm')->name('sign'); // UserDashboardController
            Route::post('sign', 'postMemberForm')->name('sign'); // UserDashboardController
        });
        Route::controller(UserAdminController::class)->group(function () {
            Route::prefix('download')->name('download::')->group(function () {
                Route::get('new/{id}', 'getNewMemberForm')->name('new'); // UserAdminController
                Route::get('signed/{id}', 'getSignedMemberForm')->name('signed'); // UserAdminController
            });
            // Member form management (Board)
            Route::post('print/{id}', 'printMemberForm')->middleware(['permission:board'])->name('print'); // UserAdminController
            Route::post('delete/{id}', 'destroyMemberForm')->middleware(['permission:board'])->name('delete'); // UserAdminController
        });
    });

    /* Routes related to committees. */
    Route::controller(CommitteeController::class)->prefix('committee')->name('committee::')->group(function () {
        /* --- Board only --- */
        Route::middleware(['auth', 'permission:board'])->group(function () {
            // Membership management
            Route::prefix('membership')->name('membership::')->group(function () {
                Route::post('add', 'addMembership')->name('add'); // CommitteeController
                Route::get('end/{committee}/{edition}', 'endEdition')->name('endedition'); // CommitteeController
                Route::get('{id}/delete', 'deleteMembership')->name('delete'); // CommitteeController
                Route::get('{id}', 'editMembershipForm')->name('edit'); // CommitteeController
                Route::post('{id}', 'editMembership')->name('edit'); // CommitteeController
            });

            // Committee management
            Route::get('add', 'add')->name('add'); // CommitteeController
            Route::post('add', 'store')->name('add'); // CommitteeController
            Route::get('{id}/edit', 'edit')->name('edit'); // CommitteeController
            Route::post('{id}/edit', 'update')->name('edit'); // CommitteeController
            Route::post('{id}/image', 'image')->name('image'); // CommitteeController

        });
        
        /* --- Public routes --- */
        Route::get('list', 'overview')->name('list'); // CommitteeController
        Route::get('{id}', 'show')->name('show'); // CommitteeController
        Route::get('{id}/send_anonymous_email', 'showAnonMailForm')->middleware(['auth', 'member'])->name('anonymousmail'); // CommitteeController
        Route::post('{id}/send_anonymous_email', 'postAnonMailForm')->middleware(['auth', 'member'])->name('anonymousmail'); // CommitteeController
        Route::get('{slug}/toggle_helper_reminder', 'toggleHelperReminder')->middleware(['auth'])->name('toggle_helper_reminder'); // CommitteeController
    });

    /* Routes related to societies. */
    Route::controller(CommitteeController::class)->prefix('society')->name('society::')->group(function () {
        Route::get('list', 'overview')->name('list')->defaults('showSociety', true);
        Route::get('{id}', 'show')->name('show'); // CommitteeController
    });

    /* Routes related to narrowcasting (Board only). */
    Route::controller(NarrowcastingController::class)->prefix('narrowcasting')->name('narrowcasting::')->group(function () {
        Route::middleware(['auth', 'permission:board'])->group(function () { 
            Route::get('list', 'index')->name('list'); // NarrowcastingController
            Route::get('add', 'create')->name('add'); // NarrowcastingController
            Route::post('add', 'store')->name('add'); // NarrowcastingController
            Route::get('edit/{id}', 'edit')->name('edit'); // NarrowcastingController
            Route::post('edit/{id}', 'update')->name('edit'); // NarrowcastingController
            Route::get('delete/{id}', 'destroy')->name('delete'); // NarrowcastingController
            Route::get('clear', 'clear')->name('clear'); // NarrowcastingController
        });
        Route::get('', 'show')->name('display'); // NarrowcastingController
    });

    /* Routes related to companies. */
    Route::controller(CompanyController::class)->prefix('companies')->name('companies::')->group(function () {

        /* --- Board only --- */
        Route::middleware(['auth', 'permission:board'])->group(function () {
            Route::get('list', 'adminIndex')->name('admin'); // CompanyController
            Route::get('add', 'create')->name('add'); // CompanyController
            Route::post('add', 'store')->name('add'); // CompanyController
            Route::get('edit/{id}', 'edit')->name('edit'); // CompanyController
            Route::post('edit/{id}', 'update')->name('edit'); // CompanyController
            Route::get('delete/{id}', 'destroy')->name('delete'); // CompanyController

            Route::get('up/{id}', 'orderUp')->name('orderUp'); // CompanyController
            Route::get('down/{id}', 'orderDown')->name('orderDown'); // CompanyController
        });
        
        /* --- Public routes --- */
        Route::get('index', 'index')->name('index'); // CompanyController
        Route::get('{id}', 'show')->name('show'); // CompanyController
    });

    /* Routes related to membercard. */
    Route::prefix('membercard')->name('membercard::')->group(function () {
        Route::controller(CompanyController::class)->group(function () {
            Route::get('index', 'indexmembercard')->name('index'); // CompanyController
            Route::get('{id}', 'showmembercard')->name('show'); // CompanyController
        });

        Route::controller(MemberCardController::class)->group(function () {
            Route::post('print', 'startPrint')->middleware(['auth', 'permission:board'])->name('print'); // MemberCardController
            Route::get('download/{id}', 'download')->name('download'); // MemberCardController
        });
    });

    /* Routes related to joboffers. */
    Route::controller(JobofferController::class)->prefix('joboffers')->name('joboffers::')->group(function () {
        /* --- Board only --- */
        Route::middleware(['auth', 'permission:board'])->group(function () {
            Route::get('list', 'adminIndex')->name('admin'); // JobofferController

            Route::get('add', 'create')->name('add'); // JobofferController
            Route::post('add', 'store')->name('add'); // JobofferController

            Route::get('edit/{id}', 'edit')->name('edit'); // JobofferController
            Route::post('edit/{id}', 'update')->name('edit'); // JobofferController

            Route::get('delete/{id}', 'destroy')->name('delete'); // JobofferController
        });
        /* --- Public routes --- */
        Route::get('index', 'index')->name('index'); // JobofferController
        Route::get('{id}', 'show')->name('show'); // JobofferController
    });

    /* Routes related to leaderboards. */
    Route::prefix('leaderboards')->name('leaderboards::')->middleware(['auth', 'member'])->group(function () {
        Route::controller(LeaderboardController::class)->group(function () {

            /* Committee dependent */
            Route::get('list', 'adminIndex')->name('admin'); // LeaderboardController
            Route::get('edit/{id}', 'edit')->name('edit'); // LeaderboardController
            Route::post('edit/{id}', 'update')->name('edit'); // LeaderboardController

            /* Board only */
            Route::middleware(['permission:board'])->group(function () {
                Route::get('add', 'create')->name('add'); // LeaderboardController
                Route::post('add', 'store')->name('add'); // LeaderboardController
                Route::get('delete/{id}', 'destroy')->name('delete'); // LeaderboardController
            });

            // Public route
            Route::get('', 'index')->name('index'); // LeaderboardController

        });

        /* Committee dependent */
        Route::controller(LeaderboardEntryController::class)->prefix('entries')->name('entries::')->group(function () {
            Route::post('add', 'store')->name('add'); // LeaderboardEntryController
            Route::post('update', 'update')->name('update'); // LeaderboardEntryController
            Route::get('delete/{id}', 'destroy')->name('delete'); // LeaderboardEntryController
        });
    });

    /* Routes related to dinnerforms. */
    Route::prefix('dinnerform')->name('dinnerform::')->middleware(['auth'])->group(function () {

        /* TIPCie only */
        Route::controller(DinnerformController::class)->middleware(['permission:tipcie'])->group(function () {
            Route::get('add', 'create')->name('add'); // DinnerformController
            Route::post('add', 'store')->name('add'); // DinnerformController
            Route::get('edit/{id}', 'edit')->name('edit'); // DinnerformController
            Route::post('edit/{id}', 'update')->name('edit'); // DinnerformController
            Route::get('close/{id}', 'close')->name('close'); // DinnerformController
            Route::get('delete/{id}', 'destroy')->name('delete'); // DinnerformController
            Route::get('admin/{id}', 'admin')->name('admin'); // DinnerformController
            Route::get('process/{id}', 'process')->name('process'); // DinnerformController
        });
        Route::controller(DinnerformOrderlineController::class)->prefix('orderline')->name('orderline::')->middleware(['permission:tipcie'])->group(function () {
            Route::get('delete/{id}', 'delete')->name('delete'); // DinnerformOrderlineController
            Route::get('edit/{id}', 'edit')->name('edit'); // DinnerformOrderlineController
            Route::post('add/{id}', 'store')->name('add'); // DinnerformOrderlineController
            Route::post('update/{id}', 'update')->name('update'); // DinnerformOrderlineController
        });
        // Public route
        Route::get('{id}', [DinnerformController::class, 'show'])->name('show'); // DinnerformController
    });

    /* Routes related to the wallstreet drink system (TIPCie only) */
    Route::controller(WallstreetController::class)->prefix('wallstreet')->name('wallstreet::')->middleware(['permission:tipcie'])->group(function () {
        Route::get('', 'admin')->name('admin'); // WallstreetController
        Route::get('marquee', 'marquee')->name('marquee'); // WallstreetController
        Route::post('add', 'store')->name('add'); // WallstreetController
        Route::get('close/{id}', 'close')->name('close'); // WallstreetController
        Route::get('edit/{id}', 'edit')->name('edit'); // WallstreetController
        Route::post('edit/{id}', 'update')->name('edit'); // WallstreetController
        Route::get('delete/{id}', 'destroy')->name('delete'); // WallstreetController
        Route::get('statistics/{id}', 'statistics')->name('statistics'); // WallstreetController
        route::prefix('products')->name('products::')->group(function () {
            Route::post('add/{id}', 'addProducts')->name('add'); // WallstreetController
            Route::get('remove/{id}/{productId}', 'removeProduct')->name('remove'); // WallstreetController
        });
    });

    /*
     * Routes related to events.
     * Important: routes in this block always use event_id or a relevant other ID. activity_id is in principle never used.
     */
    Route::prefix('events')->name('event::')->group(function () {
        Route::controller(EventController::class)->group(function () {
            
            // Financials related to events (Finadmin only)
            Route::prefix('financial')->name('financial::')->middleware('permission:finadmin')->group(function () {
                Route::get('list', 'finindex')->name('list'); // EventController
                Route::post('close/{id}', 'finclose')->name('close'); // EventController
            });




            // Event related admin (Board only)
            Route::middleware(['permission:board'])->group(function () {
                // Categories
                Route::prefix('categories')->name('category::')->group(function () {
                    Route::get('list', 'categoryAdmin')->name('admin'); // EventController
                    Route::post('add', 'categoryStore')->name('add'); // EventController
                    Route::get('edit/{id}', 'categoryEdit')->name('edit'); // EventController
                    Route::post('edit/{id}', 'categoryUpdate')->name('edit'); // EventController
                    Route::get('delete/{id}', 'categoryDestroy')->name('delete'); // EventController
                });

                // Events admin
                Route::get('add', 'create')->name('add'); // EventController
                Route::post('add', 'store')->name('add'); // EventController
                Route::get('edit/{id}', 'edit')->name('edit'); // EventController
                Route::post('edit/{id}', 'update')->name('edit'); // EventController
                Route::get('delete/{id}', 'destroy')->name('delete'); // EventController

                // Albums
                Route::post('album/{event}/link', 'linkAlbum')->name('linkalbum'); // EventController
                Route::get('album/unlink/{album}', 'unlinkAlbum')->name('unlinkalbum'); // EventController
            });

            /* --- Public routes --- */
            Route::get('', 'index')->name('list'); // EventController
            Route::get('archive/{year}', 'archive')->name('archive'); // EventController
            Route::post('copy', 'copyEvent')->name('copy'); // EventController

            /* --- Catch-alls --- */
            Route::get('admin/{id}', 'admin')->middleware(['auth'])->name('admin'); // EventController
            Route::get('scan/{id}', 'scan')->middleware(['auth'])->name('scan'); // EventController

            Route::post('set_reminder', 'setReminder')->middleware(['auth'])->name('set_reminder'); // EventController
            Route::get('toggle_relevant_only', 'toggleRelevantOnly')->middleware(['auth'])->name('toggle_relevant_only'); // EventController

            // Force login for event
            Route::get('{id}/login', 'forceLogin')->middleware(['auth'])->name('login'); // EventController
            // Show event 
            Route::get('{id}', 'show')->name('show'); // EventController
        });

        // Related to presence & participation
        Route::controller(ParticipationController::class)->group(function () {
            /* --- Public routes --- */
            Route::get('togglepresence/{id}', 'togglePresence')->middleware(['auth'])->name('togglepresence'); // ParticipationController

            // Manage participation
            Route::get('participate/{id}', 'create')->middleware(['member'])->name('addparticipation'); // ParticipationController
            Route::get('unparticipate/{participation_id}', 'destroy')->name('deleteparticipation'); // ParticipationController

            // Participate for someone else (Board only)
            Route::post('participatefor/{id}', 'createFor')->middleware(['permission:board'])->name('addparticipationfor'); // ParticipationController

        });

        // Buy tickets for an event (Public)
        Route::post('buytickets/{id}', [TicketController::class, 'buyForEvent'])->middleware(['auth'])->name('buytickets'); // TicketController

        Route::controller(ActivityController::class)->group(function () {

            /* ---  Board only admin --- */
            Route::middleware(['permission:board'])->group(function () {
                // Related to activities
                Route::post('signup/{id}', 'store')->middleware(['permission:board'])->name('addsignup'); // ActivityController
                Route::get('signup/{id}/delete', 'destroy')->middleware(['permission:board'])->name('deletesignup'); // ActivityController

                // Related to helping committees
                Route::post('addhelp/{id}', 'addHelp')->middleware(['permission:board'])->name('addhelp'); // ActivityController
                Route::post('updatehelp/{id}', 'updateHelp')->middleware(['permission:board'])->name('updatehelp'); // ActivityController
                Route::get('deletehelp/{id}', 'deleteHelp')->middleware(['permission:board'])->name('deletehelp'); // ActivityController
            });
            /*  --- Public routes ---  */
            Route::get('checklist/{id}', 'checklist')->name('checklist'); // ActivityController
        });

    });

    /* Routes related to pages. */
    Route::controller(PageController::class)->prefix('page')->name('page::')->group(function () {

        /* --- Board only --- */
        Route::middleware(['auth', 'permission:board'])->group(function () {
            Route::get('', 'index')->name('list'); // PageController
            Route::get('add', 'create')->name('add'); // PageController
            Route::post('add', 'store')->name('add'); // PageController
            Route::get('edit/{id}', 'edit')->name('edit'); // PageController
            Route::post('edit/{id}', 'update')->name('edit'); // PageController
            Route::post('edit/{id}/image', 'featuredImage')->name('image'); // PageController
            Route::get('delete/{id}', 'destroy')->name('delete'); // PageController

            Route::prefix('/edit/{id}/file')->name('file::')->group(function () {
                Route::post('add', 'addFile')->name('add'); // PageController
                Route::get('{file_id}/delete', 'deleteFile')->name('delete'); // PageController
            });
        });

        /* --- Public --- */
        Route::get('{slug}', 'show')->name('show'); // PageController
    });

    /* Routes related to news. */
    Route::controller(NewsController::class)->prefix('news')->name('news::')->middleware(['member'])->group(function () {

        /* --- Board only --- */
        Route::middleware(['auth', 'permission:board'])->group(function () {
            Route::get('admin', 'admin')->name('admin'); // NewsController
            Route::get('add', 'create')->name('add'); // NewsController
            Route::post('add', 'store')->name('add'); // NewsController
            Route::get('edit/{id}', 'edit')->name('edit'); // NewsController
            Route::post('edit/{id}', 'update')->name('edit'); // NewsController
            Route::post('edit/{id}/image', 'featuredImage')->name('image'); // NewsController
            Route::get('delete/{id}', 'destroy')->name('delete'); // NewsController
            Route::get('sendWeekly/{id}', 'sendWeeklyEmail')->name('sendWeekly'); // NewsController
        });
        /* --- Member only --- */
        Route::get('showWeeklyPreview/{id}', 'showWeeklyPreview')->name('showWeeklyPreview'); // NewsController
        Route::get('list', 'index')->name('list'); // NewsController
        Route::get('{id}', 'show')->name('show'); // NewsController
    });

    /* Routes related to menu. (Board only) */
    Route::controller(MenuController::class)->prefix('menu')->name('menu::')->middleware(['auth', 'permission:board'])->group(function () {
        Route::get('', 'index')->name('list'); // MenuController
        Route::get('add', 'create')->name('add'); // MenuController
        Route::post('add', 'store')->name('add'); // MenuController

        Route::get('up/{id}', 'orderUp')->name('orderUp'); // MenuController
        Route::get('down/{id}', 'orderDown')->name('orderDown'); // MenuController

        Route::get('edit/{id}', 'edit')->name('edit'); // MenuController
        Route::post('edit/{id}', 'update')->name('edit'); // MenuController
        Route::get('delete/{id}', 'destroy')->name('delete'); // MenuController
    });

    /* Routes related to tickets. */
    Route::controller(TicketController::class)->prefix('tickets')->name('tickets::')->middleware(['auth'])->group(function () {
        // Board only admin
        Route::middleware(['auth', 'permission:board'])->group(function () {
            Route::get('', 'index')->name('list'); // TicketController
            Route::get('add', 'create')->name('add'); // TicketController
            Route::post('add', 'store')->name('add'); // TicketController
            Route::get('edit/{id}', 'edit')->name('edit'); // TicketController
            Route::post('edit/{id}', 'update')->name('edit'); // TicketController
            Route::get('delete/{id}', 'destroy')->name('delete'); // TicketController
        });

        /*  Public Routes  */
        Route::get('scan/{barcode}', 'scan')->name('scan'); // TicketController
        Route::get('unscan/{barcode?}', 'unscan')->name('unscan'); // TicketController
        Route::get('download/{id}', 'download')->name('download'); // TicketController
    });

    /* Routes related to e-mail. (Board only) */
    Route::prefix('email')->name('email::')->middleware(['auth', 'permission:board'])->group(function () {
        Route::controller(EmailListController::class)->prefix('list')->name('list::')->group(function () {
            Route::get('add', 'create')->name('add'); // EmailListController
            Route::post('add', 'store')->name('add'); // EmailListController
            Route::get('edit/{id}', 'edit')->name('edit'); // EmailListController
            Route::post('edit/{id}', 'update')->name('edit'); // EmailListController
            Route::get('delete/{id}', 'destroy')->name('delete'); // EmailListController
        });

        Route::controller(EmailController::class)->group(function () {
            Route::get('', 'index')->name('admin'); // EmailController
            Route::get('filter', 'filter')->name('filter'); // EmailController

            Route::get('add', 'create')->name('add'); // EmailController
            Route::post('add', 'store')->name('add'); // EmailController
            Route::get('preview/{id}', 'show')->name('show'); // EmailController
            Route::get('edit/{id}', 'edit')->name('edit'); // EmailController
            Route::post('edit/{id}', 'update')->name('edit'); // EmailController
            Route::get('toggleready/{id}', 'toggleReady')->name('toggleready'); // EmailController
            Route::get('delete/{id}', 'destroy')->name('delete'); // EmailController

            Route::prefix('{id}/attachment')->name('attachment::')->group(function () {
                Route::post('add', 'addAttachment')->name('add'); // EmailController
                Route::get('delete/{file_id}', 'deleteAttachment')->name('delete'); // EmailController
            });
        });
    });

    /* Public Routes for e-mail */
    Route::get('togglelist/{id}', [EmailListController::class, 'toggleSubscription'])->middleware(['auth'])->name('togglelist'); // EmailListController
    Route::get('unsubscribe/{hash}', [EmailController::class, 'unsubscribeLink'])->name('unsubscribefromlist'); // EmailController
    Route::get('quotes', ['middleware' => ['member'], 'as' => 'quotes::list', function (Illuminate\Http\Request $request) {
        return (new FeedbackController())->index($request, 'quotes');
    }]);
    Route::get('goodideas', ['middleware' => ['member'], 'as' => 'goodideas::index', function (Illuminate\Http\Request $request) {
        return (new FeedbackController())->index($request, 'goodideas');
    }]);

    /* Routes related to the Feedback Boards. */
    Route::controller(FeedbackController::class)->prefix('feedback')->middleware(['member'])->name('feedback::')->group(function () {

        Route::prefix('categories')->middleware(['permission:board'])->name('category::')->group(function () {
            Route::get('admin', 'categoryAdmin')->name('admin'); // FeedbackController
            Route::post('addone', 'categoryStore')->name('add'); // FeedbackController
            Route::get('edit/{id}', 'categoryEdit')->name('edit'); // FeedbackController
            Route::post('edit/{id}', 'categoryUpdate')->name('edit'); // FeedbackController
            Route::get('delete/{id}', 'categoryDestroy')->name('delete'); // FeedbackController
        });

        /* -- Public routes -- */
        Route::get('approve/{id}', 'approve')->name('approve'); // FeedbackController
        Route::post('reply/{id}', 'reply')->name('reply'); // FeedbackController
        Route::get('archive/{id}', 'archive')->name('archive'); // FeedbackController
        Route::get('restore/{id}', 'restore')->name('restore'); // FeedbackController
        Route::get('delete/{id}', 'delete')->name('delete'); // FeedbackController
        Route::post('vote', 'vote')->name('vote'); // FeedbackController
        
        /* -- Catch-alls -- */
        Route::prefix('/{category}')->group(function () {
            Route::get('index', 'index')->name('index'); // FeedbackController
            Route::get('search/{searchTerm?}', 'search')->name('search'); // FeedbackController
            Route::get('archived', 'archived')->name('archived'); // FeedbackController
            Route::post('add', 'add')->name('add'); // FeedbackController
            Route::get('archiveall', 'archiveAll')->middleware(['permission:board'])->name('archiveall'); // FeedbackController
        });
    });

    /* Routes related to the OmNomCom. */
    Route::prefix('omnomcom')->name('omnomcom::')->group(function () {
        /* Pubic routes */
        Route::get('minisite', ['uses' => 'OmNomController@miniSite']);

        /* Routes related to OmNomCom stores. */
        Route::prefix('store')->name('store::')->group(function () {
            Route::controller(OmNomController::class)->group(function () {
                Route::get('', 'choose')->middleware(['auth'])->name('show'); // OmNomController
                Route::get('{store?}', 'display')->name('show'); // OmNomController
                Route::post('{store}/buy', 'buy')->name('buy'); // OmNomController
            });
            Route::post('rfid/add', [RfidCardController::class, 'store'])->name('rfidadd'); // RfidCardController
        });

        /* Routes related to OmNomCom orders. */
        Route::controller(OrderLineController::class)->group(function () {

            Route::prefix('orders')->middleware(['auth'])->name('orders::')->group(function () {
                // Public
                Route::get('history/{date?}', 'index')->name('list'); // OrderLineController
                Route::get('orderline-wizard', 'orderlineWizard')->name('orderline-wizard'); // OrderLineController

                // OmNomCom admins only
                Route::middleware(['permission:omnomcom'])->group(function () {
                    Route::post('add/bulk', 'bulkStore')->name('addbulk'); // OrderLineController
                    Route::post('add/single', 'store')->name('add'); // OrderLineController
                    Route::get('delete/{id}', 'destroy')->name('delete'); // OrderLineController
                    Route::get('', 'adminindex')->name('adminlist'); // OrderLineController

                    Route::prefix('filter')->name('filter::')->group(function () {
                        Route::get('name/{name?}', 'filterByUser')->name('name'); // OrderLineController
                        Route::get('date/{date?}', 'filterByDate')->name('date'); // OrderLineController
                    });
                });

            });

            /* Routes related to Payment Statistics. */
            Route::prefix('payments')->name('payments::')->middleware(['permission:finadmin'])->group(function () {
                Route::get('statistics', 'showPaymentStatistics')->name('statistics'); // OrderLineController
                Route::post('statistics', 'showPaymentStatistics')->name('statistics'); // OrderLineController
            });
        });

        /* Routes related to the TIPCie OmNomCom store. */
        Route::get('tipcie', [TIPCieController::class, 'orderIndex'])->middleware(['auth', 'permission:tipcie'])->name('tipcie::orderhistory'); // TIPCieController

        /* Routes related to Financial Accounts. (Finadmin only) */
        Route::controller(AccountController::class)->prefix('accounts')->name('accounts::')->middleware(['permission:finadmin'])->group(function () {
            Route::get('list', 'index')->name('list'); // AccountController
            Route::get('add', 'create')->name('add'); // AccountController
            Route::post('add', 'store')->name('add'); // AccountController
            Route::post('aggregate/{account}', 'showAggregation')->name('aggregate'); // AccountController
            Route::get('edit/{id}', 'edit')->name('edit'); // AccountController
            Route::post('edit/{id}', 'update')->name('edit'); // AccountController
            Route::get('delete/{id}', 'destroy')->name('delete'); // AccountController
            Route::get('{id}', 'show')->name('show'); // AccountController
        });

        /* Routes related to managing Products. (Omnomcom admins only) */
        Route::prefix('products')->middleware(['permission:omnomcom'])->name('products::')->group(function () {
            Route::controller(ProductController::class)->group(function () {
                Route::get('', 'index')->name('list'); // ProductController
                Route::get('add', 'create')->name('add'); // ProductController
                Route::post('add', 'store')->name('add'); // ProductController
                Route::get('edit/{id}', 'edit')->name('edit'); // ProductController
                Route::post('edit/{id}', 'update')->name('edit'); // ProductController
                Route::get('delete/{id}', 'destroy')->name('delete'); // ProductController

                Route::get('export/csv', 'generateCsv')->name('export_csv'); // ProductController
                Route::post('update/bulk', 'bulkUpdate')->name('bulkupdate'); // ProductController
            });

            Route::controller(AccountController::class)->group(function () {
                Route::get('statistics', 'showOmnomcomStatistics')->name('statistics'); // AccountController
                Route::post('statistics', 'showOmnomcomStatistics')->name('statistics'); // AccountController
            });

            Route::controller(StockMutationController::class)->group(function () {
                Route::get('mut', 'index')->name('mutations'); // StockMutationController
                Route::get('mut/csv', 'generateCsv')->name('mutations_export'); // StockMutationController
            });
        });

        /* Routes related to OmNomCom Categories. (OmNomCom admins only) */
        Route::controller(ProductCategoryController::class)->prefix('categories')->middleware(['permission:omnomcom'])->name('categories::')->group(function () {
            Route::get('', 'index')->name('list'); // ProductCategoryController
            Route::get('add', 'create')->name('add'); // ProductCategoryController
            Route::post('add', 'store')->name('add'); // ProductCategoryController
            Route::post('edit/{id}', 'update')->name('edit'); // ProductCategoryController
            Route::get('delete/{id}', 'destroy')->name('delete'); // ProductCategoryController
            Route::get('{id}', 'show')->name('show'); // ProductCategoryController
        });

        /* Routes related to Withdrawals. */
        Route::controller(WithdrawalController::class)->group(function () {
            /* --- Public routes --- */
            Route::get('mywithdrawal/{id}', 'showForUser')->middleware(['auth'])->name('mywithdrawal'); // WithdrawalController
            Route::get('unwithdrawable', ['middleware' => ['permission:finadmin'], 'as' => 'unwithdrawable', 'uses' => 'WithdrawalController@unwithdrawable']);

            /* --- Finadmin only --- */
            Route::prefix('withdrawals')->middleware(['permission:finadmin'])->name('withdrawal::')->group(function () {
                Route::get('', 'index')->name('list'); // WithdrawalController
                Route::get('add', 'create')->name('add'); // WithdrawalController
                Route::post('add', 'store')->name('add'); // WithdrawalController
                Route::post('edit/{id}', 'update')->name('edit'); // WithdrawalController
                Route::get('delete/{id}', 'destroy')->name('delete'); // WithdrawalController
                Route::get('accounts/{id}', 'showAccounts')->name('showAccounts'); // WithdrawalController

                Route::get('export/{id}', 'export')->name('export'); // WithdrawalController
                Route::get('close/{id}', 'close')->name('close'); // WithdrawalController
                Route::get('email/{id}', 'email')->name('email'); // WithdrawalController

                Route::get('deletefrom/{id}/{user_id}', 'deleteFrom')->name('deleteuser'); // WithdrawalController
                Route::get('markfailed/{id}/{user_id}', 'markFailed')->name('markfailed'); // WithdrawalController
                Route::get('markloss/{id}/{user_id}', 'markLoss')->name('markloss'); // WithdrawalController
                
                // Catchall 
                Route::get('{id}', 'show')->name('show'); // WithdrawalController
            });
        });

        /* Routes related to Mollie. */
        Route::controller(MollieController::class)->prefix('mollie')->middleware(['auth'])->name('mollie::')->group(function () {
            /*Public routes */
            Route::post('pay', 'pay')->name('pay'); // MollieController
            Route::get('status/{id}', 'status')->name('status'); // MollieController
            Route::get('receive/{id}', 'receive')->name('receive'); // MollieController

            /* Finadmin only */
            Route::get('list', 'index')->middleware(['permission:finadmin'])->name('list'); // MollieController
            Route::get('monthly/{month}', 'monthly')->middleware(['permission:finadmin'])->name('monthly'); // MollieController
        });
        // Order generation (omnomcom admin only)
        Route::get('supplier', [OmNomController::class, 'generateOrder'])->middleware(['permission:omnomcom'])->name('generateorder'); // OmNomController
    });

    /* Routes related to webhooks. */
    Route::any('webhook/mollie/{id}', [MollieController::class, 'webhook'])->name('webhook::mollie');

    /* Routes related to YouTube videos. */
    Route::controller(VideoController::class)->prefix('video')->name('video::')->group(function () {
        Route::prefix('admin')->middleware(['permission:board'])->name('admin::')->group(function () {
            Route::get('', 'index')->name('index'); // VideoController
            Route::post('add', 'store')->name('add'); // VideoController
            Route::get('edit/{id}', 'edit')->name('edit'); // VideoController
            Route::post('edit/{id}', 'update')->name('edit'); // VideoController
            Route::get('delete/{id}', 'destroy')->name('delete'); // VideoController
        });
        Route::get('', 'publicIndex')->name('index'); // VideoController
        Route::get('{id}', 'view')->name('view'); // VideoController
    });

    /* Routes related to announcements. */
    Route::controller(AnnouncementController::class)->prefix('announcement')->name('announcement::')->group(function () {
        Route::prefix('admin')->middleware(['permission:sysadmin'])->group(function () {
            Route::get('', 'index')->name('index'); // AnnouncementController
            Route::get('add', 'create')->name('add'); // AnnouncementController
            Route::post('add', 'store')->name('add'); // AnnouncementController
            Route::get('edit/{id}', 'edit')->name('edit'); // AnnouncementController
            Route::post('edit/{id}', 'update')->name('edit'); // AnnouncementController
            Route::get('delete/{id}', 'destroy')->name('delete'); // AnnouncementController
            Route::get('clear', 'clear')->name('clear'); // AnnouncementController
        });
        Route::get('dismiss/{id}', 'dismiss')->name('dismiss'); // AnnouncementController
    });

    /* Routes related to photos. */
    Route::prefix('photos')->name('photo::')->group(function () {
        /* --- Public routes --- */
        Route::controller(PhotoController::class)->group(function () { 
            Route::get('', 'index')->name('albums'); // PhotoController
            Route::get('slideshow', 'slideshow')->name('slideshow'); // PhotoController

            Route::get('/like/{id}', 'likePhoto')->middleware(['auth'])->name('likes'); // PhotoController
            Route::get('/dislike/{id}', 'dislikePhoto')->middleware(['auth'])->name('dislikes'); // PhotoController
            Route::get('/photo/{id}', 'photo')->name('view'); // PhotoController
            Route::get('{id}', 'show')->name('album::list');
        }); 

        /* Routes related to the photo admin. (Protography only) */
        Route::controller(PhotoAdminController::class)->prefix('admin')->middleware(['permission:protography'])->name('admin::')->group(function () {
            Route::get('index', 'index')->name('index'); // PhotoAdminController
            Route::post('index', 'search')->name('index'); // PhotoAdminController
            Route::post('add', 'create')->name('add'); // PhotoAdminController
            Route::get('edit/{id}', 'edit')->name('edit'); // PhotoAdminController
            Route::post('edit/{id}', 'update')->middleware(['permission:publishalbums'])->name('edit'); // PhotoAdminController
            Route::post('edit/{id}/action', 'action')->name('action'); // PhotoAdminController
            Route::post('edit/{id}/upload', 'upload')->name('upload'); // PhotoAdminController
            Route::get('edit/{id}/delete', 'delete')->middleware(['permission:publishalbums'])->name('delete'); // PhotoAdminController
            Route::get('publish/{id}', 'publish')->middleware(['permission:publishalbums'])->name('publish'); // PhotoAdminController
            Route::get('unpublish/{id}', 'unpublish')->middleware(['permission:publishalbums'])->name('unpublish'); // PhotoAdminController
        });
    });

    // Fetching images: Public
    Route::controller(FileController::class)->prefix('image')->name('image::')->group(function () {
        Route::get('{id}/{hash}', 'getImage')->name('get'); // FileController
        Route::get('{id}/{hash}/{name}', 'getImage');
    });

    /* Routes related to Spotify. (Board) */
    Route::get('spotify/oauth', [SpotifyController::class, 'oauthTool'])->name('spotify::oauth')->middleware(['auth', 'permission:board']); // SpotifyController

    /* Routes related to roles and permissions. (Sysadmin) */
    Route::controller(AuthorizationController::class)->prefix('authorization')->middleware(['auth', 'permission:sysadmin'])->name('authorization::')->group(function () {
        Route::get('', 'index')->name('overview'); // AuthorizationController
        Route::post('{id}/grant', 'grant')->name('grant'); // AuthorizationController
        Route::get('{id}/revoke/{user}', 'revoke')->name('revoke'); // AuthorizationController
    });

    /* Routes related to the password manager. (Access restricted in controller)*/
    Route::controller(PasswordController::class)->prefix('passwordstore')->middleware(['auth'])->name('passwordstore::')->group(function () {
        Route::get('', 'index')->name('index'); // PasswordController
        Route::get('auth', 'getAuth')->name('auth'); // PasswordController
        Route::post('auth', 'postAuth')->name('auth'); // PasswordController
        Route::get('add', 'create')->name('add'); // PasswordController
        Route::post('add', 'store')->name('add'); // PasswordController
        Route::get('edit/{id}', 'edit')->name('edit'); // PasswordController
        Route::post('edit/{id}', 'update')->name('edit'); // PasswordController
        Route::get('delete/{id}', 'destroy')->name('delete'); // PasswordController
    });

    /* Routes related to e-mail aliases. (Sysadmin only) */
    Route::controller(AliasController::class)->prefix('alias')->middleware(['auth', 'permission:sysadmin'])->name('alias::')->group(function () {
        Route::get('', 'index')->name('index'); // AliasController
        Route::get('add', 'create')->name('add'); // AliasController
        Route::post('add', 'store')->name('add'); // AliasController
        Route::get('delete/{id_or_alias}', 'destroy')->name('delete'); // AliasController
        Route::post('update', 'update')->name('update'); // AliasController
    });

    /* The route for the SmartXp Screen. (Public) */
    Route::controller(SmartXpScreenController::class)->group(function () {
        Route::get('smartxp', 'show')->name('smartxp'); // SmartXpScreenController
        Route::get('protopolis', 'showProtopolis')->name('protopolis'); // SmartXpScreenController
        Route::get('caniworkinthesmartxp', 'canWork');
    });

    /* The routes for Protube. (Public)*/
    Route::controller(ProtubeController::class)->prefix('protube')->name('protube::')->group(function () {
        Route::get('dashboard', 'dashboard')->middleware(['auth'])->name('dashboard'); // ProtubeController
        Route::get('togglehistory', 'toggleHistory')->middleware(['auth'])->name('togglehistory'); // ProtubeController
        Route::get('clearhistory', 'clearHistory')->middleware(['auth'])->name('clearhistory'); // ProtubeController
        Route::get('top', 'topVideos')->name('top'); // ProtubeController
    });

    /* Routes related to calendars. */
    Route::get('ical/calendar/{personal_key?}', [EventController::class, 'icalCalendar'])->name('ical::calendar'); // EventController

    /* Routes related to the Achievement system. */
    Route::controller(AchievementController::class)->group(function () {
        Route::get('achieve/{achievement}', 'achieve')->middleware(['auth'])->name('achieve'); // AchievementController

        Route::prefix('achievement')->name('achievement::')->group(function () {
            // Board only
            Route::middleware(['auth', 'permission:board'])->group(function () {
                Route::get('', 'overview')->name('list'); // AchievementController
                Route::get('add', 'create')->name('add'); // AchievementController
                Route::post('add', 'store')->name('add'); // AchievementController
                Route::get('manage/{id}', 'manage')->name('manage'); // AchievementController
                Route::post('update/{id}', 'update')->name('update'); // AchievementController
                Route::get('delete/{id}', 'destroy')->name('delete'); // AchievementController
                Route::post('award/{id}', 'award')->name('award'); // AchievementController
                Route::post('give', 'give')->name('give'); // AchievementController
                Route::get('take/{id}/{user}', 'take')->name('take'); // AchievementController
                Route::get('takeAll/{id}', 'takeAll')->name('takeAll'); // AchievementController
                Route::post('{id}/icon', 'icon')->name('icon'); // AchievementController
            });
            // Public
            Route::get('gallery', 'gallery')->name('gallery'); // AchievementController
        });
    });
    /* Routes related to the Welcome Message system. (Board only) */
    Route::controller(WelcomeController::class)->prefix('welcomeMessages')->name('welcomeMessages::')->middleware(['auth', 'permission:board'])->group(function () {
        Route::get('', 'overview')->name('list'); // WelcomeController
        Route::post('add', 'store')->name('add'); // WelcomeController
        Route::get('delete/{id}', 'destroy')->name('delete'); // WelcomeController
    });

    /* Routes related to Protube TempAdmin (Board only) */
    Route::controller(TempAdminController::class)->prefix('tempadmin')->name('tempadmin::')->middleware(['auth', 'permission:board'])->group(function () {
        Route::get('make/{id}', 'make')->name('make'); // TempAdminController
        Route::get('end/{id}', 'end')->name('end'); // TempAdminController
        Route::get('endId/{id}', 'endId')->name('endId'); // TempAdminController
        Route::get('edit/{id}', 'edit')->name('edit'); // TempAdminController
        Route::post('edit/{id}', 'update')->name('edit'); // TempAdminController
        Route::get('add', 'create')->name('add'); // TempAdminController
        Route::post('add', 'store')->name('add'); // TempAdminController
        Route::get('', 'index')->name('index'); // TempAdminController
    });

    /* Routes related to QR Authentication. */
    Route::controller(QrAuthController::class)->prefix('qr')->name('qr::')->group(function () {
        // API
        Route::get('code/{code}', 'showCode')->name('code'); // QrAuthController
        Route::post('generate', 'generateRequest')->name('generate'); // QrAuthController
        Route::get('isApproved', 'isApproved')->name('approved'); // QrAuthController

        // Usage of the QR code
        Route::middleware(['auth'])->group(function () {
            Route::get('{code}', 'showDialog')->name('dialog'); // QrAuthController
            Route::get('{code}/approve', 'approve')->name('approve'); // QrAuthController
        });
    });

    /* Routes related to the Short URL Service*/
    Route::controller(ShortUrlController::class)->name('short_url::')->group(function () {
        // Public
        Route::get('go/{short?}', 'go')->name('go'); // ShortUrlController

        // Board
        Route::prefix('short_url')->middleware(['auth', 'permission:board'])->group(function () {
            Route::get('', 'index')->name('index'); // ShortUrlController
            Route::get('edit/{id}', 'edit')->name('edit'); // ShortUrlController
            Route::post('edit/{id}', 'update')->name('edit'); // ShortUrlController
            Route::get('delete/{id}', 'destroy')->name('delete'); // ShortUrlController
        });
    });

    /* Routes related to the DMX Management. (Board or alfred) */
    Route::controller(DmxController::class)->prefix('dmx')->name('dmx::')->middleware(['auth', 'permission:board|alfred'])->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/add', 'create')->name('add');
        Route::post('/add', 'store')->name('add');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/edit/{id}', 'update')->name('edit');
        Route::get('/delete/{id}', 'delete')->name('delete');

        Route::prefix('override')->name('override::')->group(function () {
            Route::get('/', 'overrideIndex')->name('index');
            Route::get('/add', 'overrideCreate')->name('add');
            Route::post('/add', 'overrideStore')->name('add');
            Route::get('/edit/{id}', 'overrideEdit')->name('edit');
            Route::post('/edit/{id}', 'overrideUpdate')->name('edit');
            Route::get('/delete/{id}', 'overrideDelete')->name('delete');
        });
    });

    /* Routes related to the Query system. (Board only) */
    Route::controller(QueryController::class)->prefix('queries')->name('queries::')->middleware(['auth', 'permission:board'])->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/activity_overview', 'activityOverview')->name('activity_overview');
        Route::get('/activity_statistics', 'activityStatistics')->name('activity_statistics');
        Route::get('/membership_totals', 'membershipTotals')->name('membership_totals');
    });

    /* Routes related to the Minisites */
    Route::prefix('minisites')->name('minisites::')->group(function () {
        Route::controller(IsAlfredThereController::class)->prefix('isalfredthere')->name('isalfredthere::')->group(function () {
            // Open page (Public)
            Route::get('/', 'showMiniSite')->name('index');
            // Admin (Board)
            Route::get('/admin', 'getAdminInterface')->middleware(['auth', 'permission:sysadmin|alfred'])->name('admin');
            Route::post('/admin', 'getAdminInterface')->middleware(['auth', 'permission:sysadmin|alfred'])->name('admin');
        });
    });

    /* Routes related to Cantus Codices (Senate only) */
    Route::controller(CodexController::class)->prefix('codex')->name('codex::')->middleware(['auth', 'permission:senate'])->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('add-codex', 'addCodex')->name('add-codex');
        Route::get('add-song', 'addSong')->name('add-song');
        Route::get('add-song-category', 'addSongCategory')->name('add-song-category');
        Route::get('add-text-type', 'addTextType')->name('add-text-type');
        Route::get('add-text', 'addText')->name('add-text');

        Route::get('edit-codex/{codex}', 'editCodex')->name('edit-codex');
        Route::get('edit-song/{id}', 'editSong')->name('edit-song');
        Route::get('edit-song-category/{id}', 'editSongCategory')->name('edit-song-category');
        Route::get('edit-text-type/{id}', 'editTextType')->name('edit-text-type');
        Route::get('edit-text/{id}', 'editText')->name('edit-text');

        Route::get('delete-codex/{codex}', 'deleteCodex')->name('delete-codex');
        Route::get('delete-song/{id}', 'deleteSong')->name('delete-song');
        Route::get('delete-song-category/{id}', 'deleteSongCategory')->name('delete-song-category');
        Route::get('delete-text-type/{id}', 'deleteTextType')->name('delete-text-type');
        Route::get('delete-text/{id}', 'deleteText')->name('delete-text');

        Route::post('add-codex', 'storeCodex')->name('add-codex');
        Route::post('add-song', 'storeSong')->name('add-song');
        Route::post('add-song-category', 'storeSongCategory')->name('add-song-category');
        Route::post('add-text-type', 'storeTextType')->name('add-text-type');
        Route::post('add-text', 'storeText')->name('add-text');

        Route::post('edit-codex/{codex}', 'updateCodex')->name('edit-codex');
        Route::post('edit-song/{id}', 'updateSong')->name('edit-song');
        Route::post('edit-song-category/{id}', 'updateSongCategory')->name('edit-song-category');
        Route::post('edit-text-type/{id}', 'updateTextType')->name('edit-text-type');
        Route::post('edit-text/{id}', 'updateText')->name('edit-text');

        Route::get('export/{id}', 'exportCodex')->name('export');
    });

    /*Route related to the december theme*/
    Route::get('/december/toggle', function () {
        Cookie::queue('disable-december', Cookie::get('disable-december') === 'disabled' ? 'enabled' : 'disabled', 43800);

        return Redirect::back();
    })->name('december::toggle');
});
