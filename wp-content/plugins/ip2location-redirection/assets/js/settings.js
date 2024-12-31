jQuery(document).ready(function ($) {
	$('#lookup_mode')
		.on('change', function () {
			if ($(this).val() == 'bin') {
				$('#bin_database').show();
				$('#api_web_service').hide();
			} else {
				$('#bin_database').hide();
				$('#api_web_service').show();
			}
		})
		.trigger('change');

	$('#update_ip2location_database').on('click', function (e) {
		e.preventDefault();

		var enable_region = $('#enable_region_redirection').is(':checked');
		var ipv4_only = $('#download_ipv4_only').is(':checked');

		$('#download_token').prop('readonly', true);
		$('#update_ip2location_database, #lookup_mode, #enable_region_redirection, #download_ipv4_only').prop('disabled', true);

		$('#update_status').html('<span class="dashicons dashicons-update spin"></span> Updating database...');

		$.post(
			ajaxurl,
			{
				action: 'ip2location_redirection_update_ip2location_database',
				token: $('#download_token').val(),
				enable_region: enable_region,
				ipv4_only: ipv4_only,
				__nonce: $('#update_nonce').val(),
			},
			function (data) {
				if (data.status == 'OK') {
					$('#update_status').html('<span class="dashicons dashicons-yes-alt"></span> Database updated successfully.');
				} else {
					$('#update_status').html('<span class="dashicons dashicons-warning"></span>' + data.message);
				}
			},
			'json'
		)
			.error(function () {
				$('#update_status').html('<span class="dashicons dashicons-warning"></span> Request timed out. Please check your server error log for details.');
			})
			.always(function () {
				$('#download_token').prop('readonly', false);
				$('#update_ip2location_database, #lookup_mode, #enable_region_redirection, #download_ipv4_only').prop('disabled', false);
			});
	});

	$('#btn_download_backup').on('click', function (e) {
		e.preventDefault();

		$('#form_download_backup').submit();
	});

	$('#file-restore').uploadFile({
		url: ajaxurl,
		formData: {
			action: 'ip2location_redirection_restore',
			__nonce: $('#restore_nonce').val(),
		},
		multiple: false,
		dragDrop: true,
		maxFileCount: 1,
		fileName: 'file-restore',
		acceptFiles:'.json',
		onSuccess:function(files, data, xhr, pd) {
			if (data.status != 'OK') {
				alert(data.message);
				return;
			}

			window.location.href = window.location.href;
		},
	});
});
