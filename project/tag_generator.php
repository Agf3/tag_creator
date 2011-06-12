<!--  
/*
*Authors: Eli Goldner
*	  Chaim Tewel
*	  Eli Zentman
*/
-->

<?php	

function __autoload($class_name) {
	include $class_name . '.php';
}

interface ITagGenerator{
	function __construct($tag, $attributes, $content);
}

class TagGenerator {
	
	public function __construct($tag, $attributes, $content){
		echo $this->aTag($tag, $attributes, $content);
	}
		
	//create an html a tag
	private function aTag($tag, $attributes, $content){
		try{
			//test for exceptions
			$this->exception_tester($tag, $attributes, $content);
			//if no exception has been thrown then generate an html tag
			$html = '<' . $tag;
			foreach($attributes as $key=>$value){
				if(isset($value)){
					$html .= ' ' . $key . '="' . $value . '"';		
				}
	     		}
	     		//opening tag gets closed. content/close tag is only added if tag isn't a void tag.
			$html .= '>';
				
			if($this->isCloseTagNeeded($tag)){
				$html .= $content . "</" . $tag . "><br>\n";
			}
			//return string containing the complete html tag 	
		    	return $html;
		}
		catch (InvalidTagException $ite){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'tag_error_log.csv', $ite);
		}
		catch (NonArrayException $nae) {
			new ErrorHandler('c:\xampp\htdocs\project\\', 'tag_error_log.csv', $nae);
		}
		catch(NonStringException $nse){
			new ErrorHandler('c:\xampp\htdocs\project\\', 'tag_error_log.csv', $nse);
		}
	}
	
	private function exception_tester($tag, $attributes, $content){
		//test validity of the html tag
		if(!$this->html5TagValidate($tag)){
	            throw new InvalidTagException();
	        }	
	        //test if attributes are in an array	
		if(!is_array($attributes)){
			throw new NonArrayException();			
		}
		//test if the content is a string
		if(!is_string($content)){
			throw  new NonStringException();
		}
	}
			
	/*
	*This function will check if the given tag is a valid tag in HTML5.
	*/
	private function html5TagValidate($tag){
	
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

	private function isCloseTagNeeded($tag){
		//array of all HTML5 void tags (tags that cannot have a close tag( some can have attributes))
		$tagsWithoutCloseTag = array ("area","base","br","col","command","embed","hr","img","input","keygen","link","meta","param",
			"source","track","wbr" );

		if (in_array($tag, $tagsWithoutCloseTag)){
			return false;
		}else{
			return true;
		}
	}
}

class InvalidTagException extends Exception{ 
	public $message = 'Invalid HTML5 tag';
	public $code = 111;
	public function _construct($message, $code){ }
}

class NonArrayException extends Exception{ 
	public $message = 'Attributes must be in an array';
	public $code = 112;
	public function _construct($message, $code){ }
}

class NonStringException extends Exception{
	public $message = 'Content must be a string';
	public $code = 113;
	public function _construct($message, $code){ }
}

$tag = "img";
$attributes = array("id" => "myid", "href" => "http://www.ruxtongroup.com", "class" => "myfirstclass mysecondclass");
$content = "Test tag";
new TagGenerator($tag, $attributes, $content);
echo "Done";

?>
