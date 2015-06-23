<?php

namespace init\weconsole\maker;
/**
 * Class Maker
 * @package core\init\weconsole\maker
 */
class Maker
{
    /**
     * Create file
     * @param $path
     * @throws MakerException
     */
    public static function touch($path)
    {
        //Directory Separator
        if(strpos($path, '\\') !== false)
        {
            $path = str_replace("\\", '/', $path);
        }

        //Check caracter
        if(strpos($path, '/') !== false)
        {
            //Break file path
            $path_parts = explode('/', $path);
            //Get filename
            $filename = $path_parts[count($path_parts) - 1];
            //Define directory
            unset($path_parts[count($path_parts) - 1]);
            $directory = implode('/', $path_parts) . '/';
        }
        else
        {
            $filename = $path;
            $caller = debug_backtrace();
            $directory = pathinfo($caller[0]['file'], PATHINFO_DIRNAME) . '/';
        }

        if(!is_dir($directory))
            if(!mkdir($directory, 0644, true))
                throw new MakerException('Can not create directory ' . $directory . '. Permision denied');


        //Check if directory is writable
        if(is_dir($directory) && is_writable($directory))
        {
            //Create file
            $file = $directory.$filename;
            if(!touch($file))
                throw new MakerException('Can not create file at ' . $file);
        }
        else
            throw new MakerException('File path is not writable: ' . $directory);
    }
}