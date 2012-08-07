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

function duoshuo_comments(){?>

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
addAction('index_footer','duoshuo_comments');

function duoshuo_add_thread($logData){?>
<script>
	jQuery(function(){
		//如果想要隐藏原来的评论列表，可以打开下面两行的注释
		//jQuery('.comment-header').hide();
		//jQuery('.comment').hide();
		jQuery('#comment-place').replaceWith('<div class="ds-thread" data-thread-key="<?php echo $logData['logid'];?>" data-url="<?php echo Url::log($logData['logid']);?>" data-title="<?php echo $logData['log_title'];?>" data-author-key="<?php echo $logData['author'];?>"></div>');
	});
</script>
	<?php 
}
addAction('log_related', 'duoshuo_add_thread');


function duoshuo_nav() {//写入插件导航
	echo '<div class="sidebarsubmenu" id="themeseditor"><a href="./plugin.php?plugin=duoshuo">多说设置</a></div>';
}
addAction('adm_sidebar_ext', 'duoshuo_nav');
