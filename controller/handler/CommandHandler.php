<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/db/UserInfoEntity.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/Utils.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/api/Schedule.php";
/**
 * Created by PhpStorm.
 * User: monster
 * Date: 26.10.2016
 * Time: 19:00
 */
class CommandHandler
{

    private static $cmdList = array( Utils::START_CMD, Utils::SETALIAS_CMD, Utils::SCHEDULE_CMD, Utils::PS_CMD, Utils::HELP_CMD);
    private static $btnList = array(Utils::SCHEDULE_COLLEGE_BTN);
    private static $aliasConst = array("Лев", "Тигр", "Волк","Лев");
    private static $aliasListM = array( "Лев"=>"Лев", "Тигр"=>"Тигр", "Волк"=>"Волк");
    private static $aliasListF = array( "Лев"=>"Львица", "Тигр"=>"Тигрица", "Волк"=>"Волчица");

    /**
     * @return array
     */
    public static function getCmdList(){
        return self::$cmdList;
    }


    /**
     * @return array
     */
    public static function getBtnList(){
        return self::$btnList;
    }

    /**
     * @param array $message
     * @return bool
     */
    public static function isCommand($message){
        $text = explode(' ',$message['text']);
        $text = strtolower($text[0]);
        $arrCmd =  self::$cmdList;
        $arrBtn =  self::$btnList;
        return  in_array($text,$arrCmd) || in_array($message['text'], $arrBtn);
    }

    private static function getText($message){
        $text = $message['text'];
        if(in_array($text, self::$btnList)){
            return $text;
        }else{
            $text = explode(' ',$text);
            $text = strtolower($text[0]);
            return $text;
        }
    }
    public static function execCommand($message){
        $text = self::getText($message);
        if($text == Utils::START_CMD){
            return self::startCommand($message);
        }elseif($text == Utils::SETALIAS_CMD){
            return self::setAliasCommand($message);
        }elseif($text == Utils::SCHEDULE_COLLEGE_BTN){
            return self::getKorpus($message);
        }elseif($text == Utils::SCHEDULE_CMD){
            return self::getScheduleLink($message);
        }elseif ($text == Utils::PS_CMD){
            return self::psCommand($message);
        }elseif ($text == Utils::HELP_CMD){
            return self::helpCommand($message);
        }
    }

    private static function psCommand($message){
        $chat_id = $message['chat']['id'];
        $ar = explode(" ", $message['text']);
        $text = "Netu";
        $res = array();
        $rows = array();
        if($ar[1] == 1){
            $dataid = $ar[2];
            $rows[] = array(array("text" => "Понедельник", "callback_data"=>'/ps 2 ' . $dataid . '|1'),
                        array("text" => "Вторник", "callback_data"=>'/ps 2 ' . $dataid . '|2'));

            $rows[] = array(array("text" => "Среда", "callback_data"=>'/ps 2 ' . $dataid . '|3'),
                array("text" => "Четверг", "callback_data"=>'/ps 2 ' . $dataid . '|4'));

            $rows[] = array(array("text" => "Пятница", "callback_data"=>'/ps 2 ' . $dataid . '|5'),
                array("text" => "Суббота", "callback_data"=>'/ps 2 ' . $dataid . '|6'));

            $text = "Bot: Выбери день";
            $res["reply_markup"] = array("inline_keyboard" => $rows);
        }elseif ($ar[1] == 2){
            $days = array("Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота");
            $data = explode("|", $ar[2]);
            $gid = $data[0];
            $did = $data[1];
            $text = "";
            $link = file_get_contents("http://precoschedule.azurewebsites.net/?koz&groupid=" . $gid . "&day=" . $did);
            $subinfo = json_decode($link, true);
            $text .= $subinfo[0]["group_name"] . " - " . $days[$did-1] . "\n";

            foreach ($subinfo as $item){
                $text .= $item['num'] . ". " . $item["name"] . " - " . $item["room"] . " \n";
            }
            $res["reply_markup"] = self::get_StartMenu();
        }
        $res["chat_id"] = $chat_id;
        $res["text"] = $text;
        return  $res;
    }

