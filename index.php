<?php
$content = false;
if (isset($_GET['generate'])) {
    if (!in_array($_GET['generate'], array('season', 'advanced_season', 'playoff', 'tournament'))) {
        header('Location: index.php');
        exit;
    }
    $content = $_GET['generate'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>PHP Sports Generators</title>
        <style type="text/css">
            table.playoff {
                float:left;       
                margin-right:1ex;
            }            
            table.playoff td span{
                border: 1px solid black;
                padding: 0 1ex;
                padding-right: 120px;
                display: inline-block;
                color: gray;
            }
        </style>
    </head>
    <body>

        <?php if ($content): ?>
        <h1><?php echo strtoupper($content); ?></h1>
        <h2><a href="index.php">Back to index</a></h2>
        <?php include($content . '.php'); ?>
        <?php else: ?>
        
        <h1>PHP Sports Generators</h1>
        <h2><a href="https://bitbucket.org/zdenekdrahos/php-sports-generators/">https://bitbucket.org/zdenekdrahos/php-sports-generators/</a></h2>
        
        <ul>
            <li><a href="?generate=season">Generate Season Schedule</a></li>
            <li><a href="?generate=advanced_season">Generate Advanced Season Schedule</a></li>
            <li><a href="?generate=playoff">Generate Playoff Schedule</a></li>
            <li><a href="?generate=tournament">Generate Tournament</a></li>
        </ul>
        
        <?php endif; ?>

    </body>
</html>
