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
else if (isset($_POST['submit_helper'])){
	// ther helper form has been submitted
	if(validGCDHelper()){
		$a = $_POST['a'];
		$b = $_POST['b'];
		$gcdOut = binaryGCD($a, $b);
	}
	if(valideValHelper()){
		
		$pMin1 = (((int)$_POST['p']) - 1); // p-1 value
		$qMin1 = (((int)$_POST['q']) - 1); // q-1 value
		$prod = bcmul((string)$pMin1, (string)$qMin1); // (p-1) * (q-1)

		if(binaryGCD($_POST['eVal'], $prod) == 1)
			$eValidation = 'VALID e ';
		else
			$eValidation = 'INVALID e ';
	}
	if (validdValHelper()){
		$pMin1 = (((int)$_POST['pd']) - 1); // p-1 value
		$qMin1 = (((int)$_POST['qd']) - 1); // q-1 value
		$mod = bcmul((string)$pMin1, (string)$qMin1); // (p-1) * (q-1)
		$prod = bcmul($_POST['dVal'], $_POST['ed']);
		$divRemainder = bcmod($prod, $mod); // division remainder

		if($divRemainder == '1')
			$dValidation = 'VALID d ';
		else
			$dValidation = 'INVALID d ';
	}
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>RSA Encryptor/Decryptor</title>
</head>
<body>
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

<form method="POST" action = "<?php $_SERVER['PHP_SELF'] ?>">
	Helper
	<fieldset>
		Compute gcd(a,b)
		<label for="a">a:</label> <input type="text" name="a">
		<label for="b"> b:</label> <input type="text" name="b"> 
		<?php if(isset($gcdOut)) echo ' gcd(' . $a . ', ' . $b . ') = ' . $gcdOut?><br/ >
		<br />
		Valid e checker (N = p*q) | e must be such that: e=1(mod[(p-1)*(q-1)]):
		<label for="p">p:</label> <input type="text" name="p">
		<label for="q"> q:</label> <input type="text" name="q">
		<label for="eVal"> e:</label> <input type="text" name="eVal">
		<?php if(isset($eValidation)) echo ' ' . $eValidation . '<br />' ?>
		<br />
		Valud d checker (N = p*q) | e must be such that: d*e=1(mod[(p-1)*(q-1)]):
		<label for="pd">p:</label> <input type="text" name="pd">
		<label for="qd"> q:</label> <input type="text" name="qd">
		<label for="ed"> e:</label> <input type="text" name="ed">
		<label for="dVal"> d:</label> <input type="text" name="dVal">
		<?php if(isset($dValidation)) echo ' ' . $dValidation . '<br />' ?>

	</fieldset>
	<input type="submit" name="submit_helper">
</form>
  
</body>
</html>