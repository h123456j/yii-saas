/**
 * Created by huangj06 on 2017/10/20.
 */


$(document).ready(function () {

    if ($("#module-tree").length > 0) {
        json = JSON.parse(json);
        loadShow();
        var html = menuHtml(json);
        $("#menu-list-body").html(html);
        loadHide();
        //折叠展开操作处理
        $(document).on('click', '.td_nav', function () {
            var id = $(this).attr('data-id');
            var hide = $(this).attr('data-hide');
            hide == 1 ? $(this).attr('data-hide', '0') : $(this).attr('data-hide', '1');
            var childList = document.getElementsByClassName('td_' + id);
            if (childList.length > 0)
                menuToggle(childList, hide);
        });
    } else {
        var groupList = $(".div-group-list")
        var hashTable = new HashTable();
    }

    $(".li-group").click(function () {
        var _this = $(this);
        var id = _this.attr('data-id');
        if (_this.hasClass('li-selected')) {
            _this.removeClass('li-selected');
            hashTable.remove(id);
        } else {
            _this.addClass('li-selected');
            hashTable.add(id, _this.html());
        }
    });

    $("#input-group").click(function () {
        $(".li-group").removeClass('li-selected');
        var groupIds = $(this).val();
        if (groupIds.length > 0) {
            var temp = groupIds.split(",");
            $.each(temp, function (key, item) {
                $("#group-" + item).addClass('li-selected');
            });
        }
        groupList.show();
    });

    $(".group-close").click(function () {
        groupList.hide();
    });

    $(".group-reset").click(function () {
        $(".li-group").removeClass('li-selected');
        hashTable.clear();
    });

    $(".group-confirm").click(function () {
        var arr = hashTable.getKeys();
        $("#input-group").val(arr.join());
        groupList.hide();
    });

});

function menuToggle(data, hide) {
    $.each(data, function (key, item) {
        hide == 1 ? $(item).attr('data-hide', '0') : $(item).attr('data-hide', '1');
        hide == 1 ? $(item).parent("tr").hide() : $(item).parent("tr").show();
        var id = $(item).attr('data-id');
        var childList = document.getElementsByClassName('td_' + id);
        if (childList.length > 0)
            menuToggle(childList, hide);
    })
}

/**
 * 改造导航栏html
 * @param data
 * @param level
 * @returns {string}
 */
function menuHtml(data, level) {
    var html = '';
    level = level || 0;
    var padding = level * 30;
    $.each(data, function (key, item) {
        if (item['pid'] == 0) {
            level = 0;
            html += '<tr data-level="' + level + '"><td class="td_nav td_' + item['pid'] + '" data-id="' + item['id'] + '" data-hide="1">';
            html += '<span style="padding-right: 10px;" class="glyphicon glyphicon-folder-open"></span>' + item['title'] + '</td>';
        } else {
            html += '<tr data-level="' + level + '"><td class="td_nav td_' + item['pid'] + '" data-id="' + item['id'] + '" data-hide="1" style="padding-left: ' + padding + 'px;">';
            html += '|--<span style="padding: 0 5px;" class="glyphicon glyphicon-file"></span>' + item['title'] + '</td>';
        }
        html += '<td data-id="' + item['id'] + '" data-tree-code="' + item['tree_code'] + '">';
        html += '<span data-title="新增导航栏" data-url="'+item['addUrl']+'" style="padding: 0 5px;" class="span-add content-modal glyphicon glyphicon-plus"></span>|';
        html += '<span data-title="导航栏编辑" data-url="'+item['editUrl']+'" style="color: #337AB7;padding: 0 5px;" class="span-edit content-modal glyphicon glyphicon-pencil"></span>|';
        html += '<span style="color: #ff0000;padding: 0 5px;" class="span-del glyphicon glyphicon-trash"></span></td></tr>';
        if (item['_child'].length > 0) {
            level += 1;
            html += menuHtml(item['_child'], level);
        }
    });
    return html;
}


function HashTable() {
    var size = 0;
    var entry = new Object();
    this.add = function (key, value) {
        if (!this.containsKey(key)) {
            size++;
        }
        entry[key] = value;
    },
        this.getValue = function (key) {
            return this.containsKey(key) ? entry[key] : null;
        };
    this.remove = function (key) {
        if (this.containsKey(key) && (delete entry[key])) {
            size--;
        }
    };
    this.containsKey = function (key) {
        return (key in entry);
    };
    this.containsValue = function (value) {
        for (var prop in entry) {
            if (entry[prop] == value) {
                return true;
            }
        }
        return false;
    };
    this.getValues = function () {
        var values = new Array();
        for (var prop in entry) {
            values.push(entry[prop]);
        }
        return values;
    };
    this.getKeys = function () {
        var keys = new Array();
        for (var prop in entry) {
            keys.push(prop);
        }
        return keys;
    };
    this.getSize = function () {
        return size;
    };
    this.clear = function () {
        size = 0;
        entry = new Object();
    };
}

