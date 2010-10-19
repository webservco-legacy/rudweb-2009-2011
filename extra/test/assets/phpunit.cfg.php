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
require_once 'RudWEb/lib/Core/Core.lib.php';
require_once 'RudWEb/lib/Core/CoreUtils.lib.php';

require_once 'RudWEb/lib/Library/Library.lib.php';

require_once 'RudWEb/lib/Config/Config.lib.php';

require_once 'RudWEb/lib/Error/Error.lib.php';

require_once 'RudWEb/lib/I18n/I18n.lib.php';
require_once 'RudWEb/lib/I18n/I18nUtils.lib.php';

require_once 'RudWEb/lib/Log/Log.lib.php';

require_once 'RudWEb/lib/App/App.lib.php';

require_once 'RudWEb/int/Database/Database.int.php';

require_once 'RudWEb/lib/Database/Database.lib.php';
require_once 'RudWEb/lib/Database/Mysql.lib.php';
require_once 'RudWEb/lib/Database/Mysqli.lib.php';
require_once 'RudWEb/lib/Database/Pdo.lib.php';
require_once 'RudWEb/lib/Database/Postgresql.lib.php';
require_once 'RudWEb/lib/Database/Sqlite3.lib.php';

require_once 'RudWEb/lib/String/String.lib.php';

require_once 'RudWEb/lib/Sanitizer/Sanitizer.lib.php';

require_once 'RudWEb/lib/Router/Router.lib.php';

require_once 'RudWEb/lib/Module/Module.lib.php';

require_once 'RudWEb/lib/Controller/Controller.lib.php';

require_once 'RudWEb/lib/Output/Output.lib.php';

/**
 * Assets path.
 */
define ('_PU_ASSETS_PATH', '/home/rudisoft/www/projects/RudWEb-5.0/extra/test/assets/' );

?>