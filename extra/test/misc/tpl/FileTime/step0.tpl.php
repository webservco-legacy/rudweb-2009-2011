<?php
/**
 * $Id$
 *
 * Test.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2010, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<p>
	Before you go any further please check the settings in <strong>"./settings.cfg.php"</strong>, and modify if needed.
</p>

<h3>Settings:</h3>
<ul>
	<li>
	Working directory <strong>"<?php echo $cfg['work_dir']?>"</strong> is
	<span class="<?php echo ( $check['dir'] ) ? 'ok' : 'err' ?>"><?php if ( !$check['dir'] ) { echo 'not '; }?>writable</span>;
	</li>
	<li><strong><?php echo $cfg['file_count']; ?></strong> files will be created for testing;</li>
	<li>Each test case will run <strong><?php echo $cfg['test_count']; ?></strong> times (there are <strong><?php echo $test_cases; ?></strong> test cases);</li>
</ul>

<h3>Test cases:</h3>
<ul>
	<li>"Filemtime";</li>
	<li>"Filemcime";</li>
	<li>"Filegetcontents";</li>
</ul>

<h3>Summary of operations:</h3>
<ul>
	<li>Step 0: This one;</li>
	<li>Step 1: Create test files and initialize testing libraries;</li>
	<li>Step 2: Run test case "Filemtime";</li>
	<li>Step 3: Run testcase "Filectime";</li>
	<li>Step 4: Run test case "FileGetContents";</li>
	<li>Step 5: Save log file;</li>
	<li>Step 6: Cleanup test files;</li>
</ul>

<p class="next">
<?php if ( FALSE !== $go ) : ?>
	&#187; <a class="cont" title="Start the tests" href="./index.php?test=<?php echo $test; ?>&amp;step=1">Proceed</a>
<?php else : ?>
	Adjust settings and <a class="cont" title="Reload page" href="./index.php?test=<?php echo $test; ?>&amp;step=0">try again</a>
<?php endif; ?>
</p>