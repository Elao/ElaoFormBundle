/**
 * Collection
 *
 * @param {Element} element
 */
function Collection (element)
{
    this.element       = $(element);
    this.replaceKey    = new RegExp(this.element.data('collection'), 'g');
    this.currentKey    = this.count();
    this.allowAdd      = false;
    this.allowDelete   = false;
    this.min           = false;
    this.max           = false;
    this.limitMin      = false;
    this.limitMax      = false;
    this.htmlPrototype = null;
    this.addButton     = null;
    this.items         = null;

    this.parseItems();
    this.parseAdd();
    this.parseDelete();
    this.parseMin();
    this.parseMax();

    this.element.removeAttr('data-collection');
}

/**
 * Update limit
 */
Collection.prototype.updateLimit = function ()
{
    if (this.min) {
        this.limitMin = this.count() <= this.min;

        for (var i = this.items.length - 1; i >= 0; i--) {
            this.items[i].toggleDelete(!this.limitMin);
        }
    }

    if (this.max) {
        this.limitMax = this.count() >= this.max;

        this.addButton.toggle(!this.limitMax);
    }
}

/**
 * Get length of the collection
 *
 * @return {Number}
 */
Collection.prototype.count = function ()
{
    return this.element.children().length;
}

/**
 * Add a new item
 */
Collection.prototype.add = function ()
{
    if (this.allowAdd && !this.limitMax) {
        var item = this.getPrototype();

        this.items.push(item);
        this.element.append(item.element);
        this.currentKey++;

        this.element.trigger("collection:added", [item]);
    }
};

/**
 * Delete an existing item
 *
 * @param {CollectionItem} item
 */
Collection.prototype.remove = function (item)
{
    var index = this.items.indexOf(item);

    if (this.allowDelete && !this.limitMin && index >= 0) {

        this.items = this.items.slice(0, index).concat(this.items.slice(index+1));

        item.element.remove();

        this.element.trigger("collection:deleted", [item]);
    }
};

/**
 * Get a new item from the HTML prototype
 *
 * @return {Element}
 */
Collection.prototype.getPrototype = function ()
{
    return new CollectionItem(this, $(this.htmlPrototype.replace(this.replaceKey, this.currentKey)));
};

/**
 * Parse add button
 */
Collection.prototype.parseAdd = function()
{
    var addButtonId = this.element.data('add');

    this.htmlPrototype = this.element.data('prototype');
    this.element.removeAttr('data-prototype');

    if (addButtonId) {
        this.allowAdd  = true;
        this.addButton = $('#' + addButtonId);
        this.addButton.on('click', this.add.bind(this));
        this.element.removeAttr('data-add');
    }
};

/**
 * Parse add button
 */
Collection.prototype.parseDelete = function()
{
    if (this.element.data('delete')) {
        this.allowDelete = true;
        this.element.removeAttr('data-delete');
    }
};

/**
 * Parse Mininum
 */
Collection.prototype.parseMin = function()
{
    var min = this.element.data('collection-min');

    if (min) {
        this.min = min;
        this.element.on('collection:deleted', this.updateLimit.bind(this));
        this.element.removeAttr('data-collection-min');
        this.updateLimit();
    }
};

/**
 * Parse Maximum
 */
Collection.prototype.parseMax = function()
{
    var max = this.element.data('collection-max');

    if (max) {
        this.max = max;
        this.element.on('collection:added', this.updateLimit.bind(this));
        this.element.removeAttr('data-collection-max');
        this.updateLimit();
    }
};

/**
 * Parse Items
 *
 * @return {Array}
 */
Collection.prototype.parseItems = function()
{
    if (!this.items) {
        this.items = [];

        var items = this.element.children(),
            length = items.length;

        for (var i = 0; i < length; i++) {
            this.items.push(new CollectionItem(this, items[i]));
        }
    }
};

/**
 * Collection Item
 *
 * @param {Element} element
 */
function CollectionItem (collection, element)
{
    this.collection = collection;
    this.element    = element;

    var deleteButton = $('[data-delete="' + this.element[0].id + '"]', element);

    if (this.collection.allowDelete && deleteButton) {
        this.deleteButton = deleteButton;
        this.deleteButton.on('click', this.remove.bind(this));
    }
}

/**
 * Remove item from collection
 */
CollectionItem.prototype.remove = function()
{
    this.collection.remove(this);
};

/**
 * Toggle delete
 */
CollectionItem.prototype.toggleDelete = function(toggle)
{
    if (this.deleteButton) {
        this.deleteButton.toggle(toggle);
    }
};
