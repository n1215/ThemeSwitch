<?php
/**
 * [ThemeSwitch]テーマスイッチ
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.7.1
 * @license    MIT License
 */

App::uses('BcAgent', 'Lib');
App::uses('ThemeSwitchConfig', 'ThemeSwitch.Model');

class ThemeSwitch {

/**
 * テーマ設定の配列
 * @var array
 */
	public $themes = array();

/**
 * ユーザーエージェント
 * @var BcAgent
 */
	protected $agent = null;

/**
 * 設定用クラス
 * @var ThemeSwitchConfig
 */
	public $config = null;

/**
 * 現在のコンテクストから生成
 *
 * @return self
 */
	public static function createFromContext() {
		$config = ThemeSwitchConfig::create();
		return new self($config->read(), BcAgent::findCurrent());
	}

/**
 * コンストラクタ
 *
 * @param array $themes テーマ設定の配列
 * @param BcAgent $agent ユーザーエージェント
 */
	public function __construct(array $themes = null, BcAgent $agent = null) {
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
/**
 * テーマのリストを取得
 *
 * @return array
 */
	public function getAllThemeList() {
		$availableThemes = ThemeSwitchConfig::getAvailableThemes();
		return array_combine($availableThemes, $availableThemes);
	}

/**
 * キャッシュのファイル名の接尾辞を生成
 *
 * @return string
 */
	public function cacheSuffix() {
		if ($this->agent === null) {
			return '';
		}
		return '_theme_switch_' . $this->agent->name;
	}
}
