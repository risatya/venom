jQuery.fn.id = function(attribute) {
	if (!attribute) attribute = 'id';
	var id = this.eq(0).attr(attribute);
	return id ? parseInt(id.match(/(\d+)$/)[1], 10) : null;
};

jQuery.fn.inputFieldText = function(string, hintClass) {
	this.each(function() {
      $(this).filter(function(){
      	return ($(this).val() == '' || $(this).val() == string);
      }).addClass(hintClass).val(string);
      $(this).focus(function(){
        if ($(this).val() == string){
          $(this).removeClass(hintClass).val('');
        }
      });
      $(this).blur(function(){
        if ($(this).val() == ''){
          $(this).addClass(hintClass).val(string);
        }
      });
      var $this = $(this);
      $this.parents('FORM').submit(function(){
      	if ($this.val() == string) {
      		$this.val('');
      	}
      	return true;
      });
  });

  return this;
};

// LIGHTBOX

$(function(){

	if (!$.fn.fancybox) {
		return;
	}

	var $curvyCorners = $('<div id="fancy-edge-tl"></div><div id="fancy-edge-br"></div>');

	//Do Larger Images
	$('.fancylarge').fancybox({
		onStart:function() {
			if ($('#fancy-edge-tl').length == 0) {
				$('#fancybox-outer').append($curvyCorners);
			}
		},
		titleFormat:function(title) {
			return title;
		},
		speedIn:400,
		speedOut:400,
		autoDimensions:false,
		overlayShow: true,
		overlayColor: '#082339',
		overlayOpacity: 0.88,
		padding:15,
		hideOnContentClick:false
	});

	//Do Video
	$('BODY').append('<div style="display:none" id="video"></div>').append('<a href="#video" id="videoLink" />');

	$('a.video').click(function(evt){
		
		// skip video popup when user is on iWhatever
		// we return true so user is directed to mp4 directly
		if (navigator.userAgent.toLowerCase().match(/(iphone|ipod|ipad)/)) {
			return true;
		}

		var videoDetails = $(this).next().find('param[name="data"]').metadata({type:'attr', name:'value'});
		videoDetails.url = $(this).attr('href');
		videoDetails.title = $(this).attr('title');

		var flashvars = {
			autostart:'true', repeat:'false',
			width:videoDetails.width,
			height:videoDetails.height,
			file:videoDetails.url,
			skin:'/swf/thiess_videoskin.zip',
			controlbar:'over'
		};

		var player = 'player.swf';
		if (swfobject.getFlashPlayerVersion().major < 10) {
			player = 'playerv9.swf';
			delete flashvars.skin;
			delete flashvars.controlbar;
			videoDetails.height += 20;
		}

		$('#videoLink').attr('title', $(this).attr('title')).css({position:'absolute', top:evt.pageY, left:evt.pageX}).fancybox({
			onStart:function() {
				if ($('#fancy-edge-tl').length == 0) {
					$('#fancybox-outer').append($curvyCorners);
				}
				$(window).trigger('FancyBox.open');
			},
			onComplete:function(){
				swfobject.embedSWF('/swf/'+player, 'fancy-video', videoDetails.width, videoDetails.height, '9.0.115', null, flashvars, {allowfullscreen:'true'}, null, function(obj) {
					if (obj.success == false) {
						$('#fancy-video').append('<p style="text-align: center;font-size: 16px;"><strong>This video requires <a href="http://get.adobe.com/flashplayer" target="_blank" style="font-size: 16px;">Adobe Flash Player</a> to be installed</strong></p>')
					}
				});
			},
			onCleanup:function() {
				$('#fancy-video').empty();
			},
			onClosed:function() {
				//$('#fancybox-outer').remove($curvyCorners);
				$(window).trigger('FancyBox.close');
			},
			content:'<div id="fancy-video"></div>',
			speedIn:400,
			speedOut:400,
			width:videoDetails.width,
			height:videoDetails.height,
			scrolling:false,
			padding:15,
			autoDimensions:false,
			overlayShow: true,
			overlayColor: '#082339',
			overlayOpacity: 0.88,
			titleFormat:function(title) {
				return title;
			},
			hideOnContentClick:false
		}).trigger('click');

		return false;

	});

	$('div.audio-player').each(function(i){
		$('a', this).each(function(){
			var url = $(this).attr('href');
			var $player = $('<div />').attr('id', 'audio-player-'+i);
			$(this).replaceWith($player);
			var data = {};
			data.file = url;
			var player = 'player.swf';
			var height = 62;
			if (swfobject.getFlashPlayerVersion().major < 10) {
				player = 'playerv9.swf';
				height = 20;
			} else {
				data.skin = '/swf/thiess_audioskin.zip';
			}
			data.icons = false;
			swfobject.embedSWF('/swf/'+player, 'audio-player-'+i, 599, height, '9.0.115', null, data, {wmode: 'transparent'});
		});
	});

});

