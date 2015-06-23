<?php
namespace helpers\weframework\components\webservice;

use helpers\weframework\components\encode\Json;
use helpers\weframework\components\encode\Serialize;

class Webservice
{


    public static function Call($request, $method = 'get', $params = null)
    {
        $data = null;
        switch($method)
        {
            case 'get':
                $data = self::Get($request);
                break;
            case 'post':
                $data = self::Post($request, $params);
                break;
        }

        return $data;
    }

    /**
     * Get
     * @param $request
     * @return mixed
     */
    private static function Get($request)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $request);
        curl_setopt($curl, CURLOPT_HEADER, 0);            // No header in the result
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result

        // Fetch and return content, save it.
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
    }

    /**
     * Post
     * @param $request
     * @param $params
     * @return mixed
     */
    private static function Post($request, $params)
    {
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$request);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, self::Prepare($params));

        $data = curl_exec($ch);

        curl_close($ch);

        return $data;
    }

    /**
     * Prepare
     * @param $params
     * @return string
     */
    private static function Prepare($params)
    {
        $url_param = '';
        if(is_array($params) && count($params) > 0)
        {
            foreach($params as $ind => $val)
            {
                $params[$ind] = urlencode($val);
                $url_param .= $ind.'='.$params[$ind].'&';
            }
            $url_param = rtrim($url_param, '&');
            return $url_param;
        }
        else
            return '';
    }


    /**
     * Encode
     * @param $data
     * @param $encode
     * @return string
     */
    public static function Encode($data, $encode = null)
    {
        if(isset($encode))
            $engine = strtolower($encode);
        else
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


    /**
     * Decode
     * @param $data
     * @param null $encode
     * @return mixed
     */
    public static function Decode($data, $encode = null)
    {
        if(isset($encode))
            $engine = strtolower($encode);
        else
            $engine = strtolower(WE_WS_ENCODE);

        switch($engine)
        {
            case 'json':
                $decode = Json::Decode($data);
                break;
            case 'serialize':
                $decode = Serialize::Decode($data);
                break;
            default:
                $decode = Json::Decode($data);
        }
        return $decode;
    }
}