<?php
function isPrime($num){
	/* checks if the provided number is a prime number */
	// TODO: This function obviously has a problem when large numbers are provided.
	for($i = ((int)sqrt($num)); $i > 1; $i--)
		if ($num%$i == 0)
			return 0;
	return 1;
}

?>
