(function () {
   'use strict';
	function alertBoxes() {

		jQuery(window).load(function() {
			var alertBox = jQuery('#alert');
			if(alertBox.length > 0 ){
				jQuery('html, body').animate({
					scrollTop: alertBox.offset().top - 50
				}, 1200);
				alertBox.delay(12000).fadeOut(1200);
			}
		});
	}
	function closeNotifications(){
		jQuery(window).load(function() {
			var alertBox = jQuery('.woocommerce-error, .woocommerce-message, .woocommerce-info');
			if(alertBox.length > 0 ){
				alertBox.prepend('<a href="#close-alert-box" class="close-alert-box">&times;</span>');
				jQuery('.close-alert-box').on('click', function(){
					jQuery(this).parent().fadeOut(600);
					return false;
				});
			}
		});

	}
	function magicLineMenu() {

		var $el, leftPos, newWidth,
			$mainNav = jQuery("#menu-main-menu");

		jQuery( "#magic-line" ).remove();

		$mainNav.append("<span id='magic-line'></span>");
		var $magicLine = jQuery("#magic-line");

		if($mainNav.length > 0 && jQuery("#menu-main-menu > .current-page-ancestor").length > 0){
			jQuery("#menu-main-menu > .current-page-ancestor").addClass('current-menu-item');
		}

		if($mainNav.length > 0 && jQuery("#menu-main-menu > .current-menu-item").length > 0){

			var $cmi = jQuery("#menu-main-menu .current-menu-item");
			var paddingleft = $cmi.css("padding-left").replace("px", ""),
			positionleft = $cmi.position().left;

			$magicLine
				.width(jQuery("#menu-main-menu > .current-menu-item").width())
				.css("left", (positionleft + parseInt(paddingleft)))
				.data("origLeft", $magicLine.position().left)
				.data("origWidth", $magicLine.width());

			jQuery("#menu-main-menu > li").hover(function() {
				$el = jQuery(this).children('a');
				leftPos = jQuery(this).position().left + parseInt(jQuery(this).css("padding-left").replace("px", ""));
				newWidth = $el.parent().width();
				$magicLine.stop().animate({
					left: leftPos,
					width: newWidth
				});
			}, function() {
				$magicLine.stop().animate({
					left: $magicLine.data("origLeft"),
					width: $magicLine.data("origWidth")
				});
			});

		}else{
			$magicLine.addClass('no-parrent');


			jQuery("#menu-main-menu > li").hover(function() {
				$el = jQuery(this).children('a');
				leftPos = jQuery(this).position().left + parseInt(jQuery(this).css("padding-left").replace("px", ""));
				newWidth = $el.parent().width();
				$magicLine.stop().animate({
					opacity: 1,
					left: leftPos,
					width: newWidth
				});
			}, function() {
				$magicLine.stop().animate({
					opacity: 0,
					left: 0,
					width: 0
				});
			});
		}
	}
	function blockNewsSlider(){
		var newsSlider = jQuery('.block-news-slider');
		if(newsSlider.length > 0){
			newsSlider.bxSlider({
				auto: true,
				pager: false,
				mode: 'fade',
			});
		}
	}
	function blockLogoSlider(){
		var logoSlider = jQuery('.block-logo-slider');
		if(logoSlider.length > 0){
			logoSlider.bxSlider({
				auto: true,
				minSlides: 3,
				maxSlides: 10,
				slideWidth: 130,
				slideMargin: 10,
				moveSlides: 1,
				pager: false,
			});
		}
	}
	function teamGrid(){
		var $grid = jQuery('.team-member-list'),
			$filterOptions = jQuery('.filter-options');

		$grid.shuffle({
			itemSelector: '.team-member-list-item',
			gutterWidth: 26,
			columnWidth: 220,
			speed: 500,
		});

		var $btns = $filterOptions.children();
		$btns.on('click', function() {
			var $this = jQuery(this),
			isActive = $this.hasClass( 'active' ),
			group = isActive ? 'all' : $this.data('group');

			// Hide current label, show current label in title
			if ( !isActive ) {
				jQuery('.filter-options .active').removeClass('active');
			}

			$this.toggleClass('active');

			if( isActive ){
				jQuery('.filter-options .filter-all').addClass('active');
			}

			// Filter elements
			$grid.shuffle( 'shuffle', group );

			return false;

		});

		$btns = null;
	}
	function cookiesPolicy(){
		jQuery('.cookie-notice-close').on('click', function(){
			jQuery.cookie('shortscookieenable', '1', { expires: 365, path: '/' });
			jQuery('.block-cookie-policy').slideUp(400);
			return false;
		});
		if(jQuery.cookie('shortscookieenable') === null ){
			jQuery('.block-cookie-policy').slideDown(400);
		}
	}
	function sidebarToggleMenu() {
		var cat_link = jQuery('.widget_product_categories li.cat-parent > a'),
			cat_parent = jQuery('.widget_product_categories li.cat-parent');
		cat_link.append('<span href="#" class="cat-toggle-trigger">&nbsp;</span>');

		cat_parent.each(function() {
			if(jQuery( this ).hasClass('current-cat-parent') || jQuery( this ).hasClass('current-cat')){
				jQuery( this ).addClass('trigger-open');
			}
		});

		var cat_trigger = cat_link.children('.cat-toggle-trigger');

		cat_trigger.on('click', function(){
			jQuery(this).closest('li').children('ul.children').stop().slideToggle();
			if(jQuery(this).closest('li').hasClass('trigger-open')){
				jQuery(this).closest('li').removeClass('trigger-open');
			}else{
				jQuery(this).closest('li').addClass('trigger-open');
			}
			return false;
		});
	}
	function sidebarToggleLayerNav() {

			var widget = jQuery('.widget_layered_nav');
			var widgetTitleLink = jQuery('.widgettitle > a');
			// Hack for opening all of them at the begining
			widget.find('.widgettitle').addClass('trigger-open');
			widget.find('ul').show();
			// End of hack

			widgetTitleLink.on('click', function(){

				var widgetTitle = jQuery(this).closest('.widgettitle');
				var widgetLinks = jQuery(this).closest('.widget_layered_nav').find('ul');

				widgetLinks.stop().slideToggle();
				if(widgetTitle.hasClass('trigger-open')){
					widgetTitle.removeClass('trigger-open');
				}else{
					widgetTitle.addClass('trigger-open');
				}
				return false;
			});
	}
	function readMoreCatalogDescription(){
		var desc = jQuery('.term-description'),
			parapgraphs = desc.children('p'),
			boundary = parapgraphs.eq(1),
			pcount = parapgraphs.length;

		if(pcount > 1){
			jQuery('<div class="term-description-hidden">').insertAfter(boundary).append(boundary.nextAll().andSelf());
			desc.append('<a href="#" class="term-description-more">Read More</a>');
			//parapgraphs.first().after('<a href="#" class="term-description-more">Read More</a>');
			var desc_trigger 	= jQuery('.term-description-more'),
				desc_cont 		= jQuery('.term-description-hidden');
			desc_trigger.on('click', function(){
				jQuery(this).toggleClass('trigger-open');
				if(jQuery(this).hasClass('trigger-open')){
					jQuery(this).text('Hide');
				}else{
					jQuery(this).text('Read More');
				}
				desc_cont.stop().toggle();
				return false;
			});

		}
	}
	function createAccountForm(){
		var button = jQuery('a.create-account-button'),
			customSelect = jQuery('select');

		button.on('click', function(){
			jQuery('.create-account-button-container').hide();
			jQuery('.create-account-register-form').fadeIn();
			customSelect.customSelect();
			return false;
		});

		var shipping_cont = jQuery('.create-account-register-form .register-shipping'),
			shipping_box = jQuery('#sameasbilling');

			if(shipping_box.is(':checked')){
				shipping_cont.hide();
			}else{
				shipping_cont.show();
				customSelect.trigger('render');
			}
			shipping_box.change(function() {
				if(jQuery(this).is(':checked')){
					shipping_cont.fadeOut();
				}else{
					shipping_cont.fadeIn();
					customSelect.trigger('render');
				}
			});
	}
	function assistedSearch(){
		var a = jQuery('#lift-spares-assisted-search'),
			b = a.find('input[type=submit]'),
			i = "";

		if(a.length > 0){

			var c = a.find('select[name=filter_manufacturer]'),
				d = a.find('select[name=filter_product-group]'),
				e = a.find('select[name=filter_product-category]');


			c.on('change', function(){
				var cthis = jQuery(this).find(':selected');
				if(cthis.val().length > 0){
					var cattr = cthis.attr('data-product-group');
					if(cattr.length > 0){
						d.prop('disabled', false);
						d.find('option[value=""]').text('Select a category');
						var arr = cattr.split(' ');
						for (i = 0; i < arr.length; i++) {
							d.find('option[value="'+arr[i]+'"]').removeClass('hidden');
						}
					}
				}else{
					d.find('option[value=""]').text('Please select a manufacturer first').prop("selected", true);
					d.find('option[value!=""]').addClass('hidden').prop("selected", false);
					e.find('option[value=""]').text('Please select a category first').prop("selected", true);
					e.find('option[value!=""]').addClass('hidden').prop("selected", false);
					d.prop('disabled', true);
					e.prop('disabled', true);
				}
				d.trigger('render');
				e.trigger('render');
			});

			d.on('change', function(){

				var dthis = jQuery(this).find(':selected');
				if(dthis.val().length > 0){
					var dattr = dthis.attr('data-product-category');
					if(dattr.length > 0){
						e.prop('disabled', false);
						e.find('option[value=""]').text('Select a sub category');
						var arr = dattr.split(' ');
						for (i = 0; i < arr.length; i++) {
							e.find('option[value="'+arr[i]+'"]').removeClass('hidden');
						}
					}
				}else{
					e.find('option[value=""]').text('Please select a category first').prop("selected", true);
					e.find('option[value!=""]').addClass('hidden').prop("selected", false);
					e.prop('disabled', true);
				}
				e.trigger('render');
			});

			if(c.val().length > 0){
				var cthis = c.find(':selected');
				var cattr = cthis.attr('data-product-group');
				if(cattr.length > 0){
					d.prop('disabled', false);
					d.find('option[value=""]').text('Select a category');
					var carr = cattr.split(' ');
					for (i = 0; i < carr.length; i++) {
						d.find('option[value="'+carr[i]+'"]').removeClass('hidden');
					}
				}
				d.trigger('render');
				e.trigger('render');
			}

			if(d.val().length > 0){
				var dthis = d.find(':selected');
				var dattr = dthis.attr('data-product-category');
				if(dattr.length > 0){
					e.prop('disabled', false);
					e.find('option[value=""]').text('Select a sub category');
					var darr = dattr.split(' ');
					for (i = 0; i < darr.length; i++) {
						e.find('option[value="'+darr[i]+'"]').removeClass('hidden');
					}
				}
				e.trigger('render');
			}

			if(e.val().length > 0){
			}

			b.on('click', function(){
				var f = a.find('select[name=filter_manufacturer]').val();
				if(f.length > 0) {
					return true;
				}
				return true;
			});
		}
	}
	function validateEmail(sEmail) {
		var filter = /^[\w-.+]+@[a-zA-Z0-9.-]+.[a-zA-z0-9]{2,4}$/;
		if (filter.test(sEmail)) {
			return true;
		}
		else {
			return false;
		}
	}
	function validateRegisterForm(){
		var form = jQuery('.create-account-register-form'),
			countrySelect = jQuery('#reg_country'),
			postcode = jQuery('#reg_postcode'),
			button = form.find('.button'),
			required = form.find('input'),
			requiredmatch1 = form.find('input.required-match-1'),
			requiredmatch2 = form.find('input.required-match-2');

		if(countrySelect.val() === 'IE'){
			postcode.removeClass('required');
			postcode.prev('label').find('.required').remove();
			postcode.next('small.red').remove();
		}

		countrySelect.on('change', function() {
			var country = this.value;

			postcode.removeClass('input-field-error');
			if(country === 'IE'){
				if(postcode.hasClass('required')){
					postcode.removeClass('required');
					postcode.prev('label').find('.required').remove();
					postcode.next('small.red').remove();
				}
			}else{
				if(!postcode.hasClass('required')){
					postcode.addClass('required');
					postcode.prev('label').append('<abbr class="required" title="required">*</abbr>');
				}
			}

		});

		required.each(function(){
			jQuery(this).focusout(function() {
				if(jQuery(this).hasClass('required')){
					var value = jQuery(this).val();
					jQuery(this).siblings('small.red').remove();
					if(value.length > 0 ){
						jQuery(this).removeClass('input-field-error');
						if(jQuery(this).hasClass('input-email')){
							if (validateEmail(value)) {
								jQuery(this).removeClass('input-field-error');

								if(jQuery(this).hasClass('required-match-1')){
									requiredmatch1.removeClass('input-field-error');
									requiredmatch1.next('small.red').remove();
									if(requiredmatch1.eq(0).val() !== requiredmatch1.eq(1).val()){
										requiredmatch1.addClass('input-field-error').after('<small class="red">Your email addresses do not match.</small>');
									}
								}
							}else{
								jQuery(this).addClass('input-field-error').after('<small class="red">The email address isn&#8217;t correct.</small>');
							}
						}
					}else{
						jQuery(this).addClass('input-field-error').after('<small class="red">This field is required.</small>');
					}
				}

				if(jQuery(this).hasClass('required-match-2')){
					requiredmatch2.next('small.red').remove();
					requiredmatch2.removeClass('input-field-error');
					if(requiredmatch2.eq(0).val() !== requiredmatch2.eq(1).val()){
						requiredmatch2.addClass('input-field-error').after('<small class="red">Your passwords do not match.</small>');
					}
				}
			});
			jQuery(this).keyup(function() {
				if(jQuery(this).hasClass('required-match-2')){
					requiredmatch2.next('small.red').remove();
					requiredmatch2.removeClass('input-field-error');
					if(requiredmatch2.eq(0).val() !== requiredmatch2.eq(1).val()){
						requiredmatch2.addClass('input-field-error').after('<small class="red">Your passwords do not match.</small>');
					}
				}
			});
		});

		button.on('click', function(){
			jQuery('small.red').remove();
			required.each(function(){
				if(jQuery(this).hasClass('required')){
					var value = jQuery(this).val();
					if(value.length > 0 ){
						jQuery(this).removeClass('input-field-error');

						if(jQuery(this).hasClass('input-email')){
							if (validateEmail(value)) {
								jQuery(this).removeClass('input-field-error');
							}
						}
						if(jQuery(this).hasClass('input-checkbox')){
							if(jQuery(this).is(":checked")){
								jQuery(this).removeClass('input-field-error');
							}else{
								jQuery(this).addClass('input-field-error').parent().append('<small class="red">Please review and accept our Online Account Terms and Conditions.</small>');
							}
						}
					}else{
						jQuery(this).addClass('input-field-error').after('<small class="red">This field is required.</small>');
					}
				}
			});

			if(requiredmatch1.eq(0).val() !== requiredmatch1.eq(1).val()){
				requiredmatch1.addClass('input-field-error').after('<small class="red">Your email addresses do not match.</small>');
			}

			if(requiredmatch2.eq(0).val() !== requiredmatch2.eq(1).val()){
				requiredmatch2.addClass('input-field-error').after('<small class="red">Your passwords do not match.</small>');
			}

			var sameasbilling = jQuery('input[name=sameasbilling]');

			if(sameasbilling.is(':checked')){
				jQuery('.register-shipping .required').removeClass('input-field-error').next('small.red').remove();
			}

			if(form.find('.input-field-error').length > 0){
				jQuery('html, body').animate({
					scrollTop: jQuery(".input-field-error").first().offset().top - 25
				}, 1000);
				return false;
			}
		});
	}
	function checkoutSteps(){
		var stepsBar = jQuery('.checkout-bar-steps');

		if(stepsBar.length > 0){

			var steps = stepsBar.find('a.checkout-bar-step'),
				tabs = jQuery('.checkout-step-tab');

			var currentStep	= jQuery('.checkout-step-tab.current');
			var required 	= currentStep.find('.validate-required input, .validate-required select');

			var countrySelectBilling = jQuery('#billing_country'),
				postcodeBilling = jQuery('#billing_postcode');

			if(countrySelectBilling.val() === 'IE'){
				postcodeBilling.parent().removeClass('validate-required', 'woocommerce-invalid','woocommerce-invalid-required-field');
				postcodeBilling.next('small.red').remove();
			}

			countrySelectBilling.on('change', function() {
				var country = this.value;

				postcodeBilling.parent().removeClass('woocommerce-invalid','woocommerce-invalid-required-field');
				postcodeBilling.next('small.red').remove();
				postcodeBilling.removeClass('input-field-error');
				if(country === 'IE'){
					if(postcodeBilling.parent().hasClass('validate-required')){
						postcodeBilling.parent().attr('data-o_class', 'form-row form-row-last address-field validate-postcode');
					}
				}else{
					postcodeBilling.parent().attr('data-o_class', 'form-row form-row-last address-field validate-required validate-postcode');
				}
			});


			var countrySelectShipping = jQuery('#shipping_country'),
				postcodeShipping = jQuery('#shipping_postcode');

			if(countrySelectShipping.val() === 'IE'){
				postcodeShipping.parent().removeClass('validate-required', 'woocommerce-invalid','woocommerce-invalid-required-field');
				postcodeShipping.next('small.red').remove();
			}

			countrySelectShipping.on('change', function() {
				var country = this.value;

				postcodeShipping.parent().removeClass('woocommerce-invalid','woocommerce-invalid-required-field');
				postcodeShipping.next('small.red').remove();
				postcodeShipping.removeClass('input-field-error');
				if(country === 'IE'){
					if(postcodeShipping.parent().hasClass('validate-required')){
						postcodeShipping.parent().attr('data-o_class', 'form-row form-row-last address-field validate-postcode');
					}
				}else{
					postcodeShipping.parent().attr('data-o_class', 'form-row form-row-last address-field validate-required validate-postcode');
				}
			});

			required.each(function(){
				jQuery(this).focusout(function() {
					if(jQuery(this).parents('.validate-required').length > 0){
						var value = jQuery(this).val();
						jQuery(this).parent().find('small.red').remove();
						if(value.length > 0 ){
							jQuery(this).removeClass('input-field-error');
							if(jQuery(this).hasClass('input-email')){
								if (validateEmail(value)) {
									jQuery(this).removeClass('input-field-error');
								}else{
									jQuery(this).addClass('input-field-error').after('<small class="red">The email address isn&#8217;t correct.</small>');
								}
							}
						}else{
							jQuery(this).addClass('input-field-error').parent().append('<small class="red">This field is required.</small>');
						}
					}
				});
			});

			steps.on('click', function(e){

				e.preventDefault();
				var step = jQuery(this);

				if(step.hasClass('current') || !step.hasClass('completed') || step.hasClass('disabled')){
					return false;
				}
				var stepLink = step.attr('href');

				var po_number 	= jQuery('input[name=po_number]').val();
				if(po_number.length > 0){
					jQuery('.purchase-order-number-review span').html(po_number);
				}

				steps.removeClass('current');
				steps.removeClass('completed');
				step.addClass('current');
				step.parent().prevAll().find('a.checkout-bar-step').addClass('completed');


				jQuery(tabs).removeClass('current');
				jQuery(stepLink).addClass('current');

				jQuery('select.hasCustomSelect:visible').trigger('render');
				jQuery('select:visible').not( ".hasCustomSelect" ).customSelect();

			});

			jQuery('.change-step').on('click', function(e){
				e.preventDefault();

				var currentStep	= jQuery('.checkout-step-tab.current');
				var required 	= currentStep.find('.validate-required input, .validate-required select');
				var po_number 	= jQuery('input[name=po_number]').val();
				if(po_number.length > 0){
					//jQuery('.purchase-order-number-review span').html(po_number);
				}
				currentStep.find('.input-field-error').removeClass('input-field-error');
				required.each(function(){
					var value = jQuery(this).val();
					jQuery(this).parent().find('small.red').remove();
					if(value.length > 0 ){
						jQuery(this).removeClass('input-field-error');
						if(jQuery(this).hasClass('input-email')){
							if (validateEmail(value)) {
								jQuery(this).removeClass('input-field-error');
							}else{
								jQuery(this).addClass('input-field-error').after('<small class="red">The email address isn&#8217;t correct.</small>');
							}
						}
					}else{
						jQuery(this).addClass('input-field-error').parent().append('<small class="red">This field is required.</small>');
					}
				});

				if(currentStep.find('.input-field-error').length > 0){
					jQuery('html, body').animate({
						scrollTop: jQuery(".input-field-error").first().offset().top - 25
					}, 1000);
					return false;
				}
				var stepLink = jQuery(this).attr('href');

				var step = stepsBar.find('a.checkout-bar-step[href="'+stepLink+'"]');
				steps.removeClass('current');
				steps.removeClass('completed');
				step.addClass('current');
				step.parent().prevAll().find('a.checkout-bar-step').addClass('completed');

				jQuery(tabs).removeClass('current');
				jQuery(stepLink).addClass('current');


				var shipping = jQuery(stepLink).find('select.check_shipping_method');
				if(shipping.length > 0 ){
					//shipping.prepend("<option value=''>Select Shipping Method</option>").val('');
					shipping.val('');
					jQuery(stepLink).on('click', 'input#place_order', function(){
						if(shipping.val().length < 1 ){
							jQuery('.customSelect.shipping_method.check_shipping_method').addClass('input-field-error');
							shipping.addClass('input-field-error').parent().append('<small class="red">This field is required.</small>');
							return false;
						}
					});
				}
				if(jQuery('input#place_order').length > 0 ){
					jQuery(stepLink).on('click', 'input#place_order', function(){
						if(jQuery('input[name=po_number]').val().length < 1 ){
							jQuery('input[name=po_number]').addClass('input-field-error').parent().append('<small class="red">This field is required.</small>');
							return false;
						}
					});

					jQuery(stepLink).on('focusout', 'input[name=po_number]', function() {
						var value = jQuery(this).val();
						jQuery(this).parent().find('small.red').remove();
						if(value.length > 0 ){
							jQuery(this).removeClass('input-field-error');
						}else{
							jQuery(this).addClass('input-field-error').parent().append('<small class="red">This field is required.</small>');
						}
					});

				}

				jQuery('html, body').animate({
					scrollTop: stepsBar.offset().top
				}, 1000);

				jQuery('select.hasCustomSelect:visible').trigger('render');
				jQuery('select:visible').not( ".hasCustomSelect" ).customSelect();
			});

		}

	}
	function checkoutShippingSameAsBilling(){

		var checkbox = jQuery('#same-as-billing-checkbox');
		checkbox.change(function() {

			var $shipping_country		= jQuery('#shipping_country'),
				$shipping_first_name 	= jQuery('#shipping_first_name'),
				$shipping_last_name 	= jQuery('#shipping_last_name'),
				$shipping_company 		= jQuery('#shipping_company'),
				$shipping_address_1 	= jQuery('#shipping_address_1'),
				$shipping_address_2 	= jQuery('#shipping_address_2'),
				$shipping_city 			= jQuery('#shipping_city'),
				$shipping_state 		= jQuery('#shipping_state'),
				$shipping_postcode 		= jQuery('#shipping_postcode'),
				$shipping_email 		= jQuery('#shipping_email'),
				$shipping_phone 		= jQuery('#shipping_phone');

			var $multipleselect = jQuery('#multiple_customer_shipping_adresses');

			if(this.checked) {

				var billing_country		= jQuery('#billing_country').val(),
					billing_first_name 	= jQuery('#billing_first_name').val(),
					billing_last_name 	= jQuery('#billing_last_name').val(),
					billing_company 	= jQuery('#billing_company').val(),
					billing_address_1 	= jQuery('#billing_address_1').val(),
					billing_address_2 	= jQuery('#billing_address_2').val(),
					billing_city 		= jQuery('#billing_city').val(),
					billing_state 		= jQuery('#billing_state').val(),
					billing_postcode 	= jQuery('#billing_postcode').val(),
					billing_email 		= jQuery('#billing_email').val(),
					billing_phone 		= jQuery('#billing_phone').val();

					$multipleselect.find('option[value="create-new"]').prop("selected", true);
					$multipleselect.trigger('change').trigger('render').prop('disabled', true);

					$shipping_country.find('option[value="'+billing_country+'"]').prop("selected", true).trigger('change');
					$shipping_country.trigger('render').prop('disabled', true);
					$shipping_first_name.val(billing_first_name).prop('disabled', true);
					$shipping_last_name.val(billing_last_name).prop('disabled', true);
					$shipping_company.val(billing_company).prop('disabled', true);
					$shipping_address_1.val(billing_address_1).prop('disabled', true);
					$shipping_address_2.val(billing_address_2).prop('disabled', true);
					$shipping_city.val(billing_city).prop('disabled', true);
					$shipping_state.val(billing_state).prop('disabled', true);
					$shipping_postcode.val(billing_postcode).prop('disabled', true);
					$shipping_email.val(billing_email).prop('disabled', true);
					$shipping_phone.val(billing_phone).prop('disabled', true);



			}else{
					$multipleselect.trigger('change').prop('disabled', false);

					$shipping_country.prop('disabled', false).trigger('change');
					$shipping_first_name.prop('disabled', false);
					$shipping_last_name.prop('disabled', false);
					$shipping_company.prop('disabled', false);
					$shipping_address_1.prop('disabled', false);
					$shipping_address_2.prop('disabled', false);
					$shipping_city.prop('disabled', false);
					$shipping_state.prop('disabled', false);
					$shipping_postcode.prop('disabled', false);
					$shipping_email.prop('disabled', false);
					$shipping_phone.prop('disabled', false);
			}
		});

		var $shipping_country		= jQuery('#shipping_country'),
			$shipping_first_name 	= jQuery('#shipping_first_name'),
			$shipping_last_name 	= jQuery('#shipping_last_name'),
			$shipping_company 		= jQuery('#shipping_company'),
			$shipping_address_1 	= jQuery('#shipping_address_1'),
			$shipping_address_2 	= jQuery('#shipping_address_2'),
			$shipping_city 			= jQuery('#shipping_city'),
			$shipping_state 		= jQuery('#shipping_state'),
			$shipping_postcode 		= jQuery('#shipping_postcode'),
			$shipping_email 		= jQuery('#shipping_email'),
			$shipping_phone 		= jQuery('#shipping_phone');

		jQuery('#place_order').click(function() {
			$shipping_country.prop('disabled', false);
			$shipping_first_name.prop('disabled', false);
			$shipping_last_name.prop('disabled', false);
			$shipping_company.prop('disabled', false);
			$shipping_address_1.prop('disabled', false);
			$shipping_address_2.prop('disabled', false);
			$shipping_city.prop('disabled', false);
			$shipping_state.prop('disabled', false);
			$shipping_postcode.prop('disabled', false);
			$shipping_email.prop('disabled', false);
			$shipping_phone.prop('disabled', false);
		});
	}
	function popupbox(){
		jQuery('.popup').fancybox({
			openEffect	: 'fade',
			closeEffect	: 'fade',
			padding		: 40,
			autoSize	: false,
			width		: 880,
			autoHeight	: true,
			arrows		: false,
			helpers : {
				title : null,
			},
			tpl : {
				closeBtn : '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;">&times;</a>',
			}
		});
	}
	jQuery(document).ready(function() {
		sidebarToggleMenu();
		sidebarToggleLayerNav();
		readMoreCatalogDescription();
		createAccountForm();
		assistedSearch();
		validateRegisterForm();
		checkoutSteps();
		closeNotifications();
		checkoutShippingSameAsBilling();
	});
	jQuery(window).load(function() {

		jQuery(document).ready(function() {

			jQuery('select:visible').customSelect();
			blockNewsSlider();
			blockLogoSlider();
			teamGrid();
			cookiesPolicy();
			magicLineMenu();
			popupbox();

			jQuery('img.black-and-white').hoverizr({});
		});

	});
}());