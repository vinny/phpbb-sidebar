$(document).ready(function() {
	var sidebarBlocksData = $('#sidebar-blocks-data');
	var updateOrderURL = sidebarBlocksData.attr('data-url');
	var updateOrderHash = sidebarBlocksData.attr('data-hash');

	if (updateOrderURL && updateOrderURL.indexOf('&amp;') !== -1) {
		updateOrderURL = updateOrderURL.replace(/&amp;/g, '&');
	}

	// AJAX order submit
	function saveNewOrder() {
		var leftBlocks = [];
		$('#sidebar-left-list tr[data-id]').each(function() { leftBlocks.push($(this).data('id')); });
		
		var rightBlocks = [];
		$('#sidebar-right-list tr[data-id]').each(function() { rightBlocks.push($(this).data('id')); });

		$.ajax({
			url: updateOrderURL,
			type: 'POST',
			data: {
				action: 'update_order',
				order: JSON.stringify({
					left: leftBlocks,
					right: rightBlocks
				}),
				hash: updateOrderHash
			},
			success: function(response) {
				// For reload to sync U_MOVE_UP, U_MOVE_DOWN URLs properly!
				window.location.reload(); 
			}
		});
	}

	// Initialize SortableJS
	var leftList = document.getElementById('sidebar-left-list');
	if (leftList && typeof Sortable !== 'undefined') {
		Sortable.create(leftList, {
			group: 'shared',
			animation: 150,
			handle: '.drag-handle',
			filter: '.empty-row',
			onEnd: saveNewOrder
		});
	}

	var rightList = document.getElementById('sidebar-right-list');
	if (rightList && typeof Sortable !== 'undefined') {
		Sortable.create(rightList, {
			group: 'shared',
			animation: 150,
			handle: '.drag-handle',
			filter: '.empty-row',
			onEnd: saveNewOrder
		});
	}

	// Override traditional UP, DOWN, and MOVE SIDE buttons to trigger standard redirects 
	// Instead of broken DOM structures so the page re-renders properly
	$('.move-up-btn, .move-down-btn, .move-side-btn').on('click', function(e) {
		e.preventDefault();
		window.location.href = $(this).attr('href');
	});
});

phpbb.addAjaxCallback('sidebar_toggle_enabled', function(res) {
	var $el = $(this);
	var $icon = $el.find('i.icon');
	$icon.removeClass('fa-check-circle fa-times-circle')
		.addClass(res.icon_class)
		.css('color', res.icon_color)
		.attr('title', res.title)
		.attr('data-original-title', res.title);
});
