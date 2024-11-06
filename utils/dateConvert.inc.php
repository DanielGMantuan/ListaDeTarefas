<?php

function formatarData($data)
{
    return date('d/m/Y',$data);
}

function ConverterDataMySQL($data){
    return date( "Y-m-d" , $data);
}

function ConverterDataToMySQL($date){
    $formattedDate = DateTime::createFromFormat('d/m/Y', $date);

    // Verifica se a data foi criada corretamente
    if ($formattedDate) {
        // Converte para o formato MySQL (YYYY-MM-DD)
        $mysqlDate = $formattedDate->format('Y-m-d');
        return $mysqlDate; // Exibe '2024-11-07'
    }
}

?>