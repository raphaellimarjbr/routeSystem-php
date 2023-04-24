<?php

    namespace App\Routes;

    class Routes
    {
        public static function routes () : array 
        {
            $routes = array(
                "/" => "HomeController@index",
                "/about" => "AboutController@index"
            );

            return $routes;
        }
    }