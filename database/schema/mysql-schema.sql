/*M!999999\- enable the sandbox mode */ 
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `account_number` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `accounts_account_number_index` (`account_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `achievement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `achievement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `fa_icon` mediumtext DEFAULT NULL,
  `tier` varchar(255) NOT NULL,
  `has_page` tinyint(1) NOT NULL,
  `page_name` varchar(255) DEFAULT NULL,
  `page_content` mediumtext DEFAULT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `achievement_page_name_unique` (`page_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `achievements_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `achievements_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `achievement_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `alerted` tinyint(1) NOT NULL DEFAULT 0,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `achievements_users_user_id_index` (`user_id`),
  KEY `achievements_users_achievement_id_index` (`achievement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `no_show_fee` double(8,2) NOT NULL DEFAULT 0.00,
  `participants` int(11) NOT NULL DEFAULT -1,
  `hide_participants` tinyint(1) NOT NULL DEFAULT 0,
  `attendees` int(11) DEFAULT NULL,
  `registration_start` int(11) NOT NULL,
  `registration_end` int(11) NOT NULL,
  `deregistration_end` int(11) NOT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT 0,
  `closed_account` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment` varchar(255) DEFAULT NULL,
  `redirect_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_event_id_index` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `activities_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `activities_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `is_present` tinyint(1) NOT NULL DEFAULT 0,
  `committees_activities_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `backup` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_users_user_id_index` (`user_id`),
  KEY `activities_users_activity_id_index` (`activity_id`),
  KEY `activities_users_committees_activities_id_index` (`committees_activities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `street` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `alias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `alias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `alias_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `announcements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `display_from` datetime NOT NULL,
  `display_till` datetime NOT NULL,
  `show_guests` tinyint(1) NOT NULL DEFAULT 0,
  `show_users` tinyint(1) NOT NULL DEFAULT 0,
  `show_members` tinyint(1) NOT NULL DEFAULT 1,
  `show_only_homepage` tinyint(1) NOT NULL DEFAULT 1,
  `show_only_new` tinyint(1) NOT NULL DEFAULT 0,
  `show_only_firstyear` tinyint(1) NOT NULL DEFAULT 0,
  `show_only_active` tinyint(1) NOT NULL DEFAULT 0,
  `show_as_popup` tinyint(1) NOT NULL DEFAULT 0,
  `show_style` tinyint(4) NOT NULL DEFAULT 0,
  `is_dismissable` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bankaccounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `bankaccounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `iban` varchar(255) NOT NULL,
  `bic` varchar(255) NOT NULL,
  `machtigingid` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `bankaccounts_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `codex_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `codex_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `codex_codex_song`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `codex_codex_song` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codex` bigint(20) unsigned NOT NULL,
  `song` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `codex_codex_song_codex_index` (`codex`),
  KEY `codex_codex_song_song_index` (`song`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `codex_codex_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `codex_codex_text` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codex` bigint(20) unsigned NOT NULL,
  `text_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `codex_codex_text_codex_index` (`codex`),
  KEY `codex_codex_text_text_id_index` (`text_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `codex_codices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `codex_codices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `export` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `codex_songs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `codex_songs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `artist` varchar(255) DEFAULT NULL,
  `lyrics` longtext NOT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `codex_text_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `codex_text_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `codex_texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `codex_texts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `codex_texts_type_id_index` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `committees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `committees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `allow_anonymous_email` tinyint(1) NOT NULL DEFAULT 0,
  `is_society` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `committees_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `committees_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` bigint(20) unsigned NOT NULL,
  `committee_id` bigint(20) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `notification_sent` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `committees_activities_activity_id_index` (`activity_id`),
  KEY `committees_activities_committee_id_index` (`committee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `committees_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `committees_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `committee_id` bigint(20) unsigned NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `edition` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `committees_users_user_id_index` (`user_id`),
  KEY `committees_users_committee_id_index` (`committee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `excerpt` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `on_carreer_page` tinyint(1) NOT NULL,
  `in_logo_bar` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `on_membercard` tinyint(1) NOT NULL DEFAULT 0,
  `membercard_excerpt` mediumtext DEFAULT NULL,
  `membercard_long` mediumtext DEFAULT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dinnerform_orderline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dinnerform_orderline` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `dinnerform_id` bigint(20) unsigned NOT NULL,
  `description` mediumtext NOT NULL,
  `price` double(8,2) NOT NULL,
  `helper` tinyint(1) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dinnerform_orderline_user_id_index` (`user_id`),
  KEY `dinnerform_orderline_dinnerform_id_index` (`dinnerform_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dinnerforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dinnerforms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `restaurant` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `event_id` bigint(20) unsigned DEFAULT NULL,
  `helper_discount` double DEFAULT NULL,
  `regular_discount` double(8,2) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `visible_home_page` tinyint(1) NOT NULL DEFAULT 1,
  `ordered_by_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dinnerforms_event_id_index` (`event_id`),
  KEY `dinnerforms_ordered_by_user_id_index` (`ordered_by_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dmx_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dmx_channels` (
  `id` bigint(20) unsigned NOT NULL,
  `name` mediumtext NOT NULL,
  `special_function` char(10) NOT NULL DEFAULT 'none',
  KEY `dmx_channels_id_index` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dmx_fixtures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dmx_fixtures` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` mediumtext NOT NULL,
  `channel_start` int(11) NOT NULL,
  `channel_end` int(11) NOT NULL,
  `follow_timetable` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `dmx_overrides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dmx_overrides` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fixtures` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `emails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `sender_address` varchar(255) NOT NULL,
  `body` mediumtext NOT NULL,
  `to_user` tinyint(1) NOT NULL DEFAULT 0,
  `to_member` tinyint(1) NOT NULL DEFAULT 0,
  `to_pending` tinyint(1) NOT NULL DEFAULT 0,
  `to_list` tinyint(1) NOT NULL DEFAULT 0,
  `to_event` tinyint(1) NOT NULL DEFAULT 0,
  `to_backup` tinyint(1) NOT NULL DEFAULT 0,
  `to_active` tinyint(1) NOT NULL DEFAULT 0,
  `sent_to` int(11) DEFAULT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT 0,
  `ready` tinyint(1) NOT NULL DEFAULT 0,
  `time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `emails_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `emails_events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emails_events_email_id_index` (`email_id`),
  KEY `emails_events_event_id_index` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `emails_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `emails_files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email_id` bigint(20) unsigned NOT NULL,
  `file_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `emails_files_email_id_index` (`email_id`),
  KEY `emails_files_file_id_index` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `emails_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `emails_lists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email_id` bigint(20) unsigned NOT NULL,
  `list_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emails_lists_email_id_index` (`email_id`),
  KEY `emails_lists_list_id_index` (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `event_newsitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_newsitem` (
  `newsitem_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  KEY `event_newsitem_event_id_index` (`event_id`),
  KEY `event_newsitem_newsitem_id_index` (`newsitem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `is_external` tinyint(1) NOT NULL DEFAULT 0,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `publication` int(11) DEFAULT NULL,
  `unique_users_count` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_sequence` int(11) NOT NULL DEFAULT 0,
  `location` varchar(255) NOT NULL,
  `maps_location` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `involves_food` tinyint(1) NOT NULL DEFAULT 0,
  `secret` tinyint(1) NOT NULL DEFAULT 0,
  `force_calendar_sync` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `committee_id` bigint(20) unsigned DEFAULT NULL,
  `summary` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `events_start_index` (`start`),
  KEY `events_end_index` (`end`),
  KEY `events_category_id_index` (`category_id`),
  KEY `events_committee_id_index` (`committee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) DEFAULT NULL,
  `connection` mediumtext NOT NULL,
  `queue` mediumtext NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `feedback_category_id` bigint(20) NOT NULL DEFAULT 1,
  `feedback` mediumtext NOT NULL,
  `reviewed` tinyint(1) NOT NULL DEFAULT 0,
  `accepted` tinyint(1) DEFAULT NULL,
  `reply` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `feedback_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `review` tinyint(1) NOT NULL,
  `reviewer_id` bigint(20) unsigned DEFAULT NULL,
  `show_publisher` tinyint(1) NOT NULL DEFAULT 0,
  `can_reply` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_categories_reviewer_id_index` (`reviewer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `feedback_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback_votes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `feedback_id` bigint(20) unsigned NOT NULL,
  `vote` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_votes_user_id_index` (`user_id`),
  KEY `feedback_votes_feedback_id_index` (`feedback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `mime` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `hashmap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hashmap` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `subkey` varchar(255) DEFAULT NULL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `headerimages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `headerimages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `credit_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `headerimages_credit_id_index` (`credit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `joboffers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `joboffers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) unsigned NOT NULL,
  `title` mediumtext NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `redirect_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `joboffers_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `leaderboards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `leaderboards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `committee_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `points_name` varchar(255) DEFAULT 'points',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leaderboards_committee_id_index` (`committee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `leaderboards_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `leaderboards_entries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `leaderboard_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leaderboards_entries_leaderboard_id_index` (`leaderboard_id`),
  KEY `leaderboards_entries_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `mailinglists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mailinglists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `is_member_only` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL,
  `conversions_disk` varchar(255) DEFAULT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `proto_username` varchar(255) DEFAULT NULL,
  `membership_form_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_primary_at_another_association` tinyint(1) NOT NULL DEFAULT 0,
  `until` bigint(20) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `card_printed_on` date DEFAULT NULL,
  `omnomcom_sound_id` bigint(20) unsigned DEFAULT NULL,
  `membership_type` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `members_user_id_index` (`user_id`),
  KEY `members_omnomcom_sound_id_index` (`omnomcom_sound_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menuitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menuitems` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent` bigint(20) unsigned DEFAULT NULL,
  `menuname` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `page_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order` int(11) NOT NULL,
  `is_member_only` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menuitems_parent_index` (`parent`),
  KEY `menuitems_page_id_index` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  KEY `model_has_permissions_permission_id_index` (`permission_id`),
  KEY `model_has_permissions_model_id_index` (`model_id`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  KEY `model_has_roles_role_id_index` (`role_id`),
  KEY `model_has_roles_model_id_index` (`model_id`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `mollie_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mollie_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `mollie_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `narrowcasting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `narrowcasting` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `campaign_start` int(11) NOT NULL,
  `campaign_end` int(11) NOT NULL,
  `slide_duration` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `youtube_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `newsitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsitems` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `featured_image_id` bigint(20) unsigned DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_weekly` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `newsitems_user_id_index` (`user_id`),
  KEY `newsitems_featured_image_id_index` (`featured_image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` mediumtext DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`),
  KEY `oauth_access_tokens_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` mediumtext DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` mediumtext NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orderlines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `orderlines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `cashier_id` bigint(20) unsigned DEFAULT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `original_unit_price` double(8,2) NOT NULL,
  `units` int(11) NOT NULL,
  `total_price` double(8,2) NOT NULL,
  `authenticated_by` mediumtext NOT NULL,
  `payed_with_cash` datetime DEFAULT NULL,
  `payed_with_bank_card` datetime DEFAULT NULL,
  `payed_with_mollie` int(11) DEFAULT NULL,
  `payed_with_withdrawal` int(11) DEFAULT NULL,
  `payed_with_loss` tinyint(1) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `orderlines_user_id_index` (`user_id`),
  KEY `orderlines_created_at_index` (`created_at`),
  KEY `orderlines_cashier_id_index` (`cashier_id`),
  KEY `orderlines_product_id_index` (`product_id`),
  KEY `orderlines_payed_with_mollie_index` (`payed_with_mollie`),
  KEY `orderlines_payed_with_withdrawal_index` (`payed_with_withdrawal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_member_only` tinyint(1) NOT NULL DEFAULT 0,
  `show_attachments` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `valid_to` int(11) NOT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `passwordstore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `passwordstore` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` bigint(20) unsigned NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `username` mediumtext DEFAULT NULL,
  `password` mediumtext DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `note` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `passwordstore_permission_id_index` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_role` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `photo_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `photo_albums` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` char(255) NOT NULL,
  `date_create` int(11) NOT NULL,
  `date_taken` int(11) NOT NULL,
  `thumb_id` bigint(20) unsigned DEFAULT NULL,
  `event_id` bigint(20) unsigned DEFAULT NULL,
  `private` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `photo_albums_thumb_id_index` (`thumb_id`),
  KEY `photo_albums_event_id_index` (`event_id`),
  KEY `photo_albums_published_private_date_taken_index` (`published`,`private`,`date_taken`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `photo_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `photo_likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photo_likes_photo_id_index` (`photo_id`),
  KEY `photo_likes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `album_id` bigint(20) unsigned NOT NULL,
  `date_taken` int(11) NOT NULL,
  `private` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photos_album_id_index` (`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `playedvideos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `playedvideos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `video_id` varchar(255) NOT NULL,
  `video_title` varchar(255) NOT NULL,
  `duration_played` double DEFAULT NULL COMMENT 'Duration played in seconds',
  `duration` double DEFAULT NULL COMMENT 'Duration of the video in seconds',
  `spotify_id` varchar(50) DEFAULT NULL,
  `spotify_name` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `playedvideos_user_id_index` (`user_id`),
  KEY `playedvideos_video_id_index` (`video_id`),
  KEY `playedvideos_created_at_video_id_index` (`created_at`,`video_id`),
  KEY `playedvideos_spotify_id_index` (`spotify_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `product_wallstreet_drink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_wallstreet_drink` (
  `wallstreet_drink_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(8,2) NOT NULL,
  `calories` int(11) NOT NULL DEFAULT 0,
  `barcode` int(11) DEFAULT NULL,
  `supplier_id` mediumtext DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `preferred_stock` int(11) NOT NULL DEFAULT 0,
  `max_stock` int(11) NOT NULL DEFAULT 0,
  `supplier_collo` int(11) NOT NULL DEFAULT 0,
  `is_visible` tinyint(1) NOT NULL DEFAULT 0,
  `is_alcoholic` tinyint(1) NOT NULL DEFAULT 0,
  `is_visible_when_no_stock` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `products_account_id_index` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `products_categories_product_id_index` (`product_id`),
  KEY `products_categories_category_id_index` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `qrauth_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `qrauth_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `auth_token` mediumtext NOT NULL,
  `qr_token` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qrauth_requests_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `rfid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rfid` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `card_id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `rfid_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_user` (
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  KEY `role_user_user_id_index` (`user_id`),
  KEY `role_user_role_id_index` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` mediumtext DEFAULT NULL,
  `payload` mediumtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`),
  KEY `sessions_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `short_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `short_url` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `clicks` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `short_url_url_unique` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `soundboard_sounds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `soundboard_sounds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` bigint(20) unsigned NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `name` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `soundboard_sounds_file_id_index` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `stickers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `stickers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `country_code` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `file_id` bigint(20) unsigned NOT NULL,
  `reporter_id` bigint(20) unsigned DEFAULT NULL,
  `report_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stickers_user_id_foreign` (`user_id`),
  KEY `stickers_file_id_foreign` (`file_id`),
  KEY `stickers_reporter_id_index` (`reporter_id`),
  CONSTRAINT `stickers_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`),
  CONSTRAINT `stickers_reporter_id_foreign` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`),
  CONSTRAINT `stickers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `stock_mutations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_mutations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `before` int(11) NOT NULL,
  `after` int(11) NOT NULL,
  `is_bulk` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `stock_mutations_user_id_index` (`user_id`),
  KEY `stock_mutations_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tempadmins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tempadmins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `tempadmins_created_by_index` (`created_by`),
  KEY `tempadmins_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ticket_purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_purchases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint(20) unsigned NOT NULL,
  `orderline_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `scanned` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_complete` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `ticket_purchases_ticket_id_index` (`ticket_id`),
  KEY `ticket_purchases_orderline_id_index` (`orderline_id`),
  KEY `ticket_purchases_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `members_only` tinyint(1) NOT NULL,
  `available_from` int(11) NOT NULL,
  `available_to` int(11) NOT NULL,
  `is_prepaid` tinyint(1) NOT NULL DEFAULT 0,
  `show_participants` tinyint(1) NOT NULL DEFAULT 0,
  `has_buy_limit` tinyint(1) NOT NULL DEFAULT 0,
  `buy_limit` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `tickets_event_id_index` (`event_id`),
  KEY `tickets_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_welcome`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_welcome` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `message` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_welcome_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `calling_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_seen_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `birthdate` date DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `diet` mediumtext DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone_visible` tinyint(1) NOT NULL DEFAULT 0,
  `address_visible` tinyint(1) NOT NULL DEFAULT 0,
  `receive_sms` tinyint(1) NOT NULL DEFAULT 0,
  `keep_protube_history` tinyint(1) NOT NULL DEFAULT 1,
  `pref_calendar_alarm` double DEFAULT NULL,
  `show_birthday` tinyint(1) NOT NULL DEFAULT 1,
  `show_achievements` tinyint(1) NOT NULL DEFAULT 1,
  `profile_in_almanac` tinyint(1) NOT NULL DEFAULT 1,
  `show_omnomcom_total` tinyint(1) NOT NULL DEFAULT 0,
  `show_omnomcom_calories` tinyint(1) NOT NULL DEFAULT 0,
  `keep_omnomcom_history` tinyint(1) NOT NULL DEFAULT 1,
  `disable_omnomcom` tinyint(1) NOT NULL DEFAULT 0,
  `theme` int(11) NOT NULL DEFAULT 0,
  `pref_calendar_relevant_only` tinyint(1) NOT NULL DEFAULT 0,
  `utwente_username` varchar(255) DEFAULT NULL,
  `edu_username` varchar(255) DEFAULT NULL,
  `utwente_department` mediumtext DEFAULT NULL,
  `did_study_create` tinyint(1) NOT NULL DEFAULT 0,
  `did_study_itech` tinyint(1) NOT NULL DEFAULT 0,
  `tfa_totp_key` varchar(255) DEFAULT NULL,
  `signed_nda` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `personal_key` varchar(64) DEFAULT NULL,
  `discord_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_last_seen_at_index` (`last_seen_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users_mailinglists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_mailinglists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `list_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `users_mailinglists_list_id_index` (`list_id`),
  KEY `users_mailinglists_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ut_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ut_accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL,
  `number` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `givenname` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `found` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `event_id` bigint(20) unsigned DEFAULT NULL,
  `youtube_id` varchar(255) NOT NULL,
  `youtube_title` varchar(255) NOT NULL,
  `youtube_length` varchar(255) NOT NULL,
  `youtube_user_id` varchar(255) NOT NULL,
  `youtube_user_name` varchar(255) NOT NULL,
  `youtube_thumb_url` varchar(255) NOT NULL,
  `video_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `videos_event_id_index` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wallstreet_drink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallstreet_drink` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `end_time` bigint(20) NOT NULL,
  `start_time` bigint(20) NOT NULL,
  `price_increase` double(8,2) NOT NULL,
  `price_decrease` double(8,2) NOT NULL,
  `minimum_price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `random_events_chance` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wallstreet_drink_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallstreet_drink_event` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wallstreet_drink_id` bigint(20) unsigned NOT NULL,
  `wallstreet_drink_events_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wallstreet_drink_event_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallstreet_drink_event_product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wallstreet_drink_event_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallstreet_drink_event_product_wallstreet_drink_event_id_index` (`wallstreet_drink_event_id`),
  KEY `wallstreet_drink_event_product_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wallstreet_drink_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallstreet_drink_events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `percentage` int(11) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wallstreet_drink_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallstreet_drink_prices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wallstreet_drink_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `price` double(8,2) NOT NULL,
  `diff` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `withdrawals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `withdrawals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `closed` tinyint(1) NOT NULL DEFAULT 0,
  `total_users_associated` int(11) NOT NULL DEFAULT 0,
  `total_orderlines_associated` int(11) NOT NULL DEFAULT 0,
  `sum_associated_orderlines` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `withdrawals_failed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `withdrawals_failed` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `withdrawal_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `correction_orderline_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `withdrawals_failed_withdrawal_id_index` (`withdrawal_id`),
  KEY `withdrawals_failed_user_id_index` (`user_id`),
  KEY `withdrawals_failed_correction_orderline_id_index` (`correction_orderline_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*M!999999\- enable the sandbox mode */ 
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_03_09_221221_initialmigration',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_03_09_233319_entrust_setup_tables',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_03_16_190241_activities',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_03_16_193518_committees',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_03_19_205050_alterevents',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_03_20_145717_makeactivityeventidnullable',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_03_20_153401_updateactivity',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_03_30_213121_droputwentes',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_04_10_155223_create_files_table',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_04_10_160233_add_image_to_committee',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_05_04_223511_add_narrowcasting_table',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_05_04_232550_create_quote_table',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_05_15_213137_update_study_users_table_time_as_int',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_05_15_232440_update_committee_membership_date_to_int',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_05_17_205004_add_study_type',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_05_25_192649_convert_events_activities_datetime_to_int',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_05_25_235837_user_profile_picture_column',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_05_26_000653_user_proto_username',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_01_164325_update_quote_type_to_text',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_08_202555_edit_activity_table',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_09_114034_move_secret_to_event',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_13_194056_new_migration_program_changes',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_15_201612_add_image_to_event',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_15_214834_update_image_with_hash',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_16_224512_two_factor_authentication_tables',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_17_233542_move_totp_to_user',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_17_233552_add_ubikey_to_user',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_21_212547_registration_migration',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_22_170307_introducing_softdelete',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_22_211743_default_membership_types',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_23_112958_omnomcom_migration',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_29_214555_create_pages_table',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_29_214732_create_menuitems_table',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_04_151755_add_is_member_only_to_pages',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_04_175731_add_softdeletes_to_pages',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_05_115709_allow_null_user_orderline',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_05_151741_make_page_slug_unique',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_05_164636_add_featured_image_id_to_pages',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_06_155157_make_linking_table_for_files_to_pages',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_06_182122_add_rfid_cards',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_06_210159_drop_categorie_display',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_07_131558_allow_null_menuitems_parent',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_07_131816_add_order_to_menuitems',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_07_171636_add_member_only_to_menuitems',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_13_204444_add_last_membercard_printed',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_15_124759_add_old_name_to_activity',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_07_17_145915_add_print_file',1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_08_10_152013_create_users_tokens_table',2);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_08_17_134114_add_company_profiles',3);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_08_20_182010_remove_proto_username',4);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_08_30_193936_create_alias_table',5);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_09_05_141650_add_tempadmin_table',6);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_09_04_185820_associate_helping_with_events',7);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_09_08_195023_create_playedvideos_table',8);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_09_09_170006_add_email_list_functionality',9);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_09_11_144751_make_emails_tables',9);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_09_11_201106_add_newsletter_summary_to_events',9);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_09_21_144940_create_pastries_table',10);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_08_185109_create_achievement_table',11);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_29_211636_update_achievement_img_id_nullable',12);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_09_15_213445_make_withdrawals_closable',13);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_09_22_011617_create__table',13);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_09_22_014934_create_failed_jobs_table',13);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_10_03_192127_create_user_welcome_table',14);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_10_03_200454_make_pages_studies_table',15);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_10_03_203327_update_users_table_privacy_name',16);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_10_03_214359_remove_biography',16);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_10_03_222908_remove_address_primary',16);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_10_10_205959_create_passwordentry_table',17);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_10_25_145226_add_wizard_boolean_to_users',18);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_10_25_165147_add_membercard_attributes_to_companies',19);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_10_25_174847_add_joboffers_table',19);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_10_25_220503_update_password_reset_table',19);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_10_27_145355_add_video_support_narrowcasting',20);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_11_18_104215_activity_participants_not_nullable',21);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_11_28_201203_updateAchievementTable',22);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_12_02_144039_rename_protomail_to_protousername',23);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_12_05_211332_add_sort_field_to_companies_table',24);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_12_05_215753_add_flickr_albums_and_items',25);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_12_07_124414_add_dates_to_flickr',26);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_12_30_200712_add_newsletter_field_to_events',27);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_01_09_195645_remove_obsolete_tool',28);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_01_09_212926_add_event_tickets_tables',29);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_02_06_183022_change_datatype_page_content',30);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_02_13_221519_add_mollie_table',31);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_02_21_184216_remove_printed_file_column',32);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_02_23_002809_remove_softdelete_bank',33);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_02_07_154009_create_newsitems_table',34);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_03_02_002316_remove_primary_member_column',35);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_03_09_231235_add_deposit_to_activities',36);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_03_13_193009_create_quotes_likes_table',37);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_03_16_132526_additional_flickr_data',38);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_03_22_211433_add_event_destination_to_email',39);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_03_27_200526_albumprivatable',40);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_04_03_174933_add_diet_to_user',41);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_04_03_213210_create_config_table',42);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_04_20_152043_add_external_column_events',43);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_05_15_152220_add_prepaid_option_to_tickets',44);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_05_15_155216_add_payment_url_to_mollie',44);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_06_12_223703_remove_wizard_column_from_users',45);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_06_19_212644_add_product_tier_to_category',46);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_06_26_213129_productdefaultrank',46);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_06_26_221506_achievementisprize',47);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_07_03_220332_flickr_add_private_flag',48);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_07_04_132604_emails_add_active_member_destination',49);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_07_04_205456_hashmap_store_larger_text',50);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_09_15_200945_remove_yubikey_column',51);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_09_22_134929_add_attachment_button_to_pages',52);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_09_29_131354_add_anonymous_email_to_committee',53);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_09_25_223718_remove_unique_page_slug_index',54);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_10_09_102828_add_api_key_to_user',55);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_10_09_201751_add_radio_station',56);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_10_09_223627_add_displays',57);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_10_16_102218_playedvideos_add_spotifyid',58);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_10_22_154136_update_sessions_for_laravel52',59);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_10_22_171848_update_jobs_for_laravel53',59);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_10_23_193905_sessions_in_cookies_only',60);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_10_23_220112_sessions_back_in_database',61);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_10_28_100412_add_institution_column_to_user_table',62);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_10_28_132818_add_protube_privacy_to_user',63);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_01_000001_create_oauth_auth_codes_table',64);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_01_000002_create_oauth_access_tokens_table',64);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_01_000003_create_oauth_refresh_tokens_table',64);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_01_000004_create_oauth_clients_table',64);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2016_06_01_000005_create_oauth_personal_access_clients_table',64);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_11_06_104406_add_present_table_to_activity_participation',65);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_11_06_220427_users_add_nda_field',66);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_10_30_215235_add_qrauth_requests_table',67);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_11_21_210700_add_soundboard_sounds_table',68);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_11_28_191955_create_dmx_manager',69);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_12_06_174219_extend_dmx_manager',70);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_12_19_180911_add_study_fields_to_user',71);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_01_09_205312_drop_nationality_gender_studyhistory',72);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_02_27_155857_move_settings_to_users_table',73);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_02_27_164436_add_force_sync_for_events',74);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_03_20_193426_add_helper_reminder_table',75);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2017_12_05_215829_create_photolikes_table',76);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_05_01_180557_add_birthday_optout',77);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_06_05_183351_add_email_event_pivot',78);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_06_05_213518_add_supplier_id_to_product',79);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_06_12_221653_add_closed_account_to_activities',80);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_06_26_204526_add_description_to_orderlines',81);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_06_26_212834_add_omnomcom_total_user_pref',82);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_06_28_152040_add_failed_withdrawal_table',83);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_07_03_183750_add_video_table',84);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_09_10_221132_add_user_has_studied_itech',85);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_09_17_145620_add_announcements_table',86);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_10_29_091537_fix_for_github_817_819_820',87);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_10_29_114355_add_header_images',87);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_11_27_224536_rename_is_prize_to_exclude_from_all_achievements',88);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_11_14_165117_add_calories_to_products',89);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2018_11_14_172300_add_omnomcom_show_calories_to_users',89);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_03_18_143533_add_use_dark_theme_to_users_table',90);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_04_02_212223_add_theme_to_users_table',91);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_04_11_164711_add_omnomcom_block_to_users_table',92);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_03_19_204609_add_notification_sent_to_committees_activities',93);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_06_04_202230_archive_achievements',94);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_06_04_210748_order_omnomcom',94);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_07_23_195454_add_pin_to_omnomcom',95);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_10_22_181949_add_featured_to_event',96);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_11_24_093900_add_short_url',97);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_12_17_214522_orderline_paid_audit',98);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_12_27_220910_create_new_photo_tables',99);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2019_11_29_103335_create_dinnerforms_table',100);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2020_02_11_203742_create_societies_column_for_committees',101);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2020_02_11_204426_create_good_ideas_table',102);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2020_02_11_204901_create_good_idea_votes_table',102);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2020_06_30_210405_add_profile_in_almanac_to_users',103);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2020_07_30_142212_add_membership_form_to_members_table',104);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2020_10_27_212616_add_redirect_url_to_joboffers',105);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2021_03_06_201232_add_url_to_achievement_table',106);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2020_12_15_210106_create_leaderboards_table',107);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2021_02_10_163004_change_user_theme_to_enum',108);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2021_04_26_203140_add_featured_to_leaderboards_table',109);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2021_04_25_205806_add_pet_membership_type',110);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2021_04_25_140954_change_membership_type',111);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2021_07_11_180444_create_event_categories_table',112);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2021_07_11_181335_add_category_to_events',112);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2021_10_03_170304_add_alerted_column_to_achievements_users_table',113);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2021_12_10_220655_add_is_pending_row_to_emails_table',114);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_03_21_161021_add_hide_participants_to_activity',115);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2021_06_06_183111_create_permission_tables',116);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_09_04_214929_add_events_update_sequency_field',117);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_07_18_010010_create_dinner_orderline_table',118);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_09_13_215305_drop_bank_is_first_column',119);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_09_25_214738_add_visibility_to_dinnerforms',120);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_10_03_160141_dinnerform_int_to_float',121);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_05_19_120628_add_to_backup_row_to_emails',122);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_10_20_153408_add_publish_time_to_events',123);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_10_24_152612_add_discount_to_dinnerforms',124);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_23_10_164620_add_uuid_to_failed_jobs',125);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_11_11_122455_add_provider_column_to_oauth_clients_table',126);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_11_13_161109_add_payed_with_loss_to_orderlines',127);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_01_06_212940_add_pkce_support_to_oauth_clients',128);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_11_30_175546_add_attendees_to_activities',129);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_01_20_211900_add_member_until_to_member',130);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_02_12_133147_add_custom_omnomcom_sound_to_members',131);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_01_31_000437_add_wallstreet_drink',132);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_04_23_231630_add_show_participants_to_ticket',133);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_05_30_101828_add_redirect_link_to_activities',134);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_05_09_212116_create_stock_mutations',135);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_06_25_223210_add_maps_location_to_events_table',136);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_05_08_143425_add_userid_to_dinnerform',137);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_08_28_160325_add_description_to_achievement_users',138);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2022_11_18_204950_add_feedback_functionality',139);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_08_16_231824_add_is_weekly_to_news',140);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_08_16_232939_many_to_many_between_events_and_newsitems',140);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_09_09_195628_add_codex_tool',141);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_10_05_114449_add_show_publisher_to_feedback_category',142);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_11_23_120900_add_is_active_to_committees',143);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_11_30_214933_drop_displays_table',144);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_11_30_215014_drop_radio_stations_table',144);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_12_07_173710_add_custom_wallstreet_events',145);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_01_25_223150_remove_committees_helper_reminders_table',146);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_02_04_215138_add_random_minutes_to_wallstreet_events',147);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_02_21_154834_add_buy_limit_to_tickets',148);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_02_16_093651_add_active_to_wallstreet_drink_events',149);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_03_12_115002_add_users_count_to_events',150);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2023_03_30_162439_add_discord_id_column_to_users',151);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_05_09_011413_alter_codices',152);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_08_31_214750_add_membership_type_to_members',153);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_09_01_230659_create_ut_accounts_table',153);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_09_04_015210_add_primary_to_members',153);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_10_19_175537_cleanup_membership_system',154);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_10_26_224952_add_total_and_sum_to_withdrawals',154);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_11_03_180047_add_indexes_to_orderlines',155);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_10_28_211723_migrate_utf8_to_utf8mb4',156);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_11_17_173707_cleanup_flickr_items',157);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2024_04_15_010517_add_delta_to_wallstreet_price',158);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_02_07_222231_ids_to_bigints',159);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_03_19_150803_create_stickers_table',160);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_04_01_154616_add_index_to_playedvideos_video_id',161);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_04_03_151909_add_reporting_to_stickers',162);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_05_16_172633_move_pref_calendar_alarm_to_int',163);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_06_21_185748_create_media_table',164);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_07_01_171217_drop_tokens_table',165);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_07_19_100444_add_barcode_to_products',166);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_07_21_230526_remove_image_id_from_events',167);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_07_25_105252_remove_file_id_from_photos',168);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_07_25_131956_remove_image_id_from_users',169);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_07_26_152555_change_album_thumb_id_to_nullable',170);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_08_09_181322_remove_use_dark_theme_from_users',171);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_08_26_192009_remove_image_id_from_products',172);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_04_161326_add_last_seen_at_to_users',173);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_05_135249_remove_image_id_from_committees',174);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_05_155553_remove_image_id_from_narrowcasting',175);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_05_162513_remove_image_id_from_wallstreet_drink_events',176);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_06_170441_remove_image_id_from_companies',177);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_06_181647_remove_soft_deletes_from_pages',178);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_08_161957_remove_image_id_from_headerimages',179);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_09_102812_add_extra_indexes_to_orderlines',180);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_10_004900_remove_pages_files',181);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_10_120553_remove_featured_image_from_pages',182);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_10_171228_add_created_at_index_to_playedvideos',183);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_12_123717_add_published_private_date_taken_index_to_photo_albums',184);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_12_131536_add_index_to_spotify_id_on_playedvideos',185);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_17_111109_add_duration_played_to_playedvideos',186);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2025_09_17_114212_add_duration_to_playedvideos',187);
