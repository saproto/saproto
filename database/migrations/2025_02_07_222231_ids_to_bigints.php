<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        self::dropForeign();

        Schema::table('dmx_channels', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('rfid', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('announcements', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('emails_lists', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('addresses', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('newsitems', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('activities_users', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('permissions', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('user_welcome', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('committees_users', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('emails_events', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('alias', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('events', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('emails', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('photo_likes', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('dmx_overrides', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('dinnerforms', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('hashmap', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('joboffers', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('passwordstore', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('product_categories', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('emails_files', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('accounts', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('achievement', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('leaderboards', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('short_url', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('photo_albums', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('leaderboards_entries', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('withdrawals', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('mollie_transactions', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('members', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('narrowcasting', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('achievements_users', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('bankaccounts', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('photos', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('menuitems', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('ticket_purchases', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('videos', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('users_mailinglists', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('dmx_fixtures', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('users', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('activities', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('mailinglists', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('roles', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('orderlines', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('pages_files', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('event_categories', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('files', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('playedvideos', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('committees', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('companies', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('committees_activities', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('qrauth_requests', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('pages', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('headerimages', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('withdrawals_failed', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('failed_jobs', function ($table) {
            $table->bigIncrements('id')->change();
        });
        Schema::table('tickets', function ($table) {
            $table->bigIncrements('id')->change();
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
            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }
};
