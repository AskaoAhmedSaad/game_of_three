<?php
$this->title = 'Starting Game';
?>
<h4>Starting Game</h4>
<form method="POST">
	<input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>"
           value="<?=Yii::$app->request->csrfToken?>"/>
	<button type="submit">Start</button>
</form>