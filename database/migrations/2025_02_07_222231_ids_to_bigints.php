<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        self::dropForeign();

        Schema::table('rfid', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
        });
        Schema::table('announcements', function ($table) {
            $table->id()->change();
        });
        Schema::table('emails_lists', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('email_id')->index()->change();
            $table->unsignedBigInteger('list_id')->index()->change();
        });
        Schema::table('addresses', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
        });
        Schema::table('newsitems', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
            $table->unsignedBigInteger('featured_image_id')->nullable()->index()->change();
        });
        Schema::table('activities_users', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('activity_id')->change();
            $table->unsignedBigInteger('committees_activities_id')->nullable()->index()->change();
        });
        Schema::table('permissions', function ($table) {
            $table->id()->change();
        });
        Schema::table('user_welcome', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
        });
        Schema::table('committees_users', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
            $table->unsignedBigInteger('committee_id')->index()->change();
        });
        Schema::table('emails_events', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('email_id')->index()->change();
            $table->unsignedBigInteger('event_id')->index()->change();
        });
        Schema::table('alias', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->nullable()->index()->change();
        });
        Schema::table('events', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('category_id')->nullable()->index()->change();
            $table->unsignedBigInteger('committee_id')->nullable()->index()->change();
            $table->unsignedBigInteger('image_id')->nullable()->index()->change();
        });
        Schema::table('emails', function ($table) {
            $table->id()->change();
        });
        Schema::table('photo_likes', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('photo_id')->index()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
        });
        Schema::table('dmx_channels', function ($table) {
            $table->unsignedBigInteger('id')->index()->change();
        });
        Schema::table('dmx_overrides', function ($table) {
            $table->id()->change();
        });
        Schema::table('dinnerforms', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('event_id')->nullable()->index()->change();
            $table->unsignedBigInteger('ordered_by_user_id')->index()->change();
        });
        Schema::table('hashmap', function ($table) {
            $table->id()->change();
        });
        Schema::table('joboffers', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('company_id')->index()->change();
        });
        Schema::table('passwordstore', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('permission_id')->index()->change();
        });
        Schema::table('product_categories', function ($table) {
            $table->id()->change();
        });
        Schema::table('emails_files', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('email_id')->index()->change();
            $table->unsignedBigInteger('file_id')->index()->change();
        });
        Schema::table('accounts', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_number')->index()->change();
        });
        Schema::table('achievement', function ($table) {
            $table->id()->change();
        });
        Schema::table('leaderboards', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('committee_id')->index()->change();
        });
        Schema::table('short_url', function ($table) {
            $table->id()->change();
        });
        Schema::table('photo_albums', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('thumb_id')->index()->change();
            $table->unsignedBigInteger('event_id')->nullable()->index()->change();
        });
        Schema::table('leaderboards_entries', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('leaderboard_id')->index()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
        });
        Schema::table('withdrawals', function ($table) {
            $table->id()->change();
        });
        Schema::table('mollie_transactions', function ($table) {
            $table->id()->change();
        });
        Schema::table('members', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
            $table->unsignedBigInteger('omnomcom_sound_id')->nullable()->index()->change();
        });
        Schema::table('narrowcasting', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('image_id')->nullable()->index()->change();
        });
        Schema::table('achievements_users', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
            $table->unsignedBigInteger('achievement_id')->index()->change();
        });
        Schema::table('bankaccounts', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
        });
        Schema::table('photos', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('file_id')->index()->change();
            $table->unsignedBigInteger('album_id')->index()->change();
        });
        Schema::table('menuitems', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('parent')->nullable()->index()->change();
            $table->unsignedBigInteger('page_id')->nullable()->index()->change();
        });
        Schema::table('ticket_purchases', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('ticket_id')->index()->change();
            $table->unsignedBigInteger('orderline_id')->index()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
        });
        Schema::table('videos', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('event_id')->nullable()->index()->change();
        });
        Schema::table('users_mailinglists', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('list_id')->index()->change();
            $table->unsignedBigInteger('user_id')->charset(null)->collation(null)->index()->change();
        });
        Schema::table('dmx_fixtures', function ($table) {
            $table->id()->change();
        });
        Schema::table('users', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('image_id')->nullable()->index()->change();
        });
        Schema::table('activities', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('event_id')->nullable()->change();
            $table->unsignedBigInteger('closed_account')->nullable()->change();
        });
        Schema::table('mailinglists', function ($table) {
            $table->id()->change();
        });
        Schema::table('roles', function ($table) {
            $table->id()->change();
        });
        Schema::table('orderlines', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('cashier_id')->nullable()->index()->change();
            $table->unsignedBigInteger('product_id')->index()->change();
        });
        Schema::table('pages_files', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('page_id')->index()->change();
            $table->unsignedBigInteger('file_id')->index()->change();
        });
        Schema::table('event_categories', function ($table) {
            $table->id()->change();
        });
        Schema::table('files', function ($table) {
            $table->id()->change();
        });
        Schema::table('playedvideos', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->nullable()->index()->change();
        });
        Schema::table('committees', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('image_id')->nullable()->index()->change();
        });
        Schema::table('companies', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('image_id')->index()->change();
        });
        Schema::table('committees_activities', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('activity_id')->index()->change();
            $table->unsignedBigInteger('committee_id')->index()->change();
        });
        Schema::table('qrauth_requests', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
        });
        Schema::table('pages', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('featured_image_id')->nullable()->index()->change();
        });
        Schema::table('headerimages', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('credit_id')->nullable()->index()->change();
            $table->unsignedBigInteger('image_id')->index()->change();
        });
        Schema::table('withdrawals_failed', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('withdrawal_id')->index()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
            $table->unsignedBigInteger('correction_orderline_id')->index()->change();
        });
        Schema::table('failed_jobs', function ($table) {
            $table->id()->change();
        });
        Schema::table('soundboard_sounds', function ($table) {
            $table->id()->change();
        });
        Schema::table('tempadmins', function ($table) {
            $table->id()->change();
        });
        Schema::table('products_categories', function ($table) {
            $table->id()->change();
        });
        Schema::table('oauth_clients', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
        Schema::table('tickets', function ($table) {
            $table->id()->change();
            $table->unsignedBigInteger('event_id')->index()->change();
            $table->unsignedBigInteger('product_id')->index()->change();
        });

        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->index()->change();
            $table->unsignedBigInteger('model_id')->index()->change();
        });
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id')->index()->change();
            $table->unsignedBigInteger('model_id')->index()->change();
        });
        Schema::table('permission_role', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id')->index()->change();
            $table->unsignedBigInteger('role_id')->index()->change();
        });

        Schema::table('feedback_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('reviewer_id')->nullable()->index()->change();
        });
        Schema::table('event_newsitem', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->index()->change();
            $table->unsignedBigInteger('newsitem_id')->index()->change();
        });
        Schema::table('codex_codex_song', function (Blueprint $table) {
            $table->unsignedBigInteger('codex')->index()->change();
            $table->unsignedBigInteger('song')->index()->change();
        });
        Schema::table('feedback_votes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->change();
            $table->unsignedBigInteger('feedback_id')->index()->change();
        });
        Schema::table('wallstreet_drink_event_product', function (Blueprint $table) {
            $table->unsignedBigInteger('wallstreet_drink_event_id')->index()->change();
            $table->unsignedBigInteger('product_id')->index()->change();
        });
        Schema::table('role_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->change();
            $table->unsignedBigInteger('role_id')->index()->change();
        });
        Schema::table('codex_texts', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->index()->change();
        });
        Schema::table('dinnerform_orderline', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->change();
            $table->unsignedBigInteger('dinnerform_id')->index()->change();
        });
        Schema::table('wallstreet_drink_event', function (Blueprint $table) {
            $table->unsignedBigInteger('wallstreet_drink_id')->change();
            $table->unsignedBigInteger('wallstreet_drink_events_id')->change();
        });
        Schema::table('stock_mutations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->change();
            $table->unsignedBigInteger('product_id')->index()->change();
        });
        Schema::table('feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->change();
        });
        Schema::table('wallstreet_drink_events', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id')->nullable()->index()->change();
        });
        Schema::table('sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->index()->change();
        });
        Schema::table('codex_codex_text', function (Blueprint $table) {
            $table->unsignedBigInteger('codex')->index()->change();
            $table->unsignedBigInteger('text_id')->index()->change();
        });
        Schema::table('soundboard_sounds', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id')->index()->change();
        });
        Schema::table('tempadmins', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->index()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->index()->change();
            $table->unsignedBigInteger('image_id')->nullable()->index()->change();
        });
        Schema::table('tokens', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->index()->change();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('products_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->index()->change();
            $table->unsignedBigInteger('category_id')->index()->change();
        });
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('client_id')->index()->change();
        });
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('client_id')->index()->change();
        });
        Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('client_id')->change();
        });
        self::reinstateForeign();
    }

    public static function dropForeign(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->dropForeign(['permission_id']);
        });

        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropForeign(['permission_id']);
            $table->dropForeign(['role_id']);
        });

        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });

        Schema::table('pages_files', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
            $table->dropForeign(['page_id']);
        });
    }

    public static function reinstateForeign(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });

        Schema::table('permission_role', function (Blueprint $table) {
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::table('pages_files', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }
};
