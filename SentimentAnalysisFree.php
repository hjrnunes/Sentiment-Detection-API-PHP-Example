<?php
require_once("mashape/MashapeClient.php");


class SentimentAnalysisFree {
	const PUBLIC_DNS = "chatterbox-analytics-sentiment-analysis-free.p.mashape.com";
	private $authHandlers;

	function __construct($publicKey, $privateKey) {
		$this->authHandlers = array();
		$this->authHandlers[] = new MashapeAuthentication($publicKey, $privateKey);
		
	}
	public function classifytext($lang, $text, $exclude = null) {
		$parameters = array(
				"lang" => $lang,
				"text" => $text,
				"exclude" => $exclude);

		$response = HttpClient::doRequest(
				HttpMethod::POST,
				"https://" . self::PUBLIC_DNS . "/sentiment/current/classify_text/",
				$parameters,
				$this->authHandlers,
				ContentType::FORM,
				true);
		return $response;
	}
	
}
?>
