<html>
<script src="./jquery-1.10.2.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    // �����Ɏ��ۂ̏������L�q���܂��B
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
				$('#msg').html('�V���b�v�f�[�^�擾�����B�A�C�e�����X�g�쐬��');
				//�A�C�e��URL��S�Ď擾���܂�
				var arr = $(data).find('a');
				var itemUrls = [];
				jQuery.each(arr,
					function(idx,tag){
						if(tag.href.indexOf("item.taobao.com/item.htm") != -1){
						itemUrls.push(tag.href);
						}
					}
				);
				//�A�C�e�����X�g�쐬�I��
				$('#msg').html('�A�C�e�����X�g�쐬�I���B�A�C�e���f�[�^���擾���܂�');

				//�A�C�e��URLs�����ɁA�A�C�e���f�[�^���擾
				jQuery.each(itemUrls,
					function(idx,itemUrl){
						//�A�C�e��URL�ŁAHTML���擾
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
								console.log('�A�C�e��URL�ɃA�N�Z�X�Ɏ��s���܂����BURL�͐������ł����H�l�b�g�͂��������q�����Ă��܂����H�A�N�Z�X�����ۂ���Ă��܂��񂩁H');
							}
						});
					}
				);
			},
			error:function() {
				alert('�A�N�Z�X�Ɏ��s���܂����BURL�͐������ł����H�l�b�g�͂��������q�����Ă��܂����H�A�N�Z�X�����ۂ���Ă��܂��񂩁H');
			}
		});
        }
    );
  });
</script>
<body>
<h1>���i���擾�c�[��(���c��)</h1>
URL(��Fhttp://zhangjunkai.taobao.com/)<br/>
<input type="text" id="shopIDs" size="40" value="http://zhangjunkai.taobao.com/">
<input type="button" value="�擾" id="htmlget" />
<div id="msg"></div>
<ul id="sample01"></ul>

</body>
</html>