/*
*Author: Eli Goldner
*Description: this function will only accept a tag that is valid in HTML versions up to but not including HTML5
*/

<?php

        function htmlTagValidate($tag){

                htmlValidTags = array ("!--", "!DOCTYPE", "a", "abbr", "acronym", "address", "applet", "area", "b", "base", "basefont",
		 "bdo", "big", "blockquote", "body", "br", "button", "caption", "center", "cite", "code", "col", "colgroup", "dd", "del",
		 "dfn", "dir", "div", "dl", "dt", "em", "fieldset", "font", "form", "frame", "frameset", "h1", - "h6", "head", "hr", "html",
		 "i", "iframe", "img", "input", "ins", "kbd", "label", "legend", "li", "link", "map", "menu", "meta", "noframes", "noscript",
		 "object", "ol", "optgroup", "option", "p", "param", "pre", "q", "s", "samp", "script", "select", "small", "span", "strike",
		 "strong", "style", "sub", "sup", "table", "tbody", "td", "textarea", "tfoot", "th", "thead", "title", "tr", "tt", "u", "ul",
		 "var", "wbr", "xmp" );


                if (!in_array($tag, $htmlValidTags)){
                        die("Invalid HTML tag");
                }else{
                        return '<' . $tag . '>';
                }

        }




?>
~

