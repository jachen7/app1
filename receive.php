<?php
  //echo "hello, i am jachen"
  $json_str=file_get_contents('php://input'); //接收RESUEST的BODY
  $json_obj=json_decode($json_str); //轉JSON格式
  $myfile=fopen("log.txt","w+") or die("unable to open file!"); //log.txt接收訊息
  fwrite($myfile, "\xEF\xBB\xBf".$json_str);
  fclose($myfile);
?>
