<?php
/**
 * [ThemeSwitch]テーマスイッチコントローラ
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.7.1
 * @license    MIT License
 */

App::uses('ThemeSwitch', 'ThemeSwitch.Model');
App::uses('ThemeSwitchConfig', 'ThemeSwitch.Model');

class ThemeSwitchController extends BcPluginAppController {

/**
 * クラス名
 *
 * @var string
 */
	public $name = 'ThemeSwitch';

/**
 * コンポーネント
 *
 * @var array
 */
	public $components = array('BcAuth', 'Cookie', 'BcAuthConfigure');

/**
 * サブメニューエレメント
 *
 * @var array
 */
	public $subMenuElements = array('theme_switch');

/**
 * パンくずナビ
 *
 * @var array
 */
	public $crumbs = array(
		array('name' => 'プラグイン管理', 'url' => array('plugin' => '', 'controller' => 'plugins', 'action' => 'index')),
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Security->csrfCheck = true;
		$this->Security->csrfUseOnce = false;
	}

/**
 * [ADMIN] 管理画面
 *
 * @return void
 */
	public function admin_index() {
		$this->pageTitle = 'テーマスイッチ設定';
		$themeSwitch = ThemeSwitch::createFromContext();
		$this->set(array(
			'csrfTokenKey' => $this->Session->read('_Token.key'),
			'currentThemes' => $themeSwitch->themes,
			'themeList' => $themeSwitch->getAllThemeList(),
			'submitUrl' => Router::url(array('action' => 'admin_config'))
		));
	}

/**
 * テーマスイッチの設定を更新
 *
 * @return string
 * @throws HttpRequestMethodException
 * @throws HttpInvalidParamException
 */
	public function admin_config() {
		$this->autoRender = false;
		$this->viewClass = 'json';

		//POSTかつAjaxかつデータが空でない事を確認
		if (!$this->request->isAll(array('post', 'ajax'))
			|| empty($this->request->data)) {
			$this->response->statusCode(400);
			return json_encode(array(
				'success' => false,
				'message' => '400 Invalid Request'
			));
		}

		//バリデーション
		$config = ThemeSwitchConfig::create();
		$errors = $config->validator->validate($this->request->data);

		//エラーがある場合
		if (count($errors) > 0) {
			$this->response->statusCode(400);
			return json_encode(array(
				'success' => false,
				'errors' => $errors
			));
		}

		//エラーのない場合
		$config->save($this->request->data);

		return json_encode(array(
			'success' => true
		));
	}

}
