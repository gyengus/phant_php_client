<?php
	class Phant {
		protected $url = ""; // Phant server url
		protected $pubkey = ""; // Stream public key
		protected $privkey = ""; // Stream private key
		protected $delkey = ""; // Key for delete stream

		function __construct($url, $pubkey, $privkey, $delkey = "") {
			$this->url = $url;
			$this->pubkey = $pubkey;
			$this->privkey = $privkey;
			$this->delkey = $delkey;
		} // __constructor

		public function post($data) {
			$url = $this->url . "input/" . $this->pubkey . ".json";
			$data_str = "";
			foreach ($data as $key => $val) {
				$data_str .= $key . "=" . urlencode($val) . "&";
			} // foreach
			$data_str = substr($data_str, 0, -1);
			// curl
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, count($data));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
			curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Phant-Private-Key: " . $this->privkey));
			if ($response = curl_exec($ch)) {
				$response = json_decode($response);
			} else {
				$response->success = -1;
			}
			curl_close($ch);
			return $response;
		} // post

		public function get($format = "json", $page = false, $pubkey = "") {
			$url = $this->url . "output/" . ($pubkey ? $pubkey : $this->pubkey) . "." . $format . ($page ? "?page=" . $page : "");
			if ($format == "csv") return file_get_contents($url);
			return json_decode(file_get_contents($url));
		} // get

		// Delete stream contents
		public function clear() {
			$url = $this->url . "input/" . $this->pubkey . "/clear?private_key=" . $this->privkey;
			return json_decode(file_get_contents($url));
		} // clear

		// Stream stat
		public function stats($format = "json", $pubkey = "") {
			$url = $this->url . "output/" . ($pubkey ? $pubkey : $this->pubkey) . "/stats." . $format;
			if ($format == "csv") return file_get_contents($url);
			return json_decode(file_get_contents($url));
		} // stats

	} // Phant class
