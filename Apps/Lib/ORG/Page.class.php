<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

class Page extends Think {
    // 起始行数
    public $firstRow	;
    // 列表每页显示行数
    public $listRows	;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 分页总页面数
    public $totalPages  ;
    // 总行数
    public $totalRows  ;
    // 当前页数
    public $nowPage    ;
    // 分页的栏的总页数
    public $coolPages   ;
    // 分页栏每页显示的页数
    public $rollPage   ;
	// 分页url定制
	public $urlrule;
 

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     +----------------------------------------------------------
     */
    public function __construct($totalRows,$listRows,$p='') {
        $this->totalRows = $totalRows;
        $this->parameter = $parameter;
        $this->rollPage = C('PAGE_ROLLPAGE') ? C('PAGE_ROLLPAGE') : 2;
        $this->listRows = !empty($listRows)?$listRows:C('PAGE_LISTROWS');
        $this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
		if (!define('PAGESTOTAL')) define('PAGESTOTAL', $this->totalPages);
        $this->coolPages  = ceil($this->totalPages/$this->rollPage);
		if($p){
			$this->nowPage =$p;
			}else{
			$this->nowPage  = !empty($_GET[C('VAR_PAGE')])?intval($_GET[C('VAR_PAGE')]):1;
		}
        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows*($this->nowPage-1);
    }
 
	public function  show($is_dynamic=''){
		if($this->totalRows == 0 OR $this->listRows == 0 OR $this->totalPages <= 1){
			return '';
		}
		$urlrule =  str_replace('%7B%24page%7D','{$page}',$this->urlrule); //urldecode	
		if(!$urlrule){		
			$p = C('VAR_PAGE');			
			$nowCoolPage      = ceil($this->nowPage/$this->rollPage);
			$url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
			$parse = parse_url($url);
			if(isset($parse['query'])) {
				parse_str($parse['query'],$params);
				unset($params[$p]);
				$urlrule   =  $parse['path'].'?'.http_build_query($params);
			}
            if($is_dynamic){
                $urlrule = $urlrule."&".$p.'={$page}';
            }else{
                $urlrule = $urlrule."".'{$page}.html';
            }
		}


		$pre_page = $this->nowPage-1;
		$next_page = $this->nowPage +1;
		
		if($this->nowPage >=$this->totalPages){
			$next_page =  $this->nowPage = $this->totalPages;
		}
		if($this->nowPage <= 1){
			$pre_page =  $this->nowPage = 1;
		}

		$output = '';
		$output .= '<a class="a1">'.$this->totalRows.L('page_item').'</a>';
		$output .= '<li><a class="page-first" href="'.$this->pageurl($urlrule, 1,$this->parameter).'">&lt|</a></li>';
		$output .= '<li><a class="page-prev" href="'.$this->pageurl($urlrule, $pre_page,$this->parameter).'">上一页</a></li>';
		$show_nums = $this->rollPage*2+1;// 显示页码的个数
	
		if($this->totalPages <= $show_nums){
			for($i = 1;$i<=$this->totalPages;$i++){
				if($i == $this->nowPage){
					$output .= '<li><a class="pageCur" href="javascript:;" pageCur="'.$this->pageurl($urlrule,$i,$this->parameter).'">'.$i.'</a></li>';
				}else{
					$output .= '<li><a href="'.$this->pageurl($urlrule,$i,$this->parameter).'">'.$i.'</a></li>';
				}
			}
		}else{
			if($this->nowPage < (1+$this->rollPage)){
				for($i = 1;$i<=$show_nums;$i++){
					if($i == $this->nowPage){
						$output .=  '<li><a class="pageCur" href="javascript:;" pageCur="'.$this->pageurl($urlrule,$i,$this->parameter).'">'.$i.'</a></li>';
					}else{
						$output .= '<li><a href="'.$this->pageurl($urlrule,$i,$this->parameter).'">'.$i.'</a></li>';
					}
				}			
			}else if($this->nowPage >= ($this->totalPages - $this->rollPage)){
				for($i = $this->totalPages - $show_nums ; $i <= $this->totalPages ; $i++){
					if($i == $this->nowPage){
						$output .=  '<li><a class="pageCur" href="javascript:;" pageCur="'.$this->pageurl($urlrule,$i,$this->parameter).'">'.$i.'</a></li>';
					}else{
						$output .= '<li><a href="'.$this->pageurl($urlrule,$i,$this->parameter).'">'.$i.'</a></li>';
					}
				}
			}else{
				$start_page = $this->nowPage - $this->rollPage;
				$end_page = $this->nowPage + $this->rollPage;
				for($i = $start_page ; $i<=$end_page ; $i++){
					if($i == $this->nowPage){
						$output .=  '<li><a class="pageCur" href="javascript:;" pageCur="'.$this->pageurl($urlrule,$i,$this->parameter).'">'.$i.'</a></li>';
					}else{
						$output .= '<li><a href="'.$this->pageurl($urlrule,$i,$this->parameter).'">'.$i.'</a></li>';
					}
				}
			}
		}
		
		$output .='<li><a class="page-next" href="'.$this->pageurl($urlrule,$next_page,$this->parameter).'">下一页</a></li>'; 
		$output .='<li><a class="page-last" href="'.$this->pageurl($urlrule,$this->totalPages,$this->parameter).'"> &gt| </a></li>';
		return $output;
	}

	public function pageurl($urlrule, $page, $array = array())
	{
		@extract($array, EXTR_SKIP);
		if(is_array($urlrule))
		{
			//$urlrules = explode('|', $urlrule);
			$urlrule = $page < 2 ? $urlrule[0] : $urlrule[1];
		}
		$url = str_replace('{$page}', $page, $urlrule);
		return $url;
	}

}
?>