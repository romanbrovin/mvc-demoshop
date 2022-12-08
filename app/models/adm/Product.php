<?php

namespace app\models\adm;

use app\models\Calculation;
use R;

class Product extends App
{

    private string $table = 'm_product';

    public array $vars = [
        'id' => ['type' => 'int', 'lenght' => 9],
        'article' => ['type' => 'string', 'lenght' => 20],
        'barcode' => ['type' => 'string', 'lenght' => 11],
        'name' => ['type' => 'string', 'lenght' => 150],
        'category_id' => ['type' => 'int', 'lenght' => 9],
        'preview' => ['type' => 'string'],
        'description' => ['type' => 'string'],
        'parts' => ['type' => 'int', 'lenght' => 5],
        'figures' => ['type' => 'int', 'lenght' => 4],
        'age' => ['type' => 'int', 'lenght' => 3],
        'year' => ['type' => 'int', 'lenght' => 4],
        'youtube' => ['type' => 'string'],
        'length' => ['type' => 'int', 'lenght' => 4],
        'width' => ['type' => 'int', 'lenght' => 4],
        'height' => ['type' => 'int', 'lenght' => 4],
        'weight' => ['type' => 'float', 'lenght' => 6],
        'length_pack' => ['type' => 'int', 'lenght' => 4],
        'width_pack' => ['type' => 'int', 'lenght' => 4],
        'height_pack' => ['type' => 'int', 'lenght' => 4],
        'weight_pack' => ['type' => 'float', 'lenght' => 6],
        'price_adv' => ['type' => 'int', 'lenght' => 7],
        'price_adv_discount' => ['type' => 'int', 'lenght' => 7],
        'price_dbs' => ['type' => 'int', 'lenght' => 7],
        'price_dbs_discount' => ['type' => 'int', 'lenght' => 7],
        'price_ozon' => ['type' => 'int', 'lenght' => 7],
        'price_ozon_discount' => ['type' => 'int', 'lenght' => 7],
        'price_wb' => ['type' => 'int', 'lenght' => 7],
        'price_wb_discount' => ['type' => 'int', 'lenght' => 7],
        'price_avito' => ['type' => 'int', 'lenght' => 7],
        'price_avito_discount' => ['type' => 'int', 'lenght' => 7],
        'bonus' => ['type' => 'int', 'lenght' => 2],
        'tag_new' => ['type' => 'int', 'lenght' => 1],
        'tag_hit' => ['type' => 'int', 'lenght' => 1],
        'tag_rare' => ['type' => 'int', 'lenght' => 1],
        'tag_low_price' => ['type' => 'int', 'lenght' => 1],
        'comment' => ['type' => 'string', 'lenght' => 90],
        'photo' => ['type' => 'string'],
        's_product_id' => ['type' => 'int', 'lenght' => 9],
        's_category_id' => ['type' => 'int', 'lenght' => 9],
        's_soon' => ['type' => 'int', 'lenght' => 1],
        's_select' => ['type' => 'int', 'lenght' => 1],
        's_tag' => ['type' => 'string', 'lenght' => 150],
        's_amount' => ['type' => 'int', 'lenght' => 6],
        's_text' => ['type' => 'string', 'lenght' => 150],
        's_order' => ['type' => 'string'],
    ];

    public function getQueryWhere(): string
    {
        if (notArray($this->vars['s_tag'])) {
            $query[] = "tag_{$this->vars['s_tag']} = 1";
        }

        if (notArray($this->vars['s_select'])) {
            $query[] = "is_select = {$this->vars['s_select']}";
        }

        if (notArray($this->vars['s_product_id'])) {
            $query[] = "id = {$this->vars['s_product_id']}";
        }

        if (notArray($this->vars['s_soon'])) {
            $query[] = "is_soon = {$this->vars['s_soon']}";
        }

        if (notArray($this->vars['s_amount'])) {
            $query[] = "amount_active = 0";
        }

        if (notArray($this->vars['s_category_id'])) {
            $query[] = "
                category_id IN
                    (
                        SELECT id
                        FROM m_category
                        WHERE id = {$this->vars['s_category_id']}
                    )";
        }

        if (notArray($this->vars['s_text'])) {
            $query[] = "
                (
                        article LIKE '%{$this->vars['s_text']}%'
                    OR  barcode LIKE '%{$this->vars['s_text']}%'
                    OR  name LIKE '%{$this->vars['s_text']}%'
                    OR  comment_admin LIKE '%{$this->vars['s_text']}%'
                )";
        }

        if (!isset($query)) {
            $query = "id > 0";
        } else {
            $query = implode(' AND ', $query);
        }

        return $query;
    }

