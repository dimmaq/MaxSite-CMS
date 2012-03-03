<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * MaxSite CMS
 * (c) http://max-3000.com/
 */

mso_cur_dir_lang('templates');

require_once( getinfo('common_dir') . 'comments.php' );

# всё делаем по-новому, чтобы для доступа к странице нужно было пройти авторизацию
# вначале выводим логин и пароль
# если авторизация пройдена, значит выводим страницу с формой
# если авторизация не пройдена, то опять выводим форму


# обработка отправленных данных - возвращает результат
$res_post = mso_comuser_edit(); 

# получим всю информацию о комюзере из сессии или url
$comuser_info = mso_get_comuser();

# отображение формы залогирования
$login_form = !is_login_comuser();

# если нет данных юзера, то выводим форму
if (!$comuser_info) $login_form = true;

if ($f = mso_page_foreach('users-form-head-meta')) require($f);
else
{
	mso_head_meta('title', t('Форма редактирования комментатора') . '. ' . getinfo('title')); // meta title страницы
}

if (!$comuser_info and mso_get_option('page_404_http_not_found', 'templates', 1) ) header('HTTP/1.0 404 Not Found'); 

// теперь сам вывод
# начальная часть шаблона
require(getinfo('template_dir') . 'main-start.php');

echo NR . '<div class="type type_users_form">' . NR;

echo $res_post;
	
