<?php

namespace vendor\core\base;

class View
{

    public array $route; // текущий маршрут и параметры (controller, action, params)
    public $layout;      // текущий шаблон
    public $view;        // текущий вид
    public array $scripts = [];
    public array $styles = [];

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        $this->layout = $layout;
        $this->view = $view;
    }

    // Сжатие HTML в одну строчку
    protected function compressPage($buffer)
    {
        $search = [
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        ];

        $replace = [
            '>',
            '<',
            '\\1',
            '',
        ];

        return preg_replace($search, $replace, $buffer);
    }

    public function render($vars)
    {
        if (is_array($vars)) {
            extract($vars);
        }

        $prefix = str_replace('\\', '/', $this->route['prefix']);
        $pathToFolder = $prefix . $this->route['controller'];

        if (isset($meta['template'])) {
            $fileView = APP . "/views/adm/templates/$this->view.php";
        } else {
            $fileView = APP . "/views/$pathToFolder/$this->view.php";
        }


        $uri = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($uri);
        if (isset($uri[1])) {
            $uri = explode('?', $uri[1]);
        }
        $uri = $uri[0];


        if (COMPRESS_PAGE == 1) {
            ob_start([$this, "compressPage"]);
        } else {
            ob_start();
        }

        if (is_file($fileView)) {
            require_once $fileView;

            $fileScript = "/js/$pathToFolder.min.js";
            if (is_file(WWW . $fileScript)) {
                echo "<script src=\"$fileScript\"></script>";
            }

            $fileStyle = "/css/$pathToFolder.min.css";
            if (is_file(WWW . $fileStyle)) {
                echo "<link href=\"$fileStyle\" rel=\"stylesheet\">";
            }
        } else {
            echo 'not found view: ' . $fileView;
            include WWW . '/404.php';
        }

        $content = ob_get_contents();
        ob_clean();

        if (false !== $this->layout) {
            $fileLayout = APP . "/views/layouts/$this->layout.php";
            if (is_file($fileLayout)) {
                $content = $this->cutScripts($content);
                $scripts = [];
                if (!empty($this->scripts[0])) {
                    $scripts = $this->scripts[0];
                }
                $scripts = array_unique($scripts);

                $content = $this->cutStyle($content);
                $styles = [];
                if (!empty($this->styles[0])) {
                    $styles = $this->styles[0];
                }
                $styles = array_unique($styles);

                $route = $this->route;
                require_once $fileLayout;
            } else {
                echo 'not found layout: ' . $fileLayout;
                include WWW . '/404.php';
            }
        }
    }

    protected function cutScripts($content)
    {
        $pattern = "#<script.*?>.*?</script>#si";
        preg_match_all($pattern, $content, $this->scripts);
        if (!empty($this->scripts)) {
            $content = preg_replace($pattern, '', $content);
        }

        return $content;
    }

    protected function cutStyle($content)
    {
        $pattern = '#<link.*?rel="stylesheet">#si';
        preg_match_all($pattern, $content, $this->styles);
        if (!empty($this->styles)) {
            $content = preg_replace($pattern, '', $content);
        }

        return $content;
    }

}
