<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseVote extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('vote');
        $this->hasColumn('blog_id', 'integer', null, array('type' => 'integer', 'notnull' => true));
        $this->hasColumn('value', 'integer', null, array('type' => 'integer', 'notnull' => true));
    }

    public function setUp()
    {
        $this->hasOne('Blog', array('local' => 'blog_id',
                                    'foreign' => 'id',
                                    'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}