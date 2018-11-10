<?php
namespace app\tests\unit\repositories;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use app\modules\game\models\Games;

class DbCreateNewGameRepositoryTest extends TestCase
{
    use Specify;

    public function testCreate()
    {
        $this->specify("test positive creation of new games", function() {
            $player = 1;
            $createNewGameRepository = Yii::$container->get('app\modules\game\repositories\CreateNewGameRepositoryInterface', [$player]);
            $game = $createNewGameRepository->create();
            $this->assertNotNull($game);
            $this->assertTrue(is_a($game, '\app\modules\game\models\Games'));
            $this->assertNotEmpty($game->hits); // has first hit
            $this->assertTrue(count($game->hits) === 1); // has only one first hit
            $this->assertTrue($game->status == Games::ACTIVE_STATUS); // is active game
        });

        $this->specify("test negative creation of new games with passing Invalid player number", function() {
            $this->expectException(yii\db\Exception::class);
            $player = 3;
            $createNewGameRepository = Yii::$container->get('app\modules\game\repositories\CreateNewGameRepositoryInterface', [$player]);
            $game = $createNewGameRepository->create($player);
        });
    }
}