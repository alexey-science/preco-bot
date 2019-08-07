<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/api/TelegramBot.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/handler/ParseMessage.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/handler/CommandHandler.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/handler/BuilderMessage.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/db/ConnectorDB.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/db/UserInfoEntity.php";
/**
 * Created by PhpStorm.
 * User: monster
 * Date: 26.10.2016
 * Time: 17:13
 */
class HandlerMessage
{
    private $bot;
    private $message;

    /**
     * HandlerMessage constructor.
     * @param TelegramBot $bot
     * @param array $message
     */
    public function __construct($bot, $message)
    {
        $this->bot = $bot;
        $this->message = $message;
    }

    private function sendPrivate($type,$resmes){
        if($type == "text"){
            $this->bot->sendMessage($resmes);
        }elseif ($type == "sticker"){
            $this->bot->sendSticker($resmes);
        }elseif ($type == "photo"){
            $this->bot->sendPhoto($resmes);
        }elseif ($type == "audio"){
            $this->bot->sendAudio($resmes);
        }elseif ($type == "voice"){
            $this->bot->sendVoice($resmes);
        }elseif ($type == "document"){
            $this->bot->sendDocument($resmes);
        }
    }

    private function sendBroadCast($type,$resmes){
        $chat_ids = UserInfoEntity::select_ChatId($resmes["chat_id"]);
        if(is_null($chat_ids)){
            $res["chat_id"] = $resmes["chat_id"];
            $res["text"] = "Bot: Попробуй отправить позже" ;
            $this->sendPrivate("text", $res);
        }else{

            foreach ($chat_ids as $item) {
                $resmes["chat_id"] = $item["chat_id"];
                $this->sendPrivate($type, $resmes);
            }
        }

    }
    public function adminExecute($message){
        $this->sendBroadCast("text", $message);
    }
    public function execute(){
        $type = ParseMessage::getTypeMessage($this->message);
        if($type == "text"){
            $isCmd = CommandHandler::isCommand($this->message);
            if ($isCmd){
                $response = CommandHandler::execCommand($this->message);
                $this->sendPrivate($type, $response);
            }else{
                $response = BuilderMessage::buildMsgText($this->message);
                $this->sendBroadCast($type, $response);
            }
        }elseif($type == "sticker"){
            $response = BuilderMessage::buildMsgSticker($this->message);
            $this->sendBroadCast($type, $response);
        }elseif($type == "photo"){
            $response = BuilderMessage::buildMsgPhoto($this->message);
            $this->sendBroadCast($type, $response);
        }elseif($type == "audio"){
            $response = BuilderMessage::buildMsgAudio($this->message);
            $this->sendBroadCast($type, $response);
        }elseif($type == "voice"){
            $response = BuilderMessage::buildMsgVoice($this->message);
            $this->sendBroadCast($type, $response);
        }elseif($type == "document"){
            $response=BuilderMessage::buildMsgDocument($this->message);
            $this->sendBroadCast($type, $response);
        }



    }


}