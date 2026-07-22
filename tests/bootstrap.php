<?php
/**
 *
 * Sidebar Manager extension. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026 Vinny <https://github.com/vinny/phpbb-sidebar>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

// Dynamically locate the phpBB board root relative to this test file
$dir = __DIR__;
$board_root = null;

while ($dir && dirname($dir) !== $dir) {
	$dir = dirname($dir);
	if (file_exists($dir . '/tests/bootstrap.php') && is_dir($dir . '/phpBB')) {
		$board_root = $dir;
		break;
	}
}

if ($board_root) {
	set_include_path(get_include_path() . PATH_SEPARATOR . $board_root);
	require_once $board_root . '/tests/bootstrap.php';

	if (file_exists($board_root . '/tests/test_framework/phpbb_test_case.php')) {
		require_once $board_root . '/tests/test_framework/phpbb_test_case.php';
	}
} else if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
	require_once __DIR__ . '/../vendor/autoload.php';
}
