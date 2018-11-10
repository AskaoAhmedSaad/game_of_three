<?php
namespace app\tests\unit\repositories;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use Codeception\Util\Fixtures;
use app\tests\fixtures\Games\GamesFixture;

class DbGetGameRepositoryTest extends TestCase
{
    use Specify;
    
    protected function setUp()
    {
        parent::setUp();
    }

    public function fixtures() {
        return [
            'games' => [
                'class' => GamesFixture::className(),
                'dataFile' => 'tests/fixtures/Games/data/DbGetGameRepositoryTest_case.php'
            ],
        ];
    }

    public function testGetLastGame()
    {
        $this->specify("test positive getting last game", function() {
            $getGameRepository = Yii::$container->get('app\modules\game\repositories\GetGameRepositoryInterface');
            $lastGame = $getGameRepository->getLastGame();
            $this->assertNotNull($lastGame);
            $this->assertTrue(is_a($lastGame, '\app\modules\game\models\Games'));
        });
    }
}