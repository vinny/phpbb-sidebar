<?php
/**
 *
 * @package phpBB Extension - vinny/sidebar
 * @copyright (c) Vinny
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
