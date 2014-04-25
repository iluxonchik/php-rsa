<?php
require_once('genstructure.php');
require_once('rsafunctions.php');
if (isset($_POST['submit_encrypt'])){
	// text for encryption has been submitted
	//TODO: Form checking
	if (validEncryptionData()){
		// if the user provided fields for encryption are valid
		$publicKey = new Key($_POST['N'], $_POST['e']);
		$asciified = textToASCII($_POST['textToEncrypt']);
		$blockSize = ((int)$_POST['blockSize']);
		$output = encryptText($publicKey, $asciified, $blockSize, 0); // encrypt the text
	}
	else 
		inputError();
}


else if (isset($_POST['submit_decrypt'])){
	// text for decryption has been submitted
	//TODO: Form checking
	if (validDecryptionData()){
		$publicKey = new Key($_POST['N'], $_POST['d']);
		$textToDecrypt = $_POST['textToDecrypt'];
		$blockSize = ((int)$_POST['blockSize']);
		$output = encryptText($publicKey, $textToDecrypt, $blockSize, 1); // decrypt the text
	}
	else
		inputError();
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>RSA Encryptor/Decryptor</title>
</head>
 <p> (N, e) --> public key | (N, d) --> private key [N is the modulus]

<form method="POST" action = "<?php $_SERVER['PHP_SELF'] ?>">
	<fieldset>
		<label for="N">N:</label> <input type="text" name="N"> <br/ >
		<label for="e">e:</label> <input type="text" name="e"> <br/ >
		<label for="blockSize">Block Size:</label> <input type="text" name="blockSize"> (how to separate the digits before encryption) <br/ >
		<label for="textToEncrypt">Text To Encrypt:</label> <textarea rows="10" cols="45" name="textToEncrypt"></textarea> 
	</fieldset>
	<input type="submit" name="submit_encrypt">
</form>

<form method="POST" action = "<?php $_SERVER['PHP_SELF'] ?>">
	<fieldset>
		<label for="N">N:</label> <input type="text" name="N"> <br/ >
		<label for="e">d:</label> <input type="text" name="d"> <br/ >
		<label for="blockSize">Block Size:</label> <input type="text" name="blockSize"> (how to separate the digits before decryption) <br/ >
		<label for="textToDecrypt">Text To Decrypt:</label> <textarea rows="10" cols="45" name="textToDecrypt"></textarea> 
	</fieldset>
	<input type="submit" name="submit_decrypt">
</form>


<p> Output: </p>
<textarea rows="10" cols="45" name="output"><?php if(isset($output) && !empty($output)) echo $output; ?></textarea>

<body>
  
</body>
</html>