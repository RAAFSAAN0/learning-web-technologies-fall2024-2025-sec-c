<?php

$array = array(20,440,55,232,1212,44);
$search_element = 122;
for( $i = 0; $i < sizeof($array); $i++ ){
   if ($search_element == $array[$i]){
    echo $search_element ." is found in the array ";
    break;
   }
   else{
    echo $search_element ." is not found in the array ";
    break;
   }
}


?>