(function ($) {

	$(document).ready(function () {
		handleOwlCarousel();
		handleSyncedOwlCarousel();
		handleHeader();
		handleAccordion();
		WPML_popup_filter();
	});

	function handleHeader() {
		handleHeaderDropdown();
		toggleSearch();
	}


	function handleAccordion() {
		var $firstImg = $('.project-item img.project-image').first();
		var initialTarget = $firstImg.data('bsTarget');
		var currentlyOpenElem = $(initialTarget)[0];

		var currentlyOpenCollapse = new bootstrap.Collapse(currentlyOpenElem, { toggle: false });
		currentlyOpenCollapse.show();

		var transitionInProgress = false;

		$('.collapse').on('shown.bs.collapse hidden.bs.collapse', function () {
			transitionInProgress = false;
		});

		$('.project-item img.project-image').each(function () {
			var $img = $(this);
			var targetSelector = $img.data('bsTarget');
			var $targetElem = $(targetSelector);

			$img.on('mouseenter', function () {
				if (transitionInProgress || targetSelector === '#' + currentlyOpenElem?.id) {
					return;
				}

				transitionInProgress = true;

				setTimeout(function () {
					$(currentlyOpenElem).collapse('hide');
					currentlyOpenElem = $targetElem[0];
					$(currentlyOpenElem).collapse('show');
				}, 50);
			});

			$img.on('click', function () {
				if (transitionInProgress) {
					return;
				}

				if (targetSelector !== '#' + currentlyOpenElem.id) {
					transitionInProgress = true;

					setTimeout(function () {
						$(currentlyOpenElem).collapse('hide');
						currentlyOpenElem = $targetElem[0];
						$(currentlyOpenElem).collapse('show');
					}, 50);
				}
			});

			$img.on('mouseleave', function () {
			});
		});

		function adjustCardWidths() {
			var maxWidth = 0;
			$('.project-item img.project-image').each(function () {
				var width = $(this).innerWidth();
				if (width > maxWidth) {
					maxWidth = width;
				}
			});
			$('.project-item .card').css("width", maxWidth + "px");
		}

		$(window).on('resize', adjustCardWidths).trigger('resize');
		adjustCardWidths();
	}


	function handleHeaderDropdown() {
		$('.dropdown').hover(
			function () {
				$(this).find('.dropdown-menu').first().dropdown('show');
				$(this).find('a').first().addClass('active');
				if(!isMobile) $('.mega-menu-style-2 .depth_0 li:first-child ul.depth_1').addClass('show');
			},
			function () {
				$(this).find('.dropdown-menu').first().dropdown('hide');
				$(this).find('a').first().removeClass('active');
				if(!isMobile) $('.mega-menu-style-2 .depth_0 li:first-child ul.depth_1').addClass('show');

			}
		);

		// $('.dropdown').first().find('.dropdown-menu').first().dropdown('show').find('.dropdown-menu').first().dropdown('show');
	}

	function isMobile() {
		return window.innerWidth < 991;
	}

	function handleOwlCarousel() {
		$(".owl-carousel").not(".owl-skip").each(function () {
			var owl = $(this);

			if (owl.find('.item').length <= 1) return;

			var data_loop = owl.data('loop') ?? false;
			var data_dots = owl.data('dots') ?? false;
			var data_items = owl.data('items') ?? 1;
			var data_padding = owl.data('padding') ?? 0;
			var data_start = owl.data('start') ?? 0;
			var data_center = owl.data('center') ?? false;
			var data_autoWidth = owl.data('autoWidth') ?? false;
			var data_margin = owl.data('margin') ?? 0;
			var responsive = owl.data('responsive') ?? {};
			var owl_options = {
				items: data_items,
				loop: data_loop,
				dots: data_dots,
				stagePadding: data_padding,
				startPosition: data_start,
				center: data_center,
				autoWidth: data_autoWidth,
				margin: data_margin,
			};

			if (responsive && isMobile()) {
				owl_options.responsive = responsive;
			}

			console.log('owl_options', owl_options);


			owl.owlCarousel(owl_options);


			if (owl.hasClass('owl-first-bigger')) {
				function adjustWidths() {

				}
				owl.on('initialized.owl.carousel translated.owl.carousel', adjustWidths);
				adjustWidths();
			}


			//handle middle item
			updateMiddleItem();
			owl.on('translated.owl.carousel', updateMiddleItem);
			owl.on('translate.owl.carousel', function () {
				owl.find('.owl-item').removeClass('highlight');
			});


			//handle video play
			owl.on('translate.owl.carousel', function () {
				$('video').each(function () {
					this.pause();
				});
				$('iframe').each(function () {
					var src = $(this).attr('src');
					if (src && src.includes('vimeo')) {
						if (typeof Vimeo !== 'undefined' && Vimeo.Player) {
							var player = new Vimeo.Player($(this));
							player.pause();
						}
					}
				});
			});

			//play video on active slide
			owl.on('translated.owl.carousel', function (event) {
				var current = $(event.target).find('.owl-item.active');
				var video = current.find('video');
				if (video.length) {
					video.get(0).play();
				} else {
					var iframe = current.find('iframe');
					if (iframe.length && iframe.attr('src').includes('vimeo')) {
						if (typeof Vimeo !== 'undefined' && Vimeo.Player) {
							var player = new Vimeo.Player(iframe);
							player.play();
						}
					}
				}
			});

			var data_arrows = owl.data('arrows') ?? false;

			if (data_arrows) {
				$('.custom-prev-' + data_arrows).on('click', function () {
					var owl = $(this).closest('.container').find('.owl-carousel');
					owl.trigger('prev.owl.carousel');
				});

				$('.custom-next-' + data_arrows).on('click', function () {
					var owl = $(this).closest('.container').find('.owl-carousel');
					owl.trigger('next.owl.carousel');
				});
			}

			function updateMiddleItem() {
				owl.find('.owl-item').removeClass('highlight first-active');

				var activeItems = owl.find('.owl-item.active');
				var totalVisible = activeItems.length;
				var middleIndex = Math.floor(totalVisible / 2);

				if (totalVisible === 2) {
					middleIndex = 0;
				}

				

				var middleItem = activeItems.eq(middleIndex);
				middleItem.addClass('highlight');
				activeItems.first().addClass('first-active');
			}

		});
	}

	function handleSyncedOwlCarousel() {

		$('.custom-prev-solution').on('click', function () {
			$('.slider-1 .owl-carousel').trigger('prev.owl.carousel');
		});

		$('.custom-next-solution').on('click', function () {
			$('.slider-1 .owl-carousel').trigger('next.owl.carousel');
		});

		var slider1 = $('.slider-1 .owl-carousel');
		var slider2 = $('.slider-2 .owl-carousel');
		var syncing = false;

		slider1.owlCarousel({
			items: 1,
			loop: true,
			nav: false,
			dots: false,
			autoplay: false,
			animateOut: 'fadeOut',
			smartSpeed: 450, // Duration of transition
			mouseDrag: false, // Disable mouse drag for smoother transitions
		}).on('initialized.owl.carousel', function (event) {
			var total = event.item.count;
			$('.total-slider-items .total').text(total);
			$('.total-slider-items .current').text(1);
		}).on('changed.owl.carousel', function (event) {
			if (!syncing) {
				syncing = true;
				var index = event.item.index - event.relatedTarget._clones.length / 2;
				var count = event.item.count;

				if (index < 0) {
					index = count + index;
				} else if (index >= count) {
					index = index - count;
				}

				var current = index + 1;
				$('.total-slider-items .current').text(current);

				slider2.trigger('to.owl.carousel', [index, 300, true]);
				syncing = false;
			}
		});

		slider2.owlCarousel({
			items: 1,
			loop: true,
			nav: false,
			dots: false,
			autoplay: false,
		}).on('changed.owl.carousel', function (event) {
			if (!syncing) {
				syncing = true;
				var index = event.item.index - event.relatedTarget._clones.length / 2;
				var count = event.item.count;

				if (index < 0) {
					index = count + index;
				} else if (index >= count) {
					index = index - count;
				}

				var current = index + 1;
				$('.total-slider-items .current').text(current);

				slider1.trigger('to.owl.carousel', [index, 300, true]);
				syncing = false;
			}
		});
	}

	function toggleSearch() {
		var form = $('.search-form');
		$(document).on('click', '.search-icon, .close-search', function () {
			form.toggleClass('d-flex d-none');
			form.find('input[type="search"]').val('').focus();
		});
	}

	function WPML_popup_filter() {
		const $searchInput = $('#lang-search');
		const $languageItems = $('.language-item');
		const preSelectedLang = $searchInput.data('preSelected');

		console.log('preSelectedLang', preSelectedLang);


		$searchInput.on('input', function () {
			const searchTerm = $(this).val().toLowerCase();

			$languageItems.each(function () {
				const langName = $(this).data('name').toLowerCase();
				const langCode = $(this).data('code').toLowerCase();

				if (langName.includes(searchTerm) || langCode.includes(searchTerm)) {
					$(this).show();
				} else {
					$(this).hide();
				}
			});
		});

		$searchInput.on('focusout', function () {
			const searchTerm = $(this).val();

			if (searchTerm === '') {
				$languageItems.each(function () {
					const langCode = $(this).data('code').toUpperCase();
					if (preSelectedLang.includes(langCode)) {
						$(this).show();
					} else {
						$(this).hide();
					}
				});
			}
		});
	}

})(jQuery);