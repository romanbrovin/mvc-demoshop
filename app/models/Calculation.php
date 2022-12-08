<?php

namespace app\models;

use R;
use vendor\core\base\Model;

class Calculation extends Model
{

    /**
     * Расчет себестоимости, реализации, остатков, прибыли
     */
    public static function calc(int $productId = null)
    {
        $queryProduct =
        $queryCategory = null;

        $fields = require ROOT . '/config/fields.php';

        if (($productId) && $productId > 0) {
            $product = R::load('m_product', $productId);

            $queryProduct = "id = $productId";
            $queryCategory = "id = {$product['category_id']}";
        } else {
            foreach ($fields as $item => $key) {
                if ($key == 'summary') {
                    $query = "
                        UPDATE m_const
                        SET
                                updated_at = NOW()
                            ,   value = 0
                        WHERE name = '$item'";

                    R::exec($query);
                }
            }
        }


        // Считаем усредненную цену закупки, остатки и доходность для товара
        $products = R::findAll('m_product', $queryProduct);

        foreach ($products as $product) {
            $query = "
                SELECT
                        (-- кол-во всех товаров на складе
                            SELECT SUM(amount)
                            FROM m_storage
                            WHERE product_id = '{$product['id']}'
                        ) as amount
                    ,   (-- кол-во активных товаров на складе
                            SELECT SUM(amount)
                            FROM m_storage
                            WHERE
                                    product_id = '{$product['id']}' 
                                AND is_hidden = 0
                        ) as amount_active
                    ,   (-- средняя цена закупки у активных товаров
                            SELECT SUM(price*amount)
                            FROM m_storage
                            WHERE
                                    product_id = '{$product['id']}' 
                                AND is_hidden = 0
                        ) as price_avg
                FROM m_storage
                WHERE product_id = '{$product['id']}'
                LIMIT 1";

            $storage = R::getRow($query);

            // средняя цена покупки
            $product['price_avg'] = (isset($storage['price_avg'])) ? $storage['price_avg'] : 0;
            // остатки товара
            $product['amount'] = (isset($storage['amount'])) ? $storage['amount'] : 0;
            // остатки активного товара
            $product['amount_active'] = (isset($storage['amount_active'])) ? $storage['amount_active'] : 0;

            $marketplaceList = R::findAll('m_marketplace');

            foreach ($marketplaceList as $marketplace) {
                $name = $marketplace['short_name'];

                $product["price_{$name}_discount_sum"] = 0;
                $product["price_{$name}_discount_percent"] = 0;
                $product["price_{$name}_profit"] = 0;
                $product["price_{$name}_profit_percent"] = 0;
            }

            if ($product['amount_active'] > 0) { // если есть активный товар
                // считаем среднюю цену покупки
                $product['price_avg'] = $product['price_avg'] / $product['amount_active'];

                foreach ($marketplaceList as $marketplace) {
                    $name = $marketplace['short_name'];

                    if ($product["price_{$name}_discount"] > 0) { // цена со скидкой
                        $product["price_{$name}_profit"] = $product["price_{$name}_discount"] - $product['price_avg'];
                    } else if ($product["price_$name"] > 0) { // цена без скидки
                        $product["price_{$name}_profit"] = $product["price_$name"] - $product['price_avg'];
                    }

                    $product["price_{$name}_profit_percent"] = $product["price_{$name}_profit"] / $product['price_avg'] * 100;
                    $product["price_{$name}_discount_sum"] = $product["price_$name"] - $product["price_{$name}_discount"];

                    if ($product["price_{$name}_discount_sum"] > 0) {
                        $product["price_{$name}_discount_percent"] = $product["price_{$name}_discount_sum"] / $product["price_$name"] * 100;
                    }
                }
            }

            R::store($product);
        }


        // Считаем данные по стоимости для категорий
        $categories = R::findAll('m_category', $queryCategory);

        foreach ($categories as $category) {
            $costAll =
            $costActive =
            $sellingActive = 0;

            // считаем остатки товаров для текущей категории
            $query = "
                SELECT
                        SUM(amount) as amount_all
                    ,   SUM(amount_active) as amount_active
                FROM m_product
                WHERE category_id = '{$category['id']}'
                LIMIT 1";

            $product = R::getRow($query);

            $amountAll = $product['amount_all'];
            $amountActive = $product['amount_active'];

            // берем все продукты из текущей категории
            $products = R::findAll('m_product', "category_id = '{$category['id']}'");

            foreach ($products as $product) {
                // себестоимость товаров
                $query = "
                    SELECT
                            (-- считаем себестоимость всех товаров
                                SELECT SUM(price*amount)
                                FROM m_storage
                                WHERE product_id = '{$product['id']}'
                            ) as cost_all
                        ,   (-- считаем себестоимость активных товаров
                                SELECT SUM(price*amount)
                                FROM m_storage
                                WHERE
                                        product_id = '{$product['id']}'
                                    AND is_hidden = 0
                            ) as cost_active
                    FROM m_storage
                    WHERE product_id = '{$product['id']}'";

                $storage = R::getRow($query);

                if (isset($storage['cost_all'])) {
                    $costAll += $storage['cost_all'];
                }

                if (isset($storage['cost_active'])) {
                    $costActive += $storage['cost_active'];
                }

                // считаем реализацию активных товаров в текущей категории
                if ($product['price_adv_discount'] > 0) {
                    $sellingActive += $product['amount_active'] * $product['price_adv_discount'];
                } else {
                    $sellingActive += $product['amount_active'] * $product['price_adv'];
                }

                // обновляем данные по текущей категории
                $query = "
                    UPDATE m_category
                    SET
                            cost_all = '$costAll'
                        ,   cost_active = '$costActive'
                        ,   selling_active = '$sellingActive'
                        ,   amount_all = '$amountAll'
                        ,   amount_active = '$amountActive'
                    WHERE name = '{$category['name']}'";

                R::exec($query);
            }
        }


        // Обновление общей себестоимости, реализации и остатков для всех товаров
        $query = "
            SELECT
                    SUM(cost_all) as cost_all
                ,   SUM(cost_active) as cost_active
                ,   SUM(selling_active) as selling_active
                ,   SUM(amount_all) as amount_all
                ,   SUM(amount_active) as amount_active
            FROM m_category";

        $category = R::getRow($query);

        $cost_all = $category['cost_all'];
        $cost_active = $category['cost_active'];
        $selling_active = $category['selling_active'];
        $amount_all = $category['amount_all'];
        $amount_active = $category['amount_active'];
        $income_money = $selling_active - $cost_active; // доход в рублях
        $income_percent = 0;

        if ($selling_active > 0) { // если в продаже есть товары
            $income_percent = round($income_money / $cost_active * 100);
        }

        foreach ($fields as $item => $key) {
            if ($key == 'summary') {
                $query = "
                    UPDATE m_const
                    SET
                            updated_at = NOW()
                        ,   value = '${$item}'
                    WHERE name = '$item'";

                R::exec($query);
            }
        }
    }

