<?php use_javascript('swfupload.js') ?>
<?php use_javascript('swfu_handlers.js') ?>
<?php use_javascript('swfu_fileprogress.js') ?>
<h1>Upload Test Page</h1>

<!--<script type="text/javascript" src="js/swfupload.swfobject.js"></script>-->
<script type="text/javascript">
		var swfu;

		window.onload = function () {
			swfu = new SWFUpload({
				// Backend settings
				upload_url: "<?php echo url_for('welcome/getvideo') ?>",
				file_post_name: "videofile",

				// Flash file settings
				file_size_limit : "10 MB",
				file_types : "*.flv;*.mpg;*.avi;*.mp4",			// ;or you could use something like: "*.doc;*.wpd;*.pdf",
				file_types_description : "Video files",
				file_upload_limit : "0",
				file_queue_limit : "1",

				// Event handler settings
				swfupload_loaded_handler : swfUploadLoaded,
				
				file_dialog_start_handler: fileDialogStart,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				
				//upload_start_handler : uploadStart,	// I could do some client/JavaScript validation here, but I don't need to.
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,

				// Button Settings
				button_image_url : "/images/XPButtonUploadText_61x22.png",
				button_placeholder_id : "spanButtonPlaceholder",
				button_width: 61,
				button_height: 22,
				
				// Flash Settings
				flash_url : "/flash/swfu/swfupload.swf",

				custom_settings : {
					progress_target : "fsUploadProgress",
					upload_successful : false
				},
				
				// Debug settings
				debug: false
			});

		};
	</script>

<div id="content">

	<h2>Classic Form Demo</h2>
	<form id="form1" action="<?php echo url_for('welcome/thanks') ?>" enctype="multipart/form-data" method="post">
		<p>This demo shows how SWFUpload might be combined with an HTML form.  It also demonstrates graceful degradation (using the graceful degradation plugin).
			This demo also demonstrates the use of the server_data parameter.  This demo requires Flash Player 9+</p>
		<div class="fieldset">
			<span class="legend">Submit your Video</span>
			<table style="vertical-align:top;">
				<tr>
					<td><label for="firstname">First Name:</label></td>
					<td><input name="firstname" id="firstname" type="text" style="width: 200px" /></td>
				</tr>
				<tr>
					<td><label for="lastname">Last Name:</label></td>
					<td><input name="lastname" id="lastname" type="text" style="width: 200px" /></td>
				</tr>
				<tr>
					<td><label for="description">Description:</label></td>
					<td><textarea name="description"  id="description" cols="0" rows="0" style="width: 400px; height: 100px;"></textarea></td>
				</tr>
				<tr>
					<td><label for="txtFileName">Video:</label></td>
					<td>
						<div>
							<div>
								<input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF;" />
								<span id="spanButtonPlaceholder"></span>
								(10 MB max)
							</div>
							<div class="flash" id="fsUploadProgress">
								<!-- This is where the file progress gets shown.  SWFUpload doesn't update the UI directly.
											The Handlers (in handlers.js) process the upload events and make the UI updates -->
							</div>
							<input type="hidden" name="hidFileID" id="hidFileID" value="" />
							<!-- This is where the file ID is stored after SWFUpload uploads the file and gets the ID back from upload.php -->
						</div>
					</td>
				</tr>
				<tr>
					<td><label for="comments">Comments:</label></td>
					<td><textarea name="comments" id="comments" cols="0" rows="0" style="width: 400px; height: 100px;"></textarea></td>
				</tr>
			</table>
			<br />
			<input type="submit" value="Submit" id="btnSubmit" />
		</div>
	</form>
</div>
