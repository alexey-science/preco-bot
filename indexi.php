<?php
//include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/db/ConnectorDB.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/config/config.php";
/**
 * Created by PhpStorm.
 * User: monster
 * Date: 28.10.2016
 * Time: 13:43
 */


$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$mysqli->real_connect(HOST_DB, USER_DB, PASS_DB, NAME_DB, PORT_DB);
if($mysqli->connect_errno){
    echo ("Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    exit();
}
//echo $mysqli->query("INSERT INTO userinfo(chat_id, firstname, lastname, username) VALUES ('1', 'a','b','c')");

//
//
//if (!($stmt = $mysqli->prepare("INSERT INTO userinfo(chat_id, username, firstname, lastname) VALUES (?, ?, ?, ?)"))) {
//    echo "Не удалось подготовить запрос: (" . $mysqli->errno . ") " . $mysqli->error;
//}
//
//$chat_id = "222";
//$username ="Alex";
//$firstname = "al";
//$lastname = "kl";
//$stmt->bind_param("ssss", $chat_id,$username,$firstname,$lastname);
//
//if (!$stmt->execute()) {
//    echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
//}
//$stmt->close();


//echo $mysqli->query("INSERT INTO userinfo(chat_id, username, firstname, lastname) VALUES ('123', 'test', 'test', 'test')");
//echo $mysqli->query("DELETE FROM userinfo WHERE chat_id = '0'");

//echo $mysqli->query("ALTER TABLE userinfo  ADD COLUMN `alias_name` text");
//echo $mysqli->query("UPDATE userinfo SET alias_name = CONCAT(\"Admin\",id) WHERE id = 21");
//echo $mysqli->query("UPDATE userinfo SET alias_name = CONCAT(\"Admin\") WHERE id = 21");

//echo $mysqli->query("INSERT INTO userinfo(chat_id, username, firstname, lastname, alias_name) VALUES ('0', 'Bot', 'Bot', 'Bot','Bot')");
$res = $mysqli->query("SELECT * FROM userinfo");
while($row = $res->fetch_assoc()){
echo var_dump($row) . "</br>";
}
