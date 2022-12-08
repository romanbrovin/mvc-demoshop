<?php

namespace app\models\adm;

use app\models\Basket;
use app\models\Calculation;
use R;

class Order extends App
{

    public array $vars = [
        'id' => ['type' => 'int', 'lenght' => 9],
        'payment' => ['type' => 'int', 'lenght' => 1],
        'delivery_service' => ['type' => 'string', 'lenght' => 50],
        'delivery_track' => ['type' => 'string', 'lenght' => 30],
        'delivery_variant' => ['type' => 'string', 'lenght' => 100],
        'delivery_price' => ['type' => 'int', 'lenght' => 9],
        'delivery_days' => ['type' => 'string', 'lenght' => 20],
        'address' => ['type' => 'string'],
        'comment' => ['type' => 'string', 'lenght' => 90],
        'marketplace' => ['type' => 'string', 'lenght' => 10],
        'marketplace_order' => ['type' => 'string', 'lenght' => 100],
        's_order_id' => ['type' => 'int', 'lenght' => 9],
        's_user_id' => ['type' => 'int', 'lenght' => 9],
        's_text' => ['type' => 'string', 'lenght' => 150],
        's_status' => ['type' => 'string', 'lenght' => 100],
        's_payment' => ['type' => 'int', 'lenght' => 1],
        's_marketplace' => ['type' => 'string', 'lenght' => 10],
        's_order' => ['type' => 'string'],
    ];

    public function getQueryWhere(): string
    {
        if (notArray($this->vars['s_status'])) {
            $query[] = "current_status = '{$this->vars['s_status']}'";
        }

        if (notArray($this->vars['s_payment'])) {
            $query[] = "payment = {$this->vars['s_payment']}";
        }

        if (notArray($this->vars['s_marketplace'])) {
            $query[] = "marketplace = '{$this->vars['s_marketplace']}'";
        }

        if (notArray($this->vars['s_order_id'])) {
            $query[] = "id = '{$this->vars['s_order_id']}'";
        }

        if (notArray($this->vars['s_user_id'])) {
            $query[] = "
                uid IN
                    (
                        SELECT uid
                        FROM m_user
                        WHERE 
                                id = {$this->vars['s_user_id']}
                            AND role = 'user'
                    )";
        }

        if (notArray($this->vars['s_text'])) {
            $query[] = "
                (
                        id LIKE '%{$this->vars['s_text']}%'
                    OR  delivery_track LIKE '%{$this->vars['s_text']}%'
                    OR  address LIKE '%{$this->vars['s_text']}%'
                    OR  comment_admin LIKE '%{$this->vars['s_text']}%'
                    OR  delivery_service LIKE '%{$this->vars['s_text']}%'
                    OR  marketplace_order LIKE '%{$this->vars['s_text']}%'
                    OR  id IN
                        (
                            SELECT order_id
                            FROM m_basket
                            WHERE product_id =
                                (
                                    SELECT id
                                    FROM m_product
                                    WHERE article LIKE '%{$this->vars['s_text']}%'
                                    LIMIT 1
                                ) 
                        )
                    OR  uid IN
                        (
                            SELECT uid
                            FROM m_user
                            WHERE
                                (
                                        name LIKE '%{$this->vars['s_text']}%' 
                                    OR  surname LIKE '%{$this->vars['s_text']}%'
                                    OR  phone LIKE '%{$this->vars['s_text']}%'
                                    OR  email LIKE '%{$this->vars['s_text']}%'
                                )
                                AND role = 'user'
                        )
                )";
        }

        if (!isset($query)) {
            $query = "current_status != 'new'";
        } else {
            $query = implode(' AND ', $query);
        }

        return $query;
    }

    /**
     * Менеджер создает заказ под маркетплейс
     */
    public function createByMarketplace()
    {
        $user = new \app\models\User();
        $uid = $user->create();

        // общая сумма текущего заказа
        $field = 'price_' . $this->vars['marketplace'];
        $query = "
            SELECT SUM($field * amount)
            FROM m_basket
            WHERE
                    uid = '{$_SESSION['uid']}'
                AND is_checkout = 0";

        $orderSum = R::getCell($query);

        $order = R::dispense('m_order');
        $order['uid'] = $uid;
        $order['created_at'] = date('Y-m-d H:i:s');
        $order['updated_at'] = date('Y-m-d H:i:s');
        $order['checkouted_at'] = date('Y-m-d H:i:s');
        $order['payment'] = 2;
        $order['order_sum'] = $orderSum;
        $order['total_sum'] = $orderSum;
        $order['marketplace'] = $this->vars['marketplace'];
        $order['address'] = '';
        $order['comment_user'] = '';
        $order['comment_admin'] = '';
        $order['current_status'] = 'checkouted';
        $order['role'] = 'user';
        R::store($order);

        // номер текущего заказа
        $orderId = R::getInsertID();

        Basket::setGoodsToOrder($orderId);
    }

