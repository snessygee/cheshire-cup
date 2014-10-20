<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

class PlayoffDuelParticipant implements IBTreeItem {

    /** @var mixed */
    public $team;
    /** @var int */
    public $seeded;

    public function __construct($seeded, $team) {
        if (!is_int($seeded)) {
            throw new PlayoffException(PlayoffException::EXC2);
        }
        $this->team = $team;
        $this->seeded = $seeded;
    }

    public function __toString() {
        return "{$this->team} ({$this->seeded})";
    }

    public static function is_identical($a, $b) {
        if ($a instanceof PlayoffDuelParticipant && $b instanceof PlayoffDuelParticipant) {
            return $a->team === $b->team && $a->seeded === $b->seeded;
        } else {
            throw new PlayoffException(PlayoffException::EXC3);
        }
    }

}

?>
