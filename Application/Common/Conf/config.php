<?php
return array(
	//'配置项'=>'配置值'
	//'DEFAULT_V_LAYER' =>  'dist',
	
	//URL重写保存在.htaccess中，需修改相应http.conf
    'URL_MODEL'=> 2,

    
	//数据库配置项
	'DB_TYPE'=>'mysql',
    'DB_HOST'=>'localhost',
    'DB_NAME'=>'zhijiaobao3',
    'DB_USER'=>'root',
    'DB_PWD'=>'dsdadc666',
    'DB_PORT'=>3306,
    'DB_PREFIX'=>'t_',


    //以下为支教宝自定义配置

    // 短信接口配置
    'ALI_APPKEY'       => '23696538',
    'ALI_SECRETKEY'    => 'e02249a67711ef2ecf5befde5a4e5955',
    'ALI_SMSTYPE'      => 'normal',
    'ALI_SIGNNAME'     => '支教宝',
    'ALI_TEMPLATECODE' => 'SMS_55610001'

);