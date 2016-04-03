<?php
foreach ($users as $u){
	echo "<p><a href=".base_url()."show/".$u->id.">".$u->name."</p>";
}
?>