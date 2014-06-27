<?php

/************************************************************/
//    PSU-Passport Web Service via Nusoap           		//
//   			ver.2013 for php5 				     		//
//												     		//
//  modifly by Mr.Niti Chotkaew (TTMED-PSU)                 //
//													 		//
//  update Nusoap http://sourceforge.net/projects/nusoap    //
//															//
//  fix. 1.compatible for php 5                   			//
//       2.support UTP-8                  					//
/***********************************************************/
 

require_once(APPPATH.'libraries/nusoap.php');

/**************************************************/
//    function  -  Authenticate                   //
//    output    -  ture / false                   //
/**************************************************/
function lib_psulogin_authenticate($id,$password){
	
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $id : '';
$proxypassword = isset($_POST['proxypassword']) ? $password : '';
$client = new nusoap_client('https://passport.psu.ac.th/authentication/authentication.asmx?WSDL', 'wsdl',
						$proxyhost, $proxyport, $proxyusername, $proxypassword);
						
	$err = $client->getError();
	echo $err;
	if ($err) {
			$str_return =  $err ;
	  }
	$proxy = $client->getProxy();
	$person = array('username' => $id,'password' => $password);
	$result = $proxy->Authenticate($person);
 
	if ($client->fault) {
			$str_return = $result["AuthenticateResult"];
	}else{
		  $err = $client->getError();
		 if ($err){
			   $str_return =  $err ;
		 }else{
			   $str_return = $result["AuthenticateResult"];
		 }
	}
	
	return $str_return;
}


/*****************************************************/
//   function - GetStudentDetails                    //
//   output -   code/firstname/lastname/fac.code     //
/****************************************************/
function lib_psulogin_getStudentDetails($id,$password){
	
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $id : '';
$proxypassword = isset($_POST['proxypassword']) ? $password : '';
$client = new nusoap_client('https://passport.psu.ac.th/authentication/authentication.asmx?WSDL', 'wsdl',
						$proxyhost, $proxyport, $proxyusername, $proxypassword);
						
	$err = $client->getError();
	echo $err;
	if ($err) {
			$str_return =  $err ;
	  }
	
	$client->soap_defencoding = 'UTF-8';
    $client->decode_utf8 = false;
	$proxy = $client->getProxy();
	$person = array('username' => $id,'password' => $password);
	$result = $proxy->GetStudentDetails($person);
	
	if ($client->fault) {
			$str_return = $result["GetStudentDetailsResult"]["string"];
	}else{
		  $err = $client->getError();
		 if ($err){
			   $str_return =  $err ;
		 }else{
			   $str_return = $result["GetStudentDetailsResult"]["string"];
		 }
	}
	return $str_return;
}

/**************************************************************/
//    function  -  GetStaffDetails                            //
//    output    -  code/firstname/lastname/id card/fac.code   //
/**************************************************************/
function lib_psulogin_getStaffDetails($id,$password){
	
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $id : '';
$proxypassword = isset($_POST['proxypassword']) ? $password : '';
$client = new nusoap_client('https://passport.psu.ac.th/authentication/authentication.asmx?WSDL', 'wsdl',
						$proxyhost, $proxyport, $proxyusername, $proxypassword);
						
	$err = $client->getError();
	echo $err;
	if ($err) {
			$str_return =  $err ;
	  }
	
	$client->soap_defencoding = 'UTF-8';
    $client->decode_utf8 = false;
	$proxy = $client->getProxy();
	$person = array('username' => $id,'password' => $password);
	$result = $proxy->GetStaffDetails($person);
	
	if ($client->fault) {
			$str_return = $result["GetStaffDetailsResult"]["string"];
	}else{
		  $err = $client->getError();
		 if ($err){
			   $str_return =  $err ;
		 }else{
			   $str_return = $result["GetStaffDetailsResult"]["string"];
		 }
	}
	return $str_return;
}

/**************************************************/
//    function  -  GetStaffID                     //
//    output    -  code                           //
/**************************************************/
function lib_psulogin_getStaffID($id,$password){
	
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $id : '';
$proxypassword = isset($_POST['proxypassword']) ? $password : '';
$client = new nusoap_client('https://passport.psu.ac.th/authentication/authentication.asmx?WSDL', 'wsdl',
						$proxyhost, $proxyport, $proxyusername, $proxypassword);
						
	$err = $client->getError();
	echo $err;
	if ($err) {
			$str_return =  $err ;
	  }
	$proxy = $client->getProxy();
	$person = array('username' => $id,'password' => $password);
	$result = $proxy->GetStaffID($person);
	
	if ($client->fault) {
			$str_return = $result["GetStaffIDResult"];
	}else{
		  $err = $client->getError();
		 if ($err){
			   $str_return =  $err ;
		 }else{
			   $str_return = $result["GetStaffIDResult"];
		 }
	}
	return $str_return;
}

/***************************************************************************************************************************/
//    function  -  GetUserDetails                                                                                          //
//    output    -  username,firstname,lastname,code,sex,id card,?,fac.code,fac.name,campus.code,campus.name,?,title,email  //
/***************************************************************************************************************************/
function lib_psulogin_getUserDetails($id,$password){
	
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $id : '';
$proxypassword = isset($_POST['proxypassword']) ? $password : '';
$client = new nusoap_client('https://passport.psu.ac.th/authentication/authentication.asmx?WSDL', 'wsdl',
						$proxyhost, $proxyport, $proxyusername, $proxypassword);	
						
	$err = $client->getError();
	echo $err;
	if ($err) {
			$str_return =  $err ;
	  }
	$client->soap_defencoding = 'UTF-8';
    $client->decode_utf8 = false;
	$proxy = $client->getProxy();
	$person = array('username' => $id,'password' => $password);
	$result = $proxy->GetUserDetails($person);
	
	if ($client->fault) {
			$str_return = $result["GetUserDetailsResult"]["string"];
	}else{
		  $err = $client->getError();
		 if ($err){
			   $str_return =  $err ;
		 }else{
			   $str_return = $result["GetUserDetailsResult"]["string"];
		 }
	}
	return $str_return;
}

?>