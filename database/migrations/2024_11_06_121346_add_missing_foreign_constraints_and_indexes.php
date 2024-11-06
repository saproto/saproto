<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // todo: check all onDeletes, make a migration to all bigints
        Schema::table('achievements_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('achievement_id')->unsigned()->index()->change();
            $table->foreign('achievement_id')->references('id')->on('achievement')->onDelete('cascade');
        });

        Schema::table('activities_users', function (Blueprint $table) {
            $table->integer('committees_activities_id')->unsigned()->index()->change();
            $table->foreign('committees_activities_id')->references('id')->on('committees')->onDelete('cascade');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('alias', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


        Schema::table('bankaccounts', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('codex_codex_song', function (Blueprint $table) {
            $table->bigInteger('codex')->unsigned()->index()->change();
            $table->foreign('codex')->references('id')->on('codex_codices')->onDelete('cascade');

            $table->bigInteger('song')->unsigned()->index()->change();
            $table->foreign('song')->references('id')->on('codex_songs')->onDelete('cascade');
        });

        Schema::table('codex_codex_text', function (Blueprint $table) {
            $table->bigInteger('codex')->unsigned()->index()->change();
            $table->foreign('codex')->references('id')->on('codex_codices')->onDelete('cascade');

            $table->bigInteger('text_id')->unsigned()->index()->change();
            $table->foreign('text_id')->references('id')->on('codex_texts')->onDelete('cascade');
        });

        Schema::table('codex_texts', function (Blueprint $table) {
            $table->bigInteger('type_id')->unsigned()->index()->change();
            $table->foreign('type_id')->references('id')->on('codex_text_types')->onDelete('cascade');
        });

        Schema::table('committees_activities', function (Blueprint $table) {
            $table->integer('activity_id')->unsigned()->index()->change();
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');

            $table->integer('committee_id')->unsigned()->index()->change();
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->integer('image_id')->unsigned()->index()->change();
            $table->foreign('image_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::table('committees_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('committee_id')->unsigned()->index()->change();
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');
        });

        Schema::table('dinnerforms', function (Blueprint $table) {
            $table->integer('event_id')->unsigned()->index()->change();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            $table->integer('ordered_by_user_id')->unsigned()->index()->change();
            $table->foreign('ordered_by_user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('dinnerform_orderline', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('dinnerform_id')->unsigned()->index()->change();
            $table->foreign('dinnerform_id')->references('id')->on('dinnerforms')->onDelete('cascade');
        });

        Schema::table('emails_events', function (Blueprint $table) {
            $table->integer('email_id')->unsigned()->index()->change();
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');

            $table->integer('event_id')->unsigned()->index()->change();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });

        Schema::table('emails_files', function (Blueprint $table) {
            $table->integer('email_id')->unsigned()->index()->change();
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');

            $table->integer('file_id')->unsigned()->index()->change();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::table('emails_lists', function (Blueprint $table) {
            $table->integer('email_id')->unsigned()->index()->change();
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');

            $table->integer('list_id')->unsigned()->index()->change();
            $table->foreign('list_id')->references('id')->on('mailinglists')->onDelete('cascade');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->index()->change();
            $table->foreign('category_id')->references('id')->on('event_categories')->onDelete('cascade');

            $table->integer('image_id')->unsigned()->index()->change();
            $table->foreign('image_id')->references('id')->on('files')->onDelete('cascade');

            $table->integer('committee_id')->unsigned()->index()->change();
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');
        });

        Schema::table('event_newsitem', function (Blueprint $table) {

            $table->integer('event_id')->unsigned()->index()->change();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            $table->integer('newsitem_id')->unsigned()->index()->change();
            $table->foreign('newsitem_id')->references('id')->on('newsitems')->onDelete('cascade');
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('feedback_category_id')->unsigned()->index()->change();
            $table->foreign('feedback_category_id')->references('id')->on('feedback_categories')->onDelete('cascade');
        });

        Schema::table('feedback_categories', function (Blueprint $table) {
            $table->integer('reviewer_id')->unsigned()->index()->change();
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('feedback_votes', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('feedback_id')->unsigned()->index()->change();
            $table->foreign('feedback_id')->references('id')->on('feedback')->onDelete('cascade');
        });

        Schema::table('headerimages', function (Blueprint $table) {
            $table->integer('image_id')->unsigned()->index()->change();
            $table->foreign('image_id')->references('id')->on('files')->onDelete('cascade');

            $table->integer('credit_id')->unsigned()->index()->change();
            $table->foreign('credit_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('joboffers', function (Blueprint $table) {
            $table->integer('company_id')->unsigned()->index()->change();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::table('leaderboards', function (Blueprint $table) {
            $table->integer('committee_id')->unsigned()->index()->change();
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');
        });

        Schema::table('leaderboards_entries', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('leaderboard_id')->unsigned()->index()->change();
            $table->foreign('leaderboard_id')->references('id')->on('leaderboards')->onDelete('cascade');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('membership_form_id')->unsigned()->index()->change();
            $table->foreign('membership_form_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::table('menuitems', function (Blueprint $table) {
            $table->integer('page_id')->unsigned()->index()->change();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

            $table->integer('parent')->unsigned()->index()->change();
            $table->foreign('parent')->references('id')->on('menuitems')->onDelete('cascade');
        });

        Schema::table('mollie_transactions', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('narrowcasting', function (Blueprint $table) {
            $table->integer('image_id')->unsigned()->index()->change();
            $table->foreign('image_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::table('newsitems', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('featured_image_id')->unsigned()->index()->change();
            $table->foreign('featured_image_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('orderlines', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('cashier_id')->unsigned()->index()->change();
            $table->foreign('cashier_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->index()->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->integer('payed_with_mollie')->unsigned()->index()->change();
            $table->foreign('payed_with_mollie')->references('id')->on('mollie_transactions')->onDelete('cascade');

            $table->integer('payed_with_withdrawal')->unsigned()->index()->change();
            $table->foreign('payed_with_withdrawal')->references('id')->on('withdrawals')->onDelete('cascade');
        });


        Schema::table('pages', function (Blueprint $table) {
            $table->integer('featured_image_id')->unsigned()->index()->change();
            $table->foreign('featured_image_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::table('passwordstore', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned()->index()->change();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->integer('file_id')->unsigned()->index()->change();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');

            $table->integer('album_id')->unsigned()->index()->change();
            $table->foreign('album_id')->references('id')->on('photo_albums')->onDelete('cascade');
        });

        Schema::table('photo_albums', function (Blueprint $table) {
            $table->integer('thumb_id')->unsigned()->index()->change();
            $table->foreign('thumb_id')->references('id')->on('photos')->onDelete('cascade');

            $table->integer('event_id')->unsigned()->index()->change();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });

        Schema::table('photo_likes', function (Blueprint $table) {
            $table->integer('photo_id')->unsigned()->index()->change();
            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('playedvideos', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('account_id')->unsigned()->index()->change();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->integer('image_id')->unsigned()->index()->change();
            $table->foreign('image_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::table('products_categories', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->index()->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->integer('category_id')->unsigned()->index()->change();
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
        });

        Schema::table('product_wallstreet_drink', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->index()->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->bigInteger('wallstreet_drink_id')->unsigned()->index()->change();
            $table->foreign('wallstreet_drink_id')->references('id')->on('wallstreet_drink')->onDelete('cascade');
        });

        Schema::table('qrauth_requests', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('rfid', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('soundboard_sounds', function (Blueprint $table) {
            $table->integer('file_id')->unsigned()->index()->change();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::table('stock_mutations', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->index()->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('tempadmins', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('event_id')->unsigned()->index()->change();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->index()->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('ticket_purchases', function (Blueprint $table) {
            $table->integer('ticket_id')->unsigned()->index()->change();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');

            $table->integer('orderline_id')->unsigned()->index()->change();
            $table->foreign('orderline_id')->references('id')->on('orderlines')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('tokens', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('image_id')->unsigned()->index()->change();
            $table->foreign('image_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::table('users_mailinglists', function (Blueprint $table) {
            $table->integer('list_id')->unsigned()->index()->change();
            $table->foreign('list_id')->references('id')->on('emails_lists')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('user_welcome', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('ut_accounts', function (Blueprint $table) {
            $table->integer('member_id')->unsigned()->index()->change();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });

        Schema::table('wallstreet_drink_event', function (Blueprint $table) {
            $table->bigInteger('wallstreet_drink_id')->unsigned()->index()->change();
            $table->foreign('wallstreet_drink_id')->references('id')->on('wallstreet_drink')->onDelete('cascade');

            $table->bigInteger('wallstreet_drink_events_id')->unsigned()->index()->change();
            $table->foreign('wallstreet_drink_events_id')->references('id')->on('wallstreet_drink_events')->onDelete('cascade');
        });

        Schema::table('wallstreet_drink_events', function (Blueprint $table) {
            $table->integer('image_id')->unsigned()->index()->change();
            $table->foreign('image_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::table('wallstreet_drink_event_product', function (Blueprint $table) {
            $table->bigInteger('wallstreet_drink_event_id')->unsigned()->index()->change();
            $table->foreign('wallstreet_drink_event_id')->references('id')->on('wallstreet_drink_events')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->index()->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('wallstreet_drink_prices', function (Blueprint $table) {
            $table->bigInteger('wallstreet_drink_id')->unsigned()->index()->change();
            $table->foreign('wallstreet_drink_id')->references('id')->on('wallstreet_drink')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->index()->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('withdrawals_failed', function (Blueprint $table) {
            $table->integer('withdrawal_id')->unsigned()->index()->change();
            $table->foreign('withdrawal_id')->references('id')->on('withdrawals')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('correction_orderline_id')->unsigned()->index()->change();
            $table->foreign('correction_orderline_id')->references('id')->on('orderlines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //reverse the up function
        Schema::table('achievements_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['achievement_id']);
            $table->dropIndex(['achievement_id']);
        });

        Schema::table('activities_users', function (Blueprint $table) {
            $table->dropForeign(['committees_activities_id']);
            $table->dropIndex(['committees_activities_id']);
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('alias', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('bankaccounts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('codex_codex_song', function (Blueprint $table) {
            $table->dropForeign(['codex']);
            $table->dropIndex(['codex']);

            $table->dropForeign(['song']);
            $table->dropIndex(['song']);
        });

        Schema::table('codex_codex_text', function (Blueprint $table) {
            $table->dropForeign(['codex']);
            $table->dropIndex(['codex']);

            $table->dropForeign(['text_id']);
            $table->dropIndex(['text_id']);
        });

        Schema::table('codex_texts', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropIndex(['type_id']);
        });

        Schema::table('committees_activities', function (Blueprint $table) {
            $table->dropForeign(['activity_id']);
            $table->dropIndex(['activity_id']);

            $table->dropForeign(['committee_id']);
            $table->dropIndex(['committee_id']);
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
            $table->dropIndex(['image_id']);
        });

        Schema::table('committees_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['committee_id']);
            $table->dropIndex(['committee_id']);
        });

        Schema::table('dinnerforms', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropIndex(['event_id']);

            $table->dropForeign(['ordered_by_user_id']);
            $table->dropIndex(['ordered_by_user_id']);
        });

        Schema::table('dinnerform_orderline', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['dinnerform_id']);
            $table->dropIndex(['dinnerform_id']);
        });

        Schema::table('emails_events', function (Blueprint $table) {
            $table->dropForeign(['email_id']);
            $table->dropIndex(['email_id']);

            $table->dropForeign(['event_id']);
            $table->dropIndex(['event_id']);
        });

        Schema::table('emails_files', function (Blueprint $table) {
            $table->dropForeign(['email_id']);
            $table->dropIndex(['email_id']);

            $table->dropForeign(['file_id']);
            $table->dropIndex(['file_id']);
        });

        Schema::table('emails_lists', function (Blueprint $table) {
            $table->dropForeign(['email_id']);
            $table->dropIndex(['email_id']);

            $table->dropForeign(['list_id']);
            $table->dropIndex(['list_id']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropIndex(['category_id']);

            $table->dropForeign(['image_id']);
            $table->dropIndex(['image_id']);

            $table->dropForeign(['committee_id']);
            $table->dropIndex(['committee_id']);
        });

        Schema::table('event_newsitem', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropIndex(['event_id']);

            $table->dropForeign(['newsitem_id']);
            $table->dropIndex(['newsitem_id']);
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['feedback_category_id']);
            $table->dropIndex(['feedback_category_id']);
        });

        Schema::table('feedback_categories', function (Blueprint $table) {
            $table->dropForeign(['reviewer_id']);
            $table->dropIndex(['reviewer_id']);
        });

        Schema::table('feedback_votes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['feedback_id']);
            $table->dropIndex(['feedback_id']);
        });

        Schema::table('headerimages', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
            $table->dropIndex(['image_id']);

            $table->dropForeign(['credit_id']);
            $table->dropIndex(['credit_id']);
        });

        Schema::table('joboffers', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropIndex(['company_id']);
        });

        Schema::table('leaderboards', function (Blueprint $table) {
            $table->dropForeign(['committee_id']);
            $table->dropIndex(['committee_id']);
        });

        Schema::table('leaderboards_entries', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['leaderboard_id']);
            $table->dropIndex(['leaderboard_id']);
        });

        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['membership_form_id']);
            $table->dropIndex(['membership_form_id']);
        });

        Schema::table('menuitems', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
            $table->dropIndex(['page_id']);

            $table->dropForeign(['parent']);
            $table->dropIndex(['parent']);
        });

        Schema::table('mollie_transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('narrowcasting', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
            $table->dropIndex(['image_id']);
        });

        Schema::table('newsitems', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['featured_image_id']);
            $table->dropIndex(['featured_image_id']);
        });

        Schema::table('orderlines', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['cashier_id']);
            $table->dropIndex(['cashier_id']);

            $table->dropForeign(['product_id']);
            $table->dropIndex(['product_id']);

            $table->dropForeign(['payed_with_mollie']);
            $table->dropIndex(['payed_with_mollie']);

            $table->dropForeign(['payed_with_withdrawal']);
            $table->dropIndex(['payed_with_withdrawal']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['featured_image_id']);
            $table->dropIndex(['featured_image_id']);
        });

        Schema::table('passwordstore', function (Blueprint $table) {
            $table->dropForeign(['permission_id']);
            $table->dropIndex(['permission_id']);
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
            $table->dropIndex(['file_id']);

            $table->dropForeign(['album_id']);
            $table->dropIndex(['album_id']);
        });

        Schema::table('photo_albums', function (Blueprint $table) {
            $table->dropForeign(['thumb_id']);
            $table->dropIndex(['thumb_id']);

            $table->dropForeign(['event_id']);
            $table->dropIndex(['event_id']);
        });

        Schema::table('photo_likes', function (Blueprint $table) {
            $table->dropForeign(['photo_id']);
            $table->dropIndex(['photo_id']);

            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('playedvideos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropIndex(['account_id']);

            $table->dropForeign(['image_id']);
            $table->dropIndex(['image_id']);
        });

        Schema::table('products_categories', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropIndex(['product_id']);

            $table->dropForeign(['category_id']);
            $table->dropIndex(['category_id']);
        });

        Schema::table('product_wallstreet_drink', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropIndex(['product_id']);

            $table->dropForeign(['wallstreet_drink_id']);
            $table->dropIndex(['wallstreet_drink_id']);
        });

        Schema::table('qrauth_requests', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('rfid', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('soundboard_sounds', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
            $table->dropIndex(['file_id']);
        });

        Schema::table('stock_mutations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['product_id']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('tempadmins', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropIndex(['event_id']);

            $table->dropForeign(['product_id']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('ticket_purchases', function (Blueprint $table) {
            $table->dropForeign(['ticket_id']);
            $table->dropIndex(['ticket_id']);

            $table->dropForeign(['orderline_id']);
            $table->dropIndex(['orderline_id']);

            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('tokens', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
            $table->dropIndex(['image_id']);
        });

        Schema::table('users_mailinglists', function (Blueprint $table) {
            $table->dropForeign(['list_id']);
            $table->dropIndex(['list_id']);

            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('user_welcome', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('ut_accounts', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            $table->dropIndex(['member_id']);
        });

        Schema::table('wallstreet_drink_event', function (Blueprint $table) {
            $table->dropForeign(['wallstreet_drink_id']);
            $table->dropIndex(['wallstreet_drink_id']);

            $table->dropForeign(['wallstreet_drink_events_id']);
            $table->dropIndex(['wallstreet_drink_events_id']);
        });

        Schema::table('wallstreet_drink_events', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
            $table->dropIndex(['image_id']);
        });

        Schema::table('wallstreet_drink_event_product', function (Blueprint $table) {
            $table->dropForeign(['wallstreet_drink_event_id']);
            $table->dropIndex(['wallstreet_drink_event_id']);

            $table->dropForeign(['product_id']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('wallstreet_drink_prices', function (Blueprint $table) {
            $table->dropForeign(['wallstreet_drink_id']);
            $table->dropIndex(['wallstreet_drink_id']);

            $table->dropForeign(['product_id']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('withdrawals_failed', function (Blueprint $table) {
            $table->dropForeign(['withdrawal_id']);
            $table->dropIndex(['withdrawal_id']);

            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['correction_orderline_id']);
            $table->dropIndex(['correction_orderline_id']);
        });
    }
};
