<?php
class IndexController extends Controller{
	public function index($page=1){
		$assign['title'] = ($page==1?"":("第".$page."页 - "))."首页";
		$this->display($assign, 'index');	
	}
}