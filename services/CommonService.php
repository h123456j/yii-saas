<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/11
 * Time: 9:44
 */

namespace app\services;


use app\services\base\BaseService;
use common\error\Error;
use yii\base\Exception;
use yii\helpers\VarDumper;

class CommonService extends BaseService
{

    private $fileType = ['png', 'jpg', 'jpeg', 'gif'];

    /**
     * 文件上传
     * @return array
     * @throws Exception
     */
    public function upload()
    {
        $files = $_FILES['files'];
        $result = [];
        if (empty($files))
            throw  new Exception('文件不能为空', Error::FILE_FOR_EMPTY);
        $date = date('Y-m-d');
        $dir = _UPLOAD_ROOT_ . '/' . $date;

        if (!is_dir($dir))
            mkdir($dir);

        foreach ($files['name'] as $key => $item) {
            if (!empty($item)) {
                $ext = pathinfo($item, PATHINFO_EXTENSION);
                if (!in_array($ext, $this->fileType)) {
                    throw new Exception($item . '文件格式不合法', Error::FILE_FOR_ILLEGAL_TYPE);
                } else {
                    $temp = $files['tmp_name'][$key];
                    $fileName = md5($item . time()) . '.' . $ext;
                    $path = $dir . '/' . $fileName;
                    if (move_uploaded_file($temp, $path)) {
                        $result[] = [
                            'name' => $item,
                            'path' => '/uploads/' . $date . '/' . $fileName
                        ];
                    }
                }
            }
        }
        return $result;
    }

}