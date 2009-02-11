-- test
-- DATABASE STRUCTURE
-- 16:35 2009-02-09


-- ////////////////////////////////////////////////////////////////////////////////
-- CONTENT
-- ////////////////////////////////////////////////////////////////////////////////

-- --------------------------------------------------------------------------------
-- PAGES
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS rw_ws_pages;
CREATE TABLE rw_ws_pages (
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