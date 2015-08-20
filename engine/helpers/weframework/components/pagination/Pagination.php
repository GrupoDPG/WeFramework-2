<?php
namespace helpers\weframework\components\pagination;
/**
 * Class Pagination
 * @package helpers\weframework\components\pagination
 */
class Pagination{
    /**
     * @var \PDO $db
     * @var int $urlPage
     * @var int $limitResult
     * @var int $total
     * @var string $query
     * @var array $query_param
     * @var array $queryResult
     * @var int $queryResult
     * @var int $queryRows
     * @var Pagination $navigation
     * @var string $navigation
     */
    private $db;
    private $pageDefined = false;
    private $page = 0;
    private $limitResult = 10;
    private $navRange = 10;
    private $total = 0;
    private $query;
    private $queryParam;
    private $queryResult;
    private $currentResults = 1;
    private $queryRows = 0;
    private $navigation;
    private $pageVar = 'page';
    private $pageVarDefeined = false;

    /**
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection){
        $this->db = $connection;
    }

    /**
     * @return int
     */
    public function getNavRange()
    {
        return $this->navRange;
    }

    /**
     * @param int $navRange
     */
    public function setNavRange($navRange)
    {
        $this->navRange = $navRange;
    }

    /**
     * @return string
     */
    public function getPageVar()
    {
        return $this->pageVar;
    }

    /**
     * @param string $pageVar
     */
    public function setPageVar($pageVar)
    {
        $this->pageVarDefeined = true;
        $this->pageVar = $pageVar;
    }


    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimitResult()
    {
        return $this->limitResult;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return mixed
     */
    public function getQueryResult()
    {
        return $this->queryResult;
    }

    /**
     * @return int
     */
    public function getCurrentResults()
    {
        return $this->currentResults;
    }

    /**
     * @return int
     */
    public function getQueryRows()
    {
        return $this->queryRows;
    }

    public function getNavigation(){
        return $this->navigation;
    }


    /**
     * @return string
     */
    private function prepareQuery(){
        return trim(preg_replace('@LIMIT \w+@i', '', $this->query));
    }

    /**
     * @return bool
     */
    private function hasParams(){
        return (isset($this->queryParam) && is_array($this->queryParam) && count($this->queryParam) > 0);
    }

    private function setTotal(){
        $sql = $this->prepareQuery();
        $stmt = $this->db->prepare($sql);
        if($this->hasParams())
            $stmt->execute($this->queryParam);
        else
            $stmt->execute();
        $this->total = $stmt->rowCount();
    }

    private function setQueryResult(){
        $sql = $this->prepareQuery();
        if($this->page <= 1)
            $sql .= " LIMIT " . $this->limitResult;
        else {
            $limit = ((($this->page * $this->limitResult)) - $this->limitResult);
            $sql .= " LIMIT ".$limit.",".$this->limitResult;
        }
        $stmt = $this->db->prepare($sql);
        if($this->hasParams())
            $stmt->execute($this->queryParam);
        else
            $stmt->execute();

        $this->queryRows = $stmt->rowCount();
        $this->queryResult = $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $query
     * @param null $params
     */
    public function query($query, $params = null){
        $this->query = $query;
        $this->queryParam = $params;
    }

    /**
     * @param $page_number
     * @return $this
     */
    public function page($page_number){
        if(isset($page_number) && !empty($page_number)) {
            $this->page = $page_number;
            $this->pageDefined = true;
        }
        return $this;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function limitResult($limit){
        if(is_numeric($limit)) {
            $this->limitResult = $limit;
        }
        return $this;
    }

    
    private function preparePageValue(){
        if(!$this->pageDefined)
            if(isset($_GET[$this->pageVar]))
                $this->page = $_GET[$this->pageVar];
            else $this->page(1);
    }

    public function paginate(){
        $this->preparePageValue();
        $this->setTotal();
        $this->setQueryResult();
        $this->navigation = new Navigation($this);
        return $this->navigation;
    }

}