<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$info = array(
	'name' => 'Download count',
	'description' => t('Подсчет количества переходов по ссылке. Обрамите нужную ссылку в [dc]...[/dc]'),
	'version' => '1.1',
	'author' => 'Максим, Wave',
	'plugin_url' => 'http://max-3000.com/',
	'author_url' => 'http://maxsite.org/',
	'group' => 'template',
	'options_url' => getinfo('site_admin_url') . 'plugin_down_count',
);

# end file