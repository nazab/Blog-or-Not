<?php

/**
 * Vote form.
 *
 * @package    form
 * @subpackage Vote
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class VoteForm extends sfForm
{
  public function configure()
  {
    $this->setValidators(array(
      'blog_id'    => new sfValidatorDoctrineChoice(array('model' => 'Blog')),
      'value'      => new sfValidatorInteger(),
    ));
  }
}