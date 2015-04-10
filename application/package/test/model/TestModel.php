<?php
namespace test\model;

use \mvc\Model;

class TestModel extends Model
{
    public function Welcome()
    {
        return 'Test is Alive!';
    }
}