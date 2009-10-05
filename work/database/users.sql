-- $Id$
-- $URL$
-- $Revision$

-- --------------------------------------------------------------------------------
-- USERS
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS tst_usr_usr;
CREATE TABLE tst_usr_usr (
	-- IDENTIFICATION
	usr_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
	grp_id MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 1,
	usr_name VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL, /* XXX */
	usr_mail VARCHAR(40) COLLATE utf8_unicode_ci NOT NULL,
	usr_hash VARCHAR(40) COLLATE utf8_unicode_ci NOT NULL,
	-- INFORMATION
	usr_fname VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	usr_mname VARCHAR(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	usr_lname VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	-- SETTINGS
	usr_skin VARCHAR(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'RudWEb',
	usr_lang CHAR(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
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

DROP TABLE IF EXISTS tst_usr_data;
CREATE TABLE tst_usr_data (
	-- INFORMATION
	usr_phone VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	usr_address VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	usr_country VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	
	PRIMARY KEY (usr_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;