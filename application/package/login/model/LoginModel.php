<?php
namespace login\model;

use \mvc\Model;
use Respect\Validation\Validator;
use core\security\Auth;
use helpers\weframework\components\alert\Alert;
use helpers\weframework\components\request\Request;

class LoginModel extends Model
{
    public function Auth()
    {
        $validate = Validator::key('user', Validator::string()->notEmpty())
            ->key('passwd', Validator::string()->notEmpty())
            ->validate(Request::Post()->GetAll());

        if($validate)
        {
            Auth::Active();
            Alert::Success('Parabéns! Vocês está logado.');
        }
        else
        {
            Alert::Error('Forneça os dados corretamente.');
        }
    }
}