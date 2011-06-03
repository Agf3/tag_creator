<!-- 
*Error Handler
 -->

<?php 

include 'file_manager.php';

interface IErrorHandler{
	function printErrorMsg($anyError);
	function logError($anyError);
	function classify($code);
}

class ErrorHandler implements IErrorHandler{
		
	public function __construct($path, $file, $anyError){
		$this->printErrorMsg($anyError);
		$fm = new FileManager();
		$fm->write_csv_log($path, $file, $this->logError($anyError));
		;
	}
	
	public function printErrorMsg($anyError){
		echo $anyError->getMessage() . "<br>\n";
	}
		
	//parse exception details and creates an array that can be written to a log
	public function logError($anyError) {
		$traceError = $anyError->getTrace();
		$errorInfo = array("Message: " . $anyError->getMessage(),
						   "File: " . $anyError->getFile(), 
			    		   "Thrown on line: " . $anyError->getLine(),
						   "Code: " . $anyError->getCode(), 
			 			   "Called by function: " . $traceError[0]['function'],
						   "On line: " . $traceError[0]['line'],
						   "in file" . $traceError[0]['file'],
						   "Classification: " . $this->classify($anyError->getCode()));	
		return $errorInfo;
	}
		
	//this function assumes that a severe error code is between 111 and 120 
	//while a warning error code is less than or equal to 110
	function classify($code){
		if($code <= 110){
			$classify = "Warning";
		}
		if($code > 110 && $code <= 120){
			$classify = "Severe";
		}
		return $classify;
	}
}

?>