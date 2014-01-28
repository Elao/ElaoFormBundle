function Collection (element)
{
    this.element       = $(element);
    this.addButton     = false;
    this.htmlPrototype = this.element.data('prototype');
    this.replaceKey    = new RegExp(this.element.data('collection'), 'g');
    this.currentKey    = this.count();
    this.min           = this.element.data('collection-min');
    this.max           = this.element.data('collection-max');

    var addButton    = this.element.data('add'),
        deleteButton = this.element.data('delete');

    if (addButton) {
        this.addButton = $('#' + addButton);
        this.addButton.on('click', this.add.bind(this));
        this.element.removeAttr('data-add');
    }

    if (deleteButton) {
        this.element.on('click', '.' + deleteButton, this.remove.bind(this));
        this.element.removeAttr('data-delete');
    }

    this.element.removeAttr('data-collection-min');
    this.element.removeAttr('data-collection-max');
    this.element.removeAttr('data-prototype');
    this.element.removeAttr('data-collection');

    this.element.on('collection:added', this.handleCount.bind(this));
    this.element.on('collection:deleted', this.handleCount.bind(this));
    this.handleCount();
}

Collection.prototype.handleCount = function ()
{
    if (this.min) {
        if (this.count() > this.min) {
            $('[data-delete]', this.element).each(function (key, element) { $(element).show() });
        } else {
            $('[data-delete]', this.element).each(function (key, element) { $(element).hide() });
        }
    }

    if (this.max) {
        if (this.count() < this.max) {
            this.addButton.show();
        } else {
            this.addButton.hide();
        }
    }
}

Collection.prototype.count = function ()
{
    return this.element.children().length;
}

Collection.prototype.add = function ()
{
    var item = this.getPrototype();

    this.element.append(item);
    this.currentKey++;

    this.element.trigger("collection:added", [item]);
};

Collection.prototype.remove = function (e)
{
    var item = $("#" + $(e.target).data('delete'));

    item.remove();

    this.element.trigger("collection:deleted", [item]);
};

Collection.prototype.getPrototype = function ()
{
    return $(this.htmlPrototype.replace(this.replaceKey, this.currentKey));
};
