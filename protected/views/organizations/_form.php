<?php
/* @var $this OrganizationsController */
/* @var $model Organizations */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'organizations-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="profileForm">
		<div class="pfName">
			<fieldset>
				<legend>Organization</legend>
					<table class="uiNameTable">
						<tbody>
							<tr>
								<td>
									<label for="CallersProfile_first_name" class="required">Name <span class="required">*</span></label>
								</td>
								<td>
									<label for="CallersProfile_last_name" class="required">Address <span class="required">*</span></label>
								</td>
							</tr>
							<tr>
								<td>
									<input size="60" maxlength="255" class="reqd fields textFieldMedium" name="Organizations[name]" id="Organizations_name" type="text" value="<?php echo $model->name; ?>">
								</td>
								<td colspan='2' rowspan='3'>
									<textarea rows="6" cols="50" name="Organizations[address]" id="Organizations_address" class="reqd fields textFieldMedium"><?php echo $model->address; ?></textarea>
								</td>
							</tr>
							<tr>
								<td>
									<label for="Organizations_contact_number">Contact Number <span class="required">*</span></label>
								</td>
								<td></td>
							</tr>
							<tr>
								<td>
									<input size="60" maxlength="255" class="fields textFieldMedium" name="Organizations[contact_number]" id="Organizations_contact_number" type="text" value="<?php echo $model->contact_number; ?>">
								</td>
								<td></td>
							</tr>
							<tr>
								<td>
									<label for="Organizations_state">State <span class="required">*</span></label>
								</td>
								<td>
									<label for="Organizations_country">Country <span class="required">*</span></label>
								</td>
							</tr>
							<tr>
								<td>
									<input size="60" maxlength="255" class="fields textFieldMedium" name="Organizations[state]" id="Organizations_state" type="text" value="<?php echo $model->state; ?>">
								</td>
								<td>
									<input size="60" maxlength="255" class="fields textFieldMedium" name="Organizations[country]" id="Organizations_country" type="text" value="<?php echo $model->country; ?>">
								</td>
							</tr>
							<tr>
								<td>
									<label for="Organizations_type">Type <span class="required">*</span></label>
								</td>
							</tr>
							<tr>
								<td>
									<select id="Organizations_type" name="Organizations[type]">
										<option value="ORGANIZATION">Organization</option>
										<option value="GROUP">Group</option>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
			</fieldset>
		</div>
	</div>	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'grayButtons')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->