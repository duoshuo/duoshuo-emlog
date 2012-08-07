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

emLoadJQuery();

include_once EMLOG_ROOT . '/content/plugins/duoshuo/duoshuo_config.php';

function duoshuo_print_scripts(){?>

<!-- Duoshuo bottom script -->
<script type="text/javascript">
	jQuery(function(){
		jQuery('#newcomment').addClass('ds-recent-comments').data('excerpt-length', 32);
	});
	var duoshuoQuery = {short_name: "<?php echo DUOSHUO_SHORTNAME;?>"};
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

function duoshuo_replace_comments($logData){?>
<script>
	jQuery(function(){
	<?php if (!DUOSHUO_SHOW_ORIGINAL_COMMENTS):?>
		jQuery('.comment-header').remove();
		jQuery('.comment').remove();
	<?php endif;?>
		jQuery('#comment-place').replaceWith('<?php echo duoshuo_comments($logData)?>');
	});
</script>
	<?php 
}
addAction('log_related', 'duoshuo_replace_comments');

function duoshuo_nav() {//写入插件导航
	echo '<div class="sidebarsubmenu" id="themeseditor"><a href="./plugin.php?plugin=duoshuo">多说设置</a></div>';
}
addAction('adm_sidebar_ext', 'duoshuo_nav');
