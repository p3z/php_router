<?php

function send_email($to, $subject, $message, $headers){

        try{
                $mail_sent = mail($to, $subject, $message, $headers);  
                
                if ( !$mail_sent ) {
                        save_to_access_log("Error sending email to " . $to . " - " . date('d-m-Y H:i:s'));
                } 
        } catch( Exception $e ){
                save_to_access_log("Error sending email to " . $to . " - " . date('d-m-Y H:i:s'));
                save_to_access_log("\nerror: " . $e);
        }
        
       
}

function build_log_message($params = [], $include_msg = ""){

        if( is_array($params) ){
                $route_name = $params[0];
        }

        $access_log_msg = "route '" . $route_name. "' accessed at " . date('d-m-Y H:i:s');
       
 

        foreach($params as $key => $val){
                if(is_numeric($key)){
                        unset($params[$key]); // params are always strings, so remove any default stuff, remainder shd now just be actual params user set
                }
        }

        
        

        switch($include_msg){
                case ($include_msg !== ""):

                        $access_log_msg .= " " . $include_msg;                        
                        break;
                
                default:

                        if( count($params) > 0){

                                $access_log_msg .= " params: " . json_encode($params);
                        }
        }

        return $access_log_msg;
        
}

// If saving to a log file, you may way to remember to include this in your gitignore
function save_to_file($input_string, $file_name = "access_log.php") {

        global $env;
        
        // Open the file in append mode, create it if it doesn't exist
        $file = fopen($file_name, 'a');
    
        // Check if the file was successfully opened
        if ($file === false) {

                $to = $env['EMAIL_ERRORS_TO'] ?? " EMAIL_ERRORS_TO not set";
                $subject = "Faker data API in use";
                $message = 'User accessed the system at ' . date('d-m-Y H:i:s');
                $headers = 'From: ' . $env['EMAIL_ERRORS_TO'] ?? " EMAIL_ERRORS_TO not set";
                send_email($to, $subject, $message, $headers);
    
        } else {
    
           // Append the input string to the file
           fwrite($file, $input_string . PHP_EOL);
    
           // Close the file
           fclose($file);
    
        }
    
       
    }


    function has_query_str($url) {
        $parsed_url = parse_url($url);
        return isset($parsed_url['query']);
}
    
function parse_query_str($str) {
        $params = [];
        parse_str($str, $params);
        return $params;
}

function has_post_variables() {
        return !empty($_POST);
}

function rand_arr_val($arr){
        return $arr[rand(0, count($arr) - 1)];
}

function rand_datetime($start, $end) {
    // Convert $start and $end to DateTime objects
    $start_date_time = new DateTime($start);
    $end_date_time = new DateTime($end);

    // Calculate the difference in seconds between $start and $end
    $interval_in_seconds = $end_date_time->getTimestamp() - $start_date_time->getTimestamp();

    // Generate a random number of seconds within the interval
    $random_seconds = mt_rand(0, $interval_in_seconds);

    // Create a new DateTime object by adding the random number of seconds to $start
    $result_date_time = clone $start_date_time;
    $result_date_time->add(new DateInterval('PT' . $random_seconds . 'S'));

    return $result_date_time;
}

function dd($data, $print = true){
        echo "<pre>";
                //echo "<br><br>Data type: " . gettype($data) . "<br><br>";

                if($print){
                        print_r($data);
                } else {
                        var_dump($data);
                }
                
                
        echo "</pre>";
        die();
        
}
?>