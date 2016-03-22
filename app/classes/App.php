<?php

class App {

    protected $languages = array('pt');
    protected $lang      = 'en';
    protected $page      = 'home/home';
    protected $param     = '';

    public function __construct()
    {
        $url = array_filter($this->parseUrl());
        $this->getIdioma(@$url[0]);

        if ( @$url[0] != $this->lang ) array_unshift($url, $this->lang);

        $this->checaPagina($url);
    }

    public function getMenu()
    {
        $menu = dirname(dirname(__FILE__)) . '/lang/' . $this->lang . '/menu/menu.php';
        if ( file_exists($menu) )
        {
            require_once $menu;
        }
    }

    public function getContent()
    {
        $geral     = dirname(dirname(__FILE__)) . '/lang/' . $this->lang . '/geral.php';
        $menu      = dirname(dirname(__FILE__)) . '/lang/' . $this->lang . '/menu.php';
        $banner    = dirname(dirname(__FILE__)) . '/lang/' . $this->lang . '/banner.php';
        $intro     = dirname(dirname(__FILE__)) . '/lang/' . $this->lang . '/intro.php';
        $about     = dirname(dirname(__FILE__)) . '/lang/' . $this->lang . '/about.php';
        $subscribe = dirname(dirname(__FILE__)) . '/lang/' . $this->lang . '/subscribe.php';
        $footer    = dirname(dirname(__FILE__)) . '/lang/' . $this->lang . '/footer.php';
        $contact   = dirname(dirname(__FILE__)) . '/lang/' . $this->lang . '/contact.php';

        $this->addFile($geral);
        $this->addFile($menu);
        $this->addFile($banner);
        $this->addFile($intro);
        $this->addFile($about);
        $this->addFile($subscribe);
        $this->addFile($footer);
        $this->addFile($contact);

    }

    public function addFile($file)
    {
        if (file_exists($file))
        {
            require_once $file;
        }
    }

    public function getPagina()
    {
        $file = dirname(dirname(__FILE__)) . '/paginas/' . $this->page . '.php';
        $this->addFile($file);
    }
    
    public function getBodyClass()
    {
        return explode('/', $this->page)[0];
    }


    public function checaPagina($pagina = array())
    {
        $this->param = $pagina;
        if ( isset($pagina[0]) ) unset($pagina[0]);
        if ( count($pagina) == 1 ) $pagina[0] = $pagina[1];

        $page = implode('/', $pagina);
        if ( $page ) $this->page = $page;
    }

    public function getImageUrl($nome = '', $caminho = '')
    {
        $url = $this->getBaseUrl() . 'img/' . $caminho . $nome;
        echo $url;
    }

    public function getLink($link = '')
    {
        $lang = ($this->lang == 'pt') ? '' : $this->lang . '/';
        echo $this->getBaseUrl() . $lang . $link;
    }

    public function isHome()
    {
        $url = array_filter($this->parseUrl());
        $this->getIdioma(@$url[0]);

        if ( @$url[0] != $this->lang ) array_unshift($url, $this->lang);

        return $url;
    }

    public function getBaseUrl()
    {
        $path = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $path;

        echo $url;
    }

    public function baseUrl()
    {
        $path = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $path;

        return $url;
    }

    public function getIdioma($idioma = '')
    {
        if ( in_array($idioma, $this->languages) )
            $this->lang = $idioma;
    }

    public function parseUrl()
    {
        if ( isset($_GET['url']) )
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        else
            return array();
    }

}
