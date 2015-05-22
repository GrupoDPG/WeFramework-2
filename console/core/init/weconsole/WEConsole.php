<?php
namespace init\weconsole;
/**
 * Class WEConsole
 * @package init\weconsole
 */
trait WEConsole
{
    /**
     * Reppository class name
     * @param $arg
     * @return string
     */
    public function getClassName($arg)
    {
        if(strpos($arg, '\\') !== false)
            $name = str_replace('\\', '/', $arg);
        elseif(strpos($arg, '/') !== false)
            $name = $arg;

        if(strpos($arg, '/') !== false)
        {
            $ex = explode('/', $name);
            $class_name = $ex[count($ex) - 1];
        }
        else
            $class_name = $arg;

        return $class_name;
    }
}