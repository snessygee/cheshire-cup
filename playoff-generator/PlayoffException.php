<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

/**
 * PlayoffException class
 * - extends standard Exception
 * - codes: 1, 2, 3, 4, 5, 6
 */
final class PlayoffException extends Exception {

    /** 
     * PlayoffGenerator - Invalid arguments for constructor
     * - Teams variable is not array 
     * - Team count is invalid, it must be power of two
     * - Maximum is MAX_TEAMS teams 
     * - All indexes must be integers. Index(key) determines seeded of the team
     */
    const EXC1 = 1;    
    /** PlayoffDuelParticipant - Seeded must be integer in PlayoffDuelParticipant */
    const EXC2 = 2;
    /** PlayoffDuelParticipant - Only PlayoffDuelParticipant instances can be compared with method compare. */
    const EXC3 = 3;
    /** PlayoffTree - parameter must be PlayoffGenerator */
    const EXC4 = 4;
    /** PlayoffTreePrintout - Not instance of PlayoffTree in constructor */
    const EXC5 = 5;
    /** BinaryTree - Binary tree item have to implements IBTreeItem */
    const EXC6 = 6;
    
    private static $exceptions = array();

    public function __construct($code) {
        parent::__construct('PlayoffException (' . self::$exceptions[$code] . ')', $code);
    }
    
    public static function init() {
        self::$exceptions = array(
            self::EXC1 => 'PlayoffGenerator - Invalid arguments for constructor',
            self::EXC2 => 'PlayoffDuelParticipant - Seeded must be integer in PlayoffDuelParticipant',
            self::EXC3 => 'PlayoffDuelParticipant - Only PlayoffDuelParticipant instances can be compared with method compare.',
            self::EXC4 => 'PlayoffTree - parameter must be PlayoffGenerator',
            self::EXC5 => 'PlayoffTreePrintout - Not instance of PlayoffTree in constructor',
            self::EXC6 => 'BinaryTree - Binary tree item have to implements IBTreeItem',
        );
    }
    
}
PlayoffException::init();

?>
