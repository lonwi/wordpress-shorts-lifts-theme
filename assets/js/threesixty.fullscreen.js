(function($) {
  'use strict';
  $.ThreeSixtyFullscreen = function(el, options) {
    var plugin = this,
      $el = el,
      opts = options,
      $button = $('<a href=\'#\' class=\'full-screen-3d\' title=\'Open fullscreen mode\'>Fullscreen</a>'),
      isFullscreen = false,
      pfx = ['webkit', 'moz', 'ms', 'o', ''];

    // Attach event to the plugin
    $button.bind('click', function(event) {
      plugin.onClickHandler.apply(this, event);
    });

    /**
     * Set styles for the plugin interface.
     * @return {Object} this
     */
    plugin.setStyles = function() {
      $button.css({
      });
      return this;
    };

    plugin.RunPrefixMethod = function(obj, method) {
      var p = 0,
        m, t;
      while (p < pfx.length && !obj[m]) {
        m = method;
        if (pfx[p] === '') {
          m = m.substr(0, 1).toLowerCase() + m.substr(1);
        }
        m = pfx[p] + m;
        t = typeof obj[m];
        if (t !== 'undefined') {
          pfx = [pfx[p]];
          return (t === 'function' ? obj[m]() : obj[m]);
        }
        p++;
      }
    };
    /**
     * Initilize the fullscreen plugin
     * @param  {Object} opt override options
     */
    plugin.init = function() {
      plugin.setStyles();
      $el.prepend($button);
    };

    plugin.onClickHandler = function(e) {
      var elem;
      if (typeof $el.attr('id') !== 'undefined') {
        elem = document.getElementById($el.attr('id'));
      } else if (typeof $el.parent().attr('id') !== 'undefined') {
        elem = document.getElementById($el.parent().attr('id'));
      } else {
        return false;
      }
      plugin.toggleFullscreen(elem);
    };

    plugin.toggleButton = function() {
		
      if (isFullscreen) {
        $button.css({
          'background-position': '0px 0px'
        });
      } else {
        $button.css({
          'background-position': '0px -20px'
        });
      }
    };
	
	plugin.openButton = function() {
		$button.css({
          'background-position': '0px -20px'
        }).attr('title','Open fullscreen mode');
		$el.css({
			'width' : 467,
			'height' : 467,
			'border' : '4px solid #eeeeee',
			'top'   : 0,
			'margin-top' : 0,
		});
	};
	plugin.closeButton = function() {
		var windowWidth = $(window).width(); //retrieve current window width
		var windowHeight = $(window).height(); //retrieve current window height
		if(windowWidth > windowHeight) {
			var newSize = windowHeight;
		}else{
			var newSize = windowWidth;
		}
		if(newSize > 1200){
			newSize = 1200;
		}
		var marginTop = newSize / 2;
		$el.css({
			'width' : newSize,
			'height' : newSize,
			'border' : 'none',
			'top'   : '50%',
			'margin-top' : -marginTop,
		});
		$button.css({
          'background-position': '0px 0px'
        }).attr('title','Close fullscreen mode');
	};

    plugin.toggleFullscreen = function(elem) {
      if (plugin.RunPrefixMethod(document, 'FullScreen') || plugin.RunPrefixMethod(document, 'IsFullScreen')) {
        plugin.RunPrefixMethod(document, 'CancelFullScreen');
		plugin.openButton();
      }
      else {
        plugin.RunPrefixMethod(elem, 'RequestFullScreen');
		plugin.closeButton();
      }
      //plugin.toggleButton();
    };
    plugin.init();
  };
}(jQuery));