<?php
require_once('season-generator/init.php');

$teams = array(
    'Makov',
    'Morasice',
    'Sec',
    //null,
    'Ujezd',
    'Litomysl',
    'Chotovice'
);
?>
<h2>Classic season</h2>
<?php
try {
    $season = SeasonGenerator::create($teams, 2);
    $season->generate();
    $sprint = new SeasonPrintout($season->getSchedule());
    $sprint->printTable();
} catch (SeasonException $e) {
    echo $e->getMessage();
}
?>
<h2>Season with limited fields</h2>
<?php
try {
    $season = SeasonFieldsGenerator::create($teams, 2, 2);
    $season->generate();
    $sprint = new SeasonPrintout($season->getSchedule());
    $sprint->printTable();
    echo '<hr />';
    $sprint->printLines();
} catch (SeasonException $e) {
    echo $e->getMessage();
}
?>
