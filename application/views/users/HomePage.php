<?php include('header.php'); ?>
<script>
$(document).ready(function(){
    $("#myInput").on("keyup",function(){
        var value=$(this).val().toLowerCase();
        $("#myTable tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>

<div class="container">
<div class="row">
<div class="col-lg-4">
<form class="form-inline">
    <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="myInput">
    <button class="btn btn-outline-success" type="submit">Search</button>
  </form>
  </div>
</div>
</div>

 <div class="container" style="margin-top:20px;">
 <div class="row">
<h1>All Articles</h1>
  <table class="table table-bordered">
<thead >
<tr>
<th>S.no</th>
<th>Article Image</th>
<th>Article Title</th>
<th>Published On</th>
</tr>
</thead>
<tbody id="myTable">
<?php if(count($articles)):
 $count=$this->uri->segment(3); 
 ?> 
<?php foreach ($articles as $art): ?>
<tr>	   
        <td><?=    ++$count; ?></td> 
        <?php if(!is_null($art->image_path)) { ?>
        <td><img src="<?php echo $art->image_path ?>" alt="" width="280" height="200"></td>
        <?php } ?>
		<td><?= anchor("admin/{$art->id}",$art->article_title); ?></td>
		<td><?= date('d M y H:i:s',strtotime($art->created_at)); ?></td>
	</tr>
	<?php endforeach; ?>
<?php else: ?>
	<tr>
	<td colspan="3">Not data available</td>
	</tr>
   <?php endif; ?>
</tbody>
</table>
<?php  echo $this->pagination->create_links();   ?> 
</div>
</div>
<?php include('footer.php'); ?>