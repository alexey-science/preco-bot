<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/api/HttpQuery.php";
/**
 * Created by PhpStorm.
 * User: monster
 * Date: 26.10.2016
 * Time: 16:49
 */
class TelegramBot
{
    private $webhookUrl;
    private $token;

    /**
     * @param string $token
     * @param string $webhook
     */
    public function __construct($token, $webhook){
        $this->webhookUrl = $webhook;
        $this->token = $token;
    }

    /**
     * @param array $mes
     */
    public function sendMessage($mes){
        HttpQuery::apiRequest("sendMessage", $mes);
    }

    /**
     * @param array $mes
     */
    public function sendSticker($mes){
        HttpQuery::apiRequest("sendSticker", $mes);
    }

    /**
     * @param array $mes
     */
    public function sendPhoto($mes){
        HttpQuery::apiRequest("sendPhoto", $mes);
    }


    /**
     * @param array $mes
     */
    public function sendAudio($mes){
        HttpQuery::apiRequest("sendAudio", $mes);
    }

    /**
     * @param array $mes
     */
    public function sendVoice($mes){
        HttpQuery::apiRequest("sendVoice", $mes);
    }

    /**
     * @param array $mes
     */
    public function sendDocument($mes){
        HttpQuery::apiRequest("sendDocument", $mes);
    }

    public function setWebhook(){

    }

}