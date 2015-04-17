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
 * テーマ設定の配列
 * @var array
 */
	protected $themes;

/**
 * ユーザーエージェント
 * @var BcAgent
 */
	protected $agent;

/**
 * 現在のコンテクストから生成
 *
 * @return self
 */
	public static function createFromContext() {
		return new self(Configure::read('ThemeSwitch.themes'), BcAgent::findCurrent());
	}

/**
 * コンストラクタ
 *
 * @param array $themes テーマ設定の配列
 * @param BcAgent $agent ユーザーエージェント
 */
	public function __construct(array $themes, BcAgent $agent = null) {
		$this->themes = $themes;
		$this->agent = $agent;
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
