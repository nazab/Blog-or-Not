<!--
<script src="http://www.google.com/jsapi"></script>
<script>
google.load("jquery","1.3.2");
google.load("jqueryui","1.7.2");
</script>
<?php echo stylesheet_tag('ui.stars.css');?>
<?php echo javascript_include_tag('ui.stars.js') ?>
<script type="text/javascript">
$(function(){
      $("#ratings").children().not("select").hide();

      // Create target element for onHover titles
      $caption = $("<span/>");

      $("#ratings").stars({
            inputType: "select",
             cancelShow: false,
            captionEl: $caption, // point to our newly created element
            callback: function(ui, type, value)
            {
                  $.post("<?php echo url_for('blog/vote') ?>", {vote: value}, function(data)
                  {
                        //$("#ajax_response").html(data);
                  });
            }

      });

      // Make it available in DOM tree
      $caption.appendTo("#ratings");
});
</script>
-->
<h1>Blog or Not</h1>
<?php foreach ($blog_list as $blog): ?>
<div id="voted_blog" style="float:right;">
<h2>Vote history</h2>
<?php if(is_array($vote_history)) { ?>
<ul>
<?php foreach($vote_history as $vote) {?>
<li>You voted <?php echo $vote['my_vote'];?> for <?php echo $vote['blog_url'];?></li>
<?php } ?>
</ul>
<?php } ?>
<?php //print_r($vote_history); ?>
</div>
<div id="blog_box">
<img src="<?php echo $image_url.$blog->getThumbnailUrl() ?>" alt="<?php echo $blog->getUrl() ?>"/><br/>
<small><?php echo $blog->getUrl() ?></small>
</div>
<div id="vote_box">
  <form id="ratings" action="<?php echo url_for('blog/vote') ?>" method="post">
   <select name="vote">
    <option value="1">Very poor</option>
    <option value="2">Not that bad</option>
    <option value="3">Average</option>
    <option value="4">Good</option>
    <option value="5">Perfect</option>
   </select>
   <input type="submit" value="Rate it!" />
  </form>
  <div style="clear:both;"></div>
</div>
<?php endforeach; ?>