<?php
define('SEASON_MIN_PERIODS', 1);
define('SEASON_MAX_PERIODS', 10);
define('SEASON_MAX_TEAMS', 100);

require_once(dirname(__FILE__) . '/SeasonException.php');
require_once(dirname(__FILE__) . '/SeasonGenerator.php');
require_once(dirname(__FILE__) . '/SeasonFieldsGenerator.php');
require_once(dirname(__FILE__) . '/SeasonSchedule.php');
require_once(dirname(__FILE__) . '/SeasonRound.php');
require_once(dirname(__FILE__) . '/SeasonMatch.php');
require_once(dirname(__FILE__) . '/SeasonPrintout.php');

?>
