; (function ($, window, document, undefined) {

  function playAudio() {
    $(".widget_aheto__audio--vestry .clickAud").on('click', function () {
      stopAudio();

      const audio = $(this).find("audio").get(0);

      if (!$(this).hasClass('playAud')) {
        audio.play();
        $(this).addClass('playAud');
      } else {
        audio.pause();
        $(this).removeClass('playAud');
      }
    });
  }

  function stopAudio() {
    const $audios = document.querySelectorAll('audio');

    $audios.forEach((element) => {
      element.pause();
    });
  }

  playAudio();

})(jQuery, window, document);