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

use \mvc\Controller;
use logout\model\Logout as mLogout;

class Logout extends Controller
{

    public function Index()
    {
        $logout = new mLogout();
        $logout->Logout();
    }
}