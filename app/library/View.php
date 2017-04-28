<?php

class View implements Yaf\View_interface
{
    protected $loader;
    protected $twig;
    protected $tpl_vars = [];

    public function __construct($template_dir, array $options = [])
    {
        $this->loader = new Twig_Loader_Filesystem($template_dir);
        $this->twig = new Twig_Environment($this->loader, $options);
    }

    public function __isset($name)
    {
        return isset($this->tpl_vars[$name]);
    }

    public function __set($name, $value)
    {
        $this->tpl_vars[$name] = $value;
    }

    public function __get($name)
    {
        return $this->tpl_vars[$name];
    }

    public function __unset($name)
    {
        unset($this->tpl_vars[$name]);
    }

    public function getTwig()
    {
        return $this->twig;
    }

    public function assign($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->tpl_vars[$k] = $v;
            }
        } else {
            $this->tpl_vars[$name] = $value;
        }
    }

    public function display($template, $vars = null)
    {
        echo $this->render($template, $vars);
    }

    public function render($template, $var = null)
    {
        if (is_array($var)) {
            $this->tpl_vars = array_merge($this->tpl_vars, $var);
        }

        $config = \Yaf\Application::app()->getConfig()->toArray();

        $ext = $config['application']['view']['ext'];

        return $this->twig->loadTemplate($template . '.' .$ext)->render($this->tpl_vars);
    }

    public function getScriptPath()
    {
        $paths = $this->loader->getPaths();
        return reset($paths);
    }


    public function setScriptPath($template_dir)
    {
        $this->loader->setPaths($template_dir);
    }
}
