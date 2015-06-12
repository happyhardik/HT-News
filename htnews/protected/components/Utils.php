<?php
/**
 * Class Utils
 * this class contains small utility functions
 */
class Utils {

    /**
     * truncates the given string by the given length and append the 'append' parameter at the end
     * @param $string
     * @param int $length
     * @param string $append
     * @return array|string
     */
    public function truncate($string,$length=255,$append="&hellip;") {
        $string = trim($string);

        if(strlen($string) > $length) {
            $string = wordwrap($string, $length);
            $string = explode("\n", $string, 2);
            $string = $string[0] . $append;
        }

        return $string;
    }
}