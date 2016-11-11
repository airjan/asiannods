<?php

include "heads.php";
$url = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = 'POST';
$twitter = new TwitterAPIExchange($settings);

$postfields = array(
    'status' => $_POST['tweetvalue'], 

);

/** Perform a POST request and echo the response **/
$twitter = new TwitterAPIExchange($settings);
$response =  $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();

$response = json_decode($response);
$result ="Success ";
if (@$response->errors) 
{
	$result =  $response->errors[0]->message;
}
echo "<script> alert('".$result."');</script>";
echo "<script> location.replace('home.php');</script>";

?>