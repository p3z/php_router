<?php

function get_root($params, $query) {

        $info = [
          'api_name' => "<Your API name>",
          'last_updated' => '03/01/24 (uk)',
          'api_key' => "All routes require an API key to access (if use_validation inside router.php is true). This should be defined in config.php file beneath LIVE_API_KEY key of the env array. For a successful query, append your route url with a query string containing 'api_key=[your_api_key_goes_here]. For example, if my api key had the value 'super_awesome_api_key', then the /test route would be: /test?api_key=?super_awesome_api_key",
          'routes'=> [
              [
                  'route'=> '/',
                  'method'=> 'GET',
                  'behaviour'=> "Lorem ipsum...",
                  'route_params'=> [
                      'lorem'=> 'ipsum',
                      'dolores' => 'amet'
                  ]
                ],
              
          ]
      
        ];
      
        $access_log_msg = build_log_message( $params );
        save_to_file($access_log_msg);
        echo json_encode($info);
}

function get_catchall($params, $query) {

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);    
        $access_log_msg = build_log_message( [$uri], "- invalid route");
        save_to_file($access_log_msg);
        echo json_encode(["invalid route"]);
};

?>