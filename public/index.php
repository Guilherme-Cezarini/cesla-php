<?php 
// public/index.php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Routes\Routes;

require '../vendor/autoload.php';

Routes::execute();
