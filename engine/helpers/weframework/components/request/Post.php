<?php
namespace helpers\weframework\components\request;
/**
 * Class Post
 * @package helpers\weframework\components\request
 */
class Post
{
    private static $save_data = false;

    public function saveData()
    {
        self::$save_data = true;
    }

    /**
     * IsPost
     * Método repossável para verificar se existe $_POST
     * @return bool
     */
    public function IsPost()
    {
        if($_POST)
            return true;

        return false;
    }

    /**
     * Get
     * Retorna valor de um determinado campo
     * @param $name
     * @return mixed
     */
    public function Get($name)
    {
        if(isset($_POST[$name]))
            return $_POST[$name];

        return null;
    }

    /**
     * GetAll
     * Retorna toddos os índices de POST
     * @return mixed
     */
    public function GetAll()
    {
        return $_POST;
    }

    /**
     * @param $key
     * @return null|string
     */
    public static function ValueOf($key)
    {
        if(self::$save_data === true)
            if(isset($_POST[$key]))
                return $_POST[$key];

        return null;
    }
}