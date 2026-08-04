# Sidebar Manager for phpBB [![Build Status](https://github.com/vinny/phpbb-sidebar/workflows/Tests/badge.svg)](https://github.com/vinny/phpbb-sidebar/actions)

Sidebar Manager for phpBB adds a flexible way to manage sidebars across your forum. It lets administrators create, organize, and position widgets on the left or right side of the board.

## Features

- **Dual sidebars:** Support for independent left and right sidebar layouts.
- **Drag-and-drop ACP:** Reorder blocks and move them between columns from the Admin Control Panel.
- **Responsive layout:** Automatically adapts to desktop screens and hides sidebars on mobile devices.
- **Toggleable sidebars:** Let users collapse or expand sidebars for a cleaner reading experience. User preference is stored via cookies.
- **Custom HTML and BBCode blocks:** Create your own widgets using HTML or BBCode.
- **Built-in system blocks:** Includes useful blocks such as Welcome Panel, Forum Statistics, Quick Search, Clock, Calendar, Newest Member, and Recent Topics/Posts.
- **Page exclusion rules:** Choose which pages should not display sidebars.
- **Quick controls:** Enable, disable, or delete blocks directly from the admin panel.

## Why Sidebar Manager exists

Sidebar Manager was built for phpBB forums that need a cleaner way to add useful content without complicating the layout. It gives administrators full control over sidebars, widgets, and visibility, while keeping the forum easy to use and easy to maintain.

## Dynamic block extensions

Sidebar Manager can also be extended with child extensions.

For PHP-driven sidebar blocks, the recommended base is:

- [`vinny/sidebarblock_skeleton`](https://github.com/vinny/phpbb-sidebarblock-skeleton)

Use the skeleton when a block needs to read data from phpBB, another extension, or custom PHP logic. Typical examples include birthdays, groups, polls, banned users, mChat data, Quick Style data, or any other dynamic forum content.

Sidebar Manager remains responsible for:

- ACP management;
- sidebar side selection;
- block ordering;
- enabled/disabled state;
- frontend sidebar layout;
- rendering the block container.

The child extension is responsible for:

- registering its system block;
- querying and preparing dynamic data;
- checking permissions and board settings;
- assigning template variables;
- providing the block-specific template and CSS.

Child extensions integrate through the `vinny.sidebar.render_block` event. This keeps Sidebar Manager stable while still allowing new blocks to be distributed separately.

## Support

[![Buy me a coffee and support this extension](https://camo.githubusercontent.com/201ef269611db7eb6b5d08e9f756ab8980df3014b64492770bdf13a6ed924641/68747470733a2f2f6b6f2d66692e636f6d2f696d672f676974687562627574746f6e5f736d2e737667)](https://ko-fi.com/vinny1)

## License

[GNU General Public License v2](license.txt)