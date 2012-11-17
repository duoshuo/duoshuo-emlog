<?php
global $userData;

$params = $duoshuoPlugin->packageOptions() + array(
	'callback'	=>	'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) .'/plugin.php?plugin=duoshuo&page=connect_site',
	'user_key'	=>	$userData['uid'],
	'user_name'	=>	$userData['username'],
);
?>
<iframe id="duoshuo-remote-window" src="<?php echo 'http://duoshuo.com/connect-site/?'. http_build_query($params, null, '&');?>" style="border:0; width:100%; height:580px;"></iframe>
<script>
$('#duoshuo_settings').addClass('sidebarsubmenu1');
</script>
