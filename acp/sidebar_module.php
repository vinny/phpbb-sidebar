<?php
/**
 *
 * Sidebar Manager extension. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026 Vinny <https://github.com/vinny/phpbb-sidebar>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace vinny\sidebar\acp;

class sidebar_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	/**
	 * Main execution function
	 */
	public function main($id, $mode)
	{
		global $language, $template, $request, $config, $db, $table_prefix, $phpbb_log, $user;

		$language->add_lang(['info_acp_sidebar', 'sidebar'], 'vinny/sidebar');

		$this->tpl_name = 'acp_sidebar_' . $mode;
		$this->page_title = $language->lang('ACP_VINNY_SIDEBAR_' . strtoupper($mode));

		add_form_key('vinny_sidebar');

		$blocks_table = $table_prefix . 'vinny_sidebar_blocks';

		if ($mode == 'settings')
		{
			$submit = $request->is_set_post('submit');

			if ($submit)
			{
				if (!check_form_key('vinny_sidebar'))
				{
					trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$available_pages = [
					'index'			=> 'SIDEBAR_PAGE_INDEX',
					'viewforum'		=> 'SIDEBAR_PAGE_VIEWFORUM',
					'viewtopic'		=> 'SIDEBAR_PAGE_VIEWTOPIC',
					'posting'		=> 'SIDEBAR_PAGE_POSTING',
					'ucp'			=> 'SIDEBAR_PAGE_UCP',
					'mcp'			=> 'SIDEBAR_PAGE_MCP',
					'search'		=> 'SIDEBAR_PAGE_SEARCH',
					'memberlist'	=> 'SIDEBAR_PAGE_MEMBERLIST',
					'viewonline'	=> 'SIDEBAR_PAGE_VIEWONLINE',
				];
				$allowed_pages = array_keys($available_pages);
				$exclude_array = $request->variable('vinny_sidebar_exclude_pages', array(''));
				$exclude_array = array_values(array_intersect($exclude_array, $allowed_pages));
				$clock_format = $request->variable('vinny_sidebar_clock_format', '24');
				$clock_format = in_array($clock_format, ['12', '24'], true) ? $clock_format : '24';

				$config->set('vinny_sidebar_enable', $request->variable('vinny_sidebar_enable', 1));
				$config->set('vinny_sidebar_left_enable', $request->variable('vinny_sidebar_left_enable', 1));
				$config->set('vinny_sidebar_right_enable', $request->variable('vinny_sidebar_right_enable', 1));
				$config->set('vinny_sidebar_hide_toggles', $request->variable('vinny_sidebar_hide_toggles', 0));
				$config->set('vinny_sidebar_clock_format', $clock_format);
				$config->set('vinny_sidebar_exclude_pages', implode(',', $exclude_array));

				$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_VINNY_SIDEBAR_SETTINGS');

				$this->purge_sidebar_cache();

				trigger_error($language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
			}

			$available_pages = [
				'index'			=> 'SIDEBAR_PAGE_INDEX',
				'viewforum'		=> 'SIDEBAR_PAGE_VIEWFORUM',
				'viewtopic'		=> 'SIDEBAR_PAGE_VIEWTOPIC',
				'posting'		=> 'SIDEBAR_PAGE_POSTING',
				'ucp'			=> 'SIDEBAR_PAGE_UCP',
				'mcp'			=> 'SIDEBAR_PAGE_MCP',
				'search'		=> 'SIDEBAR_PAGE_SEARCH',
				'memberlist'	=> 'SIDEBAR_PAGE_MEMBERLIST',
				'viewonline'	=> 'SIDEBAR_PAGE_VIEWONLINE',
			];
			$excluded = explode(',', $config['vinny_sidebar_exclude_pages']);
			$options = '';
			foreach ($available_pages as $page => $lang_key)
			{
				$selected = (in_array($page, $excluded)) ? ' selected="selected"' : '';
				$options .= '<option value="' . $page . '"' . $selected . '>' . $language->lang($lang_key) . '</option>';
			}

			// Render variables on template
			$template->assign_vars([
				'U_ACTION'						=> $this->u_action,
				'VINNY_SIDEBAR_ENABLE'			=> $config['vinny_sidebar_enable'],
				'VINNY_SIDEBAR_LEFT_ENABLE'		=> $config['vinny_sidebar_left_enable'],
				'VINNY_SIDEBAR_RIGHT_ENABLE'	=> $config['vinny_sidebar_right_enable'],
				'VINNY_SIDEBAR_HIDE_TOGGLES'	=> $config['vinny_sidebar_hide_toggles'],
				'VINNY_SIDEBAR_CLOCK_FORMAT'	=> isset($config['vinny_sidebar_clock_format']) ? $config['vinny_sidebar_clock_format'] : '24',
				'S_EXCLUDE_PAGES_OPTIONS'		=> $options,
			]);
		}
		else if ($mode == 'blocks')
		{
			global $phpbb_container, $phpbb_root_path, $phpEx;

			$action = $request->variable('action', '');
			$block_id = $request->variable('block', 0);

			if ($request->is_set_post('add'))
			{
				$action = 'add';
			}

			if ($action == 'add' || $action == 'edit')
			{
				$language->add_lang('posting');

				if (!function_exists('display_custom_bbcodes'))
				{
					include($phpbb_root_path . 'includes/functions_display.' . $phpEx);
				}
				if (!class_exists('parse_message'))
				{
					include($phpbb_root_path . 'includes/message_parser.' . $phpEx);
				}

				$block_data = [];
				$block_content_text = '';

				if ($action == 'edit' && $block_id)
				{
					$sql = 'SELECT * FROM ' . $blocks_table . ' WHERE block_id = ' . (int) $block_id;
					$result = $db->sql_query($sql);
					$block_data = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if (!$block_data)
					{
						trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if ($block_data['block_is_system'])
					{
						trigger_error($language->lang('CANNOT_EDIT_SYSTEM_BLOCK') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$parse_bbcode = isset($block_data['block_parse_bbcode']) ? (int) $block_data['block_parse_bbcode'] : 1;
					if ($parse_bbcode)
					{
						$edit_data = generate_text_for_edit($block_data['block_content'], $block_data['bbcode_uid'], $block_data['bbcode_options']);
						$block_content_text = $edit_data['text'];
					}
					else
					{
						$block_content_text = $block_data['block_content'];
					}
				}

				$submit = $request->is_set_post('submit');
				$preview = $request->is_set_post('preview');
				$analyse = $request->is_set_post('analyse');
				$analysis_results = [];
				$block_preview = '';

				if ($submit || $preview || $analyse)
				{
					if (!check_form_key('vinny_sidebar'))
					{
						trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$parse_bbcode = $request->variable('block_parse_bbcode', 0);
					$original_content = $request->variable('block_content', '', true);

					if ($parse_bbcode)
					{
						$storage_content = $original_content;
						$uid = $bitfield = '';
						$flags = 7; // BBCODE | SMILIES | URLS
						generate_text_for_storage($storage_content, $uid, $bitfield, $flags, true, true, true);

						$block_data = [
							'block_name'			=> $request->variable('block_name', '', true),
							'block_parse_bbcode'	=> 1,
							'block_content'			=> $storage_content,
							'bbcode_uid'			=> $uid,
							'bbcode_bitfield'		=> $bitfield,
							'bbcode_options'		=> $flags,
							'sidebar_side'			=> $request->variable('sidebar_side', 'left'),
							'block_enabled'			=> $request->variable('block_enabled', 1),
						];
						$block_content_text = $original_content;
					}
					else
					{
						$block_data = [
							'block_name'			=> $request->variable('block_name', '', true),
							'block_parse_bbcode'	=> 0,
							'block_content'			=> $original_content,
							'bbcode_uid'			=> '',
							'bbcode_bitfield'		=> '',
							'bbcode_options'		=> 0,
							'sidebar_side'			=> $request->variable('sidebar_side', 'left'),
							'block_enabled'			=> $request->variable('block_enabled', 1),
						];
						$block_content_text = $original_content;
					}

					if (!in_array($block_data['sidebar_side'], ['left', 'right'], true))
					{
						trigger_error($language->lang('INVALID_SIDEBAR_SIDE') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if ($block_data['block_name'] === '')
					{
						trigger_error($language->lang('BLOCK_NAME_EMPTY') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if (utf8_strlen($block_data['block_name']) > 255)
					{
						trigger_error($language->lang('BLOCK_NAME_TOO_LONG') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if ($block_data['block_content'] === '')
					{
						trigger_error($language->lang('BLOCK_CONTENT_EMPTY') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if (preg_match('/[\x{10000}-\x{10FFFF}]/u', $block_data['block_content']))
					{
						trigger_error($language->lang('BLOCK_CONTENT_ILLEGAL_CHARS') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if ($preview)
					{
						if ($block_data['block_parse_bbcode'])
						{
							$block_preview = generate_text_for_display($storage_content, $uid, $bitfield, $flags);
						}
						else
						{
							$block_preview = htmlspecialchars_decode($block_data['block_content'], ENT_COMPAT);
						}
					}

					if ($analyse)
					{
						$analysis_results = $this->analyse_block_content($block_data['block_content'], $config, $language);
					}

					if ($submit && $action == 'add')
					{
						$sql = 'SELECT MAX(block_order) AS max_order FROM ' . $blocks_table . " WHERE sidebar_side = '" . $db->sql_escape($block_data['sidebar_side']) . "'";
						$result = $db->sql_query($sql);
						$block_data['block_order'] = (int) $db->sql_fetchfield('max_order') + 10;
						$db->sql_freeresult($result);

						$sql = 'INSERT INTO ' . $blocks_table . ' ' . $db->sql_build_array('INSERT', $block_data);
						$db->sql_query($sql);
						$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_VINNY_SIDEBAR_BLOCK_ADDED', false, [$block_data['block_name']]);
						$this->purge_sidebar_cache();
						trigger_error($language->lang('BLOCK_ADDED') . adm_back_link($this->u_action));
					}
					else if ($submit)
					{
						$sql = 'UPDATE ' . $blocks_table . ' SET ' . $db->sql_build_array('UPDATE', $block_data) . ' WHERE block_id = ' . (int) $block_id;
						$db->sql_query($sql);
						$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_VINNY_SIDEBAR_BLOCK_UPDATED', false, [$block_data['block_name']]);
						$this->purge_sidebar_cache();
						trigger_error($language->lang('BLOCK_UPDATED') . adm_back_link($this->u_action));
					}
				}

				/** @var \phpbb\controller\helper $controller_helper */
				$controller_helper = $phpbb_container->get('controller.helper');

				$template->assign_vars([
					'S_EDIT_BLOCK' 				=> true,
					'S_EDIT_BLOCK_SUBMITTED'	=> ($submit || $preview || $analyse),
					'BLOCK_FORM_TITLE'			=> ($action == 'add') ? $language->lang('ACP_VINNY_SIDEBAR_BLOCK_ADD') : $language->lang('ACP_VINNY_SIDEBAR_BLOCK_EDIT'),
					'U_ACTION' 					=> $this->u_action . '&amp;action=' . $action . ($block_id ? '&amp;block=' . $block_id : ''),
					'BLOCK_NAME'				=> (isset($block_data['block_name'])) ? $block_data['block_name'] : '',
					'S_PARSE_BBCODE'			=> (isset($block_data['block_parse_bbcode'])) ? (bool) $block_data['block_parse_bbcode'] : true,
					'BLOCK_CONTENT'				=> $block_content_text,
					'SIDEBAR_SIDE'				=> (isset($block_data['sidebar_side'])) ? $block_data['sidebar_side'] : 'left',
					'BLOCK_ENABLED'				=> (isset($block_data['block_enabled'])) ? $block_data['block_enabled'] : 1,
					'S_BLOCK_PREVIEW'			=> $block_preview !== '',
					'BLOCK_PREVIEW'				=> $block_preview,
					'S_BLOCK_ANALYSIS'			=> !empty($analysis_results),
					'U_BACK'					=> $this->u_action,

					'BBCODE_STATUS'				=> $language->lang('BBCODE_IS_ON', '<a href="' . $controller_helper->route('phpbb_help_bbcode_controller') . '">', '</a>'),
					'SMILIES_STATUS'			=> $language->lang('SMILIES_ARE_ON'),
					'IMG_STATUS'				=> $language->lang('IMAGES_ARE_ON'),
					'FLASH_STATUS'				=> $language->lang('FLASH_IS_ON'),
					'URL_STATUS'				=> $language->lang('URL_IS_ON'),

					'S_BBCODE_ALLOWED'			=> true,
					'S_SMILIES_ALLOWED'			=> true,
					'S_BBCODE_IMG'				=> true,
					'S_BBCODE_FLASH'			=> true,
					'S_LINKS_ALLOWED'			=> true,
				]);

				display_custom_bbcodes();

				foreach ($analysis_results as $result)
				{
					$template->assign_block_vars('analysis_results', [
						'CLASS'		=> $result['class'],
						'MESSAGE'	=> $result['message'],
					]);
				}
			}
			else if ($action == 'delete' && $block_id)
			{
				if (confirm_box(true))
				{
					$sql = 'SELECT block_name, block_is_system FROM ' . $blocks_table . ' WHERE block_id = ' . (int) $block_id;
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if (!$row)
					{
						trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if ($row['block_is_system'])
					{
						trigger_error($language->lang('CANNOT_DELETE_SYSTEM_BLOCK') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$sql = 'DELETE FROM ' . $blocks_table . ' WHERE block_id = ' . (int) $block_id;
					$db->sql_query($sql);
					$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_VINNY_SIDEBAR_BLOCK_DELETED', false, [$row['block_name']]);
					$this->purge_sidebar_cache();
					trigger_error($language->lang('BLOCK_DELETED') . adm_back_link($this->u_action));
				}
				else
				{
					confirm_box(false, $language->lang('CONFIRM_DELETE_BLOCK'), build_hidden_fields(['block' => $block_id, 'action' => 'delete']));
				}
				redirect($this->u_action);
			}
			else if ($action == 'toggle_enabled' && $block_id)
			{
				if (!check_link_hash($request->variable('hash', ''), 'toggle_enabled'))
				{
					trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$sql = 'SELECT block_enabled FROM ' . $blocks_table . ' WHERE block_id = ' . (int) $block_id;
				$result = $db->sql_query($sql);
				$current_status = (int) $db->sql_fetchfield('block_enabled');
				$db->sql_freeresult($result);

				$new_status = ($current_status) ? 0 : 1;

				$sql = 'UPDATE ' . $blocks_table . ' SET block_enabled = ' . $new_status . ' WHERE block_id = ' . (int) $block_id;
				$db->sql_query($sql);
				$this->purge_sidebar_cache();

				if ($request->is_ajax())
				{
					$icon_class = ($new_status) ? 'fa-check-circle' : 'fa-times-circle';
					$icon_color = ($new_status) ? '#228822' : '#bcbcbc';
					$title      = ($new_status) ? $language->lang('YES') : $language->lang('NO');

					$json_response = new \phpbb\json_response;
					$json_response->send(['success' => true, 'icon_class' => $icon_class, 'icon_color' => $icon_color, 'title' => $title]);
				}
				redirect($this->u_action);
			}
			else if ($action == 'toggle_side' && $block_id)
			{
				if (!check_link_hash($request->variable('hash', ''), 'toggle_side'))
				{
					if ($request->is_ajax())
					{
						$json_response = new \phpbb\json_response;
						$json_response->send(['success' => false, 'error' => $language->lang('FORM_INVALID')]);
					}
					trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$sql = 'SELECT sidebar_side, block_is_system FROM ' . $blocks_table . ' WHERE block_id = ' . (int) $block_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					if ($request->is_ajax())
					{
						$json_response = new \phpbb\json_response;
						$json_response->send(['success' => false, 'error' => $language->lang('FORM_INVALID')]);
					}
					redirect($this->u_action);
				}

				$current_side = $row['sidebar_side'];
				$new_side = ($current_side == 'left') ? 'right' : 'left';

				$sql = 'UPDATE ' . $blocks_table . " SET sidebar_side = '" . $db->sql_escape($new_side) . "' WHERE block_id = " . (int) $block_id;
				$db->sql_query($sql);
				$this->purge_sidebar_cache();

				if ($request->is_ajax())
				{
					$side_text  = ($new_side == 'left') ? $language->lang('BLOCK_SIDE_LEFT') : $language->lang('BLOCK_SIDE_RIGHT');
					$other_text = ($new_side == 'left') ? $language->lang('BLOCK_SIDE_RIGHT') : $language->lang('BLOCK_SIDE_LEFT');
					$icon_class = ($new_side == 'left') ? 'fa-arrow-circle-right' : 'fa-arrow-circle-left';

					$json_response = new \phpbb\json_response;
					$json_response->send(['success' => true, 'side_text' => $side_text, 'other_text' => $other_text, 'icon_class' => $icon_class]);
				}
				redirect($this->u_action);
			}
			else if (($action == 'move_up' || $action == 'move_down') && $block_id)
			{
				if (!check_link_hash($request->variable('hash', ''), $action))
				{
					trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$sql = 'SELECT block_order, sidebar_side FROM ' . $blocks_table . ' WHERE block_id = ' . (int) $block_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if ($row)
				{
					$current_order = $row['block_order'];
					$current_side = $row['sidebar_side'];

					$sql_compare = ($action == 'move_up') ? '<' : '>';
					$sql_order_dir = ($action == 'move_up') ? 'DESC' : 'ASC';

					// Find the adjacent block within the same sidebar
					$sql = 'SELECT block_id, block_order FROM ' . $blocks_table . "
						WHERE sidebar_side = '" . $db->sql_escape($current_side) . "'
							AND block_order " . $sql_compare . ' ' . (int) $current_order . '
						ORDER BY block_order ' . $sql_order_dir;
					$result = $db->sql_query_limit($sql, 1);
					$adjacent_row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if ($adjacent_row)
					{
						// Swap orders
						$db->sql_query('UPDATE ' . $blocks_table . ' SET block_order = ' . (int) $adjacent_row['block_order'] . ' WHERE block_id = ' . (int) $block_id);
						$db->sql_query('UPDATE ' . $blocks_table . ' SET block_order = ' . (int) $current_order . ' WHERE block_id = ' . (int) $adjacent_row['block_id']);
						$this->purge_sidebar_cache();

						if ($request->is_ajax())
						{
							$json_response = new \phpbb\json_response;
							$json_response->send(['success' => true]);
						}
					}
				}

				if ($request->is_ajax())
				{
					$json_response = new \phpbb\json_response;
					$json_response->send(['success' => false]);
				}

				redirect($this->u_action);
			}
			else if ($action == 'update_order' && $request->is_ajax())
			{
				if (!check_link_hash($request->variable('hash', ''), 'update_order'))
				{
					$json_response = new \phpbb\json_response;
					$json_response->send(['success' => false, 'error' => $language->lang('FORM_INVALID')]);
				}

				$order_json = htmlspecialchars_decode($request->variable('order', '', true));
				$order_data = json_decode($order_json, true);

				if (is_array($order_data))
				{
					$db->sql_transaction('begin');

					foreach ($order_data as $side => $ids)
					{
						if ($side !== 'left' && $side !== 'right')
						{
							continue;
						}

						if (is_array($ids))
						{
							foreach ($ids as $index => $id)
							{
								$sql = 'UPDATE ' . $blocks_table . '
										SET block_order = ' . (int) ($index * 10) . ",
											sidebar_side = '" . $db->sql_escape($side) . "'
										WHERE block_id = " . (int) $id;
								$db->sql_query($sql);
							}
						}
					}

					$db->sql_transaction('commit');
					$this->purge_sidebar_cache();
				}

				$json_response = new \phpbb\json_response;
				$json_response->send(['success' => true]);
			}
			else if ($action == 'purge_cache')
			{
				if (!check_link_hash($request->variable('hash', ''), 'purge_cache'))
				{
					trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
				}
				$this->purge_sidebar_cache();
				$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_VINNY_SIDEBAR_CACHE_PURGED');
				trigger_error($language->lang('SIDEBAR_CACHE_PURGED') . adm_back_link($this->u_action));
			}
			else
			{
				// Block List View
				$left_active = $left_disabled = 0;
				$right_active = $right_disabled = 0;

				$sql = 'SELECT * FROM ' . $blocks_table . ' ORDER BY sidebar_side ASC, block_order ASC';
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					if ($row['sidebar_side'] == 'left')
					{
						$row['block_enabled'] ? $left_active++ : $left_disabled++;
					}
					else
					{
						$row['block_enabled'] ? $right_active++ : $right_disabled++;
					}

					$block_var_name = ($row['sidebar_side'] == 'left') ? 'blocks_left' : 'blocks_right';
					$template->assign_block_vars($block_var_name, [
						'ID'		=> $row['block_id'],
						'NAME'		=> $language->lang($row['block_name']),
						'SIDE'		=> $row['sidebar_side'],
						'ENABLED'	=> $row['block_enabled'],
						'IS_SYSTEM'	=> $row['block_is_system'],
						'U_EDIT'	=> $this->u_action . '&amp;action=edit&amp;block=' . $row['block_id'],
						'U_DELETE'	=> $this->u_action . '&amp;action=delete&amp;block=' . $row['block_id'],
						'U_TOGGLE_ENABLED'	=> $this->u_action . '&amp;action=toggle_enabled&amp;block=' . $row['block_id'] . '&amp;hash=' . generate_link_hash('toggle_enabled'),
						'U_TOGGLE_SIDE'		=> $this->u_action . '&amp;action=toggle_side&amp;block=' . $row['block_id'] . '&amp;hash=' . generate_link_hash('toggle_side'),
						'U_MOVE_UP'			=> $this->u_action . '&amp;action=move_up&amp;block=' . $row['block_id'] . '&amp;hash=' . generate_link_hash('move_up'),
						'U_MOVE_DOWN'		=> $this->u_action . '&amp;action=move_down&amp;block=' . $row['block_id'] . '&amp;hash=' . generate_link_hash('move_down'),
					]);
				}
				$db->sql_freeresult($result);

				$template->assign_vars([
					'U_ACTION' 				=> $this->u_action,
					'U_UPDATE_ORDER'		=> $this->u_action . '&amp;action=update_order',
					'UPDATE_ORDER_HASH'		=> generate_link_hash('update_order'),
					'U_PURGE_CACHE'			=> $this->u_action . '&amp;action=purge_cache&amp;hash=' . generate_link_hash('purge_cache'),
					'LEFT_STATUS_SUMMARY'	=> $language->lang('BLOCKS_STATUS_SUMMARY', $left_active, $left_disabled),
					'RIGHT_STATUS_SUMMARY'	=> $language->lang('BLOCKS_STATUS_SUMMARY', $right_active, $right_disabled),
				]);
			}
		}
	}

	/**
	 * Checks trusted HTML block content for patterns that deserve admin attention.
	 *
	 * These checks intentionally warn instead of blocking. Custom blocks are an
	 * administrator-controlled HTML feature, so legitimate snippets may need code
	 * that would be unsafe in normal user-submitted content.
	 */
	private function analyse_block_content($content, $config, $language)
	{
		$content = htmlspecialchars_decode($content, ENT_COMPAT);
		$results = [];
		$has_untrusted_connection = false;

		if (preg_match('/alert\s*\(/i', $content))
		{
			$results[] = [
				'class'		=> 'warningbox',
				'message'	=> $language->lang('BLOCK_ANALYSIS_ALERT_USAGE'),
			];
		}

		if (preg_match('/location\s*\.\s*href\s*=/i', $content))
		{
			$results[] = [
				'class'		=> 'errorbox',
				'message'	=> $language->lang('BLOCK_ANALYSIS_LOCATION_CHANGE'),
			];
		}

		if (preg_match('/<script\b(?=[^>]*\bsrc\s*=)(?![^>]*\basync\b)[^>]*>/i', $content))
		{
			$results[] = [
				'class'		=> 'warningbox',
				'message'	=> $language->lang('BLOCK_ANALYSIS_SCRIPT_WITHOUT_ASYNC'),
			];
		}

		if (!empty($config['server_protocol']) && strpos($config['server_protocol'], 'https') === 0 && preg_match('/(?:src|href)\s*=\s*["\']http:\/\//i', $content))
		{
			$has_untrusted_connection = true;
			$results[] = [
				'class'		=> 'warningbox',
				'message'	=> $language->lang('BLOCK_ANALYSIS_UNTRUSTED_CONNECTION'),
			];
		}

		if (!$has_untrusted_connection && preg_match('/(?:src|href|action)\s*=\s*["\'](?:https?:)?\/\//i', $content))
		{
			$results[] = [
				'class'		=> 'warningbox',
				'message'	=> $language->lang('BLOCK_ANALYSIS_EXTERNAL_RESOURCE'),
			];
		}

		if (preg_match('/<iframe\b/i', $content))
		{
			$results[] = [
				'class'		=> 'warningbox',
				'message'	=> $language->lang('BLOCK_ANALYSIS_IFRAME'),
			];
		}

		if (preg_match('/<form\b/i', $content))
		{
			$results[] = [
				'class'		=> 'warningbox',
				'message'	=> $language->lang('BLOCK_ANALYSIS_FORM'),
			];
		}

		if (preg_match('/\s(on[a-z]+)\s*=/i', $content))
		{
			$results[] = [
				'class'		=> 'warningbox',
				'message'	=> $language->lang('BLOCK_ANALYSIS_INLINE_EVENT'),
			];
		}

		if (preg_match('/(?:href|src)\s*=\s*["\']\s*javascript:/i', $content))
		{
			$results[] = [
				'class'		=> 'errorbox',
				'message'	=> $language->lang('BLOCK_ANALYSIS_JAVASCRIPT_URI'),
			];
		}

		if (empty($results))
		{
			$results[] = [
				'class'		=> 'successbox',
				'message'	=> $language->lang('BLOCK_ANALYSIS_NO_ISSUES'),
			];
		}

		return $results;
	}

	/**
	 * Destroys the compiled sidebar blocks cache.
	 */
	protected function purge_sidebar_cache()
	{
		global $phpbb_container;
		if ($phpbb_container !== null && $phpbb_container->has('cache.driver'))
		{
			$cache = $phpbb_container->get('cache.driver');
			$cache->destroy('_vinny_sidebar_blocks');
		}
	}
}
