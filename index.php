<?php
require_once"vendor/autoload.php";
use \Carbon\Carbon;
$usr = new \App\Controller\UserController();

session_start();
if (empty($_SESSION['ipadd']) || empty($_SESSION['timeIP'])) {

  $_SESSION['ipadd'] = $usr->get_client_ip();
  $_SESSION['timeIP'] = Carbon::now('Asia/Jakarta');
  $usr->insertuser($_SESSION['ipadd'],$_SESSION['timeIP']);

}

if (!empty($_SESSION['timeIP']) && strtotime($_SESSION['timeIP']) + 1800 < Carbon::now('Asia/Jakarta')->timestamp) {
  session_unset();
  session_destroy();
  echo '
  <script>
  window.location.replace("'.BaseUrl.'");
  </script>
  ';
}
 ?>

 <!DOCTYPE html>
 <html lang="id">
   <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title></title>

     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

     <!--[if lt IE 9]>
       <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
       <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
     <![endif]-->
   </head>
   <body>
     <div class="container">
       <div class="row">
         <div class="col-md-2"></div>
         <div class="col-md-8">

           <h3 class="text-center">Online Statistik Dengan PHP</h3><br />
           <canvas id="myChart"></canvas><br />
           <h4 class="text-center">Pengunjung Dalam 24 Jam Terakhir</h4><br />
           <?php include_once"HariIni.php"; ?>
           <h4 class="text-center">Total Pengunjung</h4><br />
           <?php include_once"TotalPengunjung.php"; ?>

         </div>
         <div class="col-md-2"></div>
       </div>
     </div>


     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
     <script type="text/javascript">
     var BaseUrl = "<?=BaseUrl;?>"
     </script>
     <script src="<?=BaseUrl.'my.js';?>" type="text/javascript"></script>
   </body>
 </html>
