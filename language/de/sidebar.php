<?php
/**
 *
 * Sidebar Manager extension. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026 Vinny <https://github.com/vinny/phpbb-sidebar>
 * @license GNU General Public License, version 2 (GPL-2.0)
 * German translation by MedCo <https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1494211>
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
	'SIDEBAR_RECENT_TOPICS'			=> 'Aktuelle Themen',
	'SIDEBAR_RECENT_POSTS'			=> 'Aktuelle Beiträge',
	'SIDEBAR_MENU'					=> 'Menü',
	'SIDEBAR_NEWEST_MEMBER'			=> 'Neuestes Mitglied',
	'SIDEBAR_NEWEST_MEMBER_WELCOME'	=> 'Herzlich willkommen im Board:',
	'SIDEBAR_SEARCH'				=> 'Suche',
	'SIDEBAR_CLOCK'					=> 'Uhrzeit',
	'SIDEBAR_CLOCK_AM'				=> 'AM',
	'SIDEBAR_CLOCK_PM'				=> 'PM',
	'SIDEBAR_CALENDAR'				=> 'Kalender',

	'SIDEBAR_STATISTICS'			=> 'Statistik',
	'SIDEBAR_WELCOME'				=> 'Willkommen',
	'SIDEBAR_WELCOME_GUEST'			=> 'Um auf alle Funktionen zuzugreifen und Beiträge zu verfassen, melde dich bitte an oder registriere ein Benutzerkonto.',
	'SIDEBAR_WELCOME_BACK'			=> 'Willkommen zurück',

	'SIDEBAR_TOTAL_POSTS'			=> 'Beiträge insgesamt',
	'SIDEBAR_TOTAL_TOPICS'			=> 'Themen insgesamt',
	'SIDEBAR_TOTAL_MEMBERS'			=> 'Mitglieder insgesamt',
	'SIDEBAR_BY'					=> 'von',
	'SIDEBAR_TOGGLE'				=> 'Sidebar ein-/ausblenden',

	'SIDEBAR_CAL_JANUARY'	=> 'Januar',
	'SIDEBAR_CAL_FEBRUARY'	=> 'Februar',
	'SIDEBAR_CAL_MARCH'		=> 'März',
	'SIDEBAR_CAL_APRIL'		=> 'April',
	'SIDEBAR_CAL_MAY'		=> 'Mai',
	'SIDEBAR_CAL_JUNE'		=> 'Juni',
	'SIDEBAR_CAL_JULY'		=> 'Juli',
	'SIDEBAR_CAL_AUGUST'	=> 'August',
	'SIDEBAR_CAL_SEPTEMBER'	=> 'September',
	'SIDEBAR_CAL_OCTOBER'	=> 'Oktober',
	'SIDEBAR_CAL_NOVEMBER'	=> 'November',
	'SIDEBAR_CAL_DECEMBER'	=> 'Dezember',

	'SIDEBAR_CAL_SUN'		=> 'Sonntag',
	'SIDEBAR_CAL_MON'		=> 'Montag',
	'SIDEBAR_CAL_TUE'		=> 'Dienstag',
	'SIDEBAR_CAL_WED'		=> 'Mittwoch',
	'SIDEBAR_CAL_THU'		=> 'Donnerstag',
	'SIDEBAR_CAL_FRI'		=> 'Freitag',
	'SIDEBAR_CAL_SAT'		=> 'Samstag',
]);
