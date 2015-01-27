<?php
/**
 * -----------------------------------------------------
 * BASE
 * -----------------------------------------------------
 * Este arquivo de funções tem como responsabilidade gerenciar o corpa base da página HTML
 *
 * @package WeFramework
 * @subpackage Helpers/WeFramework/Functions
 * @auhor Diogo Brito
 * @version 0.1 - 04/10/2014
 */


/**
 * GLOBALS VARS
 *
 */
static $CONTROLL_PAGE = array();




/**
 * GlobalInclude
 * Inclui dentro do escopo as variávies globais
 *
 * @param $file_path
 * @return string
 */
function TemplateContent($file_path)
{
    return mvc\View::GetInstance()->Compile($file_path, true);
}

/*
 * GetHead()
 * Inclusão de cabeçalho Html
 */
function GetHead()
{
    //Recuperando instância da classe Layout
    $lay = \core\layout\Layout::GetInstance();
    //Retonrnado o diretório do tema principal
    $main_theme = $lay->GetDirTheme();
    //Arquivo para include
    $file = $main_theme . 'inc' . DS . 'base' . DS. 'head.php';
    //Imprimindo arquivo
    echo TemplateContent($file);
}

/*
 * GetHeader()
 * Inclusão de cabeçalho Html
 */
function GetHeader()
{
    //Recuperando instância da classe Layout
    $lay = \core\layout\Layout::GetInstance();
    //Retonrnado o diretório do tema principal
    $main_theme = $lay->GetDirTheme();
    //Arquivo para include
    $file = $main_theme . 'inc' . DS . 'base' . DS. 'header.php';
    //Imprimindo arquivo
    echo TemplateContent($file);
}

/*
 * GetContent()
 * Inclusão de cabeçalho Html
 */
function GetContent()
{

    //Recuperando instância da classe Layout
    $lay = \core\layout\Layout::GetInstance();
    //Retonrnado o diretório do tema principal
    $main_theme = $lay->GetDirTheme();
    //Arquivo para include
    $file = $main_theme . 'inc' . DS . 'base' . DS. 'content.php';

    //Imprimindo arquivo
    echo TemplateContent($file);
}

/*
 * GetLoop()
 * Conteúdo dinâmico da página
 */
function GetLoop()
{
    $file_loop = \core\layout\Render::GetInstance()->Render(true);
    if(!$file_loop)
    {
        header('Location: '.\core\router\Router::GetInstance()->BaseURL() . '404');
    }
    else
    {
        echo TemplateContent($file_loop);
    }
    echo PHP_EOL;
}

/*
 * GetLoop()
 * Inclusão de cabeçalho Html
 */
function GetFooter()
{
    //Recuperando instância da classe Layout
    $lay = \core\layout\Layout::GetInstance();
    //Retonrnado o diretório do tema principal
    $main_theme = $lay->GetDirTheme();
    //Arquivo para include
    $file = $main_theme . 'inc' . DS . 'base' . DS. 'footer.php';
    //Imprimindo arquivo
    echo TemplateContent($file);
}

/**
 * GetBaseThemePath()
 * Esta função retorna o caminho do tema atual
 *
 * @return string
 */
function GetBaseThemePath()
{
    if(defined('WE_THEME_PATH'))
    {
        return WE_THEME_PATH;
    }
    return '';
}

/**
 * PageIndex
 * @return string
 */
function PageIndex()
{
    if(defined('WE_THEME_PAGE_INDEX'))
    {
        return WE_THEME_PAGE_INDEX;
    }
    return '';
}

/**
 * BaseURL
 * @return string
 */
function BaseUrl()
{
    if(defined('WE_BASE_URL'))
    {
        return WE_BASE_URL;
    }
    return '';
}

/**
 * GetThemeBaseUrl
 * Caminho absoluto do tema
 * @return string
 */
function GetThemeBaseUrl()
{
    return '/' . WE_REAL_BASE_URL . ((WE_REAL_BASE_URL != '') ? '/' : '') . 'layout/themes/'.((WE_THEME != '') ? WE_THEME . '/' : '');
}

/**
 * ThemeBaseUrl
 * Retorna  a URL do tema atual
 * @return string
 */
function ThemeBaseUrl()
{
    return WE_WRAPPER . '://'.$_SERVER['HTTP_HOST'].'/'. WE_REAL_BASE_URL . ((WE_REAL_BASE_URL != '') ? '/' : '') .'layout/themes/'.((WE_THEME != '') ? WE_THEME . '/' : '');
}

/**
 * RealBaseUrl
 * @return string
 */
function RealBaseUrl()
{
    return WE_WRAPPER . '://'.$_SERVER['HTTP_HOST'].'/'. WE_REAL_BASE_URL . ((WE_REAL_BASE_URL != '') ? '/' : '');
}

/**
 * @return string
 */
