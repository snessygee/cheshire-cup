<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

final class SeasonSchedule implements IteratorAggregate {

    /** @var array */
    public $teams;
    /** @var int */
    public $periodCount;
    /** @var int number of matches in round (== number of fields) */
    public $matchesInRound;
    /** @var array(SeasonRound) contains round for ONE period */
    public $rounds;

    public function __construct() {
        $this->teams = array();
        $this->periodCount = 0;
        $this->matchesInRound = 0;
        $this->rounds = array();
    }

    public function getIterator() {
        return new ArrayIterator($this->rounds);
    }

    public function getNumberOfTeams() {
        return count($this->teams);
    }

    public function getNumberOfRoundsInPeriod() {
        if (!empty($this->rounds)) {
            return count($this->rounds);
        } else {
            $teamCount = $this->getNumberOfTeams();
            return ($teamCount % 2 == 0) ? $teamCount - 1 : $teamCount;
        }
    }

    public function getNumberOfMatchesInPeriod() {
        $teamCount = $this->getNumberOfTeams();
        return $teamCount * ($teamCount - 1) / 2;
    }

}

?>