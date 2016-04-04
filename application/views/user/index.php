 <form class="navbar-form navbar-left" role="search">
  <div class="form-group">
    <input type="text" class="form-control" placeholder="Search" id="search" onkeydown="down()" onkeyup="up()">
    <div id="ajax-results"></div>
  </div>        
</form>

 <table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Type</th>
      <th>Date Added</th>
      <th>Active</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $u) {
    if($u->active){$activo = "SI";}else{$activo="NO";}
    echo "<tr>";
    echo "<th scope='row'>".$u->id."</th>";
    echo "<td>".$u->name."</td>";
    echo "<td>".$u->email."</td>";
    echo "<td>".$u->type."</td>";
    echo "<td>".$u->date_added."</td>";
    echo "<td>".$activo."</td>";
    echo "<td><a href='userController/edit/$u->id'>Editar</a> <a href='userController/delete/$u->id'>Eliminar</a></td>";
    echo "</tr>";
    } ?>   
  </tbody>
</table>



<script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
    <script>
     
      var timer;

        function up(){
              timer = setTimeout(function(){
                var keywords = $('#search').val();
                if ( keywords.length > 0 ){
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url(); ?>" + "index.php/ajaxController/getUsers",
                      dataType: 'text',
                      data: {name: keywords},
                      success: function(res){
                        $('#ajax-results').html(res);
                      },
                      error: function(e){
                        console.log(e);
                      }
                    });
                 }
              },500);
            }

        function down(){
          clearTimeout(timer);
        }

    </script>
</body>
</html>