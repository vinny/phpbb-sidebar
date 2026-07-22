<?php
/**
 *
 * Sidebar Manager extension. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026 Vinny <https://github.com/vinny/phpbb-sidebar>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace vinny\sidebar\tests\event;

class main_listener_test extends \phpbb_test_case
{
	protected $template;
	protected $user;
	protected $config;
	protected $db;
	protected $auth;
	protected $dispatcher;
	protected $listener;

	public function setUp(): void
	{
		parent::setUp();

		$this->template = $this->createMock('\phpbb\template\template');
		$this->user = $this->createMock('\phpbb\user');
		$this->config = new \phpbb\config\config([
			'vinny_sidebar_enable' => 1,
			'vinny_sidebar_left_enable' => 1,
			'vinny_sidebar_right_enable' => 1,
			'vinny_sidebar_exclude_pages' => 'index,viewtopic',
			'vinny_sidebar_hide_toggles' => 0,
		]);
		$this->db = $this->createMock('\phpbb\db\driver\driver_interface');
		$this->auth = $this->createMock('\phpbb\auth\auth');
		$this->dispatcher = $this->createMock('\phpbb\event\dispatcher_interface');
	}

	public function test_getSubscribedEvents()
	{
		$events = \vinny\sidebar\event\listener::getSubscribedEvents();
		$this->assertArrayHasKey('core.page_header', $events);
		$this->assertArrayHasKey('core.user_setup', $events);
		$this->assertEquals('on_page_header', $events['core.page_header']);
		$this->assertEquals('load_language_on_setup', $events['core.user_setup']);
	}

	public function test_load_language_on_setup()
	{
		$listener = new \vinny\sidebar\event\listener(
			$this->template,
			$this->user,
			$this->config,
			$this->db,
			$this->auth,
			$this->dispatcher,
			'phpbb_',
			'./',
			null
		);

		$event = new \phpbb\event\data(['lang_set_ext' => []]);
		$listener->load_language_on_setup($event);

		$lang_set = $event['lang_set_ext'];
		$this->assertCount(1, $lang_set);
		$this->assertEquals('vinny/sidebar', $lang_set[0]['ext_name']);
		$this->assertEquals('sidebar', $lang_set[0]['lang_set']);
	}

	public function test_on_page_header_disabled_globally()
	{
		$this->config['vinny_sidebar_enable'] = 0;

		$listener = new \vinny\sidebar\event\listener(
			$this->template,
			$this->user,
			$this->config,
			$this->db,
			$this->auth,
			$this->dispatcher,
			'phpbb_',
			'./',
			null
		);

		$this->template->expects($this->never())->method('assign_vars');

		$event = new \phpbb\event\data([]);
		$listener->on_page_header($event);
	}
}
