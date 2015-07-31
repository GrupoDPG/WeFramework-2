<?php
/**
 * Class Home
 * Classe responsável por realizar operações da página Home
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @package WeFramewrok
 * @subpackage Package/Home
 * @version 0.1 - 11/03/2014
 */
namespace home\controller;
use home\model\HomeModel;
use \mvc\Controller;

class HomeController extends Controller
{
    /**
     * __construct
     * Adicione controladores auxiliares
     * @example
     * param 1 = route
     * param 2 = controller
     * param 3 = metthod NULL
     * $this->AddController('home/hello', '/home/controller/HelloController');
     * $this->AddController('home/abc/dfg/uhul', '/home/controller/HelloController', 'say');
     */
    public function __construct()
    {
        $this->AddController('home/hello', '/home/controller/HelloController');
        $this->AddController('home/abc/dfg/uhul', '/home/controller/HelloController', 'say');
    }

    /**
     * Index
     * Carregamento inicial - método pincipal
     *
     * @access public
     * @return void
     * @example
     *
     * Exemplo de carregamento de outras camadas:
     *
     * Model
     * $this->Load()->Model('nome_do_arquivo', 'alias');
     *  - Usando
     *       $this->alias->Method;
     *
     * Component
     * $this->Load()->Component('nome_do_arquivo', 'alias');
     *  - Usando
     *       $this->alias->Method;
     *
     * View
     * $this->Load()->View('pagina', array('data1' => $dado1, 'data2' => $dado2));
     */
    public function Index()
    {
        $model = new HomeModel();
        //Verifica se outras camadas foram carregadas
        if($this->Loaded())
        {
            $welcome_message = $model->Welcome();

            /*
             * Enviando dados para a View
             */
            $this->Load()->View('index|home', array('welcome_message' => $welcome_message));
        }
    }

    /**
     * Exemplo com o WE Webservice
     * Acesse: domain/webservice/home/call
     */
    public function Call()
    {
        $this->Load()->View('home/call', array(
            'test' => 'Testing...'
        ), true);
    }
}