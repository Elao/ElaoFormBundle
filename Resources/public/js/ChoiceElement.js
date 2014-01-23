function ChoiceElement(id)
{
    this.element  = document.getElementById(id);
    this.expanded = this.element.tagName.toLowerCase() != "select";
    this.options  = this.element.getElementsByTagName(this.expanded ? 'input' : 'option');
    this.multiple = this.expanded ? this.isOptionMultiple() : this.element.multiple;

    this.jqueryElement = $(this.element);

    this.attachEvents();
    this.processValue();
}

ChoiceElement.prototype.getValue = function()
{
    return this.value;
};

ChoiceElement.prototype.setValue = function(value)
{
    if (this.multiple) {

    } else {
        this.element.value = value;
    }
};

ChoiceElement.prototype.isOptionMultiple = function()
{
    return this.options.length ? this.options.item(0).type.toLowerCase() == "checkbox" : false;
};

ChoiceElement.prototype.attachEvents = function()
{
    if (this.expanded) {
        for (var i = this.options.length - 1; i >= 0; i--) {
            this.options[i].onchange = this.valueChanged.bind(this);
        }
    } else {
        this.element.onchange = this.valueChanged.bind(this);
    }
};

ChoiceElement.prototype.valueChanged = function(e)
{
    this.processValue();
    this.trigger('choice-change');
};

ChoiceElement.prototype.processValue = function()
{
    if (this.multiple || this.expanded) {
        this.value = this.getOptionsValues();
    } else {
        this.value = this.element.value;
    }

    console.log(this.value);
};

ChoiceElement.prototype.getOptionsValues = function()
{
    var values = [];
    for (var i = this.options.length - 1; i >= 0; i--) {

        var option = this.options.item(i);

        if(this.isOptionSelected(option)) {

            if (!this.multiple) {
                return option.value;
            }

            values.push(option.value);
        }
    }

    return values;
};

ChoiceElement.prototype.isOptionSelected = function(option)
{
    return this.expanded ? option.checked : option.selected;
};