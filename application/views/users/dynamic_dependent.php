<html>
<head>
    <title>Codeigniter Dynamic Dependent Select Box using Ajax</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  
    <style>
    .box
    {
        width:100%;
        max-width:650px;
        margin:0 auto;
    }
    </style>
</head>
<body>
    <div class="container box">
    <br/>
    <br />
    <h3 align="center">Codeigniter Dynamic Dependent Select Box using Ajax</h3>
    <br />
    <div class="form-group">
        <select name="country" id="country" class="form-control input-lg">
            <option value="">Select Country</option>
            <?php  
            foreach($country as $row)
            {
                echo '<option value="'.$row->country_id.'">'.$row->country_name.'</option>';
            }
            ?>
        </select>
    </div>
    <br />
    <div class="form-group">
     <select name="state" id="state" class="form-control input-lg">
        <option value="">Select State</option>
     </select>
    </div>
    <br />
    <div class="form-group">
        <select name="city" id="city" class="form-control input-lg">
            <option value="">Select City</option>
        </select>
    </div>
    </div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
 $('#country').change(function(){
  var country_id = $('#country').val();
  
  if(country_id != '')
  {
   $.ajax({
    url:"<?php echo base_url(); ?>dynamic_dependent/fetch_state",
    method:"POST",
    data:{country_id:country_id},
    success:function(data)
    {
     $('#state').html(data);
     $('#city').html('<option value="">Select City</option>');
    }
   });
  }
  else
  {
   $('#state').html('<option value="">Select State</option>');
   $('#city').html('<option value="">Select City</option>');
  }
 });

 $('#state').change(function(){
  var state_id = $('#state').val();
  if(state_id != '')
  {
   $.ajax({
    url:"<?php echo base_url(); ?>dynamic_dependent/fetch_city",
    method:"POST",
    data:{state_id:state_id},
    success:function(data)
    {
     $('#city').html(data);
    }
   });
  }
  else
  {
   $('#city').html('<option value="">Select City</option>');
  }
 });
 
});
</script>