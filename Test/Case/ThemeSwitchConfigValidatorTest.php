<?php
/**
 * [ThemeSwitch]ThemeSwitchConfigValidatorのテスト
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.6.0
 * @license    MIT License
 */

App::uses('ThemeSwitchConfigValidator', 'ThemeSwitch.Model');

/**
 * Test class for ThemeSwitchConfigValidator
 */
class ThemeSwitchConfigValidatorTest extends BaserTestCase {


/**
 * @var ThemeSwitchConfigValidator
 */
	protected $validator;

/**
 * Set up
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$themesAvailable = array('m-single', 'nada-icons');
		$this->validator = new ThemeSwitchConfigValidator($themesAvailable);
	}

/**
 * バリデーションのテスト
 *
 * @param array $expected 期待値
 * @param array $data 入力データ
 * @return void
 * @dataProvider validateDataProvider
 */
	public function testValidate($expected, $data) {
		$actual = $this->validator->validate($data);
		$this->assertEquals($expected, $actual);
	}

/**
 * validate用データプロバイダ
 *
 * @return array
 */
	public function validateDataProvider() {
		return array(
			array(array(), array('smartphone' => 'm-single', 'mobile' => 'nada-icons')),
			array(
				array(
					'smartphone' => array('テーマが見つかりません'),
					'mobile' => array('モバイル用のテーマを選択してください')
				),
				array('smartphone' => 'unavailable', 'mobile' => ''))
		);
	}

}
