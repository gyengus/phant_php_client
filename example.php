<?php
	/* Phant server settings */
	define("PHANT_URL", "http://localhost:8080/"); // Phant server url
	define("PHANT_PUBKEY", "xxxxxxxxxxxxxxxxx"); // Stream public key
	define("PHANT_PRIVKEY", "xxxxxxxxxxxxxxxxx"); // Stream private key
	define("PHANT_DELKEY", "xxxxxxxxxxxxxxxxx"); // Key for delete stream

    $phant = new Phant(PHANT_URL, PHANT_PUBKEY, PHANT_PRIVKEY, PHANT_DELKEY);
	// Posting data to stream
    $resp = $phant->post(array("field" => "value", "another_field" => "another_value");
    if ($resp->success != 1) print "Error";

	// Getting data from stream
    $data = $phant->get("json", 1);
