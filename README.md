# Sidebar Manager for phpBB

## Extension Description
A flexible sidebar management system for phpBB forums. It allows administrators to add, organize, and customise widgets on both the left and right sides of the board.

## Features

- **Dual Sidebars:** Independent left and right sidebar layout support.
- **Drag & Drop ACP:** Intuitive Admin Control Panel interface to easily reorder and move blocks between layout columns.
- **Responsive & Native:** Automatically hides on mobile devices and features a seamless Flexbox integration that perfectly adapts to any desktop screen resolution.
- **Toggleable Sidebars:** Users can manually collapse or expand sidebars for a distraction-free reading experience (user preference is saved via cookies).
- **Custom HTML Blocks:** Create your own unlimited personalized widgets using custom HTML.
- **Built-in System Blocks:** Comes ready out-of-the-box with useful widgets like Welcome Panel, Forum Statistics, Quick Search, Clock, Calendar, Newest Member, and Recent Topics/Posts.
- **Page Exclusion Rules:** Choose specific pages where the sidebars should be hidden.
- **Granular Control:** Quickly enable, disable, or delete individual blocks directly from the admin panel with a single click.

## Dynamic Block Extensions

Sidebar Manager can also be extended by child extensions.

The recommended base for creating PHP-driven sidebar blocks is:

- [`vinny/sidebarblock_skeleton`](https://github.com/vinny/phpbb-sidebarblock-skeleton)

Use the skeleton when a block needs to read data from phpBB, another extension, or custom PHP logic. Examples include birthdays, groups, polls, banned users, mChat data, Quick Style data, or any other dynamic forum content.

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

Child extensions integrate through the `vinny.sidebar.render_system_block` event. This keeps Sidebar Manager stable while allowing new blocks to be distributed as separate extensions.

## Support

[![Buy me a coffee and support this extension](https://camo.githubusercontent.com/201ef269611db7eb6b5d08e9f756ab8980df3014b64492770bdf13a6ed924641/68747470733a2f2f6b6f2d66692e636f6d2f696d672f676974687562627574746f6e5f736d2e737667)](https://ko-fi.com/vinny1)

## License

[GNU General Public License v2](license.txt)
