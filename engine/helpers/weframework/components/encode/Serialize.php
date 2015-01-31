<?php
namespace helpers\weframework\components\encode;

class Serialize implements  IEncode
{
    public static function Encode($data)
    {
        return serialize($data);
    }

    public static function Decode($data)
    {
        return unserialize($data);
    }
}