ttributes = array();
	
	$tag="form ";
	$content="just say something";
	
	$attributes = array("action" => "some_action", "method" => "some_method", "name" => "somename",
                    "id" => "some_id", "event" => "some_event", "style" => "some_style", "class" => "some_class");
					
	echo tag($tag, $attributes, $content);

function tag($tag, $attributes, $content){
		
	try{
		if(is_array($attributes)){
			throw new Exception("is not array!");
		}
		
		$output='<' . $tag;

		foreach($attributes as $key=>$value){
			$output .= '' . $key . '="' . $value . '" ';
		}
		$output .= '>' . $content . '</' . $tag . '>';

		return $output;
		
	} catch(Exception $ex){
		echo 'Error code:' . $ex->getmessage();
	}
	
}

?> 