    /**
     * Списание товара со склада
     */
    public static function writeOff(int $orderId)
    {
        // Данные из корзины по текущему заказу
        $query = '
            SELECT *,
                (
                    SELECT amount_active
                    FROM m_product
                    WHERE id = m_basket.product_id
                    LIMIT 1
                ) as amount_active,
                (
                    SELECT bonus
                    FROM m_product
                    WHERE id = m_basket.product_id
                    LIMIT 1
                ) as bonus,
                (
                    SELECT price_adv_discount
                    FROM m_product
                    WHERE id = m_basket.product_id
                    LIMIT 1
                ) as price_adv_discount
            FROM m_basket
            WHERE order_id = ?';

        $basketList = R::getAll($query, [$orderId]);

        $bonus = 0;

        foreach ($basketList as $basket) {
            if (!isset($uid)) {
                $uid = $basket['uid'];
            }

            // Кол-во бонусов для текущего продукта + другие бонусы этого заказа
            $bonus += $basket['price_adv_discount'] / 100 * $basket['bonus'] * $basket['amount'];

            // Товара в продаже больше/равно товара в корзине
            if ($basket['amount_active'] >= $basket['amount']) {
                // Все активные товары со склада по этому товару
                $query = "product_id = {$basket['product_id']} AND is_hidden = 0";
                $storageList = R::findAll('m_storage', $query);

                foreach ($storageList as $storage) {
                    // Если в позиции на складе хватает товара
                    if ($storage['amount'] >= $basket['amount']) {
                        $storage['amount'] -= $basket['amount'];

                        // Если не осталось товара в этой позиции
                        if ($storage['amount'] == 0) {
                            R::trash($storage);
                        } else {
                            // Обновление кол-ва товара на складе по текущему продукту
                            R::store($storage);
                        }

                        goto end;
                    } else {
                        R::trash($storage);
                    }

                    $basket['amount'] -= $storage['amount'];
                }

                end:
            }

            Calculation::setAmountInProduct($basket['product_id']);
            Calculation::calc($basket['product_id']);
        }

        Calculation::setBonusesToUser($bonus, $uid);
    }

    /**
     * Обновление остатков у продукта
     */
    private static function setAmountInProduct($productId)
    {
        // Общее кол-во товаров на складе
        $query = "
            SELECT
                    (
                        SELECT SUM(amount)
                        FROM m_storage
                        WHERE product_id = '$productId'
                    ) as amount
                ,   (
                        SELECT SUM(amount)
                        FROM m_storage
                        WHERE
                                product_id = '$productId'
                            AND is_hidden = 0
                    ) as amount_active
                FROM m_storage
                WHERE product_id = '$productId'";

        $storage = R::getRow($query);

        $amount =
        $amountActive = 0;

        if (isset($storage['amount']) && $storage['amount']) {
            $amount = $storage['amount'];
        }

        if (isset($storage['amount_active']) && $storage['amount_active']) {
            $amountActive = $storage['amount_active'];
        }

        // Обновление данных в продукте
        $query = "
            UPDATE m_product
            SET
                    amount_active = '$amountActive'
                ,   amount = '$amount'
            WHERE id = '$productId'";

        R::exec($query);

        // Если на продаже нет активных товаров
        if ($amountActive == 0) {
            // Обнуление средней цены закупки
            $query = "
                UPDATE m_product
                SET price_avg = 0
                WHERE id = '$productId'";

            R::exec($query);
        }
    }

    /**
     * Начисление бонусов клиенту
     */
    private static function setBonusesToUser($bonus, $uid)
    {
        $user = R::findOne('m_user', "uid = ?", [$uid]);

        $totalBonuses = $bonus + $user['bonus'];

        $query = "
            UPDATE m_user
            SET
                    bonus = '$totalBonuses'
                ,   purchases = purchases + 1
            WHERE uid = '{$user['uid']}'";

        R::exec($query);
    }

}