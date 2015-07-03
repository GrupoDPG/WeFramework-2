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
        $script_path = dirname($_SERVER['SCRIPT_NAME']);
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
     * Retorna toddos os índices de POST
     * @return mixed
     */
    public function GetAll()
    {
        //Project Folder
        $script_path = dirname($_SERVER['SCRIPT_NAME']);
        //URI
        $uri = $_SERVER['REQUEST_URI'];
        //Separando a pasta do projeto da url
        $uri_ex = explode($script_path, $uri);
        $uri = trim($uri_ex[1], '/');

        $parameters = null;
        //Existe / ?
        if(strpos($uri, '/') !== false)
        {
            //Parâmetros URL
            $pre_parameters = explode('/', $uri);
            //Limpeza de dados
            $i = 0;
            foreach($pre_parameters as $k => $v)
            {
                if(strpos($v, '?') === false)
                {
                    $parameters[$i] = $v;
                    $i++;
                }
            }
        }
        else
        {
            $parameters[0] = $uri;
        }

        // $_GET
        if(count($_GET) > 0)
        {
            $parameters = array_merge($parameters, $_GET);
        }

        return $parameters;
    }
}