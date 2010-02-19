<?php

/**
 * Blog form base class.
 *
 * @package    form
 * @subpackage blog
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseBlogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'url'           => new sfWidgetFormTextarea(),
      'email'         => new sfWidgetFormTextarea(),
      'is_thumbnail'  => new sfWidgetFormInputCheckbox(),
      'thumbnail_url' => new sfWidgetFormTextarea(),
      'admin_hash'    => new sfWidgetFormTextarea(),
      'public_hash'   => new sfWidgetFormTextarea(),
      'vote_sum'      => new sfWidgetFormInput(),
      'vote_count'    => new sfWidgetFormInput(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => 'Blog', 'column' => 'id', 'required' => false)),
      'url'           => new sfValidatorString(array('max_length' => 1000)),
      'email'         => new sfValidatorString(array('max_length' => 1000)),
      'is_thumbnail'  => new sfValidatorBoolean(),
      'thumbnail_url' => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'admin_hash'    => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'public_hash'   => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'vote_sum'      => new sfValidatorInteger(),
      'vote_count'    => new sfValidatorInteger(),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('blog[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Blog';
  }

}
