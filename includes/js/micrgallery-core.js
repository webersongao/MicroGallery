
jQuery(document).ready(function ($) {
  // Instantiates the variable that holds the media library frame.
  var meta_image_frame;
  // Runs when the image button is clicked.
  $('.micro-gallery-imgupload').click(function (e) {
    e.preventDefault();
    // If the frame already exists, re-open it.
    if (meta_image_frame) {
      meta_image_frame.open();
      return;
    }

    // Sets up the media library frame
    meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
      title: 'Select images to upload',
      button: {
        text: 'Use this image',
      },
      multiple: true
    });
    // Runs when an image is selected.
    meta_image_frame.on('select', function () {

      var attachments = meta_image_frame.state().get('selection').map(function (attachment) {
        attachment.toJSON();
        return attachment;

      });

      //loop through the array and do things with each attachment
      var i;

      for (i = 0; i < attachments.length; ++i) {

        //sample function 1: add image preview
        $('#micro-gallery-sortableitem').append(
          '<div class="micro-gallery-boximg"><img src="' +
          attachments[i].attributes.url + '" title="img' +
          attachments[i].id + '" >'
          + '<input id="micro-gallery-image-input' + attachments[i].id + '" type="hidden" name="mg_gallery_imgids[]"  value="' +
          attachments[i].id + '"><input class="micro-gallery-image-delete" type="button" name="mg_data_delete_img_item"  data-dlt="' +
          attachments[i].id + '" value="Delete this"></div>'
        );

      }
    });
    // Opens the media library frame.
    meta_image_frame.open();
  });

});

