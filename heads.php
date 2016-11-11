<?php
session_start();
include "config.php";
include "Request.php";
require_once('TwitterAPIExchange.php');


$settings = array(
    'oauth_access_token' => $config['twitteraccesstoken'],
    'oauth_access_token_secret' => $config['twittertokensecret'],
    'consumer_key' => $config['twitterapikey'],
    'consumer_secret' => $config['twitterapisecret']
);
?>