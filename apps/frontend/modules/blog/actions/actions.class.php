<?php

/**
 * blog actions.
 *
 * @package    blogornot
 * @subpackage blog
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class blogActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->setTitle('Blog or Not');
    $user = $this->getUser();
    $this->blog_list = Doctrine::getTable('Blog')->getBlogForVoting($user->getAttribute('already_voted_list'));
    $this->image_url = sfConfig::get('app_image_url');
    if(count($this->blog_list) >0) {
      $user->setAttribute('blog_id',$this->blog_list[0]->getId());
      $this->vote_history = $user->getAttribute('vote_history');
    } else {
      $this->redirect('blog/new');
    }
  }

  public function executeNew(sfWebRequest $request)
  {
    // Display the form
    $this->form = new BlogForm();
    if ($this->getRequest()->isMethod('post'))
    {
      $this->form->bind($request->getParameter('blog'));
      if ($this->form->isValid())
      {
        $blog = new Blog();
        $blog->setEmail($this->form->getValue('email'));
        $blog->setUrl($this->form->getValue('url'));
        $blog->setAdmin_hash(md5(time().$this->form->getValue('url').$this->form->getValue('email')));
        $blog->setPublic_hash(md5(time().$this->form->getValue('email').$this->form->getValue('url')));
        $blog->save();
        // Send mail with secret URL
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
        //redirect to the thank you page
        $this->redirect('blog/thankyou');
      }
    }
  }
  public function executeThankyou() {}
  public function executeError404() {}

  public function executeVote(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    
    $user = $this->getUser();
    $blog_id = $user->getAttribute('blog_id');
    $vote_form = new VoteForm();
    $bind_value = array('blog_id' => $blog_id,'value' => $request->getParameter('vote'));
    $vote_form->bind($bind_value);
    if($vote_form->isValid())
    {
      $vote = new Vote();
      $vote->setBlog_id($vote_form->getValue('blog_id'));
      $vote->setValue($vote_form->getValue('value'));
      $vote->save();
      
      // Update vote_SUM
      Doctrine_Query::create()
      ->update('Blog b')
      ->set('b.vote_sum', 'b.vote_sum + '.$vote_form->getValue('value'))
      ->where('b.id = ?',$vote_form->getValue('blog_id'))
      ->execute();
      
      // Update vote_COUNT
      Doctrine_Query::create()
      ->update('Blog b')
      ->set('b.vote_count', 'b.vote_count + 1')
      ->where('b.id = ?',$vote_form->getValue('blog_id'))
      ->execute();
      
      
      if(sfConfig::get('sf_exclusion_list')) {
        // Exclusion list!
        $session_list = $user->getAttribute('already_voted_list');
        if(is_array($session_list) && count($session_list) > 0) {
        } else {
          //No data in the array
          $session_list = array();
        }
        $session_list[] = $vote_form->getValue('blog_id');
        $user->setAttribute('already_voted_list',$session_list);
      }
      // Check if the vote history is empty it it is initiate an empty list
      $vote_history = $user->getAttribute('vote_history');
      if(is_array($vote_history) && count($vote_history) > 0) {
      } else {
        $vote_history = array();
      }
      // Add the just rated blog to the vote_history
      $voted_blog = Doctrine::getTable('Blog')->find($vote_form->getValue('blog_id'));
      $vote_avg = $voted_blog->getVote_sum() / $voted_blog->getVote_count();
      $vote_info = array(
                        'my_vote' => $vote_form->getValue('value'),
                        'vote_avg' => $vote_avg,
                        'vote_count' => $voted_blog->getVote_count(),
                        'vote_sum' => $voted_blog->getVote_sum(),
                        'blog_url' => $voted_blog->getUrl(),
                        'blog_thmbnail' => $voted_blog->getThumbnail_url(),
                        );
      array_unshift($vote_history, $vote_info);
      $user->setAttribute('vote_history',$vote_history);
      $this->redirect('blog/index');
    }
  }
  
  public function executeAdmin(sfWebRequest $request)
  {
    $admin_hash = $request->getParameter('admin_hash');
    $blog = Doctrine::getTable('Blog')->findOneByAdmin_hash($admin_hash);
    $this->blog = $blog;
  }
  
  public function executeWidget(sfWebRequest $request)
  {
    $public_hash = $request->getParameter('public_hash');
    $blog = Doctrine::getTable('Blog')->findOneByPublic_hash($public_hash);
    $this->blog = $blog;
  }
}
