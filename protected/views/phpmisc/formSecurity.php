<?php
$this->renderPartial('/layouts/block_single',array('title'=>'Form security test','back'=>$this->createUrl('phpMisc/index')));
?>

<form action="<?php echo $this->createUrl('phpMisc/formSecurity'); ?>" method="post">
	<label for="user_input">User Input:</label>
    <input name="userinput" id="user_input" />
    
    <input type="submit" value="submit" />
</form>