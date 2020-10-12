console.log('This is from the ajaxupload script');


$(document).ready(function () {
	$("#file-upload-form").on('submit', function(e){
		e.preventDefault();
		$.ajax({
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(evt) {
					if(evt.lengthComputable) {
						var percentComplete = ((evt.loaded / evt.total) * 100);
						$(".file-upload-progress-bar").width(percentComplete + '%');
					}
				}, false);
				return xhr;
			},
			type: 'POST',
			url: '../__admin/fileUploadServer.php',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function() {
				$('.file-upload-progress-bar').width('0%');
				$('#file-upload-status').html('<p>uploading to server...</p>');
			},
			error: function() {
				$('#file-upload-status').html('<p>uploaded failed.</p>');
				mdtoast('File upload failed, kindly try again', {
						duration: 3000,
			  			type: 'error'
					});

			},
			success: function(response) {
				console.log('It was successful');
				console.log('Response value is ', response);
				if (response == 'ok') {
					$('#file-upload-form')[0].reset();
					$('#file-upload-status').html('<p>uploaded.</p>');
	    			document.querySelector('.modal-bg').classList.add('show-modal-bg');
					mdtoast('Hurray, The file has been successfully uploaded.', {
					duration: 4000,
		  			type: 'success',
		  			modal: true,
		  			interaction: true,
		  			interactionTimeout: 5000,
		  			actionText: 'OK', 
	  				action: function(){
	    			document.querySelector('.modal-bg').classList.remove('show-modal-bg');
					$(".file-upload-progress-bar").width('0');
					$('#file-upload-status').html('');
	    			this.hide();
	  			}

				});
				}else if (response == 'err') {
					$('#file-upload-status').html('');
					$(".file-upload-progress-bar").width('0');
					mdtoast('Please select a valid file to upload', {
						duration: 3000,
			  			type: 'error'
					});
				} else if (response == 'max_size_err') {
					$('#file-upload-status').html('');
					$(".file-upload-progress-bar").width('0');
					mdtoast('File size should not exceed 510MB', {
						duration: 3000,
			  			type: 'error'
					});
				}

			}
		});
	});

		//file type validation
		$('#file-upload-input').change(function(){
			var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'audio/mpeg', 'video/3gpp', 'video/mp4', 'video/x-matroska' ];

			var file = this.files[0];
			var fileType = file.type;
			if(!allowedTypes.includes(fileType)) {
				mdtoast('Please select a valid file(JPEG/JPG/PNG/GIF/MP3/3GP/MP4/MKV).', {
						duration: 4000,
			  			type: 'warning'
					});
				$('file-upload-input').val('');
				return false;
			}
			})
	});

