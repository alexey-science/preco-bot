<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/simple_html_dom.php";
/**
 * Created by PhpStorm.
 * User: monster
 * Date: 13.11.2016
 * Time: 13:59
 */
class Schedule
{

    private static $LINK_KOZV = "http://preco.ru/studentu/raspisanie-zanyatij/po-adresu-ul-kozhzavodskaya-1";
    private static $LINK_KOMR = "http://preco.ru/studentu/raspisanie-zanyatij/po-adresu-ul-komarovskogo-9a";

    private static function curl_start($link)
    {
        $ch = curl_init($link);

        curl_setopt($ch, CURLOPT_COOKIESESSION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36');
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_ENCODING, "");

        curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);



        $filename = curl_exec($ch);
        //Закрываем cURL-сессию
        curl_close($ch);
        //Закрываем дексриптор файла
        return $filename;
    }

    public static  function getLinkKozv(){
        return "http://preco.ru/images/stories/shedule1/znamenatel_c_14-19.11.xls";
    }

    /**
     * @return string
     */
    public static function getScheduleKozv(){
        $html = new simple_html_dom();
        $html->load_file(self::$LINK_KOZV);
        $a = $html->find("td[class=yau7q_shedule___file]",0)->find("a",0);
        return strval($a->href);
    }

    /**
     * @return string
     */
    public static function getScheduleKomr(){
        $html = new simple_html_dom();
        $html->load_file(self::$LINK_KOMR);
        $a = $html->find("td[class=yau7q_shedule___file]",0)->find("a",0);
        return strval($a->href);
    }

}