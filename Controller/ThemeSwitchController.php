<?php
/**
 * [ThemeSwitch]テーマスイッチコントローラ
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.6.0
 * @license    MIT License
 */

App::uses('ThemeSwitch', 'ThemeSwitch.Model');
App::uses('ThemeSwitchConfigValidator', 'ThemeSwitch.Model');

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
		array('name' => 'テーマスイッチ管理', 'url' => array('plugin' => 'theme_switch', 'controller' => 'theme_switch', 'action' => 'index'))
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
		$availableThemes = ThemeSwitch::getAvailableThemes();
		$themeList = array_combine($availableThemes, $availableThemes);
		$themeSwitch = ThemeSwitch::createFromContext();
        $this->set('csrfTokenKey', $this->Session->read('_Token.key'));
		$this->set('currentThemes', $themeSwitch->themes);
		$this->set('themeList', $themeList);
		$this->set('submitUrl', Router::url(array('plugin' => 'theme_switch', 'controller' => 'theme_switch', 'action' => 'admin_ajax_config')));
	}

/**
 * テーマスイッチの設定を更新
 *
 * @return string
 * @throws HttpRequestMethodException
 * @throws HttpInvalidParamException
 */
	public function admin_ajax_config() {
		$this->autoRender = false;
		$this->viewClass = 'json';

		//Ajaxリクエストのみ
		$this->request->onlyAllow('ajax');

		//POSTリクエストのみ
		if (!$this->request->is('post')) {
			throw new HttpRequestMethodException();
		}

		//POSTされたJSONデータを配列で取得
		$data = $this->request->data;

		if (empty($data)) {
			throw new HttpInvalidParamException();
		}

		//バリデーション
		$validator = ThemeSwitchConfigValidator::create();
		$errors = $validator->validate($data);

		//エラーがある場合
		if (count($errors) !== 0) {
			$this->response->statusCode(400);
			$jsonArray = array(
				'success' => false,
				'errors' => $errors
			);
			return json_encode($jsonArray);
		}

		//エラーのない場合
		$themeSwitch = ThemeSwitch::createFromContext();
		$themeSwitch->saveConfig($data);
		$jsonArray = array(
			'success' => true
		);

		return json_encode($jsonArray);
	}

}
