; (function ($, window, document, undefined) {

  function playAudioS() {
    $(".aheto-cpt-article--vestry_skin-6 .clickAud").on('click', function () {
      stopAudio();

      const audio = $(this).find("audio").get(0);

      if (!$(this).hasClass('playAudS')) {
        audio.play();
        $(this).addClass('playAudS');
      } else {
        audio.pause();
        $(this).removeClass('playAudS');
      }
    });
  }

  function stopAudio() {
    const $audios = document.querySelectorAll('audio');

    $audios.forEach((element) => {
      element.pause();
    });
  }

  playAudioS();

})(jQuery, window, document);