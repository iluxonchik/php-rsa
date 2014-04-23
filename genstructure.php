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
?>