<?php
/**
 * [ThemeSwitch]テーマスイッチ バリデーター用の基底クラス
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.7.0
 * @license    MIT License
 */

App::uses('CakeValidationSet', 'Model/Validator');

class ThemeSwitchBaseValidator {

/**
 * バリデーションルール
 * @var array
 */
	protected $rules = array();

/**
 * バリデーションセット
 * @var CakeValidationSet[]
 */
	protected $validationSets = array();

/**
 * 追加で利用するバリデーション用のメソッド名
 * @var array
 */
	protected $methods = array();

/**
 * コンストラクタ
 *
 * @param array $rules バリデーションルール
 * @param array $methods 追加で利用するバリデーションのメソッド名
 */
	public function __construct(array $rules = array(), array $methods = array()) {
		$this->rules = array_merge($this->rules, $rules);
		$this->methods = array_merge($this->methods, $methods);
		$this->validationSets = $this->makeValidationSets();
	}

/**
 * CakeValidationSetの連想配列を生成
 *
 * @return CakeValidationSet[]
 */
	protected function makeValidationSets() {
		$sets = array();
		foreach ($this->rules as $field => $rules) {
			$sets[] = $this->createValidationSet($field, $rules);
		}
		return $sets;
	}

/**
 * バリデーション用のメソッドを付け加えてCakeValidationSetを生成
 *
 * @param string $field フィールド
 * @param array $rules ルール
 * @return CakeValidationSet
 */
	protected function createValidationSet($field, $rules) {
		$set = new CakeValidationSet($field, $rules);
		$methods = array();
		foreach ($this->methods as $method) {
			$methods[strtolower($method)] = array($this, $method);
		}
		$set->setMethods($methods);
		return $set;
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
			if (count($error) === 0) {
				continue;
			}
			$errors[$set->field] = $set->validate($data);
		}
		return $errors;
	}
}
