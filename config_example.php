<?php

$env = [
    'LIVE_API_KEY' => '<YOUR APP\'S API KEY>',
    'DEMO_API_KEY' => '<YOUR APP\'S DEMO API KEY>', // so you can provide a subset of limited functionality beneath a separate key
    'EMAIL_ERRORS_TO' => '<USER WHO RECEIVES EMAILS FROM send_email()>'
];

$routes_list = []; // All registered routes are stored here
$use_validation = true;

?>