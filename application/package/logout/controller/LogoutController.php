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

namespace logout\controller;

use logout\model\LogoutModel;
use \mvc\Controller;

class LogoutController extends Controller
{

    public function Index()
    {
        $logout = new LogoutModel();
        $logout->Logout();
    }
}