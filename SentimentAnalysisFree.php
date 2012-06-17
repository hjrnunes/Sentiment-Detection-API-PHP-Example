<?php
require_once("mashape/MashapeClient.php");

class SentimentAnalysisFree
{
	private $publicKey;
	private $privateKey;
	function __construct($publicKey, $privateKey)
	{
		$this->publicKey = $publicKey;
		$this->privateKey = $privateKey;
	}

	public function classifytext($lang, $text, $exclude = null)
	{
		$parameters = array("lang" => $lang,
		                    "text" => $text,
		                    "exclude" => $exclude);
		$response = HttpClient::doRequest(HttpMethod::POST, "https://chatterbox-analytics-sentiment-analysis-free.p.mashape.com/sentiment/current/classify_text/", $parameters, $this->publicKey, $this->privateKey, true);
		return $response;
	}
}
?>