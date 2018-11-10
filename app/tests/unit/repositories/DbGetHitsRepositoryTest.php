<?php
namespace app\tests\unit\repositories;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use Codeception\Util\Fixtures;
use app\tests\fixtures\Games\GamesFixture;
use app\tests\fixtures\Hits\HitsFixture;

class DbCreateHitsRepositoryTest extends TestCase
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
                'dataFile' => 'tests/fixtures/Games/data/DbGetHitsRepositoryTest_case.php'
            ],
            'hits' => [
                'class' => HitsFixture::className(),
                'dataFile' => 'tests/fixtures/Hits/data/DbGetHitsRepositoryTest_case.php'
            ],
        ];
    }

    public function testGetLastGameHit()
    {
        $this->specify("test positive getting last game hit", function() {
            $gameID = 1;
            $getHitsRepository = Yii::$container->get('app\modules\game\repositories\GetHitsRepositoryInterface', [$gameID]);
            $lastGameHit = $getHitsRepository->getLastGameHit();
            $this->assertNotNull($lastGameHit);
            $this->assertTrue(is_a($lastGameHit, '\app\modules\game\models\Hits'));
        });
    }
}