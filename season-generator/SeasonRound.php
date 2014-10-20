<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

/**
 * SeasonRound class
 * - holds matches which belongs to the round
 */
final class SeasonRound implements IteratorAggregate {

    /** @var array */
    private $matches;

    public static function constructFromTeams($teams) {
        $round = new self();
        $round->generateMatches($teams, count($teams));
        return $round;
    }
    
    public static function constructFromMatches($matches) {
        $round = new self();
        $round->matches = $matches;
        return $round;
    }            

    public function swapMatchOfFirstTeam() {
        $this->matches[0]->swapTeams();
    }

    public function getIterator() {
        return new ArrayIterator($this->matches);
    }
    
    private function __construct() {
        $this->matches = array();        
    }        

    private function generateMatches($teams, $teamCount) {
        for ($i = 0; $i < $teamCount / 2; $i++) {
            try {
                $match = new SeasonMatch($teams[$i], $teams[$teamCount - $i - 1]);
                if ($i % 2 == 1) {
                    $match->swapTeams();
                }
                $this->matches[] = $match;
            } catch (SeasonException $e) {// empty match (if odd team count) -> continue to next match
                continue;
            }
        }
    }

}

?>
