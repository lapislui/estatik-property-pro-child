(function ($) {
	function requestModalHtml(data, callback) {
		$.post(ERA_EstatikPayments.ajaxurl, {
			action: 'era_get_estatik_payment_modal',
			request_id: parseInt(data.requestId, 10) || 0,
			property_id: parseInt(data.propertyId, 10) || 0,
			nonce: ERA_EstatikPayments.nonce
		})
			.done(function (response) {
				var html = response && response.success && response.data && response.data.html
					? response.data.html
					: '<div class="era-estatik-payments-state">Unable to load payment details.</div>';
				callback(html);
			})
			.fail(function () {
				callback('<div class="era-estatik-payments-state">Unable to load payment details.</div>');
			});
	}

	function resizeAdminPopup() {
		var modal = $('#TB_ajaxContent .era-estatik-payment-modal');
		var windowEl = $('#TB_window');
		var contentEl = $('#TB_ajaxContent');
		var width = Math.min($(window).width() - 80, 1000);
		var height = modal.length ? Math.ceil(modal.outerHeight(true)) + 30 : 360;
		var maxHeight = Math.max($(window).height() - 80, 320);
		var finalHeight = Math.min(height, maxHeight);
		var top = Math.max(Math.round(($(window).height() - finalHeight) / 2), 30);

		windowEl.css({ width: width + 'px', marginLeft: '-' + Math.round(width / 2) + 'px', height: finalHeight + 'px', top: top + 'px', marginTop: '0' });
		contentEl.css({ width: width + 'px', height: (finalHeight - 30) + 'px', overflowY: height > maxHeight ? 'auto' : 'hidden' });
	}

	function openAdminModal(data) {
		var content;
		tb_show('', '#TB_inline?inlineId=era-estatik-payments-modal-shell&width=920&height=420');
		content = $('#TB_ajaxContent').find('.era-estatik-payments-modal-shell__content');
		if (!content.length) {
			content = $('#era-estatik-payments-modal-shell').find('.era-estatik-payments-modal-shell__content');
		}

		content.html('<div class="era-estatik-payments-modal-shell__loading">Loading payment details...</div>');
		resizeAdminPopup();
		requestModalHtml(data, function (html) {
			content.html(html);
			setTimeout(resizeAdminPopup, 0);
		});
	}

	function openFrontModal(data) {
		var modal = $('#era-estatik-front-payments-modal');
		modal.find('.era-estatik-front-payments-modal__body').html('<div class="era-estatik-payments-state">Loading payment details...</div>');
		modal.addClass('is-visible');
		$('body').addClass('era-estatik-front-payments-open');
		requestModalHtml(data, function (html) {
			modal.find('.era-estatik-front-payments-modal__body').html(html);
		});
	}

	function closeFrontModal() {
		$('#era-estatik-front-payments-modal').removeClass('is-visible');
		$('body').removeClass('era-estatik-front-payments-open');
	}

	$(document).on('click', '.js-era-estatik-payments-view, .js-era-estatik-front-payments-view', function (e) {
		var data = {
			requestId: $(this).data('request-id'),
			propertyId: $(this).data('property-id')
		};

		e.preventDefault();

		if ($(this).hasClass('js-era-estatik-front-payments-view')) {
			openFrontModal(data);
			return;
		}

		openAdminModal(data);
	});

	$(document).on('click', '.js-era-estatik-front-payments-close, .era-estatik-front-payments-modal__overlay', function (e) {
		e.preventDefault();
		closeFrontModal();
	});

	$(window).on('resize', function () {
		if ($('#TB_window:visible').length && $('#TB_ajaxContent .era-estatik-payment-modal').length) {
			resizeAdminPopup();
		}
	});
})(jQuery);
