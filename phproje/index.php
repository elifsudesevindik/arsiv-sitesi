<?php
$kitaplar = json_decode(file_get_contents('json/kitaplar.json'), true);
$filmler = json_decode(file_get_contents('json/filmler.json'), true);
if(!$kitaplar) $kitaplar = [];
if(!$filmler) $filmler = [];

$arama = isset($_GET['ara']) ? $_GET['ara'] : '';

if($arama != '') {
    $kitaplar = array_filter($kitaplar, function($kitap) use ($arama) {
        return stristr($kitap['isim'], $arama) || stristr($kitap['yazar'], $arama);
    });
    $filmler = array_filter($filmler, function($film) use ($arama) {
        return stristr($film['isim'], $arama);
    });
}
$favoriler = isset($_GET['favoriler']) && $_GET['favoriler'] == 1;

if($favoriler) {
    $kitaplar = array_filter($kitaplar, function($kitap) {
        return isset($kitap['favori']) && $kitap['favori'];
    });
    $filmler = array_filter($filmler, function($film) {
        return isset($film['favori']) && $film['favori'];
    });
}
?>



<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kitap-Film Arşivi</title>
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



<div class="anasayfa">
    <h1>⋆. 𐙚 ̊  Kitap-Film Arşivim  ⋆. 𐙚 ̊</h1>
    <p>Okuduğum kitaplar, izlediğim film ve diziler arşivim.</p>
    <form action="index.php" method="GET">
        <input type="text" name="ara" placeholder="Kitap veya film ara..."
               value="<?php echo $arama; ?>" autocomplete="off">
        <button type="submit">🔍 Ara</button>
        <?php if($arama != ''): ?>
            <a href="index.php">✖ Temizle</a>
        <?php endif; ?>
    </form>

    <?php if($favoriler): ?>
        <a href="index.php">✖ Favorileri Kapat</a>
    <?php else: ?>
        <a href="index.php?favoriler=1" class="buton">⭐ Favoriler</a>
    <?php endif; ?>

</div>


<div class="ust-alan">

    <img class="sol-resim" src="18eef8c791c3f53a88fffcfbbf15123b.png" alt="çiçek resmi">
    <div class="iki-sutun">

        <!-- SOL: KİTAPLAR -->
        <div class="sutun">
           <h2> 𓍢ִ໋🀦 Kitaplar</h2>
            <?php if(count($kitaplar) == 0): ?>
                <p>Henüz kitap eklenmemiş.</p>
            <?php else: ?>
               <?php foreach($kitaplar as $i => $kitap): ?>
                   <div class="kart">
                       <form action="favori.php" method="POST">
                            <input type="hidden" name="tur" value="kitap">
                            <input type="hidden" name="index" value="<?php echo $i; ?>">
                            <button type="submit">
                                <?php echo isset($kitap['favori']) && $kitap['favori'] ? '⭐' : '☆'; ?>
                             </button>
                        </form>
                        <a href="detay.php?tur=kitap&index=<?php echo $i; ?>" class="kart-link">
                            <?php if($kitap['foto'] != ''): ?>
                                <img src="<?php echo $kitap['foto']; ?>" width="80">
                            <?php endif; ?>
                            <h3><?php echo $kitap['isim']; ?></h3>
                            <p>Yazar: <?php echo $kitap['yazar']; ?></p>
                        </a>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- SAĞ: FİLM/DİZİLER -->
        <div class="sutun">
            <h2> 📽 Film/Diziler</h2>
            <?php if(count($filmler) == 0): ?>
                <p>Henüz film eklenmemiş.</p>
            <?php else: ?>
                <?php foreach($filmler as $i => $film): ?>
                    <div class="kart">
                        <form action="favori.php" method="POST">
                            <input type="hidden" name="tur" value="film">
                            <input type="hidden" name="index" value="<?php echo $i; ?>">
                            <button type="submit">
                                <?php echo isset($film['favori']) && $film['favori'] ? '⭐' : '☆'; ?>
                            </button>
                        </form>
                        <a href="detay.php?tur=film&index=<?php echo $i; ?>" class="kart-link">
                            <?php if($film['foto'] != ''): ?>
                                <img src="<?php echo $film['foto']; ?>" width="80">
                            <?php endif; ?>
                            <h3><?php echo $film['isim']; ?></h3>
                            <h5><?php echo $film['tur_detay'] == 'dizi' ? ' Dizi' : ' Film'; ?></h5>
                            <p>Yıl: <?php echo $film['yil']; ?></p>

                        </a>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <img class="sag-resim" src="18eef8c791c3f53a88fffcfbbf15123b.png" alt="çiçek resmi">
</div>

</body>
</html>