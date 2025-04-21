/*=========================================================================================
  File Name: app.js
  Description: Template related app JS.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/
window.colors = {
	solid: {
		primary: '#7367F0',
		secondary: '#82868b',
		success: '#28C76F',
		info: '#00cfe8',
		warning: '#FF9F43',
		danger: '#EA5455',
		dark: '#4b4b4b',
		black: '#000',
		white: '#fff',
		body: '#f8f8f8'
	},
	light: {
		primary: '#7367F01a',
		secondary: '#82868b1a',
		success: '#28C76F1a',
		info: '#00cfe81a',
		warning: '#FF9F431a',
		danger: '#EA54551a',
		dark: '#4b4b4b1a'
	}
};
(function (window, document, $) {
	'use strict';
	var $html = $('html');
	var $body = $('body');
	var $textcolor = '#4e5154';
	var assetPath = '../../../app-assets/';

	if ($('body').attr('data-framework') === 'laravel') {
		assetPath = $('body').attr('data-asset-path');
	}

	// to remove sm control classes from datatables
	if ($.fn.dataTable) {
		$.extend($.fn.dataTable.ext.classes, {
			sFilterInput: 'form-control',
			sLengthSelect: 'form-select'
		});
	}

	$(window).on('load', function () {
		var rtl;
		var compactMenu = false;

		if ($body.hasClass('menu-collapsed') || localStorage.getItem('menuCollapsed') === 'true') {
			compactMenu = true;
		}

		if ($('html').data('textdirection') == 'rtl') {
			rtl = true;
		}

		setTimeout(function () {
			$html.removeClass('loading').addClass('loaded');
		}, 1200);

		$.app.menu.init(compactMenu);

		// Navigation configurations
		var config = {
			speed: 300 // set speed to expand / collapse menu
		};
		if ($.app.nav.initialized === false) {
			$.app.nav.init(config);
		}

		Unison.on('change', function (bp) {
			$.app.menu.change(compactMenu);
		});

		// Tooltip Initialization
		// $('[data-bs-toggle="tooltip"]').tooltip({
		//   container: 'body'
		// });
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
			return new bootstrap.Tooltip(tooltipTriggerEl);
		});

		// Collapsible Card
		$('a[data-action="collapse"]').on('click', function (e) {
			e.preventDefault();
			$(this).closest('.card').children('.card-content').collapse('toggle');
			$(this).closest('.card').find('[data-action="collapse"]').toggleClass('rotate');
		});

		// Cart dropdown touchspin
		if ($('.touchspin-cart').length > 0) {
			$('.touchspin-cart').TouchSpin({
				buttondown_class: 'btn btn-primary',
				buttonup_class: 'btn btn-primary',
				buttondown_txt: feather.icons['minus'].toSvg(),
				buttonup_txt: feather.icons['plus'].toSvg()
			});
		}

		// Do not close cart or notification dropdown on click of the items
		$('.dropdown-notification .dropdown-menu, .dropdown-cart .dropdown-menu').on('click', function (e) {
			e.stopPropagation();
		});

		//  Notifications & messages scrollable
		$('.scrollable-container').each(function () {
			var scrollable_container = new PerfectScrollbar($(this)[0], {
				wheelPropagation: false
			});
		});

		// Reload Card
		$('a[data-action="reload"]').on('click', function () {
			var block_ele = $(this).closest('.card');
			var reloadActionOverlay;
			if ($html.hasClass('dark-layout')) {
				var reloadActionOverlay = '#10163a';
			} else {
				var reloadActionOverlay = '#fff';
			}
			// Block Element
			block_ele.block({
				message: feather.icons['refresh-cw'].toSvg({ class: 'font-medium-1 spinner text-primary' }),
				timeout: 2000, //unblock after 2 seconds
				overlayCSS: {
					backgroundColor: reloadActionOverlay,
					cursor: 'wait'
				},
				css: {
					border: 0,
					padding: 0,
					backgroundColor: 'none'
				}
			});
		});

		// Close Card
		$('a[data-action="close"]').on('click', function () {
			$(this).closest('.card').removeClass().slideUp('fast');
		});

		$('.card .heading-elements a[data-action="collapse"]').on('click', function () {
			var $this = $(this),
				card = $this.closest('.card');
			var cardHeight;

			if (parseInt(card[0].style.height, 10) > 0) {
				cardHeight = card.css('height');
				card.css('height', '').attr('data-height', cardHeight);
			} else {
				if (card.data('height')) {
					cardHeight = card.data('height');
					card.css('height', cardHeight).attr('data-height', '');
				}
			}
		});

		// Add disabled class to input group when input is disabled
		$('input:disabled, textarea:disabled').closest('.input-group').addClass('disabled');

		// Add sidebar group active class to active menu
		$('.main-menu-content').find('li.active').parents('li').addClass('sidebar-group-active');

		// Add open class to parent list item if subitem is active except compact menu
		var menuType = $body.data('menu');
		if (menuType != 'horizontal-menu' && compactMenu === false) {
			$('.main-menu-content').find('li.active').parents('li').addClass('open');
		}
		if (menuType == 'horizontal-menu') {
			$('.main-menu-content').find('li.active').parents('li:not(.nav-item)').addClass('open');
			$('.main-menu-content').find('li.active').closest('li.nav-item').addClass('sidebar-group-active open');
			// $(".main-menu-content")
			//   .find("li.active")
			//   .parents("li")
			//   .addClass("active");
		}

		//  Dynamic height for the chartjs div for the chart animations to work
		var chartjsDiv = $('.chartjs'),
			canvasHeight = chartjsDiv.children('canvas').attr('height'),
			mainMenu = $('.main-menu');
		chartjsDiv.css('height', canvasHeight);

		if ($body.hasClass('boxed-layout')) {
			if ($body.hasClass('vertical-overlay-menu')) {
				var menuWidth = mainMenu.width();
				var contentPosition = $('.app-content').position().left;
				var menuPositionAdjust = contentPosition - menuWidth;
				if ($body.hasClass('menu-flipped')) {
					mainMenu.css('right', menuPositionAdjust + 'px');
				} else {
					mainMenu.css('left', menuPositionAdjust + 'px');
				}
			}
		}

		/* Text Area Counter Set Start */

		$('.char-textarea').on('keyup', function (event) {
			checkTextAreaMaxLength(this, event);
			// to later change text color in dark layout
			$(this).addClass('active');
		});

		/*
		Checks the MaxLength of the Textarea
		-----------------------------------------------------
		@prerequisite:  textBox = textarea dom element
				e = textarea event
						length = Max length of characters
		*/
		function checkTextAreaMaxLength(textBox, e) {
			var maxLength = parseInt($(textBox).data('length')),
				counterValue = $('.textarea-counter-value'),
				charTextarea = $('.char-textarea');

			if (!checkSpecialKeys(e)) {
				if (textBox.value.length < maxLength - 1) textBox.value = textBox.value.substring(0, maxLength);
			}
			$('.char-count').html(textBox.value.length);

			if (textBox.value.length > maxLength) {
				counterValue.css('background-color', window.colors.solid.danger);
				charTextarea.css('color', window.colors.solid.danger);
				// to change text color after limit is maxedout out
				charTextarea.addClass('max-limit');
			} else {
				counterValue.css('background-color', window.colors.solid.primary);
				charTextarea.css('color', $textcolor);
				charTextarea.removeClass('max-limit');
			}

			return true;
		}
		/*
		Checks if the keyCode pressed is inside special chars
		-------------------------------------------------------
		@prerequisite:  e = e.keyCode object for the key pressed
		*/
		function checkSpecialKeys(e) {
			if (e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40)
				return false;
			else return true;
		}

		$('.content-overlay').on('click', function () {
			$('.search-list').removeClass('show');
			var searchInput = $('.search-input-close').closest('.search-input');
			if (searchInput.hasClass('open')) {
				searchInput.removeClass('open');
				searchInputInputfield.val('');
				searchInputInputfield.blur();
				searchList.removeClass('show');
			}

			$('.app-content').removeClass('show-overlay');
			$('.bookmark-wrapper .bookmark-input').removeClass('show');
		});

		// To show shadow in main menu when menu scrolls
		var container = document.getElementsByClassName('main-menu-content');
		if (container.length > 0) {
			container[0].addEventListener('ps-scroll-y', function () {
				if ($(this).find('.ps__thumb-y').position().top > 0) {
					$('.shadow-bottom').css('display', 'block');
				} else {
					$('.shadow-bottom').css('display', 'none');
				}
			});
		}
	});

	// Hide overlay menu on content overlay click on small screens
	$(document).on('click', '.sidenav-overlay', function (e) {
		// Hide menu
		$.app.menu.hide();
		return false;
	});

	// Execute below code only if we find hammer js for touch swipe feature on small screen
	if (typeof Hammer !== 'undefined') {
		var rtl;
		if ($('html').data('textdirection') == 'rtl') {
			rtl = true;
		}

		// Swipe menu gesture
		var swipeInElement = document.querySelector('.drag-target'),
			swipeInAction = 'panright',
			swipeOutAction = 'panleft';

		if (rtl === true) {
			swipeInAction = 'panleft';
			swipeOutAction = 'panright';
		}

		if ($(swipeInElement).length > 0) {
			var swipeInMenu = new Hammer(swipeInElement);

			swipeInMenu.on(swipeInAction, function (ev) {
				if ($body.hasClass('vertical-overlay-menu')) {
					$.app.menu.open();
					return false;
				}
			});
		}

		// menu swipe out gesture
		setTimeout(function () {
			var swipeOutElement = document.querySelector('.main-menu');
			var swipeOutMenu;

			if ($(swipeOutElement).length > 0) {
				swipeOutMenu = new Hammer(swipeOutElement);

				swipeOutMenu.get('pan').set({
					direction: Hammer.DIRECTION_ALL,
					threshold: 250
				});

				swipeOutMenu.on(swipeOutAction, function (ev) {
					if ($body.hasClass('vertical-overlay-menu')) {
						$.app.menu.hide();
						return false;
					}
				});
			}
		}, 300);

		// menu close on overlay tap
		var swipeOutOverlayElement = document.querySelector('.sidenav-overlay');

		if ($(swipeOutOverlayElement).length > 0) {
			var swipeOutOverlayMenu = new Hammer(swipeOutOverlayElement);

			swipeOutOverlayMenu.on('tap', function (ev) {
				if ($body.hasClass('vertical-overlay-menu')) {
					$.app.menu.hide();
					return false;
				}
			});
		}
	}

	$(document).on('click', '.menu-toggle, .modern-nav-toggle', function (e) {
		e.preventDefault();

		// Toggle menu
		$.app.menu.toggle();

		setTimeout(function () {
			$(window).trigger('resize');
		}, 200);

		if ($('#collapse-sidebar-switch').length > 0) {
			setTimeout(function () {
				if ($body.hasClass('menu-expanded') || $body.hasClass('menu-open')) {
					$('#collapse-sidebar-switch').prop('checked', false);
				} else {
					$('#collapse-sidebar-switch').prop('checked', true);
				}
			}, 50);
		}

		// Save menu collapsed status in localstorage
		if ($body.hasClass('menu-expanded') || $body.hasClass('menu-open')) {
			localStorage.setItem('menuCollapsed', false);
		} else {
			localStorage.setItem('menuCollapsed', true);
		}

		// Hides dropdown on click of menu toggle
		// $('[data-bs-toggle="dropdown"]').dropdown('hide');

		return false;
	});

	// Add Children Class
	$('.navigation').find('li').has('ul').addClass('has-sub');
	// Update manual scroller when window is resized
	$(window).resize(function () {
		$.app.menu.manualScroller.updateHeight();
	});

	$('#sidebar-page-navigation').on('click', 'a.nav-link', function (e) {
		e.preventDefault();
		e.stopPropagation();
		var $this = $(this),
			href = $this.attr('href');
		var offset = $(href).offset();
		var scrollto = offset.top - 80; // minus fixed header height
		$('html, body').animate(
			{
				scrollTop: scrollto
			},
			0
		);
		setTimeout(function () {
			$this.parent('.nav-item').siblings('.nav-item').children('.nav-link').removeClass('active');
			$this.addClass('active');
		}, 100);
	});

	// main menu internationalization

	// init i18n and load language file
	if ($body.attr('data-framework') === 'laravel') {
		// change language according to data-language of dropdown item
		var language = $('html')[0].lang;
		if (language !== null) {
			// get the selected flag class
			var selectedLang = $('.dropdown-language')
				.find('a[data-language=' + language + ']')
				.text();
			var selectedFlag = $('.dropdown-language')
				.find('a[data-language=' + language + '] .flag-icon')
				.attr('class');
			// set the class in button
			$('#dropdown-flag .selected-language').text(selectedLang);
			$('#dropdown-flag .flag-icon').removeClass().addClass(selectedFlag);
		}
	} else {
		i18next.use(window.i18nextXHRBackend).init(
			{
				debug: false,
				fallbackLng: 'en',
				backend: {
					loadPath: assetPath + 'data/locales/{{lng}}.json'
				},
				returnObjects: true
			},
			function (err, t) {
				// resources have been loaded
				jqueryI18next.init(i18next, $);
			}
		);

		// change language according to data-language of dropdown item
		$('.dropdown-language .dropdown-item').on('click', function () {
			var $this = $(this);
			$this.siblings('.selected').removeClass('selected');
			$this.addClass('selected');
			var selectedLang = $this.text();
			var selectedFlag = $this.find('.flag-icon').attr('class');
			$('#dropdown-flag .selected-language').text(selectedLang);
			$('#dropdown-flag .flag-icon').removeClass().addClass(selectedFlag);
			var currentLanguage = $this.data('language');
			i18next.changeLanguage(currentLanguage, function (err, t) {
				$('.main-menu, .horizontal-menu-wrapper').localize();
			});
		});
	}

	/********************* Bookmark & Search ***********************/
	// This variable is used for mouseenter and mouseleave events of search list
	var $filename = $('.search-input input').data('search'),
		bookmarkWrapper = $('.bookmark-wrapper'),
		bookmarkStar = $('.bookmark-wrapper .bookmark-star'),
		bookmarkInput = $('.bookmark-wrapper .bookmark-input'),
		navLinkSearch = $('.nav-link-search'),
		searchInput = $('.search-input'),
		searchInputInputfield = $('.search-input input'),
		searchList = $('.search-input .search-list'),
		appContent = $('.app-content'),
		bookmarkSearchList = $('.bookmark-input .search-list');

	// Bookmark icon click
	bookmarkStar.on('click', function (e) {
		e.stopPropagation();
		bookmarkInput.toggleClass('show');
		bookmarkInput.find('input').val('');
		bookmarkInput.find('input').blur();
		bookmarkInput.find('input').focus();
		bookmarkWrapper.find('.search-list').addClass('show');

		var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
			$arrList = '',
			$activeItemClass = '';

		$('ul.search-list li').remove();

		for (var i = 0; i < arrList.length; i++) {
			if (i === 0) {
				$activeItemClass = 'current_item';
			} else {
				$activeItemClass = '';
			}

			var iconName = '',
				className = '';
			if ($(arrList[i].firstChild.firstChild).hasClass('feather')) {
				var classString = arrList[i].firstChild.firstChild.getAttribute('class');
				iconName = classString.split('feather-')[1].split(' ')[0];
				className = classString.split('feather-')[1].split(' ')[1];
			}

			$arrList +=
				'<li class="auto-suggestion ' +
				$activeItemClass +
				'">' +
				'<a class="d-flex align-items-center justify-content-between w-100" href=' +
				arrList[i].firstChild.href +
				'>' +
				'<div class="d-flex justify-content-start align-items-center">' +
				feather.icons[iconName].toSvg({ class: 'me-75 ' + className }) +
				'<span>' +
				arrList[i].firstChild.dataset.bsOriginalTitle +
				'</span>' +
				'</div>' +
				feather.icons['star'].toSvg({ class: 'text-warning bookmark-icon float-end' }) +
				'</a>' +
				'</li>';
		}
		$('ul.search-list').append($arrList);
	});

	// Navigation Search area Open
	navLinkSearch.on('click', function () {
		var $this = $(this);
		var searchInput = $(this).parent('.nav-search').find('.search-input');
		searchInput.addClass('open');
		searchInputInputfield.focus();
		searchList.find('li').remove();
		bookmarkInput.removeClass('show');
	});

	// Navigation Search area Close
	$('.search-input-close').on('click', function () {
		var $this = $(this),
			searchInput = $(this).closest('.search-input');
		if (searchInput.hasClass('open')) {
			searchInput.removeClass('open');
			searchInputInputfield.val('');
			searchInputInputfield.blur();
			searchList.removeClass('show');
			appContent.removeClass('show-overlay');
		}
	});

	// Filter
	if ($('.search-list-main').length) {
		var searchListMain = new PerfectScrollbar('.search-list-main', {
			wheelPropagation: false
		});
	}
	if ($('.search-list-bookmark').length) {
		var searchListBookmark = new PerfectScrollbar('.search-list-bookmark', {
			wheelPropagation: false
		});
	}
	// update Perfect Scrollbar on hover
	$('.search-list-main').mouseenter(function () {
		searchListMain.update();
	});

	searchInputInputfield.on('keyup', function (e) {
		$(this).closest('.search-list').addClass('show');
		if (e.keyCode !== 38 && e.keyCode !== 40 && e.keyCode !== 13) {
			if (e.keyCode == 27) {
				appContent.removeClass('show-overlay');
				bookmarkInput.find('input').val('');
				bookmarkInput.find('input').blur();
				searchInputInputfield.val('');
				searchInputInputfield.blur();
				searchInput.removeClass('open');
				if (searchInput.hasClass('show')) {
					$(this).removeClass('show');
					searchInput.removeClass('show');
				}
			}

			// Define variables
			var value = $(this).val().toLowerCase(), //get values of input on keyup
				activeClass = '',
				bookmark = false,
				liList = $('ul.search-list li'); // get all the list items of the search
			liList.remove();
			// To check if current is bookmark input
			if ($(this).parent().hasClass('bookmark-input')) {
				bookmark = true;
			}

			// If input value is blank
			if (value != '') {
				appContent.addClass('show-overlay');

				// condition for bookmark and search input click
				if (bookmarkInput.focus()) {
					bookmarkSearchList.addClass('show');
				} else {
					searchList.addClass('show');
					bookmarkSearchList.removeClass('show');
				}
				if (bookmark === false) {
					searchList.addClass('show');
					bookmarkSearchList.removeClass('show');
				}

				var $startList = '',
					$otherList = '',
					$htmlList = '',
					$bookmarkhtmlList = '',
					$pageList =
						'<li class="d-flex align-items-center">' +
						'<a href="#">' +
						'<h6 class="section-label mt-75 mb-0">Pages</h6>' +
						'</a>' +
						'</li>',
					$activeItemClass = '',
					$bookmarkIcon = '',
					$defaultList = '',
					a = 0;

				// getting json data from file for search results
				$.getJSON(assetPath + 'data/' + $filename + '.json', function (data) {
					for (var i = 0; i < data.listItems.length; i++) {
						// if current is bookmark then give class to star icon
						// for laravel
						if ($('body').attr('data-framework') === 'laravel') {
							data.listItems[i].url = assetPath + data.listItems[i].url;
						}

						if (bookmark === true) {
							activeClass = ''; // resetting active bookmark class
							var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
								$arrList = '';
							// Loop to check if current seach value match with the bookmarks already there in navbar
							for (var j = 0; j < arrList.length; j++) {
								if (data.listItems[i].name === arrList[j].firstChild.dataset.bsOriginalTitle) {
									activeClass = ' text-warning';
									break;
								} else {
									activeClass = '';
								}
							}

							$bookmarkIcon = feather.icons['star'].toSvg({ class: 'bookmark-icon float-end' + activeClass });
						}
						// Search list item start with entered letters and create list
						if (data.listItems[i].name.toLowerCase().indexOf(value) == 0 && a < 5) {
							if (a === 0) {
								$activeItemClass = 'current_item';
							} else {
								$activeItemClass = '';
							}
							$startList +=
								'<li class="auto-suggestion ' +
								$activeItemClass +
								'">' +
								'<a class="d-flex align-items-center justify-content-between w-100" href=' +
								data.listItems[i].url +
								'>' +
								'<div class="d-flex justify-content-start align-items-center">' +
								feather.icons[data.listItems[i].icon].toSvg({ class: 'me-75 ' }) +
								'<span>' +
								data.listItems[i].name +
								'</span>' +
								'</div>' +
								$bookmarkIcon +
								'</a>' +
								'</li>';
							a++;
						}
					}
					for (var i = 0; i < data.listItems.length; i++) {
						if (bookmark === true) {
							activeClass = ''; // resetting active bookmark class
							var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
								$arrList = '';
							// Loop to check if current search value match with the bookmarks already there in navbar
							for (var j = 0; j < arrList.length; j++) {
								if (data.listItems[i].name === arrList[j].firstChild.dataset.bsOriginalTitle) {
									activeClass = ' text-warning';
								} else {
									activeClass = '';
								}
							}

							$bookmarkIcon = feather.icons['star'].toSvg({ class: 'bookmark-icon float-end' + activeClass });
						}
						// Search list item not start with letters and create list
						if (
							!(data.listItems[i].name.toLowerCase().indexOf(value) == 0) &&
							data.listItems[i].name.toLowerCase().indexOf(value) > -1 &&
							a < 5
						) {
							if (a === 0) {
								$activeItemClass = 'current_item';
							} else {
								$activeItemClass = '';
							}
							$otherList +=
								'<li class="auto-suggestion ' +
								$activeItemClass +
								'">' +
								'<a class="d-flex align-items-center justify-content-between w-100" href=' +
								data.listItems[i].url +
								'>' +
								'<div class="d-flex justify-content-start align-items-center">' +
								feather.icons[data.listItems[i].icon].toSvg({ class: 'me-75 ' }) +
								'<span>' +
								data.listItems[i].name +
								'</span>' +
								'</div>' +
								$bookmarkIcon +
								'</a>' +
								'</li>';
							a++;
						}
					}
					$defaultList = $('.main-search-list-defaultlist').html();
					if ($startList == '' && $otherList == '') {
						$otherList = $('.main-search-list-defaultlist-other-list').html();
					}
					// concatinating startlist, otherlist, defalutlist with pagelist
					$htmlList = $pageList.concat($startList, $otherList, $defaultList);
					$('ul.search-list').html($htmlList);
					// concatinating otherlist with startlist
					$bookmarkhtmlList = $startList.concat($otherList);
					$('ul.search-list-bookmark').html($bookmarkhtmlList);
					// Feather Icons
					// if (feather) {
					//   featherSVG();
					// }
				});
			} else {
				if (bookmark === true) {
					var arrList = $('ul.nav.navbar-nav.bookmark-icons li'),
						$arrList = '';
					for (var i = 0; i < arrList.length; i++) {
						if (i === 0) {
							$activeItemClass = 'current_item';
						} else {
							$activeItemClass = '';
						}

						var iconName = '',
							className = '';
						if ($(arrList[i].firstChild.firstChild).hasClass('feather')) {
							var classString = arrList[i].firstChild.firstChild.getAttribute('class');
							iconName = classString.split('feather-')[1].split(' ')[0];
							className = classString.split('feather-')[1].split(' ')[1];
						}
						$arrList +=
							'<li class="auto-suggestion">' +
							'<a class="d-flex align-items-center justify-content-between w-100" href=' +
							arrList[i].firstChild.href +
							'>' +
							'<div class="d-flex justify-content-start align-items-center">' +
							feather.icons[iconName].toSvg({ class: 'me-75 ' }) +
							'<span>' +
							arrList[i].firstChild.dataset.bsOriginalTitle +
							'</span>' +
							'</div>' +
							feather.icons['star'].toSvg({ class: 'text-warning bookmark-icon float-end' }) +
							'</a>' +
							'</li>';
					}
					$('ul.search-list').append($arrList);
					// Feather Icons
					// if (feather) {
					//   featherSVG();
					// }
				} else {
					// if search input blank, hide overlay
					if (appContent.hasClass('show-overlay')) {
						appContent.removeClass('show-overlay');
					}
					// If filter box is empty
					if (searchList.hasClass('show')) {
						searchList.removeClass('show');
					}
				}
			}
		}
	});

	// Add class on hover of the list
	$(document).on('mouseenter', '.search-list li', function (e) {
		$(this).siblings().removeClass('current_item');
		$(this).addClass('current_item');
	});
	$(document).on('click', '.search-list li', function (e) {
		e.stopPropagation();
	});

	$('html').on('click', function ($this) {
		if (!$($this.target).hasClass('bookmark-icon')) {
			if (bookmarkSearchList.hasClass('show')) {
				bookmarkSearchList.removeClass('show');
			}
			if (bookmarkInput.hasClass('show')) {
				bookmarkInput.removeClass('show');
				appContent.removeClass('show-overlay');
			}
		}
	});

	// Prevent closing bookmark dropdown on input textbox click
	$(document).on('click', '.bookmark-input input', function (e) {
		bookmarkInput.addClass('show');
		bookmarkSearchList.addClass('show');
	});

	// Favorite star click
	$(document).on('click', '.bookmark-input .search-list .bookmark-icon', function (e) {
		e.stopPropagation();
		if ($(this).hasClass('text-warning')) {
			$(this).removeClass('text-warning');
			var arrList = $('ul.nav.navbar-nav.bookmark-icons li');
			for (var i = 0; i < arrList.length; i++) {
				if (arrList[i].firstChild.dataset.bsOriginalTitle == $(this).parent()[0].innerText) {
					arrList[i].remove();
				}
			}
			e.preventDefault();
		} else {
			var arrList = $('ul.nav.navbar-nav.bookmark-icons li');
			$(this).addClass('text-warning');
			e.preventDefault();
			var $url = $(this).parent()[0].href,
				$name = $(this).parent()[0].innerText,
				$listItem = '',
				$listItemDropdown = '',
				iconName = $(this).parent()[0].firstChild.firstChild.dataset.icon;
			if ($($(this).parent()[0].firstChild.firstChild).hasClass('feather')) {
				var classString = $(this).parent()[0].firstChild.firstChild.getAttribute('class');
				iconName = classString.split('feather-')[1].split(' ')[0];
			}
			$listItem =
				'<li class="nav-item d-none d-lg-block">' +
				'<a class="nav-link" href="' +
				$url +
				'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="' +
				$name +
				'">' +
				feather.icons[iconName].toSvg({ class: 'ficon' }) +
				'</a>' +
				'</li>';
			$('ul.nav.bookmark-icons').append($listItem);
			$('[data-bs-toggle="tooltip"]').tooltip();
		}
	});

	// If we use up key(38) Down key (40) or Enter key(13)
	$(window).on('keydown', function (e) {
		var $current = $('.search-list li.current_item'),
			$next,
			$prev;
		if (e.keyCode === 40) {
			$next = $current.next();
			$current.removeClass('current_item');
			$current = $next.addClass('current_item');
		} else if (e.keyCode === 38) {
			$prev = $current.prev();
			$current.removeClass('current_item');
			$current = $prev.addClass('current_item');
		}

		if (e.keyCode === 13 && $('.search-list li.current_item').length > 0) {
			var selected_item = $('.search-list li.current_item a');
			window.location = selected_item.attr('href');
			$(selected_item).trigger('click');
		}
	});

	// Waves Effect
	Waves.init();
	Waves.attach(
		".btn:not([class*='btn-relief-']):not([class*='btn-gradient-']):not([class*='btn-outline-']):not([class*='btn-flat-'])",
		['waves-float', 'waves-light']
	);
	Waves.attach("[class*='btn-outline-']");
	Waves.attach("[class*='btn-flat-']");

	$('.form-password-toggle .input-group-text').on('click', function (e) {
		e.preventDefault();
		var $this = $(this),
			inputGroupText = $this.closest('.form-password-toggle'),
			formPasswordToggleIcon = $this,
			formPasswordToggleInput = inputGroupText.find('input');

		if (formPasswordToggleInput.attr('type') === 'text') {
			formPasswordToggleInput.attr('type', 'password');
			if (feather) {
				formPasswordToggleIcon.find('svg').replaceWith(feather.icons['eye'].toSvg({ class: 'font-small-4' }));
			}
		} else if (formPasswordToggleInput.attr('type') === 'password') {
			formPasswordToggleInput.attr('type', 'text');
			if (feather) {
				formPasswordToggleIcon.find('svg').replaceWith(feather.icons['eye-off'].toSvg({ class: 'font-small-4' }));
			}
		}
	});

	// on window scroll button show/hide
	$(window).on('scroll', function () {
		if ($(this).scrollTop() > 400) {
			$('.scroll-top').fadeIn();
		} else {
			$('.scroll-top').fadeOut();
		}

		// On Scroll navbar color on horizontal menu
		if ($body.hasClass('navbar-static')) {
			var scroll = $(window).scrollTop();

			if (scroll > 65) {
				$('html:not(.dark-layout) .horizontal-menu .header-navbar.navbar-fixed').css({
					background: '#fff',
					'box-shadow': '0 4px 20px 0 rgba(0,0,0,.05)'
				});
				$('.horizontal-menu.dark-layout .header-navbar.navbar-fixed').css({
					background: '#161d31',
					'box-shadow': '0 4px 20px 0 rgba(0,0,0,.05)'
				});
				$('html:not(.dark-layout) .horizontal-menu .horizontal-menu-wrapper.header-navbar').css('background', '#fff');
				$('.dark-layout .horizontal-menu .horizontal-menu-wrapper.header-navbar').css('background', '#161d31');
			} else {
				$('html:not(.dark-layout) .horizontal-menu .header-navbar.navbar-fixed').css({
					background: '#f8f8f8',
					'box-shadow': 'none'
				});
				$('.dark-layout .horizontal-menu .header-navbar.navbar-fixed').css({
					background: '#161d31',
					'box-shadow': 'none'
				});
				$('html:not(.dark-layout) .horizontal-menu .horizontal-menu-wrapper.header-navbar').css('background', '#fff');
				$('.dark-layout .horizontal-menu .horizontal-menu-wrapper.header-navbar').css('background', '#161d31');
			}
		}
	});

	// Click event to scroll to top
	$('.scroll-top').on('click', function () {
		$('html, body').animate({ scrollTop: 0 }, 75);
	});

	function getCurrentLayout() {
		var currentLayout = '';
		if ($html.hasClass('dark-layout')) {
			currentLayout = 'dark-layout';
		} else if ($html.hasClass('bordered-layout')) {
			currentLayout = 'bordered-layout';
		} else if ($html.hasClass('semi-dark-layout')) {
			currentLayout = 'semi-dark-layout';
		} else {
			currentLayout = 'light-layout';
		}
		return currentLayout;
	}

	// Get the data layout, for blank set to light layout
	var dataLayout = $html.attr('data-layout') ? $html.attr('data-layout') : 'light-layout';

	// Navbar Dark / Light Layout Toggle Switch
	$('.nav-link-style').on('click', function () {
		var currentLayout = getCurrentLayout(),
			switchToLayout = '',
			prevLayout = localStorage.getItem(dataLayout + '-prev-skin', currentLayout);

		// If currentLayout is not dark layout
		if (currentLayout !== 'dark-layout') {
			// Switch to dark
			switchToLayout = 'dark-layout';
		} else {
			// Switch to light
			// switchToLayout = prevLayout ? prevLayout : 'light-layout';
			if (currentLayout === prevLayout) {
				switchToLayout = 'light-layout';
			} else {
				switchToLayout = prevLayout ? prevLayout : 'light-layout';
			}
		}
		// Set Previous skin in local db
		localStorage.setItem(dataLayout + '-prev-skin', currentLayout);
		// Set Current skin in local db
		localStorage.setItem(dataLayout + '-current-skin', switchToLayout);

		// Call set layout
		setLayout(switchToLayout);

		// ToDo: Customizer fix
		$('.horizontal-menu .header-navbar.navbar-fixed').css({
			background: 'inherit',
			'box-shadow': 'inherit'
		});
		$('.horizontal-menu .horizontal-menu-wrapper.header-navbar').css('background', 'inherit');
	});

	// Get current local storage layout
	var currentLocalStorageLayout = localStorage.getItem(dataLayout + '-current-skin');

	// Set layout on screen load
	//? Comment it if you don't want to sync layout with local db
	// setLayout(currentLocalStorageLayout);

	function setLayout(currentLocalStorageLayout) {
		var navLinkStyle = $('.nav-link-style'),
			currentLayout = getCurrentLayout(),
			mainMenu = $('.main-menu'),
			navbar = $('.header-navbar'),
			// Witch to local storage layout if we have else current layout
			switchToLayout = currentLocalStorageLayout ? currentLocalStorageLayout : currentLayout;

		$html.removeClass('semi-dark-layout dark-layout bordered-layout');

		if (switchToLayout === 'dark-layout') {
			$html.addClass('dark-layout');
			mainMenu.removeClass('menu-light').addClass('menu-dark');
			navbar.removeClass('navbar-light').addClass('navbar-dark');
			navLinkStyle.find('.ficon').replaceWith(feather.icons['sun'].toSvg({ class: 'ficon' }));
		} else if (switchToLayout === 'bordered-layout') {
			$html.addClass('bordered-layout');
			mainMenu.removeClass('menu-dark').addClass('menu-light');
			navbar.removeClass('navbar-dark').addClass('navbar-light');
			navLinkStyle.find('.ficon').replaceWith(feather.icons['moon'].toSvg({ class: 'ficon' }));
		} else if (switchToLayout === 'semi-dark-layout') {
			$html.addClass('semi-dark-layout');
			mainMenu.removeClass('menu-dark').addClass('menu-light');
			navbar.removeClass('navbar-dark').addClass('navbar-light');
			navLinkStyle.find('.ficon').replaceWith(feather.icons['moon'].toSvg({ class: 'ficon' }));
		} else {
			$html.addClass('light-layout');
			mainMenu.removeClass('menu-dark').addClass('menu-light');
			navbar.removeClass('navbar-dark').addClass('navbar-light');
			navLinkStyle.find('.ficon').replaceWith(feather.icons['moon'].toSvg({ class: 'ficon' }));
		}
		// Set radio in customizer if we have
		if ($('input:radio[data-layout=' + switchToLayout + ']').length > 0) {
			setTimeout(function () {
				$('input:radio[data-layout=' + switchToLayout + ']').prop('checked', true);
			});
		}
	}
})(window, document, jQuery);

