<?php
/**
 *
 * Sidebar Manager extension. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026 Vinny <https://github.com/vinny/phpbb-sidebar>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace vinny\sidebar\acp;

class sidebar_info
{
	public function module()
	{
		return [
			'filename'	=> '\vinny\sidebar\acp\sidebar_module',
			'title'		=> 'ACP_VINNY_SIDEBAR',
			'modes'		=> [
				'settings'	=> [
					'title'	=> 'ACP_VINNY_SIDEBAR_SETTINGS',
					'auth'	=> 'ext_vinny/sidebar',
					'cat'	=> ['ACP_VINNY_SIDEBAR']
				],
				'blocks'	=> [
					'title'	=> 'ACP_VINNY_SIDEBAR_BLOCKS',
					'auth'	=> 'ext_vinny/sidebar',
					'cat'	=> ['ACP_VINNY_SIDEBAR']
				],
			],
		];
	}
}
