/**
 * Created by huangj06 on 2017/10/20.
 */


$(document).ready(function () {
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
    var padding = 0;
    for (var i = 0; i < level; i++) {
        padding += 35;
    }
    $.each(data, function (key, item) {
        if (item['pid'] == 0) {
            level = 0;
            html += '<tr data-level="' + level + '"><td class="td_nav td_' + item['pid'] + '" data-id="' + item['id'] + '" data-hide="1">';
            html += '<span style="padding-right: 10px;" class="glyphicon glyphicon-folder-open"></span>' + item['title'] + '</td>';
        } else {
            html += '<tr data-level="' + level + '"><td class="td_nav td_' + item['pid'] + '" data-id="' + item['id'] + '" data-hide="1" style="padding-left: ' + padding + 'px;">';
            html += '|--<span style="padding: 0 5px;" class="glyphicon glyphicon-file"></span>' + item['title'] + '</td>';
        }
        html += '<td data-id="' + item['id'] + '" data-tree-code="' + item['tree_code'] + '"><span style="padding: 0 5px;" class="span-add glyphicon glyphicon-plus"></span>|';
        html += '<span style="color: #337AB7;padding: 0 5px;" class="span-edit glyphicon glyphicon-pencil"></span>|';
        html += '<span style="color: #ff0000;padding: 0 5px;" class="span-del glyphicon glyphicon-trash"></span></td></tr>';
        if (item['_child'].length > 0) {
            level += 1;
            html += menuHtml(item['_child'], level);
        }
    });
    return html;
}

