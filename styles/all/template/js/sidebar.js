(function($) {
	'use strict';

	// Path-scoped key so multiple boards on the same domain never clash
	var boardPath = window.location.pathname.replace(/\/[^/]*$/, '');
	var storagePrefix = 'phpbb_sidebar_' + boardPath + '_';

	function setSidebarState(side, isHidden) {
		try {
			if (window.localStorage) {
				window.localStorage.setItem(storagePrefix + side, isHidden ? '1' : '0');
			}
		} catch {
			// Storage unavailable or disabled
		}
	}

	function getSidebarState(side) {
		try {
			if (window.localStorage) {
				return window.localStorage.getItem(storagePrefix + side);
			}
		} catch {
			// Storage unavailable or disabled
		}
		return null;
	}

	function syncToggleButton(side, isHidden) {
		var sidebar = $('#vinny-sidebar-' + side);
		var toggleBtn = sidebar.children('.vinny-sidebar-toggle');
		var icon = toggleBtn.find('i');

		if (isHidden) {
			sidebar.addClass('vinny-sidebar-hidden');
			toggleBtn.attr('aria-expanded', 'false');
			if (side === 'left') {
				icon.removeClass('fa-chevron-left').addClass('fa-chevron-right');
			} else {
				icon.removeClass('fa-chevron-right').addClass('fa-chevron-left');
			}
		} else {
			sidebar.removeClass('vinny-sidebar-hidden');
			toggleBtn.attr('aria-expanded', 'true');
			if (side === 'left') {
				icon.removeClass('fa-chevron-right').addClass('fa-chevron-left');
			} else {
				icon.removeClass('fa-chevron-left').addClass('fa-chevron-right');
			}
		}
	}

	function toggleSidebar(side) {
		var sidebar = $('#vinny-sidebar-' + side);
		var hiddenClass = 'vinny-sidebar-' + side + '-hidden';
		var isHidden = document.documentElement.classList.contains(hiddenClass) || sidebar.hasClass('vinny-sidebar-hidden');

		if (!isHidden) {
			// Hide
			document.documentElement.classList.add(hiddenClass);
			syncToggleButton(side, true);
			setSidebarState(side, true);
		} else {
			// Show
			document.documentElement.classList.remove(hiddenClass);
			syncToggleButton(side, false);
			setSidebarState(side, false);
		}
	}

	$(function() {
		$('.vinny-sidebar-toggle').on('click', function() {
			var side = $(this).data('side');
			toggleSidebar(side);
		});

		// Synchronize toggle buttons quietly based on pre-rendered or stored state
		var isLeftHidden = document.documentElement.classList.contains('vinny-sidebar-left-hidden') || getSidebarState('left') === '1';
		var isRightHidden = document.documentElement.classList.contains('vinny-sidebar-right-hidden') || getSidebarState('right') === '1';

		if (isLeftHidden) {
			document.documentElement.classList.add('vinny-sidebar-left-hidden');
			syncToggleButton('left', true);
		}
		if (isRightHidden) {
			document.documentElement.classList.add('vinny-sidebar-right-hidden');
			syncToggleButton('right', true);
		}
	});
})(jQuery);
