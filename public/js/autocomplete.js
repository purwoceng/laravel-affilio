// Autocomplete */
(function($) {
    $.fn.autocomplete = function(option) {
        return this.each(function() {
            var $this = $(this);
            var $dropdown = $('<ul class="dropdown-menu" />');

            this.timer = null;
            this.items = [];

            $.extend(this, option);

            $this.attr('autocomplete', 'off');

            // Focus
            $this.on('focus', function() {
                this.request();
            });

            // Blur
            $this.on('blur', function() {
                setTimeout(function(object) {
                    object.hide();
                }, 200, this);
            });

            // Keydown
            $this.on('keydown', function(event) {
                switch(event.keyCode) {
                    case 27: // escape
                        this.hide();
                        break;
                    default:
                        this.request();
                        break;
                }
            });

            // Click
            this.click = function(event) {
                event.preventDefault();

                var value = $(event.target).parent().attr('data-value');

                if (value && this.items[value]) {
                    this.select(this.items[value]);
                }
            }

            // Show
            this.show = function() {
                var pos = $this.position();

                $dropdown.css({
                    top: pos.top + $this.outerHeight(),
                    left: pos.left
                });

                $dropdown.show();
            }

            // Hide
            this.hide = function() {
                $dropdown.hide();
            }

            // Request
            this.request = function() {
                clearTimeout(this.timer);

                this.timer = setTimeout(function(object) {
                    object.source($(object).val(), $.proxy(object.response, object));
                }, 200, this);
            }

            // Response
            this.response = function(json) {
                var html = '';
                var category = {};
                var name;
                var i = 0, j = 0;

                if (json.length) {
                    for (i = 0; i < json.length; i++) {
                        // update element items
                        this.items[json[i]['value']] = json[i];
                            // ungrouped items
                            html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
                    }

                }

                if (html) {
                    this.show();
                } else {
                    this.hide();
                }

                $dropdown.html(html);
            }

            $dropdown.on('click', '> li > a', $.proxy(this.click, this));
            $this.after($dropdown);
        });
    }
})(window.jQuery);
