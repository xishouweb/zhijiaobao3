<?php
    //只要请求该文件，即执行git pull命令
    $dir = "/WebSite/zhijiaobao3/";
    $handle = passthru("cd ".$dir." && git pull origin master");
    //if ($handle)

?>