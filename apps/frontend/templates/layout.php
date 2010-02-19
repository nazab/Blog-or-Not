<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <script src="http://www.google.com/jsapi" type="text/javascript"></script>
    <script type="text/javascript">
    google.load("jquery","1.3.2");
    </script>
    <script src="http://www.malsup.com/jquery/corner/jquery.corner.js?v2.01" type="text/javascript"></script>
    <script type="text/javascript">
    $("#header").corner("round top");
    $("#menu").corner("round bottom");
    $("#footer").corner("round");
    $("#content").corner("round");
    </script>
  </head>
  <body>
    <div id="header" class="center">
      <a href="<?php echo url_for('blog/index');?>">
        <?php echo image_tag('mamou-assis.png', 'alt=logo id=logo') ?>
        <span id="title">Blog or Not</span>
        <span id="theme">Geek</span>
      </a>
    </div>
    <div id="menu" class="center">
    <ul class="center">
    <li><a href="<?php echo url_for('blog/index');?>">Home</a></li>
    <li><a href="<?php echo url_for('blog/new');?>">Add your blog</a></li>
    <li><a href="<?php echo url_for('blog/new');?>">Blog</a></li>
    </ul>
    </div>
    <div id="content" class="center">
    <?php echo $sf_content ?>
    </div>
    <div id="footer">
    <div class="center">
    <a href="http://blog.nazab.com">Nazab</a>
    </div>
    </div>
  </body>
</html>
