<?php
if (count($users)>0){

foreach ($users as $u){
	echo "<p><a href=".base_url()."index.php/userController/show/".$u->id.">".$u->name."</p>";
}

}else{
	echo 'no hay resultados';
}
?>