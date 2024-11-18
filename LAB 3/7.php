<?php

for( $i = 1; $i <= 3; $i++ ){
    for ( $j = 1; $j <= $i; $j++ ){
        echo "* ";
    }
    echo "\n";
}

echo "\n";

for( $i = 3; $i >= 1; $i-- ){
    for ( $j = 1; $j <= $i; $j++ ){
        echo $j . " ";
    }
    echo "\n";
}

echo "\n";


$char =  "A";

for( $i = 1; $i <= 3; $i++ ){
    for ( $j = 1; $j <= $i; $j++ ){
        echo $char . " ";
        $char++;
    }
    echo "\n";
}

?>