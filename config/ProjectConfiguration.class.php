<?php

# FROZEN_SF_LIB_DIR: C:\WWW\hotornot\lib\vendor\symfony\lib

require_once dirname(__FILE__).'/../lib/symfony/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // for compatibility / remove and enable only the plugins you want
    //$this->enableAllPluginsExcept(array('sfDoctrinePlugin', 'sfCompat10Plugin'));
	$this->enablePlugins(array('sfDoctrinePlugin'));
	$this->disablePlugins(array('sfPropelPlugin'));

  }
}