// To use feather svg icons with different sizes
function featherSVG(iconSize) {
	// Feather Icons
	if (iconSize == undefined) {
		iconSize = '14';
	}
	return feather.replace({ width: iconSize, height: iconSize });
}

// jQuery Validation Global Defaults
if (typeof jQuery.validator === 'function') {
	jQuery.validator.setDefaults({
		errorElement: 'span',
		errorPlacement: function (error, element) {
			if (
				element.parent().hasClass('input-group') ||
				element.hasClass('select2') ||
				element.attr('type') === 'checkbox'
			) {
				error.insertAfter(element.parent());
			} else if (element.hasClass('form-check-input')) {
				error.insertAfter(element.parent().siblings(':last'));
			} else {
				error.insertAfter(element);
			}

			if (element.parent().hasClass('input-group')) {
				element.parent().addClass('is-invalid');
			}
		},
		highlight: function (element, errorClass, validClass) {
			$(element).addClass('error');
			if ($(element).parent().hasClass('input-group')) {
				$(element).parent().addClass('is-invalid');
			}
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass('error');
			if ($(element).parent().hasClass('input-group')) {
				$(element).parent().removeClass('is-invalid');
			}
		}
	});
}

// Add validation class to input-group (input group validation fix, currently disabled but will be useful in future)
/* function inputGroupValidation(el) {
  var validEl,
	invalidEl,
	elem = $(el);

  if (elem.hasClass('form-control')) {
	if ($(elem).is('.form-control:valid, .form-control.is-valid')) {
	  validEl = elem;
	}
	if ($(elem).is('.form-control:invalid, .form-control.is-invalid')) {
	  invalidEl = elem;
	}
  } else {
	validEl = elem.find('.form-control:valid, .form-control.is-valid');
	invalidEl = elem.find('.form-control:invalid, .form-control.is-invalid');
  }
  if (validEl !== undefined) {
	validEl.closest('.input-group').removeClass('.is-valid is-invalid').addClass('is-valid');
  }
  if (invalidEl !== undefined) {
	invalidEl.closest('.input-group').removeClass('.is-valid is-invalid').addClass('is-invalid');
  }
} */





