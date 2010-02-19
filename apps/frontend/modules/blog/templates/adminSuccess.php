<h1>Welcome to your admin page</h1>

<img src="<?php echo $blog->thumbnail_url ?>"/><br/>
you're blog is : <?php echo link_to($blog->url,$blog->url); ?><br/>
you have been voted <?php echo $blog->vote_count ?> times!<br/>
you're average vote is <?php if($blog->vote_count == 0) echo 0; else echo $blog->vote_sum/$blog->vote_count ?>!
<br/>
<textarea cols="100" rows="3">
<script type="text/javascript" src="<?php echo url_for('blog/widget?public_hash='.$blog->public_hash,'absolute=true')?>"></script>
</textarea>
<br/>
<div style="border:black solid 2px">
<script type="text/javascript" src="<?php echo url_for('blog/widget?public_hash='.$blog->public_hash)?>"></script>
</div>