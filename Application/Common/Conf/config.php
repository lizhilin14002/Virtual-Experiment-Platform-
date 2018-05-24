<?php
return array(
	//'配置项'=>'配置值'
	// 添加数据库配置信息 @公共变量 common/config
	'DB_TYPE'=>'mysql',// 数据库类型
	'DB_HOST'=>'localhost',// 服务器地址
	'DB_NAME'=>'vrcenter',// 数据库名
	'DB_USER'=>'root',// 用户名
	'DB_PWD'=>'',// 密码
	'DB_PORT'=>3306,// 端口
	'DB_PREFIX'=>'',// 数据库表前缀
	'DB_CHARSET'=>'utf8',// 数据库字符集
	'URL_MODEL'=>'2',
	'SHOW_PAGE_TRACE' =>true, 
	//添加模板主题默认后缀为“tpl”
	// 'TMPL_TEMPLATE_SUFFIX'=>'.tpl'
	//模板文件的默认后缀的情况是.html，也可以通过 TMPL_TEMPLATE_SUFFIX 来配置成其他的
	//如果觉得目录结构太深，可以通过设置 TMPL_FILE_DEPR 参数来配置简化模板的目录层次
	'TMPL_PARSE_STRING' => array(
        '__STYLE__' => __ROOT__.'/Public',
     ),
);