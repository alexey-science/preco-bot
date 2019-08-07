<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/config/config.php";
/**
 * Created by PhpStorm.
 * User: monster
 * Date: 26.10.2016
 * Time: 16:59
 */
class HttpQuery
{
    /**
     * @param string $method
     * @param array $parameters
     * @return bool
     */
    public static function apiRequest($method, $parameters)
    {
        if (!is_string($method)) {
            error_log("Method name must be a string\n");
            return false;
        }

        if (!$parameters) {
            $parameters = array();
        } else if (!is_array($parameters)) {
            error_log("Parameters must be an array\n");
            return false;
        }

        // encoding to JSON array parameters, for example reply_markup
        foreach ($parameters as $key => &$val) {
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }
        $url = API_URL . $method . '?' . http_build_query($parameters);

        return file_get_contents($url)?true:false;
    }
}