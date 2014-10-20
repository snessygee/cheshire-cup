<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

class TournamentGroup {

    private $groupName;
    private $teams;

    public function __construct() {
        $this->teams = array();
        $this->groupName = 'Group';
    }

    public function getTeams() {
        return $this->teams;
    }

    public function getTeamCount() {
        return count($this->teams);
    }

    public function getGroupName() {
        return $this->groupName;
    }
    
    public function setGroupName($newName) {
        if ($this->isNameValid($newName)) {
            $this->groupName = $newName;
        }
    }
    
    public function addTeam($team) {
        if ($this->isTeamValid($team)) {
            $this->teams[] = $team;
        }
    }    

    protected function isNameValid($newName) {
        return is_string($newName) && !empty($newName) && $this->groupName != $newName;
    }
    
    protected function isTeamValid($team) {
        return is_string($team) && !empty($team) && !in_array($team, $this->teams);
    }

}

?>