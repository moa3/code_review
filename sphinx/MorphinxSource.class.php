<?php

class af_orm_sphinx_MorphinxSource
{
    public $name;

    public $pre_queries = array();

    public $fetch_query = '';

    public $cli_query = '';

    private $model;

    public $type = 'mysql';

    public function __construct($model_name)
    {
        $this->name = $model_name;
        $this->model = new $model_name();
        $this->setSqlConf();
        $this->setSqlPreQueries();
        $this->setFetchQuery();
        $this->setCliQuery();
    }

    private function setSqlConf()
    {
        //FIXME find a better way to get the conf, this one is sooooo bad
        $config = new Config(SITEBASE .'/conf/conf.ini', $_SERVER["HTTP_HOST"]);

        $this->sql_host = $config->dbserver;
        $this->sql_user = $config->dbuser;
        $this->sql_pass = $config->dbpass;
        $this->sql_db = $config->dbname; 
        $this->sql_port = 3306; //TODO get from conf
    }

    private function setSqlPreQueries()
    {
        $this->pre_queries []= "SET NAMES 'utf8'";
        $this->pre_queries []= "SET lc_time_names = 'fr_FR'";
    }

    private function setFetchQuery()
    {
        $this->fetch_query = "SELECT `".$this->model->_table."`.`".$this->model->getPkey()."` * %d + %d as id, ".
                        "'".$this->name."' as `class_".$this->name."`, ".
                        af_orm_SqlBuilder::select($this->getSelectedFields()).
                        " FROM ".af_orm_SqlBuilder::from($this->model->_table).
                        af_orm_SqlBuilder::joins($this->buildJoins(), 'LEFT')." ".
                        af_orm_SqlBuilder::where($this->getConditions(), $this->getSqlConditions());
    }

    private function setCliQuery()
    {
    }

    private function getSelectedFields()
    {
        $index = $this->model->getMorphinxIndex();
        $ret = array();
        foreach($index['fields'] as $key => $value)
        {
            if(!is_numeric($key))
            {
                $ret[$key] = $value;
            }
            else
            {
                if(!is_array($ret[$this->model->_table]))
                    $ret[$this->model->_table] = array();
                $ret[$this->model->_table] []= $value;
            }
        }
        return $ret;
    }

    private function buildJoins()
    {
        $index = $this->model->getMorphinxIndex();
        $ret = array();
        foreach($index['fields'] as $key => $value)
        {
            if(is_string($key))
                $ret []= $this->model->getJoinFor($key);
        }
        return $ret;
    }

    private function getConditions()
    {
        $index = $this->model->getMorphinxIndex();
        if(isset($index['conditions']))
            return $index['conditions'];
        return array();
    }

    private function getSqlConditions()
    {
        $index = $this->model->getMorphinxIndex();
        if(isset($index['sql_conditions']))
            return implode(' AND ', $index['sql_conditions']);
        return '';
    }
}
