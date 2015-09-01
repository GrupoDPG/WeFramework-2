<?php
namespace helpers\weframework\components\request;
use helpers\weframework\classes\Config;
/**
 * Class Get
 * @package helpers\weframework\components\request
 */
class Get
{
    use Config;
    /**
     * Get
     * Retorna valor de um determinado campo
     * @param $name
     * @return mixed
     */
    public function Get($name)
    {
        if(isset($_GET[$name]))
            return $_GET[$name];

        //Project Folder
        $script_path = dirname($_SERVER['SCRIPT_NAME']) . '/';
        //URI
        $uri = $_SERVER['REQUEST_URI'];
        //Separando a pasta do projeto da url
        $uri_ex = explode($script_path, $uri);

        for($i = 0; $i < count($uri_ex); $i++)
            if(empty($uri_ex[$i]))
                unset($uri_ex[$i]);

        $uri = array_values($uri_ex);
        //Verificando se o parâmetro passado é um número
        if(is_numeric($name))
        {
            $uri = preg_replace('@\?.*@', '', $uri[0]);
            $uri = trim($uri, '/');
            $uri = explode('/', $uri);

            $key = (int) $name;
            if(isset($uri[$key]))
                return $uri[$key];
            else
                return null;

        }
        //Parâmetro por referência de nome
        else
        {
            $uri = implode('/', $uri);
            $params_names = $this->UrlParamName();
            //Existe / ?
            if(strpos($uri, '/') !== false)
            {
                $key = array_search($name, $params_names);
                if($key) {
                    //Parâmetros URL
                    $url = explode('/', $uri);
                    if (isset($url[$key]))
                        return $url[$key];
                }
            }
            elseif($name == $params_names[0])
                return $uri;
        }

        return null;
    }


    /**
     * @return mixed
     */
    private function UrlParamName()
    {
        $routes = $this->GetFileConfig('routes.ini');
        $url_params_names = $routes['url_param'];

        return $url_params_names;
    }

    /**
     * GetAll
     * Retorna todos os índices de POST
     * @param bool $inclusive_url_params
     * @return mixed
     */
    public function GetAll($inclusive_url_params = true)
    {
        //Project Folder
        $script_path = str_replace('\\', "/", dirname($_SERVER['SCRIPT_NAME']));
        //URI
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        if(strpos($uri, '?') !== true){
            $uri = preg_replace('@\?.+@', '', $uri);
        }
        //Separando a pasta do projeto da url
        $parameters = explode($script_path, $uri);
        if(count($_GET) > 0 && $inclusive_url_params)
            $parameters = array_merge($parameters, $_GET);

        return $parameters;
    }
}