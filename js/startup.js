(function () {

    'use_strict';

    // Run code when document (DOM) has been loaded 
    document.addEventListener('DOMContentLoaded', function()
    {
        // Get the html container
        var pswp = document.querySelector('.pswp');
                
        // Get all image links
        var tags = document.querySelectorAll('figure > a');

        // Add share buttons
        var share_buttons = [
            {id:'facebook', label: pswp.querySelector('#pswp__facebook').value, url:'https://www.facebook.com/sharer/sharer.php?u={{url}}'},
            {id:'twitter', label: pswp.querySelector('#pswp__twitter').value, url:'https://twitter.com/intent/tweet?text={{text}}&url={{url}}'},
            {id:'pinterest', label: pswp.querySelector('#pswp__pinterest').value, url:'http://www.pinterest.com/pin/create/button/?url={{url}}&media={{image_url}}&description={{text}}'},
            {id:'download', label: pswp.querySelector('#pswp__download').value, url:'{{raw_image_url}}', download:true}
        ];

        // Loop tags
        for(var i = 0; i < tags.length; i++)
        {
            // Get a caption
            var caption = tags[i].parentElement.querySelector('figcaption');

            // Load the image and set attributes
            loadImage(tags[i], i, caption)

            // Add click event
            tags[i].addEventListener('click', function (event) {

                // Make sure that PhotoSwipe and PhotoSwipeUI_Default exists
                if (!PhotoSwipe || !PhotoSwipeUI_Default) {
                    return;
                }

                // Prevent default click behaviour
                event.preventDefault();

                // Create options
                var options = {
                    index: parseInt(this.getAttribute('data-pswp-index')),
                    shareButtons: share_buttons,
                    closeOnScroll: false,
                    closeOnVerticalDrag: false,
                    clickToCloseNonZoomable: false
                };

                // Create an array to hold items
                var items = [];

                // Get all images
                var images = document.querySelectorAll('.annytab-photoswipe');

                // Loop tags
                for(var j = 0; j < images.length; j++)
                {
                    // Add image to item list
                    items.push({
                        src: images[j].href,
                        w: images[j].getAttribute('data-pswp-width'),
                        h: images[j].getAttribute('data-pswp-height'),
                        title: images[j].getAttribute('data-pswp-caption')
                    });
                }

                // Create a gallery
                var gallery = new PhotoSwipe(pswp, PhotoSwipeUI_Default, items, options);

                // Open the gallery
                gallery.init();

            }, false);

        }

    }, false);

    // Load an image
    function loadImage(tag, index, caption) {

        // Create a new image and set the source
        var img = new Image();
        img.src = tag.href;

        // Handle the onload event
        img.onload = function() {
            tag.classList.add('annytab-photoswipe');
            tag.setAttribute('data-pswp-index', index);
            tag.setAttribute('data-pswp-width', img.naturalWidth);
            tag.setAttribute('data-pswp-height', img.naturalHeight);
            tag.setAttribute('data-pswp-caption', caption !== null ? caption.innerHTML : '');
        };

    } // End of the loadImage method

})();