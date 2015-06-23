<?php

/**
 * @param $name
 * @return null|string
 */
function getPostOf($name){
    return \helpers\weframework\components\request\Request::Post()->ValueOf($name);
}

/**
 * @param $name
 * @return null|string
 */
function printPostOf($name){
    $value = \helpers\weframework\components\request\Request::Post()->ValueOf($name);
    if(isset($value))
        echo $value;
    echo '';
}