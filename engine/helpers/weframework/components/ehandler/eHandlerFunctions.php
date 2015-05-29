<?php
/**
 * setError
 * Reportar mensagem de erro
 * @param $message
 */
function eHandlerSetError($message)
{
    \helpers\weframework\components\ehandler\eHandler::setError($message);
}

/**
 * getMessage
 * Retorno de erro armazenado
 */
function eHandlerGetMessage()
{
    return \helpers\weframework\components\ehandler\eHandler::getMessage();
}