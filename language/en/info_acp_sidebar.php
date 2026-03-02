<?php
/**
 *
 * @package phpBB Extension - vinny/sidebar
 * @copyright (c) Vinny
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_VINNY_SIDEBAR'				=> 'Sidebar Manager',
	'ACP_VINNY_SIDEBAR_SETTINGS'	=> 'Settings',
	'ACP_VINNY_SIDEBAR_BLOCKS'		=> 'Manage Blocks',
	
	'VINNY_SIDEBAR'					=> 'Sidebar Manager',
	'VINNY_SIDEBAR_EXPLAIN'			=> 'Here you can manage the sidebars and their blocks.',
	
	// Settings
	'VINNY_SIDEBAR_ENABLE'			=> 'Enable Sidebar functionality',
	'VINNY_SIDEBAR_ENABLE_EXPLAIN'	=> 'A global switch to enable or disable the entire sidebar system.',
	'VINNY_SIDEBAR_LEFT_ENABLE'		=> 'Enable Left Sidebar',
	'VINNY_SIDEBAR_RIGHT_ENABLE'	=> 'Enable Right Sidebar',
	'VINNY_SIDEBAR_HIDE_TOGGLES'			=> 'Hide toggle buttons',
	'VINNY_SIDEBAR_HIDE_TOGGLES_EXPLAIN'	=> 'If enabled, the buttons that allow users to show/hide the sidebar will not be displayed, preventing them from collapsing the sidebar.',
	
	// Logs
	'LOG_VINNY_SIDEBAR_SETTINGS'	=> '<strong>Sidebar Manager settings updated</strong>',
	
	// Blocks
	'ACP_VINNY_SIDEBAR_BLOCK_ADD'	=> 'Add Custom Block',
	'ACP_VINNY_SIDEBAR_BLOCK_EDIT'	=> 'Edit Block',
	'BLOCK_NAME'					=> 'Block Name',
	'BLOCK_SIDE'					=> 'Sidebar Side',
	'BLOCK_SIDE_LEFT'				=> 'Left Sidebar',
	'BLOCK_SIDE_RIGHT'				=> 'Right Sidebar',
	'BLOCK_MOVE_TO'					=> 'Move to',
	'BLOCK_DRAG_DROP'				=> 'Drag & Drop',
	'BLOCK_CONTENT'					=> 'Block Content',
	'BLOCK_CONTENT_EXPLAIN'			=> 'Enter the custom code for this block here. All code must use HTML markup, BBCodes are not supported.',
	'BLOCK_ENABLED'					=> 'Enabled',
	'BLOCK_ORDER'					=> 'Order Position',
	'BLOCK_EXCLUDE_PAGES'			=> 'Exclude from pages',
	'BLOCK_EXCLUDE_PAGES_EXPLAIN'	=> 'Select the pages where this block should NOT be shown. Press and hold CTRL to select multiple pages.', // (e.g., all, index, viewforum, viewtopic).',
	
	'VINNY_SIDEBAR_CLOCK_FORMAT'	=> 'Clock Format',
	'VINNY_SIDEBAR_CLOCK_FORMAT_EXPLAIN' => 'Choose between 24-hour and AM/PM format for the Clock block.',
	'VINNY_SIDEBAR_CLOCK_24H'		=> '24 hour (00:00:00)',
	'VINNY_SIDEBAR_CLOCK_AMPM'		=> 'AM/PM (12:00:00 AM)',

	'BLOCK_ADDED'					=> 'Block successfully added.',
	'BLOCK_UPDATED'					=> 'Block successfully updated.',
	'BLOCK_DELETED'					=> 'Block successfully deleted.',
	'NO_BLOCKS'						=> 'No blocks found. Click "Add Custom Block" to create one.',
	'CONFIRM_DELETE_BLOCK'			=> 'Are you sure you want to delete this block?',

	'CANNOT_EDIT_SYSTEM_BLOCK'		=> 'You cannot edit a system protected block. Its content is managed by the extension logic.',
	'CANNOT_DELETE_SYSTEM_BLOCK'	=> 'You cannot delete a system protected block.',
	'BLOCK_NAME_EMPTY'				=> 'The block name cannot be empty.',
	'BLOCK_CONTENT_EMPTY'			=> 'The block content cannot be empty.',
	'BLOCK_CONTENT_ILLEGAL_CHARS'	=> 'The block code contains unsupported characters (invalid for this database).',
]);
