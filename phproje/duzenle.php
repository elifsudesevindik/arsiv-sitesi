<?php
$tur = $_GET['tur'];
$index = $_GET['index'];

if($tur == 'kitap') {
    $kitaplar = json_decode(file_get_contents('json/kitaplar.json'), true);
    $oge = $kitaplar[$index];
} elseif($tur == 'film') {
    $filmler = json_decode(file_get_contents('json/filmler.json'), true);
    $oge = $filmler[$index];
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isim = $_POST['isim'];

    // 1. Önce mevcut fotoğrafı koru (Yeni seçilmezse bu kullanılacak)
    $foto = $oge['foto'];

    // 2. Yeni bir dosya seçilmiş mi kontrol et
    if(isset($_FILES['foto']) && $_FILES['foto']['name'] != '') {
        $hedef_klasor = "yuklemeler/";

        // Klasör yoksa oluştur
        if (!is_dir($hedef_klasor)) {
            mkdir($hedef_klasor, 0777, true);
        }

        $dosya_adi = basename($_FILES['foto']['name']);
        $hedef_yol = $hedef_klasor . $dosya_adi;

        // Dosyayı bilgisayardan sunucuya taşı
        if(move_uploaded_file($_FILES['foto']['tmp_name'], $hedef_yol)) {
            $foto = $hedef_yol; // Başarılıysa yeni yolu değişkene ata
        }
    }

    if($tur == 'kitap') {
        $kitaplar[$index] = [
                'isim' => $isim,
                'yazar' => $_POST['yazar'],
                'puan' => $_POST['puan'],
                'konu' => isset($_POST['konu']) ? $_POST['konu'] : '',
                'foto' => $foto, // Güncel dosya yolu
        ];
        file_put_contents('json/kitaplar.json', json_encode($kitaplar, JSON_UNESCAPED_UNICODE));

    } elseif($tur == 'film') {
        $filmler[$index] = [
                'isim' => $isim,
                'tur_detay' => $_POST['tur_detay'],
                'yil' => $_POST['yil'],
                'puan' => $_POST['puan'],
                'konu' => isset($_POST['konu']) ? $_POST['konu'] : '',
                'fragman' => isset($_POST['fragman']) ? $_POST['fragman'] : '',
                'foto' => $foto, // Güncel dosya yolu
        ];
        file_put_contents('json/filmler.json', json_encode($filmler, JSON_UNESCAPED_UNICODE));
    }

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Düzenle</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="index.php">Ana Sayfa</a>
    <a href="ekle.php">Ekle</a>
    <h4>*ੈ✩‧₊˚༺☆༻*ੈ✩‧₊˚</h4>
    <audio controls >
        <source src="leberch-soft-piano-501446.mp3" type="audio/mpeg">
        Tarayıcınız ses öğesini desteklemiyor.
    </audio>
</nav>

<div class="ekle-sayfa">

    <?php if($tur == 'kitap'): ?>
        <h1> Kitap Düzenle</h1>
        <form action="duzenle.php?tur=kitap&index=<?php echo $index; ?>" method="POST" enctype="multipart/form-data">
            <label>İsim:</label>
            <input type="text" name="isim" value="<?php echo $oge['isim']; ?>" required autocomplete="off">

            <label>Yazar:</label>
            <input type="text" name="yazar" value="<?php echo $oge['yazar']; ?>" required autocomplete="off">

            <label>Puan:</label>
            <input type="number" name="puan" value="<?php echo $oge['puan']; ?>" min="1" max="10">

            <label>Konu:</label>
            <textarea name="konu"><?php echo isset($oge['konu']) ? $oge['konu'] : ''; ?></textarea>

            <label>Mevcut Kapak:</label><br>
            <?php if(!empty($oge['foto'])): ?>
                <img src="<?php echo $oge['foto']; ?>" width="100" style="border: 1px dashed #ccc; margin-bottom: 10px;"><br>
            <?php endif; ?>

            <label>Kapak Fotoğrafı Değiştir:</label>
            <input type="file" name="foto" accept="image/*"><br>

            <button type="submit">Kaydet</button>
        </form>

    <?php elseif($tur == 'film'): ?>
        <h1>Film/Dizi Düzenle</h1>
        <form action="duzenle.php?tur=film&index=<?php echo $index; ?>" method="POST" enctype="multipart/form-data">
            <label>İsim:</label>
            <input type="text" name="isim" value="<?php echo $oge['isim']; ?>" required autocomplete="off">

            <label>Tür:</label>
            <select name="tur_detay">
                <option value="film" <?php echo $oge['tur_detay'] == 'film' ? 'selected' : ''; ?>>Film</option>
                <option value="dizi" <?php echo $oge['tur_detay'] == 'dizi' ? 'selected' : ''; ?>>Dizi</option>
            </select>

            <label>Yıl:</label>
            <input type="number" name="yil" value="<?php echo $oge['yil']; ?>">

            <label>Puan:</label>
            <input type="number" name="puan" value="<?php echo $oge['puan']; ?>" min="1" max="10">

            <label>Mevcut Kapak:</label><br>
            <?php if(!empty($oge['foto'])): ?>
                <img src="<?php echo $oge['foto']; ?>" width="100" style="border: 1px dashed #ccc; margin-bottom: 10px;"><br>
            <?php endif; ?>

            <label>Kapak Fotoğrafı Değiştir:</label>
            <input type="file" name="foto" accept="image/*"><br>

            <label>Fragman Linki:</label>
            <input type="text" name="fragman" value="<?php echo isset($oge['fragman']) ? $oge['fragman'] : ''; ?>" autocomplete="off">

            <label>Konu:</label>
            <textarea name="konu"><?php echo isset($oge['konu']) ? $oge['konu'] : ''; ?></textarea>

            <button type="submit">Kaydet</button>
        </form>
    <?php endif; ?>

</div>

</body>
</html>