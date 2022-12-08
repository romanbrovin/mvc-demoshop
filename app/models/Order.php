<?php

namespace app\models;

use R;
use vendor\core\base\Model;
use vendor\libs\Delivery;

class Order extends Model
{

    public array $vars = [
        'id' => ['type' => 'int'],
        'delivery_type' => ['type' => 'string'],
        'delivery_variant' => ['type' => 'string'],
        'delivery_price' => ['type' => 'int'],
        'delivery_days' => ['type' => 'string'],
        'deliveryMinDay' => ['type' => 'string'],
        'deliveryMaxDay' => ['type' => 'string'],
        'address' => ['type' => 'string'],
        'payment' => ['type' => 'int'],
        'comment_user' => ['type' => 'string'],
        'postcode' => ['type' => 'int'],
    ];

    public array $deliveryData = [];
    public array $requiredVars = [];
    public array $errors = [];

    /**
     * Создание нового заказа
     */
    public function create()
    {
        // общая сумма текущего заказа
        $orderSum = Basket::getTotalSum();

        $payment = 1;
        $cod = 0;
        $totalSum = $orderSum;

        (isAuth()) ? $role = 'user' : $role = '';

        $query = "
            INSERT INTO m_order
            SET     
                    uid = '{$_SESSION['uid']}'
                ,   created_at = NOW()
                ,   order_sum = '$orderSum'
                ,   payment = '$payment'
                ,   cod = '$cod'
                ,   total_sum = '$totalSum'
                ,   address = ''
                ,   marketplace = 'adv'
                ,   comment_user = ''
                ,   comment_admin = ''
                ,   role = '$role'";

        R::exec($query);

        // номер текущего заказа
        $orderId = R::getInsertID();

        Basket::setGoodsToOrder($orderId);

        setcookie('orderId', $orderId, time() + 86400, '/');
    }

    /**
     * Обновление данных внутри заказа в момент оформления заказа
     */
    public function update()
    {
        $order = R::load('m_order', $_COOKIE['orderId']);

        $courierAddresses = self::courierAddresses();

        $cod = 0;
        $deliveryDays = '';
        $deliveryVariant = '';

        if ($this->vars['delivery_type'] == 'mail') {
            $deliveryDays = $this->vars['delivery_days'];

            if (!is_array($this->vars['delivery_variant'])) {
                $deliveryVariant = $this->vars['delivery_variant'];
            }

            if (array_key_exists($this->vars['address'], $courierAddresses)) {
                $this->vars['address'] = '';
                $this->vars['delivery_price'] = 0;
            }

            if ($this->vars['payment'] == 2) {
                $cod = round(($order['order_sum'] + $this->vars['delivery_price']) * 0.04);
            }
        } else if ($this->vars['delivery_type'] == 'courier') {
            foreach ($courierAddresses as $name => $cost) {
                if ($this->vars['address'] == $name) {
                    $this->vars['delivery_price'] = $cost;
                }
            }
        }


        $totalSum = $order['order_sum'] + $this->vars['delivery_price'] + $cod - $order['bonus'];

        if ($totalSum < 1) {
            $totalSum = 1;
        }

        $query = "
            UPDATE m_order
            SET 
                    updated_at = NOW()
                ,   delivery_type = ?
                ,   delivery_variant = ?
                ,   delivery_price = ?
                ,   delivery_days = ?
                ,   cod = '$cod'
                ,   payment = ?
                ,   total_sum = '$totalSum'
                ,   address = ?
                ,   comment_user = ?
            WHERE 
                    id = '{$order['id']}'
                AND uid = '{$_SESSION['uid']}'";

        R::exec($query, [
            $this->vars['delivery_type'],
            $deliveryVariant,
            $this->vars['delivery_price'],
            $deliveryDays,
            $this->vars['payment'],
            $this->vars['address'],
            $this->vars['comment_user'],
        ]);
    }

    /**
     * Оформление заказа и уведомление клиента
     */
    public function checkout()
    {
        $query = "
            UPDATE m_order
            SET
                    checkouted_at = NOW()
                ,   uid = '{$_SESSION['user']['uid']}'
                ,   comment_user = ?
                ,   current_status = 'checkouted'
                ,   role = 'user'
            WHERE id = ?";

        R::exec($query, [
            $this->vars['comment_user'],
            $_COOKIE['orderId'],
        ]);


        $query = "
            UPDATE m_basket
            SET role = 'user'
            WHERE order_id = ?";

        R::exec($query, [$_COOKIE['orderId']]);

        // Письмо клиенту
        // $mail->send();


        // Письмо менеджеру
        // $mail->send();
    }

