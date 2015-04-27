<?php
/**
 * [ThemeSwitch]テーマスイッチのシステムナビ
 *
 * @copyright Copyright 2015 - , n1215
 * @link       http://github.com/n1215
 * @package    n1215.bcplugins.theme_switch
 * @since      baserCMS v 3.0.7
 * @version    0.7.1
 * @license    MIT License
 */

$config['BcApp.adminNavi.theme_switch'] = array(
	'name' => 'テーマスイッチプラグイン',
	'contents' => array(
		array('name' => '設定', 'url' => array('admin' => true, 'plugin' => 'theme_switch', 'controller' => 'theme_switch', 'action' => 'index'))
	)
);

App::build(array(
	'View/Helper' => array( dirname(__FILE__) . DS . '..' . DS . 'View' . DS . 'Helper' . DS ),
	'Routing/Filter' => array( dirname(__FILE__) . DS . '..' . DS . 'Routing' . DS . 'Filter' . DS )
), App::PREPEND);