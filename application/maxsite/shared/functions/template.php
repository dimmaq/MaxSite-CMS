<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/*
 * (c) MaxSite CMS
 * http://max-3000.com/
 *
 * Функции для работы с шаблоном
 * Не копируйте этот файл в свой шаблон!
 *
 * Файл несовместим со старым default-шаблоном
 *
 */

 
# функция возвращает массив $path_url-файлов по указанному $path - каталог на сервере
# $full_path - нужно ли возвращать полный адрес (true) или только имя файла (false)
# $exts - массив требуемых расширений. По-умолчанию - картинки
if (!function_exists('get_path_files'))
{
	function get_path_files($path = '', $path_url = '', $full_path = true, $exts = array('jpg', 'jpeg', 'png', 'gif', 'ico'))
	{
		// если не указаны пути, то отдаём пустой массив
		if (!$path or !$path_url) return array();
		if (!is_dir($path)) return array(); // это не каталог

		$CI = & get_instance(); // подключение CodeIgniter
		$CI->load->helper('directory'); // хелпер для работы с каталогами
		$files = directory_map($path, true); // получаем все файлы в каталоге
		if (!$files) return array();// если файлов нет, то выходим

		$all_files = array(); // результирующий массив с нашими файлами
		
		// функция directory_map возвращает не только файлы, но и подкаталоги
		// нам нужно оставить только файлы. Делаем это в цикле
		foreach ($files as $file)
		{
			if (@is_dir($path . $file)) continue; // это каталог
			
			$ext = substr(strrchr($file, '.'), 1);// расширение файла
			
			// расширение подходит?
			if (in_array($ext, $exts))
			{
				if (strpos($file, '_') === 0) continue; // исключаем файлы, начинающиеся с _
				
				// добавим файл в массив сразу с полным адресом
				if ($full_path)
					$all_files[] = $path_url . $file;
				else
					$all_files[] = $file;
			}
		}
		
		natsort($all_files); // отсортируем список для красоты
		
		return $all_files;
	}
}

# возвращает подкаталоги в указаном каталоге. 
# можно указать исключения из каталогов в $exclude 
# в $need_file можно указать обязательный файл в подкаталоге 
# если $need_file = true то обязательный php-файл в подкаталоге должен совпадать с именем подкаталога
# например для /menu/ это menu.php 
if (!function_exists('mso_get_dirs'))
{
	function mso_get_dirs($path, $exclude = array(), $need_file = false)
	{
		$CI = & get_instance(); // подключение CodeIgniter
		$CI->load->helper('directory'); // хелпер для работы с каталогами
		$all_dirs = directory_map($path, true);
		
		$dirs = array();
		foreach ($all_dirs as $d)
		{
			// нас интересуют только каталоги
			if (is_dir($path . $d) and !in_array($d, $exclude))
			{
				if (strpos($d, '_') === 0) continue; // исключаем файлы, начинающиеся с _
				if (strpos($d, '-') === 0) continue; // исключаем файлы, начинающиеся с -
				
				// если указан обязщательный файл, то проверяем его существование
				if($need_file ===true and !file_exists($path . $d . '/' . $d . '.php')) continue;
				if($need_file !== true and $need_file and !file_exists($path . $d . '/' . $need_file)) continue;
				
				$dirs[] = $d;
			}
		}
		
		natcasesort($dirs);
		
		return $dirs;
	}
}

# возвращает файлы для favicon
if (!function_exists('default_favicon'))
{
	function default_favicon()
	{
		$all = get_path_files(getinfo('template_dir') . 'images/favicons/', getinfo('template_url') . 'images/favicons/', false);
		return implode($all, '#');
	}
}

# возвращает файлы для компонент
if (!function_exists('default_components'))
{
	function default_components()
	{
		static $all = false; // запоминаем результат, чтобы несколько раз не вызывать функцию get_path_files
		
		if ($all === false)
		{
			$all = mso_get_dirs(getinfo('template_dir') . 'components/', array(), true);
		}
		
		return '0||' . tf('Отсутствует') . '#' . implode($all, '#');
	}
}

