<?php
/**
 *
 * @package phpBB Extension - vinny/sidebar
 * @copyright (c) Vinny
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
		global $language, $template, $request, $config, $db, $table_prefix, $phpbb_container;

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

				$config->set('vinny_sidebar_enable', $request->variable('vinny_sidebar_enable', 1));
				$config->set('vinny_sidebar_left_enable', $request->variable('vinny_sidebar_left_enable', 1));
				$config->set('vinny_sidebar_right_enable', $request->variable('vinny_sidebar_right_enable', 1));
				$config->set('vinny_sidebar_hide_toggles', $request->variable('vinny_sidebar_hide_toggles', 0));
				$config->set('vinny_sidebar_clock_format', $request->variable('vinny_sidebar_clock_format', '24'));
				$exclude_array = $request->variable('vinny_sidebar_exclude_pages', array(''));
				$config->set('vinny_sidebar_exclude_pages', implode(',', $exclude_array));

				trigger_error($language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
			}

			$available_pages = ['index', 'viewforum', 'viewtopic', 'posting', 'ucp', 'mcp', 'search', 'memberlist', 'viewonline'];
			$excluded = explode(',', $config['vinny_sidebar_exclude_pages']);
			$options = '';
			foreach ($available_pages as $page)
			{
				$selected = (in_array($page, $excluded)) ? ' selected="selected"' : '';
				$options .= '<option value="' . $page . '"' . $selected . '>' . $page . '</option>';
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
			$action = $request->variable('action', '');
			$block_id = $request->variable('block', 0);

			if ($request->is_set_post('add'))
			{
				$action = 'add';
			}

			if ($action == 'add' || $action == 'edit')
			{
				$block_data = [];
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
				}

				$submit = $request->is_set_post('submit');
				if ($submit)
				{
					if (!check_form_key('vinny_sidebar'))
					{
						trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$block_data = [
						'block_name'	=> $request->variable('block_name', '', true),
						'block_content'	=> $request->variable('block_content', '', true),
						'sidebar_side'	=> $request->variable('sidebar_side', 'left'),
						'block_enabled'	=> $request->variable('block_enabled', 1),
					];

					if ($block_data['block_name'] === '')
					{
						trigger_error($language->lang('BLOCK_NAME_EMPTY') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if ($block_data['block_content'] === '')
					{
						trigger_error($language->lang('BLOCK_CONTENT_EMPTY') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if (preg_match_all('/[\x{10000}-\x{10FFFF}]/u', $block_data['block_content'], $matches))
					{
						trigger_error($language->lang('BLOCK_CONTENT_ILLEGAL_CHARS') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if ($action == 'add')
					{
						$sql = 'SELECT MAX(block_order) AS max_order FROM ' . $blocks_table . ' WHERE sidebar_side = \'' . $db->sql_escape($block_data['sidebar_side']) . '\'';
						$result = $db->sql_query($sql);
						$block_data['block_order'] = (int) $db->sql_fetchfield('max_order') + 10;
						$db->sql_freeresult($result);

						$sql = 'INSERT INTO ' . $blocks_table . ' ' . $db->sql_build_array('INSERT', $block_data);
						$db->sql_query($sql);
						trigger_error($language->lang('BLOCK_ADDED') . adm_back_link($this->u_action));
					}
					else
					{
						$sql = 'UPDATE ' . $blocks_table . ' SET ' . $db->sql_build_array('UPDATE', $block_data) . ' WHERE block_id = ' . (int) $block_id;
						$db->sql_query($sql);
						trigger_error($language->lang('BLOCK_UPDATED') . adm_back_link($this->u_action));
					}
				}

				$template->assign_vars([
					'S_EDIT_BLOCK' 		=> true,
					'U_ACTION' 			=> $this->u_action . '&amp;action=' . $action . ($block_id ? '&amp;block=' . $block_id : ''),
					'BLOCK_NAME'		=> (isset($block_data['block_name'])) ? $block_data['block_name'] : '',
					'BLOCK_CONTENT'		=> (isset($block_data['block_content'])) ? $block_data['block_content'] : '',
					'SIDEBAR_SIDE'		=> (isset($block_data['sidebar_side'])) ? $block_data['sidebar_side'] : 'left',
					'BLOCK_ENABLED'		=> (isset($block_data['block_enabled'])) ? $block_data['block_enabled'] : 1,
					'U_BACK'			=> $this->u_action,
				]);
			}
			else if ($action == 'delete' && $block_id)
			{
				if (confirm_box(true))
				{
					$sql = 'SELECT block_is_system FROM ' . $blocks_table . ' WHERE block_id = ' . (int) $block_id;
					$result = $db->sql_query($sql);
					$is_system = (bool) $db->sql_fetchfield('block_is_system');
					$db->sql_freeresult($result);

					if ($is_system)
					{
						trigger_error($language->lang('CANNOT_DELETE_SYSTEM_BLOCK') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$sql = 'DELETE FROM ' . $blocks_table . ' WHERE block_id = ' . (int) $block_id;
					$db->sql_query($sql);
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
				
				$sql = 'UPDATE ' . $blocks_table . ' SET sidebar_side = \'' . $db->sql_escape($new_side) . '\' WHERE block_id = ' . (int) $block_id;
				$db->sql_query($sql);

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
					$sql = 'SELECT block_id, block_order FROM ' . $blocks_table . '
						WHERE sidebar_side = \'' . $db->sql_escape($current_side) . '\'
							AND block_order ' . $sql_compare . ' ' . (int) $current_order . '
						ORDER BY block_order ' . $sql_order_dir;
					$result = $db->sql_query_limit($sql, 1);
					$adjacent_row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if ($adjacent_row)
					{
						// Swap orders
						$db->sql_query('UPDATE ' . $blocks_table . ' SET block_order = ' . (int) $adjacent_row['block_order'] . ' WHERE block_id = ' . (int) $block_id);
						$db->sql_query('UPDATE ' . $blocks_table . ' SET block_order = ' . (int) $current_order . ' WHERE block_id = ' . (int) $adjacent_row['block_id']);

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
					foreach ($order_data as $side => $ids)
					{
						if ($side !== 'left' && $side !== 'right') continue;
						
						if (is_array($ids))
						{
							foreach ($ids as $index => $id)
							{
								$sql = 'UPDATE ' . $blocks_table . ' 
										SET block_order = ' . (int) ($index * 10) . ', 
											sidebar_side = \'' . $db->sql_escape($side) . '\' 
										WHERE block_id = ' . (int) $id;
								$db->sql_query($sql);
							}
						}
					}
				}

				$json_response = new \phpbb\json_response;
				$json_response->send(['success' => true]);
			}
			else
			{
				// Block List View
				$sql = 'SELECT * FROM ' . $blocks_table . ' ORDER BY sidebar_side ASC, block_order ASC';
				$result = $db->sql_query($sql);
				
				while ($row = $db->sql_fetchrow($result))
				{
					$block_var_name = ($row['sidebar_side'] == 'left') ? 'blocks_left' : 'blocks_right';
					$template->assign_block_vars($block_var_name, [
						'ID'		=> $row['block_id'],
						'NAME'		=> $language->lang($row['block_name']),
						'SIDE'		=> $row['sidebar_side'],
						'ORDER'		=> $row['block_order'],
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
					'U_ACTION' 			=> $this->u_action,
					'U_ADD'	   			=> $this->u_action . '&amp;action=add',
					'U_UPDATE_ORDER'	=> $this->u_action . '&amp;action=update_order',
					'UPDATE_ORDER_HASH'	=> generate_link_hash('update_order'),
				]);
			}
		}
	}
}
