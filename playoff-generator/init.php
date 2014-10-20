<?php
// TODO: refactoring in tests (primarily method ::invalid_arguments)
// TODO: camelCase in playoff-generator classes

define('PLAYOFF_MAX_TEAMS', 128);

require_once(dirname(__FILE__) . '/helpers/Functions.php');
require_once(dirname(__FILE__) . '/helpers/IBTreeItem.php');
require_once(dirname(__FILE__) . '/helpers/BinaryTree.php');
require_once(dirname(__FILE__) . '/PlayoffException.php');
require_once(dirname(__FILE__) . '/PlayoffGenerator.php');
require_once(dirname(__FILE__) . '/PlayoffDuelParticipant.php');
require_once(dirname(__FILE__) . '/PlayoffTree.php');
require_once(dirname(__FILE__) . '/PlayoffTreePrintout.php');

?>
