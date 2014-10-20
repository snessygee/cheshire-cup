<?php
require_once('tournament-generator/init.php');

$tempGroups = array(
    'GROUP A' => array('Makov', 'Pardubice', 'Liberec', 'Plzeň'),
    'GROUP B' => array('Londýn', 'Manchester', 'Glasgow', 'Dublin'),
    'GROUP C' => array('New York', 'Los Angeles', 'Detroit', 'Toronto'),
);

$groups = array();
foreach ($tempGroups as $name => $teams) {
    $g = new TournamentGroup();
    $g->setGroupName($name);
    foreach ($teams as $team) {
        $g->addTeam($team);
    }
    $groups[] = $g;
}

$tournament = TournamentGenerator::create($groups);
?>
<div style="color:red"><strong>Note: </strong> if number of teams in groups are different then generated schedule isn't 100% correct (group schedules are OK, but in tournament schedule e.g. team has 2 matches in one round)!</div>

<h2>Groups</h2>
<ul>
<?php
foreach ($tempGroups as $name => $teams) {
    echo '<li>';
    echo "<strong>{$name}</strong>: ";
    foreach ($teams as $team) {
        echo "{$team}, ";
    }
    echo '</li>';
}
?>
</ul>
<hr />
<h2>Tournament schedule - all teams in the round</h2>
<?php 
$tournament->generate(1);
$sprint = new SeasonPrintout($tournament->getTournamentSchedule());
$sprint->printTable();
?>
<hr />
<h2>Tournament schedule - 2 fields</h2>
<?php 
$tournament->generate(1,2);
$sprint = new SeasonPrintout($tournament->getTournamentSchedule());
$sprint->printTable();
?>
<hr />
<h2>Schedules for each group</h2>
<?php 
$groupSchedules = $tournament->getGroupSchedules();
foreach($groupSchedules as $group => $schedule) {
    echo "<h3>{$group}</h3>";
    $sprint = new SeasonPrintout($schedule);
    $sprint->printLines();
    echo '<hr />';
}
?>