/**
 * Display toastr
 *
 * @param string type
 * @param string message
 * @param string title
 * @param object config
 *
 * @return void
 */
function notify(type, message, title = null, config = {}) {
	title = title || (type.charAt(0).toUpperCase() + type.slice(1) + '!')

	toastr[type](message, title, {
		closeButton: false,
		tapToDismiss: false,
		progressBar: config.progressBar ? config.progressBar : ['error'].includes(type),
		rtl: true
	});
}


/**
 * Display ajax error with a notification/toastr
 *
 * @param object xhr
 * @param string textStatus
 * @param string errorThrown
 *
 * @return void
 */
function ajaxErrorDisplay(xhr, textStatus, errorThrown) {
	// START: Laravel validation error
	if (typeof (xhr.responseJSON) != "undefined") {
		if (xhr.responseJSON.errors && typeof xhr.responseJSON.errors == 'object') {
			Object.entries(xhr.responseJSON.errors).forEach(function ([key, errors]) {
				Object.entries(errors).forEach(function ([index, error]) {
					notify('error', error);
				});
			});
		}
		else if (xhr.responseJSON.message) {
			notify('error', xhr.responseJSON.message);
		}
		else {
			notify('error', errorThrown);
		}
	}
	// END: Laravel validation error
	else {
		notify('error', errorThrown);
	}
}

