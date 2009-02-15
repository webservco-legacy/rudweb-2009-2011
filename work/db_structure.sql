-- test
-- DATABASE STRUCTURE
-- 16:35 2009-02-09

-- ////////////////////////////////////////////////////////////////////////////////
-- SETTINGS
-- ////////////////////////////////////////////////////////////////////////////////

-- --------------------------------------------------------------------------------
-- USERS
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS rudweb_set_usr;
CREATE TABLE rudweb_set_usr (
  -- IDENTIFICATION
  usr_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  usr_name VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL,
  usr_mail VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL,
  usr_pass VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL,
  -- INFORMATION
  usr_fname VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  -- usr_middle_name VARCHAR(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  usr_lname VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  -- usr_phone VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  -- usr_address VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  -- usr_country VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  -- SETTINGS
  usr_skin VARCHAR(15) COLLATE utf8_unicode_ci NOT NULL,
  usr_lang CHAR(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  -- ADMIN
  usr_lvl TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  usr_group MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  usr_status TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  usr_deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  usr_notes VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  usr_created_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  usr_created_date DATE NOT NULL DEFAULT '0000-00-00',
  usr_created_time TIME NOT NULL DEFAULT '00:00:00',
  -- usr_deleted_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  -- usr_deleted_date DATE NOT NULL DEFAULT '0000-00-00',
  -- usr_deleted_time TIME NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (usr_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------------------------------
-- LOGIN HISTORY
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS rudweb_var_logins;
CREATE TABLE rudweb_var_logins (
  login_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  usr_id MEDIUMINT(5) UNSIGNED NOT NULL,
  login_date DATE NOT NULL DEFAULT '0000-00-00',
  login_time TIME NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (login_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- ////////////////////////////////////////////////////////////////////////////////
-- CONTENT
-- ////////////////////////////////////////////////////////////////////////////////

-- --------------------------------------------------------------------------------
-- PAGES
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS rudweb_web_pages;
CREATE TABLE rudweb_web_pages (
  -- IDENTIFICATION
  pg_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  pg_ln CHAR(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  -- LOCATION
  pg_parent MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  pg_level MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  pg_order MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  -- MAIN
  pg_title VARCHAR(150) COLLATE utf8_unicode_ci NOT NULL,
  pg_alias VARCHAR(150) COLLATE utf8_unicode_ci NOT NULL,
  pg_kw VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  pg_dsc VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  pg_template VARCHAR(20) COLLATE utf8_unicode_ci NOT NULL,
  -- SETTINGS
  pg_menu TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  pg_show TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  pg_deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  pg_group MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  pg_start DATE NOT NULL DEFAULT '0000-00-00',
  pg_end DATE NOT NULL DEFAULT '0000-00-00',
  pg_comments TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  pg_search TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  pg_statistics TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  -- STATISTICS
  page_created_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  page_created_date DATE NOT NULL DEFAULT '0000-00-00',
  page_created_time TIME NOT NULL DEFAULT '00:00:00',
  page_modified_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  page_modified_date DATE NOT NULL DEFAULT '0000-00-00',
  page_modified_time TIME NOT NULL DEFAULT '00:00:00',
  page_verified_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  page_verified_date DATE NOT NULL DEFAULT '0000-00-00',
  page_verified_time TIME NOT NULL DEFAULT '00:00:00',
  page_version MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (pg_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;