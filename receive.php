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
 $myfile = fopen("log2.txt","w+") or die("Unable to open file!"); //設定一個log.txt 用來印訊息
 fwrite($myfile, "\xEF\xBB\xBF".$response); //在字串前加入\xEF\xBB\xBF轉成utf8格式
 fclose($myfile);
 //回傳給line server
 $header[] = "Content-Type: application/json";
 $header[] = "Authorization: Bearer v/gXvI8PN5gIad5vfOvJK5JlOHcDSwaJDFwOzErjdNDc6fJf8Q0+NSF6132URQj4TG/uNI7r4OO0JT7isHjuh2RjHSFUvci0ysxShaa+W56ZDR99kAtUzueMKXqECaVD3loOi+bfhtH4NeZtnjvlbwdB04t89/1O/w1cDnyilFU=";
 $ch = curl_init("https://api.line.me/v2/bot/message/push");                                                                      
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
 $result = curl_exec($ch);
 curl_close($ch); 
?>
