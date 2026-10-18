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
<!DOCTYPE html>

<html lang="en">

<head>
    
    <meta charset="utf-8" />

    <title>Misc Tests .:. RudWEb</title>
    
    <meta name="author" content="Radu Maier" />
    
    <meta name="copyright" content="Copyright (c) 2008 - 2011, RudiSoft.Net" />
    
    <meta name="DC.title" content="RudWEb" />
    <meta name="DC.subject" content="Misc Tests" />
    <meta name="DC.creator" content="Radu Maier" />
    
    <link rel="stylesheet" href="./css/style.css" />

</head>

<body id="rudtest">

    <header class="content">

        <h1>Misc Tests</h1>
        
        <nav id="menu">
            <ul>
            <?php foreach ( $tests as $test_id => $test_name ) : ?>
            <?php $test_class = ( $test_id == $test ) ? ' class="active"' : ''; ?>
                <li><a <?php echo $test_class; ?> title="<?php echo $test_name; ?>" href="./index.php?test=<?php echo $test_id; ?>"><?php echo $test_name; ?></a></li>
            <?php endforeach; ?>
            </ul>
        <?php if ( ( 0 < $step ) && ( 6 > $step ) ) : ?>
            <a class="cancel" title="Abort tests" href="./index.php?test=<?php echo $test; ?>&amp;step=6">&#187; Cancel</a>
        <?php elseif ( 0 == $step ) : ?>
            <a class="cancel" title="Abort tests" href="./index.php?test=<?php echo $test; ?>&amp;step=0">&#187; Reload</a>
        <?php endif; ?>
        </nav>
    
    </header>
    
    <section id="message" class="content">
        
        <h2><?php echo $tests[$test];?> Test - Step <?php echo $step; ?> of <?php echo $steps; ?></h2>
        
        <p><?php echo $message; ?></p>
        
    </section>
    
    <footer class="content">
        <address>Copyright (c) 2008 - 2011, RudiSoft.Net</address>
    </footer>

</body>

</html>
