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

App::uses('CakeValidationSet', 'Model/Validator');
App::uses('ThemeSwitch', 'ThemeSwitch.Model');

class ThemeSwitchConfigValidator {

/**
 * 利用できるテーマ名の配列
 * @var array
 */
	protected $themes = null;

/**
 * バリデーションセット
 * @var CakeValidationSet[]
 */
	protected $validationSets = array();

/**
 * 現在のコンテクストから生成
 *
 * @return self
 */
	public static function create() {
		return new self(ThemeSwitch::getAvailableThemes());
	}

/**
 * コンストラクタ
 *
 * @param array $themes テーマ設定の配列
 */
	public function __construct(array $themes) {
		$this->themes = $themes;
		$this->validationSets = $this->makeValidationSets();
	}

/**
 * バリデーションルールを生成
 *
 * @return array
 */
	protected function getRules() {
		return array(
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
	}

/**
 * CakeValidationSetの連想配列を生成
 *
 * @return CakeValidationSet[]
 */
	protected function makeValidationSets() {
		$sets = array();
		foreach ($this->getRules() as $field => $rules) {
			$set = new CakeValidationSet($field, $rules);
			$methods = array('themeavailable' => array($this, 'themeAvailable'));
			$set->setMethods($methods);
			$sets[] = $set;
		}
		return $sets;
	}

/**
 * バリデーション実行
 *
 * @param array $data 対象データの配列
 * @return array $errors エラー
 */
	public function validate($data) {
		$errors = array();
		foreach ($this->validationSets as $set) {
			$error = $set->validate($data);
			if (count($error) == 0) {
				continue;
			}
			$errors[$set->field] = $set->validate($data);
		}
		return $errors;
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
