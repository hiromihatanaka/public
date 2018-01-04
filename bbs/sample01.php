<?php

error_reporting(E_ALL & ~E_NOTICE);
mb_language("Japanese");
mb_internal_encoding("UTF-8");
date_default_timezone_set('Asia/Tokyo');

session_start();

/**-------------------------------------------------------------------------------------------------
 関数
 --------------------------------------------------------------------------------------------------*/
function print_pre($a){

    print("<pre>");
    print_r($a);
    print("</pre>");

}

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


/**-------------------------------------------------------------------------------------------------
 SQL
 --------------------------------------------------------------------------------------------------*/

function getSqlCountNoticeBoard($arg_map) {

    // 件数チェック
    $sql = "";
    $sql.= "SELECT ";
    $sql.= "COUNT(no) AS count ";
    $sql.= "FROM ";
    $sql.= " notice_board ";
    $sql.= "WHERE";
    $sql.= " delete_flag = 0;";

    return $sql;
}

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
    $sql.= "WHERE";
    $sql.= " delete_flag = 0;";

    return $sql;
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<style>
 .myStyle {
    font-weight: bold;
    border: 1px solid gray;
 }
</style>
<script type="text/javascript">

function btn_conf() {

  var conf_check = '0';

  //user_name用↓
  var user_name = document.form1.user_name.value;

  if (user_name == '') {
    alert('名前を入力して下さい');
    conf_check = '1';
    var conf1_check = '1';
  }

  //全体の送信確認
  if (conf_check == '0'){
    var res = confirm('入力内容を確認します。よろしいですか？');
    if (res == true){
      document.form1.action = 'sample01.php';
      document.form1.submit();
    }
  }
}

function btn_conf2() {

	var e = document.getElementById('msg');
	e.textContent = 'はろー！';
	e.style.color = 'red';
	e.className = 'myStyle';
	var greet = document.createElement('p');
    text = document.createTextNode('hello world');

    document.form2.appendChild(greet).appendChild(text);
}

// 即時関数
(function(name){
	console.log("hello" + name);
})("Tom");

// タイマー処理
var i = 1;
function show() {
	console.log(i++);
	var tid = setTimeout(function() {
	show();
}, 1000);
	if(i > 3) {
		clearTimeout(tid);
	}
}
show();



//window.location.href = 'http://doyinstall.com'
// window.document //window省略可


</script>

</head>
<body>
<p id="msg">
あいうえお
</p>
<form action="" name="form1" method="post">
<span>*</span>全て必須入力です
<table>
<tr>
<td>名前<span>*</span></td>
<td><input type="text" size="50" name="user_name" value=""></td>
</tr>
<tr>
<td>性別<span>*</span></td>
<td>
<input type="radio" name="seibetsu" value="1">男&nbsp;<input type="radio" name="seibetsu" value="2">女
</td>
</tr>
<tr>
<td>年齢<span>*</span></td>
<td>
<select name="age">
<option value="" selected></option>
<option value="1">10代</option>
<option value="2">20代</option>
<option value="3">30代</option>
<option value="4">その他</option>
</select>
<td>
</tr>
<tr>
<td>趣味<span>*</span></td>
<td>
<input type="checkbox" name="hobby1" value="1">読書&nbsp;
<input type="checkbox" name="hobby2" value="2">スポーツ&nbsp;
<input type="checkbox" name="hobby3" value="3">料理&nbsp;
<input type="checkbox" name="hobby4" value="4">その他
</td>
</tr>
<tr>
<td>コメント<span>*</span></td>
<td><textarea rows="3" cols="30" name="comment"></textarea></td>
</tr>
</table>
<input type="button" name="submit_button" onClick="javascript:btn_conf();" value="送信" >  <!--typeをsubmitにするとページが更新されてしまい、フォーカスされないので注意。-->
<br /><br />
<input type="button" name="submit_button" onClick="javascript:alert('hoge');" value="hoge送信" >  <!--typeをsubmitにするとページが更新されてしまい、フォーカスされないので注意。-->
</form>

<form action="#" name="form2" method="post">
<input type="button" name="domsousa" onClick="javascript:btn_conf2();" value="DOM操作用" >
</form>
</body>
</html>
