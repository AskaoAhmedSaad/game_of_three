<?php
namespace tests\repositories;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use app\tests\fixtures\Games\GamesFixture;
use app\tests\fixtures\Hits\HitsFixture;

class DbCreateNewGameRepositoryTest extends TestCase
{
    protected $createHitsRepository;
    use Specify;
    
    protected function setUp()
    {
        parent::setUp();
    }

    public function fixtures() {
        return [
            'games' => [
                'class' => GamesFixture::className(),
                'dataFile' => 'tests/fixtures/Games/data/DbCreateNewGameRepositoryTest_case.php'
            ],
            'hits' => [
                'class' => HitsFixture::className(),
                'dataFile' => 'tests/fixtures/Hits/data/DbCreateNewGameRepositoryTest_case.php'
            ],
        ];
    }

    public function testCreateFirstHit()
    {
        $this->specify("test positive creation for first hit", function() {
            $player = 1;
            $game = 1;
            $createHitsRepository = Yii::$container->get('app\modules\game\repositories\CreateHitsRepositoryInterface', [$player, $game]);
            $hit = $createHitsRepository->testCreateFirstHit();
            $this->assertNotNull($hit);
            $this->assertTrue(is_a($hit, '\app\modules\game\models\Hits'));
            $this->assertTrue($hit->value > 1);
        });
    }
}