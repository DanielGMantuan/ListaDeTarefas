<?php

function formatToBR(float $valor): string {
    return number_format($valor, 2, ',', '.');
}

function formatFromBR(string $valorBR): float {
    $valorBR = str_replace(' ', '', $valorBR);
    $valorBR = str_replace('.', '', $valorBR);
    $valorBR = str_replace(',', '.', $valorBR);

    return (float) $valorBR;
}

?>