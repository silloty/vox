<?php
$largura = 180;
$altura = 30;
$imagem = imagecreate($largura,$altura); // cria uma imagem
/*Possiveis Letras do captcha*/
/*'a','b','c','d','e','f','g','h','i',
                'j','k','l','m','n','o','p','q','r',
                's','t','u','v','w','x','y','z',
                'A','B','C','D','E','F','G','H','I',
                'J','K','L','M','N','O','P','Q','R',
                'S','T','U','V','W','X','Y','Z',
                */
$letras = array('0','1','2','3','4','5','6','7','8','9'); // neste caso o captcha terá só números
$tam_letras = count($letras)-1;
/*Fim possives letras*/
/*Cores da imagem*/
$cinza = imagecolorallocate($imagem,0xF8,0xF8,0xF8);
$cinza_escuro = imagecolorallocate($imagem,0xCC,0xCC,0xCC);
$vermelho = imagecolorallocate($imagem,0xFF,0x00,0x00);
$azul = imagecolorallocate($imagem,0x0F,0x93,0xFF);
$verde = imagecolorallocate($imagem,0x00,0x66,0x00);
$rosa = imagecolorallocate($imagem,0xFF,0x1A,0x98);
$preto = imagecolorallocate($imagem,0x00,0x00,0x00);
$marrom = imagecolorallocate($imagem,0xDC,0x91,0x3D);
$laranja = imagecolorallocate($imagem,0xFF,0x8C,0x24);
$cores = array($vermelho,$azul,$verde,$rosa,$preto,
               $marrom,$laranja);
$tam_cores = count($cores)-1;
/*Fim das cores*/

/*Escrevendo linhas de fundo*/
$nro_linhas = 20;
for($i=0;$i<$nro_linhas;$i++){
    $x1 = rand(0,$largura);
    $x2 = rand(0,$largura);
    $y1 = rand(0,$altura);
    $y2 = rand(0,$altura);
    imageline($imagem,$x1,$y1,$x2,$y2,$cinza_escuro);
}
/*Fim linhas de fundo*/

/*Escrevendo arcos de fundo*/
$nro_arcos = 20;
for($i=0;$i<$nro_arcos;$i++){
    $cx = rand(0,$largura);
    $w = rand(0,$largura);
    $cy = rand(0,$altura);
    $h = rand(0,$altura);
    $s = rand(0,360);
    $e = rand(0,360);
    imagearc($imagem,$cx,$cy,$w,$h,$s,$e,$cinza_escuro);
}
/*Fim arcos de fundo*/

/*Escrevendo as Letras na imagem*/
$palavra = '';
$xPos = 0;
for($i=0;$i<6;$i++){
    $xPos += rand(10,25);
    $yPos = rand(10,15);
    $j = rand(0,$tam_cores);
    $k = rand(0,$tam_letras);
    $palavra .= $letras[$k];
  imagestring($imagem, 5, $xPos, $yPos, $letras[$k], $cores[$j]);
}
/*fim escrevendo letras na imagem*/
//session_name('captcha');
session_start();
$_SESSION['vox_palavra'] = $palavra;
header("Content-type: image/png");
imagepng($imagem);
imagedestroy($imagem);
?>