<?php
if(!defined("Yourphp")) exit("Access Denied");
class SitemapAction extends Action
{
	
	public function index()
	{
		$_GET['l'] = 'en';
		$this->display();
	}
}
?>