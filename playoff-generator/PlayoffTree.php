<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

final class PlayoffTree {

    /** @var array */
    private $teams;
    /** @var BinaryTree */
    private $btree;

    /** @param PlayoffGenerator $playoff */
    public function __construct($playoff) {
        if (!($playoff instanceof PlayoffGenerator)) {
            throw new PlayoffException(PlayoffException::EXC4);
        }
        $this->teams = $playoff->get_teams();        
        $this->build_tree();
    }
    
    /** @return array */
    public function get_array() {
        $items = $this->btree->get_items();
        $result = array();
        $result['team_count'] = count($this->teams);
        $result['round_count'] = log(count($this->teams), 2);
        $result['rounds'] = array();
        for ($i = $result['round_count']; $i >= 1; $i--) {            
            $round = array();
            $start = pow(2, $i);
            for ($j = 0; $j < pow(2, $i); $j+=2) {
                $round[] = array(
                    'home' => $items[$start + $j],
                    'away' => $items[$start + $j + 1]
                );
            }
            $result['rounds'][$i] = $round;
        }        
        return $result;
    }        

    private function build_tree() {
        $this->btree = new BinaryTree();
        $this->btree->insert_root($this->teams[1]);
        for ($j = 1; $j <= count($this->teams) / 2; $j++) {
            $this->btree->access_root();
            $this->btree->access_first($this->teams[$j]);
            foreach ($this->find_opponents($j) as $opponent) {
                if ($j % 2 == 1) {
                    $this->btree->insert_left_son($this->teams[$j]);
                    $this->btree->insert_right_son($opponent);
                    $this->btree->access_left_son();
                } else {
                    $this->btree->insert_left_son($opponent);
                    $this->btree->insert_right_son($this->teams[$j]);
                    $this->btree->access_right_son();
                }
            }
        }
    }

    private function find_opponents($team_index) {
        $opponents = array();
        for ($i = 2; $i <= count($this->teams); $i *= 2) {
            $opponent = $i - $team_index + 1;
            if ($opponent > $team_index) {
                $opponents[] = $this->teams[$opponent];
            }
        }        
        return $opponents;
    }

}

?>
