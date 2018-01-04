<?php
require_once("./function.php");

// PHPの設定
error_reporting(E_ALL & ~E_NOTICE);
mb_language("Japanese");
mb_internal_encoding("UTF-8");
date_default_timezone_set('Asia/Tokyo');



/**-----------------------------------------------------------------------------------------------
 データ取得
 ------------------------------------------------------------------------------------------------*/
// 入力情報を受け取る
$input_map = NULL;
$input_map["user_name"]       = $_POST["user_name"];
$input_map["title"]           = $_POST["title"];
$input_map["content"]         = $_POST["content"];
$input_map["created"]         = date("Y/m/d H:i:s");

// チェック関数へ
$error_map = input_check($input_map);

if (is_array($error_map)) {

    // エラー表示
    $error_map = json_encode($error_map);

    echo $error_map;

    exit;

} else {

    /**-----------------------------------------------------------------------------------------------
     登録処理
     ------------------------------------------------------------------------------------------------*/
    // 編集用変数へ代入
    $arg_map = $input_map;

    /**-------------------------------------------------------------------------------------------------
     DBへアクセス
     --------------------------------------------------------------------------------------------------*/
    // SQL文の作成(登録)
    $sql = getSqlInsertNoticeBoard($arg_map);

    // SQL実行
    db_access($sql);

    //下部ｈｔｍｌ作成用関数
    selectComent();

    exit;
}
?>