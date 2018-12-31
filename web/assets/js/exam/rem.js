

(function(doc, win) {
	var docEl = doc.documentElement,
			isIOS = navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
			dpr = isIOS ? Math.min(win.devicePixelRatio, 3) : 1,
			dpr = window.top === window.self ? dpr : 1, 
			resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';
	docEl.dataset.dpr = dpr;
	var recalc = function() {
		var width = docEl.clientWidth;
		if (width / dpr > 1930) {
			width = 1930 * dpr;
		}
		docEl.dataset.width = width;
		docEl.dataset.percent = 20 * (width / 320);
		docEl.style.fontSize = 20 * (width / 320) + 'px';
	};
	recalc();
	if (!doc.addEventListener) return;
	win.addEventListener(resizeEvt, recalc, false);
})(document, window);


//头部事件
   $(function(){
   	  $('.homeHeadTog').hover(function(){
   	  	$('.headToggle').fadeToggle();
   	  })
   })
