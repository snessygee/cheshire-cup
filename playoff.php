<?php
require_once('playoff-generator/init.php');
?>

<h2>Playoff</h2>
<?php
$teams = array(1 =>
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
    'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
);
$teams = array();
for ($i = 1; $i <= 16; $i++) {
    $teams[$i] = $i;
}

$random_teams = array();
for ($i = 1; $i <= 8; $i++) {
    $seeded = 0;
    do {
        $seeded = rand(1, 50);
    } while (array_key_exists($seeded, $random_teams));
    $random_teams[$seeded] = $i;
}
//$playoff = PlayoffGenerator::generate($random_teams);                
$playoff = PlayoffGenerator::create($teams);
//echo var_dump($playoff->generate_round());        
echo '<hr />';
$ptree = new PlayoffTree($playoff);
$print = new PlayoffTreePrintout($ptree);
$print->print_statistics();
echo '<hr />';
$print->line_listing();
$print->table_listing();
$print->table_advanced_listing();
?>        
