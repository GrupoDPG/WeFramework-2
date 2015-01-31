<?php
namespace core\router;
use helpers\weframework\classes\Config;
use helpers\weframework\classes\Singleton;

/**
 * Class Webservice
 * @package core\router
 */
class Webservice
{
    use Config;
    use Singleton;

    /**
     * @var array|null
     * Configuração de rota do webservice
     */
    private static $ws_config = null;

    public function __construct()
    {
        if(!isset(self::$ws_config))
        {
            $config = $this->GetFileConfig('routes.ini', true);
            self::$ws_config = $config['webservice'];
        }
    }

    /**
     * WSActive
     * Status do webservice
     * @return bool
     */
    public function WSActive()
    {
        $ws =  self::$ws_config['webservice'];
        if(strtolower($ws) == 'on')
            return true;

        return false;
    }
    /**
     * WSRouter
     * Rota do webservice
     * @return mixed
     */
    public function WSRouter()
    {
        return self::$ws_config['ws_router'];
    }

    /**
     * WSAuth
     * @return mixed
     * Autenticação do webservice
     */
    public function WSAuth()
    {
        $ws =  self::$ws_config['ws_auth'];
        if(strtolower($ws) == 'on')
            return true;

        return false;
    }

    /**
     * WSEncode
     * @return mixed
     */
    public function WSEncode()
    {
        return self::$ws_config['ws_encode'];
    }
}