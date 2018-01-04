<?php
require_once("./function.php");

// PHPの設定
error_reporting(E_ALL & ~E_NOTICE);
mb_language("Japanese");
mb_internal_encoding("UTF-8");
date_default_timezone_set('Asia/Tokyo');



/**-------------------------------------------------------------------------------------------------
 DBへアクセス
--------------------------------------------------------------------------------------------------*/
// 下部のhtmlデータ作成
selectComent();

exit;

?>