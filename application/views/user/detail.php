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
  <?php
    if($user->active){$activo = "SI";}else{$activo="NO";}
    echo "<tr>";
    echo "<th scope='row'>".$user->id."</th>";
    echo "<td>".$user->name."</td>";
    echo "<td>".$user->email."</td>";
    echo "<td>".$user->type."</td>";
    echo "<td>".$user->date_added."</td>";
    echo "<td>".$activo."</td>";
    echo "<td><a href='".base_url()."index.php/userController/edit/$user->id'>Editar</a> <a href='".base_url()."index.php/userController/delete/$user->id'>Eliminar</a></td>";
    echo "</tr>";
    ?>   
  </tbody>
</table>