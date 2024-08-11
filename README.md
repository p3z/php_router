# php_router
A simple routing system for building APIs in PHP

### Logic
- .htaccess routes all requests through index.php (not needed on local)
- index.php is used for listing routes and running the main router function (run_router)
- php_router.php is where the routing system is handled.
  - The add_route function stores routes listed in index.php as an associative array. Routes are stored beneath their request method, and individual routes are keyed by their url, with their value being the callback to run when the particular route is called.
  - Each route's callback is currently defined in a single controller (route_controller.php), though it is trivial to amend this if needed to further orgranise routes according to a project's need. 
  - The run_router function is the main function that ties everything together. It identifies the route from the request's url, loops through the $routes_list array looking for a match. If one is found, it runs the associated callback. If none is found, it is passed to a default route and associated catchall function.
  - validate_api_key allows us to specify an API key to protect our routes from unauthorised clients. $use_validation (inside php_router.php) is a boolean that determines if this check is done or not. If use_validation is true, then all routes require an API key to access. This should be defined inside config.php beneath LIVE_API_KEY key of the $env array. For a successful query, append your route url with a query string containing 'api_key=[your_api_key_goes_here]. For example, if my api key had the value 'super_awesome_api_key', then the /test route would be: /test?api_key=?super_awesome_api_key
- utils.php is a small library of handy utility functions.
- config.php is the equivalent of a .env file. I wanted to keep this system completely dependency-free (ie didnt want to use common packages for env file logic), so am just using a regular php file. This being the case, it's important to remember to include it in your .gitignore if you don't want it in your source! Also, to set the correct permissions on the file as the needs of your app require. The $env array is used to store all environment variables. The values in the list below are the current defaults that the system makes use of.

```
        $env = [
                'LIVE_API_KEY' => '<YOUR APP'S API KEY>',
                'DEMO_API_KEY' => '<YOUR APP'S DEMO API KEY>', // so you can provide a subset of limited functionality beneath a separate key
                'EMAIL_ERRORS_TO' => '<USER WHO RECEIVES EMAILS FROM send_email()>'
        ];
```

