(function() {
	'use strict';

	document.addEventListener('DOMContentLoaded', function() {
		var clockContainer = document.querySelector('.vinny-sidebar-clock-container');
		if (!clockContainer) {
			return;
		}

		var clockFormat = clockContainer.getAttribute('data-clock-format') || '24';
		var amText = clockContainer.getAttribute('data-am') || '';
		var pmText = clockContainer.getAttribute('data-pm') || '';
		var timeElement = document.getElementById('vinny-clock-time');
		var ampmElement = document.getElementById('vinny-clock-ampm');

		if (!timeElement || !ampmElement) {
			return;
		}

		function updateClock() {
			var now = new Date();
			var hours = now.getHours();
			var minutes = String(now.getMinutes()).padStart(2, '0');
			var seconds = String(now.getSeconds()).padStart(2, '0');
			var ampm = '';

			if (clockFormat === '12') {
				ampm = hours >= 12 ? pmText : amText;
				hours = hours % 12;
				hours = hours ? hours : 12;
				ampmElement.textContent = ampm;
				ampmElement.style.display = 'inline-block';
			} else {
				ampmElement.style.display = 'none';
			}

			hours = String(hours).padStart(2, '0');
			timeElement.textContent = hours + ':' + minutes + ':' + seconds;
		}

		setInterval(updateClock, 1000);
		updateClock();
	});
})();
