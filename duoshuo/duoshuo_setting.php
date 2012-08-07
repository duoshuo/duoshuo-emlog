<?php
/**
 * duoshuo_setting.php
 * design by Duoshuo
 */
!defined('EMLOG_ROOT') && exit('access deined!');

function plugin_setting_view() {
    include_once EMLOG_ROOT . '/content/plugins/duoshuo/duoshuo_config.php';
    ?>
	
    <div><?php if (isset($_GET['setting'])): ?><span class="actived">操作成功</span><?php endif;?></div>
    <h2>多说参数设置</h2>
    <?php if (!DUOSHUO_SHORTNAME && !DUOSHUO_SECRET):?>
    <p>请先在<a href="http://dev.duoshuo.com/" target="_blank">多说网</a>注册一个站点，注册后你将得到域名(ShortName)和密钥(Secret)：</p>
    <?php endif;?>
    <form action="./plugin.php?plugin=duoshuo&action=setting" method="POST">
		<table width="100%" id="adm_comment_list" class="item_list">
		  	<thead>
		      <tr>
		        <th><b>选项</b></th>
		        <th><b>设置</b></th>
		        <th><b>说明</b></th>
		      </tr>
		    </thead>
		    <tbody>
		      <tr>
		        <td>多说域名</th>
		        <td><input type="text" name="duoshuo_shortname" value="<?php echo DUOSHUO_SHORTNAME;?>" />.duoshuo.com</td>
		        <td>你的多说二级域名，不包括"http://"部分</td>
		      </tr>
		      <tr>
		        <td>多说密钥(secret)</td>
		        <td><input type="text" name="duoshuo_secret" value="<?php echo DUOSHUO_SECRET;?>" /></td>
		        <td>你的多说密钥，一个32位字符串</td>
		      </tr>
		      <tr>
		        <td>显示原生评论</td>
		        <td>
		        	<input type="hidden" name="duoshuo_show_original_comments" value="0" />
			        <label><input type="checkbox" name="duoshuo_show_original_comments" value="1"<?php if (DUOSHUO_SHOW_ORIGINAL_COMMENTS) echo ' checked="checked"';?> />显示原生评论</label>
			    </td>
		        <td></td>
		      </tr>
			</tbody>
		</table>
    
        <div>
            <input type="submit" value="保存" />
        </div>
    </form>
    <?php if (DUOSHUO_SHORTNAME):?>
    <p>更多功能设置，请访问：<a href="http://<?php echo DUOSHUO_SHORTNAME?>.duoshuo.com">多说管理后台</a></p>
    <?php endif;
}

function plugin_setting() {
	
    if (!empty($_POST['duoshuo_shortname'])) {
        include_once EMLOG_ROOT . '/content/plugins/duoshuo/duoshuo_config.php';
        
        $map = array(
        	'DUOSHUO_SHORTNAME'	=>	'duoshuo_shortname',
        	'DUOSHUO_SECRET'	=>	'duoshuo_secret',
			'DUOSHUO_SHOW_ORIGINAL_COMMENTS'=>	'duoshuo_show_original_comments',
        );
        
        $fso = @fopen(EMLOG_ROOT.'/content/plugins/duoshuo/duoshuo_config.php','w'); //写入替换后的配置文件
        if ($fso === false)
        	emMsg(EMLOG_ROOT.'/content/plugins/duoshuo/duoshuo_config.php 没有写权限，请修改文件属性');
        var_dump($_POST);
        fwrite($fso, "<?php\n");
		foreach($map as $key => $value){
			$newValue = isset($_POST[$value]) ? $_POST[$value] : constant($key);
			fwrite($fso, "define('$key', '$newValue');\n");
		}
        fclose($fso);
    }
}
