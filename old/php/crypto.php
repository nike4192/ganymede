<?php

	define( 'PATH_DELIMITER', '/' );

	class Crypto {

		protected $cipher;
		protected $password;

		function __construct( $cipher, $password ) {

			$this->cipher = $cipher;
			$this->password = $password;

		}

		function encrypt( $data ) {

			$iv_size = openssl_cipher_iv_length( $this->cipher );
			$iv = openssl_random_pseudo_bytes( $iv_size );

			return $iv . openssl_encrypt( $data, $this->cipher, $this->password, 0, $iv );

		}

		function decrypt( $hash ) {

			$iv_size = openssl_cipher_iv_length( $this->cipher );
			$iv = substr( $hash, 0, $iv_size );

			return openssl_decrypt( substr( $hash, $iv_size ), $this->cipher, $this->password, 0, $iv );

		}

		function base64_encrypt( $data ) {

			return base64_encode( $this->encrypt( $data ) );

		}

		function base64_decrypt( $data ) {

			return $this->decrypt( base64_decode( $data ) );

		}

		function url_encrypt( $data ) {

			return urlencode( $this->encrypt( $data ) );

		}

		function url_decrypt( $data ) {

			return urldecode( $this->decrypt( $data ) );

		}

		function path_encrypt( $data ) {

			return $this->url_encrypt( implode( PATH_DELIMITER, func_get_args() ) );

		}

		function path_decrypt( $hash ) {

			return explode( PATH_DELIMITER, $this->url_decrypt( $hash ) );

		}

	}

	$crypto = new Crypto('AES-256-CFB', 'Ratata');

?>