# возвращает файлы для css-профиля
if (!function_exists('default_profiles'))
{
	function default_profiles()
	{
		$all = get_path_files(getinfo('template_dir') . 'css/profiles/', getinfo('template_url') . 'css/profiles/', false, array('css'));
		return implode($all, '#');
	}
}

# возвращает файлы для логотипа
if (!function_exists('default_header_logo'))
{
	function default_header_logo()
	{
		$all = get_path_files(getinfo('template_dir') . 'images/logos/', getinfo('template_url') . 'images/logos/', false);
		return implode($all, '#');
	}
}

# возвращает каталоги в uploads, где могут храниться файлы для шапки 
if (!function_exists('default_header_image'))
{
	function default_header_image()
	{
		$dirs = mso_get_dirs(getinfo('uploads_dir'), array('_mso_float', 'mini', '_mso_i', 'smiles'));
		
		return '-template-||' . tf('Каталог шаблона') . '#' . implode($dirs, '#');
	}
}

# вывод подключенных css-профилей
if (!function_exists('default_out_profiles'))
{
	function default_out_profiles()
	{
		if ($default_profiles = mso_get_option('default_profiles', 'templates', array())) // есть какие-то профили оформления
		{
			$css_out = '';
			
			// theme-профили подключаются как link rel="stylesheet
			foreach($default_profiles as $css_file)
			{
				$fn = 'css/profiles/' . $css_file;
				
				$link = strpos($css_file, 'theme-'); // это theme- ?
				
				if ($link !== false and $link === 0)
				{
					mso_add_file($fn); // подключаем внешими стилями
				}
				else
				{
					$css_out .= mso_out_css_file($fn, false, false); // получение и обработка CSS из файла
				}
			}
			
			if ($css_out) 
				echo NR . '<style>' . $css_out . '</style>' . NR;
		}
	}
}

# функция возвращает полный путь к файлу компонента для указанной опции
# $option - опция
# $def_component - компонент по умолчанию
# пример использования
# if ($fn = get_component_fn('header_component2', 'menu')) require($fn);
if (!function_exists('get_component_fn'))
{
	function get_component_fn($option = '', $def_component = '')
	{
		if ($dir = mso_get_option($option, 'templates', $def_component)) // получение опции
		{
			$fn = getinfo('template_dir') . 'components/' . $dir . '/' . $dir . '.php';
			
			// проверяем если файл в наличии
			if (file_exists($fn)) return $fn;
		}
		
		return false; // ничего нет
	}
}

# функция подключает файлы css-style установленных компонентов и выводит их содержимое в едином блоке <style>
# использовать в head 
# $component_options - названия опций, которыми определяются компоненты в шаблоне
# css-файл компонента находится в общем css-каталоге шаблона с именем компонента, например menu.php и menu.css
if (!function_exists('out_component_css'))
{
	function out_component_css($component_options = array('header_component1', 'header_component2', 'header_component3', 'header_component4', 'header_component5', 'footer_component1', 'footer_component2', 'footer_component3', 'footer_component4', 'footer_component5'))
	{
		
		// проходимся по всем заданным опциям
		foreach($component_options as $option)
		{
			// и если они определены
			if ($dir = mso_get_option($option, 'templates', false))
			{
				$fn = 'components/' . $dir . '/style.css';
				mso_add_file($fn); // подключаем внешими стилями
			}
		}
	}
}


