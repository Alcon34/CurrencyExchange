<?php

namespace Tsimashkou\CurrencyExchange\Cron;

use Magento\Tests\NamingConvention\true\resource;

class UpdateRate
{
    public function execute() {


    }

    public function getCurrencyRate()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/fixer/latest?symbols=symbols&base=usd",
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
        return $response;
    }

}
