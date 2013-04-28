(function ($) {
    var defaults = {
        tQueueTitle: 'Queue',
        tUniversityIdentification: 'University Identification',
        tPrint: 'Print',
        tDone: 'Done',
        tCancel: 'Cancel',
        tSell: 'Sell',
        tHold: 'Hold',
        tUnhold: 'Unhold',
        tHideHold: 'Hide Hold',
        tUndoLastSelling: 'Undo Last Selling',
        tPrintNext: 'Print Next',
        tNotFoundInQueue: '<i><b>{{ name }}</b> was not found in the queue.</i>',
        tAddToQueue: 'Add to queue',

        translateStatus: function (status) {return status},
        sendToSocket: function (text) {},
    };

    var lastPrinted = 0;
    var lastSold = 0;

    var methods = {
        init : function (options) {
            var settings = $.extend(defaults, options);
            var $this = $(this);
            $(this).data('queueSettings', settings);

            _init($this);
            return this;
        },
        show : function (options) {
            var permanent = options == undefined || options.permanent == undefined ? true : options.permanent;
            currentView = permanent ? 'queue' : currentView;
            $(this).permanentModal({closable: !permanent});

            var $this = $(this);

            $(this).find('tbody tr').each(function () {
                _showActions($this, $(this), $(this).data('info'));
            });
            return this;
        },
        hide : function (options) {
            $(this).permanentModal('hide');
            return this;
        },
        updateQueue : function (data) {
            _updateQueue($(this), data);
            return this;
        },
        updateQueueItem : function (data) {
            _updateQueueItem($(this), data);
            return this;
        },
        setLastSold : function (data) {
            lastSold = data;
            $(this).find('.undoLastSelling').toggle(lastSold > 0);
            return this;
        },
        gotBarcode : function (barcode) {
            _gotBarcode($(this), barcode);
            return this;
        },
    };

    $.fn.queue = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || ! method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' +  method + ' does not exist on $.queue');
        }
    };

    $.queue = function (options) {
        return $('<div>').queue(options);
    }

    function _init($this) {
        var settings = $this.data('queueSettings');

        $this.addClass('modal fade queueModal').html('').append(
            $('<div>', {'class': 'modal-header'}).append(
                $('<a>', {'class': 'close'}).html('&times;').click(function () {$this.modal('hide')}),
                $('<div>', {'class': 'form-search'}).append(
                    $('<div>', {'class': 'input-append pull-right'}).append(
                        filterText = $('<input>', {'type': 'text', 'class': 'input-medium search-query filterText', 'placeholder': settings.tUniversityIdentification}),
                        clearFilter = $('<span>', {'class': 'add-on'}).css('cursor', 'pointer').append(
                            $('<span>', {'class': 'icon-remove'})
                        )
                    )
                ),
                $('<h3>').html(settings.tQueueTitle)
            ),
            $('<div>', {'class': 'modal-body'}).append(
                $('<table>', {'class': 'table table-striped table-bordered'}).append(
                    $('<thead>').append(
                        $('<tr>').append(
                            $('<th>', {'class': 'number'}).html('Num'),
                            $('<th>', {'class': 'name'}).html('Name'),
                            $('<th>', {'class': 'status'}).html('Status'),
                            $('<th>', {'class': 'actions'}).html('Action')
                        )
                    ),
                    $('<tbody>')
                )
            ),
            $('<div>', {'class': 'modal-footer'}).append(
                $('<label>', {'class': 'checkbox pull-left'}).append(
                    hideHold = $('<input>', {'class': 'hideHold', 'type': 'checkbox', 'checked': 'checked'}),
                    settings.tHideHold
                ),
                undoLastSelling = $('<button>', {'class': 'btn btn-danger hide undoLastSelling', 'data-key': '117'}).append(
                    $('<i>', {'class': 'icon-arrow-left icon-white'}),
                    settings.tUndoLastSelling + ' - F6'
                ),
                printNext = $('<button>', {'class': 'btn btn-success', 'data-key': '118'}).append(
                    $('<i>', {'class': 'icon-print icon-white'}),
                    settings.tPrintNext + ' - F7'
                )
            )
        );

        hideHold.change(function () {
            $this.find('tbody tr').each(function () {
                _toggleVisibility($this, $(this), $(this).data('info'));
            });
        });

        clearFilter.click(function () {
            filterText.val('');
            filterText.trigger('keyup');
        });

        filterText.keyup(function () {
            var filter = $(this).val().toLowerCase();
            var pattern = new RegExp(/[a-z][0-9]{7}/);

            if (pattern.test(filter)) {
                var found = false;
                $this.find('tbody tr').each(function () {
                    if ($(this).data('info').university_identification.toLowerCase().indexOf(filter) == 0)
                        found = true;
                    return !found;
                });

                if (!found) {
                    $this.find('tbody').append(
                        $('<tr>', {'id': 'addToQueue'}).append(
                            $('<td>', {'class': 'number'}),
                            $('<td>', {'class': 'name'}).html(
                                settings.tNotFoundInQueue.replace('{{ name }}', filter)
                            ),
                            $('<td>', {'class': 'status'}),
                            $('<td>', {'class': 'actions'}).append(
                                $('<button>', {'class': 'btn btn-success'}).html(settings.tAddToQueue).data('id', filter).click(function () {
                                    settings.sendToSocket(
                                        JSON.stringify({
                                            'command': 'action',
                                            'action': 'addToQueue',
                                            'universityIdentification': filter,
                                        })
                                    );
                                })
                            )
                        )
                    );
                } else {
                    $this.find('tbody #addToQueue').remove();
                }
            } else {
                $this.find('tbody #addToQueue').remove();
            }

            $this.find('tbody tr').each(function () {
                _toggleVisibility($this, $(this), $(this).data('info'));
            });
        });

        printNext.click(function () {
            $this.find('tbody tr').each(function () {
                if ($(this).data('info').status == 'signed_in' && $(this).data('info').id > lastPrinted) {
                    lastPrinted = $(this).data('info').id;
                    $(this).find('.startCollecting').click();
                }
            });
        });

        undoLastSelling.click(function () {
            if (lastSold > 0) {
                settings.sendToSocket(
                    JSON.stringify({
                        'command': 'action',
                        'action': 'undoSelling',
                        'id': lastSold,
                    })
                );
            }
            $(this).hide();
        });
    }

    function _updateQueue($this, data) {
        var settings = $this.data('queueSettings');
        var tbody = $this.find('tbody');
        var inQueue = [];

        var currentList = new Object();
        tbody.find('tr').each(function () {
            currentList[$(this).attr('id')] = $(this);
        });

        $(data).each(function () {
            inQueue.push(this.id);

            var item = currentList['item-' + this.id];
            if (undefined == item) {
                item = _createItem($this, settings, this);
                tbody.append(item);
            } else {
                _updateItem($this, settings, item, this)
            }

            _toggleVisibility($this, item, this);
        });

        tbody.find('tr').each(function () {
            var pos = $.inArray($(this).data('info').id, inQueue)
            if (pos < 0) {
                $(this).remove();
            } else {
                inQueue.splice(pos, 1);
            }
        });
    }

    function _updateQueueItem($this, data) {
        var settings = $this.data('queueSettings');
        var item = $this.find('tbody #item-' + data.id);

        if (data.status == 'sold') {
            item.remove();
            return;
        }

        if (item.length == 0) {
            item = _createItem($this, settings, data);
            $this.find('tbody').append(item);
        } else {
            _updateItem($this, settings, item, data)
        }

        _toggleVisibility($this, item, data);
    }

    function _showActions($this, row, data) {
        switch (data.status) {
            case 'signed_in':
                if (currentView == 'sale' || currentView == 'collect') {
                    row.find('.hold').show();
                    row.find('.startCollecting, .stopCollecting, .cancelCollecting, .startSelling, .cancelSelling, .unhold').hide();
                } else {
                    row.find('.startCollecting, .hold').show();
                    row.find('.stopCollecting, .cancelCollecting, .startSelling, .cancelSelling, .unhold').hide();
                }
                break;
            case 'collecting':
                row.find('.stopCollecting, .cancelCollecting, .hold').show();
                row.find('.startCollecting, .startSelling, .cancelSelling, .unhold').hide();
                break;
            case 'collected':
                if (currentView == 'sale' || currentView == 'collect') {
                    row.find('.hold').show();
                    row.find('.startCollecting, .stopCollecting, .cancelCollecting, .startSelling, .cancelSelling, .unhold').hide();
                } else {
                    row.find('.startSelling, .hold').show();
                    row.find('.startCollecting, .stopCollecting, .cancelCollecting, .cancelSelling, .unhold').hide();
                }
                break;
            case 'selling':
                row.find('.cancelSelling, .hold').show();
                row.find('.startCollecting, .stopCollecting, .cancelCollecting, .startSelling, .unhold').hide();
                break;
            case 'hold':
                row.find('.unhold').show();
                row.find('.startCollecting, .stopCollecting, .cancelCollecting, .startSelling, .cancelSelling, .hold').hide();
                break;
        }

        if (data.locked)
            row.find('button').addClass('disabled');
        else
            row.find('button').removeClass('disabled');
    }

    function _updateItem($this, settings, row, data) {
        var previousStatus = '';
        if (row.data('info'))
            previousStatus = row.data('info').status;

        row.find('.number').html(data.number);
        row.find('.name').html('').append(
            data.name,
            ' ',
            (data.payDesk ? $('<span>', {'class': 'label label-info'}).html(data.payDesk) : '')
        );
        row.find('.status').html(settings.translateStatus(data.status));
        row.data('info', data);

        if (previousStatus != data.status)
            _showActions($this, row, data);
    }

    function _createItem($this, settings, data) {
        var row = $('<tr>', {'id': 'item-' + data.id}).append(
            $('<td>', {'class': 'number'}),
            $('<td>', {'class': 'name'}),
            $('<td>', {'class': 'status'}),
            $('<td>', {'class': 'actions'}).append(
                startCollecting = $('<button>', {'class': 'btn btn-success startCollecting'}).html(settings.tPrint).hide(),
                stopCollecting = $('<button>', {'class': 'btn btn-success stopCollecting'}).html(settings.tDone).hide(),
                cancelCollecting = $('<button>', {'class': 'btn btn-danger cancelCollecting'}).html(settings.tCancel).hide(),
                startSelling = $('<button>', {'class': 'btn btn-success startSelling'}).html(settings.tSell).hide(),
                cancelSelling = $('<button>', {'class': 'btn btn-danger cancelSelling'}).html(settings.tCancel).hide(),
                hold = $('<button>', {'class': 'btn btn-warning hold'}).html(settings.tHold).hide(),
                unhold = $('<button>', {'class': 'btn btn-warning unhold'}).html(settings.tUnhold).hide()
            )
        );

        _updateItem($this, settings, row, data);

        startCollecting.click(function () {
            if ($(this).is('.disabled'))
                return;
            settings.sendToSocket(
                JSON.stringify({
                    'command': 'action',
                    'action': 'startCollecting',
                    'id': $(this).closest('tr').data('info').id,
                })
            );
        });

        stopCollecting.click(function () {
            if ($(this).is('.disabled'))
                return;
            settings.sendToSocket(
                JSON.stringify({
                    'command': 'action',
                    'action': 'stopCollecting',
                    'id': $(this).closest('tr').data('info').id,
                })
            );
        });

        cancelCollecting.click(function () {
            if ($(this).is('.disabled'))
                return;
            settings.sendToSocket(
                JSON.stringify({
                    'command': 'action',
                    'action': 'cancelCollecting',
                    'id': $(this).closest('tr').data('info').id,
                })
            );
        });

        startSelling.click(function () {
            if ($(this).is('.disabled'))
                return;
            settings.sendToSocket(
                JSON.stringify({
                    'command': 'action',
                    'action': 'startSelling',
                    'id': $(this).closest('tr').data('info').id,
                })
            );
        });

        cancelSelling.click(function () {
            if ($(this).is('.disabled'))
                return;
            settings.sendToSocket(
                JSON.stringify({
                    'command': 'action',
                    'action': 'cancelSelling',
                    'id': $(this).closest('tr').data('info').id,
                })
            );
        });

        hold.click(function () {
            if ($(this).is('.disabled'))
                return;
            settings.sendToSocket(
                JSON.stringify({
                    'command': 'action',
                    'action': 'hold',
                    'id': $(this).closest('tr').data('info').id,
                })
            );
        });

        unhold.click(function () {
            if ($(this).is('.disabled'))
                return;
            settings.sendToSocket(
                JSON.stringify({
                    'command': 'action',
                    'action': 'unhold',
                    'id': $(this).closest('tr').data('info').id,
                })
            );
        });

        return row;
    }

    function _toggleVisibility($this, row, data) {
        var show = true;
        if ($this.find('.hideHold').is(':checked') && data.status == 'hold')
            show = false;

        var filter = $this.find('.filterText').val();
        if (filter.length > 0) {
            filter = filter.toLowerCase();
            show = false;
            if (data.name.toLowerCase().indexOf(filter) >= 0 || data.university_identification.toLowerCase().indexOf(filter) >= 0)
                show = true
        }

        if (show)
            $this.find('tbody #addToQueue').remove();

        row.toggle(show);
    }

    function _gotBarcode($this, barcode) {
        var settings = $this.data('queueSettings');

        $this.find('tbody tr:visible').each(function () {
            if ($(this).data('info').barcode == barcode) {
                switch ($(this).data('info').status) {
                    case 'collecting':
                        $(this).find('.stopCollecting').click();
                        break;
                    case 'collected':
                        $(this).find('.startSelling').click();
                        break;
                }
            }
        });
    }
})(jQuery);