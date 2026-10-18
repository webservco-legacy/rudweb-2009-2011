<?php
/**
 * $Id$
 *
 * Test.
 *
 * @author     Radu Maier <rudisoft@rudisoft.net>
 * @copyright  Copyright (c) 2008 - 2011, RudiSoft.Net
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
?>
<p>
    Cleanup complete ( <?php echo $time; ?> s ).
</p>

<h3 class="err">VERY IMPORTANT!</h3>

<p>
    The log file will be deleted at cleanup time, so please
    <a class="cont" title="Download log file" href="./savelog.php?log=<?php echo $log_file; ?>">save it now</a>!
</p>

<p class="next">
    &#187; <a title="Go to Step 6" href="./index.php?test=<?php echo $test; ?>&amp;step=6">Go to step 6</a>
</p>