<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Blog filter form base class.
 *
 * @package    filters
 * @subpackage Blog *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseBlogFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'           => new sfWidgetFormFilterInput(),
      'email'         => new sfWidgetFormFilterInput(),
      'is_thumbnail'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'thumbnail_url' => new sfWidgetFormFilterInput(),
      'admin_hash'    => new sfWidgetFormFilterInput(),
      'public_hash'   => new sfWidgetFormFilterInput(),
      'vote_sum'      => new sfWidgetFormFilterInput(),
      'vote_count'    => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'url'           => new sfValidatorPass(array('required' => false)),
      'email'         => new sfValidatorPass(array('required' => false)),
      'is_thumbnail'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'thumbnail_url' => new sfValidatorPass(array('required' => false)),
      'admin_hash'    => new sfValidatorPass(array('required' => false)),
      'public_hash'   => new sfValidatorPass(array('required' => false)),
      'vote_sum'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'vote_count'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('blog_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Blog';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'url'           => 'Text',
      'email'         => 'Text',
      'is_thumbnail'  => 'Boolean',
      'thumbnail_url' => 'Text',
      'admin_hash'    => 'Text',
      'public_hash'   => 'Text',
      'vote_sum'      => 'Number',
      'vote_count'    => 'Number',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
    );
  }
}