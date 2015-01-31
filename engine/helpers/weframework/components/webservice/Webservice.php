<?php
namespace helpers\weframework\components\webservice;

use helpers\weframework\components\encode\Json;
use helpers\weframework\components\encode\Serialize;

class Webservice
{
    /**
     * Encode
     * @param $data
     * @return string
     */
    public static function Encode($data)
    {
        $engine = strtolower(WE_WS_ENCODE);
        switch($engine)
        {
            case 'json':
                $encode = Json::Encode($data);
                break;
            case 'serialize':
                $encode = Serialize::Encode($data);
                break;
            default:
                $encode = Json::Encode($data);
        }
        return $encode;
    }
}