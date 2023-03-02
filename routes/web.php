<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Proto\Http\Controllers\AccountController;
use Proto\Http\Controllers\AchievementController;
use Proto\Http\Controllers\ActivityController;
use Proto\Http\Controllers\AddressController;
use Proto\Http\Controllers\AliasController;
use Proto\Http\Controllers\AnnouncementController;
use Proto\Http\Controllers\AuthController;
use Proto\Http\Controllers\AuthorizationController;
use Proto\Http\Controllers\BankController;
use Proto\Http\Controllers\CommitteeController;
use Proto\Http\Controllers\CompanyController;
use Proto\Http\Controllers\DinnerformController;
use Proto\Http\Controllers\DisplayController;
use Proto\Http\Controllers\DmxController;
use Proto\Http\Controllers\EmailController;
use Proto\Http\Controllers\EmailListController;
use Proto\Http\Controllers\EventController;
use Proto\Http\Controllers\FileController;
use Proto\Http\Controllers\GoodIdeaController;
use Proto\Http\Controllers\HeaderImageController;
use Proto\Http\Controllers\HomeController;
use Proto\Http\Controllers\IsAlfredThereController;
use Proto\Http\Controllers\JobofferController;
use Proto\Http\Controllers\LeaderboardController;
use Proto\Http\Controllers\MemberCardController;
use Proto\Http\Controllers\MenuController;
use Proto\Http\Controllers\MollieController;
use Proto\Http\Controllers\NarrowcastingController;
use Proto\Http\Controllers\NewsController;
use Proto\Http\Controllers\OmNomController;
use Proto\Http\Controllers\OrderLineController;
use Proto\Http\Controllers\PageController;
use Proto\Http\Controllers\ParticipationController;
use Proto\Http\Controllers\PasswordController;
use Proto\Http\Controllers\PhotoAdminController;
use Proto\Http\Controllers\PhotoController;
use Proto\Http\Controllers\ProductCategoryController;
use Proto\Http\Controllers\ProductController;
use Proto\Http\Controllers\ProfilePictureController;
use Proto\Http\Controllers\ProtubeController;
use Proto\Http\Controllers\QrAuthController;
use Proto\Http\Controllers\QueryController;
use Proto\Http\Controllers\QuoteCornerController;
use Proto\Http\Controllers\RadioController;
use Proto\Http\Controllers\RegistrationHelperController;
use Proto\Http\Controllers\RfidCardController;
use Proto\Http\Controllers\SearchController;
use Proto\Http\Controllers\ShortUrlController;
use Proto\Http\Controllers\SoundboardController;
use Proto\Http\Controllers\SpotifyController;
use Proto\Http\Controllers\SurfConextController;
use Proto\Http\Controllers\TempAdminController;
use Proto\Http\Controllers\TFAController;
use Proto\Http\Controllers\TicketController;
use Proto\Http\Controllers\TIPCieController;
use Proto\Http\Controllers\UserAdminController;
use Proto\Http\Controllers\UserProfileController;
use Proto\Http\Controllers\UserDashboardController;
use Proto\Http\Controllers\VideoController;
use Proto\Http\Controllers\WelcomeController;
use Proto\Http\Controllers\WithdrawalController;

require 'minisites.php';

/* Pass view name to body class */
View::composer('*', function ($view) {
    View::share('viewName', $view->getName());
});

// TODO: change string based controller route definitions to standard PHP callable syntax.