    /**
     * Сохранение менеджером изменений в заказе
     */
    public function save()
    {
        $order = R::load('m_order', $this->vars['id']);

        if ($order['delivery_price'] != $this->vars['delivery_price']) {
            $order['delivery_price'] = $this->vars['delivery_price'];
        }

        if (!is_array($this->vars['delivery_days'])) {
            $order['delivery_days'] = $this->vars['delivery_days'];
        }

        if ($order['delivery_type'] == 'mail') {
            if ($order['delivery_variant'] != $this->vars['delivery_variant']) {
                if ($this->vars['delivery_variant'] == 'courier') {
                    $order['delivery_price'] += 200;
                } else {
                    $order['delivery_price'] -= 200;
                }
            }
        } else {
            $this->vars['delivery_variant'] = '';
        }

        if ($this->vars['payment'] == 2 && $order['delivery_type'] == 'mail') {
            $order['cod'] = round(($order['order_sum'] + $order['delivery_price']) * 0.04);
        } else {
            $order['cod'] = 0;
        }

        $order['total_sum'] = $order['order_sum'] + $order['delivery_price'] + $order['cod'] - $order['bonus'];
        $order['payment'] = $this->vars['payment'];
        $order['address'] = $this->vars['address'];
        $order['delivery_variant'] = $this->vars['delivery_variant'];
        $order['comment_admin'] = $this->vars['comment'];

        R::store($order);
    }

    /**
     * Подтверждение заказа. Уведомление клиента
     */
    public function confirmed()
    {
        $order = R::load('m_order', $this->vars['id']);
        $order['confirmed_at'] = date('Y-m-d H:i:s');
        $order['current_status'] = 'confirmed';

        R::store($order);

        Calculation::writeOff($this->vars['id']);

        $user = R::findOne('m_user', 'uid = ?', [$order['uid']]);

        // Письмо клиенту
        // $mail->send();
    }

    /**
     * Заказ отправлен. Уведомление клиента
     */
    public function transited()
    {
        $order = R::load('m_order', $this->vars['id']);

        $order['transited_at'] = date('Y-m-d H:i:s');
        $order['current_status'] = 'transited';

        R::store($order);

        // Письмо клиенту
        // $mail->send();
    }

    /**
     * Заказ доставлен. Запись в отчет. Уведомление клиента
     */
    public function delivered()
    {
        $order = R::load('m_order', $this->vars['id']);
        $order['delivered_at'] = date('Y-m-d H:i:s');
        $order['can_cancel'] = 0;
        $order['current_status'] = 'delivered';
        R::store($order);

        $profit = self::calculateProfit($this->vars['id']);

        Report::add('order', $this->vars['id'], $profit);

        $query = "
            UPDATE m_user
            SET purchases = purchases+1
            WHERE uid = '{$order['uid']}'";

        R::exec($query);

        // Письмо клиенту
        // $mail->send();
    }

    /**
     * Менеджер списываем товар со склада. Запись в отчет
     */
    public static function writtenOff()
    {
        // общая сумма текущего заказа
        $orderSum = Basket::getTotalSum();

        $order = R::dispense('m_order');
        $order['uid'] = $_SESSION['uid'];
        $order['created_at'] = date('Y-m-d H:i:s');
        $order['written_off_at'] = date('Y-m-d H:i:s');
        $order['payment'] = 0;
        $order['delivery_type'] = 'written_off';
        $order['order_sum'] = $orderSum;
        $order['total_sum'] = $orderSum;
        $order['address'] = '';
        $order['marketplace'] = 'adv';
        $order['current_status'] = 'written_off';
        $order['comment_user'] = '';
        $order['comment_admin'] = '';
        $order['can_cancel'] = 0;
        $order['role'] = 'admin';
        R::store($order);

        // номер текущего заказа
        $orderId = R::getInsertID();

        Basket::setGoodsToOrder($orderId);

        $profit = self::calculateProfit($orderId);

        Report::add('order', $order['id'], $profit);

        Calculation::writeOff($orderId);
    }

