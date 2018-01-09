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
$myfile = fopen("log4.txt","w+") or die("Unable to open file!"); //設定一個log.txt 用來印訊息
 fwrite($myfile, "\xEF\xBB\xBF".$json_str); //在字串前加入\xEF\xBB\xBF轉成utf8格式
 fclose($myfile);
 //產生回傳給line server的格式
 $sender_userid = $json_obj->events[0]->source->userId;
 $sender_txt = $json_obj->events[0]->message->text;
 $sender_replyToken = $json_obj->events[0]->replyToken;
 $line_server_url = 'https://api.line.me/v2/bot/message/push';
 //用sender_txt來分辨要發何種訊息
 $objID = $json_obj->events[0]->message->id;
			$url = 'https://api.line.me/v2/bot/message/'.$objID.'/content';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Authorization: Bearer GMMBMktIhFYWgjtBBnH1/XYkTtLrjaZoVJXIc00L9OBWrJ9mbnWc1Tz+e5WkUpKtsF8q9NuuYFiVxj9kMc8Wr68bhCEcL+mrNsfWiyrwKFpRUstrgMyIBBO2QGTFGu3VWUnp8iaJaQLgsPlSHaeSYwdB04t89/1O/w1cDnyilFU=',
			));
				
			$json_content = curl_exec($ch);
			curl_close($ch);
$imagefile = fopen($objID.".jpeg", "w+") or die("Unable to open file!"); //設定一個log.txt，用來印訊息
			fwrite($imagefile, $json_content); 
			fclose($imagefile);
 //回傳給line server
 $header[] = "Content-Type: application/json";
 $header[] = "Authorization: Bearer GMMBMktIhFYWgjtBBnH1/XYkTtLrjaZoVJXIc00L9OBWrJ9mbnWc1Tz+e5WkUpKtsF8q9NuuYFiVxj9kMc8Wr68bhCEcL+mrNsfWiyrwKFpRUstrgMyIBBO2QGTFGu3VWUnp8iaJaQLgsPlSHaeSYwdB04t89/1O/w1cDnyilFU=";
 $ch = curl_init($line_server_url);                                                                      
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
 $result = curl_exec($ch);
 curl_close($ch); 
?>
