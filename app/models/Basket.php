<?php

namespace app\models;

use R;
use vendor\core\base\Model;

class Basket extends Model
{

    public array $vars = [
        'basketId' => ['type' => 'int', 'lenght' => 9],
        'productId' => ['type' => 'int', 'lenght' => 9],
        'currentAmount' => ['type' => 'int', 'lenght' => 6],
        'newPrice' => ['type' => 'int', 'lenght' => 9],
    ];

    /**
     * Добавление нового товара
     */
    public function add()
    {
        // проверка на существование товара в корзине
        $query = 'uid = ? AND product_id = ? AND is_checkout = 0';
        $count = R::count('m_basket', $query, [
            $_SESSION['uid'],
            $this->vars['productId']
        ]);

        $product = Product::getById($this->vars['productId']);

        $role = '';
        if (isAuth()) {
            (isAdmin()) ? $role = 'admin' : $role = 'user';
        }

        // товара нет в корзине
        if ($count == 0) {
            $query = "
                INSERT INTO m_basket
                SET 
                        uid = '{$_SESSION['uid']}'
                    ,   created_at = NOW()
                    ,   updated_at = NOW()
                    ,   product_id = ?
                    ,   order_id = 0
                    ,   amount = 1
                    ,   price_adv = '{$product['price_adv_discount']}'
                    ,   price_dbs = '{$product['price_dbs_discount']}'
                    ,   price_ozon = '{$product['price_ozon_discount']}'
                    ,   price_wb = '{$product['price_wb_discount']}'
                    ,   price_avito = '{$product['price_avito_discount']}'
                    ,   price_avg = '{$product['price_avg']}'
                    ,   role = '$role'";

            R::exec($query, [$this->vars['productId']]);
        } else {
            // сколько уже добавлено в корзину товара
            $query = "uid = ? AND product_id = ? AND is_checkout = 0";
            $basket = R::findOne('m_basket', $query, [
                $_SESSION['uid'],
                $this->vars['productId']
            ]);

            if ($product['amount_active'] > $basket['amount']) {
                $query = "
                    UPDATE m_basket
                    SET 
                            updated_at = NOW()
                        ,   amount = amount + 1
                    WHERE 
                            uid = '{$_SESSION['uid']}'
                        AND product_id = ?
                        AND is_checkout = 0";

                R::exec($query, [$this->vars['productId']]);
            }
        }
    }

    /**
     * Удаление товара из корзины
     */
    public function delete()
    {
        $query = "
            DELETE FROM m_basket
            WHERE 
                    id = ?
                AND uid = '{$_SESSION['uid']}'";

        R::exec($query, [$this->vars['basketId']]);
    }

    /**
     * Общая сумма товаров в корзине
     */
    public static function getTotalSum()
    {
        $query = "
            SELECT SUM(price_adv * amount)
            FROM m_basket
            WHERE
                    uid = '{$_SESSION['uid']}'
                AND is_checkout = 0";

        return R::getCell($query);
    }

    /**
     * Кол-во товаров в корзине
     */
    public static function getCount()
    {
        $query = "
            SELECT SUM(amount)
            FROM m_basket
            WHERE
                    uid = '{$_SESSION['uid']}'
                AND is_checkout = 0";

        return R::getCell($query);
    }

    /**
     * Список всех товаров по UID клиента
     */
    public static function getListByUid(): array
    {
        $query = "
            SELECT *,
                (
                    SELECT article
                    FROM m_product
                    WHERE id = m_basket.product_id
                ) as article
            FROM m_basket
            WHERE
                    uid = '{$_SESSION['uid']}'
                AND is_checkout = 0";

        return R::getAll($query);
    }

    /**
     * Список товаров в корзине по UID клиента и ID заказа
     */
    public static function getListByUidAndOrderId(): array
    {
        $query = "
            SELECT *,
                (
                    SELECT article
                    FROM m_product
                    WHERE id = m_basket.product_id
                ) as article
            FROM m_basket
            WHERE
                    uid = '{$_SESSION['uid']}'
                AND order_id = ?";

        return R::getAll($query, [$_COOKIE['orderId']]);
    }

    /**
     * Администратор устанавливает свою цену на товар для списания со склада
     */
    public function setPrice()
    {
        $query = "
            UPDATE m_basket 
            SET price_adv = ?
            WHERE 
                    id = ?
                AND uid = '{$_SESSION['uid']}'";

        R::exec($query, [
            $this->vars['newPrice'],
            $this->vars['basketId'],
        ]);
    }

    /**
     * Изменение кол-во товаров в корзине
     */
    public function setAmount()
    {
        $query = "
            SELECT amount_active
            FROM m_product
            WHERE id = 
                (
                    SELECT product_id
                    FROM m_basket
                    WHERE
                            id = ?
                        AND uid = '{$_SESSION['uid']}'
                    LIMIT 1
                )
            LIMIT 1";

        // проверка остатков товара
        $amountActive = R::getCell($query, [$this->vars['basketId']]);

        $query = "
            SELECT amount
            FROM m_basket
            WHERE
                    id = ?
                AND uid = '{$_SESSION['uid']}'
                AND is_checkout = 0
            LIMIT 1";

        // сколько уже добавлено в корзину товара
        $totalAmount = R::getCell($query, [$this->vars['basketId']]);

        if ($amountActive > $totalAmount || $amountActive > $this->vars['currentAmount']) {
            $query = "
                UPDATE m_basket 
                SET amount = ? 
                WHERE 
                        id = ?
                    AND uid ='{$_SESSION['uid']}'";

            R::exec($query, [
                $this->vars['currentAmount'],
                $this->vars['basketId']
            ]);

            return $this->vars['currentAmount'];
        } else {
            return false;
        }
    }

    public static function isProductInBasket($productId): bool
    {
        $query = "
            SELECT id
            FROM m_basket
            WHERE
                    uid = '{$_SESSION['uid']}'
                AND product_id = ?
                AND is_checkout = 0";

        $result = R::getCell($query, [$productId]);

        if ($result) {
            return false;
        }

        return true;
    }

    /**
     * Присваиваение всех товаров к заказу
     */
    public static function setGoodsToOrder($orderId)
    {
        $query = "uid = ? AND is_checkout = 0";
        $basketList = R::findAll('m_basket', $query, [$_SESSION['uid']]);

        foreach ($basketList as $basket) {
            $basket['order_id'] = $orderId;
            $basket['is_checkout'] = 1;

            R::store($basket);
        }
    }

}