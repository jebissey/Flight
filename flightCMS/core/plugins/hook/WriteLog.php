<?php
//--------------------------------------------------------------------------------------------------
// Write a typical and simple Log-File. To reset the Log, delete the '/log/' Directory
//--------------------------------------------------------------------------------------------------
$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Plugins können nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class WriteLog
{   
	//---------------------------------------------------------------------------------------------
	// Send Hook for Register
	//---------------------------------------------------------------------------------------------
  	function hook()
    {
      	return 'beforeStart';
    }
  
	//---------------------------------------------------------------------------------------------
	// Create a EXCEL-CSV File for easy Process. Attach to global LOG_DIR.
	//---------------------------------------------------------------------------------------------
  	function run($var)
    {
		Debug::out('WriteLog.php','Run','$var');
      	//date_default_timezone_set('UTC');
      	date_default_timezone_set('Europe/Berlin');
		$log_file     = LOG_DIR.'/log-'.date('Y-m-d').'.csv';												// define e.g. 'log/log-2024-01-12.csv'
		$http_referer = '';
      	
  		if(isset($_SERVER['HTTP_REFERER'])) $http_referer = $_SERVER['HTTP_REFERER'];
  
		$output  = date('H:i:s');
		$output .= ';';
  		$output .= $http_referer;
		$output .= ';';
  		$output .= $_SERVER['REQUEST_URI'];
  		$output .= ';';
		$output .= "'".$_SERVER['REMOTE_ADDR'];																// single ' for Excel
		$output .= ';';
		$output .= str_replace(';',' ',$_SERVER['HTTP_USER_AGENT']);
		$output .= "\n";
    
    	file_put_contents($log_file, $output, FILE_APPEND | LOCK_EX)!==false;
    }
}
?>