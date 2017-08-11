// Generated by CoffeeScript 1.9.3
(function() {
  (function($) {
    window.doShow = function(x) {
      if (window.shown(x)) {
        return window.hideOne(x);
      } else {
        return window.showOne(x);
      }
    };
    window.hideAll = function() {
      return $(".project-contents").css('display', 'none');
    };
    window.hideOne = function(x) {
      return $("#" + x).css('display', 'none');
    };
    window.showOne = function(x) {
      return $("#" + x).css('display', 'block');
    };
    return window.shown = function(x) {
      return ($("#" + x).css('display')) !== 'none';
    };
  })(jQuery);

}).call(this);
