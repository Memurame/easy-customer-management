<?php

use App\Entities\UserDetails;

if (! function_exists('current_page')) {

    /**
     * Prüft die AKtuelle Seite und gibt True oder False zurück
     *
     * @return string
     */
    function current_page(string $site, $exact = false)
    {

        $uri = service('uri');
        $uri_arr = $uri->getSegments();

        $target_arr = explode('/', $site);

        $target_arr = array_filter($target_arr);
        $target_arr = array_values($target_arr);

        if(!count($uri_arr) && empty($target_arr)){
            return true;
        }
        else{

            $return = true;
            if($exact){
                $firstArray = $uri_arr;
                $secondArray = $target_arr;
            } else{

                $firstArray = $target_arr;
                $secondArray = $uri_arr;

            }

            if(($exact && count($firstArray) != count($secondArray))
                OR empty($firstArray) OR empty($secondArray)
                OR (!$exact && count($firstArray) > count($secondArray))){
                return false;
            }

            foreach ($firstArray as $key => $val) {
                if($return AND $val == ':num' AND is_numeric($secondArray[$key]) ){
                    continue;
                }
                elseif ($return && $val != $secondArray[$key] )
                    $return = false;
            }


        }


        return $return;



    }
}

if (! function_exists('check_array')) {

    /**
     * Prüft den Wert eines Array
     *
     * @param $array
     * @param $key
     * @param $val
     * @return bool
     */
    function checkArray($array, $key, $val)
    {
        if (!$array)
            return false;
        foreach ($array as $item)
            if(is_object($item)){
                if (isset($item->{$key}) && $item->{$key} == $val)
                    return "TRUE";
            }
            else{
                if (isset($item[$key]) && $item[$key] == $val)
                    return true;
            }


        return "FALSE";
    }
}

if (! function_exists('createRandomPassword')) {

    /**
     * Zufälliges Passwort erstellen
     *
     * @param $lenght
     * @return string
     */
    function createRandomPassword($lenght = 8)
    {

        $alphabet = "abcdefghijkmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $lenght; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }
}

if (! function_exists('removeSpecialchar')) {

    /**
     * Zufälliges Passwort erstellen
     *
     * @param $lenght
     * @return string
     */
    function removeSpecialchar($string, $removeSpace = false)
    {
        $upas = Array("/" => "", "." => "", "-" => "", "'" => "");
        if($removeSpace) $upas = array_merge($upas, [" " => ""]);
        return strtr($string, $upas);
    }
}

if (! function_exists('convertExcelDateToUnix')) {

    function convertExcelDateToUnix($excelDate)
    {
        return ($excelDate - 25569) * 86400;
    }
}

if (! function_exists('composerInfo')) {

    function composerInfo()
    {
        $file = ROOTPATH . 'composer.json';
        $content = file_get_contents($file);
        return json_decode($content, true);
    }
}

if (! function_exists('profile')) {

    function profile($userId = false)
    {
        $userdetailModel = model('UserDetailsModel');
        if($userId){
            $userdetail = $userdetailModel->find($userId);
        } else {
            $userdetail = $userdetailModel->find(user_id());
        }

        if(!$userdetail){
            $userdetail = new UserDetails();
            $userdetail->user_id = auth()->id();
            $userdetailModel->save($userdetail);
        }
        return $userdetail;
    }
}

if (! function_exists('get_gravatar')) {

    function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}

if (! function_exists('new_messages')) {

    function new_messages() {
        return model('MessageModel')->getNewMessagesOfCurrentUser();
    }
}