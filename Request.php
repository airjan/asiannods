<?php

function createRequest($baseUrl, $endpoint, $get = false, $parameters=array(), $headers =array() ) {
	
	$params ="";
	if ($get) {
		if ( count($parameters)<>0 )
		{	
			$params ='?';
			foreach($parameters as $key =>$value) {
				$params .= $key .'='.$value .'&';
			}
			$params = substr($params,0,strlen($params) -1);
		}
		
	}
	$RestPoint = $baseUrl . $endpoint . $params;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $RestPoint);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$server_output = curl_exec ($ch);
	curl_close($ch);
	
	return $server_output;
		
}
?>