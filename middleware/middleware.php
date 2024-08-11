<?php

class GenericMiddleware{

    public static function validate_api_key($query){

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
        
       
      
    } // end fn

}// end class
?>