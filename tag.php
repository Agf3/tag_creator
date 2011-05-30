<?php	

$attributes = array();

$tag = "a";
$attributes = array("id" => "myid", "href" => "http://www.google.com", "class" => "myfirstclass mysecondclass");
$content = 5;


echo aTag($tag, $attributes, $content);
echo "Done";

//create an html a tag
function aTag($tag, $attributes, $content){
	try{
		//test for exceptions
		exception_tester($tag, $attributes, $content);
		//if no exception has been thrown then generate a html tag
		$html = '<' . $tag;
		foreach($attributes as $attribute=>$value){
			if(isset($value)){
				$html .= ' ' . $attribute . '="' . $value . '"';		
			}
     		}
		$html .= '>' . $content . "</" . $tag . "><br>\n";
	    //return string containing the complete html tag 	
		return $html;
	} catch (Exception $e) {
		logError($e);
	}
	
}

function exception_tester($tag, $attributes, $content){
		//test if the content is a string
		if(!is_string($content)){
			throw  new Exception("Content must be strings", 111);
		}
}

//parse exception details and returns an array that can be written to a log
function logError($anyError) {
	$traceError = $anyError->getTrace();
	$errorInfo = array("Message: " . $anyError->getMessage(), "File: " . $anyError->getFile(), 
						"Thrown on line: " . $anyError->getLine(), "Code: " . $anyError->getCode(), 
						"Called by function: " . $traceError[0]['function'], "On line: " . $traceError[0]['line'],
						"in " . $traceError[0]['file'], "Classification: " . classify($anyError->getCode()));	
	
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
?>