/**
 * Confirm delete sweet alert
 *
 * @param string url
 * @param string method
 * @param object config
 *
 * @return void
 */
function confirmDelete(url, method = 'DELETE', config = {}) {
	// Set default configuration
	// config.ajax = config.ajax || true;

	Swal.fire({
		title: 'Are you sure?',
		text: 'You won\'t be able to revert this!',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
		customClass: {
			confirmButton: 'btn btn-danger',
			cancelButton: 'btn btn-outline-info ms-1'
		},
		buttonsStyling: false
	}).then(function (result) {
		if (result.value) {
			startLoader();

			$.ajax({
				url: url,
				type: method,
				cache: false,
				processData: false,
				contentType: false,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: "json", // We will receive data in Json format
				success: function (result) {
					if (config.dataTableId) {
						LaravelDataTables[config.dataTableId]?.ajax.reload()
					}

					if (config.onSuccess && typeof config.onSuccess == 'function') {
						config.onSuccess();
					}

					Swal.fire({
						icon: 'success',
						title: 'Deleted!',
						text: result.message,
						customClass: {
							confirmButton: 'btn btn-success'
						}
					});
				},
				error: function (xhr, textStatus, errorThrown) {
					ajaxErrorDisplay(xhr, textStatus, errorThrown)
				}
			}).always(function () {
				stopLoader();
			});

		}
	});
}
$(document).on('click', '.confirm-delete', function () {
	let url = $(this).attr('confirm-delete-url');
	if (!url) {
		return;
	}

	let method = $(this).attr('confirm-delete-method') ?? 'DELETE';
	let dataTableId = $(this).attr('confirm-delete-dataTable-id');
	let onSuccess = $(this).attr('confirm-delete-on-success');
	// let ajax = $(this).attr('confirm-delete-ajax') === 'false' ? false : true;

	confirmDelete(url, method, {
		// ajax: ajax,
		dataTableId,
		onSuccess: Function(onSuccess)
	})
})

