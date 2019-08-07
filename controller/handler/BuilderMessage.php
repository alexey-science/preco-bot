<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/handler/ParseMessage.php";
/**
 * Created by PhpStorm.
 * User: monster
 * Date: 29.10.2016
 * Time: 19:57
 */
class BuilderMessage
{


    /**
     * @param string $chat_id
     * @return string
     */
    private static function getAlis($chat_id){
        $alias = UserInfoEntity::getAliasByChatId($chat_id);
        if(count($alias) > 0){
            $usealias = $alias["alias_name"];

        }else{
            $usealias = "NLO";
        }
        return $usealias;

    }
    /**
     * @param array $message
     * @return array
     */
    public static function buildMsgText($message){
            $chat_id = $message["chat"]["id"];
            $res["chat_id"] = $chat_id;
            $usealias = self::getAlis($chat_id);
            $res["text"] = isset($message["text"])?$usealias . ": " . $message["text"]:"Undefined";

            return $res;
    }

    public static function buildMsgSticker($message){

        $res["chat_id"] =  $message["chat"]["id"];
        $res["sticker"] =  isset($message["sticker"])?$message["sticker"]["file_id"]:"1";

        return $res;
    }


    public static function buildMsgPhoto($message){
        $chat_id = $message["chat"]["id"];
        $usealias = self::getAlis($chat_id);
        $res["chat_id"] =  $chat_id;
        $res["photo"] =  isset($message["photo"])?$message["photo"][0]["file_id"]:"1";
        $res["caption"] = isset($message["caption"])?$message["caption"]:"";
        $res["caption"] = $usealias . ": " . $res["caption"];
        return $res;
    }

    public static function buildMsgAudio($message){
        $chat_id = $message["chat"]["id"];
        $usealias = self::getAlis($chat_id);
        $res["chat_id"] =   $chat_id;
        $res["audio"] =  isset($message["audio"])?$message["audio"]["file_id"]:"1";
        $res["duration"] =  isset($message["audio"])?$message["audio"]["duration"]:0;
        $res["performer"] =  isset($message["audio"])?$message["audio"]["performer"]:"";
        $res["title"] =  isset($message["audio"])?$message["audio"]["title"]:"";
        $res["caption"] = isset($message["caption"])?$message["caption"]:"";
        $res["caption"] = $usealias . ": " . $res["caption"];
        return $res;
    }


    public static function buildMsgVoice($message){
        $chat_id = $message["chat"]["id"];
        $usealias = self::getAlis($chat_id);
        $res["chat_id"] =   $chat_id;
        $res["voice"] =  isset($message["voice"])?$message["voice"]["file_id"]:"1";
        $res["duration"] =  isset($message["voice"])?$message["voice"]["duration"]:0;
        $res["caption"] = isset($message["caption"])?$message["caption"]:"";
        $res["caption"] = $usealias . ": " . $res["caption"];
        return $res;
    }

    public static function buildMsgDocument($message){
        $chat_id = $message["chat"]["id"];
        $usealias = self::getAlis($chat_id);
        $res["chat_id"] =  $chat_id;
        $res["document"] =  isset($message["document"])?$message["document"]["file_id"]:"1";
        $res["caption"] = isset($message["caption"])?$message["caption"]:"";
        $res["caption"] = $usealias . ": " . $res["caption"];

        return $res;
    }
}