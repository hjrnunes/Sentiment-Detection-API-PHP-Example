<?php
/*
An example PHP client for the Chatterbox Sentiment Detection API
delivered through the Mashape platform.  The API is designed specifically
for short social texts.

This client has some hard coded (but real) tweets which are passed to the
API.

You need to add your keys found on the Mashape Dashboard.
*/
    
require_once("SentimentAnalysisFree.php")
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
   <head>
      <title>Sample Sentiment Detection API from Chatterbox</title>
   </head>
   <body>
<?php
	//Add your keys below..
	$publicKey = '';
	$privateKey = '';
	
	//Build the free API object with your keys..
	$chatterboxAPI = new SentimentAnalysisFree($publicKey, $privateKey);
	
	//Our hard coded sample tweets.  Your application will figure out
	//what it needs...
	$sampleTexts = array(
	"@getflockler must have a great designer cause it looks hot!! :-)",
	"I've started exploring Evernote... this may change my life.. I'm not sure yet, but it may.",
	"Well, Saudi Airlines have really messed up our holiday. Pretty pissed off they can get away with it.",
	"How did someone make it to our site using the keywords: \"different types of birth control\"? #odd",
	"Apple Mail, why do you crash so? #grrrr",
	"If you ever wonder 'how bad can a coffee from burger king be, really?' the answer is bad, very bad. #badcoffeebadmorning",
	"Great meeting with TK from the Queen Mary student paper - really interesting questions!",
	);
	
	$highestNumber = 0;
	$highestText = "";
	foreach($sampleTexts as $sampleText){
		echo "<p>Text: " . $sampleText . "</p>";
		
		//Here we do the actual classification.  We pass in a language
		//identifier and the text we wish to be classified.
		$classificationResponse = $chatterboxAPI->classifytext("en",$sampleText);
		
		//Uncomment this line if you want to inspect the result.
		//print_r($classificationResponse);
		
		if ($classificationResponse->statusCode != 200){
			//if there was an error
			echo "<p>Error: " . (int)$classificationResponse->statusCode . "</p>";
		}
		else{
			//Value is the predicted strength of the sentiment in the text
			$sentiment_value = (float)$classificationResponse->body->value;
			
			//Identify the most positive message
			if ($sentiment_value > $highestNumber){
				$highestNumber = $sentiment_value;
				$highestText = $sampleText;
			}
			
			//Now we need the absolute value of the sentiment value.
			$abs_sentiment_value = abs($sentiment_value);
			
			if ($abs_sentiment_value < 0.25){
				//As a consumer of this API you will need to experiment with
				//which cut-off value works best for your application.
				print "<p style='color:orange'>Hmm. Weak or neutral emotion it seems.</p>";
			}
			else{
				//Sent is the label of the sentiment.  1 is positive,
				//-1 is negative
				$sentiment_label = (integer)$classification->sent;
				if ($sentiment_label > 0){
					print "<p style='color:green'>W00t! Seems like a positive message</p>";
				}
				else{
					print "<p style='color:red'>Oh foo. Seems like a negative one</p>";	   
				}
			}
			print "<br />";
		}
	}
	print "<p> The most positive message is: " . $highestText . "</p>";
	
?>
   </body>
</html>
