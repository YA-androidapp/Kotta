jQuery.fn.kirinlyric = function(conf) {

	var cls = '.kirinlyric';
	var farPrev = conf.farPrev || 'far-prev';
	var prev = conf.prev || 'prev';
	var current = conf.current || 'current';
	var next = conf.next || 'next';
	var farNext = conf.farNext || 'far-next';
	var $audio = $(this);
	var lrc = parseLRC(conf.lrc);
	var $target = $(conf.target).html('<span class="kirinlyric blank-row ' + farPrev + '"></span><span class="kirinlyric blank-row ' + prev + '"></span>');

	// generate HTML
	var html = [];
	$.each(lrc, function(idx, row) {
		if (((row.text).indexOf('@')) == 0) {
		} else if (/^raw/.test(row.time)) {
			html.push((row.text).replace(/\[(\d{2}):(\d{2})[:.](\d{2})\]/g,''));
		} else {
			html.push('<span class="kirinlyric" data-time="' + row.time + '">' + (row.text).replace(/\[(\d{2}):(\d{2})[:.](\d{2})\]/g,'') + '<br></span>');
		}
	});
	$target.append(html.join('')).append('<span class="kirinlyric blank-row"></span><span class="kirinlyric blank-row"></span>');

	// monitoring
	function loop() {
		var currentTime = $audio.prop('currentTime');
		var $spans = $(cls);
		var prePosition = 0;

		$spans.removeClass(prev).removeClass(current).removeClass(next).removeClass(farPrev).removeClass(farNext).each(function(idx, span) {
			var $farPrev = $(($spans[idx - 2]));
			var $prev    = $(($spans[idx - 1]));
			var $span    = $(span);
			var $next    = $(($spans[idx + 1]));
			var $farNext = $(($spans[idx + 2]));
			var time     = $span.data('time');
			var nextTime = $next.data('time');

			if (currentTime > time && typeof nextTime == 'undefined' || currentTime < nextTime - 0.5) {
				$farPrev.addClass(farPrev);
				$prev.addClass(prev);
				$span.addClass(current);
				$next.addClass(next);
				$farNext.addClass(farNext);
				if(jQuery('#checkbox_auto #enable_lyric').prop('checked')){
					if (!$audio.paused) {
						var position = ( ((jQuery($farPrev).position().top)>0) ? (jQuery($farPrev).position().top) : (jQuery($span).position().top) )
								- (jQuery(cls+"[data-time]").position().top);
						position = (position > 0) ? position : 0;
						if (position > prePosition) {
							prePosition = position;
							jQuery('#lyrics').animate({scrollTop:position}, 10, 'swing');
						}
					}
				}
				return false;
			}
		});
	}

	setInterval(loop, 300);

	// convert lrc string to object
	function parseLRC(lrcStr) {
		var lrc = [];
		var arr = lrcStr.split(/\r\n|\r|\n|　/);
		$.each(arr, function(idx, row) {
			var time = row.match(/^([^\[]*)\[(\d{2}):(\d{2})[:.](\d{2})\](.*)$/);
			if (time && time.length == 6) {
				var sec = (Number(time[2]) * 60 + Number(time[3])) + Number(time[4]) / 100;
				lrc.push({
					time : sec,
					text : time[1]+time[5]
				});
			} else {
				lrc.push({
					time : 'raw' + idx,
					text : row
				});
			}
		});
		return lrc;
	}
};
