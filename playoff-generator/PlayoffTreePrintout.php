<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

/**
 * PlayoffTreePrintout class
 * - for displaying playoff tree (it uses Breadth-first search)
 */
class PlayoffTreePrintout {

    /** @var array from PlayoffTree::get_array */
    private $array;

    public function __construct($playoff_tree, $reverse = false) {
        if (!($playoff_tree instanceof PlayoffTree)) {
            throw new PlayoffException(PlayoffException::EXC5);
        }
        $this->array = $playoff_tree->get_array();
        if ($reverse === true) {
            $this->array['rounds'] = array_reverse($this->array['rounds'], true);
        }
    }
    
    public function print_statistics() {
        echo 'Round count: ' . $this->array['round_count'] . '<br />';
        echo 'Team count: ' . $this->array['team_count'] . '<br />';
    }

    public function line_listing() {        
        foreach ($this->array['rounds'] as $number => $round) {
            echo $number . '.round<br />';
            foreach ($round as $match) {
                echo $match['home'] . ' : ' . $match['away'] . ' -> ';
                echo ($match['home']->seeded < $match['away']->seeded ? $match['home']->team : $match['away']->team);
                echo '<br />';
            }
        }
        echo '<hr />';
    }

    public function table_listing() {
        $this->print_table_header();
        echo '<tr>';
        foreach ($this->array['rounds'] as $round) {
            echo '<td>';
            foreach ($round as $match) {
                echo $match['home'] . ' : ' . $match['away'] . '<br />';
            }
            echo '</td>';
        }
        echo '</tr></table><hr />';
    }
    
    public function table_advanced_listing() {        
        $height = $this->array['team_count'] * 25;
        $width = 98 / $this->array['round_count'];
        foreach ($this->array['rounds'] as $round) {
            //echo '<table class="playoff" style="height: ' . $height . 'px; width: ' . $width . '%">';            
            echo '<table class="playoff" style="height: ' . $height . 'px">';            
            foreach ($round as $match) {
                echo '<tr><td><span>';
                echo $match['home']->team . '<br />' . $match['away']->team . '<br />';
                echo '</span></td></tr>';
            }
            echo '</table>';
        }        
    }
    
    private function print_table_header() {
        echo '<table style="text-align:center;vertical-align:middle"><tr>';
        for ($i = 1; $i <= $this->array['round_count']; $i++) {
            echo '<th>' . $i . '.round</th>';
        }
        echo '</tr>';
    }

}

?>
