<?php

if(!defined('BASEPATH'))
	exit('No direct script access allowed'); 

/*
 * MKJ SimpleCaptcha для MaxSite CMS
 * © http://moringotto.ru/
 */

// Автоподключение плагина.
function mkj_sc_autoload()
{
	$options = mso_get_option('plugin_mkj_sc', 'plugins', array());

	if ((isset($options['comusers']) and !$options['comusers']) or (!is_login_comuser() and !is_login()))
	{
		// Удаляем чужую капчу.
		mso_remove_hook('comments_content_end');
		mso_remove_hook('comments_new_captcha');
		mso_remove_hook('comments_new_captcha_error');
		// Капча MKJ SimpleCaptcha.
		mso_hook_add('comments_content_end', 'mkj_sc_show');
		mso_hook_add('comments_new_captcha', 'mkj_sc_add');
		mso_hook_add('comments_new_captcha_error', 'mkj_sc_error');
		// Хук на <head></head>
		mso_hook_add('head', 'mkj_sc_head');
	}
}

// Удаление плагина.
function mkj_sc_uninstall($args = array())
{	
	mso_delete_option('plugin_mkj_sc', 'plugins' );
	return $args;
}

// CSS в <head></head>.
function mkj_sc_head($args = array())
{
	if(!is_type('page'))
		return $args;

	// Настройки плагина.
	$options = mso_get_option('plugin_mkj_sc', 'plugins', array());
	if(!isset($options['type']) or !$options['type']) { $options['type'] = false; }
	if(!isset($options['css']) or !$options['css']) { $options['css'] = ''; }

	// Если произвольные таблицы стилей пусты, грузим стандартный стиль.
	if(!$options['css'])
		echo '<link rel="stylesheet" href="'. getinfo('plugins_url') . 'mkj_sc/mkj_sc.css" type="text/css" media="screen">', NR;
	if(!$options['type'] or $options['css'])
	{
		echo '<style>', NR;
		if(!$options['type']) echo 'input.comments_submit, input.submit { display: none; }', NR;
		if($options['css']) echo $options['css'], NR;
		echo '</style>', NR;
	}

	return $args;
}

// Проверка капчи.
function mkj_sc_add($args = array()) 
{
	$options = mso_get_option('plugin_mkj_sc', 'plugins', array());
	if(!isset($options['imagespack']) or !$options['imagespack']) { $options['imagespack'] = 'default'; }
	if($options['imagespack'] != 'Свой набор')
		{
			include('images/' . $options['imagespack'] . '/info.php');
			$options['correct'] = $packinfo['correct'];
		}
	elseif(!isset($options['correct']) or !$options['correct']) { $options['correct'] = 1; }

	$id = 0;

	// Получение ID.
	if(isset($_POST['mkj_sc_img_choosed']))
		{ $id = $_POST['mkj_sc_img_choosed']; }
	elseif(isset($_POST['comments_submit']))
		{ $id = $_POST['comments_submit']; }

	// Проверка.
	if($id == $options['correct'])
		{ return true; }
	else
		{ return false; }
}

