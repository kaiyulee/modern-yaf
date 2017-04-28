<?php
class ErrorController extends Yaf\Controller_Abstract
{
    public function errorAction($exception)
    {
        // $e = $this->_request->getException();
        echo $exception;
        var_dump($exception->getCode());
        switch($exception->getCode()) {
            case YAF_ERR_NOTFOUND_MODULE;
            case YAF_ERR_NOTFOUND_CONTROLLER:
            case YAF_ERR_NOTFOUND_ACTION:
            //404
            header("Not Found");
            break;
        } 
    }
}
