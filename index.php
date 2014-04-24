<?php
require_once('genstructure.php');
require_once('rsafunctions.php');
if (isset($_POST['submit_encrypt'])){
	// text for encryption has been submitted
	//TODO: Form checking
	if (validEncryptionData()){
		// if the user provided fields for encryption are valid
		$publicKey = newKey($_POST['N'], $_POST['e']);
		$asciified = textToASCII($_POST['textToEncrypt']);
}
}
else if (isset($_POST['submit_decrypt'])){
	// text for decryption has been submitted
	//TODO: Form checking
	$N = $_POST['N'];
	$d = $_POST['d'];
	$msgToDecrytp = $_POST['textToDecrypt'];
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
		<label for="textToEncrypt">Text To Encrypt:</label> <textarea rows="10" cols="45" name="textToEncrypt"></textarea> 
	</fieldset>
	<input type="submit" name="submit_encrypt">
</form>

<form method="POST" action = "<?php $_SERVER['PHP_SELF'] ?>">
	<fieldset>
		<label for="N">N:</label> <input type="text" name="N"> <br/ >
		<label for="e">d:</label> <input type="text" name="e"> <br/ >
		<label for="textToDecrypt">Text To Decrypt:</label> <textarea rows="10" cols="45" name="textToDecrypt"></textarea> 
	</fieldset>
	<input type="submit" name="submit_decrypt">
</form>


<p> Output: </p>
<textarea rows="10" cols="45" name="output"><?php if(isset($output) && !empty($output)) echo $output; ?></textarea>

<body>
  
</body>
</html>