<?php
// 此文件用于定义公共调用的函数，如mail()，upload()，发送短信等函数

/**
 * 图片上传
 * @param string $path 图片存储路径,对于主要根据用途不同进行存放，用户头像user/，项目project/,地点location/
 * @return string
 */
function uploadImage($path) {
    $upload = new  \Think\Upload();
    $upload->maxSize  = 2048000;
    $upload->exts     = array('jpg','gif','jpeg','png');
    $upload->saveName = 'com_create_guid';
    $upload->rootPath = './Uploads/';
    $upload->autoSub  = false;
    $upload->savePath = $path; //根据图片来源不同选择不同路径
    $info = $upload->upload();
    if (!$info) {
        return $upload->getError();
    }
    else {
        zipImage($upload->rootPath,$info);
        return $info;
    }
}

/**
 * 图片压缩处理，对于新上传的图片进行压缩
 * @param array 
 * @param string
 * @return void
 */
function zipImage($path,$info) {
    $image = new \Think\Image();
    foreach ($info as $key => $value) {
        $image->open($path.$value['savepath'].$value['savename']);
        $image->thumb(450,450)->save($path.$value['savepath'].$value['savename']);
    }
}

/**
 * 发送邮件
 * @param mixed $to 收件人
 * @param string $subject 邮件标题
 * @param string $message 邮件内容
 * @return bool
 */
function sendMail($to,$subject,$message){
    import('Vendor.PHPMailer.phpmailer');
    import('Vendor.PHPMailer.smtp');
    $mail = new \PHPMailer();
    //$mail->SMTPDebug = 2;                        //设置SMTP为调试模式
    $mail->CharSet ="UTF-8";                     //发中文此项必须设置为 UTF-8，默认ISO-8859-1
    $mail->IsSMTP();                             // 设定使用SMTP服务
    $mail->SMTPAuth = true;                      // 启用 SMTP 验证功能
    //$mail->SMTPSecure = "ssl";                 // SMTP 安全协议
    $mail->Host = "smtp.126.com";                // SMTP 服务器
    $mail->Port = 25;                            // SMTP服务器的端口号
    $mail->Username = "dsdadc666@126.com";       // SMTP服务器用户名
    $mail->Password = "dsdadc666";               // SMTP服务器密码
    $mail->SetFrom('dsdadc666@126.com', '大善大爱大成');  // 设置发件人地址和名称
    $mail->IsHTML(true);                         //设置邮件内容格式为HTML
    $mail->Subject = $subject;                     // 设置邮件标题
    $mail->MsgHTML($message);                    // 设置邮件内容
    if (is_array($to)){
        foreach($to as $address){                      //设置邮件接收邮箱
            $mail->AddAddress($address['email'],$address['name']);
        }
    }else {
        $mail->AddAddress($to['email'],$to['name']);
    }
    if(!$mail->Send()) {
        echo "发送失败：" . $mail->ErrorInfo;
        return false;
    } else {
        return true;
    }
}

/**
 * 下载个人信息到excel表格中
 * @param 未完待续
 */
function downloadXls($where){
    import('Vendor.PHPExcel.PHPExcel');
    $phpexcel = new \PHPExcel();  
    $objWriter = \PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
    $objSheet = $phpexcel->getActiveSheet();
    $objSheet->setCellValue('A1','志愿者ID')
        ->setCellValue('B1','姓名')
        ->setCellValue('C1','性别')
        ->setCellValue('D1','手机')
        ->setCellValue('E1','邮箱')
        ->setCellValue('F1','状态');
    //设置默认列宽
    $objSheet->getColumnDimension('A')->setWidth('20')->setAutoSize(true);
    $objSheet->getColumnDimension('D')->setWidth('20')->setAutoSize(true);
    $objSheet->getColumnDimension('E')->setWidth('20')->setAutoSize(true);
    //设置表头字体为宋体，加粗，20号，行高为30
    $objSheet->getStyle('A1')->getFont()->setName(iconv('gbk', 'utf-8', '宋体'));
    $status = array("已报名","未通过","已通过","负责人");
    $sex = array("男","女");
    foreach($where as $k=>$v){
        $num = $k+2;
        $objSheet
            ->setCellValueExplicit('A'.$num,$v['volunteer_id'],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('B'.$num,$v['volunteer']['name'])
            ->setCellValue('C'.$num,$sex[$v['volunteer']['sex']])
            ->setCellValue('D'.$num,$v['volunteer']['phone'])
            ->setCellValue('E'.$num,$v['volunteer']['email'])
            ->setCellValue('F'.$num,$status[$v['status']-1]);
    }
    $outfile = "volunteerApply.xls";
    $objSheet->setTitle('志愿者报名表');//设置当前sheet的名称
    $phpexcel->setActiveSheetIndex(0);

    ob_end_clean();     //清除缓冲区,避免乱码
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header('Content-Disposition:inline;filename='.$outfile);
    header("Content-Transfer-Encoding: binary");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Pragma: no-cache");
    $objWriter->save('php://output');
    exit;
}


/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
 * 验证短信发送
 * @param string $code
 * @param string $phone
 * @return boolean code
 */
function sendMsg($code,$phone){
    require 'taobao-sdk/TopSdk.php';
    date_default_timezone_set('Asia/Shanghai');
    $c = new TopClient;
    $c->appkey = C('ALI_APPKEY');
    $c->secretKey = C('ALI_SECRETKEY');
    $req = new AlibabaAliqinFcSmsNumSendRequest;
    $req->setSmsType(C('ALI_SMSTYPE'));
    $req->setSmsFreeSignName(C('ALI_SIGNNAME'));
    $req->setSmsParam("{\"code\":\"".$code."\"}");
    $req->setRecNum($phone);
    $req->setSmsTemplateCode(C('ALI_TEMPLATECODE'));
    $resp = $c->execute($req);
	//var_dump($resp->result);
    if($resp->result->success)
    {
        return ok;
    }
    else
    {
        return $resp->code;
    }
}

    /**
     * 查询字符校验，并过滤
     */
    function tranSql($get) {
        $pattern = '#select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile|or|and|-|<|>|&|%|limit|where|oR|aNd#';
        $result  = preg_replace($pattern, '',$get);//要匹配的字符
        return $result;
    }
?>