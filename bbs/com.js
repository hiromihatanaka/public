
$(function() {

	// 下部コメント表示用関数
	function readComment(result) {

		// 下部表示クリア
		$('.reset').children().children().remove();

    	$.each(result, function(index, value) {
    		$(  '<form action="" name="form2[]" method="post" onclick="">' +
    			'<ul class="post_data">' +
    			'<li class="post_title" name="post_title[]"> 【'+ value['db_no'] +'】</li>' +
    			'<li class="post_title2" name="post_title2[]">'+ value['title'] +'</li>' +
    			'<li class="post_contributor">投稿者：' + value['user_name'] + '</li>' +
    			'<li class="post_datetime">'+ value['created'] +'</li>' +
    			'</ul>' +
    			'<br /><br /><br />' +
    			'<p id="honbun">'+ value['content'] +'</p>' +
    			'<input class="del_btn" name="del_btn" type="button" value="削 除">' +
    			'<input class="db_no[]" name="db_no[]" type="hidden" value="' + value['db_no'] +'">' +
    			'<br />' +
				'</form>').insertBefore($('div[name="here"]'));
    	});
	}

	// 初期表示
	$.ajax('read.php',
		{
			type: 'get',
			dataType: 'html',
			timeout: 10000
		}
	)
	// 成功時にはページに結果を反映
	.done(function(data) {

		if (data === "no data") {
			return false;
		} else {
			var result = new Array();
			result = JSON.parse(data);
			// 下部コメント表示
			readComment(result);
		}
	})
	// 失敗時には、その旨をダイアログ表示
	.fail(function() {
		window.alert('正常に終了しませんでした。');
	});

	// 投稿ボタンクリック
	$('input[name="send_btn"]').on('click', function(e) {
		/* OKの時の処理 */
		var user_name = '';
		var title     = '';
		var content   = '';
		user_name = $('input[name="user_name"]').val();
		title     = $('input[name="title"]').val();
		content   = $('textarea[name="content"]').val();
		// .phpファイルへのアクセス
		$.ajax('completion.php',
			{
				type: 'post',
				data: { 'user_name':user_name,
			    	    'title':title,
			    	    'content':content
			    	  },
			    dataType: 'html'
			}
		)
		// 成功時にはページに結果を反映
		.done(function(data) {

			  if (data === "no data") {
				return false;
			  } else {
				var result = new Array();
				result = JSON.parse(data);
			  }

			  var err_flag = 0;
			  if ($('font').length) {
				  // エラーメッセージをリセット
				  $('font').remove();
			  }
			  if (result['user_name_err']) {
				  $('input[name="user_name"]').after("<font color=\"#ff0000\">&nbsp;"+result['user_name_err']+"</font>");
				  err_flag = 1;
			  }
			  if (result['title_err']) {
				  $('input[name="title"]').after("<font color=\"#ff0000\">&nbsp;"+result["title_err"]+"</font>");
				  err_flag = 1;
			  }
			  if (result['content_err']) {
				  $('textarea[name="content"]').after("<font color=\"#ff0000\">&nbsp;"+result["content_err"]+"</font>");
				  err_flag = 1;
			  }
			  if (err_flag === 0) {

				  /* 登録成功の時の処理 */
				  // 入力値クリア
				  $('input[name="user_name"]').val('');
				  $('input[name="title"]').val('');
				  $('textarea[name="content"]').val('');
				  // 下部コメント表示
				  readComment(result);
			 }
		})
		// 失敗時には、その旨をダイアログ表示
		.fail(function() {
			window.alert('正常に終了しませんでした。');
		});
  });

  // 削除ボタンクリック
  $('body').on('click', '.del_btn', function(e) {

	if(!confirm('本当に削除しますか？')){
	  /* キャンセルの時の処理 */
	  return false;
	}else{
      /* OKの時の処理 */
	  var del_num = new Array();
	  del_num = $(this).parent().children('input[name="db_no[]"]').val();
	  if ($('font').length) {
		  // エラーメッセージをリセット
		  $('font').remove();
	  }
	  // .phpファイルへのアクセス
	  $.ajax('del.php',
	    {
	      type: 'post',
	      data: { 'del_num':del_num },
	      dataType: 'html'
	    }
	  )
	  // 成功時にはページに結果を反映
	  .done(function(data) {
			if (data === "no data") {
				// 最後の１つのデータを消す
				$('.reset').children().children().remove();
				return false;
			} else {
				var result = new Array();
				result = JSON.parse(data);
				// 下部コメント表示
				readComment(result);
			}
	  })
	  // 失敗時には、その旨をダイアログ表示
	  .fail(function() {
	    window.alert('正しい結果を得られませんでした。');
	  });
	}
  });

  // 入力部のフォーカスが当たっている場合の色変更
  $('.01')
	.focus(function() {
		$(this).css('background', '#FFFFF0');
	})
	.blur(function() {
		$(this).css('background', '#FFFFFF');
	});

});