/**
 * Config CRUD that has a modal
 *
 * @param object data
 *
 * @return void
 */
function crudModal(data) {
	let form;

	if (!data.modal || $(data.modal).length == 0) {
		console.error('crudModal(): Modal not found or not defined.');
		return;
	};
	if ((!data.form || $(data.form).length == 0) && $(data.modal).find('form').length == 0) {
		console.error('crudModal(): Form not found or not defined.');
		return;
	};


	// Default Values
	data['loading_spinner'] = data.loading_spinner || true;
	data['notify'] = data.notify || true;

	form = data.form ? $(data.form) : $(data.modal).find('form').first();
	let modal = $(data.modal);
	let uid = Date.parse(Date());
	let cur_data_id;

	// Create "action" element, that's used to define if we are "creating" or "updating"
	// form.append('<input type="hidden id="crudModal-' + uid + '-action" value="">')
	let form_action;

	// START: Create
	$(document).off('click.crudModal', data.create_btn);
	$(document).on('click.crudModal', data.create_btn, function () {
		try {
			// Toggle loading spinner if exist and set to true
			startLoader();

			var create_btn = $(this);

			// Define action
			form_action = 'create';

			// Open Modal
			modal.modal('show');

			// Reset Form
			reset_form(form[0]);

			// Reset "select" field if it's connected to external library/function
			form.find('select').each(function () {
				if (typeof $(this).selectpicker == 'function') {
					$(this).selectpicker('deselectAll');
					$(this).selectpicker('refresh');
				}
			});

			$(data['title']['selector']).text(data['title']['value']['create']);
			// $('#' + _name + '-form-action-button').val('create'); // Used to check if the form is submitted before mySQL query
			$(data['submit_btn']['selector']).text(typeof data['submit_btn']['text'] == 'string' ? data['submit_btn']['text'] : data['submit_btn']['text']['create']);
			// $('#' + _name + '-form-action').val('create');

			// Run OnClick Function
			if (data.functions && typeof data.functions['onCreateBtnClicked'] == 'function') {
				data.functions['onCreateBtnClicked']();
			}

			// Toggle loding spinner if exist and set to true
			stopLoader();
		}
		catch (e) {
			stopLoader();

			alert(e);
		}
	});
	// END: Create

	// START: Update
	$(document).off('click.crudModal', data.update_btn);
	$(document).on('click.crudModal', data.update_btn, function () {
		try {
			startLoader();

			reset_form(form[0]);

			var update_btn = $(this);

			form_action = 'update';
			$(data['title']['selector']).text(data['title']['value']['update']);
			$(data['submit_btn']['selector']).text(typeof data['submit_btn']['text'] == 'string' ? data['submit_btn']['text'] : data['submit_btn']['text']['update']);

			cur_data_id = $(this).attr('data-id');

			var edit_url;
			if (data['url']['id_replace_key']) {
				edit_url = data['url']['edit'].replace(data['url']['id_replace_key'], cur_data_id);
			}
			else {
				edit_url = data['url']['edit'] + '/' + cur_data_id;
			}


			// Run OnClick Function
			var update_btn = $(this);
			if (data.functions && data.functions['onUpdateBtnClicked'] && data.functions['onUpdateBtnClicked']['always'] && data.functions['onUpdateBtnClicked']['always']['before']) {
				var func = data.functions['onUpdateBtnClicked']['always']['before'];

				var func_string = func.toString();

				func_string = func_string.replace(/%update_btn_id%/g, update_btn.attr('id'));
				let data_variables = func_string.match(/(?<=%)[^)]+?(?=%)/g) || [];
				data_variables.forEach(function (item) {
					try {
						var value = eval(item); // In case of error (variable not defined) it will not continue

						var replaceThis = '%' + item + '%';
						func_string = func_string.replace(new RegExp(replaceThis, 'g'), value);
					}
					catch (e) {
						// Nothing
					}
				});
				func_string = func_string.replace(/\%.+?\%/g, '');

				eval('[' + func_string + '][0]')();
			}



			$.ajax({
				url: edit_url,
				dataType: "json",
				success: function (result) {
					if (data.result_key)
						result = result[data.result_key];

					if (data.functions && data.functions.onUpdateBtnClicked && typeof data.functions.onUpdateBtnClicked['success']['before'] == 'function') {
						eval(data.functions.onUpdateBtnClicked['success']['before'](result))
					}


					Object.entries(data.inputs).forEach(function ([index, field]) {
						var tag = $(field.selector).prop('tagName');
						if (tag == 'INPUT' || tag == 'TEXTAREA') {
							if ($(field.selector).is(":checkbox") || $(field.selector).is(":radio")) {
								$(field.selector).prop("checked", $(field.selector).val() == result[field.result_key]);
							} else {
								$(field.selector).val(result[field.result_key] || '');
							}
						}
						else if (tag == 'SELECT') {
							// Selectpicker
							if (typeof $(field.selector).selectpicker == 'function') {
								$(field.selector).selectpicker('deselectAll');
								if (Array.isArray(result[field.result_key])) {
									var values = new Array();
									result[field.result_key].forEach(function (value) {
										// if (field[1].selectPicker_parm && field[1].selectPicker_parm != '') {
										// values.push(value[field[1].selectPicker_parm]);
										// } else {
										values.push(value);
										// }
									});
									console.log(values);
									$(field.selector).selectpicker('val', values);
								} else {
									$(field.selector).selectpicker('val', result[field.result_key]);
								}
							}
							// Select2
							if (typeof $(field.selector).select2 == 'function') {
								if (Array.isArray(result[field.result_key])) {
									var values = new Array();
									result[field.result_key].forEach(function (value) {
										values.push(value);
									});
									$(field.selector).val(values);
								} else {
									$(field.selector).val(result[field.result_key]);
								}

								setTimeout(() => {
									$(field.selector).change();
								}, 500);
							}
							// Normal
							else {
								$(field.selector).val(result[field.result_key] || '');
								// TODO: multiple
							}
						}
					});

					if (data.functions && data.functions.onUpdateBtnClicked && typeof data.functions.onUpdateBtnClicked['success']['after'] == 'function') {
						eval(data.functions.onUpdateBtnClicked['success']['after'](result))
					}

					// Open Modal
					modal.modal('show');
				},
				error: function (xhr, textStatus, errorThrown) {
					ajaxErrorDisplay(xhr, textStatus, errorThrown)
				}
			}).always(function () {
				stopLoader();
			});

			// Run OnClick Function
			if (data.functions && data.functions['onUpdateBtnClicked'] && data.functions['onUpdateBtnClicked']['always'] && data.functions['onUpdateBtnClicked']['always']['after']) {
				var func = data.functions['onUpdateBtnClicked']['always']['after'];

				var func_string = func.toString();

				func_string = func_string.replace(/%update_btn_id%/g, update_btn.attr('id'));
				let data_variables = func_string.match(/(?<=%)[^)]+?(?=%)/g) || [];
				data_variables.forEach(function (item) {
					try {
						var value = eval(item); // In case of error (variable not defined) it will not continue

						var replaceThis = '%' + item + '%';
						func_string = func_string.replace(new RegExp(replaceThis, 'g'), value);
					}
					catch (e) {
						// Nothing
					}
				});
				func_string = func_string.replace(/\%.+?\%/g, '');

				// var func_string = func.toString().replace(/\$row_id\$/g, row_id);
				eval('[' + func_string + '][0]')();
			}
		}
		catch (e) {
			stopLoader();

			alert(e);
		}
	});
	// END: Update

	// START: Submit
	if (data.submit_validation && data.submit_validation.rules) {
		form.validate({
			submitHandler: function (form) {
				submit(form);
			},
			rules: data.submit_validation.rules
		});
	}
	else {
		// Submit form event
		$(document).off('click.crudModal', data['submit_btn']['selector']);
		$(document).on('click.crudModal', data['submit_btn']['selector'], function (e) {
			e.preventDefault();
			submit()
		});
	}

	function submit() {
		if (!form || !data['submit_btn']['selector']) return;

		if (!form[0].reportValidity()) {
			return;
		}

		startLoader();

		$(data['submit_btn']['selector']).prop('disabled', true);
		let action_url = '';
		let method = '';

		if (form_action == 'create') {
			action_url = data['url']['create'];
			method = 'POST';
		}
		else if (form_action == 'update') {
			if (data['url']['id_replace_key']) {
				action_url = data['url']['update'].replace(data['url']['id_replace_key'], cur_data_id);
			}
			else {
				action_url = data['url']['update'] + '/' + cur_data_id;
			}
			method = 'PUT';
		}
		else {
			stopLoader();
			return;
		}

		let formData = new FormData(form[0]);
		formData.append('_method', method); // Necessary in Laravel PUT request

		$.ajax({
			url: action_url,
			method: 'POST', // We get the "method" from "_method" defined above
			cache: false,
			processData: false,
			contentType: false,
			data: formData,
			dataType: "json", // We will receive data in Json format
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (result) {
				if (result.success) {
                    notify('success', result.message);

					modal.modal('hide');
					reset_form(form[0]);

					if (data['actions'] && data['actions']['submit'] && data['actions']['submit']['success'] && data['actions']['submit']['success']['action']) {
						switch (data['actions']['submit']['success']['action']) {
							case 'reload-page':
								location.reload();
								break;
							case 'reload-dataTable':
								if (data.dataTableId) {
									try {
										LaravelDataTables[data.dataTableId]?.ajax.reload()
									}
									catch (e) {
										console.error('crudModal()', e);
									}
								}
								break;
						}
					}
				}


				if (data.functions && data.functions.onSubmitBtnClicked && typeof data.functions.onSubmitBtnClicked['success']['after'] == 'function') {
					var func = data.functions.onSubmitBtnClicked['success']['after'];

					var func_string = func.toString();

					Object.entries(result).forEach(function ([key, value]) {
						var replaceThis = '%result.' + key + '%';
						func_string = func_string.replace(new RegExp(replaceThis, 'g'), value);
					});
					func_string = func_string.replace(/\%.+?\%/g, '');

					// var func_string = func.toString().replace(/\$row_id\$/g, row_id);
					eval('[' + func_string + '][0]')();
				}
			},
			error: function (xhr, textStatus, errorThrown) {
				ajaxErrorDisplay(xhr, textStatus, errorThrown)
			}
		}).always(function () {
			stopLoader();
		});

		$(data['submit_btn']['selector']).prop('disabled', false);
	}
	// END: Submit

	// START: Reset Form
	function reset_form(form) {
		form.reset();

		$(form).find('.select2').change(); // Reset selected label

		// Reset "selectpicker fields"
		// .selectpicker('refresh');
	}
	// END: Reset Form
}

