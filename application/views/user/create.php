
<fieldset>
	<legend>Formulario de registro</legend>

	<?php 	echo $this->session->flashdata('message');	?>
		<?php echo form_open("index.php/userController/store") ?>
			<table>
				<tr>
					<td>
						Nombre:
					</td>
					<td>
						<input required type="text" class="form-control" name="name" value="<?php echo set_value('nombre') ?>" />
					</td>
				</tr>
				<tr>
					<td>
						Email:
					</td>
					<td>
						<input required type="email" class="form-control" name="email" value="<?php echo set_value('email') ?>" />
					</td>
				</tr>
				
				<tr>
					<td>
						Password:
					</td>
					<td>
						<input required type="password" class="form-control" name="password" />
					</td>
				</tr>
				<tr>
					<td>
						Role:
					</td>
					<td>
						<select name="type">
							<option value='admin'>Admin</option>
							<option value='user'>User</option>
						</select>
					</td>
				</tr>

				<tr>
				<td></td>
				<td>
					 <font color="red" style="font-weight: bold; font-size: 14px; text-decoration: underline"><?php echo validation_errors(); ?></font>
				</td>
			</tr>
				<tr>
					<td>
					
					</td>
					<td>					
						<input type="submit" value="Crear" />
					</td>
				</tr>
			</table>
		<?php echo form_close() ?>
</fieldset>
</body>
</html>