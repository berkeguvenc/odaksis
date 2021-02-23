<!doctype html>

<?php
require("dbconfig.php");
require 'genelPhp/temel.php';

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

?>
<html>

<head>
   <?php require 'eklentiler/bootstrap.php' ?>

   <title>KVKK ONAY</title>
   <meta charset="utf-8">

</head>

<body>
   <?php
   $metin = "111";

   date_default_timezone_set('Europe/Istanbul');

   $tarihsaat = date("Y-m-d H:i:s");
   $tarih = date("Y-m-d");
   $saat = date("H:i:s");
   $kod = substr(uniqid(), 3, 10);

   if (isset($_POST["myButton"])) {

      $eposta = htmlspecialchars(trim($_POST['eposta']));
      $tamisim = htmlspecialchars(trim($_POST['isim'] . " " . $_POST['soyisim']));
      /*
      $kontrol = $conn->query("SELECT * FROM kvkk WHERE eposta='{$_POST['eposta']}' ");
      if ($kontrol->rowCount() == "0") {
         */
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = 'localhost';
         $mail->SMTPAuth = false;
         $mail->SMTPAutoTLS = false;
         $mail->Port = 25;

         $mail->Username = 'info@odaksis.com';
         $mail->Password = '**********';
         $mail->SMTPSecure = false;
         $mail->isHTML(true);
         $mail->CharSet = "UTF-8";
         $mail->setLanguage('tr', 'language/');
         //$mail->SMTPDebug  = 2; //Hata ayıklama yorumu için aç
         $mail->setFrom('info@odaksis.com', 'Info Odaksis');
         $mail->addAddress('alialbayrak@odaksis.com', 'Ali Albayrak');
         $mail->Subject = 'KVKK Onay bildirimi';
         $mail->Body = "
            <html>
            <body>
              <p>$tamisim, $tarih tarihinde, saat $saat'da $eposta e-posta adresini paylaşarak KVKK metnini okuyup onaylamıştır. Müşteri kodu: $kod</p>
            </body>
            </html>
            ";

         $mail_gonder = $mail->send();
         if ($mail_gonder) {
            $query = "INSERT INTO `kvkk` (`id`, `isim`, `soyisim`, `eposta`, `tarih`, `kod`) 
                VALUES (NULL, '" . $_POST['isim'] . "', '" . $_POST['soyisim'] . "', '" . $_POST['eposta'] . "', '" . $tarihsaat . "', '" . $kod . "')";
            $data = $conn->query($query);
            $metin = "Başarılı şekilde onay verdiniz.";
            function_alert();
         } else {
            $metin = "Bir hata oluştu!";
            function_alert();
            echo "<script>console.log('Debug Objects: " . $mail->ErrorInfo . "' );</script> ";
         }
      } else {
         /*$metin = "Daha önce onay verdiniz!";
         function_alert();*/
      }
   /*}*/

   function function_alert()
   {
      echo '<script> $(document).ready(function(){ $("#myModal").modal("show"); }); </script>';
   }

   ?>

   <main class="container">
      <div class="overflow-auto bg-light p-5 rounded" style="max-height: 400px;">
         <h1>KVKK ONAYI</h1>

         <p><strong>KİŞİSEL VERİLERİN KORUNMASINA İLİŞKİN AYDINLATMA METNİ</strong>&nbsp;</p>
         <p>Değerli Katılımcımız,&nbsp;</p>
         <p><strong>Kantar Insights Pazar Araştırmaları Danışmanlık ve Ticaret A.Ş. (</strong>&ldquo;<strong>Kantar</strong>&rdquo; veya &ldquo;<strong>Şirket</strong>&rdquo;) b&uuml;nyesinde verilerinizin gizliliğini olduk&ccedil;a &ouml;nemsemekteyiz. Bu kapsamda, 6698 sayılı Kişisel Verilerin Korunması Kanunu&rsquo;nda (&ldquo;<strong>KVKK</strong>&rdquo;) d&uuml;zenlenen &ldquo;Veri Sorumlusunun Aydınlatma Y&uuml;k&uuml;ml&uuml;l&uuml;ğ&uuml;&rdquo; başlıklı 10. madde ile &ldquo;İlgili Kişinin Hakları&rdquo; başlıklı 11. madde &ccedil;er&ccedil;evesinde; kişisel verileriniz ile &ouml;zel nitelikli kişisel verilerinizin (&ldquo;<strong>T&uuml;m Kişisel Verileriniz</strong>&rdquo;) hangi ama&ccedil;la işleneceği, işlenen T&uuml;m Kişisel Verileriniz&rsquo;in kimlere ve hangi ama&ccedil;la aktarılabileceği, T&uuml;m Kişisel Verileriniz&rsquo;in toplanmasının y&ouml;ntemi ve hukuki sebebi ile KVKK&rsquo;nın 11. maddesinde sayılan diğer haklarınızla ilgili olarak sizleri veri sorumlusu sıfatıyla bilgilendirmek ve aydınlatmak amacıyla işbu aydınlatma metnini (&ldquo;<strong>Aydınlatma Metni</strong>&rdquo;) bilginize sunmaktayız.</p>
         <p>&Ccedil;alışmalarımıza katılımınızın her daim g&ouml;n&uuml;ll&uuml;k esasına dayandığını bir kez daha hatırlatmak isteriz. &Ccedil;alışmanın objektif olarak yapılabilmesi amacıyla, &ccedil;alışmayı adına y&uuml;r&uuml;tt&uuml;ğ&uuml;m&uuml;z m&uuml;şterimizin bilgileri ilgili mevzuattan doğan y&uuml;k&uuml;ml&uuml;l&uuml;klerimizin yerine getirilmesi ve sizleri aydınlatmak amacıyla tarafınıza &ccedil;alışma sonrasında ayrıca sunulacaktır. Aydınlatma Metni&rsquo;nde belirtilen hususlara ilişkin herhangi bir sorunuz olması halinde aşağıdaki 5. maddede yer verdiğimiz iletişim kanallarından ilettiğiniz takdirde sorularınızı ayrıntılı bir şekilde cevaplamaktan memnuniyet duyacağımızı belirtir ve işbu belgede yer alan bilgi ve koşulları uygun bulmamanız halinde &ccedil;alışmaya katılmamanızı rica ederiz.</p>
         <ol>
            <li><strong>Veri Sorumlusunun Kimliği</strong></li>
         </ol>
         <p>&Ccedil;alışma kapsamında veri sorumlusu; tescilli merkezi Astoria Alışveriş Merkezi B&uuml;y&uuml;kdere Cad. No:127 Kat:1 Şişli, İstanbul/T&uuml;rkiye adresinde bulunan, İstanbul Ticaret Sicili M&uuml;d&uuml;rl&uuml;ğ&uuml; nezdinde 446493 sicil numarası ile kayıtlı ve 0621057396400001 MERSİS numaralı Kantar Insights Pazar Araştırmaları ve Danışmanlık Anonim Şirketi&rsquo;dir.</p>
         <ol start="2">
            <li><strong>Kişisel Verilerinizin İşlenme Ama&ccedil;ları</strong></li>
         </ol>
         <p>Kişisel verilerinizi KVKK&rsquo;nın 5. maddesi uyarınca a&ccedil;ık rızanıza yahut istisnalara dayalı olarak, &ouml;zel nitelikli kişisel verilerinizi ise KVKK&rsquo;nın 6. maddesi uyarınca yalnızca a&ccedil;ık rızanıza dayalı olarak ve başta KVKK&rsquo;nın 4. maddesinde belirtilenler olmak &uuml;zere mevzuatta &ouml;ng&ouml;r&uuml;len usul ve esaslara ve ayrıca Kişisel Verileri Koruma Kurulu (&ldquo;<strong>Kurul</strong>&rdquo;) tarafından belirlenen yeterli &ouml;nlemlere uygun şekilde aşağıdaki ama&ccedil;larla işleyebiliriz:</p>
         <ul>
            <li><strong>&Ccedil;alışmanın yapılabilmesi: </strong>&Ccedil;alışmayı adına y&uuml;r&uuml;tt&uuml;ğ&uuml;m&uuml;z m&uuml;şterimize taahh&uuml;t ettiğimiz araştırma faaliyetlerinin periyodik bazda ve/veya toplu olarak ger&ccedil;ekleştirilebilmesi, araştırma sonu&ccedil;larının analiz edilerek rapor haline getirilmesi, saha &ccedil;alışma merkezlerimiz tarafından saha &ccedil;alışmalarının y&uuml;r&uuml;t&uuml;lebilmesi, katılımcıların &ccedil;alışma kriterlerine uygunluğunun değerlendirilebilmesi, &ccedil;alışma kapsamında katılımcılarla iletişime ge&ccedil;ilmesi ve kendilerine s&uuml;rece dair bilgiler verilmesi, kendilerinden bilgi edinilmesi,</li>
            <li><strong>Şirket i&ccedil;erisinde kalite kontrol&uuml; s&uuml;recinin y&uuml;r&uuml;t&uuml;lmesi:</strong> &Ccedil;alışmalara ilişkin geriye d&ouml;n&uuml;k kalite kontrollerinin ger&ccedil;ekleştirilmesi, anket&ouml;rlere ve saha &ccedil;alışma merkezine ilişkin kalite kontrollerinin ger&ccedil;ekleştirilmesi, kalite kontrol&uuml; ama&ccedil;lı geri aramaların ger&ccedil;ekleştirilmesi, Şirket i&ccedil;i s&uuml;re&ccedil;lerin denetimi, yeni hizmet se&ccedil;enekleri geliştirme, tahmini veri modelleri oluşturma, katılımcı eğilimlerini tespit etme, uyguladığımız y&ouml;ntemlerin etkinliğini &ouml;l&ccedil;me, hizmetlerimizi ve s&uuml;re&ccedil;lerimizi iyileştirmek amacıyla araştırma ve geliştirme,</li>
            <li><strong>&Ccedil;alışmalara ilişkin geriye d&ouml;n&uuml;k kalite kontrollerinin ger&ccedil;ekleştirilmesi</strong>,</li>
            <li><strong>&Ccedil;alışmalar esnasında toplanan g&ouml;r&uuml;nt&uuml; ve işitsel kayıtların &ouml;rnek &ccedil;alışma teşkil etmesi adına T&uuml;rkiye Araştırmacılar Derneği (&ldquo;T&Uuml;AD&rdquo;) konferanslarında sunulması</strong>,</li>
            <li><strong>Şirket tesislerinde g&uuml;venliğin sağlanabilmesi</strong>,</li>
            <li><strong>T&uuml;m Kişisel Verileriniz ile ilişkili bir ihtilafta Kantar&rsquo;ın haklarının korunması,</strong></li>
            <li><strong>Kantar&rsquo;ın mevzuattan doğan &ccedil;eşitli hukuki y&uuml;k&uuml;ml&uuml;l&uuml;klerinin yerine getirilmesi</strong>.</li>
         </ul>
         <p>Kişisel verilerinizi yukarıda belirtilenler dışında herhangi bir ama&ccedil; i&ccedil;in işlememiz gerektiği takdirde size bu hususta &ouml;nceden bilgi verecek ve mevzuat uyarınca gerekli olduğu takdirde a&ccedil;ık rızanızı talep edeceğiz.<strong><em>&nbsp;</em></strong></p>
         <ol start="3">
            <li><strong>Toplanan Kişisel Veriler, Toplamanın Y&ouml;ntemi ve Hukuki Sebebi</strong></li>
         </ol>
         <p>Aydınlatma Metni&rsquo;nde belirtilen ama&ccedil;lar doğrultusunda;</p>
         <ul>
            <li><strong>Kimlik Bilgilerinizi:</strong> Adınızı, soyadınızı, cinsiyetinizi (KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>İletişim Bilgilerinizi:</strong> Telefon numaranızı, e-posta adresinizi (KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Mesleki Bilgilerinizi:</strong> Eğitim bilgilerinizi, mesleki deneyim bilgilerinizi, &ouml;zl&uuml;k bilgilerinizi (KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Dernek ve Vakıf &Uuml;yelik Bilgilerinizi</strong> (KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Biyometrik Verilerinizi:</strong> G&ouml;r&uuml;nt&uuml; kayıtlarınızı, ses kayıtlarınızı, analiz edilebilir g&ouml;r&uuml;nt&uuml; kayıtlarınızı (&ldquo;Facial Coding&rdquo; verilerinizi) (KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Siyasi G&ouml;r&uuml;ş ve D&uuml;ş&uuml;nce Bilgilerinizi</strong> (KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Sağlık Bilgilerinizi:</strong> Hastalık ge&ccedil;mişiniz, sağlık durumunuza ilişkin bilgileri (KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Kılık Kıyafet Bilgilerinizi:</strong> Kılık kıyafet tercihlerinizi (KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>&Ccedil;eşitli Tercih/Alışkanlık Bilgilerinizi:</strong> T&uuml;ketim, satın alma, gezinti/seyahat alışkanlıklarınızı ve hayat tarzınıza ilişkin bilgilerinizi (KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Ekonomik Bilgilerinizi:</strong> Kişisel gelir-gider bilgilerinizi (KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Aile Bilgilerinizi:</strong> Medeni durumunuzu, &ccedil;ocuk sayınızı, hane halkı gelir-gider bilgileriniz ile aile &uuml;yelerinize ilişkin olarak yukarıda sayılan diğer bilgileri (kişisel veri olmaları durumunda KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak, &ouml;zel nitelikli kişisel veri olmaları durumunda KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak)</li>
         </ul>
         <p>size sunduğumuz anket formlarına cevap verilmesi, &uuml;&ccedil;&uuml;nc&uuml; kişilerden a&ccedil;ık rızanız doğrultusunda elde edilmesi veya tarafınızca doğrudan sağlanması suretiyle yahut kamera kayıtları vasıtasıyla otomatik ya da otomatik olmayan yollarla topluyor ve mevzuat uyarınca &ouml;ng&ouml;r&uuml;len esas ve usullere uygun şekilde işliyoruz.</p>
         <ol start="4">
            <li><strong>Kişisel Verilerinizin Kimlere ve Hangi Ama&ccedil;larla Aktarılacağı</strong></li>
         </ol>
         <p>KVKK&rsquo;nın 8. maddesi uyarınca yurt i&ccedil;inde, 9. maddesi uyarınca ise yurt dışında; kişisel verilerinizi a&ccedil;ık rızanıza yahut istisnalara, &ouml;zel nitelikli kişisel verilerinizi ise yalnızca a&ccedil;ık rızanıza dayalı olmak &uuml;zere, başta KVKK olmak &uuml;zere mevzuatta &ouml;ng&ouml;r&uuml;len usul ve esaslara ve ayrıca Kurul kararlarına uygun şekilde, yukarıdaki 3. maddede ayrıntılarına yer verdiğimiz;</p>
         <ul>
            <li><strong>Kimlik bilgilerinizi, iletişim bilgilerinizi, mesleki bilgilerinizi, dernek ve vakıf &uuml;yelik bilgilerinizi, felsefi inan&ccedil;, din, mezhep ve diğer inan&ccedil; bilgilerinizi, cinsel hayat bilgilerinizi, biyometrik verilerinizi, siyasi g&ouml;r&uuml;ş ve d&uuml;ş&uuml;nce bilgilerinizi, sağlık bilgilerinizi, kılık ve kıyafet bilgilerinizi, &ccedil;eşitli tercih/alışkanlık bilgilerinizi, ekonomik bilgilerinizi ve aile bilgilerinizi;</strong>
               <ul>
                  <li>Raporlama gibi i&ccedil; idari s&uuml;re&ccedil;leri y&uuml;r&uuml;tebilmek amacıyla, Kantar&rsquo;ın yurt dışı iştiraklerine, sunuculara yahut Kantar UK Secure File Sistemi&rsquo;ne y&uuml;klemek suretiyle, KVKK md. 9/1 uyarınca a&ccedil;ık rızanıza dayalı olarak,</li>
                  <li>&Ccedil;alışma faaliyetlerinin ger&ccedil;ekleştirilebilmesi i&ccedil;in &ccedil;alışmayı sahada aktif olarak y&uuml;r&uuml;tebilmeleri amacıyla, Şirket&rsquo;ten bağımsız olup &ccedil;alışma kapsamında Şirket yararına hareket etmekte olan Kantar TR firmasına tanımlı saha &ccedil;alışma merkezlerimize, Outlook uygulaması &uuml;zerinden e-posta yoluyla g&ouml;ndermek ya da WeTransfer uygulamasına y&uuml;klemek suretiyle, KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak,</li>
                  <li>&Ccedil;alışma faaliyetlerinin ger&ccedil;ekleştirilebilmesi amacıyla, kullandığımız Outlook, Fileserver, Dimensions, NIPO, CATI Server, CAWI Server, Web Konferans Uygulamaları adlı uygulamaların sahibi olan şirketlere, yalnızca gerekli olduğu durumlarda ve gerektiği &ouml;l&ccedil;&uuml;de, bu uygulamaları kullanmak suretiyle (<em>uygulamaların sunucularının bulunduğu &uuml;lkeler: İngiltere, Hollanda, Bel&ccedil;ika ve Amerika Birleşik Devletleri)</em>, şirketlerin yurt dışında olması durumunda KVKK md. 9/1 uyarınca, yurt i&ccedil;inde olması durumunda KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak,</li>
                  <li>Kendisine karşı sahip olduğumuz s&ouml;zleşmesel edimlerimizin ifası amacıyla &ccedil;alışma s&uuml;reci i&ccedil;erisinde ve/veya sonunda oluşturduğumuz &ccedil;alışma raporunu/raporlarını m&uuml;şterimize, Outlook uygulaması &uuml;zerinden e-posta yoluyla g&ouml;ndermek, WeTransfer uygulamasına y&uuml;klemek, WebStreaming yahut s&ouml;zl&uuml; aktarım suretiyle, m&uuml;şterinin yurt dışında olması durumunda KVKK md. 9/1 uyarınca, yurt i&ccedil;inde olması durumunda KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak ve</li>
                  <li>Bilişim sistemlerimizin depolama, arşivleme, bakım, g&uuml;venlik gibi teknolojik gerekliliklerin karşılanması amacıyla bilgi teknolojileri hizmeti aldığımız şirketlere, Outlook uygulaması &uuml;zerinden e-posta yoluyla g&ouml;ndermek, sunuculara yahut WeTransfer uygulamasına y&uuml;klemek suretiyle, KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak,</li>
               </ul>
            </li>
            <li><strong>Kimlik bilgilerinizi; </strong>sekt&ouml;rel gerekliliklere uyum sağlanması amacıyla T&uuml;rkiye Araştırmacılar Derneği&rsquo;ne, Outlook uygulaması &uuml;zerinden e-posta yoluyla g&ouml;ndermek ya da T&Uuml;AD sistemine y&uuml;klemek suretiyle, KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak,</li>
            <li><strong>Kimlik bilgilerinizi ve biyometrik verilerinizi (g&ouml;rsel ve işitsel kayıtlarınızı);</strong> sekt&ouml;rel &ouml;rneklerin sergilenmesi amacıyla, sunumlarda yer vermek suretiyle konferans katılımcılarına, &nbsp;KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak</li>
            <li>&Ccedil;alışma kapsamında g&ouml;r&uuml;şmelerin <em><a href="https://zoom.us/">https://zoom.us/</a></em> bağlantılı internet sitesi yahut &ldquo;ZOOM Cloud Meetings&rdquo; adlı uygulama &uuml;zerinden yapılması halinde;
               <ul>
                  <li><strong>Kullanıcı Profili:</strong> İsim, soy isim, telefon (tercihe bağlı), e-posta, şifre (tek oturum a&ccedil;ma se&ccedil;eneği kullanılmadığı takdirde), profil fotoğrafı (tercihe bağlı), departman (tercihe bağlı),</li>
                  <li><strong>G&ouml;r&uuml;şme &Uuml;st Verisi: </strong>Başlık, a&ccedil;ıklama (tercihe bağlı), katılımcının IP adresi, cihaz/donanım bilgisi,</li>
                  <li><strong>Bulut Kayıtları (tercihe bağlı):</strong> Mp4 formatında t&uuml;m videolar, ses ve sunumlar, M4A formatında t&uuml;m sesler, yazışmalara ait t&uuml;m metin dosyaları, seslere ilişkin kopya dosyaları,</li>
                  <li><strong>Anlık Yazışma Kayıtları</strong>,</li>
                  <li><strong>Telefon Kullanım Verisi (tercihe bağlı):</strong> &Ccedil;ağrı numaraları, &uuml;lke adı, IP adresi, kayıtlı acil durum arama adresi, başlangı&ccedil; ve bitiş zamanları, g&ouml;r&uuml;şme sahibinin adı ve e-posta adresi ve kullanılan cihazın MAC adresi</li>
               </ul>
            </li>
         </ul>
         <p>verileriniz, Kantar&rsquo;ın veri işleyeni olan ve merkezi Amerika Birleşik Devletleri&rsquo;nde bulunan Zoom Video Communications, Inc. (&ldquo;<strong>ZOOM</strong>&rdquo;) ve bu şirketin Amerika Birleşik Devletleri, Kanada, Avustralya, İngiltere, Fransa, Hollanda ve Japonya&rsquo;da bulunan iştiraklerinin yanı sıra ZOOM&rsquo;un <em><a href="https://zoom.us/subprocessors">https://zoom.us/subprocessors</a></em> bağlantılı internet sitesinde (bağlantı adresi zaman i&ccedil;erisinde değişiklik g&ouml;sterebilir) belirtilen ve ZOOM tarafından zaman zaman g&uuml;ncellenebilen alt veri işleyenlerine KVKK md. 9/1 uyarınca a&ccedil;ık rızanıza dayalı olarak aktarılabilir.</p>
         <p>Yukarıda belirtilenlerin dışında, T&uuml;m Kişisel Verileriniz hukuki y&uuml;k&uuml;ml&uuml;l&uuml;ğ&uuml;m&uuml;z&uuml;n bulunması halinde yalnızca resmi kurum ve kuruluşlara, zorunlu olduğu &ouml;l&ccedil;&uuml;de aktarılacaktır. Herhangi bir veri aktarımı yaparken, T&uuml;m Kişisel Verileriniz&rsquo;in gizliliğini ve g&uuml;venliğini sağlamak i&ccedil;in gerekli t&uuml;m idari ve teknik &ouml;nlemleri almış olacak ve ilgili durum i&ccedil;in gerekli olandan başka ve/veya fazla aktarım ger&ccedil;ekleştirmeyeceğiz.</p>
         <p>Ayrıca belirtmek isteriz ki &ccedil;alışma kapsamında işlediğimiz ve yukarıda ilgili kısımda m&uuml;şterimize aktarıldığını belirttiğimiz T&uuml;m Kişisel Verileriniz&rsquo;i, aktarım konusunda a&ccedil;ık rızanızı vermemeniz halinde doğrudan aktarmıyor, başka verilerle eşleştirilseler dahi hi&ccedil;bir surette kimliğinizle (sizinle) ilişkilendirilemeyecek bir bi&ccedil;imde, yani anonim hale getirerek aktarıyoruz. Ancak a&ccedil;ık rıza vermemeniz halinde, biyometrik verileriniz gibi anonim hale getirilemeyecek olanları aktarmıyoruz. Aktarım konusunda a&ccedil;ık rıza vermeniz durumunda ise aktarıldığını belirttiğimiz T&uuml;m Kişisel Verileriniz&rsquo;i yalnızca m&uuml;şterimizin talep etmesi halinde, verdiğiniz a&ccedil;ık rıza kapsamında ve mevzuata uygun şekilde m&uuml;şterimize aktarıyoruz.</p>
         <ol start="5">
            <li><strong>Haklarınız ve İletişim Kanallarımız</strong></li>
         </ol>
         <p>KVKK&rsquo;nın 11. maddesi uyarınca Kantar&rsquo;a başvurarak;</p>
         <ul>
            <li>T&uuml;m Kişisel Verileriniz&rsquo;in işlenip işlenmediğini &ouml;ğrenme,</li>
            <li>T&uuml;m Kişisel Verileriniz&rsquo;in işlenmesi halinde buna ilişkin bilgi talep etme,</li>
            <li>T&uuml;m Kişisel Verileriniz&rsquo;in işlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını &ouml;ğrenme,</li>
            <li>Yurt i&ccedil;inde veya yurt dışında T&uuml;m Kişisel Verileriniz&rsquo;in aktarıldığı &uuml;&ccedil;&uuml;nc&uuml; kişileri bilme,</li>
            <li>T&uuml;m Kişisel Verileriniz&rsquo;in eksik veya yanlış işlenmiş olması halinde bunların d&uuml;zeltilmesini isteme,</li>
            <li>KVKK&rsquo;da &ouml;ng&ouml;r&uuml;len koşullara uygun olarak T&uuml;m Kişisel Verileriniz&rsquo;in silinmesini veya yok edilmesini isteme,</li>
            <li>Eksik veya yanlış olarak işlenmiş T&uuml;m Kişisel Verileriniz&rsquo;in d&uuml;zeltildiğinin ve T&uuml;m Kişisel Verileriniz&rsquo;in silindiğinin yahut yok edildiğinin bunların aktarıldığı &uuml;&ccedil;&uuml;nc&uuml; kişilere bildirilmesini isteme,</li>
            <li>İşlenen T&uuml;m Kişisel Verileriniz&rsquo;in m&uuml;nhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle aleyhinize bir sonu&ccedil; ortaya &ccedil;ıkmasına itiraz etme,</li>
            <li>T&uuml;m Kişisel Verileriniz&rsquo;in kanuna aykırı olarak işlenmesi sebebiyle zarara uğramanız halinde zararın giderilmesini talep etme hakkınız bulunmaktadır.</li>
         </ul>
         <p>KVKK&rsquo;nın 13. maddesi uyarınca yukarıdaki haklarınızı kullanmak veya T&uuml;m Kişisel Verileriniz&rsquo;e ilişkin bilgi almak ya da beyanda bulunmak istediğiniz durumlarda kimliğinizi tespit etmeye yarar belgeler ile birlikte, yazılı olarak Esentepe Mahallesi B&uuml;y&uuml;kdere Caddesi No:127 Şişli - İstanbul adresine, <em>kantarinsights@hs01.kep.tr </em>kayıtlı elektronik posta adresine veya sistemimizde kayıtlı elektronik posta hesabınızın olması halinde <em>Privacy-TR@kantar.com </em>elektronik posta adresine elektronik posta yoluyla m&uuml;racaat edebilirsiniz.</p>
         <p>Haklarınıza ilişkin talepleriniz tarafımızca, talebin niteliğine g&ouml;re en kısa s&uuml;rede ve en ge&ccedil; 30 (otuz) g&uuml;n i&ccedil;erisinde &uuml;cretsiz olarak sonu&ccedil;landırılacaktır. Taleplerinizin sonu&ccedil;landırılmasına ilişkin olarak ayrıca bir maliyet doğması halinde Kurul tarafından belirlenen tarifedeki &uuml;cretleri sizden talep edebiliriz.</p>
         <p>Saygılarımızla,</p>
         <p><strong>Kantar Insights Pazar Araştırmaları Danışmanlık ve Ticaret A.Ş.</strong></p>
         <p><strong>KATILIMCI - KİŞİSEL VERİ A&Ccedil;IK RIZA FORMU</strong></p>
         <p>Değerli Katılımcımız,</p>
         <p>&Ccedil;alışmamıza katılmak i&ccedil;in g&ouml;sterdiğiniz ilgiye teşekk&uuml;r ederiz.</p>
         <p>&Ccedil;alışmaya başlamadan &ouml;nce sizlerden şu kişisel verileriniz ile &ouml;zel nitelikli kişisel verilerinizi;</p>
         <ul>
            <li><strong>Kimlik Bilgilerinizi:</strong> Adınızı, soyadınızı, cinsiyetinizi (KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>İletişim Bilgilerinizi:</strong> Telefon numaranızı, e-posta adresinizi (KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Mesleki Bilgilerinizi:</strong> Eğitim bilgilerinizi, mesleki deneyim bilgilerinizi, &ouml;zl&uuml;k bilgilerinizi (KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Dernek ve Vakıf &Uuml;yelik Bilgilerinizi</strong> (KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Biyometrik Verilerinizi:</strong> G&ouml;r&uuml;nt&uuml; kayıtlarınızı, ses kayıtlarınızı, analiz edilebilir g&ouml;r&uuml;nt&uuml; kayıtlarınızı (&ldquo;Facial Coding&rdquo; verilerinizi) (KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Siyasi G&ouml;r&uuml;ş ve D&uuml;ş&uuml;nce Bilgilerinizi</strong> (KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Sağlık Bilgilerinizi:</strong> Hastalık ge&ccedil;mişiniz, sağlık durumunuza ilişkin bilgileri (KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Kılık Kıyafet Bilgilerinizi:</strong> Kılık kıyafet tercihlerinizi (KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>&Ccedil;eşitli Tercih/Alışkanlık Bilgilerinizi:</strong> T&uuml;ketim, satın alma, gezinti/seyahat alışkanlıklarınızı ve hayat tarzınıza ilişkin bilgilerinizi (KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Ekonomik Bilgilerinizi:</strong> Kişisel gelir-gider bilgilerinizi (KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak),</li>
            <li><strong>Aile Bilgilerinizi:</strong> Medeni durumunuzu, &ccedil;ocuk sayınızı, hane halkı gelir-gider bilgileriniz ile aile &uuml;yelerinize ilişkin olarak yukarıda sayılan diğer bilgileri (kişisel veri olmaları durumunda KVKK md. 5/1 uyarınca a&ccedil;ık rızanıza dayalı olarak, &ouml;zel nitelikli kişisel veri olmaları durumunda KVKK md. 6/2 uyarınca a&ccedil;ık rızanıza dayalı olarak)</li>
         </ul>
         <p>şu ama&ccedil;lar doğrultusunda;</p>
         <ul>
            <li><strong>&Ccedil;alışmanın yapılabilmesi: </strong>&Ccedil;alışmayı adına y&uuml;r&uuml;tt&uuml;ğ&uuml;m&uuml;z m&uuml;şterimize taahh&uuml;t ettiğimiz araştırma faaliyetlerinin periyodik bazda ve/veya toplu olarak ger&ccedil;ekleştirilebilmesi, araştırma sonu&ccedil;larının analiz edilerek rapor haline getirilmesi, saha &ccedil;alışma merkezlerimiz tarafından saha &ccedil;alışmalarının y&uuml;r&uuml;t&uuml;lebilmesi, katılımcıların &ccedil;alışma kriterlerine uygunluğunun değerlendirilebilmesi, &ccedil;alışma kapsamında katılımcılarla iletişime ge&ccedil;ilmesi ve kendilerine s&uuml;rece dair bilgiler verilmesi, kendilerinden bilgi edinilmesi,</li>
            <li><strong>Şirket i&ccedil;erisinde kalite kontrol&uuml; s&uuml;recinin y&uuml;r&uuml;t&uuml;lmesi:</strong> &Ccedil;alışmalara ilişkin geriye d&ouml;n&uuml;k kalite kontrollerinin ger&ccedil;ekleştirilmesi, anket&ouml;rlere ve saha &ccedil;alışma merkezine ilişkin kalite kontrollerinin ger&ccedil;ekleştirilmesi, kalite kontrol&uuml; ama&ccedil;lı geri aramaların ger&ccedil;ekleştirilmesi, Şirket i&ccedil;i s&uuml;re&ccedil;lerin denetimi, yeni hizmet se&ccedil;enekleri geliştirme, tahmini veri modelleri oluşturma, katılımcı eğilimlerini tespit etme, uyguladığımız y&ouml;ntemlerin etkinliğini &ouml;l&ccedil;me, hizmetlerimizi ve s&uuml;re&ccedil;lerimizi iyileştirmek amacıyla araştırma ve geliştirme,</li>
            <li><strong>&Ccedil;alışmalara ilişkin geriye d&ouml;n&uuml;k kalite kontrollerinin ger&ccedil;ekleştirilmesi</strong>,</li>
            <li><strong>&Ccedil;alışmalar esnasında toplanan g&ouml;r&uuml;nt&uuml; ve işitsel kayıtların &ouml;rnek &ccedil;alışma teşkil etmesi adına T&uuml;rkiye Araştırmacılar Derneği (&ldquo;T&Uuml;AD&rdquo;) konferanslarında sunulması</strong>,</li>
            <li><strong>Şirket tesislerinde g&uuml;venliğin sağlanabilmesi</strong>,</li>
            <li><strong>T&uuml;m Kişisel Verileriniz ile ilişkili bir ihtilafta Kantar&rsquo;ın haklarının korunması,</strong></li>
            <li><strong>Kantar&rsquo;ın mevzuattan doğan &ccedil;eşitli hukuki y&uuml;k&uuml;ml&uuml;l&uuml;klerinin yerine getirilmesi</strong></li>
         </ul>
         <p>işlemek i&ccedil;in a&ccedil;ık rızanızı almak isteriz.</p>
         <p>Ayrıca yukarıda ayrıntılarıyla belirtilen kişisel verileriniz ile &ouml;zel nitelikli kişisel verilerinizden;</p>
         <ul>
            <li><strong>Kimlik bilgilerinizi, iletişim bilgilerinizi, mesleki bilgilerinizi, dernek ve vakıf &uuml;yelik bilgilerinizi, felsefi inan&ccedil;, din, mezhep ve diğer inan&ccedil; bilgilerinizi, cinsel hayat bilgilerinizi, biyometrik verilerinizi, siyasi g&ouml;r&uuml;ş ve d&uuml;ş&uuml;nce bilgilerinizi, sağlık bilgilerinizi, kılık ve kıyafet bilgilerinizi, &ccedil;eşitli tercih/alışkanlık bilgilerinizi, ekonomik bilgilerinizi ve aile bilgilerinizi;</strong>
               <ul>
                  <li>Raporlama gibi i&ccedil; idari s&uuml;re&ccedil;leri y&uuml;r&uuml;tebilmek amacıyla, Kantar&rsquo;ın yurt dışı iştiraklerine, sunuculara yahut Kantar UK Secure File Sistemi&rsquo;ne y&uuml;klemek suretiyle, KVKK md. 9/1 uyarınca a&ccedil;ık rızanıza dayalı olarak,</li>
                  <li>&Ccedil;alışma faaliyetlerinin ger&ccedil;ekleştirilebilmesi i&ccedil;in &ccedil;alışmayı sahada aktif olarak y&uuml;r&uuml;tebilmeleri amacıyla, Şirket&rsquo;ten bağımsız olup &ccedil;alışma kapsamında Şirket yararına hareket etmekte olan Kantar TR tanımlı saha &ccedil;alışma merkezlerimize, Outlook uygulaması &uuml;zerinden e-posta yoluyla g&ouml;ndermek ya da WeTransfer uygulamasına y&uuml;klemek suretiyle, KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak,</li>
                  <li>&Ccedil;alışma faaliyetlerinin ger&ccedil;ekleştirilebilmesi amacıyla, kullandığımız Outlook, Fileserver, Dimensions, NIPO, CATI Server, CAWI Server, Web Konferans Uygulamaları adlı uygulamaların sahibi olan şirketlere, yalnızca gerekli olduğu durumlarda ve gerektiği &ouml;l&ccedil;&uuml;de, bu uygulamaları kullanmak suretiyle (<em>uygulamaların sunucularının bulunduğu &uuml;lkeler: İngiltere, Hollanda, Bel&ccedil;ika ve Amerika Birleşik Devletleri)</em>, şirketlerin yurt dışında olması durumunda KVKK md. 9/1 uyarınca, yurt i&ccedil;inde olması durumunda KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak,</li>
                  <li>Kendisine karşı sahip olduğumuz s&ouml;zleşmesel edimlerimizin ifası amacıyla &ccedil;alışma s&uuml;reci i&ccedil;erisinde ve/veya sonunda oluşturduğumuz &ccedil;alışma raporunu/raporlarını m&uuml;şterimize, Outlook uygulaması &uuml;zerinden e-posta yoluyla g&ouml;ndermek, WeTransfer uygulamasına y&uuml;klemek, WebStreaming yahut s&ouml;zl&uuml; aktarım suretiyle, m&uuml;şterinin yurt dışında olması durumunda KVKK md. 9/1 uyarınca, yurt i&ccedil;inde olması durumunda KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak ve</li>
                  <li>Bilişim sistemlerimizin depolama, arşivleme, bakım, g&uuml;venlik gibi teknolojik gerekliliklerin karşılanması amacıyla bilgi teknolojileri hizmeti aldığımız şirketlere, Outlook uygulaması &uuml;zerinden e-posta yoluyla g&ouml;ndermek, sunuculara yahut WeTransfer uygulamasına y&uuml;klemek suretiyle, KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak,</li>
               </ul>
            </li>
            <li><strong>Kimlik bilgilerinizi; </strong>sekt&ouml;rel gerekliliklere uyum sağlanması amacıyla T&uuml;rkiye Araştırmacılar Derneği&rsquo;ne, Outlook uygulaması &uuml;zerinden e-posta yoluyla g&ouml;ndermek ya da T&Uuml;AD sistemine y&uuml;klemek suretiyle, KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak,</li>
            <li><strong>Kimlik bilgilerinizi ve biyometrik verilerinizi (g&ouml;rsel ve işitsel kayıtlarınızı);</strong> sekt&ouml;rel &ouml;rneklerin sergilenmesi amacıyla, sunumlarda yer vermek suretiyle konferans katılımcılarına, KVKK md. 8/1 uyarınca a&ccedil;ık rızanıza dayalı olarak</li>
         </ul>
         <p>aktarmak i&ccedil;in de a&ccedil;ık rızanızı almak isteriz.</p>
         <p>G&ouml;r&uuml;şmelerin <em><a href="https://zoom.us/">https://zoom.us/</a></em> bağlantılı internet sitesi yahut &ldquo;ZOOM Cloud Meetings&rdquo; adlı uygulama &uuml;zerinden yapılması halinde;</p>
         <ul>
            <li><strong>Kullanıcı Profili:</strong> İsim, soy isim, telefon (tercihe bağlı), e-posta, şifre (tek oturum a&ccedil;ma se&ccedil;eneği kullanılmadığı takdirde), profil fotoğrafı (tercihe bağlı), departman (tercihe bağlı),</li>
            <li><strong>G&ouml;r&uuml;şme &Uuml;st Verisi: </strong>Başlık, a&ccedil;ıklama (tercihe bağlı), katılımcının IP adresi, cihaz/donanım bilgisi,</li>
            <li><strong>Bulut Kayıtları (tercihe bağlı):</strong> Mp4 formatında t&uuml;m videolar, ses ve sunumlar, M4A formatında t&uuml;m sesler, yazışmalara ait t&uuml;m metin dosyaları, seslere ilişkin kopya dosyaları,</li>
            <li><strong>Anlık Yazışma Kayıtları</strong></li>
            <li><strong>Telefon Kullanım Verisi (tercihe bağlı):</strong> &Ccedil;ağrı numaraları, &uuml;lke adı, IP adresi, kayıtlı acil durum arama adresi, başlangı&ccedil; ve bitiş zamanları, g&ouml;r&uuml;şme sahibinin adı ve e-posta adresi ve kullanılan cihazın MAC adresi</li>
         </ul>
         <p>verilerinizi, Kantar&rsquo;ın veri işleyeni olan ve merkezi Amerika Birleşik Devletleri&rsquo;nde bulunan Zoom Video Communications, Inc. (&ldquo;<strong>ZOOM</strong>&rdquo;) ve ZOOM&rsquo;un Amerika Birleşik Devletleri, Kanada, Avustralya, İngiltere, Fransa, Hollanda ve Japonya&rsquo;da bulunan iştiraklerinin yanı sıra <em><a href="https://zoom.us/subprocessors">https://zoom.us/subprocessors</a></em> bağlantılı internet sitesinde (bağlantı adresi zaman i&ccedil;erisinde değişiklik g&ouml;sterebilir) belirtilen ve ZOOM tarafından zaman zaman g&uuml;ncellenebilen alt veri işleyenlerine, KVKK md. 9/1 uyarınca a&ccedil;ık rızanıza dayalı olarak aktarmak i&ccedil;in de a&ccedil;ık rızanızı almak isteriz.</p>
         <p>Davet edildiğiniz bu g&ouml;r&uuml;şmede, analiz ve raporlamada kullanılmak &uuml;zere ses ve g&ouml;r&uuml;nt&uuml; kaydı alınabilir, ayrıca m&uuml;şterimiz tarafından toplantı izlenebilir. Bu g&ouml;r&uuml;nt&uuml;/ses kaydı kesinlikle gizli tutulacak ve sadece pazar araştırma ama&ccedil;ları i&ccedil;in kullanılacaktır. Vermiş olduğunuz bilgiler sadece araştırma ama&ccedil;ları ile ilgili olarak kullanılacaktır.</p>
         <p>Kişisel verileriniz kesinlikle gizli tutulacaktır. Vermiş olduğunuz bilgiler, kişisel olarak değil, araştırma kapsamında katılan b&uuml;t&uuml;n katılımcılar ile ortak ve anonim olarak değerlendirilecektir.</p>
         <p>Bizlere verdiğiniz izni her zaman <a href="mailto:Privacy-TR@kantar.com">Privacy-TR@kantar.com</a> adresine e-posta atarak geri alabilirsiniz. Kişisel verilerinizin işlenmesine ilişkin diğer detaylar i&ccedil;in size ayrıca sunduğumuz aydınlatma metnini incelemenizi rica ederiz.</p>
         <p><strong>&Ccedil;alışma ile paylaşacağım kişisel verilerimin yukarıda belirtilen kapsamda işlenmesine ve belirtilen alıcılara aktarılmasına izin veriyorum. </strong></p>
         <p><strong>G&ouml;r&uuml;şmede g&ouml;sterilen/sorulan, reklam-&uuml;r&uuml;n-konsept-fikirlerden, 3. Şahıslara bahsetmeyeceğimi onaylıyorum. </strong></p>
         <p>&nbsp;</p>

      </div>
      <hr>
      <form method="POST" action="" onsubmit="
         if(form_being_submitted) {
         alert('Gönderiliyor, lütfen biraz bekleyin ...');
         myButton.disabled = true;
         return false;
         }
         if(checkForm(this)) {
         myButton.value = 'Gönderiliyor...';
         form_being_submitted = true;
         return true;
         }
         return false;
         ">
         <div class="bg-light p-5 rounded">
            <div class="form-floating mb-3">
               <input type="text" class="form-control" id="isim" name="isim" placeholder="İsim" required>
               <label for="isim">İsim</label>
            </div>
            <div class="form-floating mb-3">
               <input type="text" class="form-control" name="soyisim" placeholder="Soyisim" required>
               <label for="soyisim">Soyisim</label>
            </div>
            <div class="form-floating mb-3">
               <input type="email" class="form-control" name="eposta" placeholder="E-posta" required>
               <label for="eposta">E-posta</label>
            </div>
            <div class="alert alert-warning" role="alert">
               <input class="form-check-input" type="checkbox" required>
               Yukarıda bulunan KVKK Aydınlatma metnini okudum ve <a class="alert-link">Açık Rıza Metnini</a> onaylıyorum.
            </div>
            <div id="hidden-div" class="d-grid gap-2">
               <input class="btn btn-success" id="btnFetch" type="submit" name="myButton">
            </div>
         </div>
      </form>
   </main>

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

</body>

<script type="text/javascript">
   var form_being_submitted = false; // global variable

   function checkForm(form) {
      if (form.isim.value == "") {
         alert("Please enter your first and last names");
         form.isim.focus();
         return false;
      }
      if (form.soyisim.value == "") {
         alert("Please enter your first and last names");
         form.soyisim.focus();
         return false;
      }
      if (form.eposta.value == "") {
         alert("Please enter your first and last names");
         form.soyisim.focus();
         return false;
      }
      return true;
   }

   function resetForm(form) {
      form.myButton.disabled = false;
      form.myButton.value = "Submit";
      form_being_submitted = false;
   }
</script>




</html>