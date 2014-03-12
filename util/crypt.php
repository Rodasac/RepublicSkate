<?php
/**
 * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
 * $algorithm - El algoritmo hash a ser utilizado. Se recomienda: SHA256
 * $password - La contraseña.
 * $salt - Un salt que será único para el password.
 * $count - Contador de iteraciones. Mientras más grande mejor, pero mas lento. Recomendado: Mayor de 1000.
 * $key_length - La longitud que tendrá el hash en bytes.
 * $raw_output - Si es true, el key se retornará en un formato binario sin tratar. Si no sera un formato hex.
 * Retorno: Un $key_length-byte key derivado de la contraseña y el salt.
 */

if (!function_exists("hash_pbkdf2")) {
    function hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false) {

        class pbkdf2 {
            public $algorithm;
            public $password;
            public $salt;
            public $count;
            public $key_length;
            public $raw_output;

            private $hash_length;
            private $output         = "";

            public function __construct($data = null)
            {
                if ($data != null) {
                    $this->init($data);
                }
            }

            public function init($data)
            {
                $this->algorithm  = $data["algorithm"];
                $this->password   = $data["password"];
                $this->salt       = $data["salt"];
                $this->count      = $data["count"];
                $this->key_length = $data["key_length"];
                $this->raw_output = $data["raw_output"];
            }

            public function hash()
            {
                $this->algorithm = strtolower($this->algorithm);
                if(!in_array($this->algorithm, hash_algos(), true))
                    throw new \Exception('PBKDF2 ERROR: Invalid hash algorithm.');

                if($this->count <= 0 || $this->key_length <= 0)
                    throw new \Exception('PBKDF2 ERROR: Invalid parameters.');

                $this->hash_length = strlen(hash($this->algorithm, "", true));
                $block_count = ceil($this->key_length / $this->hash_length);
                for ($i = 1; $i <= $block_count; $i++) {
                    // $i encoded as 4 bytes, big endian.
                    $last = $this->salt . pack("N", $i);
                    // first iteration
                    $last = $xorsum = hash_hmac($this->algorithm, $last, $this->password, true);
                    // perform the other $this->count - 1 iterations
                    for ($j = 1; $j < $this->count; $j++) {
                        $xorsum ^= ($last = hash_hmac($this->algorithm, $last, $this->password, true));
                    }
                    $this->output .= $xorsum;
                    if($this->raw_output)
                        return substr($this->output, 0, $this->key_length);
                    else
                        return bin2hex(substr($this->output, 0, $this->key_length));
                }
                return False;
            }
        }

        $data = array('algorithm' => $algorithm, 'password' => $password, 'salt' => $salt, 'count' => $count, 'key_length' => $key_length, 'raw_output' => $raw_output);
        try {
            $pbkdf2 = new pbkdf2($data);
            return $pbkdf2->hash();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}