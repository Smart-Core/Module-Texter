<?php

namespace SmartCore\Module\Texter\Controller;

use SmartCore\Bundle\EngineBundle\Engine\Module;

class Texter extends Module
{
	/**
	 * Для каждого экземпляра ноды хранится ИД текстовой записи.
	 * @var int
	 */
	protected $text_item_id;

	/**
	 * Какой редактор использовать.
	 * !!!note: пока используется как флаг, где 0 - не использовать визивиг, а 1 - использовать.
	 * @var string
	 */
	protected $editor;
	
	/**
	 * Конструктор.
	 * 
	 * @return void
	 */
	protected function init()
	{
		//$this->setVersion(0.4);
		
		$this->NodeProperties->setDefaultParams(array(
			'text_item_id'	=> 0,
			'editor'		=> 1,
		));

		/*
		$this->View->setOptions(array(
			'engine'		=> 'simple',
			'template_ext' => '.tpl',
		));
		*/
		$this->View->setRenderMethod('echoProperties');
	}

	/**
	 * Эекшен по умолчанию.
	 * 
	 * @todo подумать как лучше его называть? в CMF-ке сейчас run($parser_data).
	 */
//	public function run()
//	public function defaultAction()
	public function indexAction()
	{
		$text_item = $this->getText($this->text_item_id);

		if (is_array($text_item['meta']) and !empty($text_item['meta'])) {
			foreach ($text_item['meta'] as $key => $value) {
				$this->Html->meta($key, $value);
			}
		}
		
		$this->View->text = $text_item['text'];
	}
	
	/**
	 * Получение текста из базы.
	 * 
	 * @uses Log
	 * 
	 * @param int $item_id
	 * @return text
	 * 
	 * @todo мультиязычность.
	 * @todo вынести в Модель.
	 */
	protected function getText($item_id)
	{
		$sql = "SELECT text, item_id, meta
			FROM {$this->DB->prefix()}text_items
			WHERE item_id = '$item_id'
			AND language_id = 'ru'
			AND site_id = '{$this->Site->getId()}' ";
		if ($row = $this->DB->fetchAssoc($sql)) {
			if (isset($row['meta']) and ! empty($row['meta'])) {
				$row['meta'] = unserialize($row['meta']);
			}
			return $row;
		} else {
			// @todo сделать нормальный логгер системных ошибок с применением debug_backtrace()
			$stack = "\nFile: " . __FILE__ . "\nLine: ". __LINE__ . "\nClass: " . __CLASS__ . "\nMethod: " . __METHOD__;
			//Log::getInstance()->write('system', "Message: item_id = $item_id is not accessible. $stack");
			return false;
		}
	}	
}