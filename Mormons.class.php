<?php

class Whatever
{
    public static function search($class_name, $pattern, $args = array())
    {
        $s = new af_orm_sphinx_MorphinxSearch($args);
        echo '<pre>';
        print_r($s->search($pattern));
        echo '</pre>';
    }
}