// Вывод капчи.
function mkj_sc_show($args = array()) 
{
	$options = mso_get_option('plugin_mkj_sc', 'plugins', array());

	// Настройки.
	if(!isset($options['type']) or !$options['type']) { $options['type'] = false; }
	if(!isset($options['imagespack']) or !$options['imagespack']) { $options['imagespack'] = 'default'; }
	if(!isset($options['jserror']) or !$options['jserror']) { $options['jserror'] = true; }
	if(!isset($options['jserrortext']) or !$options['jserrortext']) { $options['jserrortext'] = 'В Вашем браузере отключен JavaScript — поэтому капча не будет работать. Пожалуйста, включите JavaScript.'; }
	// Настройки, зависящие от набора картинок.
	if($options['imagespack'] != 'Свой набор')
	{
		include('images/' . $options['imagespack'] . '/info.php');
		$options['images'] = getinfo('plugins_url') . 'mkj_sc/images/' . $options['imagespack'] . '/';
		$options['imagescount'] = $packinfo['imagescount'];
		$options['imgex'] = $packinfo['imgex'];
		$options['text'] = $packinfo['text'];
	}
	else
	{
		if(!isset($options['images']) or !$options['images']) { $options['images'] = getinfo('plugins_url') . 'mkj_sc/images/default/'; }
		if(!isset($options['imagescount']) or !$options['imagescount']) { $options['imagescount'] = 3; }
		
		if(!isset($options['imgex']) or !$options['imgex']) { $options['imgex'] = '.png'; }
		if(!isset($options['text']) or !$options['text']) { $options['text'] = 'Выберите человечка с поднятой рукой!'; }
	}

	// Случайно сортируем ID картинок.
	$imgarray = array();
	$i = 0;
	$imgs = range(1, $options['imagescount']);
	shuffle($imgs);
	while(list(, $img) = each($imgs)) 
	{
		$i++;
		$imgarray[$i] = $img;
	}

	// Общее начало капчи.
?>

<!-- Простая капча. Начало. -->
<div class="mkj_sc_box">
<p class="title"><?= $options['text'] ?></p>
<?php if(!$options['type']) { ?><p>При нажатии на картинку, Ваш комментарий будет добавлен.</p><?php } ?>

<?php
	if(!$options['type'])
	{
		// Выводим картинки в виде кнопок.
		for($i = 1; $i <= $options['imagescount']; $i++)
			{ echo('<input name="comments_submit" value="' . $imgarray[$i] . '" style="background: url(' . $options['images'] . $imgarray[$i] . $options['imgex'] . ') no-repeat" type="submit" class="var"> '); }
	}
	else
	{
		// JS.
		echo('<script type="text/javascript">
');
?>
function mkj_sc_check(i)
{
	var sch = document.getElementById('mkj_sc_img_choosed');
	sch.value = i;
<?php
		for($i = 1; $i <= $options['imagescount']; $i++)
			{ echo('var sc' . $i . ' = document.getElementById("mkj_sc_img_' . $i . '");
sc' . $i . '.style.border = "1px dashed #CCCCCC";
'); }
		for($i = 1; $i <= $options['imagescount']; $i++)
			{ echo('if(i == ' . $i . ')
	{ sc' . $i . '.style.border = "1px solid #BBBBBB"; }
'); }
?>
}
<?php
		echo('</script>');

		// Сама капча.
		for($i = 1; $i <= $options['imagescount']; $i++)
			{ echo('<img src="' . $options['images'] . $imgarray[$i] . $options['imgex'] . '" id="mkj_sc_img_' . $imgarray[$i] . '" onClick="javascript:mkj_sc_check(' . $imgarray[$i] . ')" class="varjs"> '); }
		echo('<input type="hidden" value="0" name="mkj_sc_img_choosed" id="mkj_sc_img_choosed">');
		// Сообщение об ошибке.
		if($options['jserror'])
			{ echo('<noscript><div class="error">' . $options['jserrortext'] . '</div></noscript>'); }
	}

	// Общий конец капчи.
?>

</div>
<!-- Простая капча. Конец. -->

<?php
}

// Вывод ошибки неверно выбранной картинки.
function mkj_sc_error()
{
	$options = mso_get_option('plugin_mkj_sc', 'plugins', array());
	if(!isset($options['errortext']) or !$options['errortext'])
		$options['errortext'] = 'Ошибка, выбран неверный рисунок!';
	echo('<div class="comment-error">' . $options['errortext'] . '</div>');
}

// Настройки плагина.
function mkj_sc_mso_options() 
{

	$CI = & get_instance();
	$CI->load->helper('directory');
	$all_dirs = directory_map(getinfo('plugins_dir'). 'mkj_sc/images', true);
	
	if ($all_dirs) $all_dirs = implode(' # ', $all_dirs) . ' # Свой набор';
		else $all_dirs = 'default # Свой набор';
		
	
	mso_admin_plugin_options('plugin_mkj_sc', 'plugins', 
		array(
			'type' => array(
							'type' => 'checkbox', 
							'name' => '1. Использовать JavaScript', 
							'description' => 'Вы можете включить JavaScript, и активируется старый режим капчи (версии 0.1-0.1.2), который работает <strong>НЕ</strong> у всех посетитетелей Вашего блога с отключенной поддержкой JavaScript. Такие пользователи <strong>НЕ</strong> смогут оставлять комментарии в Вашем блоге при этой настройке.', 
							'default' => false),
			'imagespack' => array(
							'type' => 'select',
							'name' => '2. Набор картинок:',
							'description' => 'Выберите набор картинок капчи. При выборе настройки <strong>&laquo;Свой набор&raquo;</strong> Вам необходимо настроить опции #3-7. При выборе набора эти настройки не надо править!',
							'values' => $all_dirs,
							'default' => 'default',
						),	
			'images' => array(
							'type' => 'text', 
							'name' => '3. Путь до картинок:', 
							'description' => 'Вы можете указать произвольный путь до папки с картинками капчи (<strong>1.jpg</strong>, <strong>2.jpg</strong> и т.д.). Количество картинок Вы должны указать в опции #4.',
							'default' => getinfo('plugins_url') . 'mkj_sc/images/default/'),
			'imagescount' => array(
							'type' => 'text', 
							'name' => '4. Количество картинок:', 
							'description' => 'Количество картинок, в папке, указанной в опции #3.', 
							'default' => 3),
			'correct'   => array(
							'type' => 'text',
							'name' => '5. Верный вариант:',
							'description' => 'Напишите ID картинки (1, 2 или 3), которая является верной. Перепроверьте этот пункт, иначе при правильном варианте ответа пользователи не смогут оставлять комментарии!',
							'default' => 1),
			'imgex'   => array(
							'type' => 'text',
							'name' => '6. Расширение картинок:',
							'description' => 'Введите расширение картинок.',
							'default' => '.png'),
			'text'   => array(
							'type' => 'text',
							'name' => '7. Текст капчи:',
							'description' => 'Вы можете изменить текст капчи на любой другой.',
							'default' => 'Выберите человечка с поднятой рукой!'),
			'errortext'   => array(
							'type' => 'text',
							'name' => '8. Текст ошибки:',
							'description' => 'При неверно выбранной картинке будет выводиться этот текст.',
							'default' => 'Ошибка, выбран неверный рисунок!'),
			'css'   => array(
							'type' => 'textarea',
							'name' => '9. Произвольные CSS-стили:',
							'description' => 'Введите сюда CSS-стили, чтобы задать произвольное оформление. <strong>Произвольные стили выводятся в шапке блога.</strong> Если Вы не хотите засорять лишним кодом Ваши страницы, внесите изменения в файл <code>mkj_sc.css</code> плагина.',
							'default' => ''),
			'jserror'   => array(
							'type' => 'checkbox',
							'name' => '10. NOSCRIPT-ошибка',
							'description' => 'Для посетителей с отключенным JavaScript, при активированной в блоге капче с использованием JavaScript (первая настройка на этой странице), будет выводиться ошибка.',
							'default' => 'true'),
			'jserrortext'   => array(
							'type' => 'text',
							'name' => '11. Текст NOSCRIPT-ошибки:',
							'description' => 'При показе блока о отключенном JavaScript (см. предыдущую настройку) будет выводится этот текст.',
							'default' => 'В Вашем браузере отключен JavaScript — поэтому капча не будет работать. Пожалуйста, включите JavaScript.'),
			'comusers'   => array(
							'type' => 'checkbox',
							'name' => '12. Скрыть капчу от комюзеров',
							'description' => 'Функция скрывает капчу от зарегистрированных комментаторов.',
							'default' => 'true'),
			),
		'Настройки простой капчи',
		'В данном окне Вы можете изменить настройки плагина MKJ SimpleCaptcha для MaxSite CMS. Если у Вас возникли какие-либо вопросы, оставьте их на <a href="http://moringotto.ru/page/simplecaptcha.html">странице плагина</a> или на <a href="http://forum.max-3000.com/viewtopic.php?f=6&t=1887">официальном форуме MaxSite CMS</a>.'
	);
}

?>