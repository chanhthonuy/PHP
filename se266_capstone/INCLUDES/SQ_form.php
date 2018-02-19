<?php 




?>
<form method="post" id="securityQuestion-form" style="">
    <label class="label"><?php print_r($sq_question, true); ?></label>
    <input type="text" name="sq_answer" required/>
    <br/>
    <input type="submit" name="submit_answer"/>
    <br/>
</form>