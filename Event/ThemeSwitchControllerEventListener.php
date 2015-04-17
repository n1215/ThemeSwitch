<?php

/**
 * [ThemeSwitch]ThemeSwitchコントローライベントリスナー
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.5.0
 * @license    MIT License
 */
class ThemeSwitchControllerEventListener extends BcControllerEventListener {

/**
 * 登録イベント
 *
 * @var array
 */
	public $events = array(
		'beforeRender'
	);

/**
 * beforeRender
 *
 * @param CakeEvent $event
 * @return void
 */
	public function beforeRender(CakeEvent $event) {
		$controller = $event->subject();
		$request = $controller->request;

		//管理画面なら何もしない
		if ($request->is('admin')) {
			return;
		}

		if (ClassRegistry::isKeySet('ThemeSwitch.ThemeSwitch')) {
			$ThemeSwitch = ClassRegistry::getObject('ThemeSwitch.ThemeSwitch');
		} else {
			$ThemeSwitch = ClassRegistry::init('ThemeSwitch.ThemeSwitch');
		}

		$theme = $ThemeSwitch->getThemeName();

		if ($theme !== null) {
			$controller->theme = $theme;
		}
	}

}