// NAV INTERACTIONS

$(function(){
	var mainNavPos = $('#main-nav').position();

	$active = $('#main-nav>LI.active>A');

	var $mainNavBg = $('<div id="main-nav-bg"><div></div></div>').hide().prependTo('#container');

	$('#main-nav UL').each(function(){
		var subnavWidth = 0;
		$li = $('LI', this);
		$li.each(function(){
			subnavWidth += $(this).width();
		});
		var padding = Math.floor(($(this).width() - subnavWidth) / $li.length / 2);
		$li.css({paddingLeft:padding+'px', paddingRight:(padding - 1) +'px'});
		$li.eq(0).addClass('first');
	});


	if ($active.length) {
		slideTo($active, false);
		$active.parent().find('ul').css({display:'block'}); // this is required to enable fadeOut/fadeIn
	}

	$('#main-nav>LI>A').hover(function(){
		slideTo(this, true);
		if ($active.get(0) == this) {
			if ($.browser.msie){
				$active.parent().find('ul').show();
			} else {
				$active.parent().find('ul').fadeIn(300);
			}
		} else {
			$active.parent().removeClass('active');
			if ($.browser.msie){
				$active.parent().find('ul').hide();
			} else {
				$active.parent().find('ul').fadeOut(300);
			}
		}
	}, function(){
		if ($active.length) {
			slideTo($active, true);
		}
	});

	$('#main-nav').hover(function(){
		// do nothin!
	}, function(){
		if ($active.length == 0) {
			$mainNavBg.hide();
		}
		if ($.browser.msie){
			$active.parent().addClass('active').find('ul').show();
		} else {
			$active.parent().addClass('active').find('ul').fadeIn(300);
		}
	});

	function slideTo(item, animate) {
		var pos = $(item).offset();
		var x = pos.left - 1;
		var y = mainNavPos.top + 17; // 17 is needed to position at bottom of nav
		var width = $(item).width();
		var duration = (animate && $mainNavBg.is(':visible')) ? 400 : 0;
		$mainNavBg.animate({top:y,left:x,width:width+'px'}, {duration:duration,queue:false}).show();
	}

});


