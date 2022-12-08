<?php

namespace app\models;

use vendor\core\base\Model;

class Paykeeper extends Model
{

    private string $user = "";
    private string $password = "";
    private string $secretSeed = "";

    public array $vars = [
        'id' => ['type' => 'int'],
        'sum' => ['type' => 'int'],
        'orderid' => ['type' => 'int'],
        'clientid' => ['type' => 'string'],
        'key' => ['type' => 'string'],
        'ps_id' => ['type' => 'string'],
        'fop_receipt_key' => ['type' => 'string'],
        'bank_id' => ['type' => 'string'],
        'card_number' => ['type' => 'string'],
        'card_holder' => ['type' => 'string'],
        'card_expiry' => ['type' => 'string'],
    ];

    public function getPayLink($orderId): string
    {
        return '/adm/order';
    }

}