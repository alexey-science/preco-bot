<?php
include_once  $_SERVER["DOCUMENT_ROOT"] . "/controller/handler/CommandHandler.php";
/**
 * Created by PhpStorm.
 * User: monster
 * Date: 26.10.2016
 * Time: 18:17
 */
class ParseMessage
{
    /**
     * @param array $message
     * @return string
     */
    public static function getTypeMessage($message){
       if(isset($message["text"])) {
           return "text";
       }elseif (isset($message["photo"])){
           return "photo";
       }elseif (isset($message["document"])){
           return "document";
       }elseif (isset($message["audio"])){
           return "audio";
       }elseif (isset($message["voice"])){
           return "voice";
       }elseif (isset($message["video"])){
           return "video";
       }elseif(isset($message["sticker"])){
           return "sticker";
       }else{
           return "undefined";
       }
    }

    public static function isReplyToMsg($message){
        return isset($message["reply_to_message"]);

    }


}