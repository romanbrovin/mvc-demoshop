<?php

namespace app\models;

use R;
use vendor\core\base\Model;

class Cabinet extends Model
{

    public array $vars = [
        'orderId' => ['type' => 'int', 'lenght' => 9],
    ];

    /**
     * Список заказов клиента
     */
    public static function getOrders(int $limitStart, int $perPage): array
    {
        $query = "
            SELECT *
            FROM m_order
            WHERE uid = '{$_SESSION['user']['uid']}'
            ORDER BY can_cancel DESC, id DESC
            LIMIT $limitStart, $perPage";

        return R::getAll($query);
    }

    /**
     * Клиент отменяет заказ
     */
    public function cancelOrder()
    {
        $query = "
            UPDATE m_order
            SET
                    canceled_at = NOW()
                ,   current_status = 'canceled'
                ,   can_cancel = 0
            WHERE 
                    id = ?
                AND uid = '{$_SESSION['uid']}'";

        R::exec($query, [$this->vars['orderId']]);


        // Возврат списанных бонусов
        $order = R::findOne('m_order', "uid = ? AND id = ?", [$_SESSION['uid'], $this->vars['orderId']]);

        if ($order['bonus'] > 0) {
            $_SESSION['user']['bonus'] += $order['bonus'];

            $query = "
                UPDATE m_user
                SET
                        updated_at = NOW()
                    ,   bonus = '{$_SESSION['user']['bonus']}'
                WHERE uid = '{$_SESSION['user']['uid']}'";

            R::exec($query);
        }

        // Письмо клиенту
        // $mail->send();
    }

}