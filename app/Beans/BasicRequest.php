<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 02/10/2016
 * Time: 08:44 AM
 */

namespace App\Beans;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BasicRequest
{
    private $id;
    private $page;
    private $rows;
    private $request;
    private $data;

    public function __construct()
    {
        $this->id = 0;
        $this->page = 0;
        $this->rows = 0;
        $this->data = array();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param mixed $rows
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }


}