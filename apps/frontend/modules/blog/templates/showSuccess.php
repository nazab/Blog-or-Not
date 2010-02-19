<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $blog->getid() ?></td>
    </tr>
    <tr>
      <th>Url:</th>
      <td><?php echo $blog->geturl() ?></td>
    </tr>
    <tr>
      <th>Email:</th>
      <td><?php echo $blog->getemail() ?></td>
    </tr>
    <tr>
      <th>Is thumbnail:</th>
      <td><?php echo $blog->getis_thumbnail() ?></td>
    </tr>
    <tr>
      <th>Thumbnail url:</th>
      <td><?php echo $blog->getthumbnail_url() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $blog->getcreated_at() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $blog->getupdated_at() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('blog/edit?id='.$blog->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('blog/index') ?>">List</a>
