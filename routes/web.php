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
use App\Http\Controllers\CodexSongCategoryController;
use App\Http\Controllers\CodexSongController;
use App\Http\Controllers\CodexTextController;
use App\Http\Controllers\CodexTextTypeController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DinnerformController;
use App\Http\Controllers\DinnerformOrderlineController;
use App\Http\Controllers\DmxFixtureController;
use App\Http\Controllers\DmxOverrrideController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EmailListController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HeaderImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IsAlfredThereController;
use App\Http\Controllers\JobofferController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\LeaderboardEntryController;
use App\Http\Controllers\LikedPhotosController;
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
use App\Http\Controllers\PhotoAlbumController;
use App\Http\Controllers\PrivateMediaController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfilePictureController;
use App\Http\Controllers\ProtubeController;
use App\Http\Controllers\QrAuthController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\RegistrationHelperController;
use App\Http\Controllers\RfidCardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\SmartXpScreenController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\StickerController;
use App\Http\Controllers\StockMutationController;
use App\Http\Controllers\SurfConextController;
use App\Http\Controllers\TempAdminController;
use App\Http\Controllers\TFAController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TIPCieController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserPasswordController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WallstreetController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WithdrawalController;
use App\Models\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

require __DIR__.'/minisites.php';
/* Route block convention:
 *
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
 * });
 *
 *
 */

/* --- Pass view name to body class --- */
View::composer('*', function ($view) {
    View::share('viewName', $view->getName());
});

