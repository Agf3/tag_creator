<!-- 
*Error Handler
 -->

<?php 

interface IErrorHandler{
	function __construct($path, $file, $any_error);
}

class ErrorHandler implements IErrorHandler{
		
	public function __construct($path, $file, $any_error){
		$this->print_error_msg($any_error);
		$this->write_csv_log($path, $file, $this->logError($any_error));
	}
	
	private function print_error_msg($any_error){
		echo $any_error->getMessage() . "<br>\n";
	}
	
	//write array containing error details to csv file
	private function write_csv_log($path, $file, $log_array){
		$csv = fopen($path . $file, 'a');
		fputcsv($csv, $log_array);
		fwrite($csv, "\r\n");
	}
		
	//parse exception details and creates an array that can be written to a log
	private function logError($any_error) {
		$traceError = $any_error->getTrace();
		$errorInfo = array("Message: " . $any_error->getMessage(),
						   "File: " . $any_error->getFile(), 
			    		   "Thrown on line: " . $any_error->getLine(),
						   "Code: " . $any_error->getCode(), 
			 			   "Called by function: " . $traceError[0]['function'],
						   "On line: " . $traceError[0]['line'],
						   "in file" . $traceError[0]['file'],
						   "Classification: " . $this->classify($any_error->getCode()));	
		return $errorInfo;
	}
		
	//this function assumes that a severe error code is between 111 and 120 
	//while a warning error code is less than or equal to 110
	private function classify($code){
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