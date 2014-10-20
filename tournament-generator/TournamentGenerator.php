<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

// TODO: refactoring, improve/fix creating of tournament schedule
final class TournamentGenerator {

    /** @var array(TournamentGroup) - tournament groups */
    private $groups;
    /** @var array(string) - all teams from tournament */
    private $allTeams;
    /** @var array(SeasonMatch) - all tournament matches from one period */
    private $allMatches;
    /** @var array(SeasonSchedule) - schedule for each group */
    private $groupsSchedules;
    /** @var SeasonSchedule */
    private $tournamentSchedule;

    public static function create($groups) {
        self::checkGroups($groups);
        return new self($groups);
    }

    private function __construct($groups) {
        $this->groups = $groups;
        $this->loadAllTeams();
        $this->loadTournamentMatches();
        $this->groupsSchedules = array();
        $this->tournamentSchedule = new SeasonSchedule();
    }

    public function getGroupSchedules() {
        return $this->groupsSchedules;
    }

    public function getTournamentSchedule() {
        return $this->tournamentSchedule;
    }

    public function generate($periodCount, $fieldCount = null) {
        if ($periodCount != $this->tournamentSchedule->periodCount) {
            $this->generateGroupSchedules($periodCount);
            $this->initTournamentSchedule($periodCount);
        }
        if ($fieldCount !== $this->tournamentSchedule->matchesInRound) {
            $this->updateFieldCount($fieldCount);
            $this->generateTournamentSchedule();
        }
    }

    private function generateGroupSchedules($periodCount) {
        try {
            $this->groupsSchedules = array();
            foreach ($this->groups as $group) {
                $season = SeasonGenerator::create($group->getTeams(), $periodCount);
                $season->generate();
                $this->groupsSchedules[$group->getGroupName()] = $season->getSchedule();
            }
        } catch (SeasonException $e) {
            throw new TournamentException(TournamentException::EXC1);
        }
    }

    private function initTournamentSchedule($periodCount) {
        $seasonGenerator = SeasonGenerator::create($this->allTeams, $periodCount);
        $seasonGenerator->generate();
        $this->tournamentSchedule = $seasonGenerator->getSchedule();
        $this->updateMatchesInRound();
    }

    private function updateMatchesInRound() {
        $matchesInRound = 0;
        foreach ($this->groups as $group) {
            $matchesInRound += floor(count($group->getTeams()) / 2);
        }
        $this->tournamentSchedule->matchesInRound = (int) $matchesInRound;
    }

    private function updateFieldCount($fieldCount) {
        $maxCount = count($this->allTeams) / 2;
        if (is_int($fieldCount) && $fieldCount > 1 && $fieldCount < $maxCount) {
            $this->tournamentSchedule->matchesInRound = $fieldCount;
        } else if (!is_null($fieldCount)) {
            throw new TournamentException(TournamentException::EXC2);
        }
    }

    private function generateTournamentSchedule() {
        $roundMatches = array();
        $matches = $this->allMatches;
        $this->tournamentSchedule->rounds = array(0 => 1);
        while (!empty($matches)) {
            if (count($roundMatches) == $this->tournamentSchedule->matchesInRound) {
                $this->tournamentSchedule->rounds[] = SeasonRound::constructFromMatches($roundMatches);
                $roundMatches = array();
            }
            $roundMatches[] = array_shift($matches);
        }
        if (!empty($roundMatches)) {
            $this->tournamentSchedule->rounds[] = SeasonRound::constructFromMatches($roundMatches);
        }
        unset($this->tournamentSchedule->rounds[0]);
    }

    private function loadAllTeams() {
        $this->allTeams = array();
        foreach ($this->groups as $group) {
            $this->allTeams = array_merge($this->allTeams, $group->getTeams());
        }
    }

    private function loadTournamentMatches() {
        $this->allMatches = array();
        $this->generateGroupSchedules(1); // otherwise matches cannot be loaded
        $groupNumber = 1;
        $groupCount = count($this->groups);
        foreach ($this->groupsSchedules as $groupSchedule) {
            $matchNumber = $groupNumber;
            foreach ($groupSchedule->rounds as $round) {
                foreach ($round as $match) {
                    $this->allMatches[$matchNumber] = $match;
                    $matchNumber += $groupCount;
                }
            }
            $groupNumber++;
        }
        ksort($this->allMatches);
    }

    private static function checkGroups($groups) {
        if (is_array($groups)) {
            foreach ($groups as $group) {
                if (!($group instanceof TournamentGroup)) {
                    throw new TournamentException(TournamentException::EXC3);
                } else if (count($group->getTeams()) < 2) {
                    throw new TournamentException(TournamentException::EXC4);
                }
            }
        } else {
            throw new TournamentException(TournamentException::EXC5);
        }
    }

}

?>