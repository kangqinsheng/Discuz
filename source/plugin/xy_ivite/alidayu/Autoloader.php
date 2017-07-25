<?php

class Autoloader{
  
  /**
     * 类库自动加载，写死路径，确保不加载其他文件。
     * @param string $class 对象类名
     * @return void
     */
    public static function autoload($class) {
        $name = $class;
        if(false !== strpos($name,'\\')){
          $name = strstr($class, '\\', true);
        }
        
        $filename = TOP_AUTOLOADER_PATH."/top/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = TOP_AUTOLOADER_PATH."/top/request/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = TOP_AUTOLOADER_PATH."/top/domain/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = TOP_AUTOLOADER_PATH."/aliyun/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = TOP_AUTOLOADER_PATH."/aliyun/request/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }

        $filename = TOP_AUTOLOADER_PATH."/aliyun/domain/".$name.".php";
        if(is_file($filename)) {
            include $filename;
            return;
        }         
    }
}

if (version_compare(phpversion(),'5.3.0','>=')) {
    spl_autoload_register('Autoloader::autoload',false,true);
}else{
    Autoloader::autoload("zhanmishu_sms");
    Autoloader::autoload("TopClient");
    Autoloader::autoload("TopLogger");
    Autoloader::autoload("SendSms");
    Autoloader::autoload("AlibabaAliqinFcSmsNumSendRequest");
    Autoloader::autoload("ResultSet");
    Autoloader::autoload("AliyunClient");
    Autoloader::autoload("HttpdnsGetRequest");
    Autoloader::autoload("RequestCheckUtil");
}
?>