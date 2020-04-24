<?php

namespace application\core;

use application\core\View;

class Router {

    protected $routes = [];
    protected $params = [];
    
    public function __construct() {
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    //метод добавления маршрутов 
    public function add($route, $params) {
        $route = '#^'.$route.'$#'; //ключи массива стали регулярными выражениями
        $this->routes[$route] = $params;
    }

    //метод проверки наличия маршрута
    public function match() {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run(){
        if ($this->match()) {
        // echo 'маршрут найден';
        echo '<p>controller: <b>'.$this->params['controller'].'</b></p>';
        echo '<p>action: <b>'.$this->params['action'].'</b></p>';
            
        $path = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'].'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                    
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }
}