if ($comuser_info)
{
	extract($comuser_info[0]);
	
	//pr($comuser_info[0]);
	if ($f = mso_page_foreach('users-form')) require($f); // подключаем кастомный вывод
	else
	{
		if ($comusers_nik) echo '<h1>' . $comusers_nik . '</h1>';
			else echo '<h1>'. t('Комментатор'). ' ' . $comusers_id . '</h1>';
		
		echo '<p><a href="' . getinfo('siteurl') . 'users/' . $comusers_id . '">' . t('Персональная страница') . '</a>';
		
		if (!$login_form)
		{
			echo ' | <a href="' . getinfo('siteurl') . 'password-recovery">' . t('Сменить пароль') . '</a>';
			echo ' | <a href="' . getinfo('siteurl') . 'logout">' . t('Выход') . '</a>';
		}
		echo '</p>';
		
		// если активация не завершена, то вначале требуем её завершить
		if ($comusers_activate_string != $comusers_activate_key) // нет активации
		{
			echo '<form method="post">' . mso_form_session('f_session_id');
			echo '<p><span style="color: red; font-weight: bold;" class="users-form">'. t('Введите ключ активации'). ':</span> 
				 <input type="text" style="width: 200px;" class="users-form" name="f_comusers_activate_key"> ';
			echo '<input type="submit" name="f_submit[' . $comusers_id . ']" value="' . t('Готово') . '"></p></form>';
			
			echo '<p>' . t('В случае проблем с активацией (не пришел ключ, указали ошибочный email), обращайтесь к администратору по email:') . ' <em>' . mso_get_option('admin_email', 'general', '-') . '</em></p>';
			
			
		}
		else // активация завершена - можно вывести поля для редактирования
		{
			echo '<form method="post" class="comusers-form">' . mso_form_session('f_session_id');
			
			if ($login_form) // нужно отобразить форму
			{
				echo '<h3>'. t('Для редактирования введите свой email и пароль'). ':</h3>';
			
				echo '<input type="hidden" value="' . getinfo('siteurl') . 'users/' . $comusers_id . '/edit" name="flogin_redirect">';
				echo '<p><strong>'. t('Ваш email'). ':</strong> <input type="text" name="flogin_user" class="flogin_user">*</p>';
				echo '<p><strong>'. t('Ваш пароль'). ':</strong> <input type="password" name="flogin_password" class="flogin_password">*</p>';
				echo mso_form_session('flogin_session_id');
		
				
				echo '<p><a href="' . getinfo('siteurl') . 'users/' . $comusers_id . '/lost">' . t('Я забыл пароль') . '</a></p>';
			}
			else
			{
				$CI = & get_instance();
				$CI->load->helper('form');
				
				echo '<input type="hidden" value="' . $comusers_email . '" name="f_comusers_email">';
				echo '<input type="hidden" value="' . $comusers_password . '" name="f_comusers_password">';
				
				echo '<h3>'. t('Укажите свои данные'). '</h3>';
				
				echo '<p><strong>'. t('Отображаемый ник'). ':</strong> <input type="text" name="f_comusers_nik" value="' . $comusers_nik . '"></p>';
				echo '<p><strong>'. t('Сайт (с http://)'). ':</strong> <input type="text" name="f_comusers_url" value="' . $comusers_url . '"></p>';
				echo '<p><strong>'. t('Аватарка (с http://, 80x80px)'). ':</strong> <input type="text" name="f_comusers_avatar_url" value="' . $comusers_avatar_url . '"></p><br>';
				
				echo '<p><strong>'. t('ICQ'). ':</strong> <input type="text" name="f_comusers_icq" value="' . $comusers_icq . '"></p>';
				echo '<p><strong>'. t('Twitter'). ':</strong> <input type="text" name="f_comusers_msn" value="' . $comusers_msn . '"></p>';
				echo '<p><strong>'. t('Jabber'). ':</strong> <input type="text" name="f_comusers_jaber" value="' . $comusers_jaber . '"></p>';
				echo '<p><strong>'. t('Дата рождения'). ':</strong> <input type="text" name="f_comusers_date_birth" value="' . $comusers_date_birth . '"></p>';
				
				echo '<p><strong>'. t('Уведомления'). ':</strong>' . form_dropdown('f_comusers_notify', array('0'=>t('Без уведомлений'), '1'=>t('Подписаться')), $comusers_notify, '');
				
				
				// поскольку чекбоксы не передаются, если они не отмечены, 
				// то передаем скрытно их дефолтные значения

				echo '<input type="hidden" value="0" name="f_comusers_meta[subscribe_my_comments]">';
				
				$check = (isset($comusers_meta['subscribe_my_comments']) and $comusers_meta['subscribe_my_comments']=='1');
				echo '<br><strong class="subscribe_my_comments">&nbsp;</strong><label>' 
					. form_checkbox('f_comusers_meta[subscribe_my_comments]', '1', $check) 
					. ' '. t('новые комментарии, где я участвую') . '</label>';
				
				
				echo '<input type="hidden" value="0" name="f_comusers_meta[subscribe_other_comments]">';
				$check = (isset($comusers_meta['subscribe_other_comments']) and $comusers_meta['subscribe_other_comments']=='1');
				echo '<br><strong class="subscribe_my_comments">&nbsp;</strong><label>' 
					. form_checkbox('f_comusers_meta[subscribe_other_comments]', '1', $check) 
					. ' '. t('новые комментарии, где я не участвую') . '</label>';
				
				
				echo '<input type="hidden" value="0" name="f_comusers_meta[subscribe_new_pages]">';
				$check = (isset($comusers_meta['subscribe_new_pages']) and $comusers_meta['subscribe_new_pages']=='1');
				echo '<br><strong class="subscribe_my_comments">&nbsp;</strong><label>' 
					. form_checkbox('f_comusers_meta[subscribe_new_pages]', '1', $check) 
					. ' '. t('новые записи сайта') . '</label>';
					
					
				echo '<input type="hidden" value="0" name="f_comusers_meta[subscribe_admin]">';
				$check = (isset($comusers_meta['subscribe_admin']) and $comusers_meta['subscribe_admin']=='1');
				echo '<br><strong class="subscribe_my_comments">&nbsp;</strong><label>' 
					. form_checkbox('f_comusers_meta[subscribe_admin]', '1', $check) 
					. ' '. t('рассылка администратора') . '</label>';
					

				


				echo '<p><strong>'. t('О себе'). ' ('. t('HTML удаляется'). '):</strong> <textarea name="f_comusers_description">'. NR 
					. htmlspecialchars(strip_tags($comusers_description)) . '</textarea></p>';
			
			}
			
			if ($login_form)
				echo '<p><input type="submit" name="flogin_submit" class="submit" value="' .  t('Отправить') . '"></p></form>';
			else
				echo '<p><input type="submit" name="f_submit[' . $comusers_id . ']" class="submit" value="' .  t('Отправить') . '"></p></form>';
			
		}
		
	} // mso_page_foreach

}
else
{
	if ($f = mso_page_foreach('pages-not-found')) 
	{
		require($f); // подключаем кастомный вывод
	}
	else // стандартный вывод
	{
		echo '<h1>' . t('404. Ничего не найдено...') . '</h1>';
		echo '<p>' . t('Извините, пользователь с указанным номером не найден.') . '</p>';
		echo mso_hook('page_404');
	}
}

echo NR . '</div><!-- class="type type_users_form" -->' . NR;

# конечная часть шаблона
require(getinfo('template_dir') . 'main-end.php');
	
?>