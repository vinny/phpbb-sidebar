<?php
/**
 *
 * @package phpBB Extension - vinny/sidebar
 * @copyright (c) Vinny
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace vinny\sidebar\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\controller\helper */
	protected $controller_helper;

	/** @var string */
	protected $table_prefix;

	/** @var string */
	protected $phpbb_root_path;

	/**
	 * Constructor
	 *
	 * @param \phpbb\template\template $template Template object
	 * @param \phpbb\user $user User object
	 * @param \phpbb\config\config $config Config object
	 * @param \phpbb\db\driver\driver_interface $db Database object
	 * @param \phpbb\request\request $request Request object
	 * @param \phpbb\auth\auth $auth Auth object
	 * @param \phpbb\controller\helper $controller_helper Controller helper
	 * @param string $table_prefix Table prefix
	 * @param string $phpbb_root_path Root path
	 */
	public function __construct(\phpbb\template\template $template, \phpbb\user $user, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\auth\auth $auth, \phpbb\controller\helper $controller_helper, $table_prefix, $phpbb_root_path)
	{
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->auth = $auth;
		$this->controller_helper = $controller_helper;
		$this->table_prefix = $table_prefix;
		$this->phpbb_root_path = $phpbb_root_path;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.page_header'	=> 'on_page_header',
			'core.user_setup'	=> 'load_language_on_setup',
		];
	}

	/**
	 * Load language file
	 *
	 * @param \phpbb\event\data $event The event object
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'vinny/sidebar',
			'lang_set' => 'sidebar',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Inject sidebar logic into page header
	 *
	 * @param \phpbb\event\data $event The event object
	 */
	public function on_page_header($event)
	{
		$enable_global = (bool) $this->config['vinny_sidebar_enable'];

		if (!$enable_global)
		{
			return;
		}

		$current_page = $this->user->page['page_name'] ?? '';
		$current_base = ($pos = strpos($current_page, '.')) !== false ? substr($current_page, 0, $pos) : $current_page;
		$excluded = explode(',', $this->config['vinny_sidebar_exclude_pages']);

		if (in_array($current_base, $excluded))
		{
			return;
		}

		$enable_left = (bool) $this->config['vinny_sidebar_left_enable'];
		$enable_right = (bool) $this->config['vinny_sidebar_right_enable'];

		$this->template->assign_vars([
			'S_VINNY_SIDEBAR_LEFT_ENABLED'	=> $enable_left,
			'S_VINNY_SIDEBAR_RIGHT_ENABLED'	=> $enable_right,
			'S_VINNY_SIDEBAR_HIDE_TOGGLES'	=> (bool) $this->config['vinny_sidebar_hide_toggles'],
		]);

		// Render blocks

			$sql = 'SELECT * FROM ' . $this->table_prefix . 'vinny_sidebar_blocks WHERE block_enabled = 1 ORDER BY block_order ASC';
			$result = $this->db->sql_query($sql);
			
			while ($row = $this->db->sql_fetchrow($result))
			{
				$title = $this->user->lang($row['block_name']);
				$content = htmlspecialchars_decode($row['block_content'], ENT_COMPAT);
				$template_file = '';

				if ($row['block_is_system'])
				{
					switch ($row['block_name'])
					{
						case 'SIDEBAR_WELCOME':
							$user_id = (int) $this->user->data['user_id'];
							$avatar = \phpbb_get_user_avatar($this->user->data);
							$username_full = \get_username_string('full', $user_id, $this->user->data['username'], $this->user->data['user_colour']);
							
							$this->template->assign_vars([
								'SIDEBAR_USER_AVATAR'	=> $avatar,
								'SIDEBAR_USER_FULL'		=> $username_full,
							]);

							$content = str_replace('{USERNAME}', $this->user->data['username'], $this->user->lang('SIDEBAR_WELCOME_CONTENT'));
							$template_file = 'blocks/welcome.html';
							break;

						case 'SIDEBAR_NEWEST_MEMBER':
							$template_file = 'blocks/newest_member.html';
							$this->template->assign_vars([
								'SIDEBAR_NEWEST_USER' => \get_username_string('full', $this->config['newest_user_id'], $this->config['newest_username'], $this->config['newest_user_colour']),
							]);
							break;

						case 'SIDEBAR_STATISTICS':
							$template_file = 'blocks/statistics.html';
							$this->template->assign_vars([
								'SIDEBAR_STAT_POSTS'   => $this->config['num_posts'],
								'SIDEBAR_STAT_TOPICS'  => $this->config['num_topics'],
								'SIDEBAR_STAT_USERS'   => $this->config['num_users'],
							]);
							break;

						case 'SIDEBAR_SEARCH':
							$template_file = 'blocks/search.html';
							$this->template->assign_vars([
								'U_SEARCH' => \append_sid("{$this->phpbb_root_path}search.php"),
							]);
							break;

						case 'SIDEBAR_MENU':
							$template_file = 'blocks/menu.html';
							break;

						case 'SIDEBAR_RECENT_TOPICS':
							$template_file = 'blocks/recent_topics.html';
							$this->render_recent_topics();
							break;

						case 'SIDEBAR_RECENT_POSTS':
							$template_file = 'blocks/recent_posts.html';
							$this->render_recent_posts();
							break;
							
						case 'SIDEBAR_CLOCK':
							$template_file = 'blocks/clock.html';
							$this->template->assign_vars([
								'SIDEBAR_CLOCK_FORMAT' => isset($this->config['vinny_sidebar_clock_format']) ? $this->config['vinny_sidebar_clock_format'] : '24',
							]);
							break;
							
						case 'SIDEBAR_CALENDAR':
							$template_file = 'blocks/calendar.html';
							break;
					}
				}

				$block_data = [
					'TITLE'			=> $title,
					'CONTENT'		=> $content,
					'TEMPLATE_FILE'	=> $template_file,
				];
				
				if ($row['sidebar_side'] == 'left' && $enable_left)
				{
					$this->template->assign_block_vars('vinny_sidebar_left_blocks', $block_data);
				}
				else if ($row['sidebar_side'] == 'right' && $enable_right)
				{
					$this->template->assign_block_vars('vinny_sidebar_right_blocks', $block_data);
				}
			}
			$this->db->sql_freeresult($result);
	}

	/**
	 * Render recent topics
	 */
	protected function render_recent_topics()
	{
		$forum_ary = array_unique(array_keys($this->auth->acl_getf('f_read', true)));
		$forum_ary = array_diff($forum_ary, $this->user->get_passworded_forums());
		if (empty($forum_ary)) return;

		$sql = 'SELECT t.topic_id, t.topic_title, t.topic_poster, t.topic_first_poster_name, t.topic_time, u.username, u.user_colour
			FROM ' . TOPICS_TABLE . ' t
			LEFT JOIN ' . USERS_TABLE . ' u ON (t.topic_poster = u.user_id)
			WHERE ' . $this->db->sql_in_set('t.forum_id', $forum_ary) . '
				AND t.topic_visibility = 1
			ORDER BY t.topic_time DESC';
		$result = $this->db->sql_query_limit($sql, 5, 0, 300);
		
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('sidebar_recent_topics', [
				'U_TOPIC' 		=> \append_sid("{$this->phpbb_root_path}viewtopic.php", 't=' . $row['topic_id']),
				'TOPIC_TITLE' 	=> \censor_text($row['topic_title']),
				'USERNAME_FULL' => \get_username_string('full', $row['topic_poster'], $row['username'], $row['user_colour'], $row['topic_first_poster_name']),
				'TIME'			=> $this->user->format_date($row['topic_time']),
			]);
		}
		$this->db->sql_freeresult($result);
	}

	/**
	 * Render recent posts
	 */
	protected function render_recent_posts()
	{
		$forum_ary = array_unique(array_keys($this->auth->acl_getf('f_read', true)));
		$forum_ary = array_diff($forum_ary, $this->user->get_passworded_forums());
		if (empty($forum_ary)) return;

		$sql = 'SELECT p.post_id, p.topic_id, p.post_subject, p.poster_id, p.post_username, p.post_time, u.username, u.user_colour
			FROM ' . POSTS_TABLE . ' p
			LEFT JOIN ' . USERS_TABLE . ' u ON (p.poster_id = u.user_id)
			WHERE ' . $this->db->sql_in_set('p.forum_id', $forum_ary) . '
				AND p.post_visibility = 1
			ORDER BY p.post_time DESC';
		$result = $this->db->sql_query_limit($sql, 5, 0, 300);
		
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('sidebar_recent_posts', [
				'U_POST' 		=> \append_sid("{$this->phpbb_root_path}viewtopic.php", 'p=' . $row['post_id'] . '#p' . $row['post_id']),
				'POST_SUBJECT' 	=> \censor_text($row['post_subject']),
				'USERNAME_FULL' => \get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
				'TIME'			=> $this->user->format_date($row['post_time']),
			]);
		}
		$this->db->sql_freeresult($result);
	}

}