    private static function getScheduleLink($message){
        $chat_id = $message['chat']['id'];
        $ar = explode(" ", $message['text']);
        $numKorpus = $ar[1];
        $link = "No schedule";
        $res =  array();

        $inlineKB = array();
        if($numKorpus == 1){
           $link = file_get_contents("http://precoschedule.azurewebsites.net/?koz&grouplist");
            $textarr = json_decode($link, true);
            foreach ($textarr as $item){
                $rows = array(array("text" => $item["name"], "callback_data"=>'/ps 1 ' . $item['id']));
                $inlineKB[] =  $rows;
            }
            $res["text"] = "Bot: Выбери группу";
            $res["reply_markup"] = array("inline_keyboard" => $inlineKB);
        }elseif($numKorpus == 2){
           $link = file_get_contents("http://precobot.azurewebsites.net/?schedule&komr");;
            $res["text"] = "Bot: " . $link;
        }
        $res["chat_id"] = $chat_id;
        return $res;

    }

    private static function startCommand($message){
        $chat_id = $message["chat"]["id"];
        $username = isset($message["chat"]["username"])?$message["chat"]["username"]:"No user name";
        $firstname = isset($message["chat"]["first_name"])?$message["chat"]["first_name"]:"No first name";
        $lastname = isset($message["chat"]["last_name"])?$message["chat"]["last_name"]:"No last name";
        $aliasname = "NoAlias";
        if(!UserInfoEntity::insert_prepare(array("chat_id"=>$chat_id, "username"=> $username, "firstname"=>$firstname, "lastname"=>$lastname, "aliasname"=>$aliasname))){
            $res = array();
            $res["text"] = "Попробуй отправить команду /start позже";
            $res["chat_id"] = $chat_id;
            return $res;
        }
        $rk = array_rand(self::$aliasConst);
        $alias = self::$aliasConst[$rk];
        $aliasM = self::$aliasListM[$alias];
        $aliasF = self::$aliasListF[$alias];
        $res = array();
        $res["text"] = "Отлично, теперь ты будешь получать все новости \"Подслушано КПиЭ и ЮУИУиЭ\", ты тоже можешь сюда писать.\nТвои сообщения будут отправлены полностью анонимно";
        $res["text"] .= "\nВыбери подходящий для себя псевдоним";
        $res["chat_id"] = $chat_id;
        $inlineKB = array(array(array("text"=>$aliasM, "callback_data"=>"/setalias " . $aliasM), array("text"=>$aliasF, "callback_data"=>"/setalias " . $aliasF)));
        $res["reply_markup"] = array("inline_keyboard" => $inlineKB);
        return $res;

    }

    public static function get_StartMenu(){
        return array(
            'keyboard' => array(array(Utils::SCHEDULE_COLLEGE_BTN)),
            'one_time_keyboard' => true,
            'resize_keyboard' => true);
    }

    private static function setAliasCommand($message){
        $chat_id = $message["chat"]["id"];
        $alias = explode(" ", $message["text"]);
        $alias = $alias[1];

        $res["chat_id"] = $chat_id;
        if(UserInfoEntity::update_alis($chat_id,$alias)){
            $res["text"] = "Отлично твой псевдоним установлен";
        }else{
            $res["text"] = "Произошла ошибка попробуй позже";
        }
        $res["reply_markup"] = self::get_StartMenu();
        return $res;
    }

    private static function helpCommand($message){
        $chat_id =  $message["chat"]["id"];
        $res["chat_id"] = $chat_id;
        $res["text"] = "Привет. С помощью этого бота можно узнать расписание. :)";
        $res["reply_markup"] = self::get_StartMenu();
        return $res;
    }


    private static function getKorpus($message){
        $chat_id =  $message["chat"]["id"];
        $res["chat_id"] = $chat_id;
        $res["text"] = "Bot: Выбери корпус 🏢 ";
        $inlineKB = array(array(array("text"=>"Кожзаводская 1", "callback_data"=>"/schedule 1"), array("text"=>"Комаровского 9а", "callback_data"=>"/schedule 2")));
        $res["reply_markup"] = array("inline_keyboard" => $inlineKB);
        return $res;
    }

}