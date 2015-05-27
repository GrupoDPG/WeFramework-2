<?php
namespace home\controller;

use mvc\Controller;

class HelloController extends Controller
{
    public function index()
    {
        die('Index called!');
    }

    public function say()
    {
        die('Say Hello to me!');
    }

    public function hi()
    {
        die('hi');
    }
}