<?php
 $form_attributes = array(
                "id"     => "reg_form",
                "name"   => "update_form",
                "method" => "post",
                "class"  => "form-signin"
                );
if ($user->active){
	$checked='checked';
}else{
	$checked='';
}


	echo $this->session->flashdata('message');	



echo form_open(base_url()."index.php/userController/update/",$form_attributes);
echo "<input type='hidden' name='id' value='".$user->id."' ><br>";
echo "Name:<input type='text' name='name' value='".$user->name."' ><br>";
echo "Email:<input type='email' name='email' value='".$user->email."' ><br>";
echo "Password:<input type='password' name='password' value='' ><br>";
echo "Active:<input type='checkbox' name='active' value='".$user->active."' $checked >";
echo "<input type='submit' value='Editar'>";
form_close();

?>