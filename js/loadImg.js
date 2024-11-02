// JavaScript Document
(function() {
  (function(jQuery) {
    return jQuery.fn.imgPreload = function(options) {
      var delay_completion, i, image_stack, placeholder_stack, replace, settings, spinner_stack, src, x, _i, _len;
      settings = {
        fake_delay: 10,
        animation_duration: 1000,
        spinner_src: 'spinner.gif'
      };
      if (options) {
        jQuery.extend(settings, options);
      }
      image_stack = [];
      placeholder_stack = [];
      spinner_stack = [];
      window.delay_completed = false;
      delay_completion = function() {
        var x, _i, _len, _results;
        window.delay_completed = true;
        _results = [];
        for (_i = 0, _len = image_stack.length; _i < _len; _i++) {
          x = image_stack[_i];
          _results.push(jQuery(x).attr('data-load-after-delay') === 'true' ? (replace(x), jQuery(x).removeAttr('data-load-after-delay')) : void 0);
        }
        return _results;
      };
      setTimeout(delay_completion, settings.fake_delay);
      this.each(function() {
        var jQueryimage, jQueryplaceholder, jQueryspinner_img, offset_left, offset_top;
        jQueryimage = jQuery(this);
        offset_top = jQueryimage.offset().top;
        offset_left = jQueryimage.offset().left;
        jQueryspinner_img = jQuery('<img>');
        jQueryplaceholder = jQuery('<img>').attr({
          src: '../wp-content/plugins/connectforms_script/loading.gif'
        });
        jQueryplaceholder.attr({
          width: jQueryimage.attr('width')
        });
        jQueryplaceholder.attr({
          height: jQueryimage.attr('height')
        });
        spinner_stack.push(jQueryspinner_img);
        placeholder_stack.push(jQueryplaceholder);
        image_stack.push(jQueryimage.replaceWith(jQueryplaceholder));
        jQuery('body').append(jQueryspinner_img);
        jQueryspinner_img.css({
          position: 'absolute'
        });
        jQueryspinner_img.css('z-index', 9999);
        jQueryspinner_img.load(function() {
          jQuery(this).css({
            left: (offset_left + jQueryplaceholder.width() / 2) - jQuery(this).width() / 2
          });
          return jQuery(this).css({
            top: (offset_top + jQueryplaceholder.height() / 2) - jQuery(this).height() / 2
          });
        });
        return jQueryspinner_img.attr({
          src: settings.spinner_src
        });
      });
      i = 0;
      for (_i = 0, _len = image_stack.length; _i < _len; _i++) {
        x = image_stack[_i];
        x.attr({
          no: i++
        });
        src = x.attr('src');
        x.attr({
          src: ''
        });
        x.load(function() {
          if (window.delay_completed) {
            return replace(this);
          } else {
            return jQuery(this).attr('data-load-after-delay', true);
          }
        });
        x.attr({
          src: src
        });
      }
      replace = function(image) {
        var jQueryimage, no_;
        jQueryimage = jQuery(image);
        no_ = jQueryimage.attr('no');
        placeholder_stack[no_].replaceWith(jQueryimage);
        spinner_stack[no_].fadeOut(settings.animation_duration / 2, function() {
          return jQuery(this).remove();
        });
        return jQueryimage.fadeOut(0).fadeIn(settings.animation_duration);
      };
      return this;
    };
  })(jQuery);
}).call(this);