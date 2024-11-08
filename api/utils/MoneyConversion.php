<?php

function formatToBR(float $valor): string {
    return number_format($valor, 2, ',', '.');
}

function formatFromBR(string $valorBR) {
    $valorBR = str_replace(chr(0xA0), ' ', $valorBR);
    $valorBR = str_replace(['R$', ' '], '', $valorBR);    
    $valorBR = str_replace('.', '', $valorBR);
    $valorBR = str_replace(',', '.', $valorBR);
    
    $valorBR = substr($valorBR, 1);
    return floatval($valorBR);
}

?>