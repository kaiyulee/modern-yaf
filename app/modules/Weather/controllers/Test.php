<?php

use \Yaf\Loader as Loader;

class TestController extends Controller
{
    public function testAction()
    {
        $m = new Weather();
        $m->getUsers();
        $this->getView()->display('test/test', ['a' => 'abc']);
    }

}
