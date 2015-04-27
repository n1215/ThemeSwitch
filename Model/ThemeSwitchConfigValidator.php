<?php
/**
 * [ThemeSwitch]テーマスイッチ 設定のバリデーター
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.7.1
 * @license    MIT License
 */

App::uses('ThemeSwitch', 'ThemeSwitch.Model');
App::uses('ThemeSwitchBaseValidator', 'ThemeSwitch.Model');

class ThemeSwitchConfigValidator extends ThemeSwitchBaseValidator {

/**
 * バリデーションルール
 * @var array
 */
	protected $rules = array(
		'smartphone' => array(
			array(
				'rule' => 'notEmpty',
				'message' => 'スマートフォン用のテーマを選択してください',
				'required' => true
			),
			array(
				'rule' => 'themeAvailable',
				'message' => 'テーマが見つかりません',
				'required' => true
			)
		),
		'mobile' => array(
			array(
				'rule' => 'notEmpty',
				'message' => 'モバイル用のテーマを選択してください',
				'required' => true
			),
			array(
				'rule' => 'themeAvailable',
				'message' => 'テーマが見つかりません',
				'required' => true
			)
		)
	);

/**
 * 追加で利用するバリデーション用のメソッド
 * @var array
 */
	protected $methods = array('themeAvailable');

/**
 * 利用できるテーマ名の配列
 * @var array
 */
	protected $themes = null;

/**
 * コンストラクタ
 *
 * @param array $themes テーマ設定の配列
 */
	public function __construct(array $themes) {
		$this->themes = $themes;
		parent::__construct();
	}

/**
 * テーマが利用可能かどうかをチェック
 *
 * @param array $check チェック対象文字列
 * @return	bool
 */
	public function themeAvailable($check) {
		if (!$check[key($check)]) {
			return false;
		}

		return in_array($check[key($check)], $this->themes);
	}
}
