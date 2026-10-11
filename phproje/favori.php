<?php
$tur = $_POST['tur'];
$index = $_POST['index'];

if($tur == 'kitap') {
    $kitaplar = json_decode(file_get_contents('json/kitaplar.json'), true);
    $kitaplar[$index]['favori'] = isset($kitaplar[$index]['favori']) && $kitaplar[$index]['favori'] ? false : true;
    file_put_contents('json/kitaplar.json', json_encode($kitaplar, JSON_UNESCAPED_UNICODE));

} elseif($tur == 'film') {
    $filmler = json_decode(file_get_contents('json/filmler.json'), true);
    $filmler[$index]['favori'] = isset($filmler[$index]['favori']) && $filmler[$index]['favori'] ? false : true;
    file_put_contents('json/filmler.json', json_encode($filmler, JSON_UNESCAPED_UNICODE));
}

header('Location: index.php');
exit;
?>
