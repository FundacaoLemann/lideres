/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var   uploaderObj = {};

jQuery(function($) {

   function renderUploaderWidget(widget_id) {

    //sidebar widget uploader config script
    if ($("#rtMedia-upload-button-" + widget_id).length > 0) {
        var temp1 = "rtMedia_widget_plupload_config_"+widget_id;
        uploaderObj[widget_id] = new UploadView(eval(temp1));

        uploaderObj[widget_id].initUploader(false);


        uploaderObj[widget_id].uploader.bind('UploadComplete', function(up, files) {
            activity_id = -1;
            //galleryObj.reloadView();            
            jQuery('.rtm-uploader-widget .rtMedia-queue-list li').remove();
            window.onbeforeunload = null;
        });
        
        uploaderObj[widget_id].uploader.bind('FilesAdded', function(up, files) {
            var upload_size_error = false;
            var upload_error = "";
            var upload_error_sep = "";
            var upload_remove_array= [];
            $.each(files, function(i, file) {
                var hook_respo = rtMediaHook.call('rtmedia_js_file_added', [up,file, "#rtmedia_uploader_filelist-"+widget_id]);
                if( hook_respo == false){
                    file.status = -1;
                    upload_remove_array.push(file.id);
                    return true;
                }
                if (uploaderObj[widget_id].uploader.settings.max_file_size < file.size) {
                    return true;
                }
                
                // Creating list of media to preview selected files
				rtmedia_pro_selected_file_list( plupload, file, '', '', widget_id );
                
                //Delete Function
                $( "#" + file.id + " .plupload_delete_" + widget_id + " .remove-from-queue" ).click( function ( e ) {
                    e.preventDefault();
                    uploaderObj[widget_id].uploader.removeFile(up.getFile(file.id));
                    $("#" + file.id).remove();
                    return false;
                });

            });
            if (upload_size_error) {
                // alert(upload_error + " because max file size is " + plupload.formatSize(uploaderObj[widget_id].uploader.settings.max_file_size) );
            }
            $.each(upload_remove_array, function(i, rfile) {
                up.removeFile(up.getFile(rfile));
            });

            rtMediaHook.call( 'rtmedia_pro_js_after_files_added', [up, files, widget_id] );
        });

        uploaderObj[widget_id].uploader.bind( 'UploadComplete', function ( up, files ) {
            var hook_respo = rtMediaHook.call( 'rtmedia_pro_js_after_files_uploaded' );
        } );
        
        uploaderObj[widget_id].uploader.bind('Error', function(up, err) {            
            if(err.code == -600){ //file size error // if file size is greater than server's max allowed size
                var tmp_array;
                var ext = tr = '';
                tmp_array =  err.file.name.split(".");
                if(tmp_array.length > 1){
                    ext= tmp_array[tmp_array.length - 1];
                    if( !(typeof(up.settings.upload_size) != "undefined" && typeof(up.settings.upload_size[ext]) != "undefined" &&  typeof(up.settings.upload_size[ext]['size']) )){
                        // Creating list of media to preview selected files
                        rtmedia_pro_selected_file_list( plupload, err.file, up, err, widget_id );
                    }
                }
            }
            else { 
            
                if( err.code == -601) { // file extension error 
                    err.message = rtmedia_file_extension_error_msg;
                }
                
                // Creating list of media to preview selected files
                rtmedia_pro_selected_file_list( plupload, err.file, up, err, widget_id );
            }
                   
            jQuery('.error_delete').on('click',function(e){
                e.preventDefault();
                jQuery(this).parent('tr').remove();
            });
            return false;
            
        });

        uploaderObj[widget_id].uploader.bind('QueueChanged', function(up) {
            var hook_respo = rtMediaHook.call( 'rtmedia_pro_js_after_queue_changed' );
            if( hook_respo != false ) {
                uploaderObj[widget_id].uploadFiles();
            }
        });

        uploaderObj[widget_id].uploader.bind('UploadProgress', function(up, file) {
            $( "#" + file.id + " .plupload_file_status" ).html( '<div class="plupload_file_progress ui-widget-header" style="width: ' + file.percent + '%;"></div>' );
			$( "#" + file.id ).addClass( 'upload-progress' );
            
			if ( file.percent == 100 ) {
				$( "#" + file.id ).toggleClass( 'upload-success' );
			}

			window.onbeforeunload = function ( evt ) {
                             
				var message = rtmedia_upload_progress_error_message;
				return message;
			};
        });
        uploaderObj[widget_id].uploader.bind('BeforeUpload', function(up, file) {
            up.settings.multipart_params.privacy = $("#rtm-file_upload-ui-"+widget_id+" select.privacy").val();
            if (jQuery("#rt_upload_hf_redirect_"+widget_id).length > 0)
                up.settings.multipart_params.redirect = up.files.length;
            jQuery("#rtmedia-uploader-form-"+widget_id+" input[type=hidden]").each(function() {
                up.settings.multipart_params[$(this).attr("name")] = $(this).val();
            });
            up.settings.multipart_params.activity_id = activity_id;
            if ($('#album-list-'+widget_id).length > 0)
                up.settings.multipart_params.album_id = $('#album-list-'+widget_id).find(":selected").val();
            else if ($('#rtmedia-current-album-'+widget_id).length > 0)
                up.settings.multipart_params.album_id = $('#rtmedia-current-album-'+widget_id).val();
        });

        uploaderObj[widget_id].uploader.bind('FileUploaded', function(up, file, res) {

            if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) { //test for MSIE x.x;
                var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number

                   if(ieversion <10) { //fixes the bug for IE<10
                           if( typeof res.response !== "undefined" )
                               res.status = 200;
                   }
            }

            var rtnObj;
             try {
                rtnObj = JSON.parse(res.response);
                uploaderObj[widget_id].uploader.settings.multipart_params.activity_id = rtnObj.activity_id;
                activity_id = rtnObj.activity_id;
            } catch (e) {
                 console.log('Invalid Activity ID');
            }
            if (res.status == 200 || res.status == 302) {
                if (uploaderObj[widget_id].upload_count == undefined)
                    uploaderObj[widget_id].upload_count = 1;
                else
                    uploaderObj[widget_id].upload_count++;

                if (uploaderObj[widget_id].upload_count == up.files.length && jQuery("#rt_upload_hf_redirect_"+widget_id).length > 0 && jQuery.trim(rtnObj.redirect_url.indexOf("http") == 0)) {
                    window.location = rtnObj.redirect_url;
                }
                $("#" + file.id + " .plupload_file_status").html( rtmedia_uploaded_msg);
                rtMediaHook.call( 'rtmedia_pro_js_after_file_upload', [up, file, res.response] );
            }else {
                $("#" + file.id + " .plupload_file_status").html( rtmedia_upload_failed_msg );
            }

            files = up.files;
            lastfile = files[files.length - 1];

        });

        uploaderObj[widget_id].uploader.refresh();//refresh the uploader for opera/IE fix on media page

        $("#rtMedia-start-upload-"+widget_id).click(function(e) {
            uploaderObj[widget_id].uploadFiles(e);
        });
        $("#rtMedia-start-upload-"+widget_id).hide();
    }

   }

    //
    $('.widget-drag-drop').each(function () {

        var temp = this.id.split("-");//get the widget id
        var widget_id = temp[temp.length-1];
        renderUploaderWidget(widget_id);

    });


});