    /**
     * Список адресов и стоимости доставки курьером
     */
    public static function courierAddresses(): array
    {
        return [
            'Район-1' => 0,
            'Район-2' => 200,
            'Район-3' => 300,
            'Район-4' => 400,
        ];
    }

    /**
     * Проверка на "новый заказ"
     */
    public static function isNew(): bool
    {
        $query = "uid = ? AND id = ? AND current_status = 'new'";
        $count = R::count('m_order', $query, [
            $_SESSION['uid'],
            $_COOKIE['orderId'],
        ]);

        if ($count == 1) {
            return true;
        }

        return false;
    }

    /**
     * Списывание/возвращение бонусы пользователя в момент оформления заказа
     */
    public function setBonus()
    {
        $order = R::load('m_order', $_COOKIE['orderId']);

        if ($order['bonus'] == 0) {
            // если бонусов меньше чем текущая сумма минус 10 рублей (чтобы была минимальная оплата)
            if (($order['total_sum'] - 10) >= $_SESSION['user']['bonus']) {
                $bonus = $_SESSION['user']['bonus'];
                $_SESSION['user']['bonus'] = 0;
            } else {
                $bonus = $order['total_sum'] - 10;
                $_SESSION['user']['bonus'] -= $bonus;
            }
        } else {
            $bonus = 0;
            $_SESSION['user']['bonus'] += $order['bonus'];
        }

        $totalSum = $order['order_sum'] + $order['delivery_sum'] + $order['cod'] - $bonus;


        $query = "
            UPDATE m_order
            SET
                    updated_at = NOW()
                ,   bonus = '$bonus'
                ,   payment = '{$order['payment']}'
                ,   total_sum = '$totalSum'
            WHERE id = ? ";

        R::exec($query, [$_COOKIE['orderId']]);


        $query = "
            UPDATE m_user
            SET
                    updated_at = NOW()
                ,   bonus = '{$_SESSION['user']['bonus']}'
            WHERE uid = '{$_SESSION['user']['uid']}'";

        R::exec($query);
    }

    /**
     * Обнуление данных по доставке
     */
    public function resetDelivery()
    {
        $order = R::load('m_order', $_COOKIE['orderId']);

        $query = "
            UPDATE m_order
            SET
                    delivery_price = 0
                ,   delivery_days = ''
                ,   delivery_service = ''
                ,   cod = 0
                ,   total_sum = '{$order['order_sum']}'
                ,   address = ''
            WHERE 
                    id = '{$order['id']}'
                AND uid = '{$_SESSION['uid']}'";

        R::exec($query);
    }

    /**
     * Получение суммарного размера заказа (вес и средний объем)
     */
    private function getDimensions(): array
    {
        $basketData = R::findAll('m_basket', 'order_id = ?', [$_COOKIE['orderId']]);

        $dimensions['weight'] =
        $v = 0;

        foreach ($basketData as $basket) {
            $product = R::load('m_product', $basket['product_id']);

            if ($product['height_pack'] > 0) { // если введены данные об упаковке товара
                $v += $product['height_pack'] * $product['width_pack'] * $product['length_pack'];
                $dimensions['weight'] += $product['weight_pack'];
            } else {
                $v += $product['height'] * $product['width'] * $product['length'];
                $dimensions['weight'] += $product['weight'];
            }
        }

        $dimensions['avg'] = round(pow($v, 1 / 3));

        return $dimensions;
    }

    public function getCalculationDelivery(): bool
    {
        if (!$this->getDeliveryPostprice()) {
            return false;
        }

        return true;
    }

    private function getDeliveryPostprice(): bool
    {
        $dimensions = self::getDimensions();
        $dimensions['weight'] *= 1000;

        $calc = new Delivery();

        $postcodeFrom = 248000;
        $postcodeTo = $this->vars['postcode'];

        $result = $calc->getPricePostprice($postcodeFrom, $postcodeTo, $dimensions['weight']);
        $result = json_decode($result);


        if ($result->code == 103) {
            $this->vars['delivery_price'] = 0;
            $this->vars['address'] = '';
            $this->errors[] = 'errorDeliveryPrice';

            return false;
        }

        if (is_array($this->vars['deliveryMinDay'])) {
            $this->vars['deliveryMinDay'] = 2;
            $this->vars['deliveryMaxDay'] = 5;

            $this->deliveryData['minDay'] = $this->vars['deliveryMinDay'];
            $this->deliveryData['maxDay'] = $this->vars['deliveryMaxDay'];
        }

        $this->vars['delivery_price'] = round($result->pkg);

        $this->deliveryData['price'] = $this->vars['delivery_price'];


        return true;
    }

}