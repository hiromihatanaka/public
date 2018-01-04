<?php
/**-------------------------------------------------------------------------------------------------
 関数
 --------------------------------------------------------------------------------------------------*/
/**
 * デバッグ表示用関数
 *
 * @param string $a
 */
function print_pre($a){

    print("<pre>");
    print_r($a);
    print("</pre>");

}

/**
 * SQL文実行関数
 *
 * @param string $sql　SQL文
 * @return　selectの場合、1行ごとのDBデータ。それ以外のSQL文は成功なら1、失敗なら0
 */
function db_access($sql){

    $url    = "localhost";
    $user   = "root";
    $pass   = "hoge";
    $db     = "test";

    // DB接続証明書発行
    $link = mysqli_connect($url, $user, $pass ,$db) or die ("MySQLの接続に失敗しました。");

    // データベースの選択
    mysqli_select_db($link ,$db) or die ("データベースの選択に失敗しました。");

    // 文字型の設定
    mysqli_set_charset($link, "utf8");

    // 登録実行
    $result = mysqli_query($link ,$sql) or die ("クエリの送信に失敗しました。<br/>SQL:".$sql);

    // SQLを閉じる
    mysqli_close($link) or die ("MySQLの切断に失敗しました。");

    return $result;

}

/**
 * 入力エラーチェック
 *
 * @param string $input_map　ユーザーの入力データ
 * @return array|"" エラーありの場合、arrayを返す、エラーなしの場合、""を返す
 */
function input_check($input_map) {

    $error_map = NULL;

    // 名前入力チェック
    if (!strlen($input_map["user_name"])) {
        $error_map["user_name_err"] = "名前を入力してください";
    }

    // 件名入力チェック
    if (!strlen($input_map["title"])) {
        $error_map["title_err"] = "件名を入力してください";
    }

    // 本文入力チェック
    if (!strlen($input_map["content"])) {
        $error_map["content_err"] = "本文を入力してください";
    }

    if (is_array($error_map)) {
        return $error_map;
    } else {
        return "";
    }

}

/**
 * 下部ｈｔｍｌ作成用関数
 *
 */
function selectComent() {
    // select文作成
    $sql2 = getSqlSelectNoticeBoard();

    // 表示実行
    $result = db_access($sql2);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $rows[] = $row;
    }

    // 件数を調べる
    $count = count($rows);

    // 件数が0ならば
    if ($count === 0) {
        echo "no data";
        exit;
    } else {
        // 連想配列($rows)をJSONに変換(エンコード)する
        $json = json_encode($rows);
        echo $json;
        exit;
    }
}

/**-------------------------------------------------------------------------------------------------
 SQL
 --------------------------------------------------------------------------------------------------*/
function getSqlSelectNoticeBoard() {

    // リスト表示
    $sql = "";
    $sql.= "SELECT ";
    $sql.= "  no AS db_no, ";
    $sql.= "  user_name, ";
    $sql.= "  title, ";
    $sql.= "  content, ";
    $sql.= "  created, ";
    $sql.= "  delete_flag ";
    $sql.= "FROM ";
    $sql.= " notice_board ";
    $sql.= "WHERE ";
    $sql.= " delete_flag = 0;";

    return $sql;
}

function getSqlInsertNoticeBoard($arg_map) {

    // 登録
    $sql = "";
    $sql.= "INSERT INTO notice_board (";
    $sql.= "  user_name, ";
    $sql.= "  title, ";
    $sql.= "  content, ";
    $sql.= "  created, ";
    $sql.= "  delete_flag ";
    $sql.= ") ";
    $sql.= "VALUES (";
    $sql.= "  '".$arg_map["user_name"]."', ";
    $sql.= "  '".$arg_map["title"]."', ";
    $sql.= "  '".$arg_map["content"]."', ";
    $sql.= "  '".$arg_map["created"]."', ";
    $sql.= "0 ";
    $sql.= ")";

    return $sql;
}

function getSqlDeleteNoticeBoard($arg_map) {

    // 削除
    $sql = "";
    $sql.= "UPDATE notice_board SET";
    $sql.= " delete_flag  = 1 ";
    $sql.= "WHERE";
    $sql.= " no    = ".intval($arg_map["db_no"])." ";

    return $sql;
}

?>