<?php
/*
 * This file is part of the PHP Sports Generators (https://bitbucket.org/zdenekdrahos/php-sports-generators)
 * Copyright (c) 2012, 2013 Zdenek Drahos (https://bitbucket.org/zdenekdrahos)
 * PHP Sports Generators is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License 3, or any later version
 * For the full license information view the file license.txt, or <http://www.gnu.org/licenses/>.
 */

final class TournamentException extends Exception {

    /** TournamentGenerator - invalid count of periods */
    const EXC1 = 21;
    /** TournamentGenerator - invalid count of fields */
    const EXC2 = 22;
    /** TournamentGenerator - all groups must be instances of TournamentGroup */
    const EXC3 = 23;
    /** TournamentGenerator - at least two teams in each group */
    const EXC4 = 24;
    /** TournamentGenerator - groups must be array */
    const EXC5 = 25;

    private static $exceptions = array();

    public function __construct($code) {
        parent::__construct('TournamentException (' . self::$exceptions[$code] . ')', $code);
    }

    public static function init() {
        self::$exceptions = array(
            self::EXC1 => 'TournamentGenerator - invalid count of periods',
            self::EXC2 => 'TournamentGenerator - invalid count of fields',
            self::EXC3 => 'TournamentGenerator - all groups must be instances of TournamentGroup',
            self::EXC4 => 'TournamentGenerator - at least two teams in each group',
            self::EXC5 => 'TournamentGenerator - groups must be array',
        );
    }

}
TournamentException::init();
?>