/**
 * Submit ajax form with POST method
 *
 * @param object data
 */
function formSubmit(data) {
	// Get "submit" button, so we can send its data (name, value) to backend, and also to disable it until the request is done
	$('button[type="submit"]').each(function () {
		$(this).click(function () {
			$('button[type="submit"]').removeAttr('clicked');
			$(this).attr('clicked', true);
		});
	});


	// Validation
	if (data.validation && data.validation.rules) {
		$(data.form).validate({
			submitHandler: function (form) {
				submit(form);
			},
			rules: data.validation.rules
		});
	}
	else {
		// Submit form event
		$(data.form).on('submit', function (e) {
			e.preventDefault();
			submit(this)
		});
	}

	function submit(form) {
		startLoader();

		// Get Clicked Button
		let clicked_button = $(this).find("button[clicked=true]");

		// Disable Clicked Button and
		clicked_button.prop('disabled', true);

		// Get Clicked Button Data
		let clicked_button_data = {
			name: clicked_button.attr('name'),
			value: clicked_button.val(),
		}

		// let form = this;
		let formData = new FormData(form);
		formData.append(clicked_button_data.name, clicked_button_data.value);

		if (data.formDataFilter && typeof data.formDataFilter == 'function') {
			formData = data.formDataFilter(formData);
		}

		// data.url = data.url ?? form.getAttribute('action') // ! using this, we will update the "data.url", so the next time we submit the form (and the "action url" is changed), the script will read it from "data.url" instead of the "form action attribute"
		let actionUrl = data.url ?? form.getAttribute('action')

		// Send query to server
		$.ajax({
			url: actionUrl,
			method: data.method || 'post',
			cache: false,
			processData: false,
			contentType: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			data: formData,
			success: function (results) {
				if (data.onSuccess && typeof data.onSuccess == 'function') {
					data.onSuccess(results);
				}

				if (results.redirect_url) {
					window.location.href = results.redirect_url + (results.message ? '?msg_success=' + results.message : '');
				}
				else {
					if (data.dataTableId) {
						try {
							LaravelDataTables[data.dataTableId]?.ajax.reload()
						}
						catch (e) {
							console.error('crudModal()', e);
						}
					}
					notify('success', results.message);
				}
			},
			error: function (xhr, textStatus, errorThrown) {
				ajaxErrorDisplay(xhr, textStatus, errorThrown)
			}
		}).always(function () {
			stopLoader();

			// Re-enable Clicked Button and
			clicked_button.prop('disabled', false);
		});
	}
}

$(document).ready(function () {
	const params = new Proxy(new URLSearchParams(window.location.search), {
		get: (searchParams, prop) => searchParams.get(prop),
	}); // Credits: https://stackoverflow.com/a/901144/9845865

	let msg_success = params.msg_success;
	if (msg_success) {
		setTimeout(() => {

			notify('success', msg_success)

			// Remove Message Parameter From URL If Exist (Reference: https://gist.github.com/simonw/9445b8c24ddfcbb856ec)
			history.replaceState && history.replaceState(
				null, '', location.pathname + location.search.replace(/[\?&]msg_success=[^&]+/, '').replace(/^&/, '?')
			);
		}, 500)
	}
});
