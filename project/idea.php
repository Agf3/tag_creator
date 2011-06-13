<?php 

	switch($tag){
		case "!--";
			$html= '<!-- $content -->';
			break;		
		default;
			$html= '<' . $tag;
			
			//will only allow the insertion of attributes if the tag allows it.
			if ($this->tagHasAttributes($tag)){
				foreach($attributes as $key=>$value){
					if(isset($value)){
						$html .= ' ' . $key . '="' . $value . '"';		
					}
		     	}
			}
			
			//opening tag gets closed. content/close tag is only added if tag isn't a void tag.
			$html .= '>';
				
			if($this->isCloseTagNeeded($tag)){
				$html .= $content . "</" . $tag . "><br>\n";
			}
			//return string containing the complete html tag 	
			break;
			
			return $html;		    	
	}
?>
			
			
	     	