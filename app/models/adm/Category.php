<?php

namespace app\models\adm;

use R;

class Category extends App
{

    public array $vars = [
        'id' => ['type' => 'int', 'lenght' => 9],
        'name' => ['type' => 'string', 'lenght' => 60],
        'description' => ['type' => 'string'],
        'comment' => ['type' => 'string', 'lenght' => 90],
        'sort' => ['type' => 'int', 'lenght' => 2],
        'photo' => ['type' => 'string'],
        'seo_title' => ['type' => 'string', 'lenght' => 250],
        'seo_description' => ['type' => 'string', 'lenght' => 250],
        's_hidden' => ['type' => 'int', 'lenght' => 1],
        's_status' => ['type' => 'string', 'lenght' => 150],
        's_text' => ['type' => 'string', 'lenght' => 150],
        's_order' => ['type' => 'string'],
    ];

    public function getQueryWhere(): string
    {
        if (notArray($this->vars['s_hidden'])) {
            $query = "is_hidden = '{$this->vars['s_hidden']}'";
        }

        if (notArray($this->vars['s_text'])) {
            $query = "
                        name LIKE '%{$this->vars['s_text']}%'
                    OR  url LIKE '%{$this->vars['s_text']}%'
                    OR  comment_admin LIKE '%{$this->vars['s_text']}%'
                    OR  description LIKE '%{$this->vars['s_text']}%'";
        }

        if (!isset($query)) {
            $query = "id > 0";
        }

        return $query;
    }

    private function prepare(): array
    {
        $url = translit($this->vars['name']);

        $var['url'] = $url;
        $var['description'] = $this->vars['description'];
        $var['name'] = $this->vars['name'];
        $var['comment_admin'] = $this->vars['comment'];
        $var['seo_title'] = $this->vars['seo_title'];
        $var['seo_description'] = $this->vars['seo_description'];

        return $var;
    }

    public function create()
    {
        $var = $this->prepare();

        $mainFolder = WWW . "/uploads/";
        if (!is_dir($mainFolder)) {
            mkdir($mainFolder);
        }

        $goodsFolder = WWW . "/uploads/goods/";
        if (!is_dir($goodsFolder)) {
            mkdir($goodsFolder);
        }

        $path = WWW . "/uploads/goods/{$var['url']}/";

        if (!is_dir($path)) {
            mkdir($path);
        }

        $obj = R::dispense('m_category');

        $obj['created_at'] = date('Y-m-d H:i:s');
        $obj['is_hidden'] = 1;

        foreach ($var as $name => $value) {
            $obj[$name] = $value;
        }

        R::store($obj);
    }

    public function save()
    {
        $var = $this->prepare();

        $obj = R::load('m_category', $this->vars['id']);

        $path = WWW . "/uploads/goods/";

        if (is_dir($path . $obj['url'])) {
            rename("$path{$obj['url']}/", "$path{$var['url']}/");
        }

        $obj['updated_at'] = date('Y-m-d H:i:s');

        foreach ($var as $name => $value) {
            $obj[$name] = $value;
        }

        R::store($obj);
    }

    public function delete()
    {
        $obj = R::load('m_category', $this->vars['id']);

        $path = WWW . "/uploads/goods/{$obj['url']}/";

        if (is_dir($path)) {
            deleteDirectory($path);
        }

        $this->simpleDelete('m_category');

        // все продукты в категории
        $products = R::findAll('m_product', "category_id = ?", [$obj['id']]);

        foreach ($products as $product) {
            // удаление карточки продукта
            R::exec("DELETE FROM m_product WHERE id = ?", [$product['id']]);

            // удаление данных со склада о товаре
            R::exec("DELETE FROM m_storage WHERE product_id = ?", [$product['id']]);
        }
    }

    public function uploadPhoto()
    {
        $obj = R::load('m_category', $this->vars['id']);

        $path = WWW . "/uploads/goods/{$obj['url']}/";

        if ($obj['photo']) {
            self::deletePhoto();
        }

        $file = filterString($_FILES[0]['name']);
        $fileExt = get_ext($file);
        $allowTypes = ['jpg', 'jpeg', 'png'];

        // проверка на корректность формата загружаемых файлов
        if (in_array($fileExt, $allowTypes)) {
            $dt = date('YmdHis', time());
            $fileName = $dt . '.' . $fileExt;

            if (move_uploaded_file($_FILES[0]['tmp_name'], $path . $fileName)) {
                resize("$path$fileName", "$path$fileName", 260, 0);
                resize("$path$fileName", "{$path}thumb-$fileName", 70, 0);

                $obj['updated_at'] = date('Y-m-d H:i:s');
                $obj['photo'] = $fileName;

                R::store($obj);
            }
        }
    }

    public function deletePhoto()
    {
        $obj = R::load('m_category', $this->vars['id']);

        $path = WWW . "/uploads/goods/{$obj['url']}/";

        if (file_exists($path . $obj['photo'])) {
            unlink($path . $obj['photo']);
            unlink($path . 'thumb-' . $obj['photo']);
        }

        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['photo'] = '';

        R::store($obj);
    }

    /**
     * Проверка перед сохранением
     */
    public function checkUniqueUrl(): bool
    {
        $query = "url = ? AND id != ?";
        $category = R::findOne('m_category', $query, [
            translit($this->vars['name']),
            $this->vars['id'],
        ]);

        if ($category) {
            $this->errors[] = 'non-unique-name';

            return false;
        }

        return true;
    }

    /**
     * Проверка перед созданием
     */
    public function checkExistUrl(): bool
    {
        $query = "url = ?";
        $category = R::findOne('m_category', $query, [
            translit($this->vars['name']),
        ]);

        if ($category) {
            $this->errors[] = 'non-unique-name';

            return false;
        }

        return true;
    }

}