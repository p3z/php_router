<?php
include 'config.php';

if( !isset($env) || !isset($routes_list) ){
  // Force a generic error if required variables not present
  echo "Error 1: Incorrect configuration.";
}

require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/middleware/middleware.php';
require_once __DIR__ . '/controllers/route_controller.php';
require_once 'php_router.php';

/*****************************************************************/
#
# Register routes via add_route
# add_route
#   - $method
#   - $path
#   - $callback: the function to run when user visits $path
#
/*****************************************************************/
// PHPRouter::add_route( $method, $path, $callback );
PHPRouter::add_route('GET', '/', 'get_root');
PHPRouter::add_route('GET', '/home', 'get_home');
PHPRouter::add_route('GET', '/404', 'get_catchall');

PHPRouter::run_router();
?>


