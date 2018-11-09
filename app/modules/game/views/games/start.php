<h4>Starting Game</h4>
<hp><?= $msg ?></p>
<form method="POST" action="/start?player=<?= $_GET['player'] ?>">
	<input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>"
           value="<?=Yii::$app->request->csrfToken?>"/>
	<button type="submit">Start</button>
</form>