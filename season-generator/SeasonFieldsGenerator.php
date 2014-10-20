<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

/**
 * SeasonFieldsGenerator class
 * - for generating season schedules with number of fields
 */
final class SeasonFieldsGenerator extends SeasonGenerator {

    /**
     * @param array $teams
     * @param int $numberOfPeriods
     * @param int $numberOfFields
     * @return SeasonGenerator
     * @throws SeasonException 
     */
    public static function create($teams, $numberOfPeriods, $numberOfFields = 2) {
        parent::verifyArguments($teams, $numberOfPeriods);
        self::verifyNumberOfFields($numberOfFields, count($teams));
        return new self($teams, $numberOfPeriods, $numberOfFields);
    }

    protected function __construct($teams, $numberOfPeriods, $numberOfFields = 2) {
        parent::__construct($teams, $numberOfPeriods);
        $this->schedule->matchesInRound = $numberOfFields;
    }

    public function generate() {
        parent::generate();
        $this->updateSchedule();
    }

    private function updateSchedule() {
        $oldSchedule = $this->schedule->rounds;
        $this->schedule->rounds = array(0 => 1); // only because I want 1st round == 1st index in schedule
        $newRoundMatches = array();
        foreach ($oldSchedule as $round) {
            $matches = $round->getIterator();
            foreach ($matches as $z) {
                if (count($newRoundMatches) >= $this->schedule->matchesInRound) {
                    $this->schedule->rounds[] = SeasonRound::constructFromMatches($newRoundMatches);
                    $newRoundMatches = array();
                }
                $newRoundMatches[] = new SeasonMatch($z->home, $z->away);
            }
        }
        if (!empty($newRoundMatches)) {
            $this->schedule->rounds[] = SeasonRound::constructFromMatches($newRoundMatches);
        }
        unset($this->schedule->rounds[0]);
    }

    private static function verifyNumberOfFields($numberOfFields, $teamCount) {
        $actual = floor($teamCount / 2);
        if (!is_int($numberOfFields) || $numberOfFields <= 1 || $numberOfFields >= $actual) {
            throw new SeasonException(SeasonException::EXC5);
        }
    }

}

?>
