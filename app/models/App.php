<?php

namespace app\models;

use R;
use vendor\core\base\Model;

class App extends Model
{

    protected static $categories; // Список категорий

    public static function getCategories(): array
    {
        if (self::$categories === null) {
            self::$categories = R::findAll('m_category', 'is_hidden = 0 ORDER BY sort_order DESC');
        }

        return self::$categories;
    }

    /**
     * Вывод блока (компонента) вместе с CSS и JS файлами
     *
     * @param string $name имя блока
     * @param array  $params переменные для блока
     */
    public static function renderBlock(string $name, array $params = [])
    {
        if (is_array($params)) {
            extract($params);
        }

        if (false == strpos($name, '/')) {
            $block_folder = $block_name = $name;
        } else {
            $name = explode('/', $name);

            $block_folder =
            $block_name =
                null;

            foreach ($name as $key => $item) {
                if ($key == 0) {
                    $block_folder .= lcfirst($name[0]);
                } else {
                    $block_folder .= '/' . $item;
                    $block_name = $item;
                }
            }
        }

        $block_css = "/blocks/$block_folder/$block_name.min.css";
        if (file_exists(WWW . $block_css)) {
            echo "<link href=\"$block_css\" rel=\"stylesheet\">" . PHP_EOL;
        }

        $block_html = WWW . "/blocks/$block_folder/$block_name.php";
        if (file_exists($block_html)) {
            require $block_html;
        }

        $block_js = "/blocks/$block_folder/$block_name.min.js";
        if (file_exists(WWW . $block_js)) {
            echo "<script src=\"$block_js\"></script>" . PHP_EOL;
        }
    }

    public static function findCells($cells, $table, $id): ?array
    {
        $query = "
            SELECT $cells
            FROM $table
            WHERE id = $id
            LIMIT 1";

        return R::getRow($query);
    }

    public static function findCell($cell, $table, $id)
    {
        $query = "
            SELECT $cell
            FROM $table
            WHERE id = $id
            LIMIT 1";

        return R::getCell($query);
    }

}
