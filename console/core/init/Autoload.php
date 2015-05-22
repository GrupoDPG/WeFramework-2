<?php
/**
 * Class Autoload
 */
class Autoload
{
    /**
     * @access public
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(array('Autoload', 'coreAtuload'));
        spl_autoload_register(array('Autoload', 'mainAtuload'));
    }

    /**
     * @param $class
     */
    private static function coreAtuload($class)
    {
        $file = WECON_BASEPATH . 'core' . WECON_DS . $class . '.php';
        include_once $file;
    }

    /**
     * @param $class
     */
    private static function mainAtuload($class)
    {
        $file = WECON_BASEPATH . $class . '.php';
        include_once $file;
    }

}