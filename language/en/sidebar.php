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

	// Default blocks titles
	'SIDEBAR_RECENT_TOPICS'	=> 'Recent Topics',
	'SIDEBAR_RECENT_POSTS'	=> 'Recent Posts',
	'SIDEBAR_MENU'					=> 'Menu',
	'SIDEBAR_NEWEST_MEMBER'			=> 'Newest Member',
	'SIDEBAR_NEWEST_MEMBER_WELCOME'	=> 'Please welcome our newest member:',
	'SIDEBAR_SEARCH'				=> 'Search',
	'SIDEBAR_CLOCK'					=> 'Clock',
	'SIDEBAR_CALENDAR'				=> 'Calendar',

	'SIDEBAR_STATISTICS'			=> 'Forum Statistics',
	'SIDEBAR_WELCOME'				=> 'Welcome',
	'SIDEBAR_WELCOME_GUEST'			=> 'To access all features and post messages, please login or register an account',
	'SIDEBAR_WELCOME_BACK'			=> 'Welcome back',

	'SIDEBAR_TOTAL_POSTS'			=> 'Total Posts',
	'SIDEBAR_TOTAL_TOPICS'			=> 'Total Topics',
	'SIDEBAR_TOTAL_MEMBERS'			=> 'Total Members',
	'SIDEBAR_BY'					=> 'by',
	'SIDEBAR_TOGGLE'				=> 'Toggle Sidebar',

	'SIDEBAR_CAL_JANUARY'	=> 'January',
	'SIDEBAR_CAL_FEBRUARY'	=> 'February',
	'SIDEBAR_CAL_MARCH'		=> 'March',
	'SIDEBAR_CAL_APRIL'		=> 'April',
	'SIDEBAR_CAL_MAY'		=> 'May',
	'SIDEBAR_CAL_JUNE'		=> 'June',
	'SIDEBAR_CAL_JULY'		=> 'July',
	'SIDEBAR_CAL_AUGUST'	=> 'August',
	'SIDEBAR_CAL_SEPTEMBER'	=> 'September',
	'SIDEBAR_CAL_OCTOBER'	=> 'October',
	'SIDEBAR_CAL_NOVEMBER'	=> 'November',
	'SIDEBAR_CAL_DECEMBER'	=> 'December',

	'SIDEBAR_CAL_SUN'		=> 'Sunday',
	'SIDEBAR_CAL_MON'		=> 'Monday',
	'SIDEBAR_CAL_TUE'		=> 'Tuesday',
	'SIDEBAR_CAL_WED'		=> 'Wednesday',
	'SIDEBAR_CAL_THU'		=> 'Thursday',
	'SIDEBAR_CAL_FRI'		=> 'Friday',
	'SIDEBAR_CAL_SAT'		=> 'Saturday',
]);