# типовой вывод секции HEAD
# можно использовать в header.php
if (!function_exists('mso_default_head_section'))
{
	function mso_default_head_section($options = array())
	{
	
		// ob_start(); # задел на будущее - буферизация
	// <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=8"><![endif]-->
		echo 
'<!DOCTYPE HTML>
<html' . mso_get_val('head_section_html_add') . '><head>' . mso_hook('head-start') . '
	<meta charset="UTF-8">
	<title>' . mso_head_meta('title') . '</title>
	<meta name="generator" content="MaxSite CMS">
	<meta name="description" content="' . mso_head_meta('description') . '">
	<meta name="keywords" content="' . mso_head_meta('keywords') . '">
	<link rel="shortcut icon" href="' . getinfo('template_url') . 'images/favicons/' . mso_get_option('default_favicon', 'templates', 'favicon1.png') . '" type="image/x-icon">
	';
	
		if (mso_get_option('default_canonical', 'templates', 0)) echo mso_link_rel('canonical');
	
		echo NT . '<!-- RSS -->' . NT . mso_rss();
		
		if ($fn = mso_fe('custom/head-start.php')) require($fn);

		echo NT . '<!-- CSS -->'; 
		
		// если есть style.php в шаблоне, то подключается только он, исключая все остальные файлы
		if ($fn = mso_fe('css/style.php')) 
		{
			require($fn);
		}
		else
		{
			echo NT . '<link rel="stylesheet" href="'; 
				
				if (mso_fe('css/css.php')) echo getinfo('template_url') . 'css/css.php'; 
				else 
				{
					if (mso_fe('css/my_style.css'))
						echo getinfo('template_url') . 'css/my_style.css'; 
					else
					{
						if (mso_fe('css/style-all-mini.css')) // если есть style-all-mini.css
							echo getinfo('template_url') . 'css/style-all-mini.css'; 
						elseif (mso_fe('css/style-all.css')) // нет mini, подключаем обычный файл
							echo getinfo('template_url') . 'css/style-all.css'; 
						else 
							echo getinfo('shared_url') . 'css-less/style-all-mini.css'; 
					}
				}
				
			echo '">';

			// подключение var_style.css
			// если есть var_style.php, то используем его
			if ($fn = mso_fe('css/var_style.php')) 
			{
				require($fn);
			}
			else
			{
				$var_file = '';
				
				if (mso_fe('css/var_style.css'))
				{
					$var_file = getinfo('template_url') . 'css/var_style.css';	
				}
				elseif (file_exists(getinfo('shared_dir') . 'css-less/var_style.css')) 
				{
					$var_file = getinfo('shared_url') . 'css-less/var_style.css';
				}
				
				if ($var_file) echo NT . '<link rel="stylesheet" href="' . $var_file . '">';	
			}
		
		} // else style.php
		
		echo NT . '<link rel="stylesheet" href="' . getinfo('template_url') . 'css/print.css" media="print">';
		
		// если есть fonts.css, то подключаем его
		// файл специально используется для подгрузки шрифтов через @import 
		mso_add_file('css/fonts.css');
		
		// и import.css для каких-то других @import
		mso_add_file('css/import.css');
		
		out_component_css();
			
		echo NT . mso_load_jquery();
		
		echo NT . '<!--[if lt IE 9]>
	<script src="' . getinfo('shared_url') . 'js/html5shiv.js"></script>
	<![endif]-->';
		
		echo NR . NT . '<!-- plugins -->' . NR;
		mso_hook('head');
		echo NT . '<!-- /plugins -->' . NR;

		mso_add_file('css/add_style.css');
		
		default_out_profiles();

		if ($fn = mso_fe('custom/head.php')) require($fn);
		if ($fn = mso_page_foreach('head')) require($fn);
		if (function_exists('ushka')) echo ushka('head');
		
		if (mso_fe('js/my.js')) 
			echo '	<script src="' . getinfo('template_url') . 'js/my.js"></script>';
		
		if ($my_style = mso_get_option('my_style', 'templates', '')) 
			echo NR . '<!-- custom css-my_style -->' . NR . '<style>' . NR . $my_style . '</style>';
		
		mso_hook('head-end');

		if (function_exists('ushka')) echo ushka('google_analytics_top');
		
		/*
		# буферизация на будущее
		$head = ob_get_contents();
		ob_end_clean();
		echo $head;
		*/
		
		echo NR . '</head>';
		if (!$_POST) flush();
	}
}


/* 
Вспомогательная функция mso_section_to_array
преобразование входящего текста опции в массив
по каждой секции по указанному патерну
Вход:

[slide]
link = ссылка изображения
title = подсказка
img = адрес картинки
text = текст с html без переносов. h3 для заголовка
p_line1 = пагинация 1 линия
p_line2 = пагинация 2 линия
[/slide]

Паттерн (по правилам php):
	'!\[slide\](.*?)\[\/slide\]!is'

Выход:

Array
(
	[0] => Array
		(
			[link] => ссылка изображения
			[title] => подсказка
			[img] => адрес картинки
			[text] => текст с html без переносов. h3 для заголовка
			[p_line1] => пагинация 1 линия
			[p_line2] => пагинация 2 линия
		)
 )

$array_default - стартовый массив опций на случай, если в опции нет обязательного ключа
например 
array('link'=>'', 'title'=>'', 'img'=>'', 'text'=>'', 'p_line1'=>'', 'p_line2'=>'')

Если $simple = true, то вхродящий паттерн используется как слово из которого
будет автоматом сформирован корректный паттерн по шаблону [слово]...[/слово]

*/

