<?php

$this->title = 'Player hit';
?>
<h4>Player hit</h4>
<p><?= $msg ?><p>
<p>current value: <?= $value ?><p>
<p><?= $allowNewGame ?><p>
<form method="POST" action="/hit?player=<?= $player ?>&id=<?= $id ?>">
	<input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>"
           value="<?=Yii::$app->request->csrfToken?>"/>
	<button type="submit">hit</button>
</form>