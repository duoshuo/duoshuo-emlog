<?php
$params = array(
		//'template'		=>	'wordpress',
		//'remote_auth'	=>	$this->remoteAuth($this->userData()),
);
$adminUrl = 'http://' . $duoshuoPlugin->shortName . '.duoshuo.com/admin/?'.http_build_query($params);
?>

<div class="containertitle"><b>多说评论管理</b>
<a class="add-new-h2" target="_blank" href="<?php echo $adminUrl;?>">更多功能设置</a>
</div>
<iframe id="duoshuo-remote-window" src="<?php echo $adminUrl;?>" style="width:100%; border:0;"></iframe>

<script>
jQuery(function(){
var $ = jQuery,
	iframe = $('#duoshuo-remote-window'),
	resetIframeHeight = function(){
		iframe.height($(window).height() - iframe.offset().top - 70);
	};
resetIframeHeight();
$(window).resize(resetIframeHeight);
});
$('#duoshuo_manage').addClass('sidebarsubmenu1');
</script>
