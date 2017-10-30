<?php 
/* *
 * -------------------------------------------------------------------------------------------- 
 * 名稱：AidecLiteFramework (ALF)
 * 短述：ALF 框架
 * 版本：1.0 
 * 日期：2016-03-28
 * 更新日期 : 2017-10-19
 * 建立者：Aidec
 * 說明：輕量化MVC框架
 * v2.0變形說明：拿掉AF框架的MVC功能，只使用AF的擴充函數庫,核心,db類
 * v3.0說明 : 1.0版本 的優化 添加靜態化處理資料庫 DB::Q()
 * v4.0說明 : 改良結構使系統介於MVC框架與傳統開發結構之間 改良路由並添加新函數以及操作文檔.... 
 * vn1.0說明: 從AF框架再重構結構，程式重構，並導入autoload、composer [內建身分驗證] (建議版本5.6+)(5.3勉強[DB接口需重寫])
 * ---------------------------------------------------------------------------------------------   
 * 純空白頁面 : 7ms~12ms
 * 加載框架後 : 22ms~37ms
 */
//phpinfo();
    header('Content-Type: text/html; charset=utf-8');
/*
 * -------------------------------------------------------------------
 *  初始常數
 * -------------------------------------------------------------------
 */
    define('debug', TRUE);

/*
 * -------------------------------------------------------------------
 *  錯誤訊息
 * -------------------------------------------------------------------
 */
    switch (debug)
    {
        case TRUE:
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        break;

        case FALSE:
            ini_set('display_errors', 0); 
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE); 
        break;

        default:
            header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
            echo '應用環境設定不正確。';
            exit();
    } 
/*
 * -------------------------------------------------------------------
 *  關閉魔術引號
 * -------------------------------------------------------------------
 */ 
    ini_set ('magic_quotes_gpc', 0); 
    if (get_magic_quotes_gpc()) 
    {
        function stripslashes_deep($value)
        {
            $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value); 
            return $value;
        } 

        $_POST = array_map('stripslashes_deep', $_POST);
        $_GET = array_map('stripslashes_deep', $_GET);
        $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
        $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
    } 

/*
 * -------------------------------------------------------------------
 *  Session
 * -------------------------------------------------------------------
 */
    if (!isset($_SESSION)) 
    { 
        session_start(); 
    } 
 
/*
 * -------------------------------------------------------------------
 *  設定預設常數
 * -------------------------------------------------------------------
 */
    #錨點定義原始路徑
    define('MYPATH', dirname(__FILE__) );
    //路徑常數
    define('BASEPATH', '');  
    //定義系統目錄路徑常數   
    define('SYSPATH', str_replace('\\', '/', MYPATH.'/system')); 
    //應用路徑
    define('APPPATH', str_replace('\\', '/', MYPATH.'/app'));

  
 /*
 * -------------------------------------------------------------------
 *  加載系統
 * -------------------------------------------------------------------
 */   
    $checkPreLoadFileArr = array(
        'Define'=>array(
            'name'=>'常數配置',
            'path'=>MYPATH . '/config/define.php',
        ),
        'ALF'=>array(
            'name'=>'運行入口',
            'path'=>SYSPATH . '/Start.php',
        ),
        'LibFunction'=>array(
            'name'=>'公用函式',
            'path'=>SYSPATH . '/Lib/function.php',
        ),
    ); 

    foreach ($checkPreLoadFileArr as $key => $value) {
        if (!file_exists($value['path'])) {
            echo $value['name'].'加載失敗!';
            die(); 
        }
    } 
    #讀取常數配置
    require_once MYPATH . '/config/define.php';
    #讀取公共函數
    require_once SYSPATH . '/Lib/function.php';
    #讀取運行入口
    require_once SYSPATH . '/Start.php';



