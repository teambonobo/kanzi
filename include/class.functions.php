<?php
class functions {
 
 //function to truncate text and show read more link  
 function truncate($mytext,$chars) {  
   $mytext = substr($mytext,0,$chars);  
   return $mytext;  
} 
}
?>
