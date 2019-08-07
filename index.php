<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/controller/api/Schedule.php";
if (isset($_GET["schedule"])){
    if(isset($_GET["kozv"])){
        echo Schedule::getScheduleKozv();
    }elseif (isset($_GET["komr"])){
        echo Schedule::getScheduleKomr();
    }
}else{
    echo "привет";
}