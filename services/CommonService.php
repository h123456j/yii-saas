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
        if(empty($_FILES['files']))
            throw  new Exception('请先选择文件', Error::FILE_FOR_EMPTY);

        $files = $_FILES['files'];
        $result = [];
        $date = date('Y-m-d');

        $dir = _UPLOAD_ROOT_ . '/' . $date;
        if (!is_dir($dir))
            mkdir($dir);

        $data = [];
        foreach ($files['name'] as $key => $item) {
            if (!empty($item)) {
                $ext = pathinfo($item, PATHINFO_EXTENSION);
                if (!in_array(strtolower($ext), $this->fileType)) {
                    throw new Exception($item . '文件格式不合法', Error::FILE_FOR_ILLEGAL_TYPE);
                } else {
                    $data[] = [
                        'name' => $item,
                        'ext' => $ext,
                        'file' => $files['tmp_name'][$key]
                    ];
                }
            }
        }

        foreach ($data as $item) {
            $fileName = md5($item['name'] . time()) . '.' . $item['ext'];
            $path = $dir . '/' . $fileName;
            if (move_uploaded_file($item['file'], $path)) {
                $result[] = [
                    'name' => $item['name'],
                    'path' => '/uploads/' . $date . '/' . $fileName
                ];
            }
        }
        return $result;
    }

}