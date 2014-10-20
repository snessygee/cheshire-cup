<?php

class Functions {

    public static function is_power_of_two($number) {
        if (is_int($number) && $number >= 2) {
            return ($number & ($number - 1)) == 0;
        }
        return false;
    }

}

?>
