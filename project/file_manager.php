<!-- 
/*
*Yitzchoks class 
*/
-->

<?php

include 'error_handler.php';

interface IFileManager{
	function createFile($path, $file);
	function readFile($path, $file);
	function updateFile($path, $file, $content, $mode);
	function deleteFile();
	function file_modification_time($path, $file);
}

class FileManager implements IFileManager{
		
	public function createFile($path, $file){
		try{
			$this->validate_path_file($path, $file, null);
			if (file_exists($path . $file)){    									
				throw new FileExistsException();     			//throws exception if file already exists
			}
			fopen($handle = $path . $file, 'w+');    			 		
            fclose($handle);     															//closes newly created file
        }
		catch(FileExistsException $fee){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fee);		//displays error message and writes error to log
		}
		catch (InvalidFileParameterException $ifpe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $ifpe);
		}
	}

	public function readFile($path, $file){
		try{
			$this->validate_path_file($path, $file, null);
			if (!file_exists($path . $file)){    											
				throw new FileNotFoundException(); 				//throws exception if file does not exist
			}
			if (!is_readable($path . $file)){     											
				throw new FileNotReadableException();     		//throws exception if file is not readable
			}
			$handle = fopen($path . $file, 'r');     										//opens file
			$content = fread($handle, filesize($path . $file));     						//reads contents of file
			return $content;     															//returns contents of file
			fclose($handle);     															//closes file
		}
		catch(FileNotFoundException $fnfe){
			//echo $fnfe->getMessage();
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnfe);		//displays error message and writes error to log
		}
		catch(FileNotReadableException $fnre){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnre);		//displays error message and writes error to log
		}
		catch (InvalidFileParameterException $ifpe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $ifpe);		//displays error message and writes error to log
		}
	}

	public function updateFile($path, $file, $content, $mode){    	 						//Valid Modes: (a) Append (w) Write
		try{
			$this->validate_path_file($path, $file, $content);
			if ((!$mode == 'a') && (!$mode == 'w')){     										
				throw new InvalidWriteModeException();  		//throws exception if invalid write mode is selected
			}
			if (!file_exists($path . $file)){     												
				throw new FileNotFoundException();     			//throws exception if file does not exist
			}
			if (!is_writable($path . $file)){     												
				throw new FileNotWritableException();     		//throws exception if file is not writable
			}
			fopen($handle = $path . $file, $mode);     										//opens file in appropriate mode
			fwrite($handle, $content);     													//writes to file (append or write)
			fclose($handle);     															//closes file
		}
		catch(InvalidWriteModeException $iwme){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $iwme);		//displays error message and writes error to log
		}
		catch(FileNotFoundException $fnfe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnfe);		//displays error message and writes error to log
		}
		catch(FileNotWritableException $fnwe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnwe);		//displays error message and writes error to log
		}
		catch (InvalidFileParameterException $ifpe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $ifpe);		//displays error message and writes error to log
		}
	}

	public function deleteFile(){
		try{
			if (!file_exists($path . $file)){     												
				throw new FileNotFoundException();     				//throws exception if files does not exist
			}
			unlink($path . $file);     															//deletes file
		}
		catch(FileNotFoundException $fnfe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnfe);			//displays error message and writes error to log
		}
	}
	
	public function file_modification_time($path, $file){
		try{
			$this->validate_path_file($path, $file, null);
			if(!file_exists($filename)){
				throw new FileNotFoundException ();
			}
			echo "$filename was last modified: " . date ("F d Y H:i:s.", filemtime($filename));
		}
		catch(FileNotFoundException $fnfe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnfe);		//displays error message and writes error to log
		}
		catch (InvalidFileParameterException $ifpe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $ifpe);		//displays error message and writes error to log
		}
	}
	
	private function validate_path_file($path, $file, $content){
		$param = array($path, $file, $content);
		foreach ($param as $value) {
			if(isset($value)){
				if(!is_string($value)){
					throw new InvalidFileParameterException(); //throws exception if path, file, or content isn't a string
				}																							 
			}
		}
	}

}

$fm = new FileManager();
echo $fm->readFile('c:\xampp\htdocs\project\\', 'tester.txt');

class FileExistsException extends Exception{
	public $message = 'File already exists!';
	public $code = 102;
	public function _construct($message, $code){ }
}

class FileNotFoundException extends Exception{ 
	public $message = 'File does not exist';
	public $code = 100;
	public function _construct($message, $code){ }
}

class FileNotReadableException extends Exception{ 
	public $message = 'File is not readable!';
	public $code = 104;
	public function _construct($message, $code){ }
}

class FileNotWritableException extends Exception{ 
	public $message = 'File is not writable!';
	public $code = 103;
	public function _construct($message, $code){ }
}

class InvalidWriteModeException extends Exception{
	public $message = 'Invalid write mode selection!';
	public $code = 114;
	public function _construct($message, $code){ }
}

class InvalidFileParameterException extends Exception{
	public $message = 'Any path, file, or content must be strings!';
	public $code = 105;
	public function _construct($message, $code){ }
}
?>
