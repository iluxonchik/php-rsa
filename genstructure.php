<?php
class key{
	/* used when values of N and e or N and d are provided 
	 * $other is either the value of d(private key) or e(public key)
	 */
	function __construct($N, $other){
		$this->N = $N;
		$this->other = $other;
	}
}

class newEncryption{
	/* contains values used in a new encryption
	 * This class is used when a two prime numbers q and p are provided,
	 * and values such as the modulus have to be computed.
	 */
	function __construct($p, $q){
		$this->p = $p;
		$this->q = $q;
		$this->N = $p*$q; // N is the modulus
		$this->M = ($p-1) * ($q-1); // used check/genarate d and e
	}
}

function textToASCII($text){
	/* recieves a chunk of text and returns a string resulting from converting all of the caharacters to ASCII */
	/* the reason for this function to return a string and not an integer is so that later on the text can be easily separated in
	   blocks of desired size for encryption process. Below a version of this function which returns an integer can be found. */
	$asciified = ''; // stores the "asciified" text
	for ($i = 0; $i<strlen($text); $i++)
		$asciified = $asciified.((string)ord($text[$i]));
	return $asciified;
}

function validEncryptionData(){
	/* checks if the fields provided by the user for encryption are not empty */
	// This is used to prevent from having an extensive set of if conditions in index.php
	return isset($_POST['textToEncrypt']) && !empty($_POST['textToEncrypt']) && isset($_POST['N']) && !empty($_POST['N']) && isset($_POST['e']) && !empty($_POST['e']);
}
?>

<?php
/***************************************************************************************
Below resides code that is not directly used in the project, it is however relevan to it
***************************************************************************************/
function INTtextToASCII($text){
	/* recieves a chunk of text and returns the number resulting from converting all of the caharacters to ASCII */
	$asciified = 0; // stores the "asciified" text
	for ($i = 0; $i<strlen($text); $i++){
		if (ord($text[$i]) < 10) 
			// if the character's ASCII code is less than 10, multiplay by 10, so that that integer can be "concatenated"
			$asciified *= 10;
		else if (ord($text[$i]) < 100)
			// if the character's ASCII code is less than 100, multiplay by 100, so that that integer can be "concatenated"
			$asciified *= 100;
		else // if ord($text[i]) > 100
			$asciified *= 1000;
			
		$asciified += ord($text[$i]);
	}

	return $asciified;
}
?>