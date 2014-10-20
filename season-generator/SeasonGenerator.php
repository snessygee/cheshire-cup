<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

/**
 * SeasonGenerator class
 * - for generating season schedules
 */
class SeasonGenerator {

    /** @var SeasonSchedule */
    protected $schedule;
    /** @var array */
    private $tempTeams;

    /**
     * @param array $teams
     * @param int $numberOfPeriods
     * @return SeasonGenerator
     * @throws SeasonException 
     */
    public static function create($teams, $numberOfPeriods) {
        self::verifyArguments($teams, $numberOfPeriods);
        return new self($teams, $numberOfPeriods);
    }

    protected function __construct($teams, $numberOfPeriods) {
        $this->schedule = new SeasonSchedule();
        $this->loadTeams($teams);
        $this->schedule->rounds = array();
        $this->schedule->periodCount = $numberOfPeriods;
        $this->schedule->matchesInRound = (int) floor($this->schedule->getNumberOfTeams() / 2);
    }

    public function shuffleTeams() {
        shuffle($this->tempTeams);
    }

    public function generate() {
        $roundsInPeriod = $this->schedule->getNumberOfRoundsInPeriod();
        for ($i = 1; $i <= $roundsInPeriod; $i++) {
            $this->schedule->rounds[$i] = SeasonRound::constructFromTeams($this->tempTeams);            
            $this->turnTeamsArray();            
        }
        $this->balanceMatchesOfFirstTeam();
    }

    public function getSchedule() {
        if (empty($this->schedule->rounds)) {
            throw new SeasonException(SeasonException::EXC2);
        }
        return $this->schedule;
    }

    /**
     * Example:[1 2 3 4 5 6] -> matches 1-6, 2-5, 3-4
     * @return [1 6 2 3 4 5] -> matches 1-5, 6-4, 2-3
     */
    private function turnTeamsArray() {
        $indexOfLastTeam = count($this->tempTeams) - 1;
        $temp = $this->tempTeams[$indexOfLastTeam];
        for ($i = $indexOfLastTeam; $i > 1; $i--) {
            $this->tempTeams[$i] = $this->tempTeams[$i - 1];
        }
        $this->tempTeams[1] = $temp;
    }

    private function balanceMatchesOfFirstTeam() {
        for ($i = 1; $i <= $this->schedule->getNumberOfRoundsInPeriod(); $i++) {
            if ($i % 2 == 0) {
                $this->schedule->rounds[$i]->swapMatchOfFirstTeam();
            }
        }
    }

    private function loadTeams($teams) {
        $this->schedule->teams = array();
        foreach ($teams as $team) {
            $this->schedule->teams[] = $team;
        }
        $this->tempTeams = $this->schedule->teams;
        if (count($this->schedule->teams) % 2 == 1) {
            array_push($this->tempTeams, null);
        }
    }

    protected static function verifyArguments($teams, $periodCount) {
        $conditions = array(
            !is_array($teams),
            is_array($teams) ? in_array(null, $teams) : false,
            count($teams) < 2 || count($teams) > SEASON_MAX_TEAMS,
            !is_int($periodCount) || $periodCount < SEASON_MIN_PERIODS || $periodCount > SEASON_MAX_PERIODS,
        );
        if (in_array(true, $conditions)) {
            throw new SeasonException(SeasonException::EXC1);
        }
    }

}

?>