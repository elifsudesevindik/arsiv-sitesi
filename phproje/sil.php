<?php
$tur = $_GET['tur'];
$index = $_GET['index'];

if($tur == 'kitap') {
    $kitaplar = json_decode(file_get_contents('json/kitaplar.json'), true);
    array_splice($kitaplar, $index, 1);
    file_put_contents('json/kitaplar.json', json_encode($kitaplar, JSON_UNESCAPED_UNICODE));

} elseif($tur == 'film') {
    $filmler = json_decode(file_get_contents('json/filmler.json'), true);
    array_splice($filmler, $index, 1);
    file_put_contents('json/filmler.json', json_encode($filmler, JSON_UNESCAPED_UNICODE));
}

header('Location: index.php');
exit;
?>