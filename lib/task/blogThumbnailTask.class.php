<?php
if(!function_exists('http_parse_headers')) {
  function http_parse_headers( $header )
  {
      $retVal = array();
      $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
      foreach( $fields as $field ) {
          if( preg_match('/([^:]+): (.+)/m', $field, $match) ) {
              $match[1] = preg_replace('/(?<=^|[\x09\x20\x2D])./e', 'strtoupper("\0")', strtolower(trim($match[1])));
              if( isset($retVal[$match[1]]) ) {
                  $retVal[$match[1]] = array($retVal[$match[1]], $match[2]);
              } else {
                  $retVal[$match[1]] = trim($match[2]);
              }
          }
      }
      return $retVal;
  }
}
//symfony blog:thumbnail --application=frontend --env=prod
class blogThumbnailTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'blog';
    $this->name             = 'thumbnail';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [blog:thumbnail|INFO] task does things.
Call it with:

  [php symfony blog:thumbnail --application="frontend"|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here
    $blogs = Doctrine::getTable('Blog');
    $blogs_to_process = $blogs->findByIsThumbnail(0);
    foreach($blogs_to_process as $blog) {
        $thumbalizr_url = 'http://api.thumbalizr.com?';
        $params = array(
          'url' => $blog->url,
          'width' => 300
        );
        $api_url = $thumbalizr_url.http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res_tab = http_parse_headers($res);
        if(!empty($res_tab['X-Thumbalizr-Status']) && $res_tab['X-Thumbalizr-Status'] == 'OK') {
          // Image is ready let's store the URL!
          $image_data = file_get_contents($api_url);
          $path = sfConfig::get('app_image_path');
          $url = sfConfig::get('app_image_url');
          $image_name = md5($blog->url);
          echo $path.$image_name."\n";
          file_put_contents($path.$image_name.'.jpg',$image_data);
          $blog->thumbnail_url = $image_name.'.jpg';
          $blog->is_thumbnail = 1;
          $blog->save();
          
           // Send mail to notify the blo will get into the game!
           try
          {
            // Create the mailer and message objects
            //$mailer = new Swift(new Swift_Connection_NativeMail());
            
            //$connection = new Swift_Connection_SMTP('smtp.free.fr');
            $connection = new Swift_Connection_NativeMail();
            $mailer = new Swift($connection);
            
            $message = new Swift_Message('Welcome!');
            
            // Render message parts
            $mailContext = array('admin_hash' => $blog->getAdmin_hash(),'blog_url' => $blog->getUrl());
            $v = $this->getPartial('newBlogMailHtmlBody', $mailContext);
            $htmlPart = new Swift_Message_Part($v, 'text/html');
            $message->attach($htmlPart);
            $message->attach(new Swift_Message_Part($this->getPartial('newBlogMailTextBody', $mailContext), 'text/plain'));
            $mailTo = $blog->getEmail();
            $mailFrom = sfConfig::get('app_mail_webmaster');
            $mailer->send($message, $mailTo, $mailFrom);
            $mailer->disconnect();
          }
          catch(Exception $e)
          {
            $this->logMessage($e);
          }
        } else {
          //print_r($res_tab);
        }
    }
  }
}
