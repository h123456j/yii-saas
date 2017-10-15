<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 19:59
 */

namespace app\component\http;


use yii\base\Component;

class Curl extends Component
{

    private $_ch;
    private $response;

    public $options;

    private $_config = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADER => true,
        CURLOPT_VERBOSE => true,
        CURLOPT_AUTOREFERER => true,
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20110619 Firefox/5.0'
    ];

    public function init()
    {
        try{
            $this->_ch=curl_init();
            $options=is_array($this->options)?array_merge($this->options,$this->_config):$this->_config;
            $this->setOptions($options);
        }catch (\Exception $e){
           exit('curl 组件初始化失败');
        }
    }

    private function exec($url)
    {
        $this->setOption(CURLOPT_URL, $url);
        $this->response = curl_exec($this->_ch);
        if (!curl_errno($this->_ch)) {
            $headerSize = curl_getinfo($this->_ch, CURLINFO_HEADER_SIZE);
            return substr($this->response, $headerSize);
        } else {
            throw new \Exception(curl_error($this->_ch));
        }
    }

    public function get($url, $params = [])
    {
        $this->setOption(CURLOPT_HTTPGET, true);
        $url = strpos($url, '?') === false ? '?' : '' . http_build_query($params);
        return $this->exec($url);
    }

    public function post($url, $data = [], $json = false)
    {
        $this->setOption(CURLOPT_POST, true);
        if ($json) {
            $data = json_encode($data);
            $this->setOption(CURLOPT_HTTPHEADER, [
                'Content-Type:application/json'
            ]);
            $this->setOption(CURLOPT_POSTFIELDS, $data);
        } else {
            $this->setOption(CURLOPT_POSTFIELDS, http_build_query($data));
        }
        return $this->exec($url);
    }

    public function setOptions($options = [])
    {
        curl_setopt_array($this->_ch, $options);
        return $this;
    }

    public function setOption($option, $value)
    {
        curl_setopt($this->_ch, $option, $value);
        return $this;
    }

}