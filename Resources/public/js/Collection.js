function Collection (element)
{
    this.element       = $(element);
    this.addButton     = false;
    this.htmlPrototype = this.element.data('prototype');
    this.replaceKey    = new RegExp(this.element.data('collection'), 'g');
    this.currentKey    = this.count();

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

    this.element.removeAttr('data-prototype');
    this.element.removeAttr('data-collection');
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
