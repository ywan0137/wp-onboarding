(function ($) {
	'use strict';
	
	$(document).ready(() => {
		$("#graphina_setting_save_button").on('click', function (event) {
			event.preventDefault();
			$.ajax({
				url: localize.ajaxurl,
				type: "POST",
				data: jQuery('#graphina_settings_tab').serialize(),
				success: function (response) {
					console.log(response);
					if (response.status === true || response.status === 'true') {
						Swal.fire({
							title: response.message,
							text: response.subMessage
						})
					}else{
						Swal.fire(response.message)
					}
				}
			});
		});

		$("#graphina_database_save_button").on("click", function (event) {
			event.preventDefault();
			if($(document).find('#graphina_external_database_action_type').val() == 'con_test'){
				$(document).find('#graphina_external_database_action_type').val('save')
			}
			$.ajax({
				url: localize.ajaxurl,
				type: "POST",
				data: jQuery('#graphina-settings-db-tab').serialize(),
				success: function (response) {
					if ( response.status === true || response.status === 'true') {
						Swal.fire({
							title: response.message,
							text: response.subMessage
						}).then((response) => {
							window.location.href = localize_admin.adminurl + 'admin.php?page=graphina-chart&activetab=database'
						})
					}else{
						Swal.fire(response.message)
					}
				}
			});
		});

		$('.graphina_test_db_btn').click(function (event) {
			event.preventDefault();
             $(document).find('#graphina_external_database_action_type').val('con_test')
			$.ajax({
				url: localize.ajaxurl,
				type: "POST",
				data: jQuery('#graphina-settings-db-tab').serialize(),
				success: function (response) {
					if (response.status === true) {
						Swal.fire(response.message)
					} else {
						Swal.fire(response.message)
					}

				}
			});
		});

		$('.graphina-database-delete').click(function () {
			let selected_value = this.getAttribute("data-selected")
			Swal.fire({
				title: localize_admin.swal_are_you_sure_text,
				text: localize_admin.swal_revert_this_text,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: localize_admin.swal_delete_text
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: localize.ajaxurl,
						type: "POST",
						data: {
							action: 'graphina_external_database',
							type: 'delete',
							value: selected_value,
							nonce:localize_admin.nonce
						},
						success: function (response) {
							if (response.status === true || response.status === 'true') {
								window.location.href = localize_admin.adminurl + 'admin.php?page=graphina-chart&activetab=database'
							}else{
								Swal.fire(response.message)
							}
						}
					});
				}
			})
		});

		$(document).on('click', '.graphina_upload_loader', function (e) {
			e.preventDefault();
			var custom_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				},
				multiple: true
			});

			custom_uploader.on('select', function () {
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				jQuery(document).find('#graphina_loader_hidden').val(attachment.url);
				jQuery(document).find('.graphina_upload_image_preview').attr("src", attachment.url)
			});

			//Open the uploader dialog
			custom_uploader.open();

		});

		$(document).on('change', '#enable_chart_filter', function() {

			if (jQuery(this).prop('checked') == true) {

				jQuery('#chart_filter_div').removeClass('graphina-d-none');

			} else {

				jQuery('#chart_filter_div').addClass('graphina-d-none');

			}
		});
	});
})(jQuery);