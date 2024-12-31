
; (function ($, window, document, undefined) {
  'use strict';

  function openDay(event, dayName) {
    var i;
    var day = document.getElementsByClassName("event-day");
    var list = document.getElementsByClassName("tablink");
    for (i = 0; i < day.length; i++) {
      day[i].style.display = "none";
    }

    for (i = 0; i < list.length; i++) {
      list[i].className = list[i].className.replace(" active", "");
    }

    document.getElementById(dayName).style.display = "table";
    event.currentTarget.className += " active";
  }

})(jQuery, window, document);