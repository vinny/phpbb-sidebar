<?php
/**
 *
 * Sidebar Manager extension. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026 Vinny <https://github.com/vinny/phpbb-sidebar>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace vinny\sidebar\migrations;

class v110 extends \phpbb\db\migration\migration
{
	/**
	 * Defines dependencies for this migration.
	 *
	 * @return array
	 */
	public static function depends_on()
	{
		return [
			'\vinny\sidebar\migrations\v100_initial',
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
			'add_columns' => [
				$this->table_prefix . 'vinny_sidebar_blocks' => [
					'block_parse_bbcode'	=> ['BOOL', 1],
					'bbcode_uid'			=> ['VCHAR:8', ''],
					'bbcode_bitfield'		=> ['VCHAR:255', ''],
					'bbcode_options'		=> ['UINT', 7],
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
			'drop_columns' => [
				$this->table_prefix . 'vinny_sidebar_blocks' => [
					'block_parse_bbcode',
					'bbcode_uid',
					'bbcode_bitfield',
					'bbcode_options',
				],
			],
		];
	}
}
