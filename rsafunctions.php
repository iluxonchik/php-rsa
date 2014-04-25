<?php
function binaryGCD($a, $b){
	/* computes and returns the greatest common divisor between a and b */
	
	/*
	 *	Binary GCD Algorithm, according to Wikipedia "binary GCD can be about 60% 
	 *	more efficient (in terms of the number of bit operations) on average than the Euclidean algorithm".

	 *	More about the Binary GCD Algorithm: http://en.wikipedia.org/wiki/Binary_GCD_algorithm
	 *	Java Implementation: http://introcs.cs.princeton.edu/java/23recursion/BinaryGCD.java.html
	 *  C++ Implementation: https://gist.github.com/cslarsen/1635213
	 */
	$shiftleft = 0;

	while( ($a && $b) && ($a != $b) ){
		$a_is_even = !($a & 1); // check if a is even
		$b_is_even = !($b & 1); // check if b is even

		// if both a and b are even
		if ($a_is_even && $b_is_even){
			$shiftleft++;
			$a >>= 1; // shift a right by 1 bit (i.e. divide by 2)
			$b >>= 1; // shift b right by 1 bit (i.e. divide by 2)
		}
		// if a is even and b is odd
		else if ($a_is_even && !$b_is_even)
			$a >>= 1;

		// if b is even and a is odd
		else if (!$a_is_even && $b_is_even)
			$b >>= 1;

		// if both a and b are odd and a >= b
		else if ($a >= $b)
			$a = ($a-$b) >> 1;

		// if both a and b are odd and a < b
		else{
			$temp = $a;
			$a = ($b - $a) >> 1;
			$b = $temp;
		}
	}

	// if $a is 0, then shift $b left by $shiftleft bits, otherwise, shit $a by $shiftleft bits
	return !$a ? $b << $shiftleft : $a << $shiftleft;

	/*
	 *	NOTE: Doing (inetger & 1) check if it's even.
	 *		  Example: 1 --> 0001
	 *		  		   6 --> 0110
	 *		  		   0001 & 0110 ---> 0000 (which is 0)
	 *
	 *		  		   1 --> 0001
	 *		  		   7 --> 0111
	 *		  		   0001 & 0111 ---> 0001 (which is 1)
	*/
}

function numDigits($num){
	/* returns the number of digitis conatined in a non-null integer */
	$numDigits = 0; // counts the number of digits 

	while ($num > 0){
		$numDigits++;
		$num = (int)($num / 10);
	}

	return $numDigits;
}

function encryptBlock($publicKey, $msg, $blockSize){
	/*  encrypts a single block
	 *	returns an encrypted version of $msg
	 *  $other is the value of e
	 *  $msg must be a string
	 */
	$encr = bcmod(bcpow($msg, $publicKey->other),$publicKey->N);
	$encrNumDig = numDigits(((int)$encr)); // number of digits in the encrypted message
	
	if($encrNumDig < $blockSize){
		// if the number of digits in the encrypted message is less that the block size
		$zeroes = '';
		// add some zeroes at the beginning
		for($i = 0; $i < $blockSize - $encrNumDig; $i++)
			$zeroes = $zeroes . '0';
		$encr = $zeroes . $encr;
	}

	return $encr;
}

function decryptBlock($privateKey, $msg){
	/*  decrypts a single block
	 *	returns a decrypted version of $msg
	 *  $other is the valye of d
	 *  $msg must be an integer
	 */
	return bcmod(bcpow($msg, $privateKey->other), $privateKey->N);
}

function encryptText($publicKey, $text, $blockSize, $opt){
	/* encrtypts text in the provided block sizes */
	/* $opt = 0 --> encrypt  $opt = 1 --> decrtypt*/

	$encrypted = ''; // stores the encrypted/decrypted integer string (the encrypted text)
	$auxRemainder = strlen($text) % $blockSize; // used to check if the text has the appropriate ammount of characters to block size

	if ($auxRemainder != 0)
		// if number of digits in text is not a multiple of $blockSize, concatenate some spaces at the end
		for ($i = 0; $i < $auxRemainder; $i++)
			$text = $text . '32';
	
	for($counter = 0; $counter < strlen($text) - $blockSize; $counter += $blockSize){
		$block = ''; // block of text to encrypt/decrypt

		for ($i = $counter; $i < $blockSize + $counter; $i++)
			// built the block of text to encrypt
			$block = $block . $text[$i];

		// encrypt an single block of text and add it to the encrypted string
		$encrypted = $encrypted . ($opt?decryptBlock($publicKey, $block, $blockSize):encryptBlock($publicKey, $block, $blockSize));			
	}

	return $encrypted;
}


?>


<?php
/************************************************** 
 The code below is not directly used in the script.
**************************************************/

function binaryGCDRecursive($a, $b){
	/* computes and returns the greatest common divisor between a and b */
	
	/*
	 *	Binary GCD Algorithm, according to Wikipedia "binary GCD can be about 60% 
	 *	more efficient (in terms of the number of bit operations) on average than the Euclidean algorithm".

	 *	More about the Binary GCD Algorithm: http://en.wikipedia.org/wiki/Binary_GCD_algorithm
	 *	Java Implementation: http://introcs.cs.princeton.edu/java/23recursion/BinaryGCD.java.html
	 *  C++ Implementation: https://gist.github.com/cslarsen/1635213

	 */

	/* NOTE:
		This is a recursive version of the binary GCD algorithm, however, the iteratibe version will be used instad,
		since this creates a very deeps recursion for large numbers, which may cause it not work without altering php's 
		default settings.
	*/
	if ($a==0)
		return $p;
	if ($b == 0)
		return $a;

	// if both a and b are even
	if(($a & 1) == 0 && ($b & 1) == 0)
		return gcd($a >> 1, $b >> 1) << 1;

	// if a is even and b is odd
	else if (($a & 1) == 0)
		return gcd($a >> 1, $b);

	// if a is odd and b is even
	else if (($b & 1) == 0 )
		return gcd($a, $b >> 1);

	// if both a and b are odd and a >= b
	else if($a >= $b)
		return gcd(($a - $b) >> 1, $b);

	// if both a and b are odd and a < b
	else
		return gcd($a, (1-$a) >> 1);


	/*
	 *	NOTE: Doing (inetger & 1) check if it's even.
	 *		  Example: 1 --> 0001
	 *		  		   6 --> 0110
	 *		  		   0001 & 0110 ---> 0000 (which is 0)
	 *
	 *		  		   1 --> 0001
	 *		  		   7 --> 0111
	 *		  		   0001 & 0111 ---> 0001 (which is 1)
	*/
}

function isPrime($num){
	/* checks if the provided number is a prime number */
	// Source: http://icdif.com/computing/2011/09/15/check-number-prime-number/

	// by defenition, 1 is not prime
	if($num == 1)
		return false;

	// 2 is the only even number that is prime
	if($num == 2)
		return true;

	/* 
	 * if a number is divisible by 2, it's not prime, so there is no need 
	 * to check other even numbers
	 */
	if ($num % 2 == 0)
		return false;

	/*
	 * this will check if the number is divisible by an odd number,
	 * (that's why i is incremented by 2 each cycle, so that the sequence
	 * 3,5,7,9,11... is achieved)
	 */
	for ($i = 3; $i < ceil(sqrt($num)); $i += 2)
		if ($num % $i == 0)
			return false;
	
	return true;
}

?>