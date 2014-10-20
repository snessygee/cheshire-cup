<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

/**
 * BinaryTree class
 * - inserted items musto implement IBTreeItem interface, otherwise exception is thrown 
 */
class BinaryTree {

    private $items;
    private $itemCount;
    private $actualPosition;

    public function __construct() {
        $this->init_tree();
    }
    
    public function destroy() {
        $this->init_tree();
    }

    public function get_item_count() {
        return $this->itemCount;
    }

    public function insert_root($item) {        
        if ($this->is_empty()) {
            $this->insert(1, $item);
        }
    }

    public function insert_left_son($item) {
        if (!$this->is_empty() && !$this->exists_left_son()) {
            $this->insert(2 * $this->actualPosition, $item);
        }
    }

    public function insert_right_son($item) {
        if (!$this->is_empty() && !$this->exists_right_son()) {
            $this->insert(2 * $this->actualPosition + 1, $item);
        }
    }
    
    public function delete_left_son() {
        if ($this->is_left_son_leaf()) {
            return $this->delete(2 * $this->actualPosition);
        }
        return null;
    }
    
    public function delete_right_son() {
        if ($this->is_right_son_leaf()) {
            return $this->delete(2 * $this->actualPosition + 1);
        }
        return null;
    }
    
    public function access_root() {
        if (!$this->is_empty()) {
            $this->actualPosition = 1;
            return $this->access_actual();
        }
        return null;
    }    

    public function access_left_son() {
        if ($this->exists_left_son()) {
            $this->actualPosition = 2 * $this->actualPosition;
            return $this->access_actual();
        }
        return null;
    }

    public function access_right_son() {
        if ($this->exists_right_son()) {
            $this->actualPosition = 2 * $this->actualPosition + 1;
            return $this->access_actual();
        }
        return null;
    }

    // non-standard method - the first found matching item is made accessible
    public function access_first($item) {        
        return $this->access($item, $this->items);
    }

    public function access_last($item) {
        return $this->access($item, array_reverse($this->items, true));
    } 

    // returns complete array, iterators (in/pre/posrt order) should be there  instead of this method
    public function get_items() {
        return $this->items;
    }

    private function is_empty() {
        return $this->get_item_count() == 0;
    }

    private function insert($index, $item) {
        $this->check_item($item);
        if ($index >= 0) {
            $this->items[$index] = $item;
            $this->itemCount++;
            ksort($this->items);
        }
    }
    
    private function delete($index) {
        $removed = $this->items[$index];
        unset($this->items[$index]);
        $this->itemCount--;
        return $removed;
    }
    
    private function access_actual() {
        return $this->items[$this->actualPosition];
    }

    private function access($item, $items) {
        $this->check_item($item);
        foreach ($items as $key => $value) {
            if (call_user_func(array($item, 'is_identical'), $item, $value)) {
            //if ($item::is_identical($item, $value)) {// PHP >= 5.2.3
                $this->actualPosition = $key;
                return $this->access_actual();
            }
        }
        return null;
    }

    private function is_left_son_leaf() {
        if ($this->exists_left_son()) {
            return $this->is_leaf(2 * $this->actualPosition);
        }
        return false;
    }
    
    private function is_right_son_leaf() {
        if ($this->exists_right_son()) {
            return $this->is_leaf(2 * $this->actualPosition + 1);
        }
        return false;
    }        

    private function exists_left_son() {
        return $this->exists_item(2 * $this->actualPosition);
    }

    private function exists_right_son() {
        return $this->exists_item(2 * $this->actualPosition + 1);
    }
    
    private function is_leaf($index) {
        return !$this->exists_item(2 * $index) && !$this->exists_item(2 * $index + 1);
    }
    
    private function exists_item($index) {
        return isset($this->items[$index]);
    }

    private function check_item($item) {
        if (!($item instanceof IBTreeItem)) {
            throw new PlayoffException(PlayoffException::EXC6);
        }
    }
    
    private function init_tree() {
        $this->items = array();
        $this->itemCount = 0;
        $this->actualPosition = 1;
    }

}

?>
