
<?php

$array = array(array(1, 2, 3, "A"),
                     array(1, 2, "B", "C"),
                     array(1, "D", "E", "F"));

for($i= 0; $i<count($array); $i++){
    $col = count($array[$i]);
    for($j = 0; $j < $col - $i - 1; $j++){
        echo "".$array[$i][$j]. " ";
    }
   
   
   
   
   
   
    echo "\n";
}

echo "\n";





for($i= 0; $i<count($array); $i++){
    $col = count($array[$i]);
    for($j = $col - $i - 1; $j < $col; $j++){
        echo "".$array[$i][$j]. " ";
    }
    echo "\n";
}

?>
