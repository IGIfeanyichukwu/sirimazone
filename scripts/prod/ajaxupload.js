console.log('This is from the ajaxupload script');


/*$(document).ready(function(){
	$('#file-upload-form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener('progress', function(evt) {
					if(evt.lengthComputable) {
						var percentComplete = ((evt.loaded /evt.total) * 100);
						$('.upload-progress-bar').width(percentComplete + '%');
					}
				}, false);
				return xhr;
			},
			type: 'POST',
			url: 'upload-content.php',
			data: new FormData(this),
			contentType: false;
			cache: false,
			processData: false,
			beforeSend: function() {
				$('.upload-progress-bar').width('0%');
				$('#uploadStatus').html('uplooading');
			},
			error: function() {
				$('#upload').html('<p>File upload fail, please try again.</p>')
			},
			success: function() {
				if(resp == 'ok') {
					$('#file-upload-form')[0].reset();
					$('#uploadStatus').html('<p>File has been uploaded successfully.</p>')
				}else if(resp == 'err') {
					$('#uploadStatus').html('<p>please select a valid file to upload</p>')
				}
			}
			});
		});

		//file type validation
		$('#file-upload-input').change(function(){
			var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

			var file = this.files[0];
			var fileType = file.type;
			if(!allowedTypes.includes(fileType)) {
				alert('Please select a valid file(PDF/DOC/DOCX/JPEG/JPG/PNG/GIF).');
				$('file-upload-input').val('');
				return false;
			}
			})
	});
*/
