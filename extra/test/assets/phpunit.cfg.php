<?php
/**
 * $Id$
 */

/**
 * Security token.
 */
define( '_RUDWEB', TRUE );

/**
 * Load all required files
 */
require 'RudWEb/lib/Core/Core.lib.php';
require 'RudWEb/lib/Core/CoreUtils.lib.php';

require 'RudWEb/lib/Library/Library.lib.php';

require 'RudWEb/lib/Cfg/Cfg.lib.php';

require 'RudWEb/lib/Error/Error.lib.php';

require 'RudWEb/lib/I18n/I18n.lib.php';
require 'RudWEb/lib/I18n/I18nUtils.lib.php';

require 'RudWEb/lib/Log/Log.lib.php';

require 'RudWEb/lib/App/App.lib.php';

require 'RudWEb/int/Database/Database.int.php';

require 'RudWEb/lib/Database/Database.lib.php';
require 'RudWEb/lib/Database/Mysql.lib.php';

require 'RudWEb/lib/Url/Url.lib.php';

require 'RudWEb/lib/Module/Module.lib.php';

require 'RudWEb/lib/Controller/Controller.lib.php';

/**
 * Assets path.
 */
define ('_PU_ASSETS_PATH', '/home/rudisoft/www/projects/RudWEb-5.0/extra/test/assets/' );

?>