<!-- 
/*
*Yitzchoks class 
*/
-->

<?php

interface IFileManager{
	function write_csv_log($path, $file, $log_array);
	function createFile($path, $file);
	function readFile($path, $file);
	function updateFile($path, $file, $content, $mode);
	function deleteFile();
	function file_modification_time($filename);
}

class FileManager implements IFileManager{
	
	//write array containing error details to csv file
	function write_csv_log($path, $file, $log_array){
		$csv = fopen($path . $file, 'a');
		fputcsv($csv, $log_array);
		fwrite($csv, "\r\n");
	}
	
	public function createFile($path, $file){
		try{
			if (file_exists($path . $file)){    						//checks existance of file
				throw new FileExistsException('File already exists!', 102);     	//throws exception if file already exists
			}
			fopen($handle = $path . $file, 'w+');    			 		//creates new file
            fclose($handle);     										//closes newly created file
        }
		catch(FileExistsException $fee){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fee);			//writes error message to screen and writes error to log
		}
	}

	public function readFile($path, $file){
		try{
			if (!file_exists($path . $file)){    						//confirms existance of file
				throw new FileNotFoundException('File does not exist!', 101); //throws exception if file does not exist
			}
			if (!is_readable($path . $file)){     						//confirms that file is readable
				throw new FileNotReadableException('File is not readable!', 104);     //throws exception if file is not readable
			}
			fopen($handle = $path . $file, 'r');     					//opens file
			$content = fread($handle, filesize($path . $file));     	//reads contents of file
			return $content;     										//returns contents of file
			fclose($handle);     										//closes file
		}
		catch(FileNotFoundException $fnfe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnfe);			//writes error message to screen and writes error to log
		}
		catch(FileNotReadableException $fnre){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnre);
		}
	}

	public function updateFile($path, $file, $content, $mode){    	 							//Valid Modes: (a) Append (w) Write
		try{
			if ((!$mode == 'a') && (!$mode == 'w')){     										//confirms validity of write mode selection
				throw new InvalidWriteModeException('Invalid write mode selection!', 114);     //throws exception if invalid write mode is selected
			}
			if (!file_exists($path . $file)){     												//confirms that file exists
				throw new FileNotFoundException('File does not exist!', 100);     				//throws exception if file does not exist
			}
			if (!is_writable($path . $file)){     												//confirms that file is writable
				throw new FileNotWritableException('File is not writable!', 103);     			//throws exception if file is not writable
			}
			fopen($handle = $path . $file, $mode);     											//opens file in appropriate mode
			fwrite($handle, $content);     														//writes to file (append or write)
			fclose($handle);     																//closes file
		}
		catch(InvalidWriteModeException $iwme){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $iwme);
		}
		catch(FileNotFoundException $fnfe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnfe);
		}
		catch(FileNotWritableException $fnwe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnwe);			//writes error message to screen and writes error to log
		}
	}

	public function deleteFile(){
		try{
			if (!file_exists($path . $file)){     												//confirms that file exists
				throw new FileNotFoundException('File does not exist!', 100);     				//throws exception if files does not exist
			}
			unlink($path . $file);     															//deletes file
		}
		catch(FileNotFoundException $fnfe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnfe);			//writes error message to screen and writes error to log
		}
	}
	
	function file_modification_time($filename){
		try{
			if(!file_exists($filename)){
				throw new FileNotFoundException ('File does not exist!', 100);
			}
			echo "$filename was last modified: " . date ("F d Y H:i:s.", filemtime($filename));
		}
		catch(FileNotFoundException $fnfe){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'file_error_log.csv', $fnfe);				//writes error message to screen and writes error to log
		}
	}

}


class FileExistsException extends Exception{ }

class FileNotFoundException extends Exception{ }

class FileNotReadableException extends Exception{ }

class FileNotWritableException extends Exception{ }

class InvalidWriteModeException extends Exception{ }
?>
