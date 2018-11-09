<h4>Player <?= $_GET['player'] ?></h4>

<p><?= $msg ?><p>
<p>current value: <?= $value ?><p>

<?php if ($allowNewGame): ?>
	<a href="/start?player=<?= $_GET['player'] ?>">start new game</a>
<?php else: ?>
	<form method="POST" action="/hit?player=<?= $_GET['player'] ?>&id=<?= $_GET['id'] ?>">
		<input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>"
	           value="<?=Yii::$app->request->csrfToken?>"/>
		<button type="submit">hit</button>
	</form>
<?php endif;?>