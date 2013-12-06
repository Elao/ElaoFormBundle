function Other (element, toggle)
{
    this.element  = $(element);
    this.trigger  = this.find(this.element.data('other-trigger'));
    this.target   = $('#' + this.element.data('other-target'));
    this.value    = eval(this.element.data('other-value'));
    this.multiple = $.isArray(this.value);
    this.type     = this.guessType(element);

    this.normalizeValue();

    this.trigger.on('change', this.update.bind(this));

    this.element.removeAttr('data-other-target');
    this.element.removeAttr('data-other-trigger');
    this.element.removeAttr('data-other-value');

    this.update();
}

Other.prototype.update = function (e)
{
    var value = this.getCurrentValue(e),
        match = this.match(value);

    this.target.toggleClass('hide', !match);

    this.element.trigger("other:" + (match ? 'displayed' : 'hidden'), [this.element, this.target, value]);
};

Other.prototype.getCurrentValue = function (e)
{
    switch (this.type) {

        case 'checkbox':
            return this.toString(this.trigger.is(':checked'));

        case 'choice-expanded':
            for (var i = this.trigger.length - 1; i >= 0; i--) {
                var option = $(this.trigger[i]);
                if (option.is(':checked')) {
                    return option.val();
                }
            }
            break;

        case 'choice-expanded-multiple':
            var values = [];

            for (var i = this.trigger.length - 1; i >= 0; i--) {
                var option = $(this.trigger[i]);
                if (option.is(':checked')) {
                    values.push(option.val());
                }
            }

            return values;

        default:
            return this.element.val();
    }

    return null;
};

Other.prototype.match = function (value)
{
    var values = $.isArray(value);

    if (this.multiple && values) {

        for (var i = values.length - 1; i >= 0; i--) {
            if (this.value.indexOf(values[i]) >= 0) {
                return true;
            }
        }

        return false;
    } else if (this.multiple) {

        return this.value.indexOf(value) >= 0;
    } else if (values) {

        return value.indexOf(this.value) >= 0;
    }

    return value === this.value;
};

Other.prototype.guessType = function (element)
{
    return element.type ? element.type : element.getAttribute('data-type');
};

Other.prototype.toString = function (value)
{
    return value === null ? null : value.toString();
};

Other.prototype.normalizeValue = function ()
{
    if (this.multiple) {
        for (var i = this.value.length - 1; i >= 0; i--) {
            this.value[i] = this.toString(this.value[i]);
        }
    } else {
        this.value = this.toString(this.value);
    }
};

Other.prototype.find = function (selector)
{
    var element = $('[name="' + selector['name'] + '"]');

    if (element.length === 0) {
        element = $('#' + selector['id']);
    }

    return element;
};
