<?php

define('TIPOCAMBIO_DEFAULT', 600);

$tc = tipoCambioDollarBCCR();
echo $tc;

function tipoCambioDollarBCCR()
{
    // Tomado de: https://www.exchangecr.co y adaptado a PHP para retornar únicamente el valor de VENTA
    $url = "https://www.exchangecr.co/api/tipodecambio"; 

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    if (!empty($response)) {
        $result = json_decode($response);
        foreach($result as $data){
            if($data->divisa=='USdollar'){
                return number_format(floatval($data->venta),2);
            }
        }
    }else{
        return number_format(floatval(TIPOCAMBIO_DEFAULT),2);
    }
}

?>