//GENERIC SITE FUNCTIONS
$(function() {

	$('#search-clear').click(function() {
		$('#main-search-middle input[type="text"]').val('').focus();
		event.stopPropagation();
		return false;
	});

	$.lastClicked = '';
	$('#main-search-middle input[type="text"], #search-clear').focus(function() {
		if ($('#main-search-middle input[type="text"]').width() < 100) {
			$(this).animate({width: 150}, function() {
				$('#search-clear').fadeIn();
			});
		}
	});

	$('#main-search').click(function(event) {
		event.stopPropagation();
	});

	$(document).click(function() {
		if (!$(this).parents().is('#main-search') && $('#main-search-middle input[type="text"]').width() > 88) {
			$('#main-search-middle input[type="text"]').animate({width: 88}, function() {
				$('#search-clear').fadeOut();
			});
		}
	});



	$('.submit input').hover(function() {
		$(this).addClass('hover');
	}, function() {
		$(this).removeClass('hover');
	});

	$('LABEL[for]').not('#JobAlertSubscribeForm LABEL, #JobAlertUnsubscribeForm LABEL, #SupplierRegisterForm LABEL').each(function(){
		$('#'+$(this).attr('for')+'[type=text]').inputFieldText($(this).text(), 'hint');
	}).hide();

	$('.base TABLE').each(function(){
		var i = 0;
		$('TR', this).each(function(){
			if ($('TH',this).length == 0) {
				if (++i % 2 == 0) {
					$(this).addClass('even');
				}
			}
		});
	});

	$('A, AREA').filter(function(){
		var href = $(this).attr('href');
		return href && !this.target && ((href.indexOf(window.location.hostname) == -1 && href.match(/^https?/i)) || href.match(/\.pdf$/i));
	}).attr('target', '_blank');


	$('a.print').click(function(){
		if (window.print) {
			$logo = $('<div id="print-logo"></div>').prependTo('BODY');
			window.print();
			$logo.remove();
		} else {
			alert('Please use the print button in your browser.');
		}
		return false;
	});

	$('a.bookmark').click(function() {
		if (document.all) {
			window.external.AddFavorite(location.href, document.title);
		} else if (window.sidebar) {
			window.sidebar.addPanel(document.title, location.href, '');
		}
		return false;
	});

	$('IMG[align=left]').addClass('alignLeft');
	$('IMG[align=right]').addClass('alignRight');
//	$('HR').replaceWith('<div class="hr"></div>');
	$('.pagecontent>p:first').addClass('first-paragraph');

	//FOOTER STYLES
	$('#footerMenu li:last-child').css({'background': 'none'});
	$('#footerMenu li:first-child').css({'padding-left': 0});
	footerWidth = ($('#footerMenu').width() + 25) / $('#footerMenu > li').length;
	$('#footerMenu li').width(footerWidth - 50);

	//NEWS CAROUSEL
	$("#news-carousel").carousel({
		'btnsPosition': 'outside',
		'nextBtn': '<a>',
		'prevBtn': '<a>',
		'dispItems': 3,
		'animSpeed': 1500,
		'slideEasing': 'easeOutQuart'
	});

	$('#news-carousel li:last-child').css({'background-image': 'none'});


	// HERO ELEMENT
	$('#hero-container').each(function(){

		var currentIndex = -1;
		var numItems = $('.hero-item', this).length;
		var heroWidth = $(this).width();
		var timeoutLength = 8; // seconds
		var timeoutRef;

		heroNavigate(0);

		$('.hero-info-panel', this).each(function(){
			if ($('.hero-item-title IMG', this).attr('height') > 40) {
				$(this).addClass('hero-info-panel-large');
			}
		});

		// remove details from items and put into array for later retrieval!

		var details = [];
		$('.hero-item', this).each(function(){
			details.push($(this).children().detach());
		});

		$('#hero-nav A', this).click(function(){
			var index = $(this).id() - 1;
			heroNavigate(index);
			return false;
		});

		function heroNavigate(index) {
			if (index == currentIndex) {
				return;
			}
			clearTimeout(timeoutRef);
			if (currentIndex > -1) {
				$('#hero-details').fadeOut(150);
			}
			currentIndex = index;
			$('#hero-items').animate({marginLeft:-(index * heroWidth)}, {
				duration:1000,
				easing:'easeOutQuad',
				complete:showDetails
			});
			$('#hero-nav A').siblings().removeClass('active');
			$('#hero-nav A:eq('+index+')').addClass('active');
			if (numItems > 1) {
				timeoutRef = setTimeout(goNext, timeoutLength * 1000);
			}
		}

		function showDetails() {
			$('#hero-details').empty().append(details[currentIndex].clone(true, true)).fadeIn(150);
		}

		function goNext() {
			var nextIndex = (currentIndex + 1) % numItems;
			heroNavigate(nextIndex);
		}

		$(window).bind('FancyBox.open', function(){
			clearTimeout(timeoutRef);
		});

		$(window).bind('FancyBox.close', function(){
			timeoutRef = setTimeout(goNext, timeoutLength * 1000);
		});

	});

	//ENVIRONMENTAL REPORT SEARCH BUTTON
	var page = '';
	$('#environmental-report-search-button').click(function(event) {
		openBlueElement('environmental-report');
	});

	//PROJECT SEARCH BUTTON
	var page = '';
	$('#project-search-button, #news-search-button').click(function(event) {
		if ($(this).attr('id') == 'project-search-button') {
			page = 'project';
		} else {
			page = 'news';
		}
		openBlueElement(page);
	});

	$(document).click(function(event) {
		if (!$(this).parents().is('#bluebar')) {
			closeBlueElement(page);
		}
	});

	$('#bluebar').click(function(event) {
		event.stopPropagation();
	});

	var type = '';
	function openBlueElement(type) {
		$('#bluebar').height($('#bluebar').height());
		$('#container').removeClass('blueElement-smallBlue').addClass('blueElement-'+type+'-search-large');
		$('#'+type+'-search-button').fadeOut(500, function(){
			$('#bluebar').animate({height: 321}, 500, function(){
				$('#bluebar-content').fadeIn(500);
				$('#bluebar-content').children(':not(script)').filter(function(data, ele){
					if ($(ele).attr('id') != type+'-search-button') {
						$(ele).fadeIn(500);
					} else {
						$(ele).hide();
					}
				});
			});
		});
	}

	function closeBlueElement(type) {

		var elements = $('.blueElement-'+type+'-search-large #bluebar-content').children(':not(script)').filter(function(data, ele){
			if ($(ele).attr('id') != type+'-search-button') {
				return true;
			}
		});

		$('.blueElement-'+type+'-search-large #bluebar-content').fadeOut(500, function() {
			elements.hide();
			$('#bluebar').animate({height: 71}, 500, function() {
				$('#container').removeClass('blueElement-'+type+'-search-large').addClass('blueElement-smallBlue');
				$('#bluebar-content').show();
				$('#'+type+'-search-button').fadeIn(500);
			});
		});

	}

	var height = 0;
	$('.latest-project-column').each(function() {
		if ($(this).height() > height) {
			height = $(this).height();
		}
	});

	$('.latest-project-column').height(height);
	$('#sub-item-nav .project-small-item:last-child').css({'margin-bottom': 0});

	//Small Projects Margin
	$('.project-small-item:odd').css({'margin-right': 0});

	// MULTIMEDIA PLAYER
	$('#multimedia-video').each(function(){
		var data = $('param', this).metadata({type:'attr', name:'value'});
		var player = 'player.swf';
		if (swfobject.getFlashPlayerVersion().major < 10) {
			player = 'playerv9.swf';
		} else {
			data.skin = '/swf/thiess_videoskin.zip';
			data.controlbar = 'over';
		}
		swfobject.embedSWF('/swf/'+player, this.id, 600, 338, '9.0.115', null, data, {id:this.id}, null, hasFlash);
	});


	var noflash = false;
	function hasFlash(e) {
		if (e.success == false || e == false) {
			$('.video-container').hide();
			$('.no-flash-bluebar').show();
			noflash = true;
		}
	}

	// MULTIMEDIA SCROLLER
	$('#multimedia-right').each(function(){
		var itemHeight =  $('.video-list LI:first').outerHeight();
		var $videoList = $('.video-list', this);

		$('a', $videoList).not('.readmore').click(function(){
			var data = $(this).parents('LI:first').find('param').metadata({type:'attr', name:'value'});
			$('#multimedia-left .title').html(data.title);
			if (noflash == false) {
				$('#multimedia-video').get(0).sendEvent('LOAD', data.video);
			} else {
				$('.no-flash-bluebar').css({'background-image': 'url('+data.background+')'});
			}
			return false;
		});

		if ($videoList.children().length < 4) {
			$('#multimedia-down, #multimedia-up').addClass('disabled').click(function(){
				return false;
			});
			return;
		}
		$('#multimedia-down', this).click(function(){
			var scroll = Math.min($.scrollTo.max($videoList.get(0), 'y'), $videoList.scrollTop() + (itemHeight * 3));
			$videoList.scrollTo(scroll+'px', {easing:'easeOutQuart', duration:1200});
			return false;
		});
		$('#multimedia-up', this).click(function(){
			var scroll = Math.max(0, $videoList.scrollTop() - (itemHeight * 3));
			$videoList.scrollTo(scroll+'px', {easing:'easeOutQuart', duration:1200});
			return false;
		});
	});

	//Do FAQ's
	$('.is-faq p.faq-question').each(function() {
		$(this).wrapInner('<div></div>');
	});

	$('.is-faq p.faq-question').append('<span>').click(function(){
		expandAnswer(this);
	}).each(function(){
		$(this).nextUntil('.faq-question, h2').wrapAll('<div class="faq-answer"></div>');
	})

	$('.faq-answer').each(function() {
		$(this).find('p:first').prepend('<span class="intro">A:</span>');
	})

	function expandAnswer(obj) {
		if ($(obj).next('.faq-answer').is(':visible')) {
			$(obj).removeClass('visible-faq');
			$(obj).next('.faq-answer').slideUp();
		} else {
			$(obj).addClass('visible-faq');
			$(obj).next('.faq-answer').slideDown();
		}
	}

	//ENEWS
	$('.news #enews').click(function() {
		$('#enews-signup').slideDown(500);
		$('#multimedia-panel').fadeOut();
		return false;
	});

	if ($('#enews-signup').has('.error').length) {
		$('#enews-signup').show();
		$('#multimedia-panel').hide();
	}

	if ($(location).attr('hash') == '#enews') {
		$('#enews').trigger('click');
	}

	if ($('.enews-thankyou').is(':visible')) {
		$('#multimedia-panel').hide();
	}

	$('.enews-thankyou').delay(5000).fadeOut(500, function() {
		$('#multimedia-panel').fadeIn();
	});

	$('#enews-signup .close').click(function() {
		$('#enews-signup').slideUp(500);
		$('#multimedia-panel').fadeIn();
		return false;
	});


	//HANDLE JOB FORMATTING
	$('#careers-applicant-login .password input').one('focus', function() {
		$(this).before($(this).clone().attr('type', 'password')).remove();
	});

	if ($('#job-details').length > 0) {
		$('p, h1, h2, h3, h4, span').each(function(data) {
			if ($(this).html() == '&nbsp;') {
				$(this).remove();
			}
		});
	}

	$('#job-details p').filter(function() {
		return ($.trim($(this).text()) === '' && !$(this).has('img').length);
	}).remove();

	$(window).load(function() {
		$('#job-details .featureImage').show();
		if ($('#job-details .featureImage').length) {

			var img = $('#job-details .featureImage:eq(1)');
			if (img) {
				var src = $('img', img).attr('src');
				if (src != undefined && src.match(/12217_GO_SeekFooter_ex|Thies-\(with-logos\)/)) {
					$('#job-details .featureImage:eq(1)').css({float: 'none'});
				} else {
					$('#job-details .featureImage:gt(0)').remove();
				}
			}

			if ($('#job-details .featureImage:first img').width() > 150) { 
				//Air port link fix
				if ($('#job-details .featureImage:first img').attr('src').match('Airport_Link_Logo_medium.JPG')) {
					firstelement = $('#job-details .featureImage:first img').parent();
					$('#job-details').prepend(firstelement);
					$(firstelement).css({'float': 'none'});
				} else {
					//If the job advertised 
					$('#job-details .featureImage:first').css({float: 'none'});
				}

			}
		}

	});

	$('.featureImage img').each(function() {
		if ($(this).attr('src').match('ThiessFooter_large.jpg')) {
			$(this).parent().remove();
		}
	});

	$('#job-details p').each(function() {
		if ($(this).html() == '&nbsp;' && $(this).next().get(0).nodeName == 'P') {
			$(this).remove();
		}
	});

	$('#anchor-links a').hover(function() {
		rollOverSource = $(this).next('img.inline-left-hover').attr('src');
		activeSource = $(this).find('img').attr('src');
		$(this).find('img').attr('src', rollOverSource);
		$(this).next('img.inline-left-hover').attr('src', activeSource);
	}, function() {
		activeSource = $(this).next('img.inline-left-hover').attr('src');
		rollOverSource = $(this).find('img').attr('src');
		$(this).find('img').attr('src', activeSource);
		$(this).next('img.inline-left-hover').attr('src', rollOverSource);
	});

	$('#ProjectSearchSector').change(function() {
		$('#ProjectSearchCapability').find('optgroup').hide();
		$('#ProjectSearchCapability').find('optgroup[label="'+$(this).find(':selected').text()+'"]').show();
	});

	$('.tiles .sub-item:nth-child(4n)').css({'margin-right': 0});

	$.fn.preload = function() {
		this.each(function(){
			$('<img/>')[0].src = this;
		});
	}

	$('#SupplierRegisterForm .select-multi fieldset:first').before('<div style="width: 100%;height: 20px;" class="checkBreak"></div>');
	$('legend:contains("NSW"), legend:contains("SA")').parent().wrapAll('<div id="1"></div>');
	$('legend:contains("QLD"), legend:contains("TAS")').parent().wrapAll('<div id="2"></div>');
	$('legend:contains("VIC"), legend:contains("NT"), legend:contains("ACT")').parent().wrapAll('<div id="3"></div>');
	$('legend:contains("WA"), legend:contains("Other")').parent().wrapAll('<div id="4"></div>');

	$('#SupplierRegisterForm .select-multi fieldset').each(function() {
		input = '<div class="all-select"><input type="checkbox" name="'+$(this).find('legend').text()+'" /></div>';
		$(this).find('legend:first').before(input);
		$(this).find('.all-select input[type="checkbox"]').click(function() {
			if ($(this).attr('checked') === true) {
				state = 'checked';
			} else {
				state = '';
			}

			$(this).parents('fieldset').find('.checkbox input[type="checkbox"]').attr('checked', state);
		})
	});

	$('#SupplierRegisterForm #2').insertBefore($('#SupplierRegisterForm #3'));
	$('#SupplierRegisterForm #1').insertBefore($('#SupplierRegisterForm #3'));

});

