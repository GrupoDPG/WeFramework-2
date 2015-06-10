<?php
namespace helpers\weframework\components\ehandler;
use helpers\weframework\components\session\Session;

/**
 * Class eHandler
 * @package helpers\weframework\components\ehandler
 */
class eHandler
{
    /**
     * setError
     * @param $message
     * @example
     * helpers/weframework/components/ehandler/eHandler::setMessage('Crash!');
     */
    public static function setMessage($message)
    {
        Session::Set('WE_EHANDLER_MESSAGE', $message, true);
    }

    /**
     * @return mixed
     */
    public static function getMessage()
    {
        $message = Session::Get('WE_EHANDLER_MESSAGE', true);
        Session::Destroy('WE_EHANDLER_MESSAGE');
        return $message;
    }
}