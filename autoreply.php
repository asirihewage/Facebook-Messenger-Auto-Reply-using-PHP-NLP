
<?php

/*
  NLP and Wikipedia based Auto reply for Facebook Messenger using PHP
  @author : Asiri Hewage - https://github.com/asirihewage
*/

include ('autoloader.php');
require_once "vadersentiment.php";
 
$configs = include('config/config.php');

use \NlpTools\Tokenizers\WhitespaceTokenizer;
use \NlpTools\Similarity\JaccardIndex;
use \NlpTools\Similarity\CosineSimilarity;
use \NlpTools\Similarity\Simhash;

//variables
$messageText = "";
$hubVerifyToken = $configs -> hubVerifyToken;
$adminSenderID = intval($configs -> admin_sender_ID);

// check token at setup
if(isset($_REQUEST['hub_verify_token'])){
  if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
    echo $_REQUEST['hub_challenge'];
    exit;
  }   
}

/* Database credentials. */
define('DB_SERVER', $configs -> host);
define('DB_USERNAME', $configs -> username);
define('DB_PASSWORD', $configs -> password);
define('DB_NAME', $configs -> database);

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

/* ---------------------------------- Create database tables for the first time ------------------------------------------------- */
$checkTables = $link-> query("SELECT senderid FROM users");

if(empty($checkTables)) {
                $result = $link-> query(file_get_contents('./db_tables_dump.sql')); 
}

/* ---------------------------------------------------- Main message flow---------------------------------------------- */

// get input json
$input = json_decode(file_get_contents('php://input'), true);

// Validate message
if(isset($input['entry'][0]['messaging'][0]['message']['text'])){
    $messageText = strval($input['entry'][0]['messaging'][0]['message']['text']);
}else if(isset($input['entry'][0]['messaging'][0]['message']['attachments'][0]['payload']['sticker_id'])){
    $sticker_id = $input['entry'][0]['messaging'][0]['message']['attachments'][0]['payload']['sticker_id'];
    $sticker_id == 369239263222822 ? $answer = "(y)" : 
        $answer = ":/ Oh my bad... I can't understand this sticker.";
    reply($input, $answer);
    die(0);
}

