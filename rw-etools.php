<?php

/*
 * Plugin Name:       html5 Etools
 * Plugin URI:        https://github.com/rpi-virtuell/rw-etools
 * Description:       display accordions from headlines und subcontent
 * Version:           0.0.1
 * Author:            Joachim Happel
 * Author URI:        https://joachim-happel
 * License:           GNU General Public License v2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * GitHub Plugin URI: https://github.com/rpi-virtuell/rw-etools
 * GitHub Branch:     master
 * Requires WP:       4.0
 * Requires PHP:      5.3
 */
 
 
add_shortcode('accord', 'accord_generator');
function accord_generator($atts, $content=''){
  	
  	$acc_id = random_int(1,999999);
  
  	$etool = shortcode_atts( array(
		'type' => 'accordion',
	  	'active' => 'false',
		'title_tag' => 'h3'
	), $atts, 'etool' );
    
    switch($etool['type']){
	  case 'accordion':
	  
			

			$description = str_replace('</'.$etool['title_tag'].'>','</summary>',do_shortcode($content));
			$description = str_replace('<'.$etool['title_tag'].'>','<details><summary>',$description);
		
		    $details = explode('<details>', $description );
		     
		    $description = ""; $i = 0;
			foreach ($details as $detail){
			  $i ++;
			  if ($i > 1) {
				$description .= '<details open="">'.$detail.'</details>';
			  }else{
				$description .= $detail;
			  }
			  
			}


			$html = '<div class="etool accordion">'.$description.'</div>';
			$html .="<script>setTimeout(details_closeAll,2000);</script>";
			$html .="<script>setTimeout(details_closeAll,2000);</script>";
			
			
			return $html;
		
		
		
			break;
	  case 'tabs':
		
			return $content;
	  default:
			return $content;
	}
  
}

function hook_add_accordion_css() {
    ?>
       <script>
			function details_thisindex(elm){
			  var nodes = elm.parentNode.childNodes, node;
			  var i = 0, count = i;
			  while( (node=nodes.item(i++)) && node!=elm )
				if( node.nodeType==1 ) count++;
			  return count;
			}

			function details_closeAll(index){
			  
			  index = index || -1;
			  
			  var len = document.getElementsByTagName("details").length;

			  for(var i=0; i<len; i++){
				if(i != index){
				  document.getElementsByTagName("details")[i].removeAttribute("open");
				  document.getElementsByTagName("details")[i].style.opacity="1";
				}
			  }
			}
	   </script>
	   <style>
             .etool.accordion{
		 		
	          }
		     .accordion details {
				  min-height: 30px;
				  padding: 4px 7px 4px 7px;
				  margin: 0 auto;
				  position: relative;
				  font-size: 22px;
				  border: 1px solid rgba(0,0,0,.1);
				  box-sizing: border-box;
			      opacity: .2;
  			  }
			  .accordion details:hover { background: rgba(100,100,100,0.15); }
			  .accordion details + .accordion details {
				margin-top: 20px;
			  }
			  .accordion details[open] {
				background-color: #fff;
				min-height: 200px;
			  }
			  .accordion summary {
				font-weight: 800;
				cursor: pointer;
				padding: 7px 8px;
			  }
			  .accordion details[open] summary{
				background-color: rgba(0,0,0,.9);
				color: #fff;
			  }
			  details[open] summary ~ * {
				color: #96999d;
				font-weight: 300;
			  }
			  .accordion details p {
				color: #96999d;
				font-weight: 300;
				margin: 15px 5px 5px;
			  }
			
					
        </style>
    <?php
}
add_action('wp_head', 'hook_add_accordion_css');