if (!function_exists('mso_section_to_array'))
{
	function mso_section_to_array($text, $pattern, $array_default = array(), $simple = false)
	{
	
		if ($simple) $pattern = '!\[' . $pattern . '\](.*?)\[\/' . $pattern . '\]!is';
		
		// $array_result - массив каждой секции (0 - все вхождения)
		if (preg_match_all($pattern, $text, $array_result))
		{
			// массив слайдов в $array_result[1]
			// преобразуем его в массив полей
			
			$f = array(); // массив для всех полей
			$i = 0; // счетчик 
			foreach($array_result[1] as $val)
			{
				$val = trim($val);
				
				if (!$val) continue;
				
				$val = str_replace(' = ', '=', $val);
				$val = str_replace('= ', '=', $val);
				$val = str_replace(' =', '=', $val);
				$val = explode("\n", $val); // разделим на строки
				
				$ar_val = array();
				
				$f[$i] = $array_default;
				
				foreach ($val as $pole)
				{
					$ar_val = explode('=', $pole); // строки разделены = type = select
					if ( isset($ar_val[0]) and isset($ar_val[1]))
						$f[$i][$ar_val[0]] = $ar_val[1];
				}
				
				$i++;
			}
			
			return $f;
		}
		
		return array(); // не найдено
	}
}


# получает css из указанного файла
# в css-файле можно использовать php
# осуществляется сжатие css
# автозамена [TEMPLATE_URL] на url-шаблона
# функция возвращает только стили, без обрамляющего <style>
# Если <style> нужны, то $tag_style = true
# Если нужен сразу вывод в браузер, то $echo = true
if (!function_exists('mso_out_css_file'))
{
	function mso_out_css_file($fn, $tag_style = true, $echo = true)
	{
		
		$fn = getinfo('template_dir') . $fn;
		
		$out = '';
		if (file_exists($fn)) // проверяем если ли файл в наличии
		{
			if ($r = @file_get_contents($fn)) $out .= $r . NR; // получаем содержимое
		
			if ($out) 
			{
				ob_start();
				eval( '?>' . stripslashes($out) . '<?php ');
				$out = ob_get_contents();
				ob_end_clean();
				
				$out = str_replace('[TEMPLATE_URL]', getinfo('template_url'), $out);
				$out = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $out);
				$out = str_replace(array('; ', ' {', ': ', ', '), array(';', '{', ':', ','), $out);
			}
		
			if ($tag_style) $out = NR . '<style>' . $out . '</style>' . NR;
			if ($echo) echo $out;
		}
		
		return $out;
	}
}


# формирование <script> с внешним js-файлом или
# формирование <link rel="stylesheet> с внешним css-файлом
# имя файла указывается относительно каталога шаблона
# если файла нет, то ничего не происходит
if (!function_exists('mso_add_file'))
{
	function mso_add_file($fn)
	{
		if (file_exists(getinfo('template_dir') . $fn)) 
		{
			$ext = substr(strrchr($fn, '.'), 1);// расширение файла
			if ($ext == 'js') echo NT . '<script src="' . getinfo('template_url') . $fn . '"></script>';
			elseif ($ext == 'css') echo NT . '<link rel="stylesheet" href="' . getinfo('template_url') . $fn . '">';
			elseif ($ext == 'less') echo NT . '<link rel="stylesheet/less" href="' . getinfo('template_url') . $fn . '" type="text/css">';
			
		}
	}
}


# Функция возвращает путь к файлу относительно текущего шаблона
# если файла нет, то возвращается false
# 	if ($fn = mso_fe('stock/page_out/page-out.php')) require($fn);
if (!function_exists('mso_fe'))
{
	function mso_fe($file)
	{
		$file = getinfo('template_dir') . $file;

		if (file_exists($file)) 
			return $file;
		else 
			return false;
	}
}


# end file