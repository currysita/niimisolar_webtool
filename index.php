<html>
<script src="./jquery-1.10.2.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    // ここに実際の処理を記述します。
    $("#htmlget").click(
        function(){
        var sendUrl = $("#shopIDs").val();
        var postdata = {sendUrl:sendUrl};
        $('#msg').html('');
		$.ajax({
			type: 'POST',
			url: 'taobaogetaction.php',
			data: postdata,
			dataType: 'html',
			success: function(data) {
				// $('*[name=module_bcmath]').append(data);
				//$('#sample01').append($(data).find('*[name=module_bcmath]').html());
				//J_TokenField
				//$('#sample01').append($(data).find('#site-nav-bd').html());
				$('#msg').html('ショップデータ取得成功。アイテムリスト作成中');
				//アイテムURLを全て取得します
				var arr = $(data).find('a');
				var itemUrls = [];
				jQuery.each(arr,
					function(idx,tag){
						if(tag.href.indexOf("item.taobao.com/item.htm") != -1){
						itemUrls.push(tag.href);
						}
					}
				);
				//アイテムリスト作成終了
				$('#msg').html('アイテムリスト作成終了。アイテムデータを取得します');

				//アイテムURLsを元に、アイテムデータを取得
				jQuery.each(itemUrls,
					function(idx,itemUrl){
						//アイテムURLで、HTMLを取得
						console.log(itemUrl);
						var itemUrlData = {sendUrl:itemUrl};
						$.ajax({
							type: 'POST',
							url: 'taobaogetaction.php',
							async: false,
							data: itemUrlData,
							dataType: 'html',
							success: function(itemHtml) {
								var id_J_PromoPrice = $(itemHtml).find('#J_StrPrice .tb-rmb-num').text();
								var price = id_J_PromoPrice.html;
							},
							error:function() {
								console.log('アイテムURLにアクセスに失敗しました。URLは正しいですか？ネットはそもそも繋がっていますか？アクセスが拒否されていませんか？');
							}
						});
					}
				);
			},
			error:function() {
				alert('アクセスに失敗しました。URLは正しいですか？ネットはそもそも繋がっていますか？アクセスが拒否されていませんか？');
			}
		});
        }
    );
  });
</script>
<body>
<h1>商品情報取得ツール(安田版)</h1>
URL(例：http://zhangjunkai.taobao.com/)<br/>
<input type="text" id="shopIDs" size="40" value="http://zhangjunkai.taobao.com/">
<input type="button" value="取得" id="htmlget" />
<div id="msg"></div>
<ul id="sample01"></ul>

</body>
</html>