function rtmedia_pro_selected_file_list( plupload, file, uploader, error, widget_id ) {
	var rtmedia_plupload_file = '<li class="plupload_file ui-state-default rtmedia-uploader-filelist-li" id="' + file.id + '">';
	rtmedia_plupload_file += '<div id="file_thumb_' + file.id + '" class="plupload_file_thumb">';
	rtmedia_plupload_file += '</div>';
	rtmedia_plupload_file += '<div class="plupload_file_status">';

	if ( error == '' ) {
		rtmedia_plupload_file += '<div class="plupload_file_progress ui-widget-header" style="width: 0%;">';
		rtmedia_plupload_file += '</div>';
	} else if ( error.code == -600 ) {
		rtmedia_plupload_file += rtmedia_max_file_msg + plupload.formatSize( uploader.settings.max_file_size / 1024 * 1024 );
		rtmedia_plupload_file += '<i class="dashicons dashicons-info rtmicon" title="' + window.file_size_info + '"></i>';
	} else if ( error.code == -601 ) {
		rtmedia_plupload_file += error.message;
		rtmedia_plupload_file += '<i class="dashicons dashicons-info rtmicon" title="' + window.file_size_info + '"></i>';
	}

	rtmedia_plupload_file += '</div>';
	rtmedia_plupload_file += '<div class="plupload_file_name" title="' + ( file.name ? file.name : '' ) + '">';
	rtmedia_plupload_file += '<span class="plupload_file_name_wrapper">';
	rtmedia_plupload_file += ( file.name ? file.name : '' );
	rtmedia_plupload_file += '</span>';
	rtmedia_plupload_file += '</div>';
	rtmedia_plupload_file += '<div class="plupload_file_action">';
	rtmedia_plupload_file += '<div class="plupload_action_icon ui-icon plupload_delete_' + widget_id + '">';
	rtmedia_plupload_file += '<span class="remove-from-queue dashicons dashicons-dismiss"></span>';
	rtmedia_plupload_file += '</div>';
	rtmedia_plupload_file += '</div>';
	rtmedia_plupload_file += '<div class="plupload_file_size">';
	rtmedia_plupload_file += plupload.formatSize( file.size );
	rtmedia_plupload_file += '</div>';
	rtmedia_plupload_file += '<div class="plupload_file_fields">';
	rtmedia_plupload_file += '</div>';
	rtmedia_plupload_file += '</li>';

	jQuery( rtmedia_plupload_file ).appendTo( '#rtmedia_uploader_filelist-' + widget_id );
	var type = file.type;
    var media_title = file.name;
    var ext = media_title.substring( media_title.lastIndexOf( "." ) + 1, media_title.length );

	if ( /image/i.test( type ) ) {
        if( ext === 'gif' ) {
            jQuery( '<img src="' + rtmedia_media_thumbs[ 'photo' ] + '" />' ).appendTo( '#file_thumb_' + file.id );
        } else {
            var img = new mOxie.Image();

            img.onload = function () {
                this.embed( jQuery( '#file_thumb_' + file.id ).get( 0 ), {
                    width: 100,
                    height: 60,
                    crop: true
                } );
            };

            img.onembedded = function () {
                this.destroy();
            };

            img.onerror = function () {
                this.destroy();
            };

            img.load( file.getSource() );
        }
	} else {
        
        jQuery.each( rtmedia_exteansions, function( key, value ) {
            if( value.indexOf( ext ) >= 0 ) {
                jQuery( '<img src="' + rtmedia_media_thumbs[ key ] + '" />' ).appendTo( '#file_thumb_' + file.id );
                
                return false;
            }
        } );
    }
    
}
