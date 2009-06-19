<?php
if(file_exists('../../include/startup.inc'))
  define('SITEBASE', realpath('../../'));
else { 
    print "invalid path…\n";
    exit(1);
}

$_SERVER["HTTP_HOST"] = getenv('HTTP_HOST');

require_once SITEBASE . '/include/startup.inc';

$s = new af_orm_sphinx_MorphinxIndexer(array('models' => array('sfrjt_user_User', 'sfrjt_user_Artist')));
//$s = new af_orm_sphinx_MorphinxIndexer(array('models' => array('sfrjt_user_User')));
echo $s->generateConf();
