<?php
/**
 * Class Login
 * Classe responsável por realizar operações da página Login
 *
 * @author Diogo Brito <diogo@weverest.com.br>
 * @package WeFramewrok
 * @subpackage Package/Home
 * @version 0.1 - 23/10/2014
 */

namespace login\controller;

use helpers\weframework\components\alert\Alert;
use helpers\weframework\components\request\Request;
use helpers\weframework\components\session\Session;
use login\model\LoginModel;
use \mvc\Controller;

class LoginController extends Controller
{

    public function Index()
    {
        if(Request::Post()->IsPost())
        {
            $login = new LoginModel();
            $login->Auth();
        }
        else
        {
            if(Session::Get('WE_ERROR'))
            {
                Alert::Error(Session::Get('WE_ERROR'));
            }
        }

        $this->Load()->View('login', array('message' => Alert::Alert()));
    }
}