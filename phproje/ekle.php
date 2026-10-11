<?php
$tur = isset($_GET['tur']) ? $_GET['tur'] : 'kitap';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tur = $_POST['tur'];
    $isim = $_POST['isim'];

    if($tur == 'kitap') {
        $yazar = $_POST['yazar'];
        $puan = isset($_POST['puan']) ? $_POST['puan'] : '';
        $konu = isset($_POST['konu']) ? $_POST['konu'] : '';

        $foto = '';
        if($_FILES['foto']['name'] != '') {
            $foto = 'yuklemeler/' . $_FILES['foto']['name'];
            move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
        }

        $yeniKitap = [
                'isim' => $isim,
                'yazar' => $yazar,
                'puan' => $puan,
                'konu' => $konu,
                'foto' => $foto
        ];

        $kitaplar = json_decode(file_get_contents('json/kitaplar.json'), true);
        if(!$kitaplar) $kitaplar = [];
        $kitaplar[] = $yeniKitap;
        file_put_contents('json/kitaplar.json', json_encode($kitaplar, JSON_UNESCAPED_UNICODE));

        header('Location: index.php');
        exit;

    } elseif($tur == 'film') {
        $yil = isset($_POST['yil']) ? $_POST['yil'] : '';
        $puan = isset($_POST['puan']) ? $_POST['puan'] : '';
        $fragman = isset($_POST['fragman']) ? $_POST['fragman'] : '';
        $konu = isset($_POST['konu']) ? $_POST['konu'] : '';
        $tur_detay = isset($_POST['tur_detay']) ? $_POST['tur_detay'] : 'film';

        $foto = '';
        if($_FILES['foto']['name'] != '') {
            $foto = 'yuklemeler/' . $_FILES['foto']['name'];
            move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
        }

        $yeniFilm = [
                'isim' => $isim,
                'tur_detay' => $tur_detay,
                'yil' => $yil,
                'puan' => $puan,
                'konu' => $konu,
                'fragman' => $fragman,
                'foto' => $foto
        ];

        $filmler = json_decode(file_get_contents('json/filmler.json'), true);
        if(!$filmler) $filmler = [];
        $filmler[] = $yeniFilm;
        file_put_contents('json/filmler.json', json_encode($filmler, JSON_UNESCAPED_UNICODE));

        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ekle - Kitap-Film Arşivi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="index.php">Ana Sayfa</a>
    <a href="ekle.php?tur=kitap">Kitap Ekle</a>
    <a href="ekle.php?tur=film">Film Ekle</a>
    <h4>*ੈ✩‧₊˚༺☆༻*ੈ✩‧₊˚</h4>
    <audio controls >
        <source src="leberch-soft-piano-501446.mp3" type="audio/mpeg">
        Tarayıcınız ses öğesini desteklemiyor.
    </audio>
</nav>

<div class="ekle-sayfa">

    <?php if($tur == 'kitap'): ?>
        <h1>Kitap Ekle</h1>
        <form action="ekle.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="tur" value="kitap">

            <label>İsim:</label>
            <input type="text" name="isim" required autocomplete="off"><br>

            <label>Yazar:</label>
            <input type="text" name="yazar" required autocomplete="off"><br>

            <label>Puan:</label>
            <input type="number" name="puan" min="1" max="10" autocomplete="off"><br>

            <label>Konu:</label>
            <textarea name="konu"></textarea><br>

            <label>Kapak Fotoğrafı:</label>
            <input type="file" name="foto" accept="image/*" autocomplete="off"><br>

            <button type="submit">Kaydet</button>
        </form>

    <?php elseif($tur == 'film'): ?>
        <h1>Film/Dizi Ekle</h1>
        <form action="ekle.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="tur" value="film">

            <label>İsim:</label>
            <input type="text" name="isim" required autocomplete="off"><br>

            <label>Tür:</label>
            <select name="tur_detay">
                <option value="film">Film</option>
                <option value="dizi">Dizi</option>
            </select><br>

            <label>Yıl:</label>
            <input type="number" name="yil" autocomplete="off"><br>

            <label>Puan:</label>
            <input type="number" name="puan" min="1" max="10" autocomplete="off"><br>

            <label>Fragman Linki:</label>
            <input type="text" name="fragman" autocomplete="off"><br>

            <label>Konu:</label>
            <textarea name="konu"></textarea><br>

            <label>Afiş Fotoğrafı:</label>
            <input type="file" name="foto" accept="image/*" autocomplete="off"><br>

            <button type="submit">Kaydet</button>
        </form>
    <?php endif; ?>

</div>

</body>
</html>