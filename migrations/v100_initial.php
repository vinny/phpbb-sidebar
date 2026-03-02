<?php
/**
 *
 * @package phpBB Extension - vinny/sidebar
 * @copyright (c) Vinny
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace vinny\sidebar\migrations;

class v100_initial extends \phpbb\db\migration\migration
{
	/**
	 * Defines dependencies for this migration.
	 *
	 * @return array
	 */
	public function effectively_installed()
	{
		return isset($this->config['vinny_sidebar_version']) && version_compare($this->config['vinny_sidebar_version'], '1.0.0', '>=');
	}

	/**
	 * Defines the name of the migration
	 *
	 * @return array
	 */
	public static function depends_on()
	{
		return [
			'\phpbb\db\migration\data\v330\v330', // Require phpBB 3.3.0
		];
	}

	/**
	 * Updates the database schema
	 *
	 * @return array
	 */
	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'vinny_sidebar_blocks' => [
					'COLUMNS' => [
						'block_id'			=> ['UINT', null, 'auto_increment'],
						'block_name'		=> ['VCHAR:255', ''], // internal name/title
						'block_content'		=> ['TEXT_UNI', ''], // HTML content for custom blocks
						'sidebar_side'		=> ['VCHAR:10', 'left'], // 'left' or 'right'
						'block_order'		=> ['USINT', 0], // Position order
						'block_enabled'		=> ['BOOL', 1],
						'block_is_system'	=> ['BOOL', 0],
					],
					'PRIMARY_KEY' => 'block_id',
				],
			],
		];
	}

	/**
	 * Reverts the database schema
	 *
	 * @return array
	 */
	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'vinny_sidebar_blocks',
			],
		];
	}

	/**
	 * Updates the database data
	 *
	 * @return array
	 */
	public function update_data()
	{
		return [
			// Config
			['config.add', ['vinny_sidebar_version', '1.0.0']],
			['config.add', ['vinny_sidebar_enable', 1]],
			['config.add', ['vinny_sidebar_left_enable', 1]],
			['config.add', ['vinny_sidebar_right_enable', 1]],
			['config.add', ['vinny_sidebar_exclude_pages', '']],
			['config.add', ['vinny_sidebar_clock_format', '24']],
			['config.add', ['vinny_sidebar_hide_toggles', 0]],

			// Module Setup
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_VINNY_SIDEBAR'
			]],
			['module.add', [
				'acp',
				'ACP_VINNY_SIDEBAR',
				[
					'module_basename'	=> '\vinny\sidebar\acp\sidebar_module',
					'modes'				=> ['settings', 'blocks'],
				],
			]],

			// Default blocks
			['custom', [[$this, 'insert_default_blocks']]],
		];
	}

	/**
	 * Reverts the database data
	 *
	 * @return array
	 */
	public function revert_data()
	{
		return [
			['config.remove', ['vinny_sidebar_version']],
			['config.remove', ['vinny_sidebar_enable']],
			['config.remove', ['vinny_sidebar_left_enable']],
			['config.remove', ['vinny_sidebar_right_enable']],
			['config.remove', ['vinny_sidebar_exclude_pages']],
			['config.remove', ['vinny_sidebar_clock_format']],
			['config.remove', ['vinny_sidebar_hide_toggles']],
		];
	}

	/**
	 * Custom function to insert predefined default blocks into the database
	 */
	public function insert_default_blocks()
	{
		$blocks_table = $this->table_prefix . 'vinny_sidebar_blocks';

		$default_blocks = [
			// Right Sidebar Blocks
			[
				'block_name'	=> 'SIDEBAR_WELCOME',
				'block_content'	=> '',
				'sidebar_side'	=> 'right',
				'block_order'	=> 10,
				'block_enabled'	=> 1,
				'block_is_system' => 1,
			],
			[
				'block_name'	=> 'SIDEBAR_RECENT_POSTS',
				'block_content'	=> '',
				'sidebar_side'	=> 'right',
				'block_order'	=> 20,
				'block_enabled'	=> 1,
				'block_is_system' => 1,
			],
			[
				'block_name'	=> 'SIDEBAR_RECENT_TOPICS',
				'block_content'	=> '',
				'sidebar_side'	=> 'right',
				'block_order'	=> 30,
				'block_enabled'	=> 1,
				'block_is_system' => 1,
			],
			[
				'block_name'	=> 'SIDEBAR_STATISTICS',
				'block_content'	=> '',
				'sidebar_side'	=> 'right',
				'block_order'	=> 40,
				'block_enabled'	=> 1,
				'block_is_system' => 1,
			],

			// Left Sidebar Blocks
			[
				'block_name'	=> 'SIDEBAR_MENU',
				'block_content'	=> '',
				'sidebar_side'	=> 'left',
				'block_order'	=> 10,
				'block_enabled'	=> 1,
				'block_is_system' => 1,
			],
			[
				'block_name'	=> 'SIDEBAR_CALENDAR',
				'block_content'	=> '',
				'sidebar_side'	=> 'left',
				'block_order'	=> 20,
				'block_enabled'	=> 1,
				'block_is_system' => 1,
			],
			[
				'block_name'	=> 'SIDEBAR_CLOCK',
				'block_content'	=> '',
				'sidebar_side'	=> 'left',
				'block_order'	=> 30,
				'block_enabled'	=> 1,
				'block_is_system' => 1,
			],
			[
				'block_name'	=> 'SIDEBAR_SEARCH',
				'block_content'	=> '',
				'sidebar_side'	=> 'left',
				'block_order'	=> 40,
				'block_enabled'	=> 1,
				'block_is_system' => 1,
			],
			[
				'block_name'	=> 'SIDEBAR_NEWEST_MEMBER',
				'block_content'	=> '',
				'sidebar_side'	=> 'left',
				'block_order'	=> 50,
				'block_enabled'	=> 1,
				'block_is_system' => 1,
			],
		];

		foreach ($default_blocks as $block)
		{
			$sql = 'SELECT block_id FROM ' . $blocks_table . ' WHERE block_name = \'' . $this->db->sql_escape($block['block_name']) . '\'';
			$result = $this->db->sql_query($sql);
			if (!$this->db->sql_fetchrow($result))
			{
				$sql_insert = 'INSERT INTO ' . $blocks_table . ' ' . $this->db->sql_build_array('INSERT', $block);
				$this->db->sql_query($sql_insert);
			}
			$this->db->sql_freeresult($result);
		}
	}
}
