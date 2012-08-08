<?php
/*
Plugin Name: 多说评论插件
Version: 0.1
Plugin URL: http://dev.duoshuo.com/
Description: 多说社会化评论框
ForEmlog: 4.2.1
Author: 多说
Author URL: http://duoshuo.com/
*/

!defined('EMLOG_ROOT') && exit('access deined!');

include_once EMLOG_ROOT . '/content/plugins/duoshuo/duoshuo_config.php';

$duoshuo_ondomready = '';

function duoshuo_print_scripts(){
	global $duoshuo_ondomready;?>
<!-- Duoshuo bottom script -->
<script type="text/javascript">
	var duoshuoQuery = {
		short_name: "<?php echo DUOSHUO_SHORTNAME;?>",
		ondomready: function(){
			var $ = DUOSHUO.jQuery;
			$('#newcomment').addClass('ds-recent-comments').data('excerpt-length', 32);
			<?php echo $duoshuo_ondomready;?>
		}
	};
	(function() {
		var ds = document.createElement('script');
		ds.type = 'text/javascript';ds.async = true;
		ds.src = 'http://static.duoshuo.com/embed.js';
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ds);
	})();
</script>
<?php 
}
addAction('index_footer','duoshuo_print_scripts');

function duoshuo_comments($logData){
	return '<div class="ds-thread" data-thread-key="' . $logData['logid'] . '" data-url="' . Url::log($logData['logid']) . '" data-title="' . $logData['log_title'] . '" data-author-key="' . $logData['author'] . '"></div>';
};

function duoshuo_replace_comments($logData){
	global $duoshuo_ondomready;
	if (!DUOSHUO_SHOW_ORIGINAL_COMMENTS){
		$duoshuo_ondomready .= <<<eot
$('.comment-header').remove();
$('.comment').remove();
eot;
	}
	$duoshuo_ondomready.= '$(\'#comment-place\').replaceWith(\'' . duoshuo_comments($logData) . '\')';
}
addAction('log_related', 'duoshuo_replace_comments');

function duoshuo_nav() {//写入插件导航
	echo '<div class="sidebarsubmenu" id="themeseditor"><a href="./plugin.php?plugin=duoshuo">多说设置</a></div>';
}
addAction('adm_sidebar_ext', 'duoshuo_nav');
