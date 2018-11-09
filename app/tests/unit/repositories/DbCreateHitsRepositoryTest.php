<?php
namespace tests\repositories;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use app\tests\fixtures\Games\GamesFixture;
use app\tests\fixtures\Hits\HitsFixture;

class DbCreateHitsRepositoryTest extends TestCase
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
            $hit = $createHitsRepository->createFirstHit();
            $this->assertNotNull($hit);
            $this->assertTrue(is_a($hit, '\app\modules\game\models\Hits'));
            $this->assertTrue($hit->value > 1);
        });
    }

    public function testCreateHit()
    {
        $this->specify("test positive creation for new hit (winning) with adding -1", function() {
            $player = 1;
            $game = 1;
            $createHitsRepository = Yii::$container->get('app\modules\game\repositories\CreateHitsRepositoryInterface', [$player, $game]);
            $lastHitValue = 4;
            $hit = $createHitsRepository->createHit($lastHitValue);
            $this->assertNotNull($hit);
            $this->assertTrue(is_a($hit, '\app\modules\game\models\Hits'));
            $this->assertTrue($hit->value * 3 - $lastHitValue == -1); // assert adding -1
            $this->assertTrue($hit->value === 1); // last hit && right new value
            $this->assertTrue($hit->isWinning($player)); // is winning for player 1
            $this->assertFalse($hit->isWinning(2)); // the other player lose
            $this->assertTrue($hit->game->status === 0); // the hit game became inactive
        });

        $this->specify("test positive creation for new hit (winning) with adding 0", function() {
            $player = 1;
            $game = 1;
            $createHitsRepository = Yii::$container->get('app\modules\game\repositories\CreateHitsRepositoryInterface', [$player, $game]);
            $lastHitValue = 3;
            $hit = $createHitsRepository->createHit($lastHitValue);
            $this->assertNotNull($hit);
            $this->assertTrue(is_a($hit, '\app\modules\game\models\Hits'));
            $this->assertTrue($hit->value * 3 - $lastHitValue == 0); // assert adding 0
            $this->assertTrue($hit->value === 1); // last hit && right new value
            $this->assertTrue($hit->isWinning($player)); // is winning for player 1
            $this->assertFalse($hit->isWinning(2)); // the other player lose
            $this->assertTrue($hit->game->status === 0); // the hit game became inactive
        });

        $this->specify("test positive creation for new hit (winning) with adding +1", function() {
            $player = 1;
            $game = 1;
            $createHitsRepository = Yii::$container->get('app\modules\game\repositories\CreateHitsRepositoryInterface', [$player, $game]);
            $lastHitValue = 2;
            $hit = $createHitsRepository->createHit($lastHitValue);
            $this->assertNotNull($hit);
            $this->assertTrue(is_a($hit, '\app\modules\game\models\Hits'));
            $this->assertTrue($hit->value * 3 - $lastHitValue == 1); // assert adding +1
            $this->assertTrue($hit->value === 1); // last hit && right new value
            $this->assertTrue($hit->isWinning($player)); // is winning for player 1
            $this->assertFalse($hit->isWinning(2)); // the other player lose
            $this->assertTrue($hit->game->status === 0); // the hit game became inactive
        });
    }
}