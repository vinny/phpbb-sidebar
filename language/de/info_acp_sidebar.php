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
	'ACP_VINNY_SIDEBAR'				=> 'Sidebar-Manager',
	'ACP_VINNY_SIDEBAR_SETTINGS'	=> 'Einstellungen',
	'ACP_VINNY_SIDEBAR_BLOCKS'		=> 'Blöcke verwalten',

	'VINNY_SIDEBAR'					=> 'Sidebar-Manager',
	'VINNY_SIDEBAR_EXPLAIN'			=> 'Hier kannst du die Sidebars und deren Blöcke verwalten. Beachte, dass Systemblöcke nicht gelöscht werden können, da deren Inhalt dynamisch durch die Codelogik erzeugt wird.',
	'VINNY_SIDEBAR_SUPPORT_STAR'	=> 'Wenn dir diese Erweiterung gefällt, gib ihr bitte einen Stern auf <a href="https://github.com/vinny/phpbb-sidebar" target="_blank" rel="noopener"><i class="icon fa fa-github fa-fw" aria-hidden="true"></i>GitHub</a>.',
	'VINNY_SIDEBAR_SUPPORT_DONATE'	=> 'Wenn du sie nützlich findest, kannst du ihre Entwicklung auch mit einer optionalen <a href="https://ko-fi.com/vinny1" target="_blank" rel="noopener"><i class="icon fa fa-heart fa-fw" aria-hidden="true"></i>Spende</a> unterstützen.',
	'VINNY_SIDEBAR_BLOCK_REQUESTS'	=> 'Möchtest du neue Funktionen hinzufügen? Du kannst einen benutzerdefinierten Sidebar-Block im Thema <a href="https://www.phpbb.com/customise/db/extension/sidebar/support/topic/255892" target="_blank" rel="noopener"><i class="icon fa fa-comments fa-fw" aria-hidden="true"></i>Block-Wünsche</a> anfragen.',
	'VINNY_SIDEBAR_BLOCK_DOWNLOADS'	=> 'Möchtest du weitere Blöcke? Durchsuche und lade zusätzliche Block-Erweiterungen aus dem Thema <a href="https://www.phpbb.com/customise/db/extension/sidebar/support/topic/255895" target="_blank" rel="noopener"><i class="icon fa fa-download fa-fw" aria-hidden="true"></i>Block-Downloads</a> herunter.',

	// Settings
	'VINNY_SIDEBAR_ENABLE'			=> 'Sidebar-Funktionalität aktivieren',
	'VINNY_SIDEBAR_ENABLE_EXPLAIN'	=> 'Ein globaler Schalter, um das gesamte Sidebar-System zu aktivieren oder zu deaktivieren.',
	'VINNY_SIDEBAR_LEFT_ENABLE'		=> 'Linke Sidebar aktivieren',
	'VINNY_SIDEBAR_RIGHT_ENABLE'	=> 'Rechte Sidebar aktivieren',
	'VINNY_SIDEBAR_HIDE_TOGGLES'			=> 'Ein-/Ausblend-Buttons ausblenden',
	'VINNY_SIDEBAR_HIDE_TOGGLES_EXPLAIN'	=> 'Wenn aktiviert, werden die Buttons zum Ein- und Ausblenden der Sidebar nicht angezeigt. Dies verhindert, dass Benutzer die Sidebar einklappen können.',

	// Logs
	'LOG_VINNY_SIDEBAR_SETTINGS'		=> '<strong>Sidebar-Manager-Einstellungen aktualisiert</strong>',
	'LOG_VINNY_SIDEBAR_BLOCK_ADDED'		=> '<strong>Sidebar-Block hinzugefügt</strong><br />» %s',
	'LOG_VINNY_SIDEBAR_BLOCK_UPDATED'	=> '<strong>Sidebar-Block aktualisiert</strong><br />» %s',
	'LOG_VINNY_SIDEBAR_BLOCK_DELETED'	=> '<strong>Sidebar-Block gelöscht</strong><br />» %s',
	'LOG_VINNY_SIDEBAR_CACHE_PURGED'	=> '<strong>Sidebar-Cache geleert</strong>',

	// Cache & Actions
	'PURGE_SIDEBAR_CACHE'				=> 'Sidebar-Cache leeren',
	'SIDEBAR_CACHE_PURGED'				=> 'Der Sidebar-Cache wurde erfolgreich geleert.',
	'BLOCKS_STATUS_SUMMARY'				=> '%1$d aktiv, %2$d deaktiviert',

	// Blocks
	'ACP_VINNY_SIDEBAR_BLOCK_ADD'	=> 'Benutzerdefinierten Block hinzufügen',
	'ACP_VINNY_SIDEBAR_BLOCK_EDIT'	=> 'Block bearbeiten',
	'BLOCK_NAME'					=> 'Block-Name',
	'PARSE_BBCODE'					=> 'BBCode parsen',
	'PARSE_BBCODE_EXPLAIN'			=> 'Wenn aktiviert, werden BBCode-Formatierungen, Smilies und URLs für diesen Block verarbeitet. Wenn deaktiviert, wird vertrauenswürdiger HTML-Code direkt gerendert.',
	'BLOCK_SIDE'					=> 'Sidebar-Seite',
	'BLOCK_SIDE_LEFT'				=> 'Linke Sidebar',
	'BLOCK_SIDE_RIGHT'				=> 'Rechte Sidebar',
	'BLOCK_MOVE_TO'					=> 'Verschieben nach',
	'BLOCK_DRAG_DROP'				=> 'Drag & Drop',
	'BLOCK_CONTENT'					=> 'Block-Inhalt',
	'BLOCK_CONTENT_EXPLAIN'			=> 'Gib den Inhalt für diesen Block ein. Für BBCode-Blöcke werden Standard-BBCode-Formatierungen, Smilies und Links unterstützt. Für HTML-Blöcke wird vertrauenswürdiger HTML-Code direkt gerendert, daher sollten nur vertrauenswürdige Administratoren Skripte, Iframes, Formulare oder Widgets von Drittanbietern hinzufügen.',
	'BLOCK_TRUSTED_HTML_WARNING'	=> 'Füge nur HTML aus vertrauenswürdigen Quellen hinzu. Skripte, Iframes, Formulare und Widgets von Drittanbietern können Besucher beeinflussen, externe Ressourcen laden oder mit Cookies und Tracking-Systemen interagieren.',
	'BLOCK_PREVIEW'					=> 'Vorschau',
	'BLOCK_PREVIEW_CONTENT_PLACEHOLDER'	=> 'Vorschau des Foren-Inhaltsbereichs',
	'BLOCK_ANALYSIS'				=> 'HTML-Analyse',
	'BLOCK_ANALYSE_HTML'			=> 'HTML analysieren',
	'BLOCK_ENABLED'					=> 'Aktiviert',
	'BLOCK_EXCLUDE_PAGES'			=> 'Von Seiten ausschließen',
	'BLOCK_EXCLUDE_PAGES_EXPLAIN'	=> 'Wähle die Seiten aus, auf denen dieser Block NICHT angezeigt werden soll. Halte die STRG-Taste gedrückt, um mehrere Seiten auszuwählen.',
	'SIDEBAR_PAGE_INDEX'			=> 'Index-Seite (Startseite)',
	'SIDEBAR_PAGE_VIEWFORUM'		=> 'Foren-Seiten',
	'SIDEBAR_PAGE_VIEWTOPIC'		=> 'Themen-Seiten',
	'SIDEBAR_PAGE_POSTING'			=> 'Seiten zum Erstellen von Beiträgen',
	'SIDEBAR_PAGE_UCP'				=> 'Persönlicher Bereich (UCP)',
	'SIDEBAR_PAGE_MCP'				=> 'Moderationsbereich (MCP)',
	'SIDEBAR_PAGE_SEARCH'			=> 'Suchseite',
	'SIDEBAR_PAGE_MEMBERLIST'		=> 'Mitgliederliste',
	'SIDEBAR_PAGE_VIEWONLINE'		=> 'Wer-ist-online-Seite',

	'VINNY_SIDEBAR_CLOCK_FORMAT'	=> 'Uhrzeit-Format',
	'VINNY_SIDEBAR_CLOCK_FORMAT_EXPLAIN' => 'Wähle zwischen dem 24-Stunden-Format und dem AM/PM-Format für den Uhr-Block.',
	'VINNY_SIDEBAR_CLOCK_24H'		=> '24 Stunden (00:00:00)',
	'VINNY_SIDEBAR_CLOCK_AMPM'		=> 'AM/PM (12:00:00 AM)',

	'BLOCK_ADDED'					=> 'Block erfolgreich hinzugefügt.',
	'BLOCK_UPDATED'					=> 'Block erfolgreich aktualisiert.',
	'BLOCK_DELETED'					=> 'Block erfolgreich gelöscht.',
	'NO_BLOCKS'						=> 'Keine Blöcke gefunden. Klicke auf „Benutzerdefinierten Block hinzufügen“, um einen zu erstellen.',
	'CONFIRM_DELETE_BLOCK'			=> 'Bist du sicher, dass du diesen Block löschen möchtest?',

	'CANNOT_EDIT_SYSTEM_BLOCK'		=> 'Du kannst einen systemgeschützten Block nicht bearbeiten. Sein Inhalt wird durch die Logik der Extension verwaltet.',
	'CANNOT_DELETE_SYSTEM_BLOCK'	=> 'Du kannst einen systemgeschützten Block nicht löschen.',
	'BLOCK_NAME_EMPTY'				=> 'Der Block-Name darf nicht leer sein.',
	'BLOCK_NAME_TOO_LONG'			=> 'Der Block-Name darf nicht länger als 255 Zeichen sein.',
	'BLOCK_CONTENT_EMPTY'			=> 'Der Block-Inhalt darf nicht leer sein.',
	'BLOCK_CONTENT_ILLEGAL_CHARS'	=> 'Der Block-Code enthält nicht unterstützte Zeichen (ungültig für diese Datenbank).',
	'INVALID_SIDEBAR_SIDE'			=> 'Die ausgewählte Sidebar-Seite ist ungültig.',
	'BLOCK_ANALYSIS_NO_ISSUES'		=> 'Es wurden keine häufigen HTML-Probleme erkannt.',
	'BLOCK_ANALYSIS_ALERT_USAGE'	=> 'Das HTML enthält alert(). Dies ist normalerweise Debugging-Code und sollte vor der Veröffentlichung entfernt werden.',
	'BLOCK_ANALYSIS_LOCATION_CHANGE'=> 'Das HTML ändert location.href. Dies kann Benutzer weiterleiten und sollte nur verwendet werden, wenn der Quelle ausdrücklich vertraut wird.',
	'BLOCK_ANALYSIS_SCRIPT_WITHOUT_ASYNC'	=> 'Das HTML lädt ein externes Skript ohne „async“. Erwäge das Hinzufügen von „async“, um das Blockieren des Seitenaufbaus (Rendering) zu vermeiden.',
	'BLOCK_ANALYSIS_UNTRUSTED_CONNECTION'	=> 'Das Board scheint HTTPS zu verwenden, aber dieses HTML lädt Inhalte über HTTP. Verwende HTTPS-Ressourcen, um Mixed-Content-Warnungen zu vermeiden.',
	'BLOCK_ANALYSIS_EXTERNAL_RESOURCE'	=> 'Das HTML lädt externe Ressourcen. Vergewissere dich, dass die Quelle vertrauenswürdig ist und deine Datenschutzrichtlinien einhält.',
	'BLOCK_ANALYSIS_IFRAME'			=> 'Das HTML enthält ein Iframe. Vergewissere dich, dass die eingebettete Quelle vertrauenswürdig ist.',
	'BLOCK_ANALYSIS_FORM'			=> 'Das HTML enthält ein Formular. Vergewissere dich, dass es Daten nur an ein vertrauenswürdiges Ziel sendet und keine sensiblen Daten unerwartet erfasst.',
	'BLOCK_ANALYSIS_INLINE_EVENT'	=> 'Das HTML enthält Inline-JavaScript-Ereignisattribute wie onclick, onload oder onerror. Vergewissere dich, dass dieser Code vertrauenswürdig ist.',
	'BLOCK_ANALYSIS_JAVASCRIPT_URI'	=> 'Das HTML enthält eine „javascript:“-URL. Vergewissere dich, dass dieser Code vertrauenswürdig ist, bevor du ihn veröffentlichst.',
]);
