<?php
    //只要请求该文件，即执行git pull命令
    $dir = "/WebSite/zhijiaobao3/";
   $i =  system("cd ".$dir." && git pull &>error.log",$res);
   var_dump($i);
?>
