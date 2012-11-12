<?php
/**
 * duoshuo_setting.php
 * design by Duoshuo
 */
!defined('EMLOG_ROOT') && exit('access deined!');

function plugin_setting_view() {
	global $duoshuoPlugin;
	
	$page = isset($_GET['page']) ? $_GET['page'] : 'settings';
	$shortName = $duoshuoPlugin->getOption('short_name');
	
    switch($page){
    	case 'manage':
    	    if (empty($shortName)){
		    	include 'connect-site.php';
		    	return;
		    }
    		include 'manage.php';
    		break;
    	case 'connect_site':
    		$duoshuoPlugin->connectSite();
    		break;
    	case 'settings':
    	default:
		    if (empty($shortName)){
		    	include 'connect-site.php';
		    	return;
		    }
    		include 'settings.php';
    }
}

function plugin_setting() {
	global $duoshuoPlugin;
	
    if (!empty($_POST['duoshuo_short_name'])) {
    	foreach($_POST as $key => $value){
	    	if (substr($key, 0, 8) === 'duoshuo_')
				$duoshuoPlugin->updateOption(substr($key, 8), $value);
    	}
	    
        $CACHE = Cache::getInstance();
        $CACHE->updateCache('options');
    }
}

