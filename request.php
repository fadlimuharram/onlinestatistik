<?php
require_once"vendor/autoload.php";
$usr = new \App\Controller\UserController();

if (isset($_GET['user'])) {

  if ($_GET['user']=='user24') {
    //mendapatkan pengunjung dalam 24 jam terakhir
    header('Content-Type: application/json');
    echo $usr->getuser24();
  }elseif ($_GET['user']=='ipnya') {
    echo $usr->get_client_ip();
  }elseif ($_GET['user']=='getday') {
    //mendapatkan 5 hari sebelumnya dari hari sekarang untuk chart
    header('Content-Type: application/json');
    echo $usr->getDay(5);
  }elseif ($_GET['user']=='getdata') {
    //mendapatkan Data 5 hari sebelumnya dari hari sekarang untuk chart
    header('Content-Type: application/json');
    echo $usr->getCountDay(5);
  }elseif ($_GET['user']=='totalpengunjung') {
    //mendapatkan Total pengunjung
    header('Content-Type: application/json');
    echo $usr->getalluser();
  }

}
 ?>
