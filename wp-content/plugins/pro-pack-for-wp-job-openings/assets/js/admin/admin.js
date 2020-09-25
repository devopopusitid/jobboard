/* global awsmJobsAdmin, awsmProJobsAdmin, awsmJobSelectControl */

'use strict';

jQuery(document).ready(function($) {
	var applicationId = $('#awsm-pro-application-id').val();

	/*================ Pro Activation Notice ================*/

	var noticeWrapperSel = '.awsm-pro-activate-notice';
	$(noticeWrapperSel).on('click', '.notice-dismiss', function(e) {
		e.preventDefault();
		var $dismissElem = $(this);
		var $wrapper = $dismissElem.parents(noticeWrapperSel);
		var nonce = $dismissElem.parents(noticeWrapperSel).data('nonce');
		$.ajax({
			url: awsmJobsAdmin.ajaxurl,
			type: 'POST',
			data: {
				nonce: nonce,
				action: 'awsm_job_pro_admin_notice'
			},
			dataType: 'json'
		}).done(function(response) {
			if (response && response.dismiss) {
				$wrapper.fadeTo(400, 0, function() {
					$wrapper.slideUp(100, function() {
						$wrapper.remove();
					});
				});
			}
		});
	});


	/*================ Applicant Mail Meta Tabs ================*/

	$('.awsm-applicant-meta-mail-container').on('click', '.awsm-jobs-applicant-mail-header', function() {
		$(this).parent().toggleClass('open');
	});

	$('ul.awsm-applicant-meta-mail-tabs a').on('click', function(e) {
		e.preventDefault();
		var $currentTab = $(this);
		if (! $currentTab.closest('li').hasClass('tabs')) {
			var tabPanelId = $currentTab.attr('href');
			$('ul.awsm-applicant-meta-mail-tabs li').removeClass('tabs');
			$currentTab.closest('li').addClass('tabs');
			$('.awsm-applicant-meta-mail-tabs-panel').hide();
			$(tabPanelId).fadeIn();
		}
	});

	/*================ Form Builder ================*/

	var $fbOptionsWrapper = $('#awsm-builder-form-options-container');
	var tmplTagfieldRegEx = new RegExp('^([a-z0-9]+(-|_))*[a-z0-9]+$');

	$('#awsm-jobs-form-builder').sortable({
		items: '.awsm-jobs-form-element-main',
		axis: 'y',
		handle: '.awsm-jobs-form-element-head',
		cursor: 'grabbing'
	});

	$fbOptionsWrapper.on('click', '.awsm-jobs-form-element-head-title', function() {
		$(this).parents('.awsm-jobs-form-element-main').toggleClass('open');
	});

	$fbOptionsWrapper.on('click', '.awsm-jobs-form-element-close', function() {
		$(this).parents('.awsm-jobs-form-element-main').removeClass('open');
	});

	$fbOptionsWrapper.parents('#settings-awsm-settings-form').find('form').on('submit', function(e) {
		if ($fbOptionsWrapper.is(':visible')) {
			$('.awsm-jobs-error-container').remove();
			var uniqueFields = { resume: [], photo: [] };
			$('.awsm-builder-field-select-control').each(function(index) {
				var fieldType = $(this).val();
				if (fieldType === 'resume' || fieldType === 'photo') {
					uniqueFields[fieldType].push(index);
				}
			});
			var errorTemplate = wp.template('awsm-pro-fb-error');
			if (uniqueFields.resume.length > 1 || uniqueFields.photo.length > 1) {
				e.preventDefault();
				var error = '';
				if (uniqueFields.resume.length > 1) {
					error += errorTemplate({isFieldType: true, fieldType: 'resume'});
				}
				if (uniqueFields.photo.length > 1) {
					error += errorTemplate({isFieldType: true, fieldType: 'photo'});
				}
				$('.awsm-jobs-form-builder-footer').append(error);
			}

			var isValid = true;
			$('.awsm-jobs-form-builder-template-tag').each(function() {
				var tmplKey = $(this).val();
				if (tmplKey.length > 0 && ! tmplTagfieldRegEx.test(tmplKey)) {
					isValid = false;
				}
			});

			if (! isValid) {
				e.preventDefault();
				var templateData = {invalidKey: true};
				$fbOptionsWrapper.find('.awsm-jobs-form-builder-footer').append(errorTemplate(templateData));
			}
		}
	});

	$fbOptionsWrapper.on(
		'click',
		'.awsm-add-form-field-row',
		function(e) {
			e.preventDefault();
			var $wrapper = $('#awsm-jobs-form-builder');
			var next = $wrapper.data('next');
			var fbTemplate = wp.template('awsm-pro-fb-settings');
			var templateData = { index: next };
			$wrapper.data('next', next + 1);
			$wrapper.append(fbTemplate(templateData));
			awsmJobSelectControl($('.awsm-builder-field-select-control').last());
		}
	);

	$fbOptionsWrapper.on(
		'change',
		'.awsm-builder-field-select-control',
		function() {
			var $elem = $(this);
			var optionValue = $elem.val();
			var index = $elem.data('index');
			index = typeof index !== 'undefined' ? index : 0;
			var optionsTemplate = null;
			var templateData = {};

			// Handle Form Builder field other options.
			var $target = $elem.parents('.awsm-jobs-form-builder-type-wrapper').find('.awsm-job-fb-options-container');
			if (
				optionValue == 'select' ||
				optionValue == 'checkbox' ||
				optionValue == 'radio'
			) {
				optionsTemplate = wp.template('awsm-pro-fb-field-options');
				templateData = { index: index };
				$target.html(optionsTemplate(templateData));
				$target.removeClass('hidden');
			} else if (
				optionValue == 'file' ||
				optionValue == 'photo' ||
				optionValue == 'resume'
			) {
				optionsTemplate = wp.template('awsm-pro-fb-file-options');
				templateData = { index: index };
				$target.html(optionsTemplate(templateData));
				$target.removeClass('hidden');
			} else {
				$target.html('');
				$target.addClass('hidden');
			}

			// Handle Template Tag.
			$target = $elem.parents('.awsm-jobs-form-element-content').find('.awsm-job-fb-template-key');
			if ( optionValue == 'resume' || optionValue == 'photo' || optionValue == 'file' ) {
				$target.html('');
				$target.addClass('hidden');
			} else {
				optionsTemplate = wp.template('awsm-pro-fb-template-tag');
				templateData = { index: index };
				$target.html(optionsTemplate(templateData));
				$target.removeClass('hidden');
			}
		}
	);

	$fbOptionsWrapper.on(
		'click',
		'.awsm-form-field-remove-row',
		function(e) {
			e.preventDefault();
			var $deleteBtn = $(this);
			$deleteBtn.parents('.awsm-jobs-form-element-main').remove();
		}
	);

	$fbOptionsWrapper.on('keyup blur', '.awsm_jobs_form_builder_label', function() {
		var $element = $(this);
		var title = $element.val();
		var $row = $element.parents('.awsm-jobs-form-element-content');
		if (title.length > 0) {
			title = $.trim(title).replace(/\s+/g, '-').toLowerCase();
			if (tmplTagfieldRegEx.test(title)) {
				$row.find('.awsm-jobs-form-builder-template-tag').val(title);
			}
		}
	});

	/*================ Mail Handling ================*/

	var $msgContainer = $('.awsm-applicant-mail-message');
	var successClass = 'awsm-success-message';
	var errorClass = 'awsm-error-message';

	$('#awsm_mail_meta_applicant_template').on('change', function() {
		var templateKey = $(this).val();
		if (typeof templateKey !== 'undefined' && templateKey.length > 0) {
			$msgContainer.hide();
			var wpData = [
				{name: 'awsm_application_id', value: applicationId},
				{name: 'awsm_template_key', value: templateKey},
				{name: 'action', value: 'awsm_job_et_data'}
			];
			$.ajax({
				url: awsmJobsAdmin.ajaxurl,
				type: 'GET',
				data: $.param(wpData),
				dataType: 'json'
			}).done(function(data) {
				if (data) {
					$('#awsm_mail_meta_applicant_subject').val(data.subject);
					$('#awsm_mail_meta_applicant_content').html(data.content);
				}
			});
		}
	});

	$('#awsm-applicant-meta-new-mail').on('click', '#awsm_applicant_mail_btn', function(e) {
		e.preventDefault();
		$('.awsm-applicant-mail-req-field').prop('required', true);
		$('#publish').on('click', function() {
			$('.awsm-applicant-mail-req-field').removeProp('required');
		});
		$('.awsm-applicant-mail-req-field').valid();
		var $errorFields = $('.awsm-form-control.error');
		if ($errorFields.length === 0) {
			$msgContainer
			.removeClass(successClass + ' ' + errorClass)
			.hide();
			var fieldSelector = '.awsm-applicant-mail-field';
			var $submitBtn = $(this);
			var submitBtnText = $submitBtn.text();
			var submitBtnResText = $submitBtn.data('responseText');
			$submitBtn.prop('disabled', true).text(submitBtnResText);
			var wpData = $('#awsm-applicant-meta-new-mail')
				.find(fieldSelector)
				.serializeArray();
			wpData.push(
				{name: 'nonce', value: awsmProJobsAdmin.nonce},
				{name: 'awsm_application_id', value: applicationId},
				{name: 'action', value: 'awsm_applicant_mail'}
			);
			$.ajax({
				url: awsmJobsAdmin.ajaxurl,
				type: 'POST',
				data: $.param(wpData),
				dataType: 'json'
			}).done(function(response) {
				if (response) {
					var className = 'awsm-default-message';
					var msg = '';
					var msgArray = [];
					if (response.error.length > 0) {
						className = errorClass;
						msgArray = response.error;
					} else {
						if (response.success.length > 0) {
							$('#awsm_jobs_no_mail_wrapper').remove();
							className = successClass;
							msgArray = response.success;
							$('#awsm_mail_meta_applicant_template').val(null).trigger('change');
							$('#awsm_mail_meta_applicant_subject').val('');
							$('#awsm_mail_meta_applicant_content').val('');
							var mailData = response.content;
							var mailTemplate = wp.template('awsm-pro-applicant-mail');
							var templateData = {
								author: mailData.author,
								'date_i18n': mailData.date_i18n,
								subject: mailData.subject,
								content: mailData.content
							};
							$('#awsm-jobs-applicant-mails-container').prepend(mailTemplate(templateData));
						}
					}
					$(msgArray).each(function(index, value) {
						msg += '<p>' + value + '</p>';
					});
					$msgContainer
						.addClass(className)
						.html(msg)
						.fadeIn();
				}
			})
			.always(function() {
				$submitBtn.prop('disabled', false).text(submitBtnText);
			});
		} else {
			$errorFields.next('label.error').addClass('awsm-job-form-error');
		}
	});

	$('.awsm-add-mail-templates').on('click', function(e) {
		e.preventDefault();
		var $wrapper = $('#awsm-repeatable-mail-templates');
		var next = $wrapper.data('next');
		$wrapper
			.find('.awsm-acc-head')
			.removeClass('on');
		$wrapper
			.find('.awsm-acc-content')
			.slideUp('normal');
		var template = wp.template('awsm-pro-notification-settings');
		var templateData = { index: next };
		$wrapper
			.find('.awsm-mail-templates-acc-section')
			.append(template(templateData));
		$wrapper
			.find('[data-required="required"]').prop('required', true);
		$wrapper.data('next', next + 1);
	});

	$('#awsm-repeatable-mail-templates').on(
		'click',
		'.awsm-remove-mail-template',
		function(e) {
			e.preventDefault();
			var $deleteBtn = $(this);
			$deleteBtn.parents('.awsm-acc-main').remove();
		}
	);

	$('#awsm-repeatable-mail-templates').on('keyup blur', '.awsm-jobs-pro-mail-template-name', function() {
		var $nameControl = $(this);
		var templateName = $nameControl.val();
		var $header = $nameControl.parents('.awsm-acc-main');
		var $titleElem = $header.find('.awsm-jobs-pro-mail-template-title');
		var title = templateName.length > 0 ? templateName : $titleElem.text();
		$titleElem.text(title);
		$header.find('.awsm-jobs-pro-mail-template-subtitle').fadeIn();
	});

	/*================ Application Notes ================*/

	function renderApplicationNotes(note) {
		note = $.trim(note);
		if (note.length > 0) {
			var wpData = [
				{name: 'nonce', value: awsmProJobsAdmin.nonce},
				{name: 'awsm_application_id', value: applicationId},
				{name: 'awsm_application_notes', value: note},
				{name: 'action', value: 'awsm_job_pro_notes'}
			];
			$.ajax({
				url: awsmJobsAdmin.ajaxurl,
				type: 'POST',
				data: $.param(wpData),
				beforeSend: function() {
					$('#awsm_application_notes').prop('disabled', true);
					$('.awsm-jobs-application-notes-list').addClass('awsm-jobs-loading');
				},
				dataType: 'json'
			}).done(function(response) {
				if (response) {
					if (response.update === true) {
						var notesData = response.notes_data;
						var notesTemplate = wp.template('awsm-pro-notes');
						var templateData = {
							index: notesData.index,
							time: notesData.time,
							'date_i18n': notesData.date_i18n,
							author: notesData.username,
							content: note
						};
						$('.awsm-jobs-application-notes-list').prepend(notesTemplate(templateData));
						$('#awsm_application_notes').val('');
					}
				}
			})
			.always(function() {
				$('.awsm-jobs-application-notes-list').removeClass('awsm-jobs-loading');
				$('#awsm_application_notes').prop('disabled', false);
			});
		}
	}

	$('#awsm_application_notes').on('keypress', function(e) {
		if (e.which == 13) {
			e.preventDefault();
			var note = $(this).val();
			renderApplicationNotes(note);
		}
	});

	var isRemovable = true;
	$('.awsm-jobs-application-notes-list').on('click', '.awsm-jobs-note-remove-btn', function(e) {
		e.preventDefault();
		var $noteList = $(this).parents('li.awsm-jobs-note');
		var index = $noteList.data('index');
		var time = $noteList.data('time');
		if (isRemovable) {
			isRemovable = false;
			var wpData = [
				{name: 'nonce', value: awsmProJobsAdmin.nonce},
				{name: 'awsm_application_id', value: applicationId},
				{name: 'awsm_note_key', value: index},
				{name: 'awsm_note_time', value: time},
				{name: 'action', value: 'awsm_job_pro_remove_note'}
			];
			$.ajax({
				url: awsmJobsAdmin.ajaxurl,
				type: 'POST',
				data: $.param(wpData),
				beforeSend: function() {
					$('.awsm-jobs-application-notes-list').addClass('awsm-jobs-loading');
				},
				dataType: 'json'
			}).done(function(response) {
				if (response) {
					if (response.delete === true) {
						$noteList.slideUp(function() {
							$(this).remove();
							var $lists = $('li.awsm-jobs-note');
							var notesCount = $lists.length;
							$lists.each(function(i) {
								var index = notesCount - (i + 1);
								$(this).data('index', index);
								$(this).attr('data-index', index);
							});
							isRemovable = true;
						});
					}
				}
			}).fail(function() {
				isRemovable = true;
			}).always(function() {
				$('.awsm-jobs-application-notes-list').removeClass('awsm-jobs-loading');
			});
		}
	});

	/*================ Application Export ================*/

	$('.awsm-export-applications-btn').insertAfter('#post-query-submit').fadeIn();


	/*================ Shortcode Generator ================*/

	$('.awsm-shortcodes-filters-select-control').awsmSelect2({
		tags: true,
		tokenSeparators: [ ',' ],
		theme: 'awsm-job',
		dropdownCssClass: 'awsm-select2-dropdown-control',
		createTag: function() {
			return null;
		}
	});

	$('.awsm-shortcodes-job-listing-control').on('change', function() {
		var $target = $('#awsm-jobs-enable-filters-container');
		if ($('#awsm_jobs_listing_all').is(':checked')) {
			$target.removeClass('awsm-hide');
		} else {
			$target.addClass('awsm-hide');
		}
	});

	$('#awsm-jobs-generate-shortcode').click(function() {
		var enableFilter = $('#awsm_jobs_enable_filters:checked').val();
		var listings = $('#awsm_jobs_listings').val();
		var pagination = $('#awsm_jobs_pagination:checked').val();

		var shortcodeContent = '[awsmjobs';
		shortcodeContent += typeof enableFilter === 'undefined' || enableFilter !== 'yes' ? ' filters="no"' : '';
		shortcodeContent += typeof listings !== 'undefined' && parseInt(listings, 10) > 0 ? ' listings="' + parseInt(listings, 10) + '"' : '';
		shortcodeContent += typeof pagination === 'undefined' || pagination !== 'yes' ? ' loadmore="no"' : '';

		if ($('#awsm_jobs_listing_filtered').is(':checked')) {
			var attrs = [];
			$('.awsm-shortcodes-filters-select-control').each(function() {
				var $elem = $(this);
				var value = $elem.val();
				var filter = $elem.data('filter');
				var enableSpec = $elem.parents('.awsm-shortcodes-filter-item').find('.awsm-check-toggle-control:checked').val();
				if (value !== null && typeof filter !== 'undefined' && enableSpec === 'yes') {
					attrs.push(filter + ':' + value.join(' '));
				}
			});
			if (attrs.length > 0) {
				shortcodeContent += ' specs="' + attrs.join(',') + '"';
			}
		}

		shortcodeContent += ']';

		$('.awsm-settings-shortcodes-wrapper code').text(shortcodeContent);
		$('#awsm-copy-clip').attr('data-clipboard-text', shortcodeContent);
	});
});
