<?php
require_once("./function.php");

// PHPの設定
error_reporting(E_ALL & ~E_NOTICE);
mb_language("Japanese");
mb_internal_encoding("UTF-8");
date_default_timezone_set('Asia/Tokyo');



/**-------------------------------------------------------------------------------------------------
 初期処理
 --------------------------------------------------------------------------------------------------*/
$db_no = $_POST['del_num'];
$arg_map["db_no"] = $db_no;

$sql = getSqlDeleteNoticeBoard($arg_map);

// 削除実行
db_access($sql);

//下部ｈｔｍｌ作成用関数
selectComent();

exit;

?>