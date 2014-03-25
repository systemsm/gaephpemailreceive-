<?php
require_once 'google/appengine/api/log/LogService.php';
use google\appengine\api\log\LogService;

syslog(LOG_INFO, "log insert");
$isi = file_get_contents('php://input');
$lines = explode("\n", $isi);
$from = "";
$subject = "";
$to = "";
$headers = "";
$message = "";

$splittingheaders = true;
for ($i=0; $i < count($lines); $i++) {
	if ($splittingheaders) {
		$headers .= $lines[$i]."\n";	 
		if (preg_match("/^Subject: (.*)/", $lines[$i], $matches)) {
			$subject = $matches[1]; // subject
		}
		if (preg_match("/^From: (.*)/", $lines[$i], $matches)) {
			$from = $matches[1]; // from
		}
		if (preg_match("/^To: (.*)/", $lines[$i], $matches)) {
			$to = $matches[1]; // to
		}
	} else {
		$partone = substr($isi, strripos($isi,"plain; charset=")+strlen("plain; charset=ISO-8859-1"));
		$realisi = explode('--',$partone);
		$txtisi = $realisi[0]; // mail
	}
	 
	if (trim($lines[$i])=="") {
		$splittingheaders = false;
	}

} 

syslog(LOG_INFO, ' from = '.$from );
syslog(LOG_INFO, ' subject = '.$subject );
syslog(LOG_INFO, ' to = '.$to );
syslog(LOG_INFO, ' isiemail2 = '.$textisi);
syslog(LOG_INFO, "end log insert");

?>
