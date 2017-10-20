/**
 * Created by huangj06 on 2017/10/20.
 */


$(document).ready(function () {
    json = JSON.parse(json);
    loadShow();
    var html = menuHtml(json);
    $("#menu-list-body").html(html);
    loadHide();
    console.log(html);
});

/**
 * 改造导航栏html
 * @param data
 * @param level
 * @returns {string}
 */
function menuHtml(data, level) {
    var html = '';
    level = level || 0;
    console.log(level);
    var separator = '';
    for (i = 0; i < level; i++) {
        separator += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
    }
    separator += '|--';
    $.each(data, function (key, item) {
        if (item['pid'] == 0) {
            level=0;
            html += '<tr><td class="td_'+item['pid']+'" data-id="'+item['id']+'"><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;&nbsp;' + item['title'] + '</td>';
        } else {
            html += '<tr><td class="td_'+item['pid']+'" data-id="'+item['id']+'">' + separator +'&nbsp;<span class="glyphicon glyphicon-file"></span>&nbsp;'+ item['title'] + '</td>';
        }
        html += '<td><span style="" class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;|&nbsp;';
        html += '<span style="color: #337AB7;" class="glyphicon glyphicon-pencil"></span>&nbsp;|&nbsp;&nbsp;';
        html += '<span style="color: #ff0000;" class="glyphicon glyphicon-trash"></span></td></tr>';
        if (item['_child'].length > 0) {
            level += 1;
            html += menuHtml(item['_child'], level);
        }
    });
    return html;
}