ROute::middleware('forcedomain')->group(function () {

    /* The main route for the frontpage. */

    Route::controller(HomeController::class)->group(function(){
        Route::get('', 'show')->name('homepage');
        Route::get('developers', 'developers')->name('developers');
        Route::get('fishcam', function(){
            return view('misc.fishcam');
        })->middleware('member')->name('fishcam');
    });

    Route::get('becomeamember', [UserDashboardController::class, 'becomeAMemberOf']);

    /* Routes related to the header images. */
    Route::prefix('headerimage')->name('headerimage::')->controller(HeaderImageController::class)->middleware(['auth', 'permission:header-image'])->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('add', 'create')->name('add');
        Route::post('add', 'store')->name('add');
        Route::get('delete/{id}', 'destroy')->name('delete');
    });

    /* Routes for the search function. */
    Route::controller(SearchController::class)->group(function(){
        Route::get('search','search')->name('search');
        Route::post('search', 'search')->name('search');
        Route::get('opensearch', 'openSearch')->name('search::opensearch');

        /* Routes for the UTwente address book. */
        Route::prefix('ldap')->name('ldap::')->middleware('utwente')->group(function () {
            Route::get('search','ldapSearch')->name('search');
            Route::post('search', 'ldapSearch')->name('search');
        });
    });

    /* Routes related to authentication. */
    Route::name('login::')->controller(AuthController::class)->group(function () {
        Route::get('login', 'getLogin')->name('show');
        Route::post('login', 'postLogin')->name('post')->middleware('throttle:5,1');

        Route::prefix('logout')->group(function(){
            Route::get('', 'getLogout')->name('logout');
            Route::get('redirect', 'getLogoutRedirect')->name('logout::redirect');
        });

        Route::prefix('password')->group(function(){
            Route::get('reset/{token}', 'getPasswordReset')->name('resetpass::token');
            Route::post('reset', 'postPasswordReset')->name('resetpass::submit')->middleware('throttle:5,1');

            Route::get('email', 'getPasswordResetEmail')->name('resetpass');
            Route::post('email', 'postPasswordResetEmail')->name('resetpass::send')->middleware('throttle:5,1');

            Route::middleware('auth')->group(function(){
                Route::get('sync', 'getPasswordSync')->name('password::sync');
                Route::post('sync', 'postPasswordSync')->name('password::sync')->middleware('throttle:5,1');

                Route::get('change', 'getPasswordChange')->name('password::change');
                Route::post('change', 'postPasswordChange')->name('password::change')->middleware('throttle:5,1');
            });

            Route::prefix('register')->group(function(){
                Route::get('', 'getRegister')->name('register');
                Route::post('', 'postRegister')->name('register')->middleware('throttle:5,1');
                Route::post('surfconext', 'postRegisterSurfConext')->name('register::surfconext')->middleware('throttle:5,1');
            });

            Route::prefix('surfconext')->group(function(){
                Route::get('', 'startSurfConextAuth')->name('edu');
                Route::get('post', 'postSurfConextAuth')->name('edupost');

                Route::prefix('username')->group(function() {
                    Route::get('', 'requestUsername')->name('requestusername');
                    Route::post('', 'requestUsername')->name('requestusername')->middleware('throttle:5,1');
                });
            });
        });
    });

    /* Routes related to user profiles. */
    Route::prefix('user')->name('user::')->middleware('auth')->group(function(){
        Route::controller(AuthController::class)->group(function(){
            Route::post('delete', 'deleteUser')->name('delete');
            Route::post('password', 'updatePassword')->name('changepassword');
        });

        Route::get('{id?}', [UserProfileController::class, 'show'])->name('profile')->middleware('member');

        Route::controller(UserAdminController::class)->group(function(){
            Route::get('quit_impersonating', 'quitImpersonating')->name('quitimpersonating');

            /* Routes related to members. */
            Route::name('member::')->prefix('{id}/member')->middleware('permission:registermembers')->group(function(){
                Route::get('impersonate', 'impersonate')->name('impersonate')->middleware('permission:board');
                Route::post('add', 'addMembership')->name('add');
                Route::post('remove', 'endMembership')->name('remove');
                Route::post('end_in_september', 'EndMembershipInSeptember')->name('endinseptember');
                Route::post('remove_end', 'removeMembershipEnd')->name('removeend');
                Route::post('settype', 'setMembershipType')->name('settype');

                /* Routes related to the custom omnomcom sound. */
                Route::prefix('omnomcomsound')->name('omnomcomsound::')->middleware('permission:board')->group(function(){
                    Route::post('update', 'uploadOmnomcomSound')->name('update');
                    Route::get('delete', 'deleteOmnomcomSound')->name('delete');
                });
            });

            Route::prefix('admin')->name('admin::')->middleware('permission:board')->group(function(){
                Route::get('','index')->name('list');
                Route::get('{id}', 'details')->name('details');
                Route::post('{id}', 'update')->name('update');

                Route::get('studied_create/{id}', 'toggleStudiedCreate')->name('toggle_studied_create');
                Route::get('studied_itech/{id}', 'toggleStudiedITech')->name('toggle_studied_itech');
                Route::get('nda/{id}', 'toggleNda')->name('toggle_nda');
                Route::get('unblock_omnomcom/{id}', 'unblockOmnomcom')->name('unblock_omnomcom');
            });
        });

        Route::controller(UserDashboardController::class)->group(function() {
            Route::get('personal_key', 'generateKey')->name('personal_key::generate');
            Route::get('dashboard', 'show')->name('dashboard');
            Route::post('dashboard', 'update')->name('dashboard');
            Route::post('change_email', 'updateMail')->name('changemail')->middleware('throttle:3,1');

            /* Routes related to the memberprofiles */
            Route::prefix('memberprofile')->name('memberprofile::')->group(function(){
                Route::prefix('complete')->group(function(){
                    Route::get('', 'getCompleteProfile')->name('complete');
                    Route::post('', 'postCompleteProfile')->name('complete');
                });
                Route::prefix('clear')->group(function(){
                    Route::get('', 'getClearProfile')->name('clear');
                    Route::post('', 'postClearProfile')->name('clear');
                });
            });

            /* Routes related to diet. */
            Route::prefix('diet')->name('diet::')->group( function () {
                Route::post('edit', 'editDiet')->name('edit');
            });
        });

        Route::prefix('registrationhelper')->name('registrationhelper::')->middleware('permission:registermembers')->controller(RegistrationHelperController::class)->group(function(){
            Route::get('', 'index')->name('list');
            Route::get('{id}', 'details')->name('details');
        });

        /* Routes related to addresses. */
        Route::prefix('address')->name('address::')->controller(AddressController::class)->group(function(){
            Route::get('add', 'add')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('delete', 'destroy')->name('delete');
            Route::get('edit', 'edit')->name('edit');
            Route::post('edit', 'update')->name('edit');
            Route::get('togglehidden', 'toggleHidden')->name('togglehidden');
        });

        /* Routes related to bank accounts. */
        Route::prefix('bank')->name('bank::')->controller(BankController::class)->group(function(){
            Route::get('add', 'add')->name('add');
            Route::post('add', 'store')->name('add');
            Route::post('delete', 'destroy')->name('delete');
            Route::get('edit', 'edit')->name('edit');
            Route::post('edit', 'update')->name('edit');
        });

        /* Routes related to RFID cards. */
        Route::prefix('rfidcard/{id}')->name('rfid::')->controller(RFIDCardController::class)->group(function(){
            Route::get('delete', 'destroy')->name('delete');
            Route::get('edit', 'edit')->name('edit');
            Route::post('edit', 'update')->name('edit');
        });

        /* Routes related to profile pictures. */
        Route::prefix('profilepic')->name('pic::')->controller(ProfilePictureController::class)->group(function(){
            Route::post('update', 'update')->name('update');
            Route::get('delete', 'destroy')->name('delete');
        });

        /* Routes related to UT accounts. */
        Route::prefix('edu')->name('edu::')->controller(SurfConextController::class)->group(function(){
            Route::get('delete', 'destroy')->name('delete');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
        });

        /* Routes related to 2FA. */
        Route::prefix('2fa')->name('2fa::')->controller(TFAController::class)->group(function(){
            Route::post('add', 'create')->name('add');
            Route::post('delete', 'destroy')->name('delete');
            Route::post('delete/{id}', 'adminDestroy')->name('admindelete')->middleware('permission:board');
        });
    });

    /* Routes related to the Membership Forms */
    Route::prefix('memberform')->name('memberform::')->middleware('auth')->group(function (){
        Route::controller(UserAdminController::class)->group(function (){
            Route::get('sign', 'getMemberForm')->name('sign');
            Route::post('sign', 'postMemberForm')->name('sign');
        });
        Route::controller(UserAdminController::class)->group(function(){
            Route::prefix('download')->name('download::')->group(function(){
                Route::get('new/{id}', 'getNewMemberForm')->name('new');
                Route::get('signed/{id}', 'getSignedMemberForm')->name('signed');
            });
            Route::post('print/{id}', 'printMemberForm')->name('print')->middleware('permission:board');
            Route::post('delete/{id}', 'destroyMemberForm')->name('delete')->middleware('permission:board');
        });
    });

    /* Routes related to committees. */
    Route::prefix('committee')->name('committee::')->controller(CommitteeController::class)->group(function(){

        Route::get('list', 'overview')->name('list');
        Route::get('{id}', 'show')->name('show');

        Route::middleware('auth')->group(function(){

            Route::get('{slug}/toggle_helper_reminder', ['as' => 'toggle_helper_reminder', 'middleware' => ['auth'], 'uses' => 'CommitteeController@toggleHelperReminder']);

            Route::middleware('member')->group(function() {
                Route::get('{id}/send_anonymous_email', ['as' => 'anonymousmail', 'middleware' => ['auth', 'member'], 'uses' => 'CommitteeController@showAnonMailForm']);
                Route::post('{id}/send_anonymous_email', ['as' => 'anonymousmail', 'middleware' => ['auth', 'member'], 'uses' => 'CommitteeController@postAnonMailForm']);
            });

            Route::middleware('permission:board')->group(function() {

                Route::get('add', 'add')->name('add');
                Route::post('add', 'store')->name('add');

                Route::get('{id}/edit', 'edit')->name('edit');
                Route::post('{id}/edit', 'update')->name('edit');

                Route::post('{id}/image', 'image')->name('image');

                Route::prefix('membership')->name('membership::')->group(function () {
                    Route::post('add', 'addMembership')->name('add');
                    Route::get('{id}/delete', 'deleteMembership')->name('delete');
                    Route::get('{id}', 'editMembershipForm')->name('edit');
                    Route::post('{id}', 'editMembership')->name('edit');
                    Route::get('end/{committee}/{edition}', 'endEdition')->name('endedition');
                });
            });
        });
    });

    /* Routes related to societies. */
    Route::prefix('society')->name('society::')->controller(CommitteeController::class)->group(function(){
        Route::get('list', 'overview')->name('list')->defaults('showSociety', true);
        Route::get('{id}', 'show')->name('show');
    });

    /* Routes related to narrowcasting. */
    Route::prefix('narrowcasting')->name('narrowcasting::')->controller(NarrowcastingController::class)->group(function(){
        Route::get('', 'display')->name('display');
        Route::middleware(['auth', 'permission:board'])->group(function(){
            Route::get('list', 'index')->name('list');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');
            Route::get('clear', 'clear')->name('clear');
        });
    });

    /* Routes related to companies. */
    Route::prefix('companies')->name('companies::')->controller('CompanyController')->group(function(){

        Route::get('', 'index')->name('index');
        Route::get('{id}', 'show')->name('show');

        Route::middleware(['auth', 'permission:board'])->group(function(){
            Route::get('list', 'adminIndex')->name('admin');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');

            Route::get('up/{id}', 'orderUp')->name('orderUp');
            Route::get('down/{id}', 'orderDown')->name('orderDown');
        });
    });

    /* Routes related to membercard. */
    Route::prefix('membercard')->name('membercard::')->group(function(){
       Route::controller(MemberCardController::class)->group(function(){
           Route::get('print', 'startPrint')->name('print')->middleware(['auth', 'permission:board']);
           Route::get('download/{id}', 'download')->name('download');
       });

        Route::controller(CompanyController::class)->group(function(){
            Route::get('', 'indexmembercard')->name('index');
            Route::get('{id}', 'showmembercard')->name('show');
        });
    });

    /* Routes related to joboffers. */
    Route::prefix('joboffers')->name('joboffers::')->controller(JobofferController::class)->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('{id}', 'show')->name('show');

        Route::middleware(['auth', 'permission:board'])->group(function(){
            Route::get('list', 'adminIndex')->name('admin');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');
        });
    });

    /* Routes related to leaderboards. */
    Route::prefix('leaderboard')->name('leaderboards::')->middleware(['auth', 'member'])->controller(LeaderboardController::class)->group(function(){

        Route::get('', 'index')->name('index');

        Route::middleware(['permission:board'])->group(function(){
            Route::get('list', 'adminIndex')->name('admin');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');

            Route::prefix('entries')->name('entries::')->group(function(){
                Route::post('add', 'store')->name('add');
                Route::post('update', 'update')->name('update');
                Route::get('delete/{id}', 'destroy')->name('delete');
            });
        });
    });

    /* Routes related to dinnerforms. */
    Route::prefix('dinnerform')->name('dinnerform::')->middleware('auth')->controller(DinnerformController::class)->group(function(){
        Route::get('{id}', 'show')->name('show');
        Route::middleware('permission:tipcie')->group(function(){
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('close/{id}', 'close')->name('close');
            Route::get('delete/{id}', 'destroy')->name('delete');
            Route::get('admin/{id}', 'admin')->name('admin');
            Route::get('process/{id}', 'process')->name('process');
        });

        Route::prefix('orderline')->name('orderline::')->group(function(){
            Route::get('delete/{id}', 'delete')->name('delete');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('add/{id}', 'store')->name('add');
            Route::post('update/{id}', 'update')->name('update')->middleware('permission:tipcie');
        });
    });

    /*
     * Routes related to events.
     * Important: routes in this block always use event_id or a relevant other ID. activity_id is in principle never used.
     */
    Route::prefix('events')->name('event::')->group(function (){

        Route::controller(EventController::class)->group(function(){
            //show event overview pages
            Route::get('', 'index')->name('list');
            Route::get('archive/{year}', 'archive')->name('archive');

            // Show events
            Route::get('{id}', 'show')->name('show');

            Route::middleware('auth')->group(function(){
                Route::post('set_reminder', 'setReminder')->name('set_reminder');
                Route::get('toggle_relevant_only', 'toggleRelevantOnly')->name('toggle_relevant_only');

                Route::get('admin/{id}', 'admin')->name('admin');
                Route::get('scan/{id}', 'scan')->name('scan');
                // Force login for event
                Route::get('{id}/login', 'forceLogin')->name('login');

                Route::middleware('permission:board')->group(function() {
                    Route::get('add', 'create')->name('add');
                    Route::post('add', 'store')->name('add');

                    Route::get('edit/{id}', 'edit')->name('edit');
                    Route::post('edit/{id}', 'update')->name('edit');

                    Route::get('delete/{id}', 'destroy')->name('delete');
                    Route::get('copy', 'copyEvent')->name('copy');

                    Route::post('album/{event}/link', 'linkAlbum')->name('linkalbum');
                    Route::get('album/unlink/{album}', 'unlinkAlbum')->name('unlinkalbum');

                    Route::prefix('categories')->name('category::')->group(function(){
                        Route::get('', 'categoryAdmin')->name('admin');
                        Route::post('add', 'categoryStore')->name('add');
                        Route::get('edit/{id}', 'categoryEdit')->name('edit');
                        Route::post('edit/{id}', 'categoryUpdate')->name('edit');
                        Route::get('delete/{id}', 'categoryDestroy')->name('delete');
                    });
                });

                Route::prefix('financial')->name('financial::')->middleware('permission:finadmin')->group(function(){
                    Route::get('', 'finindex')->name('list');
                    Route::post('close/{id}', 'finclose')->name('close');
                });
            });
        });
        // Related to participation
        Route::controller(ParticipationController::class)->middleware('auth')->group(function(){
            Route::get('unparticipate/{participation_id}', 'destroy')->name('deleteparticipation');

            Route::middleware('member')->group(function(){
                Route::get('participate/{id}', 'create')->name('addparticipation');
                Route::get('togglepresence/{id}', 'togglePresence')->name('togglepresence');
            });

            Route::post('participatefor/{id}', 'createFor')->name('addparticipationfor')->middleware('permission:board');
        });

        Route::controller(ActivityController::class)->group(function(){

            Route::get('checklist/{id}','checklist')->name('checklist');

            Route::middleware('permission:board')->group(function(){
                // Related to activities
                Route::get('signup/{id}', 'store')->name('addsignup');
                Route::get('signup/{id}/delete', 'destroy')->name('deletesignup');

                // Related to helping committees
                Route::post('addhelp/{id}', 'addHelp')->name('addhelp');
                Route::post('updatehelp/{id}', 'updateHelp')->name('updatehelp');
                Route::get('deletehelp/{id}', 'deleteHelp')->name('deletehelp');
            });
        });

        // Buy tickets for an event
        Route::post('buytickets/{id}', [TicketController::class, 'buyForEvent'])->name('buytickets')->middleware('member');
    });

    /* Routes related to the newsletter */
    Route::prefix('newsletter')->name('newsletter::')->middleware('auth')->controller(NewsController::class)->group(function(){
        Route::get('', 'newsletterPreview')->name('preview');
        Route::middleware('permission:board')->group(function(){
            Route::get('content', 'getInNewsletter')->name('show');
            Route::get('toggle/{id}', 'toggleInNewsletter')->name('toggle');
            Route::post('send', 'sendNewsletter')->name('send');
            Route::post('text', 'saveNewsletterText')->name('text');
        });
    });

    /* Routes related to pages. */
    Route::prefix('page')->name('page::')->controller(PageController::class)->group(function(){
        Route::get('{slug}', ['as' => 'show', 'uses' => 'PageController@show']);

        Route::middleware(['auth','permission:board'])->group(function(){
            Route::get('', 'index')->name('list');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('delete/{id}', 'destroy')->name('delete');

            Route::prefix('/edit/{id}')->group(function(){
                Route::get('', 'edit')->name('edit');
                Route::post('', 'update')->name('edit');
                Route::post('image', 'featuredImage')->name('image');

                Route::post('file/add', 'addFile')->name('add');
                Route::get('file/{file_id}/delete', 'deleteFile')->name('delete');
            });
        });
    });

    /* Routes related to news. */
    Route::prefix('news')->name('news::')->controller(NewsController::class)->group(function(){

        Route::get('', 'NewsController@index')->name('list');
        Route::get('{id}', 'NewsController@show')->name('show');

        Route::middleware(['auth', 'permission:board'])->group(function(){
            Route::get('admin', 'admin')->name('admin');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');

            Route::prefix('edit/{id}')->group(function(){
                Route::get('', 'edit')->name('edit');
                Route::post('', 'update')->name('edit');
                Route::post('image', 'featuredImage')->name('image');
            });
        });
    });
    /* Routes related to menu. */
    Route::prefix('menu')->name('menu::')->middleware(['auth', 'permission:board'])->controller(MenuController::class)->group(function(){
        Route::get('', 'index')->name('list');
        Route::get('add', 'create')->name('add');
        Route::post('add', 'store')->name('add');

        Route::get('up/{id}', 'orderUp')->name('orderUp');
        Route::get('down/{id}', 'orderDown')->name('orderDown');

        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('edit/{id}', 'update')->name('edit');
        Route::get('delete/{id}', 'destroy')->name('delete');
    });

    /* Routes related to tickets. */
    Route::prefix('tickets')->name('tickets::')->middleware(['auth'])->controller(TicketController::class)->group(function(){

        Route::get('scan/{barcode}', 'scan')->name('scan');
        Route::get('unscan/{barcode?}', 'unscan')->name('unscan');
        Route::get('download/{id}','download')->name('download');

        Route::middleware(['auth', 'permission:board'])->group(function(){
            Route::get('', 'index')->name('list');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');
        });
    });

    /* Routes related to e-mail. */
    Route::get('togglelist/{id}', [EmailListController::class, 'toggleSubscription'])->name('togglelist')->middleware('auth');

    Route::get('unsubscribe/{hash}', [EmailListController::class, 'unsubscribeLink'])->name('unsubscribefromlist');

    Route::prefix('email')->name('email::')->middleware(['auth', 'permission:board'])->group(function(){

        Route::controller(EmailController::class)->group(function(){
            Route::get('', 'index')->name('admin');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('preview/{id}', 'show')->name('show');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('toggleready/{id}', 'toggleReady')->name('toggleready');
            Route::get('delete/{id}', 'destroy')->name('delete');

            Route::prefix('{id}/attachment')->name('attachment::')->group(function(){
                Route::post('add', 'addAttachment')->name('add');
                Route::get('delete/{file_id}', 'deleteAttachment')->name('delete');
            });
        });

        Route::prefix('list')->name('list::')->controller(EmaillistController::class)->group(function(){
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');
        });
    });

    /* Routes related to the Quote Corner. */
    Route::prefix('quotes')->name('quotes::')->middleware(['member'])->controller(QuoteCornerController::class)->group(function(){
        Route::get('', 'overview')->name('list');
        Route::post('add', 'add')->name('add');
        Route::get('delete/{id}', 'destroy')->name('delete');
        Route::get('like/{id}', 'toggleLike')->name('like');
        Route::get('search/{searchTerm?}', 'search')->name('search');
    });

    /* Routes related to the Good Idea Board. */
    Route::prefix('goodideas')->name('goodideas::')->middleware(['member'])->controller(GoodIdeaController::class)->group(function(){
        Route::get('', 'index')->name('index');
        Route::post('add', 'add')->name('add');
        Route::get('delete/{id}', 'delete')->name('delete');
        Route::post('vote', 'vote')->name('vote');
        Route::get('deleteall', 'deleteall')->name('deleteall')->middleware(['permission:board']);
    });

    /* Routes related to the OmNomCom. */
    Route::prefix('omnomcom')->name('omnomcom::')->group(function(){
        Route::get('minisite', [OmNomController::class, 'miniSite'])->name('minisite');

        /* Routes related to OmNomCom stores. */
        Route::prefix('store')->name('store::')->group(function(){
            Route::controller(OmNomController::class)->group(function(){
                Route::get('', 'choose')->name('choose')->middleware(['auth']);
                Route::get('{store?}', 'display')->name('show');
                Route::post('{store}/buy', 'buy')->name('buy');
            });

            Route::post('rfid/add', [RfidCardController::class, 'store'])->name('rfidadd');
        });

        /* Routes related to OmNomCom orders. */
        Route::prefix('orders')->name('orders::')->middleware(['auth'])->controller(OrderLineController::class)->group(function(){
            Route::get('history/{date?}', 'index')->name('list');

            Route::middleware(['permission:omnomcom'])->group(function(){
                Route::post('add/bulk', 'bulkStore')->name('addbulk');
                Route::post('add/single', 'store')->name('add');
                Route::get('delete/{id}', 'destroy')->name('delete');
                Route::get('', 'adminList')->name('adminlist');
            });


            Route::prefix('filter')->name('filter::')->middleware(['permission:omnomcom'])->group(function(){
                Route::get('name/{name?}', 'filterByUser')->name('name');
                Route::get('date/{date?}', 'filterByDate')->name('date');
            });
        });

        /* Routes related to the TIPCie OmNomCom store. */
        Route::prefix('tipcie')->name('tipcie::')->middleware(['auth', 'permission:tipcie'])->group(function(){
            Route::get('', [TIPCieController::class, 'orderIndex'])->name('orderhistory');
        });

        /* Routes related to Financial Accounts. */
        Route::prefix('accounts')->name('accounts::')->middleware(['permission:finadmin'])->controller(AccountController::class)->group(function(){
            Route::get('', 'index')->name('list');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');
            Route::get('{id}', 'show')->name('show');
            Route::post('aggregate/{account}', 'showAggregation')->name('aggregate');
        });

        /* Routes related to Payment Statistics. */
        Route::prefix('payments')->name('payments::')->middleware(['permission:finadmin'])->controller(OrderLineController::class)->group(function(){
            Route::get('statistics', 'showPaymentStatistics')->name('statistics');
            Route::post('statistics', 'showPaymentStatistics')->name('statistics');
        });

        /* Routes related to Products. */
        Route::prefix('products')->name('products::')->middleware(['permission:omnomcom'])->group(function(){
            Route::controller(ProductController::class)->group(function(){
                Route::get('', 'index')->name('list');
                Route::get('add', 'create')->name('add');
                Route::post('add', 'store')->name('add');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::post('edit/{id}', 'update')->name('edit');
                Route::get('delete/{id}', 'destroy')->name('delete');

                Route::get('export/csv', 'generateCsv')->name('export_csv');
                Route::post('update/bulk', 'bulkUpdate')->name('bulkupdate');
            });
            Route::controller(AccountController::class)->group(function(){
                Route::get('statistics', 'showOmnomcomStatistics')->name('statistics');
                Route::post('statistics', 'showOmnomcomStatistics')->name('statistics');
            });
        });

        /* Routes related to OmNomCom Categories. */
        Route::prefix('categories')->name('categories::')->middleware(['permission:omnomcom'])->controller(ProductCategoryController::class)->group(function(){
                Route::get('', 'index')->name('list');
                Route::get('add', 'create')->name('add');
                Route::post('add', 'store')->name('add');
                Route::post('edit/{id}', 'update')->name('edit');
                Route::get('delete/{id}', 'destroy')->name('delete');
                Route::get('{id}', 'show')->name('show');
        });

        /* Routes related to Withdrawals. */
        Route::prefix('withdrawals')->name('withdrawal::')->middleware(['permission:finadmin'])->controller(WithdrawalController::class)->group(function(){
            Route::get('', 'index')->name('list');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');
            Route::get('{id}', 'show')->name('show');

            Route::get('accounts/{id}', 'showAccounts')->name('showAccounts');
            Route::get('export/{id}', 'export')->name('export');
            Route::get('close/{id}', 'close')->name('close');
            Route::get('email/{id}', 'email')->name('email');

            Route::get('deletefrom/{id}/{user_id}', 'deleteFrom')->name('deleteuser');
            Route::get('markfailed/{id}/{user_id}', 'markFailed')->name('markfailed');
            Route::get('markloss/{id}/{user_id}', 'markLoss')->name('markloss');
        });

        Route::get('unwithdrawable', [WithdrawalController::class, 'unwithdrawable'])->name('unwithdrawable')->middleware(['permission:finadmin']);

        /* Routes related to Mollie. */
        Route::prefix('mollie')->name('mollie::')->middleware(['auth'])->controller(MollieController::class)->group(function(){
            Route::post('pay', 'pay')->name('pay');
            Route::get('status/{id}', 'status')->name('status');
            Route::get('receive/{id}', 'receive')->name('receive');
            Route::middleware(['permission:finadmin'])->group(function(){
                Route::get('list', 'index')->name('list');
                Route::get('monthly/{month}', 'monthly')->name('monthly');
            });
        });

        Route::get('mywithdrawal/{id}', [WithdrawalController::class, 'showForUser'])->name('mywithdrawal')->middleware(['auth']);
        Route::get('supplier', [OmNomController::class, 'generateOrder'])->name('generateorder')->middleware(['permission:omnomcom']);
    });

    /* Routes related to webhooks. */
    Route::prefix('webhook')->name('webhook::')->group(function () {
        Route::any('mollie/{id}', [MollieController::class, 'webhook'])->name('mollie');
    });
    /* Routes related to YouTube videos. */
    Route::prefix('video')->name('video::')->controller(VideoController::class)->group(function () {

        Route::get('{id}', 'view')->name('view');
        Route::get('', 'index')->name('index');

        Route::prefix('admin')->middleware(['permission:board'])->name('admin::')->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('add', 'store')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');
        });
    });
    /* Routes related to announcements. */
    Route::prefix('announcement')->name('announcement::')->controller(AnnouncementController::class)->group(function () {
        Route::get('dismiss/{id}', 'dismiss')->name('dismiss');

        Route::prefix('admin')->middleware(['permission:sysadmin'])->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('add', 'create')->name('add');
            Route::post('add', 'store')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');
            Route::get('clear', 'clear')->name('clear');
        });
    });

    /* Routes related to photos. */
    Route::prefix('photos')->name('photo::')->group(function(){
        Route::controller(PhotoController::class)->group(function() {
            Route::get('', 'index')->name('albums');
            Route::get('slideshow', 'slideshow')->name('slideshow');

            Route::prefix('{id}')->name('album::')->group(function () {
                Route::get('', 'show')->name('list');
            });

            Route::get('like/{id}', 'likePhoto')->name('likes')->middleware('auth');
            Route::get('dislike/{id}', 'dislikePhoto')->name('dislikes')->middleware('auth');
            Route::get('photo/{id}', 'photo')->name('view');
        });

        Route::prefix('admin')->name('admin::')->middleware(['permission:protography'])->controller(PhotoAdminController::class)->group(function(){
            Route::get('index', 'index')->name('index');
            Route::post('index', 'search')->name('index');
            Route::post('add', 'create')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}/action', 'action')->name('action');
            Route::post('edit/{id}/upload', 'upload')->name('upload');
            Route::middleware(['permission:publishalbums'])->group(function(){
                Route::post('edit/{id}', 'update')->name('edit');
                Route::get('edit/{id}/delete', 'delete')->name('delete');
                Route::get('publish/{id}', 'publish')->name('publish');
                Route::get('unpublish/{id}', 'unpublish')->name('unpublish');
            });
        });
    });

    /* Routes related to Images. */
    Route::prefix('image')->name('image::')->controller(FileController::class)->group(function () {
        Route::get('{id}/{hash}', 'getImage')->name('get');
        Route::get('{id}/{hash}/{name}', 'getImage')->name('get');
    });

    /* Routes related to Spotify. */
    Route::prefix('spotify')->name('spotify::')->middleware(['auth', 'permission:board'])->controller(SpotifyController::class)->group(function () {
        Route::get('oauth', 'oauthTool')->name('oauth');
    });

    /* Routes related to roles and permissions. */
    Route::prefix('authorization')->name('authorization::')->middleware(['auth', 'permission:sysadmin'])->controller(AuthorizationController::class)->group(function () {
        Route::get('', 'index')->name('overview');
        Route::post('{id}/grant', 'grant')->name('grant');
        Route::get('{id}/revoke/{user}', 'revoke')->name('revoke');
    });

    /* Routes related to the password manager. */
    Route::prefix('passwordstore')->name('passwordstore::')->middleware(['auth'])->controller(PasswordController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('auth', 'getAuth')->name('auth');
        Route::post('auth', 'postAuth')->name('auth');
        Route::get('add', 'create')->name('add');
        Route::post('add', 'store')->name('add');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('edit/{id}', 'update')->name('edit');
        Route::get('delete/{id}', 'destroy')->name('delete');
    });

    /* Routes related to e-mail aliases. */
    Route::prefix('alias')->name('alias::')->middleware(['auth', 'permission:sysadmin'])->controller(AliasController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'create')->name('add');
        Route::post('add', 'store')->name('add');
        Route::get('delete/{id_or_alias}', 'destroy')->name('delete');
        Route::post('update', 'update')->name('update');
    });

    /* The route for the SmartXp Screen. */
    Route::controller(SmartXPScreenController::class)->group(function(){
        Route::get('smartxp','show')->name('smartxp');
        Route::get('caniworkinthesmartxp', 'canWork');
    });

    /* The routes for Protube. */
    Route::prefix('protube')->name('protube::')->group(function(){
        Route::controller(ProtubeController::class)->group(function(){
            Route::get('screen', 'screen')->name('screen');
            Route::get('offline', 'offline')->name('offline');
            Route::get('top', 'top')->name('top');
            Route::get('{id?}', 'remote')->name('remote');

            Route::middleware('auth')->group(function(){
                Route::get('admin', 'admin')->name('admin');
                Route::get('dashboard', 'dashboard')->name('dashboard');
                Route::get('togglehistory', 'toggleHistory')->name('togglehistory');
                Route::get('clearhistory', 'clearHistory')->name('clearhistory');
                Route::get('login', 'loginRedirect')->name('login');
            });
        });
        /* Routes related to the Protube Radio */
        Route::prefix('radio')->name('radio::')->middleware(['auth', 'permission:sysadmin'])->controller(RadioController::class)->group(function(){
            Route::get('index', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::get('delete/{id}', 'destroy')->name('delete');
        });

        /* Routes related to the Protube displays */
        Route::prefix('display')->name('display::')->middleware(['permission:sysadmin'])->controller(DisplayController::class)->group(function(){
            Route::get('index', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('delete/{id}', 'destroy')->name('delete');
        });

        /* Routes related to the Soundboard */
        Route::prefix('soundboard')->name('soundboard::')->middleware(['permission:sysadmin'])->controller(SoundboardController::class)->group(function(){
            Route::get('index', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::get('delete/{id}', 'destroy')->name('delete');
            Route::get('togglehidden/{id}', 'toggleHidden')->name('togglehidden');
        });
    });

    /* Routes related to calendars. */
    Route::prefix('ical')->name('ical::')->controller(EventController::class)->group(function () {
        Route::get('calendar/{personal_key?}', 'icalCalendar')->name('calendar');
    });

    /* Routes related to the Achievement system. */
    Route::controller(AchievementController::class)->group(function(){
        Route::prefix('achievement')->name('achievement::')->group(function () {
            Route::middleware(['auth', 'permission:board'])->group(function(){
                Route::get('', 'overview')->name('list');
                Route::get('add', 'create')->name('add');
                Route::post('add', 'store')->name('add');
                Route::get('manage/{id}', 'manage')->name('manage');
                Route::post('update/{id}', 'update')->name('update');
                Route::get('delete/{id}', 'destroy')->name('delete');
                Route::post('award/{id}', 'award')->name('award');
                Route::post('give', 'give')->name('give');
                Route::get('take/{id}/{user}', 'take')->name('take');
                Route::get('takeAll/{id}', 'takeAll')->name('takeAll');
                Route::post('{id}/icon', 'icon')->name('icon');
            });
            Route::get('gallery', 'gallery')->name('gallery');
        });
        Route::get('achieve/{achievement}', 'achieve')->name('achieve')->middleware(['auth']);
    });
    /* Routes related to the Welcome Message system. */
    Route::prefix('welcomeMessages')->name('welcomeMessages::')->middleware(['auth', 'permission:board'])->controller(WelcomeController::class)->group(function () {
        Route::get('', 'overview')->name('list');
        Route::post('add', 'store')->name('add');
        Route::get('delete/{id}', 'destroy')->name('delete');
    });

    /* Routes related to Protube TempAdmin */
    Route::prefix('tempadmin')->name('tempadmin::')->middleware(['auth', 'permission:board'])->controller(TempAdminController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('make/{id}', 'make')->name('make');
        Route::get('end/{id}', 'end')->name('end');
        Route::get('endId/{id}', 'endId')->name('endId');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('edit/{id}', 'update')->name('edit');
        Route::get('add', 'create')->name('add');
        Route::post('add', 'store')->name('add');
    });

    /* Routes related to QR Authentication. */
    Route::prefix('qr')->name('qr::')->controller(QrAuthController::class)->group(function () {
        Route::get('code/{code}', 'showCode')->name('code');
        Route::post('generate', 'generateRequest')->name('generate');
        Route::get('isApproved', 'isApproved')->name('approved');
        Route::middleware(['auth'])->group(function () {
            Route::get('{code}', 'showDialog')->name('dialog');
            Route::get('{code}/approve', 'approve')->name('approve');
        });
    });

    /* Routes related to the Short URL Service */
    Route::name('short_url::')->controller(ShortUrlController::class)->group(function () {
        Route::prefix('short_url')->middleware(['auth', 'permission:board'])->group(function (){
            Route::get('', 'index')->name('index');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('edit');
            Route::get('delete/{id}', 'destroy')->name('delete');
        });
        Route::get('go/{short?}', 'go')->name('go');
    });

    /* Routes related to the DMX Management. */
    Route::prefix('dmx')->name('dmx::')->middleware(['auth', 'permission:board|alfred'])->controller(DmxController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/add', 'create')->name('add');
        Route::post('/add', 'store')->name('add');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/edit/{id}', 'update')->name('edit');
        Route::get('/delete/{id}', 'destroy')->name('delete');

        Route::prefix('override')->name('override::')->group(function () {
            Route::get('/', 'overrideIndex')->name('index');
            Route::get('/add', 'overrideCreate')->name('add');
            Route::post('/add', 'overrideStore')->name('add');
            Route::get('/edit/{id}', 'overrideEdit')->name('edit');
            Route::post('/edit/{id}', 'overrideUpdate')->name('edit');
            Route::get('/delete/{id}', 'overrideDestroy')->name('delete');
        });
    });

    /* Routes related to the Query system. */
    Route::prefix('queries')->name('queries::')->middleware(['auth', 'permission:board'])->controller(QueryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/activity_overview', 'activityOverview')->name('activity_overview');
        Route::get('/membership_totals', 'membershipTotals')->name('membership_totals');
    });

    /* Routes related to the Minisites */
    Route::prefix('minisites')->name('minisites::')->group(function () {
        Route::prefix('isalfredthere')->name('isalfredthere::')->controller(IsAlfredThereController::class)->group(function () {
            Route::get('/', 'showshowMiniSite')->name('index');
            Route::get('/admin', 'getAdminInterface')->name('admin')->middleware(['auth', 'permission:sysadmin|alfred']);
            Route::post('/admin', 'postAdminInterface')->name('admin')->middleware(['auth', 'permission:sysadmin|alfred']);
        });
    });
});
