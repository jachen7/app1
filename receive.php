<?php
  //echo "hello, i am jachen"
  //$json_str=file_get_contents('php://input'); //接收RESUEST的BODY
  //$json_obj=json_decode($json_str); //轉JSON格式
  //$myfile=fopen("log2.txt","w+") or die("unable to open file!"); //log.txt接收訊息
  //fwrite($myfile, "\xEF\xBB\xBf".$json_str);
  //fclose($myfile);
 //echo "hello, i am jachen"
 $json_str = file_get_contents('php://input'); //接收REQUEST的BODY
 $json_obj = json_decode($json_str); //轉JSON格式
 //產生回傳給line server的格式
 $sender_userid = $json_obj->events[0]->source->userId;
 $sender_txt = $json_obj->events[0]->message->text;
 $response = array (
				"to" => $sender_userid,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "Hello, YOU SAY ".$sender_txt
					)
				)
		);
 $myfile = fopen("log3.txt","w+") or die("Unable to open file!"); //設定一個log.txt 用來印訊息
 fwrite($myfile, "\xEF\xBB\xBF".$response); //在字串前加入\xEF\xBB\xBF轉成utf8格式
 fclose($myfile);
 //回傳給line server
 $header[] = "Content-Type: application/json";
 $header[] = "Authorization: Bearer iXpV5f5N74qX/aepxAr4y7zpez0pxdMX9XyO0BTYjFexaIkuJ6SAH8WbNimUYh3dsF8q9NuuYFiVxj9kMc8Wr68bhCEcL+mrNsfWiyrwKFoOJ1gRaZEL2rTZ5PUy5yOxeNS/qeIG4YRqH3ZC2NrwRAdB04t89/1O/w1cDnyilFU=";
 $ch = curl_init("https://api.line.me/v2/bot/message/push");                                                                      
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
 $result = curl_exec($ch);
 curl_close($ch); 
?>
