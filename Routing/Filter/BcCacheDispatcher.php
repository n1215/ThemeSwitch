<?php
/**
 * [ThemeSwitch] BcCacheDispatcher
 * 
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2015, baserCMS Users Community <http://sites.google.com/site/baserusers/>
 *
 * @copyright		Copyright 2008 - 2015, baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			n1215.BcPlugins.theme_switch.Routing.Filter
 * @since			baserCMS v 3.0.7
 * @license			http://basercms.net/license/index.html
 */

// CUSTOMIZE ADD 2015/04/18 n1215
// >>>
App::uses('DispatcherFilter', 'Routing');
App::uses('ThemeSwitch', 'ThemeSwitch.Model');
// <<<

/**
 * This filter will check whether the response was previously cached in the file system
 * and served it back to the client if appropriate.
 */
class BcCacheDispatcher extends DispatcherFilter {

/**
 * Default priority for all methods in this filter
 * This filter should run before the request gets parsed by router
 *
 * @var int
 */
	// CUSTOMIZE MODIFY 2015/04/18 n1215
	// CacheDispatcherより優先度を上げる
	// >>>
	// public $priority = 10;
	// ---
	public $priority = 8;
	// <<<

/**
 * Checks whether the response was cached and set the body accordingly.
 *
 * @param CakeEvent $event containing the request and response object
 * @return CakeResponse with cached content if found, null otherwise
 */
	public function beforeDispatch(CakeEvent $event) {
		if (Configure::read('Cache.check') !== true) {
			return;
		}

		// CUSTOMIZE 2014/08/11 ryuring
		// $this->request->here で、URLを取得する際、URL末尾の 「index」の有無に関わらず
		// 同一ファイルを参照すべきだが、別々のURLを出力してしまう為、
		// 正規化された URLを取得するメソッドに変更
		// >>>
		//$path = $event->data['request']->here();
		// ---
		$path = $event->data['request']->normalizedHere();
		// <<<

		if ($path === '/') {
			// CUSTOMIZE MODIFY 2015/04/18 n1215
			// >>>
			// $path = 'home';
			// ---
			$path = 'index';
			// <<<
		}

		$prefix = Configure::read('Cache.viewPrefix');
		if ($prefix) {
			$path = $prefix . '_' . $path;
		}

		// CUSTOMIZE ADD 2015/04/18 n1215
		// UA判定用の文字列を後置
		// >>>
		$themeSwitch = ThemeSwitch::createFromContext();
		$suffix = $themeSwitch->cacheSuffix();
		// <<<

		$path = strtolower(Inflector::slug($path));

		// CUSTOMIZE MODIFY 2015/04/17 n1215
		// UA判定用の文字列を後置
		// >>>
		// $filename = CACHE . 'views' . DS . $path . '.php';
		// ---
		$filename = CACHE . 'views' . DS . $path . $suffix . '.php';
		// <<<

		if (!file_exists($filename)) {

			// CUSTOMIZE MODIFY 2015/04/17 n1215
			// UA判定用の文字列を後置
			// >>>
			// $filename = CACHE . 'views' . DS . $path . '_index.php';
			// ---
			$filename = CACHE . 'views' . DS . $path . '_index' . $suffix . '.php';
			// <<<
		}
		if (file_exists($filename)) {
			$controller = null;
			$view = new View($controller);
			$view->response = $event->data['response'];
			$result = $view->renderCache($filename, microtime(true));
			if ($result !== false) {
				$event->stopPropagation();
				$event->data['response']->body($result);
				return $event->data['response'];
			}
		}
	}

}
