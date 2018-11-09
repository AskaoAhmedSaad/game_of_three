<?php
namespace tests\repositories;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;

class DbCreateNewGameRepositoryTest extends TestCase
{
    use Specify;
    
    protected function setUp()
    {
        parent::setUp();
    }

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
        });

        $this->specify("test negative creation of new games with passing Invalid player number", function() {
            $this->expectException(yii\db\Exception::class);
            $player = 3;
            $createNewGameRepository = Yii::$container->get('app\modules\game\repositories\CreateNewGameRepositoryInterface', [$player]);
            $game = $createNewGameRepository->create($player);
        });
    }
}