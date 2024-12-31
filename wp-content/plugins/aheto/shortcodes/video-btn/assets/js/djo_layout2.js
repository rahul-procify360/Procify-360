;(function ($, window, document, undefined) {
    "use strict";
    
    /**
     * find all videos
     */

    function findVideos() {
        if($('.aheto-video--djo-inline').length ) {
            let videos = document.querySelectorAll('.aheto-video--djo-inline .js-video');

            for (let i = 0; i < videos.length; i++) {
                setupVideo(videos[i]);
            }
        }
    }

    /**
     * Setup video after click on box
     * 
     * @param video 
     */

    function setupVideo(video) {
        if($('.aheto-video--djo-inline').length ) {
            let link = video.querySelector('.aheto-video--djo-inline .js-link');
            let button = video.querySelector('.aheto-video--djo-inline .js-button');
            let id = video.getAttribute('data-id');

            video.addEventListener('click', () => {
                let iframe = createIframe(id);

                link.remove();
                button.remove();
                video.appendChild(iframe);
            });

            link.removeAttribute('href');
            video.classList.add('video--enabled');
        }
    }

    /**
     * Parse ID from URL
     * 
     * @param media Link with video ID(youtube poster src)
     */

    // function parseMediaURL(media) {
    // 	let regexp = /https:\/\/i\.ytimg\.com\/vi\/([a-zA-Z0-9_-]+)\/maxresdefault\.jpg/i;
    // 	let url = media.src;
    // 	let match = url.match(regexp);

    // 	return match[1];
    // }

    /**
     * Create Iframe
     * 
     * @param id Video ID
     * 
     * @returns iframe objects
     */

    function createIframe(id) {
        let iframe = document.createElement('iframe');

        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('allow', 'autoplay');
        iframe.setAttribute('src', generateURL(id));
        iframe.classList.add('aheto-video__media');

        return iframe;
    }

    /**
     * Generate full video URL
     * 
     * @param id Video ID
     * 
     * @returns full video url
     */

    function generateURL(id) {
        let query = '?rel=0&showinfo=0&autoplay=1';

        return 'https://www.youtube.com/embed/' + id + query;
    }

    findVideos();	

})(jQuery, window, document);