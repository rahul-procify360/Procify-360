;(function ($, window, document, undefined) {

	if($('#barba-wrapper').length) {

// get index of an element in its parent node
		function indexInParent(node) {
			var children = node.parentNode.childNodes;
			var num = 0;
			for (var i = 0; i < children.length; i++) {
				if (children[i] == node) return num;
				if (children[i].nodeType == 1) num++;
			}
			return -1;
		}

// element(index) selector
		function eq(index) {
			if (index >= 0 && index < this.length)
				return this[index];
			else
				return -1;
		}

// ---------- Loading Screen ---------- //

		function triggerResize() {
			var ev = document.createEvent('HTMLEvents');
			ev.initEvent('resize', true, false);
			window.dispatchEvent(ev);
		}

// Dynamic Load for Barba

		function runDynamicLoad(content) {

			var img = content.querySelectorAll('img');
			var c = 0;
			var tot = img.length;

			if (tot == 0) {
				setTimeout(function () {
					doneDynamicLoad();
				}, 100);
			}

			function imgLoaded() {
				c += 1;

				if (c === tot) {
					setTimeout(function () {
						doneDynamicLoad();
					}, 200);
				}
			}

			for (var i = 0; i < tot; i++) {
				var tImg = new Image();
				tImg.onload = imgLoaded;
				tImg.onerror = imgLoaded;
				tImg.src = img[i].src;
			}

			function doneDynamicLoad() {
				var container = document.querySelector('.barba-container');

				setTimeout(function () {
					init();
					triggerResize();

					TweenMax.to(
						container, .6,
						{alpha: 1}
					);

				}, 500);

				setTimeout(function () {
					triggerResize();
				}, 2000);

			}
		}


//Initialize Functions

		function init() {

			// Global Elements

			var q_slide = document.getElementById('q_slide');

			if (q_slide) {
				qSlide(q_slide)
			}

			window.scroll(0, 0);

			if (!(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))) {
				document.body.classList.remove("horizontal-scroll");
			}
		}

		document.addEventListener("DOMContentLoaded", function () {
			Barba.Pjax.start();
		});

		if ( window.elementorFrontend ) {
			Barba.Pjax.start();
		}

//Barba Events
		Barba.Dispatcher.on('linkClicked', function (el, e) {
			var container = document.querySelector('.barba-container');
			TweenMax.to(
				container, .4,
				{alpha: 0}
			);
		});

		Barba.Dispatcher.on('initStateChange', function () {
			if (typeof ga === 'function') {
				ga('send', 'pageview', location.pathname);
			}
		});

		Barba.Dispatcher.on('newPageReady', function (currentStatus, oldStatus, container) {
			runDynamicLoad(container);
		});

		if ( window.elementorFrontend ) {
			console.log('hi');
			runDynamicLoad(container);
		}

// Q ANIMATE
		function q_animate(element, animation, delay) {

			if (animation === 'stagTop') {
				TweenMax.staggerFromTo(
					element, 1,
					{alpha: 0, y: 130},
					{alpha: 1, y: 0, ease: Expo.easeOut, delay: delay}, 0.15
				);
			}

			if (animation === 'fadeOut') {
				TweenMax.to(
					element, .3,
					{alpha: 0, ease: Power1.easeOut, delay: delay}, 0.15
				);
			}

			if (animation === 'stagLeft') {
				TweenMax.staggerFromTo(
					element, 1.3,
					{alpha: 0, x: 200},
					{alpha: 1, x: 0, ease: Power4.easeOut, delay: delay}, 0.1
				);
			}

			if (animation === 'stagRight') {
				TweenMax.staggerFromTo(
					element, 1.3,
					{alpha: 0, x: -200},
					{alpha: 1, x: 0, ease: Power4.easeOut, delay: delay}, 0.1
				);
			}

			if (animation === 'slideTop') {
				TweenMax.fromTo(
					element, 1.3,
					{alpha: 0, y: 50},
					{alpha: 1, y: 0, ease: Expo.easeOut, delay: delay}
				);
			}


			if (animation === 'slideLeft') {
				TweenMax.fromTo(
					element, 1.3,
					{alpha: 0, xPercent: -100},
					{alpha: 1, xPercent: 0, ease: Expo.easeOut, delay: delay}
				);
			}
			else if (animation === 'sideLeft') {
				TweenMax.staggerFromTo(
					element, 1.3,
					{alpha: 0, x: 120},
					{alpha: 1, x: 0, ease: Expo.easeOut, delay: delay}, 0.2
				);
			}
			else if (animation === 'clientLeft') {
				TweenMax.staggerFromTo(
					element, 1.3,
					{alpha: 0, x: 100},
					{alpha: 1, x: 0, ease: Expo.easeOut, delay: delay}, 0.05
				);
			}
			else if (animation === 'clientRight') {
				TweenMax.staggerFromTo(
					element, 1.3,
					{alpha: 0, x: -100},
					{alpha: 1, x: 0, ease: Expo.easeOut, delay: delay}, 0.05
				);
			}
			else if (animation === 'sideRight') {
				TweenMax.staggerFromTo(
					element, 1.3,
					{alpha: 0, x: -120},
					{alpha: 1, x: 0, ease: Expo.easeOut, delay: delay}, 0.2
				);
			}
			else if (animation === 'clipRight') {
				TweenMax.staggerTo(
					element, 1,
					{clipPath: 'inset(0px 0px 0px 0px)', ease: Expo.easeInOut, delay: delay}, 0.1
				);
			}
			else if (animation === 'splitLeft') {

				var content = element.textContent;
				var letters = content.split("");
				element.innerHTML = "";

				for (var idx = 0; idx < letters.length; idx++) {
					element.innerHTML += "<span>" + letters[idx] + "</span>";
				}

				var chars = element.querySelectorAll('span');

				TweenMax.set(chars, {x: 110, alpha: 0});

				setTimeout(function () {
					TweenMax.staggerTo(
						chars, 1.3,
						{x: 0, alpha: 1, ease: Power4.easeInOut}, 0.03
					);
				}, delay);

			}
			else if (animation === 'splitRight') {

				var content = element.textContent;
				var letters = content.split("");
				element.innerHTML = "";

				for (var idx = 0; idx < letters.length; idx++) {
					element.innerHTML += "<span>" + letters[idx] + "</span>";
				}

				var chars = element.querySelectorAll('span');

				TweenMax.set(chars, {x: -110, alpha: 0});

				setTimeout(function () {
					TweenMax.staggerTo(
						chars, 1.3,
						{x: 0, alpha: 1, ease: Power4.easeInOut}, -0.02
					);
				}, delay);

			}

		}

// ----- Q SLIDE ----- //
		function qSlide(q_slide) {

			q_slide.classList.add('q_slide');

			// global vars

			var slides = q_slide.querySelectorAll('.slide');
			var pagination = q_slide.querySelector('.pagination');
			var bar = document.getElementById('bar');

			// trigger resize

			function triggerResize() {
				var ev = document.createEvent('HTMLEvents');
				ev.initEvent('resize', true, false);
				window.dispatchEvent(ev);
			}

			// autoplay function

			function autoPlay() {
				if (q_slide.getAttribute('data-autoplay') != null) {
					var q_slideDuration = q_slide.getAttribute('data-autoplay') || 4000;

					var timeout = setTimeout(function () {
						q_slideNext(q_slide, false, true);
					}, q_slideDuration);
				}
			}

			// parallax init

			var q_slideFriction = 1; // no parallax
			if (q_slide.getAttribute('data-parallax') != null) {
				var q_slideFriction = q_slide.getAttribute('data-parallax') || 0.25;
			}


			// opacity init

			if (q_slide.getAttribute('data-opacity') != null) {
				var slideOpacity = q_slide.getAttribute('data-opacity') || 0.6;
			}

			// pagination update function

			function pageUpdate() {
				if (pagination) {
					var pages = pagination.querySelectorAll('.item');
					var activePage = pagination.querySelector('.q_current');
					var newSlide = q_slide.querySelector('.is-new');
					var index = indexInParent(newSlide);

					activePage.classList.remove('q_current');
					pages[index].classList.add('q_current');
				}
			}


			// switch slide function

			function q_slideSwitch(q_slide, index, auto) {

				if (q_slide.getAttribute('wait') === 'true') return;

				var captions = q_slide.querySelectorAll('.slide-content');

				var activeSlide = q_slide.querySelector('.q_current');
				var activeSlideImage = activeSlide.querySelector('.image-container');
				var newSlide = eq.call(slides, index);
				var index = indexInParent(newSlide);
				var newSlideImage = newSlide.querySelector('.image-container');
				var newSlideContent = newSlide.querySelector('.slide-content') || captions[index];
				var allSlideElements = q_slide.querySelectorAll('.q_split_wrap');
				if (newSlideContent) {
					var newSlideElements = newSlideContent.querySelectorAll('.q_split_wrap');
				}

				if (newSlide === activeSlide) return;

				newSlide.classList.add('is-new');

				var timeout = 0;
				clearTimeout(timeout);
				pageUpdate();

				q_slide.setAttribute('wait', 'true');

				if (indexInParent(newSlide) > indexInParent(activeSlide)) {
					// next slide
					var newSlideRight = 0;
					var newSlideLeft = 'auto';
					var newSlideImageLeft = -q_slide.clientWidth * (1 - q_slideFriction) + 'px';
					var newSlideContentLeft = 'auto';
					var newSlideContentRight = 0;
					var activeSlideImageLeft = -q_slide.clientWidth * q_slideFriction + 'px';
					var sideAnim = 'sideLeft';
					var splitAnim = 'splitLeft';
					var slideAnim = 'clientLeft';

				} else {
					// prev slide
					var newSlideRight = '';
					var newSlideLeft = 0;
					var newSlideImageLeft = -q_slide.clientWidth * q_slideFriction + 'px';
					var newSlideContentLeft = 0;
					var newSlideContentRight = 'auto';
					var activeSlideImageLeft = q_slide.clientWidth * q_slideFriction + 'px';
					var sideAnim = 'sideRight';
					var splitAnim = 'splitRight';
					var slideAnim = 'clientRight';
				}

				newSlide.style.display = 'block';
				newSlide.style.width = 0;
				newSlide.style.right = newSlideRight;
				newSlide.style.left = newSlideLeft;
				newSlide.style.zIndex = 2;

				newSlideImage.style.width = q_slide.clientWidth + 'px';
				activeSlideImage.style.transform = 'translateX(0)';

				TweenMax.set(newSlideImage, {x: newSlideImageLeft});

				if (slideOpacity) {
					newSlideImage.style.opacity = slideOpacity;
				}

				if (newSlideContent) {
					newSlideContent.style.width = q_slide.clientWidth + 'px';
					newSlideContent.style.right = newSlideContentRight;
					newSlideContent.style.left = newSlideContentLeft;
				}

				if (slideOpacity) {
					TweenMax.to(activeSlideImage, 1.3, {
						x: activeSlideImageLeft,
						opacity: slideOpacity,
						ease: Expo.easeInOut
					});
				} else {
					TweenMax.to(activeSlideImage, 1.3, {
						x: activeSlideImageLeft,
						ease: Expo.easeInOut
					});
				}

				TweenMax.to(newSlide, 1.3, {
					width: q_slide.clientWidth,
					ease: Expo.easeInOut
				});

				TweenMax.to(newSlideImage, 1.3, {
					x: 0,
					opacity: 1,
					ease: Expo.easeInOut,
					onComplete: function () {
						// switch active class
						newSlide.classList.add('q_current');
						newSlide.classList.remove('is-new');
						activeSlide.classList.remove('q_current');
						newSlide.removeAttribute('style');
						// reset all styles
						newSlideImage.removeAttribute('style');
						if (newSlideContent) {
							newSlideContent.removeAttribute('style');
						}
						activeSlideImage.removeAttribute('style');
						q_slide.setAttribute('wait', 'false');


						if (auto) {
							autoPlay()
						}
					}
				});


				// caption animation
				q_animate(allSlideElements, 'fadeOut', .5);
				q_animate(newSlideElements, slideAnim, .9);
			}


			// next/prev slide switch calls

			function q_slideNext(q_slide, previous, auto) {

				var activeSlide = q_slide.querySelector('.q_current');
				var newSlide = null;
				if (previous) {
					newSlide = activeSlide.previousElementSibling;
					if (!newSlide) {
						newSlide = slides[slides.length - 1];
					}
				} else {
					newSlide = activeSlide.nextElementSibling;
					if (!newSlide)
						newSlide = slides[0];
				}
				q_slideSwitch(q_slide, indexInParent(newSlide), auto);

				triggerResize();

			}

			for (var i = slides.length - 1; i >= 0; i--) {
				var slide = slides[i];
				slide.classList.add('is-loaded');
			}

			// arrows click event

			var arrows = q_slide.querySelector('.arrows');

			if (arrows) {
				var next = arrows.querySelector('.next');
				var prev = arrows.querySelector('.prev');

				next.addEventListener('click', function (e) {
					q_slideNext(q_slide, false);
				});
				prev.addEventListener('click', function (e) {
					q_slideNext(q_slide, true);
				});
			}

			// pagination click event

			if (pagination) {
				var pages = pagination.querySelectorAll('.item');
				for (var i = pages.length - 1; i >= 0; i--) {
					var page = pages[i];
					page.addEventListener('click', function (e) {
						q_slideSwitch(q_slide, indexInParent(e.target));
						triggerResize();
					})
				}
			}

			autoPlay(); // autoplay init

			// mousemove background animation

			if (q_slide.getAttribute('mousefollow') != null) {
				if (window.innerWidth > 540) {
					for (var i = slides.length - 1; i >= 0; i--) {
						var slide = slides[i].querySelector('.image-wrapper');
						TweenMax.set(slide, {scale: 1.1});
					}

					function moveBackground(e) {
						var lMouseX = Math.max(-100, Math.min(100, q_slide.clientWidth / 2 - e.clientX));
						var lMouseY = Math.max(-100, Math.min(100, q_slide.clientHeight / 2 - e.clientY));
						var x = (25 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
						var y = (15 * lMouseY) / 100;
						for (var i = slides.length - 1; i >= 0; i--) {
							var slide = slides[i].querySelector('.image-wrapper');
							TweenMax.to(slide, 3, {autoAlpha: 1, x: x, y: y, ease: Power1.easeOut});
						}
					}

					q_slide.onmousemove = function (e) {
						moveBackground(e)
					};
				}
			}
		}
	}

})(jQuery, window, document);
