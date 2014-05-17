/**
 * Media upload handler script.
 *
 * Props to Thomas Griffin for the following JS code!
 * 
 * @package    Theme_Junkie_Features_Content
 * @since      0.1.0
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2014, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */
jQuery(document).ready(function($){
	
	var tjfc_media_frame;
	
	// Bind to our click event in order to open up the new media experience.
	$(document.body).on('click.tjfcOpenMediaManager', '.tjfc-open-media', function(e){

		// Prevent the default action from occuring.
		e.preventDefault();

		// If the frame already exists, re-open it.
		if ( tjfc_media_frame ) {
			tjfc_media_frame.open();
			return;
		}

		tjfc_media_frame = wp.media.frames.tjfc_media_frame = wp.media({

			className: 'media-frame tjfc-media-frame',
			frame: 'select',
			multiple: false,
			title: tjfc_media.title,
			library: {
				type: 'image'
			},
			button: {
				text:  tjfc_media.button
			}

		});

		tjfc_media_frame.on('select', function(){
			
			// Grab our attachment selection and construct a JSON representation of the model.
			var media_attachment = tjfc_media_frame.state().get('selection').first().toJSON();

			// Send the attachment URL to our custom input field via jQuery.
			$('#tjfc-feature-icon').val(media_attachment.url);
			
		});

		// Now that everything has been set, let's open up the frame.
		tjfc_media_frame.open();

	});

});