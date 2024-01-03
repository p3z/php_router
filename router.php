<?php

$routes = [];
$use_validation = true;

// Adds route to list of routes
function add_route($method, $path, $callback) {

        global $routes;       
        $routes[$method][$path] = $callback;

}

function validate_api_key($query){

  global $env, $use_validation;
  if($use_validation){
    
    $demo_api_key = $env['DEMO_API_KEY'];
    $valid_api_key = $env['LIVE_API_KEY']; 

    if(!isset($valid_api_key) && !isset($demo_api_key)){
      echo "Invalid server api key.";
      return;
    }
  
    if (!empty($query) && isset($query['api_key'])) {

      return ($query['api_key'] === $valid_api_key || $query['api_key'] === $demo_api_key);

    } else {
      return false;
    }
  } else {
    return true;
  }

 


 

}

function run_router(){

        global $routes;

        $query = $_GET;
        $is_valid = validate_api_key($query);

        if(!$is_valid){
          echo "Invalid client API key";
          return;
        }
        
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
      
        $valid_route = false;
      
        foreach ($routes[$method] as $path => $callback) {
          
          $pattern = str_replace('/', '\/', $path);  // ready the path for some regex magic
          $pattern = preg_replace('/\{([^\/]+)\}/', '(?P<$1>[^\/]+)', $pattern); // Capture substrings inside curly brackets: {}
          $pattern = '/^' . $pattern . '$/'; // Make sure is complete match, not just partial
      
          if (preg_match($pattern, $uri, $matches)) {
            $valid_route = true;

            // Debugging output
            // echo "Matched route: $path\n";
            // var_dump($callback);
            
            $callback($matches, $query);
            break;
          }
          
        } // end valid_route checking
      
        if (!$valid_route) {
      
          $params = [];
          $notFoundCallback = $routes['GET']['/404']; // Not valid, so load 404 route instead
          $notFoundCallback('GET', $params, $query);          

        }
      
      
      }

?>