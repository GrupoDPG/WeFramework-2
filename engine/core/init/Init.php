<?php
/**
 * Init
 * Este arquivo tem como função iniciar as dependências e a aplicação como um todo.
 *
 * @author  Diogo Brito <diogo@weverest.com.br>
 * @version 0.1
 */

    /*
     * Iniciando Autoloaders
     * As linhas abaixo é responsável por carregar as classes dinâmicamente
     */

        /*
         * Core Autoloader
         */
        $core_loader = ENGPATH . 'core' . DS . 'autoload' . DS . 'Autoload.php';
        //Verificando se o Autoload existe
        if( is_file($core_loader) )
        {
            include_once $core_loader;
            $c_autoload = new \core\autoload\Autoloader();
        }

        /*
         * Vendor Autoloader
         * Classes de terceiros, dependências.
         */
        $vendor_loader = ENGPATH . 'vendor' . DS . 'autoload.php';
        //Verificando se o Autoload existe
        if( is_file($vendor_loader) )
        {
            include_once $vendor_loader;
        }

        /*
         * Iniciando serviços...
         */
        try
        {
            $service = \core\init\Service::GetInstance();
            $service->SetConfiguration(\core\init\Config::GetInstance());
            $service->InitServices();
            $service->Start();
        }
        catch (\core\exceptions\ServiceException $e)
        {
            exit($e->getMessage());
        }

// End of file Init.php
// Location: ./engine/core/init/Init.php