$(function() {
	//Back button for thiess careers
	if ($('#careers-back').length && window.location.search.length) {
		$('#careers-back').attr('href', $('#careers-back').attr('href') + window.location.search);
	}

	//ck editor clears clears in janitor
	$('hr.hr').before('<div class="clear"></div>');
	$('hr').each(function() {
		$(this).before('<div class="hr"></div>');
		$(this).remove();
	});

	//Restrict text width to match parent if class found
	if ($('.featureImage .restrictWidth').length) {
		width = $('.featureImage .restrictWidth').eq(0).width();
		if (width > 200) {
			$('#job-details').width(width);
			$('#job-details p').not('.label, .labelText').css({'margin-right': 0});
		}
	}

});

$(function() {
	height = 23 - ($('.left-hand-grey-banner img, .large-grey-banner img, , .small-grey-banner img').height() / 2);
	$('.left-hand-grey-banner img, .large-grey-banner img, .small-grey-banner img').css({'margin-top': height});
})

if (navigator.userAgent.match(/(ipad|iphone)/gi)) {
	date = Math.random();
	$('HEAD').append('<link rel="stylesheet" href="/css/safarimobile.css?'+date+'" type="text/css" />')
	$(function() {
		$('#hero-container').wrap('<div id="ipad-wrap"></div>');
		$('#ipad-wrap').append('<div id="hero-bt2"></div><div id="hero-bl2"></div>');
	})
}