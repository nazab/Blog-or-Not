<?php

/**
 * Blog form.
 *
 * @package    form
 * @subpackage Blog
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class BlogForm extends sfForm
{
  public function configure()
  {
	$this->setWidgets(
		array(
			'url' 	=> 	new sfWidgetFormInput(),
			'email' =>	new sfWidgetFormInput(),
		)
	);
	$this->setDefaults(array('email' => 'Your Email Here', 'url' => 'Your
Url Here'));
	$this->widgetSchema->setLabels(array(
		'url'    => 'Your url',
		'email'   => 'Your email address'
		));
	$this->setValidators(array(
		'url'    => new sfValidatorUrl(array('required' => 'This field is required'),array('invalid' => 'This Url is invalid.')),
		'email'   => new sfValidatorEmail(array('required' => 'This field is required'), array('invalid' => 'This email address is invalid')),
));
	$this->widgetSchema->setNameFormat('blog[%s]');
  }
}