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
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $oge['isim']; ?></title>
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

<div class="detay-sayfa">

    <div class="detay-icerik">
        <?php if(isset($oge['foto']) && $oge['foto'] != ''): ?>

            <img src="<?php echo $oge['foto']; ?>" width="200" alt="<?php echo $oge['isim']; ?>">

        <?php endif; ?>

        <div class="detay-bilgi">
            <h1><?php echo $oge['isim']; ?></h1> <br>

            <?php if($tur == 'kitap'): ?>
                <p>Yazar: <?php echo $oge['yazar']; ?></p>
                <p>Puan: <?php echo $oge['puan']; ?>/10</p>
                <p>Konu: <?php echo $oge['konu']; ?></p>
            <?php elseif($tur == 'film'): ?>
                <h5><?php echo $oge['tur_detay'] == 'dizi' ? ' Dizi' : ' Film'; ?></h5>
                <p>Yıl: <?php echo $oge['yil']; ?></p>
                <p>Puan: <?php echo $oge['puan']; ?>/10</p>
                <p>Konu: <?php echo isset($oge['konu']) ? $oge['konu'] : ''; ?></p>
                <?php if(isset($oge['fragman']) && $oge['fragman'] != ''): ?>
                    <a href="<?php echo $oge['fragman']; ?>" target="_blank" class="fragman-buton">🎬 Fragmanı İzle</a>
                <?php else: ?>
                    <h6>Fragman eklenmemiş.</h6>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="detay-altbar">
        <a href="index.php">← Geri Dön</a>
        <div class="kart-butonlar">
            <a href="duzenle.php?tur=<?php echo $tur; ?>&index=<?php echo $index; ?>">️ Düzenle</a>
            <a href="sil.php?tur=<?php echo $tur; ?>&index=<?php echo $index; ?>"
               onclick="return confirm('Silmek istediğine emin misin?')">Sil</a>
        </div>
    </div>

</div>

</body>
</html>