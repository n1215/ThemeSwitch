<?php
/**
 * [ThemeSwitch]テーマスイッチ
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.7.0
 * @license    MIT License
 */

App::uses('BcAgent', 'Lib');
App::uses('ThemeSwitchConfigValidator', 'ThemeSwitch.Model');

class ThemeSwitchConfig {

/**
 * 設定ファイルの内部パス
 */
	const CONFIG_PATH = 'ThemeSwitch.themes';

/**
 * バリデーター
 * @var ThemeSwitchConfigValidator
 */
	public $validator = null;

/**
 * デフォルトの設定
 * @var array
 */
	protected $default = array(
		'smartphone' => '',
		'mobile' => ''
	);

/**
 * ファクトリーメソッド
 *
 * @return self
 */
	public static function create() {
		return new self(new ThemeSwitchConfigValidator(self::getAvailableThemes()));
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
 * @param ThemeSwitchConfigValidator $validator バリデーター
 */
	public function __construct(ThemeSwitchConfigValidator $validator = null) {
		$this->ensureFileExists();
		$this->validator = $validator;
	}

/**
 * 設定ファイルの有無をチェック
 *
 * @return bool
 */
	public function fileExists() {
		return file_exists($this->filePath());
	}

/**
 * 設定ファイルがなければ作成
 *
 * @return void
 */
	public function ensureFileExists() {
		if ($this->fileExists()) {
			return;
		}
		$this->save($this->default);
	}

/**
 * 設定ファイルのパスを返す
 *
 * @return string
 */
	public function filePath() {
		return APP . 'Plugin' . DS . 'ThemeSwitch' . DS . 'Config' . DS . 'themes.php';
	}

/**
 * 設定を取得
 *
 * @return array
 */
	public function read() {
		$reader = new PhpReader(self::CONFIG_PATH);
		return $reader->read(self::CONFIG_PATH);
	}

/**
 * 設定をファイルに保存
 *
 * @param array $data 保存するデータ
 * @return void
 */
	public function save($data) {
		$reader = new PhpReader(self::CONFIG_PATH);

		$config = array(
			'smartphone' => $data['smartphone'],
			'mobile' => $data['mobile']
		);
		$reader->dump(self::CONFIG_PATH, $config);
		clearViewCache();
	}
}