    private function prepare(): array
    {
        $article = translit($this->vars['article']);

        $fieldsSetZeroIfEmpty = ['barcode', 'figures', 'length_pack', 'width_pack', 'height_pack', 'weight_pack',
            'tag_new', 'tag_hit', 'tag_rare', 'tag_low_price', 'bonus'];

        foreach ($fieldsSetZeroIfEmpty as $name) {
            if ($this->vars[$name] == '') {
                $this->vars[$name] = 0;
            }
        }

        $var['name'] = $this->vars['name'];
        $var['article'] = $article;
        $var['barcode'] = $this->vars['barcode'];
        $var['category_id'] = $this->vars['category_id'];
        $var['preview'] = $this->vars['preview'];
        $var['description'] = $this->vars['description'];
        $var['parts'] = $this->vars['parts'];
        $var['figures'] = $this->vars['figures'];
        $var['age'] = $this->vars['age'];
        $var['year'] = $this->vars['year'];
        $var['youtube'] = $this->vars['youtube'];
        $var['length'] = $this->vars['length'];
        $var['width'] = $this->vars['width'];
        $var['height'] = $this->vars['height'];
        $var['weight'] = $this->vars['weight'];
        $var['length_pack'] = $this->vars['length_pack'];
        $var['width_pack'] = $this->vars['width_pack'];
        $var['height_pack'] = $this->vars['height_pack'];
        $var['weight_pack'] = $this->vars['weight_pack'];
        $var['tag_new'] = $this->vars['tag_new'];
        $var['tag_hit'] = $this->vars['tag_hit'];
        $var['tag_rare'] = $this->vars['tag_rare'];
        $var['tag_low_price'] = $this->vars['tag_low_price'];
        $var['comment_admin'] = $this->vars['comment'];

        return $var;
    }

    public function create()
    {
        $category = R::load('m_category', $this->vars['category_id']);

        $var = $this->prepare();
        $article = $var['article'];


        $path = WWW . "/uploads/goods/{$category['url']}/$article/";

        if (!is_dir($path)) {
            mkdir($path);
            mkdir($path . 'thumb/');
        }

        $obj = R::dispense($this->table);

        $obj['created_at'] = date('Y-m-d H:i:s');
        $obj['comment_admin'] = '';
        $obj['photo'] = '';

        foreach ($var as $name => $value) {
            $obj[$name] = $value;
        }

        R::store($obj);
    }

    public function save()
    {
        $obj = R::load($this->table, $this->vars['id']);
        $category = R::load('m_category', $obj['category_id']);

        $var = $this->prepare();
        $article = $var['article'];

        $path = WWW . "/uploads/goods";

        if ($article != $obj['article']) {
            $article = translit($article);
            $src = "$path/{$category['url']}/{$obj['article']}/";
            $dest = "$path/{$category['url']}/$article/";

            rename($src, $dest);
        }

        if ($this->vars['category_id'] != $obj['category_id']) {
            $categoryNew = R::load('m_category', $this->vars['category_id']);

            $src = "$path/{$category['url']}/$article/";
            $dest = "$path/{$categoryNew['url']}/$article/";

            copyDirectory($src, $dest);
            deleteDirectory($src);
        }

        $obj['updated_at'] = date('Y-m-d H:i:s');

        foreach ($var as $name => $value) {
            $obj[$name] = $value;
        }

        R::store($obj);
    }

    public function delete()
    {
        $obj = R::load($this->table, $this->vars['id']);
        $category = R::load('m_category', $obj['category_id']);

        $path = WWW . "/uploads/goods/{$category['url']}/{$obj['article']}/";

        // удаление все фоток в товаре
        if (is_dir($path)) {
            deleteDirectory($path);
        }

        // удаление данных со склада о товаре
        R::exec("DELETE FROM m_storage WHERE product_id = ?", [$this->vars['id']]);

        // удаление карточки товара
        $this->simpleDelete($this->table);
    }

    public function uploadPhoto()
    {
        $obj = R::load($this->table, $this->vars['id']);
        $category = R::load('m_category', $obj['category_id']);

        $path = WWW . "/uploads/goods/{$category['url']}/{$obj['article']}/";

        $fileExt = [];
        $photos = [];
        $files = $_FILES;
        $countFiles = count($_FILES);
        $allowTypes = ['jpg', 'jpeg', 'png'];

        if ($obj['photo']) {
            $photos = explode(';', $obj['photo']);
        }

        // проверка на корректность формата загружаемых файлов
        for ($i = 0; $i < $countFiles; $i++) {
            $files[$i]['name'] = filterString($files[$i]['name']);
            $fileExt[$i] = get_ext($files[$i]['name']);

            // если формат совпадает
            if (in_array($fileExt[$i], $allowTypes)) {
                $dt = date('YmdHis', time());
                $fileName[$i] = $dt . $i . '.' . $fileExt[$i];

                if (move_uploaded_file($files[$i]['tmp_name'], $path . $fileName[$i])) {
                    resize("$path$fileName[$i]", "$path$fileName[$i]", 1200, 0);
                    resize("$path$fileName[$i]", "{$path}thumb/$fileName[$i]", 600, 0);

                    $photos[] = $fileName[$i];
                }
            }
        }

        $photos = implode(';', $photos);

        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['photo'] = $photos;

        R::store($obj);
    }

