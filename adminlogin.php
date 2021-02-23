<?php
require("dbconfig.php");
require 'genelPhp/temel.php';
$title = 'Admin Giriş';

@session_start();

if (isset($_SESSION['KullaniciAdi'])) {
    echo "<script>window.location.assign('adminmesaj')</script>";
}

if ($_POST) {
    $admin_kadi = $_POST["kullaniciadi"];
    $admin_sifre = $_POST["sifreniz"];

    if (!empty($admin_kadi) && !empty($admin_sifre)) {
        $query = "SELECT * FROM kullanici WHERE kullaniciadi= '" . $admin_kadi . "' AND sifre= '" . $admin_sifre . "' ";
        $data = $conn->query($query);

        if ($data->rowcount() > 0) {
            foreach ($data->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $allDatas[] = $row;
            }
            $_SESSION['KullaniciAdi'] = $allDatas[0]['kullaniciadi'];

            echo "<script>window.location.assign('adminmesaj')</script>";
        }
    }
}

?>

<html>

<head>
    <title><?= $title ?> | <?= $siteAdi ?> </title>
    <?php require 'eklentiler/bootstrap.php' ?>

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <main class="form-signin">
        <form method="POST">

            <img class="mb-4" src="images/odaksis-kare.png" alt="" width="100" height="100">
            <h1 class="h3 mb-3 fw-normal">Lütfen Giriş yapın</h1>

            <label for="kullaniciadi" class="visually-hidden">Kullanıcı Adın</label>
            <input type="text" id="kullaniciadi" name="kullaniciadi" class="form-control" placeholder="Kullanıcı Adın" required autofocus>

            <label for="sifreniz" class="visually-hidden">Şifre</label>
            <input type="password" id="sifreniz" name="sifreniz" class="form-control" placeholder="Şifre" required>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Giriş Yap</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2021 - <?= $siteAdi ?> </p>
        </form>

    </main>
</body>



</html>