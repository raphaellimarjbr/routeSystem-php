<?php

    namespace App\Routes;

    use App\Routes\Routes;

    use App\Controllers\ErrorController;

    class Route 
    {
        public function __construct ()
        {
            $request = $_SERVER["REQUEST_METHOD"];
            $uri = $_SERVER["REQUEST_URI"];

            $routes = Routes::routes();

            if ($request == "GET") {
                $url = explode("/", $uri);
                array_shift($url);
                array_shift($url);

                $controller = "/{$url[0]}";
            
                if (array_key_exists($controller, $routes)) {
                    $separatorClassAndMethod = explode("@", $routes[$controller]);
                    array_shift($url);
            
                    $class = $separatorClassAndMethod[0];
                    $namespace = "App\Controllers\\{$class}";
                    array_shift($separatorClassAndMethod);
            
                    $method = $separatorClassAndMethod[0];
                    array_shift($separatorClassAndMethod);
                    if (class_exists($namespace)) {
                        if (method_exists($namespace, $method)) {
                            $index = new $namespace;
                            if(isset($url[0])) {
                                $params = $url[0];
                                array_shift($url);
                                call_user_func_array(array($index, $method), array($params));
                                echo $index->$method($params);
                            } else {
                                echo $index->$method();
                            }                            
                        } else {
                            echo "Método {$method} não existe!";
                        }
                    } else {
                        echo "Classe {$class} não existe!";
                    }
                } else {
                    $class = new ErrorController;
                    $method = $class->index();
                    echo $method;
                }
            }
        }
    }