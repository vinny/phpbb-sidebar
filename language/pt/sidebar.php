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
	'SIDEBAR_RECENT_TOPICS'			=> 'Tópicos Recentes',
	'SIDEBAR_RECENT_POSTS'			=> 'Mensagens Recentes',
	'SIDEBAR_MENU'					=> 'Menu',
	'SIDEBAR_NEWEST_MEMBER'			=> 'Utilizador Recente',
	'SIDEBAR_NEWEST_MEMBER_WELCOME'	=> 'Por favor, dê as boas-vindas ao nosso novo utilizador:',
	'SIDEBAR_SEARCH'				=> 'Pesquisa',
	'SIDEBAR_CLOCK'					=> 'Relógio',
	'SIDEBAR_CLOCK_AM'				=> 'AM',
	'SIDEBAR_CLOCK_PM'				=> 'PM',
	'SIDEBAR_CALENDAR'				=> 'Calendário',

	'SIDEBAR_STATISTICS'			=> 'Estatísticas do Fórum',
	'SIDEBAR_WELCOME'				=> 'Bem-vindo',
	'SIDEBAR_WELCOME_GUEST'			=> 'Para aceder a todas as funcionalidades e enviar mensagens, inicie sessão ou registe uma conta',
	'SIDEBAR_WELCOME_BACK'			=> 'Bem-vindo de volta',

	'SIDEBAR_TOTAL_POSTS'			=> 'Total de Mensagens',
	'SIDEBAR_TOTAL_TOPICS'			=> 'Total de Tópicos',
	'SIDEBAR_TOTAL_MEMBERS'			=> 'Total de Utilizadores',
	'SIDEBAR_BY'					=> 'por',
	'SIDEBAR_TOGGLE'				=> 'Alternar Barra Lateral',

	'SIDEBAR_CAL_JANUARY'	=> 'Janeiro',
	'SIDEBAR_CAL_FEBRUARY'	=> 'Fevereiro',
	'SIDEBAR_CAL_MARCH'		=> 'Março',
	'SIDEBAR_CAL_APRIL'		=> 'Abril',
	'SIDEBAR_CAL_MAY'		=> 'Maio',
	'SIDEBAR_CAL_JUNE'		=> 'Junho',
	'SIDEBAR_CAL_JULY'		=> 'Julho',
	'SIDEBAR_CAL_AUGUST'	=> 'Agosto',
	'SIDEBAR_CAL_SEPTEMBER'	=> 'Setembro',
	'SIDEBAR_CAL_OCTOBER'	=> 'Outubro',
	'SIDEBAR_CAL_NOVEMBER'	=> 'Novembro',
	'SIDEBAR_CAL_DECEMBER'	=> 'Dezembro',

	'SIDEBAR_CAL_SUN'		=> 'Domingo',
	'SIDEBAR_CAL_MON'		=> 'Segunda-feira',
	'SIDEBAR_CAL_TUE'		=> 'Terça-feira',
	'SIDEBAR_CAL_WED'		=> 'Quarta-feira',
	'SIDEBAR_CAL_THU'		=> 'Quinta-feira',
	'SIDEBAR_CAL_FRI'		=> 'Sexta-feira',
	'SIDEBAR_CAL_SAT'		=> 'Sábado',
]);