    /**
     * Расчет доходности заказа
     */
    private static function calculateProfit($orderId)
    {
        $order = R::load('m_order', $orderId);
        $order['costs'] = $order['delivery_price'] + $order['cod'] + $order['bonus'];

        $basketList = R::findAll('m_basket', "order_id = {$order['id']}");
        foreach ($basketList as $basket) {
            $order['costs'] += $basket['price_avg'] * $basket['amount'];
        }

        $order['profit'] = $order['total_sum'] - $order['costs'];

        R::store($order);

        return $order['profit'];
    }

    /**
     * Отмена заказа менеджером
     */
    public function canceled()
    {
        $order = R::load('m_order', $this->vars['id']);

        if ($order['current_status'] != 'checkouted' && $order['current_status'] != 'new') {
            self::returnBonusesToUser($this->vars['id']);
            self::returnGoodsToStorage();
        }

        $order['canceled_at'] = date('Y-m-d H:i:s');
        $order['can_cancel'] = 0;
        $order['current_status'] = 'canceled';
        R::store($order);

    }

    /**
     * Возврат товара из заказа обратно на склад. Удаление записи в отчете
     */
    public function returned()
    {
        $order = R::load('m_order', $this->vars['id']);

        if ($order['payment'] == 1) {
            $query = "
                UPDATE m_paykeeper
                SET
                        updated_at = NOW()
                    ,   is_return = 1
                WHERE order_id = {$order['id']}";

            R::exec($query, [$this->vars['id']]);
        }

        $order['returned_at'] = date('Y-m-d H:i:s');
        $order['current_status'] = 'returned';
        R::store($order);

        Report::delete('order', $this->vars['id']);

        self::returnBonusesToUser($this->vars['id']);
        self::returnGoodsToStorage();
    }

    /**
     * Возврат клиенту списанных бонусов
     */
    private static function returnBonusesToUser($orderId)
    {
        $order = R::load('m_order', $orderId);

        if ($order['bonus'] > 0) {
            $user = R::findOne('m_user', 'uid = ?', [$order['uid']]);
            $user['bonus'] += $order['bonus'];

            $query = "
                UPDATE m_user
                SET
                        updated_at = NOW()
                    ,   bonus = '{$user['bonus']}'
                WHERE uid = '{$order['uid']}'";

            R::exec($query);
        }
    }

    /**
     * Возрат товара на склад
     */
    private function returnGoodsToStorage()
    {
        $basketList = R::findAll('m_basket', 'order_id = ?', [$this->vars['id']]);

        foreach ($basketList as $basket) {
            // Добавление товара на склад
            $storage = R::dispense('m_storage');
            $storage['created_at'] = date('Y-m-d H:i:s');
            $storage['product_id'] = $basket['product_id'];
            $storage['price'] = $basket['price_avg'];
            $storage['amount'] = $basket['amount'];
            $storage['is_hidden'] = 1;
            R::store($storage);

            $product = R::load('m_product', $basket['product_id']);

            // Подсчет кол-во товара на складе по ID продукта
            $query = "
                SELECT SUM(amount)
                FROM m_storage
                WHERE product_id = '{$basket['product_id']}'";

            // Обновление данных по остатку в продукте
            $product['amount'] = R::getCell($query);
            R::store($product);

            Calculation::calc($product['id']);
        }
    }

    /**
     * Установка сервиса доставки
     */
    public function setDeliveryService()
    {
        $order = R::load('m_order', $this->vars['id']);
        $order['delivery_service'] = $this->vars['delivery_service'];
        R::store($order);
    }

    /**
     * Установка трек-номера
     */
    public function setDeliveryTrack()
    {
        $order = R::load('m_order', $this->vars['id']);
        $order['delivery_track'] = $this->vars['delivery_track'];
        R::store($order);
    }

    public function setMarketplaceOrder()
    {
        $order = R::load('m_order', $this->vars['id']);
        $order['marketplace_order'] = $this->vars['marketplace_order'];
        R::store($order);
    }

}