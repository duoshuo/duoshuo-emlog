<div><?php if (isset($_GET['setting'])): ?><span class="actived">操作成功</span><?php endif;?></div>
<div class="containertitle"><b>多说参数设置</b></div>
<div class="line"></div>
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
		        <td><input type="text" name="duoshuo_short_name" value="<?php echo $duoshuoPlugin->getOption('short_name');?>" />.duoshuo.com</td>
		        <td>你的多说二级域名，不包括"http://"部分</td>
		      </tr>
		      <tr>
		        <td>多说密钥(secret)</td>
		        <td><input type="text" name="duoshuo_secret" value="<?php echo $duoshuoPlugin->getOption('secret');?>" /></td>
		        <td>你的多说密钥，一个32位字符串</td>
		      </tr>
		      <tr>
		        <td>显示原生评论</td>
		        <td>
		        	<input type="hidden" name="duoshuo_show_original_comments" value="0" />
			        <label><input type="checkbox" name="duoshuo_show_original_comments" value="1"<?php if ($duoshuoPlugin->getOption('show_original_comments')) echo ' checked="checked"';?> />显示原生评论</label>
			    </td>
		        <td></td>
		      </tr>
			</tbody>
		</table>
    
        <div>
            <input type="submit" value="保存" />
        </div>
    </form>
    <p>如果你使用的模板无法看到多说评论框，请在模板的echo_log.php文件中插入代码：&lt;?php echo duoshuo_comments($logData);?&gt;</p>
    <p>更多功能设置，请访问：<a href="http://<?php echo $duoshuoPlugin->shortName?>.duoshuo.com">多说管理后台</a></p>
<script>
$('#duoshuo_settings').addClass('sidebarsubmenu1');
</script>
