<?php
/**
 * [ThemeSwitch]テーマスイッチ
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.6.0
 * @license    MIT License
 */

App::uses('BcAgent', 'Lib');

class ThemeSwitch {

/**
 * 設定ファイルのパス
 */
	const CONFIG_PATH = 'ThemeSwitch.themes';

/**
 * テーマ設定の配列
 * @var array
 */
	public $themes;

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
		$reader = new PhpReader(self::CONFIG_PATH);
		$themes = $reader->read(self::CONFIG_PATH);
		return new self($themes, BcAgent::findCurrent());
	}

/**
 * 利用可能なテーマの配列を返す
 *
 * @return array
 */
	public static function getAvailableThemes() {
		$path = WWW_ROOT . 'theme';
		$folder = new Folder($path);
		$files = $folder->read(true, true);
		return $files[0];
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

/**
 * 設定をファイルに保存
 *
 * @param array $data 保存するデータ
 * @return void
 */
	public function saveConfig($data) {
		$reader = new PhpReader(self::CONFIG_PATH);

		$config = array(
			'smartphone' => $data['smartphone'],
			'mobile' => $data['mobile']
		);
		$reader->dump(self::CONFIG_PATH, $config);
	}
}
