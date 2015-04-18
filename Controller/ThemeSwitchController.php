<?php
/**
 * [ThemeSwitch]テーマスイッチコントローラ
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.5.0
 * @license    MIT License
 */

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
	public $components = array('BcAuth');

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
 * [ADMIN] 管理画面
 *
 * @return void
 * @access public
 */
	public function admin_index() {
		$this->pageTitle = 'テーマスイッチ設定';
	}

}
