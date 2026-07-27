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
	'ACP_VINNY_SIDEBAR_SETTINGS'	=> 'Configurações',
	'ACP_VINNY_SIDEBAR_BLOCKS'		=> 'Gerir Blocos',

	'VINNY_SIDEBAR'					=> 'Sidebar Manager',
	'VINNY_SIDEBAR_EXPLAIN'			=> 'Aqui pode gerir as barras laterais e os seus blocos. Note que os blocos do sistema não podem ser eliminados, pois o seu conteúdo é gerado dinamicamente por código.',
	'VINNY_SIDEBAR_SUPPORT_STAR'	=> 'Se gosta desta extensão, por favor dê uma estrela no <a href="https://github.com/vinny/phpbb-sidebar" target="_blank" rel="noopener"><i class="icon fa fa-github fa-fw" aria-hidden="true"></i>GitHub</a>.',
	'VINNY_SIDEBAR_SUPPORT_DONATE'	=> 'Se a considera útil, também pode apoiar o seu desenvolvimento com uma <a href="https://ko-fi.com/vinny1" target="_blank" rel="noopener"><i class="icon fa fa-heart fa-fw" aria-hidden="true"></i>doação</a> opcional.',
	'VINNY_SIDEBAR_BLOCK_REQUESTS'	=> 'Deseja adicionar novas funcionalidades? Pode solicitar um bloco personalizado no tópico de <a href="https://www.phpbb.com/customise/db/extension/sidebar/support/topic/255892" target="_blank" rel="noopener"><i class="icon fa fa-comments fa-fw" aria-hidden="true"></i>Pedidos de Blocos</a>.',
	'VINNY_SIDEBAR_BLOCK_DOWNLOADS'	=> 'Quer mais blocos? Explore e transfira extensões de blocos adicionais no tópico de <a href="https://www.phpbb.com/customise/db/extension/sidebar/support/topic/255895" target="_blank" rel="noopener"><i class="icon fa fa-download fa-fw" aria-hidden="true"></i>Transferências de Blocos</a>.',

	// Settings
	'VINNY_SIDEBAR_ENABLE'			=> 'Activar funcionalidade da Barra Lateral',
	'VINNY_SIDEBAR_ENABLE_EXPLAIN'	=> 'Um comutador global para activar ou desactivar todo o sistema de barras laterais.',
	'VINNY_SIDEBAR_LEFT_ENABLE'		=> 'Activar Barra Lateral Esquerda',
	'VINNY_SIDEBAR_RIGHT_ENABLE'	=> 'Activar Barra Lateral Direita',
	'VINNY_SIDEBAR_HIDE_TOGGLES'			=> 'Ocultar botões de alternância',
	'VINNY_SIDEBAR_HIDE_TOGGLES_EXPLAIN'	=> 'Se activado, os botões que permitem aos utilizadores exibir/ocultar a barra lateral não serão exibidos, impedindo que recolham a barra lateral.',

	// Logs
	'LOG_VINNY_SIDEBAR_SETTINGS'		=> '<strong>Configurações do Sidebar Manager actualizadas</strong>',
	'LOG_VINNY_SIDEBAR_BLOCK_ADDED'		=> '<strong>Bloco da barra lateral adicionado</strong><br />» %s',
	'LOG_VINNY_SIDEBAR_BLOCK_UPDATED'	=> '<strong>Bloco da barra lateral actualizado</strong><br />» %s',
	'LOG_VINNY_SIDEBAR_BLOCK_DELETED'	=> '<strong>Bloco da barra lateral eliminado</strong><br />» %s',
	'LOG_VINNY_SIDEBAR_CACHE_PURGED'	=> '<strong>Cache da barra lateral limpo</strong>',

	// Cache & Actions
	'PURGE_SIDEBAR_CACHE'				=> 'Limpar Cache da Barra Lateral',
	'SIDEBAR_CACHE_PURGED'				=> 'O cache da barra lateral foi limpo com sucesso.',
	'BLOCKS_STATUS_SUMMARY'				=> '%1$d activos, %2$d desactivados',

	// Blocks
	'ACP_VINNY_SIDEBAR_BLOCK_ADD'	=> 'Adicionar Bloco Personalizado',
	'ACP_VINNY_SIDEBAR_BLOCK_EDIT'	=> 'Editar Bloco',
	'BLOCK_NAME'					=> 'Nome do Bloco',
	'PARSE_BBCODE'					=> 'Processar BBCode',
	'PARSE_BBCODE_EXPLAIN'			=> 'Se activado, a formatação BBCode, smileys e URLs serão processados para este bloco. Se desactivado, o código HTML bruto confiável é renderizado directamente.',
	'BLOCK_SIDE'					=> 'Lado da Barra Lateral',
	'BLOCK_SIDE_LEFT'				=> 'Barra Lateral Esquerda',
	'BLOCK_SIDE_RIGHT'				=> 'Barra Lateral Direita',
	'BLOCK_MOVE_TO'					=> 'Mover para',
	'BLOCK_DRAG_DROP'				=> 'Arrastar e Largar',
	'BLOCK_CONTENT'					=> 'Conteúdo do Bloco',
	'BLOCK_CONTENT_EXPLAIN'			=> 'Introduza o conteúdo para este bloco. Para blocos BBCode, são suportadas formatações BBCode padrão, smileys e hiperligações. Para blocos HTML, o código HTML confiável é renderizado directamente, portanto apenas administradores de confiança devem adicionar scripts, iframes, formulários ou widgets de terceiros.',
	'BLOCK_TRUSTED_HTML_WARNING'	=> 'Adicione apenas HTML de fontes confiáveis. Scripts, iframes, formulários e widgets de terceiros podem afectar visitantes, carregar recursos externos ou interagir com cookies e sistemas de rastreio.',
	'BLOCK_PREVIEW'					=> 'Pré-visualização',
	'BLOCK_PREVIEW_CONTENT_PLACEHOLDER'	=> 'Pré-visualização da área de conteúdo do fórum',
	'BLOCK_ANALYSIS'				=> 'Análise de HTML',
	'BLOCK_ANALYSE_HTML'			=> 'Analisar HTML',
	'BLOCK_ENABLED'					=> 'Activo',
	'BLOCK_EXCLUDE_PAGES'			=> 'Excluir das páginas',
	'BLOCK_EXCLUDE_PAGES_EXPLAIN'	=> 'Seleccione as páginas onde este bloco NÃO deve ser exibido. Mantenha premida a tecla CTRL para seleccionar várias páginas.',
	'SIDEBAR_PAGE_INDEX'			=> 'Página inicial',
	'SIDEBAR_PAGE_VIEWFORUM'		=> 'Páginas de fóruns',
	'SIDEBAR_PAGE_VIEWTOPIC'		=> 'Páginas de tópicos',
	'SIDEBAR_PAGE_POSTING'			=> 'Páginas de publicação',
	'SIDEBAR_PAGE_UCP'				=> 'Painel de Controlo do Utilizador',
	'SIDEBAR_PAGE_MCP'				=> 'Painel de Controlo do Moderador',
	'SIDEBAR_PAGE_SEARCH'			=> 'Página de pesquisa',
	'SIDEBAR_PAGE_MEMBERLIST'		=> 'Lista de utilizadores',
	'SIDEBAR_PAGE_VIEWONLINE'		=> 'Página Quem está online',

	'VINNY_SIDEBAR_CLOCK_FORMAT'	=> 'Formato do Relógio',
	'VINNY_SIDEBAR_CLOCK_FORMAT_EXPLAIN' => 'Escolha entre o formato 24 horas e AM/PM para o bloco do Relógio.',
	'VINNY_SIDEBAR_CLOCK_24H'		=> '24 horas (00:00:00)',
	'VINNY_SIDEBAR_CLOCK_AMPM'		=> 'AM/PM (12:00:00 AM)',

	'BLOCK_ADDED'					=> 'Bloco adicionado com sucesso.',
	'BLOCK_UPDATED'					=> 'Bloco actualizado com sucesso.',
	'BLOCK_DELETED'					=> 'Bloco eliminado com sucesso.',
	'NO_BLOCKS'						=> 'Nenhum bloco encontrado. Clique em "Adicionar Bloco Personalizado" para criar um.',
	'CONFIRM_DELETE_BLOCK'			=> 'Tem a certeza de que deseja eliminar este bloco?',

	'CANNOT_EDIT_SYSTEM_BLOCK'		=> 'Não pode editar um bloco protegido do sistema. O seu conteúdo é gerido pela lógica da extensão.',
	'CANNOT_DELETE_SYSTEM_BLOCK'	=> 'Não pode eliminar um bloco protegido do sistema.',
	'BLOCK_NAME_EMPTY'				=> 'O nome do bloco não pode estar vazio.',
	'BLOCK_NAME_TOO_LONG'			=> 'O nome do bloco não deve ter mais de 255 caracteres.',
	'BLOCK_CONTENT_EMPTY'			=> 'O conteúdo do bloco não pode estar vazio.',
	'BLOCK_CONTENT_ILLEGAL_CHARS'	=> 'O código do bloco contém caracteres não suportados (inválidos para esta base de dados).',
	'INVALID_SIDEBAR_SIDE'			=> 'O lado seleccionado da barra lateral é inválido.',
	'BLOCK_ANALYSIS_NO_ISSUES'		=> 'Nenhum problema comum de HTML foi detectado.',
	'BLOCK_ANALYSIS_ALERT_USAGE'	=> 'O HTML contém alert(). Isto é geralmente código de depuração e deve ser removido antes de publicar.',
	'BLOCK_ANALYSIS_LOCATION_CHANGE'=> 'O HTML altera location.href. Isto pode redireccionar utilizadores e só deve ser usado se for intencionalmente confiável.',
	'BLOCK_ANALYSIS_SCRIPT_WITHOUT_ASYNC'	=> 'O HTML carrega um script externo sem async. Considere adicionar async para evitar bloquear o carregamento da página.',
	'BLOCK_ANALYSIS_UNTRUSTED_CONNECTION'	=> 'O fórum parece usar HTTPS, mas este HTML carrega conteúdo por HTTP. Use recursos HTTPS para evitar avisos de conteúdo misto.',
	'BLOCK_ANALYSIS_EXTERNAL_RESOURCE'	=> 'O HTML carrega recursos externos. Confirme que a fonte é confiável e respeita a sua política de privacidade.',
	'BLOCK_ANALYSIS_IFRAME'			=> 'O HTML contém um iframe. Confirme que a fonte incorporada é confiável.',
	'BLOCK_ANALYSIS_FORM'			=> 'O HTML contém um formulário. Confirme que ele envia apenas para um destino confiável e não recolhe dados sensíveis de forma inesperada.',
	'BLOCK_ANALYSIS_INLINE_EVENT'	=> 'O HTML contém atributos de eventos JavaScript incorporados como onclick, onload ou onerror. Confirme que este código é confiável.',
	'BLOCK_ANALYSIS_JAVASCRIPT_URI'	=> 'O HTML contém um URL javascript:. Confirme que este código é confiável antes de publicar.',
]);
