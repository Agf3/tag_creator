/*
*Author: Eli Goldner
*Description: this function will only accept a tag that is valid in HTML5
*/

<?php

	function html5TagValidate($tag){
		
		html5ValidTags = array ("!--", "!DOCTYPE", "a", "abbr", "address", "area", "article", "aside", "audio", "b", "base", "bdo",
		 "blockquote", "body", "br", "button", "canvas", "caption", "cite", "code", "col", "colgroup", "command", "datalist", "dd",
		 "del", "details", "dfn", "div", "dl", "dt", "em", "embed", "fieldset", "figcaption", "figure", "footer", "form", "h1", "h2",
		 "h3", "h4", "h5", "h6", "head", "header", "hgroup", "hr", "html", "i", "iframe", "img", "input", "ins", "keygen", "kbd",
		 "label", "legend", "li", "link", "map", "mark", "menu", "meta", "meter", "nav", "noscript", "object", "ol", "optgroup",
		 "option", "output", "p", "param", "pre", "progress", "q", "rp", "rt", "ruby", "s", "samp", "script", "section", "select",
		 "small", "source", "span", "strong", "style", "sub", "summary", "sup", "table", "tbody", "td", "textarea", "tfoot", "th",
		 "thead", "time", "title", "tr", "ul", "var", "video", "wbr"  );
		
		// the following tags cannot have closing tags. IMG,INPUT,BR,HR,FRAME,AREA,BASE,BASEFONT,COL,ISINDEX,LINK,META,PARAM


		//updated list: "area", "base", "basefont", "br", "col", "command", "embed", "frame", "hr", "img", "input", "isindex", "keygen""link", "meta", "param",  "source",  "track", "wbr"
		
		if (!in_array($tag, $html5ValidTags)){
                        return false;
		}else{
			//this will change the way the method allows/disallows closing tags/attributes based on special 
                        //attributes of certain tags
			switch($tagDifferences){
				case "!--"
					$closing_tag = "--";
					break;

				case "area"
						//you gotta be kidding	
					break;
				case "hr";
					createHrTag($tag);//or just go to reg. tag creator, but void other stuff (no attributes etc.					
					break;
				case 
				default;
					//proceed with standard tag creation				
			}		
			return true; 
		}

	}




?>
