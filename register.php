<?php
include "heads.php";
$parameters = array('username'=>$config['username'], 'password' =>$config['password']);
$response = createRequest($config['baseUrl'],"Login",true,$parameters, $config['headers']);
$loginResponse = json_decode($response);
if ($loginResponse->Code == 0) {
	
		$AOkey 		=  $loginResponse->Result->Key;
		$AOToken  	=  $loginResponse->Result->Token; 
		$Url 		= $loginResponse->Result->Url .'/';
		$Username 	= $loginResponse->Result->Username;
		$headers = array(
						"AOKey: $AOkey",
						"AOToken: $AOToken"
					);
		$headers = array_merge($headers,$config['headers']);
		
		$Register = createRequest($Url,"Register", true,array('username'=>$config['username']), $headers);
		 $Register = json_decode($Register);
		if ($Register->Code ==0) {
			$_SESSION['AOkey'] 		=  $loginResponse->Result->Key;
			$_SESSION['AOToken']  	=  $loginResponse->Result->Token; 
			$_SESSION['Url'] 		=  $loginResponse->Result->Url .'/';
			$_SESSION['Username'] 	=  $loginResponse->Result->Username;	
		}
	
		
		
}
header("location: home.php");
exit;

?>

