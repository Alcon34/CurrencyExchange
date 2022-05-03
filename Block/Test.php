<?php

namespace Tsimashkou\CurrencyExchange\Block;

use Magento\Framework\View\Element\Template;

class Test extends Template
{
    public function getCurrencyRate()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/fixer/latest?symbols=&base=USD",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: oDu7rJ3O5L0FV7Ea7kH0Rxkn0H16QopB"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return  json_decode($response);
        //return 'sdds';
    }

}
