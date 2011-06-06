<!--  
/*
*Authors: Eli Goldner
*	  Chaim Tewel
*	  Eli Zentman
*/
-->

<?php	

include 'error_handler.php';

class TagGenerator implements ITagGenerator{
		
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
			$html .= '>' . $content . "</" . $tag . "><br>\n";
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
			if (!$this->html5TagValidate($tag)){
	            throw new InvalidTagException("Invalid HTML5 tag.", 111);
	        }	
	        //test if attributes are in an array	
			if(!is_array($attributes)){
				throw new NonArrayException("Attributes must be an array.", 112);			
			}
			//test if the content is a string
			if(!is_string($content)){
				throw  new NonStringException("Content must be strings", 113);
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
}

class InvalidTagException extends Exception{ }

class NonArrayException extends Exception{ }

class NonStringException extends Exception{ }

$tag = "a";
$attributes = array("id" => "myid", "href" => "http://www.google.com", "class" => "myfirstclass mysecondclass");
$content = "Test tag";

$tg = new TagGenerator();

echo $tg->aTag($tag, $attributes, $content);
echo "Done";

?>
