<?php
/**
 * $Id$
 *
 * FileTime test.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    RudTest
 * @subpackage Misc
 * @version    $Revision$
 * @since      Version 5
 * @access     public
 * @filesource
 */

/**
 * @var int
 */
$steps = 6;

/**
 * @var int
 */
$test_cases = 3;

switch ( $step )
{
    case '1' :
        Test_FileTime::Init( $cfg['work_dir'], $cfg['file_count'], $cfg['test_count'] );

        Test_FileTime::LogReset();

        $time = Test_FileTime::Start( $test_cases );

        break;

    case '2' :
        Test_FileTime::Init( $cfg['work_dir'], $cfg['file_count'], $cfg['test_count'] );

        $time = Test_FileTime::Run( 'Mtime' );

        break;

    case '3' :
        Test_FileTime::Init( $cfg['work_dir'], $cfg['file_count'], $cfg['test_count'] );

        $time = Test_FileTime::Run( 'Ctime' );

        break;

    case '4' :
        Test_FileTime::Init( $cfg['work_dir'], $cfg['file_count'], $cfg['test_count'] );

        $time = Test_FileTime::Run( 'Filegetcontents' );

        break;

    case '5' :
        Test_FileTime::Init( $cfg['work_dir'], $cfg['file_count'], $cfg['test_count'] );

        $time = Test_FileTime::End();

        $log_file = Test_FileTime::GetLogFile();

        break;

    case '6' :
        Test_FileTime::Init( $cfg['work_dir'], $cfg['file_count'], $cfg['test_count'] );

        $time = Test_FileTime::End( TRUE );

        break;

    case '0' :
        $go = TRUE;
        $check['dir'] = TRUE;
        if ( !is_writable( $cfg['work_dir'] ) )
        {
            $check['dir'] = FALSE;
            $go = FALSE;
        }

    default :

        break;
}

/**
 * @var bool
 */
$continue = TRUE;
?>