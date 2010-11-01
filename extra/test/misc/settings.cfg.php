<?php
/**
 * $Id$
 *
 * Misc tests settings.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudTest
 * @subpackage Misc
 * @version    $Revision$
 * @since      Version 5
 * @access     public
 * @filesource
 */

/**
 * Path to working directory with trailing slash.
 *
 * eg. c:/wamp/www/test/tmp/
 *
 * @var string
 */
$cfg['work_dir'] = './tmp/';

/**
 * Number of files to use for the tests.
 *
 * @var int
 */
$cfg['file_count'] = 30000;

/**
 * Number of times to run each test.
 *
 * @var int
 */
$cfg['test_count'] = 30;
?>