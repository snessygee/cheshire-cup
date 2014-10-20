<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

/**
 * SeasonException class
 * - extends standard Exception
 * - codes: 11, 12, 13, 14, 15
 */
final class SeasonException extends Exception {

    /**
     * SeasonGenerator - Invalid arguments for constructor
     * - number of teams must be from <2, SEASON_MAX_TEAMS>
     * - teams cannot contain empty value (null, false, '')
     * - number of periods must be from <SEASON_MIN_PERIODS, SEASON_MAX_PERIODS>
     */
    const EXC1 = 11;
    /** SeasonGenerator - Schedule wasn\'t generated, cannot return SeasonSchedule */
    const EXC2 = 12;
    /** SeasonMatch - Team contains null (used for catching free matches in round) */
    const EXC3 = 13;
    /** SeasonPrintout - Not instance of SeasonSchedule */
    const EXC4 = 14;
    /** SeasonFieldsGenerator - invalid number of fields */
    const EXC5 = 15;

    private static $exceptions = array();

    public function __construct($code) {
        parent::__construct('SeasonException (' . self::$exceptions[$code] . ')', $code);
    }

    public static function init() {
        self::$exceptions = array(
            self::EXC1 => 'SeasonGenerator - Invalid arguments for constructor',
            self::EXC2 => 'SeasonGenerator - Schedule wasn\'t generated, cannot execute method',
            self::EXC3 => 'SeasonMatch - Team contains null (for catching free matches',
            self::EXC4 => 'SeasonPrintout - Not instance of SeasonGenerator',
            self::EXC5 => 'SeasonAdvancedGenerator - invalid number of fields'
        );
    }

}
SeasonException::init();
?>