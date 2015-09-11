<?php
namespace helpers\weframework\components\pagination;
/**
 * Class Navigation
 * @package helpers\weframework\components\pagination
 */
class Navigation{

    private $pg;

    public function __construct(Pagination $pg){
        $this->pg = $pg;
    }

    public function rows(){
        return $this->pg->getQueryResult();
    }

    public function resultsPerPage(){
        return $this->pg->getLimitResult();
    }

    public function total(){
        return $this->pg->getTotal();
    }

    public function showing(){
        $showing = ($this->pg->getPage() * $this->pg->getLimitResult()) - $this->pg->getLimitResult();
        //if not last page
        if($this->hasResult()) {
            if ($showing == 0)
                return 1;
            return $showing + 1;
        }
        return 0;
    }

    public function showingOf(){
        //last page
        if(!$this->hasResult())
            return 0;

        if($this->pg->getQueryRows() == $this->pg->getLimitResult())
            return ($this->pg->getPage() * $this->pg->getLimitResult());

        if($this->page() <= 1)
            return $this->pg->getQueryRows();

        return $this->pg->getTotal();
    }

    public function page(){
        return $this->pg->getPage();
    }


    public function hasResult($limit = false){
        if($limit == false)
            $lastResult = ($this->pg->getPage() * $this->pg->getLimitResult()) - $this->pg->getLimitResult();
        else
            $lastResult = ($this->pg->getPage() * $this->pg->getLimitResult());

        if($lastResult > $this->pg->getTotal())
            return false;
        return true;
    }

    public function next(){
        if (!$this->hasResult(true) || $this->pg->getQueryRows() < $this->resultsPerPage() || $this->lastPage() == $this->pg->getPage())
            return false;

        return $this->pg->getPage() + 1;

    }

    public function prev(){
        if($this->pg->getPage() <=1 )
            return false;
        else
            return $this->pg->getPage() - 1;
    }

    /**
     * @return bool
     */
    public function notRows(){
        if($this->pg->getQueryRows() > 0)
            return false;
        else
            return true;
    }

    /**
     * @return int
     */
    public function queryRows(){
        return $this->pg->getQueryRows();
    }

    /**
     * @return array
     */
    public function range(){

        $page  = (int)$this->page();
        $limit = $this->pg->getNavRange();
        $total_pages = $this->lastPage();
        $float = ceil(abs($limit / 2));
        $range = [];
        $start = ($page - $float);

        if($start <= 0) {
            $start = 1;
            if($limit <= $total_pages)
                $end = $limit;
            else
                $end = $total_pages;
        } else {
            if($page < $total_pages)
                $end = $page + $float;
            else
                $end = $total_pages;
        }
        if($end > $start){
            for($i = $start; $i <= $end; $i++){
                $range[] = $i;
            }
        }
        return $range;
    }

    public function lastPage(){
        return ceil($this->total() / $this->resultsPerPage());
    }

    public function bootstrapNavigation(){
        ?>
        <ul class="pagination pagination-sm pull-left">
            <li>Mostrando <?=$this->showing()?> a <?=$this->showingOf()?> de <?=$this->total()?></li>
        </ul>
        <ul class="pagination pagination-sm pull-right">
            <?php
            if($this->prev()) {
                echo '<li><a href="'.BaseUrl().'clients?page=1"><i class="fa fa-angle-left"></i><i class="fa fa-angle-left"></i></a></li>';
                echo '<li><a href="'.BaseUrl().'clients?page='.$this->prev().'"><i class="fa fa-angle-left"></i></a></li>';
            }
            ?>
            <?php
            if(count($this->range()) > 0){
                $page_var = $this->pg->getPageVar();
                foreach($this->range() as $i){
                    if($this->pg->getPage() == $i || $this->pg->getPage() == '' && $i == 1)
                        $class = ' class="active"';
                    else
                        $class = '';
                    echo '<li'.$class.'><a href="'.BaseUrl().'clients?'.$this->pg->getPageVar().'='.$i.'">'.$i.'</a></li>';
                }
            }
            ?>
            <?php
            if($this->next()) {
                echo '<li><a href="'.BaseUrl().'clients?page='.$this->next().'"><i class="fa fa-angle-right"></i></a></li>';
                echo '<li><a href="'.BaseUrl().'clients?page='.$this->lastPage().'"><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a></li>';
            }
            ?>
        </ul>
        <?php
    }
}