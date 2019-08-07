<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/config/config.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/api/TelegramBot.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/handler/HandlerMessage.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/handler/CommandHandler.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/Utils.php";

if (isset($_GET["sendNotice"])){
    $message["chat_id"] =  0;
    $message["text"] = "Bot: Ох вей, ребята. Нью фичи вам запилил.\n1. Расписание колледжа на Кожзаводской можно смотреть в чате Бота";
    $message["reply_markup"] = CommandHandler::get_StartMenu();
    $bot = new TelegramBot(BOT_TOKEN, WEBHOOK_URL);
    $handler = new HandlerMessage($bot,$message);
    $handler->adminExecute($message);
}