<!DOCTYPE html>

<?php
require("dbconfig.php");
require 'genelPhp/temel.php';
$title = 'Kayıtlar';

@session_start();

if (!isset($_SESSION['KullaniciAdi'])) {
   @header("Location:index.html");
}
?>

<html>

<head>

   <title><?= $title ?> | <?= $siteAdi ?> </title>
   <?php require 'eklentiler/bootstrap.php' ?>

   <?php require 'eklentiler/datatable.php' ?>

   <script>
      $(document).ready(function() {
         $('#myTable').DataTable({
            "order": [
               [4, "desc"]
            ],
            "language": {
               "sDecimal": ",",
               "sEmptyTable": "Tabloda herhangi bir veri mevcut değil",
               "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
               "sInfoEmpty": "Kayıt yok",
               "sInfoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
               "sInfoThousands": ".",
               "sLengthMenu": "Sayfada _MENU_ kayıt göster",
               "sLoadingRecords": "Yükleniyor...",
               "sProcessing": "İşleniyor...",
               "sSearch": "Ara:",
               "sZeroRecords": "Eşleşen kayıt bulunamadı",
               "oPaginate": {
                  "sFirst": "İlk",
                  "sLast": "Son",
                  "sNext": "Sonraki",
                  "sPrevious": "Önceki"
               },
               "oAria": {
                  "sSortAscending": ": artan sütun sıralamasını aktifleştir",
                  "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
               },
               "select": {
                  "rows": {
                     "_": "%d kayıt seçildi",
                     "1": "1 kayıt seçildi"
                  }
               }
            }
         });
      });
   </script>

</head>

<body>

   <?php
   $metin = "111";

   if (isset($_POST["id"])) {
      $silinecekID = $_POST["id"];
      $query = 'DELETE FROM kvkk WHERE kvkk.id = ' . $silinecekID;
      $data = $conn->query($query);

      $metin = "Kayıt başarılı şekilde silindi.";
      function_alert();
   }

   $query = 'SELECT * FROM kvkk';
   $data = $conn->query($query);
   if ($data->rowcount() > 0) {
      foreach ($data->fetchAll(PDO::FETCH_ASSOC) as $row) {
         $allDatas[] = $row;
      }
   }

   function function_alert()
   {
      echo '<script> $(document).ready(function(){ $("#myModal").modal("show"); }); </script>';
   }

   ?>

   <?php require 'genelHtml/adminnav.php' ?>

   <div class="card px-md-5">
      <div class="card-body">

         <h2>Tüm Kayıtlar</h2>

         <div class="table-responsive">
            <table id="myTable" class="display" style="width:100%">
               <thead>
                  <tr>
                     <th>Kod</th>
                     <th>İsim</th>
                     <th>Soyisim</th>
                     <th>E-posta</th>
                     <th>Tarih</th>
                     <th>Sil</th>
                  </tr>
               </thead>

               <tbody>
                  <?php foreach ($allDatas as $mesaj) { ?>
                     <tr>
                        <td><?php echo $mesaj["kod"]; ?></td>
                        <td><?php echo $mesaj["isim"]; ?></td>
                        <td><?php echo $mesaj["soyisim"]; ?></td>
                        <td><?php echo $mesaj["eposta"]; ?></td>
                        <td><?php echo $mesaj["tarih"]; ?></td>
                        <td>
                           <form action="" method="POST">
                              <input type="hidden" name="id" value="<?php echo $mesaj["id"]; ?>" />
                              <button type="submit" class="btn btn-danger">Kaydı Sil</button>
                           </form>
                           </a>
                        </td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>

      </div>
   </div>

   <div class="modal" id="myModal" tabindex="-1">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Uyarı</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p><?php echo $metin; ?></p>
            </div>
         </div>
      </div>
   </div>

   <?php require 'genelHtml/footer.php' ?>

</body>

</html>