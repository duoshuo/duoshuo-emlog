duoshuo-emlog
=================

多说 extension for emlog，官方主页：[dev.duoshuo.com](http://dev.duoshuo.com/)

## 安装步骤
1. 在[多说网](http://duoshuo.com/)注册一个站点，记录下域名(ShortName)和密钥(Secret)
1. 将Duoshuo目录复制到你的emlog的content/plugins目录下
1. 在emlog的“管理后台-多说设置”中设置刚刚注册的域名(ShortName)和密钥(Secret)

## 手动插入评论框
如果你想在某个特定文章页面插入评论框，可以在templates模板中插入下面代码：
    <?php echo duoshuo_comments($logData);?>
其中的$logData是一个日志的记录对象。

## Contact
本插件由[多说网](http://duoshuo.com/)维护，如果你有什么疑问或者建议，欢迎发邮件给zhenyu (at) duoshuo.com，或者在新浪微博上私信[@多说网](http://weibo.com/duoshuo)。

## Showcases
