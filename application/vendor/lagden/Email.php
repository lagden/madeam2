<?php
namespace lagden;
/**
*
* @author Lagden
*/
class Email{
		
	public static function send($to,$subject,$msg,$from="Application <application@gmail.com>",$reply="no-reply@gmail.com"){
		$headers="".
		"MIME-Version: 1.0\r\n".
		"X-Mailer: MadeAM\r\n".
		"Content-type: text/html; charset=iso-8859-1\r\n".
		"From: {$from}\r\n".
		"Reply-To: {$reply}\r\n";
		//
		return mail($to,$subject,$msg,$headers);
	}
	//	
}