Route::middleware('forcedomain')->group(function () {
    /* --- The main route for the frontpage --- */
        Route::get('developers', [HomeController::class,'developers']);
        Route::get('', [HomeController::class,'show'])->name('homepage');
        Route::get('fishcam', [HomeController::class,'fishcam'])->middleware(['member'])->name('fishcam');

    Route::get('becomeamember', [UserDashboardController::class, 'becomeAMemberOf'])->name('becomeamember');

    Route::resource('headerimages', HeaderImageController::class)->only(['index', 'create', 'store', 'destroy'])->middleware(['auth', 'permission:header-image']);

    /* Routes for the search function. All public */
    Route::name('search::')->group(function () {
        Route::get('search', [SearchController::class,'search'])->name('get');
        Route::post('search', [SearchController::class,'search'])->name('post');
        Route::get('opensearch', [SearchController::class,'openSearch'])->name('opensearch');
        /* --- Routes for the UTwente address book --- */
        Route::prefix('ldap')->name('ldap::')->middleware(['utwente'])->group(function () {
            Route::get('search', [SearchController::class,'ldapSearch'])->name('get');
            Route::post('search', [SearchController::class,'ldapSearch'])->name('post');
        });
    });

    /* --- Routes related to authentication. All public --- */
    Route::name('login::')->group(function () {
        Route::get('register', [AuthController::class, 'registerIndex'])->name('register::index');
        Route::post('register', [AuthController::class, 'register'])->middleware(['throttle:5,1'])->name('register');

        Route::get('login', [AuthController::class, 'loginIndex'])->name('show');
        Route::post('login', [AuthController::class, 'login'])->middleware(['throttle:5,1'])->name('post');

        Route::post('logout', [AuthController::class,'logout'])->name('logout');

        Route::prefix('password')->name('password::')->group(function () {
            Route::get('reset/{token}', [UserPasswordController::class, 'resetPasswordIndex'])->name('reset::token');
            Route::post('reset', [UserPasswordController::class, 'resetPassword'])->middleware(['throttle:5,1'])->name('reset::submit');

            Route::get('email', [UserPasswordController::class, 'requestPasswordResetIndex'])->name('reset');
            Route::post('email', [UserPasswordController::class, 'requestPasswordReset'])->middleware(['throttle:5,1'])->name('reset::send');
        });

        Route::prefix('surf')->name('surf::')->group(function () {
            Route::get('login', [SurfConextController::class, 'login'])->name('login');
            Route::post('callback', [SurfConextController::class, 'callback'])->name('callback');
            Route::get('meta', [SurfConextController::class, 'provideMetadataForSurfConext'])->name('meta');
        });

        Route::get('username', [UserPasswordController::class, 'forgotUsernameIndex'])->name('requestusername::index');
        Route::post('username', [UserPasswordController::class, 'forgotUsername'])->middleware(['throttle:5,1'])->name('requestusername');
    });

    /* --- Authenticated routed related to password modifications --- */
    Route::prefix('password')->name('login::password::')->middleware(['auth'])->group(function () {
        Route::get('sync', [UserPasswordController::class, 'syncPasswordsIndex'])->name('sync::index');
        Route::post('sync', [UserPasswordController::class, 'syncPasswords'])->middleware(['throttle:5,1'])->name('sync');

        Route::get('change', [UserPasswordController::class, 'changePasswordIndex'])->name('change::index');
        Route::post('change', [UserPasswordController::class, 'changePassword'])->middleware(['throttle:5,1'])->name('change');
    });

    /* --- Routes related to user profiles --- */
    Route::prefix('user')->name('user::')->middleware(['auth'])->group(function () {

        /* --- Public routes ---- */
        Route::post('delete', [UserController::class,'destroy'])->name('delete');

        Route::get('personal_key', [UserDashboardController::class, 'generateKey'])->name('personal_key::generate');

        Route::prefix('memberprofile')->name('memberprofile::')->middleware('auth')->group(function () {
            Route::get('complete', [UserDashboardController::class, 'getCompleteProfile'])->name('show');
            Route::post('complete', [UserDashboardController::class, 'postCompleteProfile'])->name('complete');
            Route::get('clear', [UserDashboardController::class, 'getClearProfile'])->name('showclear');
            Route::post('clear', [UserDashboardController::class, 'postClearProfile'])->name('clear');
        });

            Route::post('change_email/{id}', [UserDashboardController::class,'updateMail'])->middleware(['throttle:3,1'])->name('changemail');
            Route::get('dashboard', [UserDashboardController::class, 'show'])->name('dashboard::show');
            Route::post('dashboard', [UserDashboardController::class, 'update'])->name('dashboard');

        Route::get('quit_impersonating', [UserAdminController::class, 'quitImpersonating'])->name('quitimpersonating');

        /* --- Routes related to addresses --- */
        Route::prefix('address')->name('address::')->group(function () {
            Route::get('create', [AddressController::class, 'create'])->name('create');
            Route::post('store', [AddressController::class, 'store'])->name('store');
            Route::get('delete', [AddressController::class, 'destroy'])->name('delete');
            Route::get('edit', [AddressController::class, 'edit'])->name('edit');
            Route::post('update', [AddressController::class, 'update'])->name('update');
            Route::get('togglehidden', [AddressController::class, 'toggleHidden'])->name('togglehidden');
        });

        /* --- Route(s) related to diet --- */
        Route::post('diet/edit', [UserDashboardController::class, 'editDiet'])->name('diet::edit');

        /* --- Routes related to bank accounts --- */
        Route::prefix('bank')->name('bank::')->group(function () {
            Route::get('create', [BankController::class, 'create'])->name('create');
            Route::post('store', [BankController::class, 'store'])->name('store');
            Route::post('delete', [BankController::class, 'destroy'])->name('delete');
            Route::get('edit', [BankController::class, 'edit'])->name('edit');
            Route::post('update', [BankController::class, 'update'])->name('update');
        });

        /* --- Routes related to RFID cards --- */
        Route::prefix('rfidcard/{id}')->name('rfid::')->group(function () {
            Route::get('delete', [RfidCardController::class,'destroy'])->name('delete');
            Route::get('edit', [RfidCardController::class,'edit'])->name('edit');
            Route::post('update', [RfidCardController::class,'update'])->name('update');
        });

        /* --- Routes related to profile pictures --- */
        Route::prefix('profilepic')->name('pic::')->group(function () {
            Route::post('update', [ProfilePictureController::class,'update'])->name('update');
            Route::get('delete', [ProfilePictureController::class,'destroy'])->name('delete');
        });

        /* --- Routes related to UT accounts --- */
        Route::prefix('surf')->name('surf::')->group(function () {
            Route::get('unlink', [SurfConextController::class,'unlinkAccount'])->name('unlink');
            Route::get('link', [SurfConextController::class,'linkAccount'])->name('link');
        });

        /* --- Routes related to 2FA --- */
        Route::prefix('2fa')->name('2fa::')->group(function () {
            Route::post('create', [TFAController::class,'create'])->name('create');
            Route::post('delete', [TFAController::class,'destroy'])->name('delete');
            Route::post('delete/{id}', [TFAController::class,'adminDestroy'])->middleware(['permission:board'])->name('admindelete');
        });

        /* --- Restricted routes ---- */

        /* --- Registration helper --- */
        Route::prefix('registrationhelper')->name('registrationhelper::')->middleware(['auth', 'permission:registermembers'])->group(function () {
            Route::get('', [RegistrationHelperController::class,'index'])->name('list');
            Route::get('{id}', [RegistrationHelperController::class,'details'])->name('details');
        });

        /* --- Routes related to member administration --- */
        Route::prefix('{id}/member')->name('member::')->middleware(['auth', 'permission:registermembers'])->group(function () {
            // Board only
            // Impersonation
            Route::get('impersonate', [UserAdminController::class, 'impersonate'])->middleware(['auth', 'permission:board'])->name('impersonate');
            // OmNomCom sound
            Route::prefix('omnomcomsound')->name('omnomcomsound::')->middleware(['auth', 'permission:board'])->group(function () {
                Route::post('update', [UserAdminController::class, 'uploadOmnomcomSound'])->name('update');
                Route::get('delete', [UserAdminController::class, 'deleteOmnomcomSound'])->name('delete');
            });
            Route::post('create', [UserAdminController::class, 'addMembership'])->name('create');
            Route::post('remove', [UserAdminController::class, 'endMembership'])->name('remove');
            Route::post('end_in_september', [UserAdminController::class, 'EndMembershipInSeptember'])->name('endinseptember');
            Route::post('remove_end', [UserAdminController::class, 'removeMembershipEnd'])->name('removeend');
            Route::post('settype', [UserAdminController::class, 'setMembershipType'])->name('settype');
        });

        /* --- User admin: Board only --- */
        Route::prefix('admin')->name('admin::')->middleware(['auth', 'permission:board'])->group(function () {
            Route::get('index', [UserAdminController::class,'index'])->name('index');

            Route::get('studied_create/{id}', [UserAdminController::class,'toggleStudiedCreate'])->name('toggle_studied_create');
            Route::get('studied_itech/{id}', [UserAdminController::class,'toggleStudiedITech'])->name('toggle_studied_itech');
            Route::get('primary_somewhere_else/{id}', [UserAdminController::class,'togglePrimaryAtAnotherAssociation'])->name('toggle_primary_somewhere_else');
            Route::get('nda/{id}', [UserAdminController::class,'toggleNda'])->name('toggle_nda');
            Route::get('unblock_omnomcom/{id}', [UserAdminController::class,'unblockOmnomcom'])->name('unblock_omnomcom');

            Route::get('{id}', [UserAdminController::class,'details'])->name('details');
            Route::post('{id}', [UserAdminController::class,'update'])->name('update');
        });

        Route::get('{id?}', [UserProfileController::class, 'show'])->middleware(['member'])->name('profile');

    });

    /* --- Routes related to the Membership Forms --- */
    Route::prefix('memberform')->name('memberform::')->middleware(['auth'])->group(function () {
            Route::get('sign', [UserDashboardController::class,'getMemberForm'])->name('showsign');
            Route::post('sign', [UserDashboardController::class,'postMemberForm'])->name('sign');
            Route::prefix('download')->name('download::')->group(function () {
                Route::get('new/{id}', [UserAdminController::class,'getNewMemberForm'])->name('new');
                Route::get('signed/{id}', [UserAdminController::class,'getSignedMemberForm'])->name('signed');
            });
            // Member form management (Board)
            Route::post('print/{id}', [UserAdminController::class,'printMemberForm'])->middleware(['permission:board'])->name('print');
            Route::post('delete/{id}', [UserAdminController::class,'destroyMemberForm'])->middleware(['permission:board'])->name('delete');
    });

    /* --- Routes related to committees --- */
    Route::prefix('committee')->name('committee::')->group(function () {
        /* --- Board only --- */
        Route::middleware(['auth', 'permission:board'])->group(function () {
            // Membership management
            Route::prefix('membership')->name('membership::')->group(function () {
                Route::post('store', [CommitteeController::class,'addMembership'])->name('store');
                Route::get('end/{committee}/{edition}', [CommitteeController::class,'endEdition'])->name('endedition');
                Route::get('{id}/delete', [CommitteeController::class,'deleteMembership'])->name('delete');
                Route::get('{id}', [CommitteeController::class,'editMembershipForm'])->name('edit');
                Route::post('{id}', [CommitteeController::class,'updateMembershipForm'])->name('update');
            });

            // Committee management
            Route::get('create', [CommitteeController::class,'create'])->name('create');
            Route::post('', [CommitteeController::class,'store'])->name('store');
            Route::get('{id}/edit', [CommitteeController::class,'edit'])->name('edit');
            Route::post('{id}/edit', [CommitteeController::class,'update'])->name('update');
            Route::post('{id}/image', [CommitteeController::class,'image'])->name('image');
        });

        /* --- Public routes --- */
        Route::get('index', [CommitteeController::class,'index'])->name('index');
        Route::get('{id}', [CommitteeController::class,'show'])->name('show');
        Route::get('{id}/send_anonymous_email', [CommitteeController::class,'showAnonMailForm'])->middleware(['auth', 'member'])->name('anonymousmail');
        Route::post('{id}/send_anonymous_email', [CommitteeController::class,'sendAnonMailForm'])->middleware(['auth', 'member'])->name('sendanonymousmail');
//        Route::get('{slug}/toggle_helper_reminder', [CommitteeController::class,'toggleHelperReminder'])->middleware(['auth'])->name('toggle_helper_reminder');
    });

    /* --- Routes related to societies --- */
    Route::prefix('society')->name('society::')->group(function () {
        Route::get('list', [CommitteeController::class,'index'])->name('list')->defaults('showSociety', true);
        Route::get('{id}', [CommitteeController::class,'show'])->name('show');
    });

    /* --- Routes related to narrowcasting (Board only) --- */
    Route::prefix('narrowcasting')->name('narrowcasting::')->group(function () {
        Route::middleware(['auth', 'permission:board'])->group(function () {
            Route::get('index', [NarrowcastingController::class,'index'])->name('index');
            Route::get('create',  [NarrowcastingController::class,'create'])->name('create');
            Route::post('store',  [NarrowcastingController::class,'store'])->name('store');
            Route::get('edit/{id}',  [NarrowcastingController::class,'edit'])->name('edit');
            Route::post('edit/{id}',  [NarrowcastingController::class,'update'])->name('update');
            Route::get('delete/{id}',  [NarrowcastingController::class,'destroy'])->name('delete');
            Route::get('clear',  [NarrowcastingController::class,'clear'])->name('clear');
        });
        Route::get('',  [NarrowcastingController::class,'show'])->name('display');
    });

    /* --- Routes related to companies --- */
    Route::prefix('companies')->name('companies::')->group(function () {

        /* --- Board only --- */
        Route::middleware(['auth', 'permission:board'])->group(function () {
            Route::get('list', [CompanyController::class,'adminIndex'])->name('admin');
            Route::get('create', [CompanyController::class,'create'])->name('create');
            Route::post('store', [CompanyController::class,'store'])->name('store');
            Route::get('edit/{id}', [CompanyController::class,'edit'])->name('edit');
            Route::post('edit/{id}', [CompanyController::class,'update'])->name('update');
            Route::get('delete/{id}', [CompanyController::class,'destroy'])->name('delete');

            Route::get('up/{id}', [CompanyController::class,'orderUp'])->name('orderUp');
            Route::get('down/{id}', [CompanyController::class,'orderDown'])->name('orderDown');
        });

        /* --- Public routes --- */
        Route::get('index', [CompanyController::class,'index'])->name('index');
        Route::get('{id}', [CompanyController::class,'show'])->name('show');
    });

    /* --- Routes related to membercard --- */
    Route::prefix('membercard')->name('membercard::')->group(function () {
            Route::get('index', [CompanyController::class,'indexmembercard'])->name('index');
            Route::get('{id}', [CompanyController::class,'showmembercard'])->name('show');

            Route::post('print', [MemberCardController::class,'startPrint'])->middleware(['auth', 'permission:board'])->name('print');
            Route::get('download/{id}', [MemberCardController::class,'download'])->name('download');
    });

    /* --- Routes related to joboffers --- */
    Route::prefix('joboffers')->name('joboffers::')->group(function () {
        /* --- Board only --- */
        Route::middleware(['auth', 'permission:board'])->group(function () {
            Route::get('list', [JobofferController::class,'adminIndex'])->name('admin');

            Route::get('create', [JobofferController::class,'create'])->name('create');
            Route::post('store', [JobofferController::class,'store'])->name('store');

            Route::get('edit/{id}', [JobofferController::class,'edit'])->name('edit');
            Route::post('edit/{id}', [JobofferController::class,'update'])->name('update');

            Route::get('delete/{id}', [JobofferController::class,'destroy'])->name('delete');
        });
        /* --- Public routes --- */
        Route::get('index', [JobofferController::class,'index'])->name('index');
        Route::get('{id}', [JobofferController::class,'show'])->name('show');
    });

    /* --- Routes related to leaderboards --- */
    Route::prefix('leaderboards')->name('leaderboards::')->middleware(['auth', 'member'])->group(function () {

            // Committee dependent
            Route::get('list', [LeaderboardController::class,'adminIndex'])->name('admin');
            Route::get('edit/{id}', [LeaderboardController::class,'edit'])->name('edit');
            Route::post('update/{id}', [LeaderboardController::class,'update'])->name('update');

            // Board only
            Route::middleware(['permission:board'])->group(function () {
                Route::get('create', [LeaderboardController::class,'create'])->name('create');
                Route::post('store', [LeaderboardController::class,'store'])->name('store');
                Route::get('delete/{id}', [LeaderboardController::class,'destroy'])->name('delete');
            });

            // Public route
            Route::get('', [LeaderboardController::class,'index'])->name('index');

        /* --- Committee dependent --- */
        Route::prefix('entries')->name('entries::')->group(function () {
            Route::post('create', [LeaderboardController::class,'store'])->name('create');
            Route::post('update', [LeaderboardController::class,'update'])->name('update');
            Route::get('delete/{id}', [LeaderboardController::class,'destroy'])->name('delete');
        });
    });

    /* --- Routes related to dinnerforms --- */
    Route::prefix('dinnerform')->name('dinnerform::')->middleware(['member'])->group(function () {

        /* --- TIPCie only --- */
        Route::middleware(['permission:tipcie'])->group(function () {
            Route::get('create', [DinnerformController::class,'create'])->name('create');
            Route::get('edit/{id}', [DinnerformController::class,'edit'])->name('edit');
            Route::post('store', [DinnerformController::class,'store'])->name('store');
            Route::post('update/{id}', [DinnerformController::class,'update'])->name('update');
            Route::get('close/{id}', [DinnerformController::class,'close'])->name('close');
            Route::get('delete/{id}', [DinnerformController::class,'destroy'])->name('delete');
            Route::get('admin/{id}', [DinnerformController::class,'admin'])->name('admin');
            Route::get('process/{id}', [DinnerformController::class,'process'])->name('process');
        });

        /* --- Member only --- */
        Route::get('{id}', [DinnerformController::class, 'show'])->name('show');

        /* --- Routes related to the dinnerform orderlines --- */
        Route::prefix('orderline')->name('orderline::')->group(function () {
            /* --- TIPCie only --- */
            Route::middleware(['permission:tipcie'])->group(function () {
                Route::get('edit/{id}', [DinnerformOrderlineController::class,'edit'])->name('edit');
                Route::post('update/{id}', [DinnerformOrderlineController::class,'update'])->name('update');
            });

            /* --- Member only --- */
            Route::get('delete/{id}', [DinnerformOrderlineController::class,'delete'])->name('delete');
            Route::post('store/{id}', [DinnerformOrderlineController::class,'store'])->name('store');
        });
    });
    Route::middleware(['auth', 'member'])->group(function () {

        Route::middleware('permission:board')->group(function () {
            Route::post('stickers/unreport/{sticker}', [StickerController::class, 'unreport'])->name('stickers.unreport')->middleware('permission:board');
            Route::get('stickers/admin', [StickerController::class, 'admin'])->name('stickers.admin')->middleware('permission:board');
        });

        Route::post('stickers/report/{sticker}', [StickerController::class, 'report'])->name('stickers.report');
        Route::get('stickers/overview', [StickerController::class, 'overviewMap'])->name('stickers.overviewmap');
        Route::resource('stickers', StickerController::class)->only(['index', 'store', 'destroy']);
    });

    /* --- Routes related to the wallstreet drink system (TIPCie only) --- */
    Route::prefix('wallstreet')->name('wallstreet::')->middleware(['permission:tipcie'])->group(function () {
        Route::get('', [WallstreetController::class,'index'])->name('index');
        Route::get('marquee', [WallstreetController::class,'marquee'])->name('marquee');
        Route::post('store', [WallstreetController::class,'store'])->name('store');
        Route::get('close/{id}', [WallstreetController::class,'close'])->name('close');
        Route::get('edit/{id}', [WallstreetController::class,'edit'])->name('edit');
        Route::post('edit/{id}', [WallstreetController::class,'update'])->name('update');
        Route::get('delete/{id}', [WallstreetController::class,'destroy'])->name('delete');
        Route::get('statistics/{id}', [WallstreetController::class,'statistics'])->name('statistics');
        route::prefix('products')->name('products::')->group(function () {
            Route::post('create/{id}', [WallstreetController::class,'addProducts'])->name('create');
            Route::get('remove/{id}/{productId}', [WallstreetController::class,'removeProduct'])->name('remove');
        });

        Route::prefix('events')->name('events::')->group(function () {
            Route::get('', [WallstreetController::class,'events'])->name('index');
            Route::post('store', [WallstreetController::class,'addEvent'])->name('store');
            Route::get('edit/{id}', [WallstreetController::class,'editEvent'])->name('edit');
            Route::post('update/{id}', [WallstreetController::class,'updateEvent'])->name('update');
            Route::get('delete/{id}', [WallstreetController::class,'destroyEvent'])->name('delete');
            Route::prefix('products')->name('products::')->group(function () {
                Route::post('create/{id}', [WallstreetController::class,'addEventProducts'])->name('create');
                Route::get('remove/{id}/{productId}', [WallstreetController::class,'removeEventProduct'])->name('remove');
            });
        });
    });

    /*
     * Routes related to events.
     * Important: routes in this block always use event_id or a relevant other ID. activity_id is in principle never used.
     */
    Route::prefix('events')->name('event::')->group(function () {
            // Financials related to events (Finadmin only)
            Route::prefix('financial')->name('financial::')->middleware('permission:finadmin')->group(function () {
                Route::get('list', [EventController::class,'finindex'])->name('list');
                Route::post('close/{id}', [EventController::class,'finclose'])->name('close');
            });

            // Event related admin (Board only)
            Route::middleware(['permission:board'])->group(function () {
                // Events admin
                Route::get('create', [EventController::class,'create'])->name('create');
                Route::post('store', [EventController::class,'store'])->name('store');
                Route::get('{event}/edit', [EventController::class,'edit'])->name('edit');
                Route::post('{event}/update', [EventController::class,'update'])->name('update');
                Route::get('{event}/delete', [EventController::class,'destroy'])->name('delete');

                // Albums
                Route::post('album/{event}/link', [EventController::class,'linkAlbum'])->name('linkalbum');
                Route::get('album/unlink/{album}', [EventController::class,'unlinkAlbum'])->name('unlinkalbum');
            });

            // Public routes
            Route::get('', [EventController::class,'index'])->name('index');
            Route::get('archive/{year}', [EventController::class,'archive'])->name('archive');
            Route::post('copy', [EventController::class,'copyEvent'])->name('copy');

            // Catch-alls
            Route::get('{event}/admin', [EventController::class,'admin'])->middleware(['auth'])->name('admin');
            Route::get('{event}/scan', [EventController::class,'scan'])->middleware(['auth'])->name('scan');

            Route::post('set_reminder', [EventController::class,'setReminder'])->middleware(['auth'])->name('set_reminder');
            Route::get('toggle_relevant_only', [EventController::class,'toggleRelevantOnly'])->middleware(['auth'])->name('toggle_relevant_only');

            // Force login for event
            Route::get('{event}/login', [EventController::class,'forceLogin'])->middleware(['auth'])->name('login');
            // Show event
            Route::get('{event}', [EventController::class,'show'])->name('show');

        // Event categories (Board only)
        Route::middleware(['permission:board'])->group(function () {
            Route::resource('categories', EventCategoryController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        });

        /* --- Related to presence & participation --- */
            // Public routes
            Route::get('togglepresence/{participation}', [ParticipationController::class,'togglePresence'])->middleware(['auth'])->name('togglepresence');

            // Manage participation
            Route::get('{event}/participate', [ParticipationController::class,'create'])->middleware(['member'])->name('addparticipation');
            Route::get('unparticipate/{participation}', [ParticipationController::class,'destroy'])->name('deleteparticipation');

            // Participate for someone else (Board only)
            Route::post('{event}/participatefor', [ParticipationController::class,'createFor'])->middleware(['permission:board'])->name('addparticipationfor');

        /* --- Buy tickets for an event (Public) --- */
        Route::post('{event}/buytickets', [TicketController::class, 'buyForEvent'])->middleware(['auth'])->name('buytickets');

            // Board only admin
            Route::middleware(['permission:board'])->group(function () {
                // Related to activities
                Route::post('{event}/signup', [ActivityController::class,'store'])->middleware(['permission:board'])->name('addsignup');
                Route::get('{event}/signup/delete', [ActivityController::class,'destroy'])->middleware(['permission:board'])->name('deletesignup');

                // Related to helping committees
                Route::post('{event}/addhelp', [ActivityController::class,'addHelp'])->middleware(['permission:board'])->name('addhelp');
                Route::post('updatehelp/{id}', [ActivityController::class,'updateHelp'])->middleware(['permission:board'])->name('updatehelp');
                Route::get('deletehelp/{id}', [ActivityController::class,'deleteHelp'])->middleware(['permission:board'])->name('deletehelp');
            });
            // Public routes
            Route::get('{event}/checklist', [ActivityController::class,'checklist'])->name('checklist');

    });

    /* --- Routes related to pages --- */
    Route::controller(PageController::class)->prefix('page')->name('page::')->group(function () {

        /* --- Board only --- */
        Route::middleware(['auth', 'permission:board'])->group(function () {
            Route::get('', 'index')->name('list');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('delete/{id}', 'destroy')->name('delete');

            Route::prefix('/edit/{id}/file')->name('file::')->group(function () {
                Route::post('create', 'addFile')->name('create');
                Route::get('{file_id}/delete', 'deleteFile')->name('delete');
            });
        });

        /* --- Public --- */
        Route::get('{slug}', 'show')->name('show');
    });

    /* --- Routes related to news --- */
    Route::controller(NewsController::class)->prefix('news')->name('news::')->middleware(['member'])->group(function () {

        /* --- Board only --- */
        Route::middleware(['auth', 'permission:board'])->group(function () {
            Route::get('admin', 'admin')->name('admin');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::post('edit/{id}/image', 'featuredImage')->name('image');
            Route::get('delete/{id}', 'destroy')->name('delete');
            Route::get('sendWeekly/{id}', 'sendWeeklyEmail')->name('sendWeekly');
        });
        /* --- Member only --- */
        Route::get('showWeeklyPreview/{id}', 'showWeeklyPreview')->name('showWeeklyPreview');
        Route::get('index', 'index')->name('index');
        Route::get('{id}', 'show')->name('show');
    });

    /* --- Routes related to menu. (Board only) --- */
    Route::controller(MenuController::class)->prefix('menu')->name('menu::')->middleware(['auth', 'permission:board'])->group(function () {
        Route::get('', 'index')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');

        Route::get('up/{id}', 'orderUp')->name('orderUp');
        Route::get('down/{id}', 'orderDown')->name('orderDown');

        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('delete/{id}', 'destroy')->name('delete');
    });

    /* --- Routes related to tickets --- */
    Route::controller(TicketController::class)->prefix('tickets')->name('tickets::')->middleware(['auth'])->group(function () {
        /* --- Board only admin --- */
        Route::middleware(['auth', 'permission:board'])->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('delete/{id}', 'destroy')->name('delete');
        });

        /* --- Public Routes --- */
        Route::get('scan/{barcode}', 'scan')->name('scan');
        Route::get('unscan/{barcode?}', 'unscan')->name('unscan');
        Route::get('download/{id}', 'download')->name('download');
    });

    /* --- Routes related to e-mail. (Board only) --- */
    Route::prefix('email')->name('email::')->middleware(['auth', 'permission:board'])->group(function () {
        Route::controller(EmailListController::class)->prefix('list')->name('list::')->group(function () {
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('delete/{id}', 'destroy')->name('delete');
        });

        Route::controller(EmailController::class)->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('filter', 'filter')->name('filter');

            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('show/{id}', 'show')->name('show');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('toggleready/{id}', 'toggleReady')->name('toggleready');
            Route::get('delete/{id}', 'destroy')->name('delete');

            Route::prefix('{id}/attachment')->name('attachment::')->group(function () {
                Route::post('create', 'addAttachment')->name('create');
                Route::get('delete/{file_id}', 'deleteAttachment')->name('delete');
            });
        });
    });

    /* --- Public Routes for e-mail --- */
    Route::get('togglelist/{id}', [EmailListController::class, 'toggleSubscription'])->middleware(['auth'])->name('togglelist');
    Route::get('unsubscribe/{hash}', [EmailController::class, 'unsubscribeLink'])->name('unsubscribefromlist');

    /* --- Routes to redirect /goodideas and /quotes to /feedback/goodideas and /feedback/quotes --- */
    Route::get('goodideas', [FeedbackController::class, 'goodIdeas'])->middleware(['member'])->name('goodideas::index');
    Route::get('quotes', [FeedbackController::class, 'quotes'])->middleware(['member'])->name('quotes::list');

    /* --- Routes related to the Feedback Boards --- */
    Route::controller(FeedbackController::class)->prefix('feedback')->middleware(['member'])->name('feedback::')->group(function () {

        Route::prefix('categories')->middleware(['permission:board'])->name('category::')->group(function () {
            Route::get('admin', 'categoryAdmin')->name('admin');
            Route::post('store', 'categoryStore')->name('store');
            Route::get('edit/{id}', 'categoryEdit')->name('edit');
            Route::post('edit/{id}', 'categoryUpdate')->name('update');
            Route::get('delete/{id}', 'categoryDestroy')->name('delete');
        });

        /* --- Public routes --- */
        Route::get('approve/{id}', 'approve')->name('approve');
        Route::post('reply/{id}', 'reply')->name('reply');
        Route::get('archive/{id}', 'archive')->name('archive');
        Route::get('restore/{id}', 'restore')->name('restore');
        Route::get('delete/{id}', 'delete')->name('delete');
        Route::post('vote', 'vote')->name('vote');

        /* --- Catch-alls --- */
        Route::prefix('/{category}')->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('search/{searchTerm?}', 'search')->name('search');
            Route::get('archived', 'archived')->name('archived');
            Route::post('store', 'store')->name('store');
            Route::get('archiveall', 'archiveAll')->middleware(['permission:board'])->name('archiveall');
        });
    });

    /* --- Routes related to the OmNomCom --- */
    Route::prefix('omnomcom')->name('omnomcom::')->group(function () {
        /* --- Pubic routes --- */
        Route::get('minisite', [OmNomController::class, 'miniSite']);

        /* --- Routes related to OmNomCom stores --- */
        Route::prefix('store')->name('store::')->group(function () {
            Route::controller(OmNomController::class)->group(function () {
                Route::get('{store?}', 'display')->name('show');
                Route::post('{store}/buy', 'buy')->name('buy');
            });
            Route::post('rfid/create', [RfidCardController::class, 'store'])->name('rfid::create');
        });

        /* --- Routes related to OmNomCom orders --- */
        Route::controller(OrderLineController::class)->group(function () {

            Route::prefix('orders')->middleware(['auth'])->name('orders::')->group(function () {
                // Public
                Route::get('history/{date?}', 'index')->name('index');
                Route::get('orderline-wizard', 'orderlineWizard')->name('orderline-wizard');

                // OmNomCom admins only
                Route::middleware(['permission:omnomcom'])->group(function () {
                    Route::post('store/bulk', 'bulkStore')->name('storebulk');
                    Route::post('store/single', 'store')->name('store');
                    Route::get('delete/{id}', 'destroy')->name('delete');
                    Route::get('', 'adminindex')->name('adminlist');
                });
            });

            // Routes related to Payment Statistics
            Route::prefix('payments')->name('payments::')->middleware(['permission:finadmin'])->group(function () {
                Route::get('statistics', 'showPaymentStatistics')->name('statistics');
            });
        });

        /* --- Routes related to the TIPCie OmNomCom store --- */
        Route::get('tipcie', [TIPCieController::class, 'orderIndex'])->middleware(['auth', 'permission:tipcie'])->name('tipcie::orderhistory');

        /* --- Routes related to Financial Accounts. (Finadmin only) --- */
        Route::controller(AccountController::class)->prefix('accounts')->name('accounts::')->middleware(['permission:finadmin'])->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::post('aggregate/{account}', 'showAggregation')->name('aggregate');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('delete/{id}', 'destroy')->name('delete');
            Route::get('{id}', 'show')->name('show');
        });

        /* --- Routes related to managing Products. (Omnomcom admins only) --- */
        Route::prefix('products')->middleware(['permission:omnomcom'])->name('products::')->group(function () {
            Route::controller(ProductController::class)->group(function () {
                Route::get('export/csv', 'generateCsv')->name('export_csv');
                Route::post('update/bulk', 'bulkUpdate')->name('bulkupdate');

                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::post('update/{id}', 'update')->name('update');
                Route::get('delete/{id}', 'destroy')->name('delete');
            });

            Route::controller(AccountController::class)->group(function () {
                Route::get('statistics', 'showOmnomcomStatistics')->name('statistics');
            });

            Route::controller(StockMutationController::class)->group(function () {
                Route::get('mut', 'index')->name('mutations');
                Route::get('mut/csv', 'generateCsv')->name('mutations_export');
            });
        });

        /* --- Routes related to OmNomCom Categories. (OmNomCom admins only) --- */
        Route::controller(ProductCategoryController::class)->prefix('categories')->middleware(['permission:omnomcom'])->name('categories::')->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('delete/{id}', 'destroy')->name('delete');
            Route::get('{id}', 'show')->name('show');
        });

        /* --- Routes related to Withdrawals --- */
        Route::controller(WithdrawalController::class)->group(function () {
            // Public routes
            Route::get('mywithdrawal/{id}', 'showForUser')->middleware(['auth'])->name('mywithdrawal');
            Route::get('unwithdrawable', [WithdrawalController::class, 'unwithdrawable'])->name('unwithdrawable')->middleware(['permission:finadmin']);

            // Finadmin only
            Route::prefix('withdrawals')->middleware(['permission:finadmin'])->name('withdrawal::')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::post('edit/{id}', 'update')->name('edit');
                Route::get('delete/{id}', 'destroy')->name('delete');
                Route::get('accounts/{id}', 'showAccounts')->name('showAccounts');

                Route::get('export/{id}', 'export')->name('export');
                Route::get('close/{id}', 'close')->name('close');
                Route::get('email/{id}', 'email')->name('email');

                Route::get('deletefrom/{id}/{user_id}', 'deleteFrom')->name('deleteuser');
                Route::get('markfailed/{id}/{user_id}', 'markFailed')->name('markfailed');
                Route::get('markloss/{id}/{user_id}', 'markLoss')->name('markloss');

                // Catchall
                Route::get('{id}', 'show')->name('show');
            });
        });

        /* --- Routes related to Mollie --- */
        Route::controller(MollieController::class)->prefix('mollie')->middleware(['auth'])->name('mollie::')->group(function () {
            // Public routes
            Route::post('pay', 'pay')->name('pay');
            Route::get('status/{id}', 'status')->name('status');
            Route::get('receive/{id}', 'receive')->name('receive');

            // Finadmin only
            Route::get('list', 'index')->middleware(['permission:finadmin'])->name('index');
            Route::get('monthly/{month}', 'monthly')->middleware(['permission:finadmin'])->name('monthly');
        });
        /* --- Order generation (omnomcom admin only) --- */
        Route::get('supplier', [OmNomController::class, 'generateOrder'])->middleware(['permission:omnomcom'])->name('generateorder');
    });

    /* --- Routes related to webhooks --- */
    Route::any('webhook/mollie/{id}', [MollieController::class, 'webhook'])->name('webhook::mollie');

    /* --- Routes related to YouTube videos --- */
    Route::controller(VideoController::class)->prefix('video')->name('video::')->group(function () {
        Route::prefix('admin')->middleware(['permission:board'])->name('admin::')->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('create', 'store')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('delete/{id}', 'destroy')->name('delete');
        });
        Route::get('', 'publicIndex')->name('index');
        Route::get('{id}', 'show')->name('show');
    });

    /* --- Routes related to announcements --- */
    Route::controller(AnnouncementController::class)->prefix('announcement')->name('announcement::')->group(function () {
        Route::prefix('admin')->middleware(['permission:sysadmin'])->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('delete/{id}', 'destroy')->name('delete');
            Route::get('clear', 'clear')->name('clear');
        });
        Route::get('dismiss/{id}', 'dismiss')->name('dismiss');
    });

    /* --- Legacy routes related to photos --- */
    Route::prefix('photos')->group(function () {
        Route::get('/photo/{photo}', fn (Photo $photo) => to_route('albums::album::show', ['album' => $photo->album, 'photo' => $photo->id]));
        Route::get('{album}', fn ($album) => to_route('albums::album::list', ['album' => $album]));
    });

    /* --- Routes related to photos --- */
    Route::prefix('albums')->name('albums::')->group(function () {

        Route::controller(LikedPhotosController::class)->prefix('liked')->name('liked::')->middleware(['auth', 'member'])->group(function () {
            Route::get('', 'show')->name('list');
            Route::get('viewer', 'photo')->name('show');
        });

        // Public routes
        Route::controller(PhotoAlbumController::class)->group(function () {
            Route::get('', 'index')->name('index');

            Route::prefix('{album}')->name('album::')->group(function () {
                Route::get('', 'show')->name('list');
                Route::get('viewer', 'photo')->name('show');
            });

            Route::post('/like/{photo}', 'toggleLike')->middleware(['auth'])->name('like');
        });

        /* --- Routes related to the photo admin. (Protography only) --- */
        Route::controller(PhotoAdminController::class)->prefix('admin')->middleware(['permission:protography'])->name('admin::')->group(function () {
            Route::get('index', 'index')->name('index');
            Route::post('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->middleware(['permission:publishalbums'])->name('update');
            Route::post('edit/{id}/action', 'action')->name('action');
            Route::post('edit/{id}/upload', 'upload')->name('upload');
            Route::get('edit/{id}/delete', 'delete')->middleware(['permission:publishalbums'])->name('delete');
            Route::get('publish/{id}', 'publish')->middleware(['permission:publishalbums'])->name('publish');
            Route::get('unpublish/{id}', 'unpublish')->middleware(['permission:publishalbums'])->name('unpublish');
        });
    });

    /* --- Fetching media: Private --- */
    Route::controller(PrivateMediaController::class)->middleware(['auth', 'member'])->prefix('media')->name('media::')->group(function () {
        Route::get('{id}/{conversion?}', 'show')->name('show');
    });

    /* --- Fetching files: Public   --- */
    Route::controller(FileController::class)->prefix('file')->name('file::')->group(function () {
        Route::get('{id}/{hash}/{name?}', 'get')->name('get');
    });

    /* --- Routes related to Spotify. (Board) --- */
    Route::get('spotify/oauth', [SpotifyController::class, 'oauthTool'])->name('spotify::oauth')->middleware(['auth', 'permission:board']);

    /* --- Routes related to roles and permissions. (Sysadmin) --- */
    Route::controller(AuthorizationController::class)->prefix('authorization')->middleware(['auth', 'permission:sysadmin'])->name('authorization::')->group(function () {
        Route::get('', 'index')->name('overview');
        Route::post('{id}/grant', 'grant')->name('grant');
        Route::get('{id}/revoke/{user}', 'revoke')->name('revoke');
    });

    /* Routes related to the password manager. (Access restricted in controller) */
    Route::controller(PasswordController::class)->prefix('passwordstore')->middleware(['auth'])->name('passwordstore::')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('auth', 'getAuth')->name('auth');
        Route::post('auth', 'postAuth')->name('postAuth');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('delete/{id}', 'destroy')->name('delete');
    });

    /* --- Routes related to e-mail aliases. (Sysadmin only) --- */
    Route::controller(AliasController::class)->prefix('alias')->middleware(['auth', 'permission:sysadmin'])->name('alias::')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('delete/{id_or_alias}', 'destroy')->name('delete');
        Route::post('update', 'update')->name('update');
    });

    /* --- The route for the SmartXp Screen. (Public) --- */
    Route::controller(SmartXpScreenController::class)->group(function () {
        Route::get('smartxp', 'show')->name('smartxp');
        Route::get('protopolis', 'showProtopolis')->name('protopolis');
        Route::get('caniworkinthesmartxp', 'canWork');
    });

    /* The routes for Protube. (Public) */
    Route::controller(ProtubeController::class)->prefix('protube')->name('protube::')->group(function () {
        Route::get('dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');
        Route::get('togglehistory', 'toggleHistory')->middleware(['auth'])->name('togglehistory');
        Route::get('clearhistory', 'clearHistory')->middleware(['auth'])->name('clearhistory');
        Route::get('top', 'topVideos')->name('top');
    });

    /* --- Routes related to calendars --- */
    Route::get('ical/calendar/{personal_key?}', [EventController::class, 'icalCalendar'])->name('ical::calendar');

    /* --- Routes related to the Achievement system --- */
    Route::controller(AchievementController::class)->group(function () {
        Route::get('achieve/{achievement}', 'achieve')->middleware(['auth'])->name('achieve');

        Route::prefix('achievement')->name('achievement::')->group(function () {
            // Board only
            Route::middleware(['auth', 'permission:board'])->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::post('update/{id}', 'update')->name('update');
                Route::get('delete/{id}', 'destroy')->name('delete');
                Route::post('award/{id}', 'award')->name('award');
                Route::post('give', 'give')->name('give');
                Route::get('take/{id}/{user}', 'take')->name('take');
                Route::get('takeAll/{id}', 'takeAll')->name('takeAll');
                Route::post('{id}/icon', 'icon')->name('icon');
            });
            // Public
            Route::get('gallery', 'gallery')->name('gallery');
        });
    });
    /* --- Routes related to the Welcome Message system. (Board only) --- */
    Route::resource('welcomeMessages', WelcomeController::class)
        ->middleware(['auth', 'permission:board'])
        ->only(['index', 'store', 'destroy']);

    /* --- Routes related to Protube TempAdmin (Board only) --- */
    Route::controller(TempAdminController::class)->prefix('tempadmin')->name('tempadmin::')->middleware(['auth', 'permission:board'])->group(function () {
        Route::get('make/{id}', 'make')->name('make');
        Route::get('end/{id}', 'end')->name('end');
        Route::get('endId/{id}', 'endId')->name('endId');
    });
    Route::resource('tempadmins', TempAdminController::class)->only(['index', 'create', 'store', 'edit', 'update'])->middleware(['auth', 'permission:board']);

    /* --- Routes related to QR Authentication --- */
    Route::controller(QrAuthController::class)->prefix('qr')->name('qr::')->group(function () {
        // API routes
        Route::get('code/{code}', 'showCode')->name('code');
        Route::post('generate', 'generateRequest')->name('generate');
        Route::get('isApproved', 'isApproved')->name('approved');

        // Usage of the QR code
        Route::middleware(['auth'])->group(function () {
            Route::get('{code}', 'showDialog')->name('dialog');
            Route::get('{code}/approve', 'approve')->name('approve');
        });
    });

    /* Routes related to the Short URL Service */
    Route::get('go/{short?}', [ShortUrlController::class, 'go'])->name('short_urls.go');
    Route::get('short_urls/qr_code/{id}', [ShortUrlController::class, 'qrCode'])->name('short_urls.qr_code')->middleware(['auth', 'permission:board']);
    Route::resource('short_urls', ShortUrlController::class)->except('show')->middleware(['auth', 'permission:board']);

    /* --- Routes related to the DMX Management. (Board or alfred) --- */
    Route::prefix('dmx')->name('dmx.')->middleware(['auth', 'permission:board|alfred'])->group(function () {
        Route::resource('fixtures', DmxFixtureController::class)->except('show');

        Route::resource('overrides', DmxOverrrideController::class)->except('show');
    });

    /* --- Routes related to the Query system. (Board only) --- */
    Route::controller(QueryController::class)->prefix('queries')->name('queries::')->middleware(['auth', 'permission:board'])->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/activity_overview', 'activityOverview')->name('activity_overview');
        Route::get('/activity_statistics', 'activityStatistics')->name('activity_statistics');
        Route::get('/membership_totals', 'membershipTotals')->name('membership_totals');
        Route::get('/new_membership_totals', 'newMembershipTotals')->name('new_membership_totals');
    });

    /* --- Routes related to the mini-sites --- */
    Route::prefix('minisites')->name('minisites::')->group(function () {
        Route::controller(IsAlfredThereController::class)->prefix('isalfredthere')->name('isalfredthere::')->group(function () {
            // Public routes
            Route::get('/', 'index')->name('index');
            // Board only
            Route::get('/edit', 'edit')->middleware(['auth', 'permission:sysadmin|alfred'])->name('edit');
            Route::post('/update', 'update')->middleware(['auth', 'permission:sysadmin|alfred'])->name('update');
        });
    });

    Route::middleware(['auth', 'permission:senate'])->group(function () {
        Route::resource('codex', CodexController::class);
        Route::resource('codexSong', CodexSongController::class)->except(['index', 'show']);
        Route::resource('codexSongCategory', CodexSongCategoryController::class)->except(['index', 'show']);
        Route::resource('codexText', CodexTextController::class)->except(['index', 'show']);
        Route::resource('codexTextType', CodexTextTypeController::class)->except(['index', 'show']);
    });

    Route::middleware(['auth', 'permission:sysadmin'])->prefix('inertia')->group(function () {
        Route::get('/', fn () => inertia('Welcome'))->name('index');
        Route::get('/admin', fn () => inertia('admin/Admin'))->name('admin');
    });

    /* --- Route related to the december theme --- */
    Route::get('/december/toggle', function (): RedirectResponse {
        Cookie::queue('disable-december', Cookie::get('disable-december') === 'disabled' ? 'enabled' : 'disabled', 43800);

        return back();
    })->name('december::toggle');
});
