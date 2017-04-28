<?php
use Yaf\Registry as Registry;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->getView()->content = 567;
        $this->display('index');
    }

    public function redisAction()
    {
        $cfg = Registry::get('redis');
        $redis = new Redis();
        $redis->connect($cfg['host'], $cfg['port']);
        $redis->auth($cfg['password']);
        $isConnected = $redis->ping();
        if ($isConnected !== '+PONG') {
            echo 'Failed to connect!';
            return false;
        }

        $redis->del('program');
        $redis->lpush('program', 'PHP');
        $redis->lpush('program', 'JavaScript');
        $redis->lpush('program', 'MongoDB');
        $res = $redis->lrange('program', 0, -1);
        var_dump($res);

        return false;
    }

    public function subscribeAction()
    {
        $request = $this->getRequest();
        $data = $request->getPost();

        var_dump($data);
                     
    }
}
