<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * MaxSite CMS
 * (c) http://maxsite.org/
 * Класс для формирования колонок
*/

class Columns 
{
	protected $cols_count = 3; // количество колонок
	protected $pages_count = 1; // всего количество записей
	protected $cut = 1; // кол-во записей в одной колонке
	protected $_echo = true; // выводить данные по echo - иначе return
	protected $cut_i = 1; // номер записи в колонке
	protected $cut_num_col = 1; // номер колонки
	protected $cut_close_div = false; // признак закрытого DIV
	
	function __construct($cols_count = 3, $pages_count = 1, $_echo = true)
	{
		// запомним
		$this->cols_count = $cols_count;
		$this->pages_count = $pages_count;
		
		// режим вывода
		$this->_echo = $_echo;
		
		// вычислим
		$this->cut = ceil($pages_count/$cols_count); // кол-во записей в одной колонке
		
		// основной контейнер
		if ($this->_echo) echo NR . NR . '<div class="columns"><div class="columns-wrap">';
				else return NR . NR . '<div class="columns"><div class="columns-wrap">';

	}
	
	// вывод внутри цикла
	function out($class = 'left', $style = '')
	{
		if ($this->cut_i == 1)
		{
			$this->cut_close_div = false;
			
			if ($style) $style = ' style="' . $style . '"';
			
			$out = NR . '<div class="' . $class 
					. ' column column-' . $this->cut_num_col
					. ' column-' . $this->cut_num_col . '-of-' . $this->cols_count
					. ( ($this->cut_num_col == 1) ? ' column-first':'' ) 
					. ( ($this->cut_num_col == $this->cols_count) ? ' column-last':'' ) 
					. '"' 
					. $style . '>'
					. NR . '<div class="column-content">';
					
			if ($this->_echo) echo $out;
				else return $out;
		}
	}
	
	// следующая итерация
	function next()
	{
		$this->cut_i++;

		if ($this->cut_i > $this->cut)
		{
			$this->cut_i = 1;
			$this->cut_close_div = true;
			$this->cut_num_col++;

			if ($this->_echo) echo '</div></div>' . NR;
				else return '</div></div>' . NR;
		}
	}
	
	// завершение вывода колонок
	function close()
	{
		$out = '';
		
		// незакрытый div left
		if (!$this->cut_close_div) $out .= '</div></div>' . NR;
		
		// основной контейнер
		$out .= '<div class="clearfix"></div></div></div><!-- end columns -->' . NR;

		if ($this->_echo) echo $out;
		else return $out;
		
	}
	
	// можно задать старт новой колонки явно
	function new_col($class = 'left', $style = '')
	{
		$this->cut_close_div = true; // флаг, чтобы не ставить лишний div в close()
		
		if ($style) $style = ' style="' . $style . '"';
			
		$out = NR . '<div class="' . $class 
				. ' column"' 
				. $style . '>'
				. '<div class="column-content">';
				
		if ($this->_echo) echo $out;
			else return $out;
	}
	
	
	// можно задать конец колонки явно
	function end_col()
	{
		if ($this->_echo) echo '</div></div>' . NR;
				else return '</div></div>' . NR;
	}	
	
	
	// подчистка float
	function clearfix()
	{
		if ($this->_echo) echo '<div class="clearfix"></div>' . NR;
				else return '<div class="clearfix"></div>' . NR;
	}	
	
} // end  class Columns 

# end file