    public function deletePhoto()
    {
        $obj = R::load($this->table, $this->vars['id']);
        $category = R::load('m_category', $obj['category_id']);

        $path = WWW . "/uploads/goods/{$category['url']}/{$obj['article']}/";

        $this->vars['photo'] = str_replace('_', '.', $this->vars['photo']);

        // если фотка является аватаркой
        if (isImageAvatar($path, $this->vars['photo'])) {
            unlink($path . 'mini-' . $this->vars['photo']);
            unlink($path . 'thumb-' . $this->vars['photo']);
        }

        // удаляем фотку и превьюшку
        unlink($path . $this->vars['photo']);
        unlink($path . 'thumb/' . $this->vars['photo']);

        $photos = explode(';', $obj['photo']);
        $key = array_search($this->vars['photo'], $photos);

        unset($photos[$key]);

        $photos = implode(';', $photos);

        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['photo'] = $photos;

        R::store($obj);
    }

    public function setAvatar()
    {
        $obj = R::load($this->table, $this->vars['id']);
        $category = R::load('m_category', $obj['category_id']);

        $path = WWW . "/uploads/goods/{$category['url']}/{$obj['article']}/";

        $this->vars['photo'] = str_replace('_', '.', $this->vars['photo']);

        $photos = explode(';', $obj['photo']);
        $key = array_search($this->vars['photo'], $photos);

        if (isImageAvatar($path, $photos[0])) {
            unlink($path . 'mini-' . $photos[0]);
            unlink($path . 'thumb-' . $photos[0]);
        }

        unset($photos[$key]);

        array_unshift($photos, $this->vars['photo']);
        $photos = implode(';', $photos);

        resize("$path{$this->vars['photo']}", "{$path}thumb-{$this->vars['photo']}", 220, 0);
        resize("$path{$this->vars['photo']}", "{$path}mini-{$this->vars['photo']}", 70, 0);

        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['photo'] = $photos;

        R::store($obj);
    }

    /**
     * Проверка перед сохранением
     */
    public function checkExistName(): bool
    {
        $query = "name = ? AND id != ?";
        $obj = R::findOne($this->table, $query, [
            $this->vars['name'],
            $this->vars['id'],
        ]);

        if ($obj) {
            $this->errors[] = 'non-unique-name';

            return false;
        }

        return true;
    }

    /**
     * Проверка перед созданием
     */
    public function checkUniqueName(): bool
    {
        $query = "name = ?";
        $obj = R::findOne($this->table, $query, [
            $this->vars['name'],
        ]);

        if ($obj) {
            $this->errors[] = 'non-unique-name';

            return false;
        }

        return true;
    }

    /**
     * Проверка перед сохранением
     */
    public function checkExistArticle(): bool
    {
        $query = "article = ? AND id != ?";
        $obj = R::findOne($this->table, $query, [
            $this->vars['article'],
            $this->vars['id'],
        ]);

        if ($obj) {
            $this->errors[] = 'non-unique-article';

            return false;
        }

        return true;
    }

    /**
     * Проверка перед созданием
     */
    public function checkUniqueArticle(): bool
    {
        $query = "article = ?";
        $obj = R::findOne($this->table, $query, [
            $this->vars['article'],
        ]);

        if ($obj) {
            $this->errors[] = 'non-unique-article';

            return false;
        }

        return true;
    }

    public function setPrices()
    {
        $marketplaceList = R::findAll('m_marketplace');

        foreach ($marketplaceList as $marketplace) {
            $name = $marketplace['short_name'];

            $var["price_$name"] =
            $var["price_{$name}_discount"] =
            $var["price_{$name}_discount_sum"] =
            $var["price_{$name}_discount_percent"] = 0;

            if ($this->vars["price_$name"] > 0) {
                $var["price_$name"] = $this->vars["price_$name"];
            }

            if ($this->vars["price_{$name}_discount"] > 0) {
                $var["price_{$name}_discount"] = $this->vars["price_{$name}_discount"];
            }

            if ($var["price_{$name}_discount"] < $var["price_$name"] && $var["price_{$name}_discount"] > 0
                && $var["price_$name"] > 0) {
                $var["price_{$name}_discount_sum"] = $var["price_$name"] - $var["price_{$name}_discount"];
                $var["price_{$name}_discount_percent"] = $var["price_{$name}_discount_sum"] / $var["price_$name"] * 100;
            }
        }

        $obj = R::load($this->table, $this->vars['id']);

        foreach ($var as $name => $value) {
            $obj[$name] = $value;
        }

        $obj['bonus'] = $this->vars['bonus'];

        R::store($obj);

        Calculation::calc($this->vars['id']);
    }

}