function GetRealBaseUrl()
{
    $url = '/' . WE_REAL_BASE_URL . ((WE_REAL_BASE_URL != '') ? '/' : '');
    $alias = '';
    if(WE_IS_HOT_THEME)
    {
        if(WE_THEME_ALIAS_NAME != '')
            $alias = WE_THEME_ALIAS_NAME . '/';
        else
            $alias = WE_THEME . '/';
    }
    return $url . $alias;
}

/**
 * IncludeFile
 * Inclusão de um arquivo
 *
 * @return void
 * @param $file
 * @param $controll
 */
function IncludeFile($file, $controll = null)
{
    $file = GetBaseThemePath().$file;
    if(is_file($file))
    {
        if($controll === true)
            StatusPage(true);

        echo TemplateContent($file);
    }
    else
    {
        if($controll === true)
            StatusPage(false);

        echo 'File not found: '.$file;
    }
}

/**
 * RequirePage
 * Esta funcção testa a fágine e inclui um arquivo
 * @param $url_page
 * @param null $file
 * @param $controll
 * @return bool
 */
function RequirePage($url_page, $file = null, $controll = false)
{
    $flag = mvc\View::GetInstance()->RequirePage($url_page);
    if(isset($file) && $flag === true)
    {
        IncludeFile($file, $controll);
    }

    return $flag;
}


/**
 * ControllPage
 * Controle de requisições de páginas
 *
 * @param null $flag
 * @return bool
 */
function StatusPage($flag = null)
{
    return mvc\View::GetInstance()->ControllPage($flag);
}

/**
 * StatusPage
 * Verifica status da página e redireciona para o status correto
 *
 * @return void
 */
function ControllPage()
{
    $controll = StatusPage();

    if($controll === false)
        header('Location: ' . BaseURL() . '404');
}

/**
 * MenuActive
 *
 * @param $page
 * @param $class
 */
function MenuActive($page, $class)
{
    if(RequirePage($page))
        echo $class;
}

/**
 * PrettyUrl
 * @param $string
 * @return mixed|string
 */
function PrettyUrl($string)
{

    $final = strtolower($string);
    $final = str_replace("’", "-", $final);
    $final = str_replace("?", "", $final);
    $final = str_replace("!", "", $final);
    $final = str_replace(".", "", $final);
    $final = str_replace("/", "", $final);
    $final = str_replace("#", "", $final);
    $final = str_replace("@", "", $final);
    $final = str_replace(":", "", $final);
    $final = str_replace(" ", "-", $final);
    $final = str_replace("&", "e", $final);
    $final = str_replace(",", "", $final);
    $final = str_replace(";", "", $final);

    $final = str_replace("á", "a", $final);
    $final = str_replace("à", "a", $final);
    $final = str_replace("â", "a", $final);
    $final = str_replace("ä", "a", $final);
    $final = str_replace("ã", "a", $final);

    $final = str_replace("é", "e", $final);
    $final = str_replace("è", "e", $final);
    $final = str_replace("ê", "e", $final);
    $final = str_replace("ë", "e", $final);

    $final = str_replace("í", "i", $final);
    $final = str_replace("ì", "i", $final);
    $final = str_replace("î", "i", $final);
    $final = str_replace("ï", "i", $final);

    $final = str_replace("ó", "o", $final);
    $final = str_replace("ò", "o", $final);
    $final = str_replace("ô", "o", $final);
    $final = str_replace("ö", "o", $final);
    $final = str_replace("õ", "o", $final);

    $final = str_replace("ú", "u", $final);
    $final = str_replace("ù", "u", $final);
    $final = str_replace("û", "u", $final);
    $final = str_replace("ü", "u", $final);

    $final = str_replace("Á", "A", $final);
    $final = str_replace("À", "A", $final);
    $final = str_replace("Â", "A", $final);
    $final = str_replace("Ã", "A", $final);
    $final = str_replace("Ä", "A", $final);

    $final = str_replace("É", "E", $final);
    $final = str_replace("È", "E", $final);
    $final = str_replace("Ê", "E", $final);
    $final = str_replace("Ë", "E", $final);

    $final = str_replace("Í", "I", $final);
    $final = str_replace("Ì", "I", $final);
    $final = str_replace("Î", "I", $final);
    $final = str_replace("Ï", "I", $final);

    $final = str_replace("Ó", "O", $final);
    $final = str_replace("Ò", "O", $final);
    $final = str_replace("Ô", "O", $final);
    $final = str_replace("Õ", "O", $final);
    $final = str_replace("Ö", "O", $final);

    $final = str_replace("Ú", "U", $final);
    $final = str_replace("Ù", "U", $final);
    $final = str_replace("Û", "U", $final);
    $final = str_replace("Ü", "U", $final);

    $final = str_replace("ç", "c", $final);
    $final = str_replace("ñ", "n", $final);

    $final = str_replace("Ç", "C", $final);
    $final = str_replace("Ñ", "N", $final);

    return $final;
}