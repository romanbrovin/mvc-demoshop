<?php

namespace vendor\libs;

class Delivery
{

    public function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $i = curl_exec($ch);
        curl_close($ch);

        return $i;
    }

    public function getPricePostprice($postcodeFrom, $postcodeTo, $weight)
    {
        return $this->curl("https://postprice.ru/engine/russia/api.php?from=" . $postcodeFrom .
                           "&to=" . $postcodeTo .
                           "&mass=" . $weight);
    }

}
