-- $Id$
-- $URL$
-- $Revision$

DROP TABLE IF EXISTS rudweb_work_functions;

CREATE TABLE rudweb_work_functions (
f_id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
f_name VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL,
f_4 VARCHAR(5) COLLATE utf8_unicode_ci NOT NULL,
f_5 VARCHAR(5) COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY(f_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

INSERT INTO rudweb_work_functions(f_name, f_4, f_5) VALUES
('array_combine', '0.0', '5.0'),
('array_diff', '4.0.1', '5.0'),
('array_diff_key', '0.0', '5.1.0'),
('array_key_exists', '4.0.7', '5.0'),
('array_keys', '4.0', '5.0'),
('array_map', '4.0.6', '5.0'),
('array_merge', '4.0', '5.0'),
('array_pad', '4.0', '5.0'),
('array_slice', '4.0', '5.0'),
('base64_decode', '4.0', '5.0'),
('base64_encode', '4.0', '5.0'),
('count', '4.0', '5.0'),
('date', '4.0', '5.0'),
('date_default_timezone_set', '0.0', '5.1.0'),
('define', '4.0', '5.0'),
('defined', '4.0', '5.0'),
('error_get_last', '0.0', '5.2.0'),
('error_reporting', '4.0', '5.0'),
('exif_imagetype', '4.3.0', '5.0'),
('explode', '4.0', '5.0'),
('extract', '4.0', '5.0'),
('fclose', '4.0', '5.0'),
('feof', '4.0', '5.0'),
('fgets', '4.0', '5.0'),
('file_get_contents', '4.3.0', '5.3.0'),
('file_put_contents', '0.0', '5.0'),
('finfo_close', '0.0', '5.3.0'),
('finfo_file', '0.0', '5.3.0'),
('finfo_open', '0.0', '5.3.0'),
('fopen', '4.0', '5.0'),
('fwrite', '4.0', '5.0'),
('fclose', '4.0', '5.0'),
('fsockopen', '4.0', '5.0'),
('function_exists', '4.0', '5.0'),
('fwrite', '4.0', '5.0'),
('get_magic_quotes_gpc', '4.0', '5.0'),
('getimagesize', '4.0', '5.0'),
('gmdate', '4.0', '5.0'),
('header', '4.0', '5.0'),
('image_type_to_extension ', '0.0', '5.0'),
('image_type_to_mime_type', '4.3.0', '5.0'),
('imagecolorallocate', '4.0', '5.0'),
('imagecopyresampled', '4.0.6', '5.0'),
('imagecreatefromgif', '4.0', '5.0'),
('imagecreatefromjpeg', '4.0', '5.0'),
('imagecreatefrompng', '4.0', '5.0'),
('imagecreatetruecolor', '4.0.6', '5.0'),
('imagedestroy', '4.0', '5.0'),
('imagefill', '4.0', '5.0'),
('imagegif', '4.0', '5.0'),
('imagejpeg', '4.0', '5.0'),
('imagepng', '4.0', '5.0'),
('imagepng', '4.0', '5.0'),
('imagettftext', '4.0', '5.0'),
('implode', '4.0', '5.0'),
('in_array', '4.0', '5.0'),
('ini_set', '4.0', '5.0'),
('ip2long', '4.0', '5.0'),
('is_array', '4.0', '5.0'),
('is_callable', '4.0.6', '5.0'),
('is_dir', '4.0', '5.0'),
('is_file', '4.0', '5.0'),
('is_numeric', '4.0', '5.0'),
('is_readable', '4.0', '5.0'),
('is_uploaded_file', '4.0.3', '5.0'),
('isset', '4.0', '5.0'),
('long2ip', '4.0', '5.0'),
('ltrim', '4.1.0', '5.0'),
('md5', '4.0', '5.0'),
('md5_file', '4.2.0', '5.0'),
('method_exists', '4.0', '5.0'),
('mime_content_type', '4.3.0', '5.0'),
('microtime', '4.0', '5.0'),
('mkdir', '4.0', '5.0'),
('mysql_close', '4.0', '5.0'),
('mysql_connect', '4.0', '5.0'),
('mysql_fetch_array', '4.0', '5.0'),
('mysql_num_rows', '4.0', '5.0'),
('mysql_query', '4.0', '5.0'),
('mysql_real_escape_string', '4.3.0', '5.0'),
('mysql_result', '4.0', '5.0'),
('mysql_select_db', '4.0', '5.0'),
('ob_end_clean', '4.0', '5.0'),
('ob_get_contents', '4.0', '5.0'),
('ob_start', '4.0', '5.0'),
('openssl_free_key', '4.0.4', '5.0'),
('openssl_open', '4.0.4', '5.0'),
('openssl_seal', '4.0.4', '5.0'),
('openssl_sign', '4.0.4', '5.0'),
('openssl_pkey_get_private', '4.2.0', '5.0'),
('openssl_pkey_get_public', '4.2.0', '5.0'),
('openssl_verify', '4.0.4', '5.0'),
('parse_ini_file', '4.0', '5.0'),
('preg_match', '4.0', '5.0'),
('preg_repace', '4.0', '5.0'),
('property_exists', '0.0', '5.1.0'),
('rand', '4.0', '5.0'),
('rawurlencode', '4.0', '5.0'),
('restore_error_handler', '4.0.1', '5.0'),
('round', '4.0', '5.0'),
('rtrim', '4.1.0', '5.0'),
('session_cache_expire', '4.0.3', '5.0'),
('session_cache_limiter', '4.0.3', '5.0'),
('session_destroy', '4.0', '5.0'),
('session_get_cookie_params', '4.0.4', '5.0'),
('session_name', '4.0', '5.0'),
('session_regenerate_id', '0.0', '5.1.0'),
('session_start', '4.0', '5.0'),
('session_save_path', '4.0', '5.0'),
('setcookie', '4.0', '5.0'),
('set_error_handler', '4.0.1', '5.0'),
('sha1', '4.3.0', '5.0'),
('simplexml_load_file', '0.0', '5.0'),
('simplexml_load_string', '0.0', '5.0'),
('sprintf', '4.0', '5.0'),
('str_replace', '4.0', '5.0'),
('str_word_count', '0.0', '5.1.0'), /* original is 4.3.0 + 5.0 but we need the 3rd parameter */
('stripslashes', '4.0', '5.0'),
('strlen', '4.0', '5.0'),
('mb_strlen', '4.0.6', '5.0'),
('strpos', '4.0', '5.0'),
('strrev', '4.0', '5.0'),
('strstr', '4.0', '5.0'),
('mb_strstr', '0.0', '5.2.0'),
('strtolower', '4.0', '5.0'),
('strtoupper', '4.0', '5.0'),
('mb_strtoupper', '4.3.0', '5.0'),
('substr', '4.0', '5.0'),
('mb_substr', '4.0.6', '5.0'),
('time', '4.0', '5.0'),
('trigger_error', '4.0.1', '5.0'),
('trim', '4.0', '5.0'),
('ucfirst', '4.0', '5.0'),
('uniqid', '4.0', '5.0'),
('unlink', '4.0', '5.0')
;

-- GD required
-- mbstring highly recommended but not required
-- PHP5 because of class constructors.
-- upload error messages req min 4.2.0 (5.2.0 for all codes 1-8)
-- mime_content_type is deprecated
-- finfo_open for PHP < 5.3.0 requires the extension  PECL fileinfo 0.1.0
-- finfo_close for PHP < 5.3.0 requires the extension  PECL fileinfo 0.1.0
-- finfo_file for PHP < 5.3.0 requires the extension  PECL fileinfo 0.1.0
-- openssl extension required for licensing
-- simpleXML extension required for config and licensing

-- total functions
SELECT COUNT(DISTINCT(f_id)) FROM rudweb_work_functions;
-- PHP4 version
SELECT MAX(f_4) FROM rudweb_work_functions;
-- PHP4 version - list of functions
SELECT * FROM rudweb_work_functions WHERE f_4 = (SELECT MAX(f_4) FROM rudweb_work_functions);
-- PHP5 version
SELECT MAX(f_5) FROM rudweb_work_functions;
-- PHP5 version - list of functions
SELECT * FROM rudweb_work_functions WHERE f_5 = (SELECT MAX(f_5) FROM rudweb_work_functions);
-- PHP5 only functions
SELECT * FROM rudweb_work_functions WHERE f_4 = '0.0';