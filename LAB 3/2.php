<?php

$amount  = readline('Enter the amount: ');

echo "The amount is : ";
echo "$amount";

$vat = .15 * $amount;
echo "\n";

echo "The amount after adding the vat: $vat";


?>