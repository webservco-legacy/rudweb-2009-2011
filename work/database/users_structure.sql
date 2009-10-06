-- $Id$
-- $URL$
-- $Revision$

-- --------------------------------------------------------------------------------
-- USERS MAIN
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS app_usr_usr;
CREATE TABLE app_usr_usr (
	-- IDENTIFICATION
	usr_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
	grp_id MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 1,
	-- USER DATA
	usr_name VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL, /* XXX */
	usr_mail VARCHAR(40) COLLATE utf8_unicode_ci NOT NULL,
	usr_hash VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
	-- SETTINGS
	usr_skin VARCHAR(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'RudWEb',
	usr_ln CHAR(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
	-- ADMIN
	usr_status TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	usr_deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY (usr_id),
	UNIQUE KEY user_data (usr_name, usr_mail)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------------------------------
-- GROUPS MAIN
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS app_usr_grp;
CREATE TABLE app_usr_grp (
	-- IDENTIFICATION
	grp_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
	-- SETTINGS
	grp_lvl TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
	-- GROUP DATA
  	grp_name VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL,
  	grp_dsc VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  	-- ADMIN
  	grp_status TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  	grp_deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  	
  	grp_created_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  	grp_created_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  	grp_modified_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',  
  	grp_modified_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  	grp_deleted_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  	grp_deleted_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY (grp_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------------------------------
-- USERS DATA
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS app_usr_data;
CREATE TABLE app_usr_data (
	-- IDENTIFICATION
	usr_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,	
	-- USER INFORMATION
	usr_fname VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	usr_mname VARCHAR(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	usr_lname VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	usr_phone VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	usr_address VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	usr_country VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	usr_notes VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	-- STATS
	usr_created_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	usr_created_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
	usr_modified_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	usr_modified_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
	usr_deleted_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',  
	usr_deleted_user MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY (usr_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------------------------------
-- USERS LOGIN DATA
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS app_var_login;
CREATE TABLE app_var_login (
	-- IDENTIFICATION
	usr_id MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT '0',
	-- INFORMATION
	login_mail VARCHAR(40) COLLATE utf8_unicode_ci NOT NULL,
	login_ip VARCHAR(15) COLLATE utf8_unicode_ci NOT NULL,
	login_agent VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
	login_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------------------------------
-- USERS ONLINE DATA
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS app_var_online;
CREATE TABLE app_var_online (
	-- IDENTIFICATION
	usr_id MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT '0',
	online_location VARCHAR(150) COLLATE utf8_unicode_ci NOT NULL,
	online_request VARCHAR(150) COLLATE utf8_unicode_ci NOT NULL,
	-- INFORMATION
	online_ip VARCHAR(15) COLLATE utf8_unicode_ci NOT NULL,
	online_agent VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
	online_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;