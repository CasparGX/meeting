<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {

    protected function _initialize()
    {

		header("Access-Control-Allow-Origin:*");
		header("Access-Control-Allow-Headers:Content-Type");
		header("Access-Control-Allow-Methods:*");

    }
}