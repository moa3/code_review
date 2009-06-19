<?php

class af_orm_sphinx_MorphinxSearch
{

    const CONF_FILE = '/conf/sphinx.php';

    private $client;

    private $conf = NULL;

    public function __construct($args = array())
    {
        $this->client = new af_orm_sphinx_SphinxClient();
        $this->getConf($args);
        $this->setClient();
    }

    public function search($pattern)
    {
        return $this->client->Query ( $pattern, $conf['index'] );
    }

    private function getConf($args)
    {
        if(isset($args['conf']))
          $this->conf = array_merge($this->getDefaultConf(), $args['conf']);
        else
          $this->conf = $this->getDefaultConf();
    }

    private function getDefaultConf()
    {
        require_once(SITEBASE . self::CONF_FILE);
        return $sphinx_conf;
    }

    private function setClient()
    {
        $this->client->SetServer ( $conf['host'], $conf['port'] );
        $this->client->SetIndexWeights ( array ( "sfrjt_user_User_index" => 2, "sfrjt_user_Artist_index" => 3 ) );
        //$this->client->SetConnectTimeout ( $conf['connect_timeout'] );
        //$this->client->SetWeights ( $conf['weights'] );
        //$this->client->SetMatchMode ( $conf['mode'] );
        //if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
        //if ( $groupby )				$cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
        //if ( $sortby )				$cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
        //if ( $sortexpr )			$cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
        //if ( $distinct )			$cl->SetGroupDistinct ( $distinct );
        //if ( $limit )				$cl->SetLimits ( 0, $limit, ( $limit>1000 ) ? $limit : 1000 );
        //$this->client->SetRankingMode ( $conf['ranker'] );
        //$this->client->SetArrayResult ( true );
    }

}
