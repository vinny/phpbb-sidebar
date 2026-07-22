<?php
/**
 *
 * Sidebar Manager extension. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026 Vinny <https://github.com/vinny/phpbb-sidebar>
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'VINNY_SIDEBAR_EXPLAIN'			=> 'Here you can manage the sidebars and their blocks. Note that system blocks cannot be deleted, as their content is generated dynamically by code logic.',

	// Settings
	'VINNY_SIDEBAR_ENABLE'			=> 'Enable Sidebar functionality',
	'VINNY_SIDEBAR_ENABLE_EXPLAIN'	=> 'A global switch to enable or disable the entire sidebar system.',
	'VINNY_SIDEBAR_LEFT_ENABLE'		=> 'Enable Left Sidebar',
	'VINNY_SIDEBAR_RIGHT_ENABLE'	=> 'Enable Right Sidebar',
	'VINNY_SIDEBAR_HIDE_TOGGLES'			=> 'Hide toggle buttons',
	'VINNY_SIDEBAR_HIDE_TOGGLES_EXPLAIN'	=> 'If enabled, the buttons that allow users to show/hide the sidebar will not be displayed, preventing them from collapsing the sidebar.',

	// Logs
	'LOG_VINNY_SIDEBAR_SETTINGS'		=> '<strong>Sidebar Manager settings updated</strong>',
	'LOG_VINNY_SIDEBAR_BLOCK_ADDED'		=> '<strong>Sidebar block added</strong><br />» %s',
	'LOG_VINNY_SIDEBAR_BLOCK_UPDATED'	=> '<strong>Sidebar block updated</strong><br />» %s',
	'LOG_VINNY_SIDEBAR_BLOCK_DELETED'	=> '<strong>Sidebar block deleted</strong><br />» %s',
	'LOG_VINNY_SIDEBAR_CACHE_PURGED'	=> '<strong>Sidebar cache purged</strong>',

	// Cache & Actions
	'PURGE_SIDEBAR_CACHE'				=> 'Purge Sidebar Cache',
	'SIDEBAR_CACHE_PURGED'				=> 'Sidebar cache was successfully purged.',
	'BLOCKS_STATUS_SUMMARY'				=> '%1$d active, %2$d disabled',

	// Blocks
	'ACP_VINNY_SIDEBAR_BLOCK_ADD'	=> 'Add Custom Block',
	'ACP_VINNY_SIDEBAR_BLOCK_EDIT'	=> 'Edit Block',
	'BLOCK_NAME'					=> 'Block Name',
	'PARSE_BBCODE'					=> 'Parse BBCode',
	'PARSE_BBCODE_EXPLAIN'			=> 'If enabled, BBCode formatting, smilies, and URLs will be parsed for this block. If disabled, raw trusted HTML code is rendered directly.',
	'BLOCK_SIDE'					=> 'Sidebar Side',
	'BLOCK_SIDE_LEFT'				=> 'Left Sidebar',
	'BLOCK_SIDE_RIGHT'				=> 'Right Sidebar',
	'BLOCK_MOVE_TO'					=> 'Move to',
	'BLOCK_DRAG_DROP'				=> 'Drag & Drop',
	'BLOCK_CONTENT'					=> 'Block Content',
	'BLOCK_CONTENT_EXPLAIN'			=> 'Enter the content for this block. For BBCode blocks, standard BBCode formatting, smilies, and links are supported. For HTML blocks, trusted HTML code is rendered directly, so only trusted administrators should add scripts, iframes, forms, or third-party widgets.',
	'BLOCK_TRUSTED_HTML_WARNING'	=> 'Only add HTML from trusted sources. Scripts, iframes, forms, and third-party widgets can affect visitors, load external resources, or interact with cookies and tracking systems.',
	'BLOCK_PREVIEW'					=> 'Preview',
	'BLOCK_PREVIEW_CONTENT_PLACEHOLDER'	=> 'Forum content area preview',
	'BLOCK_ANALYSIS'				=> 'HTML analysis',
	'BLOCK_ANALYSE_HTML'			=> 'Analyse HTML',
	'BLOCK_ENABLED'					=> 'Enabled',
	'BLOCK_EXCLUDE_PAGES'			=> 'Exclude from pages',
	'BLOCK_EXCLUDE_PAGES_EXPLAIN'	=> 'Select the pages where this block should NOT be shown. Press and hold CTRL to select multiple pages.', // (e.g., all, index, viewforum, viewtopic).',
	'SIDEBAR_PAGE_INDEX'			=> 'Index page',
	'SIDEBAR_PAGE_VIEWFORUM'		=> 'Forum pages',
	'SIDEBAR_PAGE_VIEWTOPIC'		=> 'Topic pages',
	'SIDEBAR_PAGE_POSTING'			=> 'Posting pages',
	'SIDEBAR_PAGE_UCP'				=> 'User Control Panel',
	'SIDEBAR_PAGE_MCP'				=> 'Moderator Control Panel',
	'SIDEBAR_PAGE_SEARCH'			=> 'Search page',
	'SIDEBAR_PAGE_MEMBERLIST'		=> 'Member list',
	'SIDEBAR_PAGE_VIEWONLINE'		=> 'Who is online page',

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
	'BLOCK_NAME_TOO_LONG'			=> 'The block name must not be longer than 255 characters.',
	'BLOCK_CONTENT_EMPTY'			=> 'The block content cannot be empty.',
	'BLOCK_CONTENT_ILLEGAL_CHARS'	=> 'The block code contains unsupported characters (invalid for this database).',
	'INVALID_SIDEBAR_SIDE'			=> 'The selected sidebar side is invalid.',
	'BLOCK_ANALYSIS_NO_ISSUES'		=> 'No common HTML issues were detected.',
	'BLOCK_ANALYSIS_ALERT_USAGE'	=> 'The HTML contains alert(). This is usually debugging code and should be removed before publishing.',
	'BLOCK_ANALYSIS_LOCATION_CHANGE'=> 'The HTML changes location.href. This can redirect users and should only be used when intentionally trusted.',
	'BLOCK_ANALYSIS_SCRIPT_WITHOUT_ASYNC'	=> 'The HTML loads an external script without async. Consider adding async to avoid blocking page rendering.',
	'BLOCK_ANALYSIS_UNTRUSTED_CONNECTION'	=> 'The board appears to use HTTPS, but this HTML loads content over HTTP. Use HTTPS resources to avoid mixed-content warnings.',
	'BLOCK_ANALYSIS_EXTERNAL_RESOURCE'	=> 'The HTML loads external resources. Confirm that the source is trusted and respects your privacy policy.',
	'BLOCK_ANALYSIS_IFRAME'			=> 'The HTML contains an iframe. Confirm that the embedded source is trusted.',
	'BLOCK_ANALYSIS_FORM'			=> 'The HTML contains a form. Confirm that it submits only to a trusted destination and does not collect sensitive data unexpectedly.',
	'BLOCK_ANALYSIS_INLINE_EVENT'	=> 'The HTML contains inline JavaScript event attributes such as onclick, onload, or onerror. Confirm that this code is trusted.',
	'BLOCK_ANALYSIS_JAVASCRIPT_URI'	=> 'The HTML contains a javascript: URL. Confirm that this code is trusted before publishing.',
]);
