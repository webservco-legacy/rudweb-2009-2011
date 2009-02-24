-- test
-- DATABASE STRUCTURE
-- 16:35 2009-02-09

-- ////////////////////////////////////////////////////////////////////////////////
-- SETTINGS
-- ////////////////////////////////////////////////////////////////////////////////

-- --------------------------------------------------------------------------------
-- USERS
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS rudweb_usr_users;
CREATE TABLE rudweb_usr_users (
  -- IDENTIFICATION
  usr_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  grp_id MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 1,
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
  usr_skin VARCHAR(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'rudweb_smarty',
  usr_lang CHAR(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ro',
  -- ADMIN
  usr_disabled TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  usr_deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  usr_notes VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  usr_created_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  usr_created_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  usr_modified_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  usr_modified_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  usr_deleted_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',  
  usr_deleted_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (usr_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------------------------------
-- GROUPS
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS rudweb_usr_groups;
CREATE TABLE rudweb_usr_groups (
  -- IDENTIFICATION
  grp_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  grp_lvl TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,  
  -- INFORMATION
  grp_name VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL,
  grp_dsc VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  -- ADMIN
  grp_disabled TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  grp_deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  grp_created_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,  
  grp_created_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  grp_modified_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',  
  grp_modified_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  grp_deleted_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  grp_deleted_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (grp_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------------------------------
-- LOGIN HISTORY
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS rudweb_var_logins;
CREATE TABLE rudweb_var_logins (
  login_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  usr_id MEDIUMINT(5) UNSIGNED NOT NULL,
  login_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  pg_disabled TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  pg_deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  pg_group MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  pg_start DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  pg_end DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  pg_comments TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  pg_search TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  pg_statistics TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  -- STATISTICS
  pg_created_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,  
  pg_created_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  pg_modified_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  pg_modified_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  pg_verified_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  pg_verified_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  pg_deleted_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  pg_deleted_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  pg_version MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (pg_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------------------------------
-- CONTENT
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS rudweb_web_content;
CREATE TABLE rudweb_web_content (
  -- IDENTIFICATION
  cnt_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  -- LOCATION
  pg_id MEDIUMINT(5) UNSIGNED NOT NULL,
  cnt_order MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  -- MAIN
  cnt_type VARCHAR(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  cnt_body MEDIUMTEXT COLLATE utf8_unicode_ci NOT NULL,
  cnt_resource MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  cnt_template VARCHAR(20) COLLATE utf8_unicode_ci NOT NULL,
  -- SETTINGS
  cnt_disabled TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  cnt_deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  cnt_start DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  cnt_end DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  cnt_search TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  cnt_statistics TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  -- STATISTICS
  cnt_created_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,  
  cnt_created_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  cnt_modified_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  cnt_modified_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  cnt_verified_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  cnt_verified_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  cnt_deleted_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  cnt_deleted_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  cnt_version MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (cnt_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------------------------------
-- PICTURES
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS rudweb_web_pictures;
CREATE TABLE rudweb_web_pictures (
  -- IDENTIFICATION
  pic_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  -- LOCATION
  pic_dir VARCHAR(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  pic_file VARCHAR(150) COLLATE utf8_unicode_ci NOT NULL,
  -- MAIN
  pic_title VARCHAR(150) COLLATE utf8_unicode_ci NOT NULL,
  pic_alias VARCHAR(150) COLLATE utf8_unicode_ci NOT NULL,
  pic_alt VARCHAR(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  -- SETTINGS
  pic_width MEDIUMINT(4) UNSIGNED NOT NULL DEFAULT 0,
  pic_height MEDIUMINT(4) UNSIGNED NOT NULL DEFAULT 0,
  pic_deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  -- STATISTICS
  pic_created_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,  
  pic_created_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  pic_deleted_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  pic_deleted_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (pic_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;