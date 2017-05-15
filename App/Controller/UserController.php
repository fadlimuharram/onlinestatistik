<?php
namespace App\Controller;
use \App\Model\User;
use \Carbon\Carbon;

class UserController{

  //mendapatkan pengunjung dalam 24 jam terakhir
  function getuser24(){
    $user24 = User::selectRaw('id, ip, count(ip) as hits')
                    ->where('created_at','<',Carbon::now('Asia/Jakarta'))
                    ->where('created_at','>',Carbon::now('Asia/Jakarta')->subDay(1))
                    ->groupBy('ip')
                    ->orderBy('id','desc')
                    ->limit(25)
                    ->get()
                    ->toJson();
    return $user24;
  }


  //mendapatkan total pengunjung
  function getalluser(){
    $users = User::selectRaw('id, ip, count(ip) as hits')
                    ->groupBy('ip')
                    ->orderBy('id','desc')
                    ->limit(50)
                    ->get()
                    ->toJson();
    return $users;
  }



  //fungsi untuk membuat 5 hari kebelakang pada chart posisi (x) dengan sistem 24 jam
  function getDay_x($berapahari){
    $hari = [];
    for ($i=$berapahari-1; $i >= 0; $i--) {
      $hari[$i] = Carbon::now('Asia/Jakarta')->subDay($i)->diffForHumans();
      if ($hari[$i] == "1 second ago") {
        $hari[$i] = "Within 24 hours";
      }
    }
    return json_encode($hari);
  }

  //fungsi untuk menghitung berapa jumlah user per hari, di loop selama 5 hari kebelakang dengan sistem 24 jam dari sekarang
  function getCountDay($berapahari){
    $hitung = [];
    for ($i=$berapahari-1; $i >= 0 ; $i--) {
      $hitung[$i] = User::where('created_at','<',Carbon::now('Asia/Jakarta')->subDay($i))
                    ->where('created_at','>',Carbon::now('Asia/Jakarta')->subDay($i+1))
                    ->count();
    }

    return json_encode($hitung);

  }

  //fungsi untuk menghitung berapa jumlah user per hari, di loop selama 5 hari kebelakang dengan sistem per malam
  function getCountDayPerMidnight($berapahari){
    $hitung = [];
    //untuk mendapatkan hari sebelumnya
    for ($i=$berapahari-2; $i >= 0 ; $i--) {
        $midnightHariIni = Carbon::now('Asia/Jakarta')->subDay($i)->secondsSinceMidnight();
        $midnightKemarin = Carbon::now('Asia/Jakarta')->subDay($i+1)->secondsSinceMidnight();
        $hitung[$i+1] = User::where('created_at','<',Carbon::createFromTimestamp(Carbon::now('Asia/Jakarta')->subDay($i)->timestamp - $midnightHariIni)->toDateTimeString())
                          ->where('created_at','>=',Carbon::createFromTimestamp(Carbon::now('Asia/Jakarta')->subDay($i+1)->timestamp - $midnightKemarin))
                          ->count();
    }
    //untuk mendapatkan hari ini
    $midnight = Carbon::now('Asia/Jakarta')->secondsSinceMidnight();
    $hariini = User::where('created_at','>=',Carbon::createFromTimestamp(Carbon::now('Asia/Jakarta')->timestamp - $midnight)->toDateTimeString())
                      ->where('created_at','<',Carbon::now('Asia/Jakarta'))
                      ->count();

    $hitung[0] = $hariini;
    return json_encode($hitung);
  }


  //fungsi untuk membuat 5 hari kebelakang pada chart posisi (x) dengan sistem per malam
  function getCountDayPerMidnight_x($berapahari){
    $hari = [];
    for ($i=$berapahari-1; $i >= 0; $i--) {
      $hari[$i] = Carbon::now('Asia/Jakarta')->subDay($i)->format('l jS \\of F Y');
    }
    return json_encode($hari);
  }


  function get_client_ip() {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
         $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
  }

  function insertuser($ip,$waktu){
    $usr = new User;
    $usr->ip = $ip;
    $usr->created_at = $waktu;
    $usr->save();

  }

}
