<!--  
/*
*Authors: Eli Goldner
*	  Chaim Tewel
*	  Eli Zentman
*/
-->

<?php	

$attributes = array();

$tag = "a";
$attributes = array("id" => "myid", "href" => "http://www.google.com", "class" => "myfirstclass mysecondclass");
$content = "Test Tag";

echo aTag($tag, $attributes, $content);
echo "Done";

//create an html a tag
function aTag($tag, $attributes, $content){
	try{
		//test for exceptions
		exception_tester($tag, $attributes, $content);
		//if no exception has been thrown then generate a html tag
		$html = '<' . $tag;
		foreach($attributes as $key=>$value){
			if(isset($value)){
				$html .= ' ' . $key . '="' . $value . '"';		
			}
     	}
		$html .= '>' . $content . "</" . $tag . "><br>\n";
	    //return string containing the complete html tag 	
		return $html;
	} catch (Exception $e) {
		logError($e);
		print_r($e);
	}
	
}

function exception_tester($tag, $attributes, $content){
		//test if the content is a string
		if (!html5TagValidate($tag)){
            throw new Exception("Invalid HTML5 tag.", 111);
        }		
		if(!is_array($attributes)){
			throw new Exception("Attribute must be an array.", 112);			
		}
		if(!is_string($content)){
			throw  new Exception("Content must be strings", 113);
		}
}

//parse exception details and returns an array that can be written to a log
function logError($anyError) {
	$traceError = $anyError->getTrace();
	$errorInfo = array("Message: " . $anyError->getMessage(),
			   "File: " . $anyError->getFile(), 
    			   "Thrown on line: " . $anyError->getLine(),
			   "Code: " . $anyError->getCode(), 
 			   "Called by function: " . $traceError[0]['function'],
			   "On line: " . $traceError[0]['line'],
			   "in " . $traceError[0]['file'],
			   "Classification: " . classify($anyError->getCode()));	
	//print_r($errorInfo);
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


/*
*This function will check if the given tag is a valid tag in HTML5.
*/
function html5TagValidate($tag){

    $html5ValidTags = array ("!--", "!DOCTYPE", "a", "abbr", "address", "area", "article", "aside", "audio", "b", "base", "bdo",
    "blockquote", "body", "br", "button", "canvas", "caption", "cite", "code", "col", "colgroup", "command", "datalist", "dd",
    "del", "details", "dfn", "div", "dl", "dt", "em", "embed", "fieldset", "figcaption", "figure", "footer", "form", "h1", "h2",
    "h3", "h4", "h5", "h6", "head", "header", "hgroup", "hr", "html", "i", "iframe", "img", "input", "ins", "keygen", "kbd",
  	"label", "legend", "li", "link", "map", "mark", "menu", "meta", "meter", "nav", "noscript", "object", "ol", "optgroup",
    "option", "output", "p", "param", "pre", "progress", "q", "rp", "rt", "ruby", "s", "samp", "script", "section", "select",
    "small", "source", "span", "strong", "style", "sub", "summary", "sup", "table", "tbody", "td", "textarea", "tfoot", "th",
    "thead", "time", "title", "tr", "ul", "var", "video", "wbr"  );

    if (!in_array($tag, $html5ValidTags)){
         return false;
    }else{
         return true;
    }
}
?>
