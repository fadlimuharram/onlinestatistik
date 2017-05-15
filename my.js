

$(document).ready(function() {
  getPengunjungDalam24();
  getallpengunjung();


//------------------------------------Sistem 24 jam ------------------------
  //---ambil 5 hari ke belakang
  var dataDaysJson = JSON.parse($.ajax({
    url: BaseUrl + 'request.php?user=getday',
    type: 'GET',
    dataType: "json",
    async: false
  }).responseText);

  var dataDaysArray = [];

  $.each(dataDaysJson,function(index, el) {
    dataDaysArray.push(el);
  });



  //---ambil data per hari selama 5 hari kebelakang
  var dataPerDayJson = JSON.parse($.ajax({
    url: BaseUrl + 'request.php?user=getdata',
    type: 'GET',
    dataType: "json",
    async: false
  }).responseText);

  var dataPerDayArray = [];

  $.each(dataPerDayJson,function(index, el) {
    dataPerDayArray.push(el);
  });

  var ctx = document.getElementById("myChart");
  var myChart = new Chart(ctx, {
     type: 'bar',
     data: {
         labels: dataDaysArray,
         datasets: [{
             label: 'Statistik Pengunjung Dalam 5 Hari',
             data: dataPerDayArray,
             backgroundColor: [
                 'rgba(255, 99, 132, 0.2)',
                 'rgba(54, 162, 235, 0.2)',
                 'rgba(255, 206, 86, 0.2)',
                 'rgba(75, 192, 192, 0.2)',
                 'rgba(153, 102, 255, 0.2)'
             ],
             borderColor: [
                 'rgba(255,99,132,1)',
                 'rgba(54, 162, 235, 1)',
                 'rgba(255, 206, 86, 1)',
                 'rgba(75, 192, 192, 1)',
                 'rgba(153, 102, 255, 1)'
             ],
             borderWidth: 1
         }]
     },
     options: {
         scales: {
             yAxes: [{
                 ticks: {
                     beginAtZero:true
                 }
             }]
         }
     }
   });

//------------------------------------End Sistem 24 jam ------------------------

//------------------------------------Sistem Per Malam--------------------------

var dataDaysJson2 = JSON.parse($.ajax({
  url: BaseUrl + 'request.php?user=gerdaypermidnight',
  type: 'GET',
  dataType: "json",
  async: false
}).responseText);

var dataDaysArray2 = [];

$.each(dataDaysJson2,function(index, el) {
  dataDaysArray2.push(el);
});



//---ambil data per hari selama 5 hari kebelakang
var dataPerDayJson2 = JSON.parse($.ajax({
  url: BaseUrl + 'request.php?user=getpermidnight',
  type: 'GET',
  dataType: "json",
  async: false
}).responseText);

var dataPerDayArray2 = [];

$.each(dataPerDayJson2,function(index, el) {
  dataPerDayArray2.push(el);
});

var ctx2 = document.getElementById("myChart2");
var myChart2 = new Chart(ctx2, {
   type: 'bar',
   data: {
       labels: dataDaysArray2,
       datasets: [{
           label: 'Statistik Pengunjung Dalam 5 Hari',
           data: dataPerDayArray2,
           backgroundColor: [
               'rgba(255, 99, 132, 0.2)',
               'rgba(54, 162, 235, 0.2)',
               'rgba(255, 206, 86, 0.2)',
               'rgba(75, 192, 192, 0.2)',
               'rgba(153, 102, 255, 0.2)'
           ],
           borderColor: [
               'rgba(255,99,132,1)',
               'rgba(54, 162, 235, 1)',
               'rgba(255, 206, 86, 1)',
               'rgba(75, 192, 192, 1)',
               'rgba(153, 102, 255, 1)'
           ],
           borderWidth: 1
       }]
   },
   options: {
       scales: {
           yAxes: [{
               ticks: {
                   beginAtZero:true
               }
           }]
       }
   }
 });

//------------------------------------End Sistem Per Malam--------------------------

});//end document ready



function getPengunjungDalam24(){
  $.ajax({
    url: BaseUrl + 'request.php?user=user24',
    type: 'GET',
    success: function(pesan){
      str = '';
      $.each(pesan,function(index, el) {
        str += '<tr>';
        str += '<td>' + (index + 1) + '</td>';
        str += '<td>' + el.ip + '</td>';
        str += '<td>' + el.hits + '</td>';
        str += '</tr>';
      });
      if (str != '') {
        $('#jika24kosong').hide();
        $('#bodytoday').html(str);
      }else {
        $('#jika24kosong').show();
        $('#jika24kosong').html("Data Kosong");
      }
    }
  });

}


function getallpengunjung(){
  $.ajax({
    url: BaseUrl + 'request.php?user=totalpengunjung',
    type: 'GET',
    success: function(pesan){
      str = '';
      $.each(pesan,function(index, el) {
        str += '<tr>';
        str += '<td>' + (index + 1) + '</td>';
        str += '<td>' + el.ip + '</td>';
        str += '<td>' + el.hits + '</td>';
        str += '</tr>';
      });
      if (str != '') {
        $('#jikaTotalkosong').hide();
        $('#bodytotalpengunjung').html(str);
      }else {
        $('#jikaTotalkosong').show();
        $('#jikaTotalkosong').html("Data Kosong");
      }
    }
  });

}
