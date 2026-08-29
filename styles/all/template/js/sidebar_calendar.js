(function($) {
	'use strict';

	$(function() {
		var calendar = $('#vinny-sidebar-calendar');
		if (!calendar.length) {
			return;
		}

		var monthsAttr = calendar.data('months');
		var daysAttr = calendar.data('days');

		var months = monthsAttr ? monthsAttr.split(',') : [];
		var days = daysAttr ? daysAttr.split(',') : [];

		if (months.length < 12 || days.length < 7) {
			return;
		}

		var colors = [
			'#16a085', '#1abc9c', '#c0392b', '#27ae60', '#ff6860', '#f39c12',
			'#f1c40f', '#e67e22', '#2ecc71', '#e74c3c', '#d35400', '#2c3e50'
		];

		var header = calendar.find('#vinny_calendar_header');
		var weekdays = calendar.find('#vinny_calendar_weekdays');
		var content = calendar.find('#vinny_calendar_content');

		var curYear = 2026;
		var curMonth = 1;

		function initDate() {
			var now = new Date();
			curYear = now.getFullYear();
			curMonth = now.getMonth() + 1;
		}

		function daysInMonth(yr, mo) {
			return (new Date(yr, mo, 0)).getDate();
		}

		function dayOfWeek(yr, mo, day) {
			return (new Date(yr, mo - 1, day)).getDay();
		}

		function isToday(yr, mo, day) {
			var now = new Date();
			return now.getFullYear() === yr && (now.getMonth() + 1) === mo && now.getDate() === day;
		}

		function renderWeekdays() {
			weekdays.empty();
			for (var e = 0; e < 7; e++) {
				weekdays.append('<div>' + days[e].substring(0, 3) + '</div>');
			}
		}

		function renderCalendar() {
			renderWeekdays();
			var daysList = [];
			var totalDays = daysInMonth(curYear, curMonth);
			for (var r = 1; r <= totalDays; r++) {
				daysList.push({ day: r, weekday: days[dayOfWeek(curYear, curMonth, r)] });
			}

			var rIdx = 0;
			var uFlag = false;
			content.empty();

			while (!uFlag && rIdx < 7) {
				if (days[rIdx] === daysList[0].weekday) {
					uFlag = true;
				} else {
					content.append('<div class="blank"></div>');
					rIdx++;
				}
			}

			for (var cIdx = 0; cIdx < 42 - rIdx; cIdx++) {
				if (cIdx >= daysList.length) {
					content.append('<div class="blank"></div>');
				} else {
					var vVal = daysList[cIdx].day;
					var isTod = isToday(curYear, curMonth, vVal);
					var mVal = isTod ? '<div class="today">' : '<div>';
					content.append(mVal + vVal + '</div>');
				}
			}

			var colorVal = colors[curMonth - 1];
			header.css('background-color', colorVal).find('h1').text(months[curMonth - 1] + ' ' + curYear);
			content.find('.today').css('background-color', colorVal).css('color', '#fff');
		}

		initDate();
		renderCalendar();

		header.find('i').on('click', function() {
			var isLeft = $(this).hasClass('fa-chevron-left');
			curMonth = isLeft ? curMonth - 1 : curMonth + 1;
			if (curMonth < 1) {
				curMonth = 12;
				curYear--;
			} else if (curMonth > 12) {
				curMonth = 1;
				curYear++;
			}
			renderCalendar();
		});
	});
})(jQuery);
