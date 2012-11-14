<?php
/*
Plugin Name: 多说评论插件
Version: 0.2
Plugin URL: http://dev.duoshuo.com/
Description: 多说社会化评论框
ForEmlog: 4.2.1
Author: 多说
Author URL: http://duoshuo.com/
*/

!defined('EMLOG_ROOT') && exit('access deined!');

if (function_exists('emLoadJQuery'))
	emLoadJQuery();

include_once EMLOG_ROOT . '/content/plugins/duoshuo/Duoshuo_Emlog.php';

$duoshuoPlugin = Duoshuo_Emlog::getInstance();

function duoshuo_print_scripts(){
	global $duoshuoPlugin;?>
<!-- Duoshuo bottom script -->
<script type="text/javascript">
	jQuery(function(){
		jQuery('#newcomment').addClass('ds-recent-comments').data('excerpt-length', 32);
	});
	var duoshuoQuery = <?php echo json_encode($duoshuoPlugin->buildQuery());?>;
	(function() {
		var ds = document.createElement('script');
		ds.type = 'text/javascript';ds.async = true;
		ds.src = 'http://static.duoshuo.com/embed.js';
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ds);
	})();
</script>
<?php 
}

function duoshuo_comments($logData){
	return '<div class="ds-thread" data-thread-key="' . $logData['logid'] . '" data-url="' . Url::log($logData['logid']) . '" data-title="' . $logData['log_title'] . '" data-author-key="' . $logData['author'] . '"></div>';
};

function duoshuo_replace_comments($logData){
	global $duoshuoPlugin;?>
<script>
	jQuery(function(){
	<?php if (!$duoshuoPlugin->getOption('show_original_comments')):?>
		jQuery('.comment-header').remove();
		jQuery('.comment').remove();
	<?php endif;?>
		jQuery('#comment-place').replaceWith('<?php echo duoshuo_comments($logData)?>');
	});
</script>
	<?php 
}

function duoshuo_installation_tips($logData){?>
<script>
	jQuery(function(){
		jQuery('#comment-place').replaceWith('还差一步，你就能开始使用多说评论框了。<a href="admin/plugin.php?plugin=duoshuo&page=settings">点此创建多说账户</a>');
	});
</script>
	<?php 
}

if ($duoshuoPlugin->shortName && $duoshuoPlugin->secret){
	addAction('index_footer','duoshuo_print_scripts');
	addAction('log_related', 'duoshuo_replace_comments');
}
else{
	addAction('log_related', 'duoshuo_installation_tips');
}

function duoshuo_nav() {//写入插件导航
	global $duoshuoPlugin;
	echo '<div id="duoshuo_settings" class="sidebarsubmenu"><a href="./plugin.php?plugin=duoshuo&page=settings">多说设置</a></div>';
	
	if (!empty($duoshuoPlugin->shortName))
		echo '<div id="duoshuo_manage" class="sidebarsubmenu"><a href="./plugin.php?plugin=duoshuo&page=manage">多说管理</a></div>';
}

addAction('adm_sidebar_ext', 'duoshuo_nav');
