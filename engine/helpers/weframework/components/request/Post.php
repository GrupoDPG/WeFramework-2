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
     * @param $index
     * @param $value
     */
    public function Set($index, $value){
        $_POST[$index] = $value;
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


    /**
     * @param null $array
     * @return null
     */
    public static function Sanitize($array = null){
        if(!isset($array))
            $array = $_POST;

        if($array) {
            foreach($array as $k => $p){
                if(!is_array($p)){
                    $array[$k] = trim($p);
                    if(empty($p))
                        $array[$k] = null;
                } else
                    self::Sanitize($p);
            }
            if(!isset($array) && $_POST)
                $_POST = $array;
        }
        return $array;

    }
}