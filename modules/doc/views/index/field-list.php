<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>表单属性配置</title>
    <script type="text/javascript" src="https://lib.sinaapp.com/js/jquery/2.0.2/jquery-2.0.2.min.js"></script>
</head>
<body>
<style type="text/css">
    #div-body {
        width: 96%;
        margin: 5px 2%;
        height: 100%;
    }

    #div-left {
        position: fixed;
        width: 600px;

    }

    #div-right {
        float: left;
        width: 600px;
        margin: 5px 5px 20px 600px;
    }

    #btn-submit, #btn-clean,#btn-look {
        width: 160px;
        height: 40px;
        line-height: 40px;
        background-color: #0a73a7;
        color: #c2cad8;
        font-size: 16px;
        border: none;
    }

    .field_add {
        color: #0a6aa1;
    }

    #field_textarea {
        width: 90%;
        min-height: 650px;
        margin-top: 10px;
    }
</style>
<div id="div-body">
    <input type="hidden" id="execute-url" value="<?= $url; ?>">
    <div id="div-left">
        <select id="template_select" style="width:90%;height: 50px;margin-top:10px;font-size: 16px;">
            <?php foreach ($fieldTemplate as $template) { ?>
                <option value="<?= $template['id'] ?>"><?= $template['name'] . '【' . $template['code'] . '】【'.$template['id'].'】' ?></option>
            <?php } ?>
        </select>
        <textarea id="field_textarea">
        </textarea>
        <button id="btn-submit">提交保存</button>
        <button id="btn-clean">清空</button>
        <button id="btn-look">查看已选择</button>
    </div>
    <div id="div-right">
        <?php
        foreach ($fieldList as $groupId => $group) {

            ?>
            <p><?= $group['group_name'] ?></p>
            <?php
            foreach ($group['data'] as $item) {
                ?>
                <li class="li-task">
                    <label><?= '标签[' . $item['tab_id'] . ']- 分组[' . $groupId . ']-模块[' . $item['module_id'] . ']-' . $item['name_chn'] ?></label>
                    <label class="field_add"
                           field_data="<?= $item['tab_id'] . '-' . $groupId . '-' . $item['module_id'] . '-' . $item['id'] . '-' . $item['name_chn'] ?>">【添加】</label>
                </li>
                <?php
            }
        }
        ?>
    </div>
</div>
</body>

<script type="text/javascript">
    $(function () {
        $(".field_add").on("click", function (el) {
            var _this = $(this);
            var data = _this.attr('field_data');
            var fieldData = $("#field_textarea").val();
            if (fieldData.length == 8 || fieldData == '' || fieldData == null) {
                fieldData = data;
            } else {
                fieldData += ',' + data;
            }
            $("#field_textarea").val(fieldData);
        });

        $("#btn-submit").on("click", function (el) {
            var templateId = $("#template_select").val();
            var data = $("#field_textarea").val();
            var url = $("#execute-url").val();
            $.ajax({
                url: "/doc/index/deal-fields",
                type: "post",
                dataType: "json",
                data: {templateId: templateId, data: data},
                success: function (data) {
                    if (data.result) {
                        alert('操作成功');
                    } else {
                        alert(data.message);
                    }
                },
                error: function () {
                    alert('服务异常');
                }
            });
        });

        $("#btn-clean").on('click', function () {
            $("#field_textarea").val('');
        });
    })
</script>
</html>