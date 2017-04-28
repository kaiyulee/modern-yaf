<?php
use Yaf\Application;
use Yaf\Bootstrap_Abstract as BootstrapAbstract;

Class Bootstrap extends BootstrapAbstract
{
    private function _initLoadModel(Yaf\Dispatcher $dispatcher)
    {
        $uri = strtolower($dispatcher->getRequest()->getRequestUri());
        $path_info = array_filter(explode('/', $uri));
        $len = count($path_info);
        $model = array_shift($path_info);
        $model_path = APP_PATH . 'modules/' . "{$model}/models/";
        if ($len >= 3 && $model != 'index') {
            spl_autoload_register(function($class) use ($model_path) {
                // include $model_path . substr($class, 0, strlen($class) - 5) . '.php';
                // Yaf\Loader::import($model_path . substr($class, 0, strlen($class) - 5) . '.php');
                Yaf\Loader::import($model_path . $class . '.php');
            });
        }
    }

    private function _initComposerAutoload(Yaf\Dispatcher $dispatcher)
    {
        require DOCUMENT_ROOT . '/vendor/autoload.php';
    }

    private function _initDbConfig(Yaf\Dispatcher $dispatcher)
    {
        $config = new Yaf\Config\Ini(CONF_PATH . '/database.ini', ENV_MODE);
        Yaf\Registry::set('mysql', $config['mysql']);
        Yaf\Registry::set('redis', $config['redis']);
    }

    private function _initRoute(Yaf\Dispatcher $dispatcher)
    {
        $router = $dispatcher->getRouter();
        $route = new Yaf\Route\Regex(
            'product/([a-zA-Z-_0-9]+)', // match
            ['controller' => 'wechat', 'action' => 'service'], // route
            [], // map
            []  // verify
        );
        //$router->addRoute('new_route', $route);
    }

    private function _initView(Yaf\Dispatcher $dispatcher)
    {
        // 关闭自动Render. 默认是开启的, 在动作执行完成以后, Yaf会自动render以动作名命名的视图模板文件.
        $dispatcher->disableView();

        // 开启/关闭自动渲染功能. 在开启的情况下(Yaf默认开启), Action执行完成以后, Yaf会自动调用View引擎去渲染该Action对应的视图模板.
        $dispatcher->autoRender(false);
    }

    private function _initTwig(Yaf\Dispatcher $dispatcher)
    {
        $config = Application::app()->getConfig()->toArray();
        $dispatcher->setView(new View(APP_PATH . 'views', $config['twig']));
    }
}
