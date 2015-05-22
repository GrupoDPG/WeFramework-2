<?php
/**
 * Separador de Diretórios
 */
define('WECON_DS', DIRECTORY_SEPARATOR);

/**
 * Console PATH
 * Diretório do console
 */
define('WECON_BASEPATH', __DIR__ . WECON_DS);

/**
 * Application PATH
 * Indice o caminho do diretório application do weframework2
 */
define('WECON_APP', '/../application/');

/**
 * Engine PATH
 * Indice o caminho do diretório engine do weframework2
 */
define('WECON_ENGINE', '/../engine/');

/**
 * Layout PATH
 * Indice o caminho do diretório layout do weframework2
 */
define('WECON_LAYOUT', '/../layout/');

/**
 * Definindo caminho de diretórios absoluto
 */
define('WECON_BASEPATH_APP', __DIR__ . rtrim(str_replace('/', WECON_DS, WECON_APP), WECON_DS) . WECON_DS);
define('WECON_BASEPATH_ENGINE', __DIR__ . rtrim(str_replace('/', WECON_DS, WECON_ENGINE), WECON_DS) . WECON_DS);
define('WECON_BASEPATH_LAYOUT', __DIR__ . rtrim(str_replace('/', WECON_DS, WECON_LAYOUT), WECON_DS) . WECON_DS);

/**
 * Consitência de diretórios
 */
$wecon_flag_error = false;
if(!is_dir(WECON_BASEPATH_APP))
{
    echo 'application directory does not exist - ' . WECON_BASEPATH_APP . PHP_EOL;
    $wecon_flag_error = true;
}
if(!is_dir(WECON_BASEPATH_ENGINE))
{
    echo 'engine directory does not exist - ' . WECON_BASEPATH_ENGINE . PHP_EOL;
    $wecon_flag_error = true;
}

if(!is_dir(WECON_BASEPATH_ENGINE))
{
    echo 'engine directory does not exist - ' . WECON_BASEPATH_ENGINE . PHP_EOL;
    $wecon_flag_error = true;
}

if($argv[1] == '--status')
    if($wecon_flag_error)
        echo 'Error - Your config file is not set correctly';
    else
        echo 'OK - Config file was built successfully';


/**
 * Verifica status de configuração
 */
if($wecon_flag_error)
{
    exit();
}