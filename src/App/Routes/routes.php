<?php 
namespace App\Routes;

use App\Helpers\Request;
use App\Helpers\Uri;
use Exception;

class Routes { 

    public const CONTROLLER_NAMESPACE = 'App\\Controller';
    public const API_CONTROLLER_NAMESPACE = 'App\\Api';
    public const MIDDLEWARE_NAMESPACE = "App\\Routes\\Middleware";


    public static function load(string $controller, string $method, string $middleware)
    {
        try {
            // roda o middleware
            if($middleware){ 
                $middlewareNamespaces = self::MIDDLEWARE_NAMESPACE. '\\' . $middleware;
                if (!class_exists($middlewareNamespaces)) {
                    throw new Exception("O Middleware {$middleware} não existe");
                }

                $middlewareInstance = new $middlewareNamespaces();
                $middlewareInstance->run();
            }

            $uri = Uri::get('path');
            $constrollerPrefixNamespace = strpos($uri, 'api') !== false ? self::API_CONTROLLER_NAMESPACE : self::CONTROLLER_NAMESPACE;
            // verificar se o controller existe
            $controllerNamespace = $constrollerPrefixNamespace . '\\' . $controller;
            if (!class_exists($controllerNamespace)) {
                throw new Exception("O Controller {$controller} não existe");
            }

            $controllerInstance = new $controllerNamespace;
            if (!method_exists($controllerInstance, $method)) {
                throw new Exception("O método {$method} não existe no Controller {$controller}");
            }
            
            $controllerInstance->$method((object)$_REQUEST);

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public static function routes(): array
    {
        return [
            'get' => [
                '/produtos'             => fn () => self::load('ProductController', 'index', ''), 
                "/produtos/criar"       => fn () => self::load('ProductController', 'create', ""),
                "/produtos/deletar"     => fn () => self::load('ProductController', 'delete', ""),
                "/produtos/exibir"      => fn () => self::load('ProductController', 'show',  ""),
                "/api/v1/produtos"      => fn () => self::load('ProductApiController', "products", "BearerTokenMiddleware"),
                "/api/v1/produtos/{id}" => fn () => self::load('ProductApiController', "product", "BearerTokenMiddleware"),
            ],
            'post' => [
                "/produtos/salvar"      => fn () => self::load('ProductController', 'store', "CSFRTokenMiddleware"),
                "/produtos/editar"      => fn () => self::load('ProductController', 'update', "CSFRTokenMiddleware"),
                "/api/v1/produtos"      => fn () => self::load('ProductApiController', 'create', 'BearerTokenMiddleware'),
            ],
            'put' => [
                "/api/v1/produtos/{id}" => fn () => self::load('ProductApiController', 'update', 'BearerTokenMiddleware'),

            ],
            'delete' => [
                "/api/v1/produtos/{id}" => fn () => self::load('ProductApiController', 'delete', 'BearerTokenMiddleware'),

            ],
        ] ;
    }

    // Função para encontrar a rota correspondente
    static function findRoute($method, $path) {
        $routes = self::routes();
        if (isset($routes[$method])) {
            foreach ($routes[$method] as $route => $controllerAction) {
                // Converter a rota definida em uma regex
                $pattern = preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', $route);
                $pattern = "@^" . $pattern . "$@D";
        
                if (preg_match($pattern, $path, $matches)) {
                    // Extrair os parâmetros da rota
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    return [
                        'handler' => $controllerAction,
                        'params' => $params,
                    ];
                }
            }
        }
        return null;
    }


    static function execute() {

        try {
            $request    = Request::get();
            $uri        = Uri::get('path');

            $routeResult = self::findRoute($request, $uri);
            if ($routeResult == null) {
                header("HTTP/1.0 404 Not Found");
                echo "<h1>404 - Página não encontrada</h1>";
                echo "<p>A página '$uri' não existe.</p>";
                exit;
            } 
          
            $router = $routeResult['handler'];
            if (!is_callable($router)) {
                header("HTTP/1.0 404 Not Found");
                echo "<h1>404 - Página não encontrada</h1>";
                echo "<p>Route {$uri} nao pode ser chamada</p>";
                exit;
            }

            $_REQUEST['url_params'] = $routeResult['params'];
            session_start();
            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
        
            header("Content-Security-Policy: default-src 'self'; script-src 'self'");
            $router();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    

    }
}