<?php

require_once './utils.php';
require_once './route_controller.php'; // A generic controller to handle all routes, you may want to break this up in future

include 'config.php';
if( !isset($env) ){
  $env = [];
}

require_once 'router.php';


add_route('GET', '/', 'get_root');
// etc...
add_route('GET', '/404', 'get_catchall');

//dd($routes);

run_router();


?>


