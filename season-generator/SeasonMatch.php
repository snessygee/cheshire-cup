<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

/**
 * SeasonMatch class
 * - holds info about home and away team (teams cannot be null)
 */
final class SeasonMatch {
    
    /** @var mixed */
    public $home;
    /** @var mixed */
    public $away;

    public function __construct($home, $away) {
        if (is_null($home) || is_null($away)) {
            throw new SeasonException(SeasonException::EXC3);
        }
        $this->home = $home;
        $this->away = $away;
    }

    public function swapTeams() {
        $temp = $this->home;
        $this->home = $this->away;
        $this->away = $temp;
    }

}

?>
