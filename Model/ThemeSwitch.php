<?php

/**
 * [ThemeSwitch]テーマスイッチ
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.5.0
 * @license    MIT License
 */
class ThemeSwitch {

/**
 * クラス名
 *
 * @var string
 */
	public $name = 'ThemeSwitch';

/**
 * コンストラクタ
 */
	public function __construct() {
		$this->themes = Configure::read('ThemeSwitch.themes');
		$this->agent = BcAgent::findCurrent();
	}

/**
 * 適用すべきテーマ名を取得
 *
 * @return string|null
 */
	public function getThemeName() {
		if (empty($this->themes) || empty($this->agent) || !array_key_exists($this->agent->name, $this->themes)) {
			return null;
		}

		return $this->themes[$this->agent->name];
	}
}
