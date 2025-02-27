<?php 
namespace App\Controller;


use League\Plates\Engine;

class Controller {


    public function view(string $view, $path, array $data = []) {
        $viewsPath = dirname(__FILE__, 4) . "/templates/{$path}"; 
        if (!file_exists($viewsPath . DIRECTORY_SEPARATOR . $view . ".php")) {
            throw new \Exception("A view {$view} não existe");
        }
        $templates = new Engine($viewsPath);
        echo $templates->render($view, $data);
    }
}