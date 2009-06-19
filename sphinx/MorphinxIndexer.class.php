<?php

class af_orm_sphinx_MorphinxIndexer
{

    const CONF_TPL_FILE ='/include/af/orm/sphinx/sphinx.conf.tpl.php'; 

    private $models = array();

    private $conf = array();

    public $sources = array();

    public $sources_count = 0;

    public function __construct($args)
    {
        $this->setModelsToIndex($args['models']);
        $this->setConf($args['conf']);
    }

    private function getSourceFromModel($model_name)
    {
        return new af_orm_sphinx_MorphinxSource($model_name);
    }

    public function generateConf()
    {
        foreach($this->models as $model_name)
        {
            $this->sources []= $this->getSourceFromModel($model_name);
            $this->sources_count++;
        }
        ob_start();
        require SITEBASE.self::CONF_TPL_FILE;
        $conf = ob_get_contents();
        ob_clean();
        return $conf;
    }

    private function setModelsToIndex($models)
    {
        $this->models = $models;
    }

    private function setConf($conf)
    {
        $this->conf = $conf;
    }
}
