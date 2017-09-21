<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/21
 * Time: 14:52
 */

namespace app\component\model;


class Page extends DataModel
{

    private $page;
    private $size;
    private $count;
    private $totalPage;


    public function __construct($page = 1, $size = 30, $count = 0, $config = [])
    {
        $page = (int)$page;
        $size = (int)$size;
        $this->page = $page >= 1 ? $page : 1;
        $this->size = $page >= 1 ? $size : 30;
        $this->count = (int)$count;
        parent::__construct($config);
    }


    public function scenarioFields()
    {
        return [
            'default' => [
                'current' => 'page',
                'total' => 'totalPage',
                'count',
                'size'
            ]
        ];
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getTotalPage()
    {
        return $this->totalPage;
    }

    /**
     * @param mixed $totalPage
     */
    public function setTotalPage($totalPage)
    {
        $this->totalPage = $totalPage;
    }


}