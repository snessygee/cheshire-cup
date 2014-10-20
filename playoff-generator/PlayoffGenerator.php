<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

final class PlayoffGenerator {

    /** @var array contains PlayoffDuelParticipant, starts with index 1 */
    private $teams;

    /**
     * @param array $teams key = seeded, value = name of the team (or other identifier)
     * @param string $class existing class, it should be PlayoffDuelParticipant or child of PlayoffDuelParticipant
     * @return PlayoffGenerator
     * @throws PlayoffException 
     */
    public static function create($teams, $class = 'PlayoffDuelParticipant') {        
        try {
            self::verify_arguments($teams, $class);
            ksort($teams); // order by seeded (== indexes)
            return new self($teams, $class);
        } catch (PlayoffException $e) {
            throw new PlayoffException(PlayoffException::EXC1);
        }
    }

    private function __construct($teams, $class) {
        $this->teams = array();
        $index = 1;
        foreach ($teams as $seeded => $team) {
            $this->teams[$index++] = new $class($seeded, $team);
        }
    }

    /** @return array */
    public function generate_round() {
        $matches = array();
        $team_count = count($this->teams);
        for ($i = 1; $i <= $team_count / 2; $i++) {
            $matches[] = array(
                'home' => $this->teams[$i],
                'away' => $this->teams[$team_count - $i + 1]
            );
        }
        return $matches;
    }

    /** @return array contains PlayoffDuelParticipant, sorted by seeded */
    public function get_teams() {
        return $this->teams;
    }

    private static function verify_arguments($teams, $class) {
        $conditions = array(
            !is_array($teams),
            !Functions::is_power_of_two(count($teams)),
            count($teams) > PLAYOFF_MAX_TEAMS,
            !(is_string($class) && class_exists($class))
        );
        if (in_array(true, $conditions)) {
            throw new PlayoffException(PlayoffException::EXC1);
        }
    }

}

?>
