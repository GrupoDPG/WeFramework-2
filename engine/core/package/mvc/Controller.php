<?php

/**
 * Class Controller
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @version 0.1 - 16/10/2014
 * @package WeFramework
 * @subpackage MVC/Controller
 */
namespace mvc;

use helpers\weframework\components\request\Request;

abstract class Controller
{
    private $flag = false;

    public function Load()
    {
        return \mvc\loaders\ControllerLoader::GetInstance()->Load();
    }

    public function Loaded()
    {
        return \mvc\loaders\ControllerLoader::GetInstance()->Loaded();
    }

    public function AddController($route, $controller, $method = null)
    {
        if($this->flag === false)
        {
            $controller_name = $controller;
            if(preg_match('@^'.$route.'@', WE_URI_PROJECT))
            {
                $controller = $this->getClass($controller);
                if(isset($controller) && $controller instanceof Controller)
                {
                    if(isset($method) && method_exists($controller, $method))
                        $controller->$method();
                    else
                    {
                        //URL
                        $url = Request::Get()->GetAll();
                        //Define url
                        $uri = implode('/', $url);
                        $route_uri = trim(str_replace($route, '', $uri), '/');
                        $url = explode('/', $route_uri);
                        $class_method = $url[0];

                        if(empty($class_method))
                        {
                            if(method_exists($controller, 'Index'))
                                $controller->Index();
                            elseif(method_exists($controller, 'index'))
                                $controller->index();
                        }
                        else
                        {
                            if(isset($class_method) && method_exists($controller, $class_method))
                                $controller->$class_method();
                        }
                        $this->flag = true;
                    }
                }
                else
                    die('The controller ' . $controller_name . ' must be a Controller type.');
            }
        }
    }


    private function getClass($controller)
    {
        $controller = str_replace('/', '\\', $controller);
        $controller = '\\' . ltrim($controller, '\\');

        if(strpos($controller, '.php') === false)
            $controller = $controller . '.php';

        $namespace = str_replace('.php', '', $controller);

        if(class_exists($namespace))
            return new $namespace;

        return null;
    }


    public function __get($varname)
    {
        $properties = \mvc\loaders\ControllerLoader::GetInstance()->GetProperties();
        if(isset($properties[$varname]))
            return $properties[$varname];
    }

}