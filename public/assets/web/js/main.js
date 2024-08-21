/**
* Template Name: Arsha - v4.9.1
* Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

$(document).ready(function(){
	var lang = $('html').attr('lang'); // Misalnya, <html lang="ar">

	$('.slide1').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: false,
		dots: false,
		arrows: false,
		rtl: lang === 'ar' ? true : false, // Aktifkan RTL jika bahasa adalah Arab
		asNavFor: '.slide2'
	});

	$('.slide2').slick({
		slidesToScroll: 1,
		slidesToShow: 7,
		infinite: false,
		dots: false,
		arrows: true,
		rtl: lang === 'ar' ? true : false, // Aktifkan RTL jika bahasa adalah Arab
		asNavFor: '.slide1',
		focusOnSelect: true,
		responsive: [
			{
			breakpoint: 480,
				settings: {
					slidesToShow: 4
				}
			},
		]
	}).on('afterChange', function(event, slick, currentSlide){
		// Remove is-active class from all items
		$('.slide2 .slick-slide').removeClass('is-active');
	
		// Add is-active class to the current item and all previous items
		for (var i = 0; i <= currentSlide; i++) {
			$('.slide2 .slick-slide[data-slick-index="' + i + '"]').addClass('is-active');
		}
	});


	

	var owl = $('#about-list');
	
    owl.owlCarousel({
        loop: false,
		rtl: lang === 'ar' ? true : false, // Aktifkan RTL jika bahasa adalah Arab
        nav: false,
		responsive : {
			// breakpoint from 0 up
			0 : {
				items : 1,
				dots: true,
			},
			// breakpoint from 768 up
			768 : {
				items : 3,
				dots: false,
			}
		},
    });

	var owlRecipe = $('#recipe-list');
    owlRecipe.owlCarousel({
        loop: false,
        nav: false,
		rtl: lang === 'ar' ? true : false, // Aktifkan RTL jika bahasa adalah Arab
		margin: 30,
		center: false,
		responsive : {
			// breakpoint from 0 up
			0 : {
				items : 1,
				dots: true,
				stagePadding: 0,
				margin: 25,
			},
			// breakpoint from 768 up
			768 : {
				items : 3,
				dots: false,
				stagePadding: 0,
				margin: 30,
			},
			// breakpoint from 768 up
			1200 : {
				items : 4,
			}
		},
    });

	var owlCatalog = $('#catalog-slider');
    owlCatalog.owlCarousel({
        loop: true,
		rtl: lang === 'ar' ? true : false, // Aktifkan RTL jika bahasa adalah Arab
        nav: false,
		center: false,
		responsive : {
			// breakpoint from 0 up
			0 : {
				items : 1,
				dots: true,
				stagePadding: 0,
				dots: true,
			},
			// breakpoint from 768 up
			768 : {
				items : 2,
				dots: false,
				stagePadding: 120,
				dots: false,
			},
			// breakpoint from 768 up
			1600 : {
				items : 3,
				dots: false,
			}
		},
    });

	// Custom Button for Previous
	$('#prev-catalog').click(function() {
		owlCatalog.trigger('prev.owl.carousel');
	});

	// Custom Button for Next
	$('#next-catalog').click(function() {
		owlCatalog.trigger('next.owl.carousel');
	});

	var owlNews = $('#news-slider');
    owlNews.owlCarousel({
        loop: true,
		rtl: lang === 'ar' ? true : false, // Aktifkan RTL jika bahasa adalah Arab
        nav: false,
		center: false,
		responsive : {
			// breakpoint from 0 up
			0 : {
				items : 1,
				dots: true,
				margin: 25,
			},
			// breakpoint from 768 up
			768 : {
				items : 3,
				dots: false,
				margin: 30,
			},
			// breakpoint from 768 up
			1600 : {
				items : 3,
				dots: false,
			}
		},
    });

	// Custom Button for Previous
	$('#prev-news').click(function() {
		owlNews.trigger('prev.owl.carousel');
	});

	// Custom Button for Next
	$('#next-news').click(function() {
		owlNews.trigger('next.owl.carousel');
	});

	var owl = $('#home-slide');
    owl.owlCarousel({
        items: 1,
		autoplay: true, 
		// rtl: lang === 'ar' ? true : false, // Aktifkan RTL jika bahasa adalah Arab
        loop: false,
        nav: true,
        dots: true,
		navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
    });

    var owl = $('#about-slide');
    owl.owlCarousel({
        items: 1,
		rtl: lang === 'ar' ? true : false, // Aktifkan RTL jika bahasa adalah Arab
        loop: false,
        nav: false,
        dots: true,
        onInitialized: addActiveClass,
        onTranslated: addActiveClass
    });

	var dots = $('#about-slide .owl-dot').length;
	document.documentElement.style.setProperty('--dots-count', dots);
	

    function addActiveClass() {
        var activeIndex = owl.find('.owl-item.active').index();
        $('.owl-dot').each(function(index) {
            if (index <= activeIndex) {
                $(this).addClass('isactive');
            } else {
                $(this).removeClass('isactive');
            }
        });
    }
});
(function() {
	"use strict";

	/**
	* Easy selector helper function
	*/
	const select = (el, all = false) => {
	el = el.trim()
	if (all) {
	  return [...document.querySelectorAll(el)]
	} else {
	  return document.querySelector(el)
	}
	}

	/**
	* Easy event listener function
	*/
	const on = (type, el, listener, all = false) => {
	let selectEl = select(el, all)
	if (selectEl) {
	  if (all) {
		selectEl.forEach(e => e.addEventListener(type, listener))
	  } else {
		selectEl.addEventListener(type, listener)
	  }
	}
	}

	/**
	* Easy on scroll event listener 
	*/
	const onscroll = (el, listener) => {
	el.addEventListener('scroll', listener)
	}

	/**
	* Navbar links active state on scroll
	*/
	let navbarlinks = select('#navbar .scrollto', true)
	const navbarlinksActive = () => {
	let position = window.scrollY + 200
	navbarlinks.forEach(navbarlink => {
	  if (!navbarlink.hash) return
	  let section = select(navbarlink.hash)
	  if (!section) return
	  if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
		navbarlink.classList.add('active')
	  } else {
		navbarlink.classList.remove('active')
	  }
	})
	}
	window.addEventListener('load', navbarlinksActive)
	onscroll(document, navbarlinksActive)

	/**
	* Scrolls to an element with header offset
	*/
	const scrollto = (el) => {
	let header = select('#header')
	let offset = header.offsetHeight

	let elementPos = select(el).offsetTop
	window.scrollTo({
	  top: elementPos - offset,
	  behavior: 'smooth'
	})
	}

	/**
	* Toggle .header-scrolled class to #header when page is scrolled
	*/
	let selectHeader = select('#header')
	if (selectHeader) {
	const headerScrolled = () => {
	  if (window.scrollY > 100) {
		// selectHeader.classList.add('header-scrolled')
	  } else {
		// selectHeader.classList.remove('header-scrolled')
	  }
	}
	window.addEventListener('load', headerScrolled)
	onscroll(document, headerScrolled)
	}

	/**
	* Back to top button
	*/
	let backtotop = select('.back-to-top')
	if (backtotop) {
	const toggleBacktotop = () => {
	  if (window.scrollY > 100) {
		backtotop.classList.add('active')
	  } else {
		backtotop.classList.remove('active')
	  }
	}
	window.addEventListener('load', toggleBacktotop)
	onscroll(document, toggleBacktotop)
	}

	/**
	* Mobile nav toggle
	*/
	on('click', '.mobile-nav-toggle', function(e) {
	select('#navbar').classList.toggle('navbar-mobile')
	this.classList.toggle('bi-list')
	this.classList.toggle('bi-x')
	})

	/**
	* Mobile nav dropdowns activate
	*/
	on('click', '.navbar .dropdown > a', function(e) {
	if (select('#navbar').classList.contains('navbar-mobile')) {
	  e.preventDefault()
	  this.nextElementSibling.classList.toggle('dropdown-active')
	}
	}, true)

	/**
	* Scrool with ofset on links with a class name .scrollto
	*/
	on('click', '.scrollto', function(e) {
	if (select(this.hash)) {
	  e.preventDefault()

	  let navbar = select('#navbar')
	  if (navbar.classList.contains('navbar-mobile')) {
		navbar.classList.remove('navbar-mobile')
		let navbarToggle = select('.mobile-nav-toggle')
		navbarToggle.classList.toggle('bi-list')
		navbarToggle.classList.toggle('bi-x')
	  }
	  scrollto(this.hash)
	}
	}, true)

	/**
	* Scroll with ofset on page load with hash links in the url
	*/
	window.addEventListener('load', () => {
	if (window.location.hash) {
	  if (select(window.location.hash)) {
		scrollto(window.location.hash)
	  }
	}
	});

	var sync1 = $("#sync1");
	var sync2 = $("#sync2");
	var syncedSecondary = true;

	sync1.owlCarousel({
		items: 1,
		slideSpeed: 2000,
		nav: false,
		autoplay: false, 
		dots: false,
		loop: true,
		responsiveRefreshRate: 200,
		// navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
	}).on('changed.owl.carousel', syncPosition);

	sync2
		.on('initialized.owl.carousel', function() {
			sync2.find(".owl-item").eq(0).addClass("");
		})
		.owlCarousel({
			// items: slidesPerPage,
			dots: false,
			nav: false,
			smartSpeed: 200,
			center:false,
			loop:false,
			slideSpeed: 500,
			responsiveRefreshRate: 100,
			responsive : {
				// breakpoint from 0 up
				0 : {
					items : 2,
				},
				// breakpoint from 768 up
				768 : {
					items : 3,
				}
			},
			// navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
		}).on('changed.owl.carousel', syncPosition2);

	function syncPosition(el) {
		//if you set loop to false, you have to restore this next line
		// var current = el.item.index;

		//if you disable loop you have to comment this block
		var count = el.item.count - 1;
		var current = Math.round(el.item.index - (el.item.count / 2) - .5);

		if (current < 0) {
			current = count;
		}
		if (current > count) {
			current = 0;
		}

		//end block

		sync2
			.find(".owl-item")
			.removeClass("center")
			.eq(current)
			.addClass("center");
		var onscreen = sync2.find('.owl-item.active').length - 1;
		var start = sync2.find('.owl-item.active').first().index();
		var end = sync2.find('.owl-item.active').last().index();

		if (current > end) {
			sync2.data('owl.carousel').to(current, 100, true);
		}
		if (current < start) {
			sync2.data('owl.carousel').to(current - onscreen, 100, true);
		}
	}

	function syncPosition2(el) {
		if (syncedSecondary) {
			var number = el.item.index;
			sync1.data('owl.carousel').to(number, 100, true);
		}
	}

	sync2.on("click", ".owl-item", function(e) {
		e.preventDefault();
		var number = $(this).index();
		sync1.data('owl.carousel').to(number, 300, true);
	});
	
	$('.parent-container').magnificPopup({
	  delegate: 'a.gallery-thumbnail',
	  type: 'image',
	  closeOnContentClick: false,
	  closeBtnInside: false,
	  mainClass: 'gallery-detail',
	  image: {
		verticalFit: true,
		titleSrc: function(item) {
		  return '<div class="title-gallery">'+item.el.attr('title') + ' </div><div class="content-gallery">'+item.el.attr('content') + '</div>';
		}
	  },
	  gallery: {
		enabled: true
	  },
	  zoom: {
		enabled: true,
		duration: 300, // don't foget to change the duration also in CSS
		opener: function(element) {
		  return element.find('img');
		}
	  }
	});
	
	
	/**
	 * Animation on scroll
	 */
	window.addEventListener('load', () => {
		AOS.init({
		duration: 1000,
		easing: "ease-in-out",
		once: true,
		mirror: false
		});
	});

  	document.addEventListener('DOMContentLoaded', function () {
		const dropdownToggleButtons = document.querySelectorAll('.btn-secondary.dropdown-toggle');
		dropdownToggleButtons.forEach(button => {
			button.addEventListener('click', function (event) {
				event.stopPropagation();
			});
		});
	});

})()