if(isset($input['entry'][0]['messaging'][0]['message']['text']) || isset($input['entry'][0]['messaging'][0]['message']['attachments'][0]['payload']['sticker_id'])){
    error_log(strval(print_r($input, true)), 3, "errors.log");

  // handle bot's anwser
  $senderId = intval($input['entry'][0]['messaging'][0]['sender']['id']);

  $mid = $input['entry'][0]['messaging'][0]['message']['mid'];
  if(isset($input['entry'][0]['messaging'][0]['message']['reply_to']['mid'])){
      $replyto = $input['entry'][0]['messaging'][0]['message']['reply_to']['mid'];
  }else{
      $replyto = null;
  }

  
  try{
    if($senderId !='' && $messageText!=''){
            $sqlinsertuser = "INSERT INTO users (senderid, messagetext, mid) VALUES (".$senderId.",'".$messageText."','".$mid."') 
            ON DUPLICATE KEY UPDATE messagetext='".$messageText."', mid='".$mid."';";
            if ($link->query($sqlinsertuser) === TRUE) {
              error_log("\n Bot learned something.", 3, "errors.log");
            } else {
              error_log(strval("\n Error: " . $sqlinsertuser . "<br>" . $link->error), 3, "errors.log");
            }
    }
            
            
    $answer = "";
    $s1 = "";
    $s2 = "";
    $similarity = 0;
    $similarity_prev = 0;
    $str = "";

    if($messageText == "hi") {
        $answer = "Hi, How can I help you?";
    }else if($senderId == $adminSenderID && $replyto != null){
        $sqlinsertans = "UPDATE autoreply SET answer='".$messageText."' WHERE mid='".$replyto."' ;";
        $resans = $link->query($sqlinsertans);
        
    }else if(count(explode(' ',trim($messageText),2)) > 1  && strtolower(explode(' ',trim($messageText),2)[0]) == 'learn') {
        try{
            if($senderId == $adminSenderID){
               $str = substr(strstr($messageText," "), 1);
                $q = $link -> real_escape_string(explode (",", $str, 2)[0]);
                $a = $link -> real_escape_string(explode (",", $str, 2)[1]);
                $sqlinsert2 = "INSERT INTO autoreply (question, answer) VALUES ('".$q."','".$a."') ON DUPLICATE KEY UPDATE answer='".$a."';";
                $res = $link->query($sqlinsert2);
                $answer = "Thank you! I will remember that.. :)"; 
            }else{
                $answer = "Sorry you are not allowed to teach me :(";
            }
        }catch(Exception $e){
            error_log($e, 3, "errors.log");
        }
    }else if(count(explode(' ',trim($messageText),2)) < 2 && strtolower(explode(' ',trim($messageText),2)[0]) == 'learn'){
        if($senderId == $adminSenderID){
            $unkquestion = '';
            $unkwn = "SELECT question FROM autoreply where answer IS NULL LIMIT 1";
            $fetchunknown = $link->query($unkwn);
            if ($fetchunknown->num_rows > 0) {

              // output data of each row
              while($rowunk = $fetchunknown->fetch_assoc()) {
                  $unkquestion = $rowunk["question"];
              }
              $answer = "What is the answer for: ' ".$unkquestion." ' ?";
              reply($input, $answer);
            }else{
                $answer = "No problems, for now :)";
                reply($input, $answer);
            }
        }else{
            $answer = "No secrets with unknown people :) ";
            reply($input, $answer);
        }
    }else{
         $sql = "SELECT question, answer FROM autoreply where answer IS NOT NULL";
        $result = $link->query($sql);
        
        if ($result->num_rows > 0) {

          // output data of each row
          while($row = $result->fetch_assoc()) {
              $similarity = floatval(similarity(strtolower($messageText), strtolower($row["question"])));
              if($similarity > $similarity_prev){
                  $answer = $row["answer"];
                  $similarity_prev = $similarity;
              }
          }

            $sentimenter = new SentimentIntensityAnalyzer();
            $result = $sentimenter->getSentiment('no thank you');

            $messageText = $link -> real_escape_string($messageText);
            if($similarity_prev <= 0.5 ){
                    $sqlinsert = "INSERT INTO autoreply (question, senderid, mid) VALUES ('".$messageText."',".$senderId.",'".$mid."') ON DUPLICATE KEY UPDATE senderid='".$senderId."', mid='".$mid."';";
                    $res = $link->query($sqlinsert);
            }
            if($similarity_prev < 0.5){
                    $answer = getWikiData($messageText); // fetch data using wikipedia to give an answer for an unknown question.
            
            }else if($similarity_prev <= 0.5){
                $answer = $answer  ;
            }
            
        } else {
           $answer = getWikiData($messageText);
        }
        $link->close();   
    }

    if($answer!=""){
        reply($input, $answer);
    }
    
  }catch(Exception $e){
      $answer = "Please wait. I'm processing your request... :)";
      error_log($e, 3, "errors.log");
      reply($input, $answer);
  }

  }

  // NLP function to get string similarity (Cosine similarity in this case)
  function similarity($s1, $s2){
      $tok = new WhitespaceTokenizer();
      $J = new JaccardIndex();
      $cos = new CosineSimilarity();
      $simhash = new Simhash(16); // 16 bits hash
      
      $setA = $tok->tokenize($s1);
      $setB = $tok->tokenize($s2);

      return $cos->similarity(
              $setA,
              $setB
          );
  }

  // function to fetch data from wikipedia
  function getWikiData($searchQuery){

    $searchQuery = str_replace(' ', '_', $searchQuery);
    
    //The url you wish to send the POST request to
    $url = 'https://en.wikipedia.org/w/api.php?action=query&prop=extracts&exlimit=max&format=json&exsentences=1&origin=*&exintro=&explaintext=&generator=search&gsrlimit=2&gsrsearch='.$searchQuery;

    
    //open connection
    $ch = curl_init();
    
    curl_setopt($ch,CURLOPT_URL, $url);
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    $result = curl_exec($ch);

    curl_close($ch);
    
    $data = json_decode($result,true);
    $res = "";
    if(array_key_exists('continue', $data)) {
        $found = $data['query']['pages'];
        foreach ($found as $field) {
            $res = $res . strval(print_r($field['extract'] , true));
        }
        return $res;
    }else{
        return "Sorry, I don't know anything about '".$searchQuery."'.";
    }

  }

  // function to send data back to the API
  function reply($input, $answer){
      $accessToken = $configs -> accessToken;
      $senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
      $response = [
      'recipient' => [ 'id' => $senderId ],
      'message' => [ 'text' => $answer ]
      ];
      $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
      curl_exec($ch);
      curl_close($ch);
  }


?>
