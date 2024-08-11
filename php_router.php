<?php

class PHPRouter{

  // Adds route to list of routes
  public static function add_route($method, $path, $callback) {

    global $routes_list;       
    $routes_list[$method][$path] = $callback;

  }


  public static function run_router( $middlewares_to_run  = [] ){

    global $routes_list;

    $query = $_GET;
    //$is_valid = GenericMiddleware::validate_api_key($query);

    // foreach( $middlewares_to_run ){

    // }
    
    // Determine the path the user is trying to visit...
    $visited_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // ... also how they're doing so
    $method = $_SERVER['REQUEST_METHOD'];
  
    // Set a flag to identify whether the route they're visiting is valid
    $valid_route = false;
  
    // Loop through any matching routes, getting ready to run the associated callback
    foreach ($routes_list[$method] as $path => $callback) {
      
      // Replace all instances of the forward slash (/) in $path with an escaped forward slash (\/) - ready the path for some regex magic 
      $path_pattern = str_replace('/', '\/', $path);

      // Convert a path pattern with placeholders (eg '/user/{id}/profile') into a regex pattern ready for identifying those route params. Params are identified by the use of curly brackets {}      
      $variable_pattern = preg_replace('/\{([^\/]+)\}/', '(?P<$1>[^\/]+)', $path_pattern);
      
      // Make sure is complete match, not just partial
      $final_pattern = '/^' . $variable_pattern . '$/'; 
  
      if (preg_match($final_pattern, $visited_path, $matches)) {

        // The visited path matched the pattern so this route is vaid
        $valid_route = true;

        // Debugging output
        // echo "Matched route: $path\n";
        // var_dump($callback);
        
        // Woohoo, valid route, so let's run the callback
        $callback($matches, $query);
        break;
      }
      
    } // end valid_route checking
    
    // If this runs, there were no matching routes identified
    if (!$valid_route) {      
  
      $params = [];
      $notFoundCallback = $routes_list['GET']['/404']; // Not valid, so load 404 route instead
      $notFoundCallback('GET', $params, $query);          

    }
  
  
  } // end fn

}// end class


?>