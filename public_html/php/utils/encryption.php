<?php
  $method = "AES-256-CBC";
  $secretHash = "yvdvpHdlBG";
  $initializationVector = "b6yqGiT67cx2v4b5";

  function encrypt($text) {
    global $method;
    global $secretHash;
    global $initializationVector;

    return openssl_encrypt($text, $method, $secretHash, 0, $initializationVector);
  }

  function decrypt($hash) {
    global $method;
    global $secretHash;
    global $initializationVector;

    return openssl_decrypt($hash, $method, $secretHash, 0, $initializationVector);
  }
?>
