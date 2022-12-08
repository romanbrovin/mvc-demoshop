<?php

namespace app\models\adm;

use R;

class Banner extends App
{

    private string $table = 'm_banner';

    public array $vars = [
        'id' => ['type' => 'int', 'lenght' => 9],
        'url' => ['type' => 'url'],
        'comment' => ['type' => 'string', 'lenght' => 90],
        'sort' => ['type' => 'int', 'lenght' => 2],
        'photo' => ['type' => 'string'],
        's_text' => ['type' => 'string', 'lenght' => 150],
        's_order' => ['type' => 'string'],
    ];

    public function getQueryWhere(): string
    {
        if (notArray($this->vars['s_text'])) {
            $query = "url LIKE '%{$this->vars['s_text']}%'";
        }

        if (!isset($query)) {
            $query = "id > 0";
        }

        return $query;
    }

    public function create()
    {
        $obj = R::dispense($this->table);

        $obj['created_at'] = date('Y-m-d H:i:s');
        $obj['photo'] = '';
        $obj['url'] = $this->vars['url'];

        R::store($obj);

        $bannerId = R::getInsertID();

        $mainFolder = WWW . "/uploads/";
        if (!is_dir($mainFolder)) {
            mkdir($mainFolder);
        }

        $bannerFolder = WWW . "/uploads/banners/";
        if (!is_dir($bannerFolder)) {
            mkdir($bannerFolder);
        }

        $path = WWW . "/uploads/banners/$bannerId/";

        if (!is_dir($path)) {
            mkdir($path);
        }
    }

    public function save()
    {
        $obj = R::load($this->table, $this->vars['id']);

        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['url'] = $this->vars['url'];

        R::store($obj);
    }

    public function delete()
    {
        $path = WWW . "/uploads/banners/{$this->vars['id']}/";

        if (is_dir($path)) {
            deleteDirectory($path);
        }

        $this->simpleDelete($this->table);
    }

    public function uploadPhoto()
    {
        $obj = R::load($this->table, $this->vars['id']);

        $path = WWW . "/uploads/banners/{$obj['id']}/";

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
                resize("$path$fileName", "$path$fileName", 1200, 0);
                resize("$path$fileName", "{$path}thumb-$fileName", 150, 0);

                $obj['updated_at'] = date('Y-m-d H:i:s');
                $obj['photo'] = $fileName;

                R::store($obj);
            }
        }
    }

    public function deletePhoto()
    {
        $obj = R::load($this->table, $this->vars['id']);

        $path = WWW . "/uploads/banners/{$obj['id']}/";

        if (file_exists($path . $obj['photo'])) {
            unlink($path . $obj['photo']);
            unlink($path . 'thumb-' . $obj['photo']);
        }

        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['photo'] = '';

        R::store($obj);
    }

}