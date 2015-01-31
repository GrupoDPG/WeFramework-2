<?php
namespace logout\model;

use \mvc\Model;
use core\security\Auth;

class Logout extends Model
{
   public function Logout()
   {
       Auth::Logout();
   }
}