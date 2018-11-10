<?php
namespace app\tests\unit\repositories;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use app\tests\fixtures\Games\GamesFixture;
use app\tests\fixtures\Hits\HitsFixture;
use app\modules\game\models\Games;
use ReflectionClass;
use Exception;

class DbCreateHitsRepositoryTest extends TestCase
{
    protected $createHitsRepository, $player1, $player2, $game;
    use Specify;
    
    protected function setUp()
    {
        parent::setUp();
        $this->player1 = 1;
        $this->player2 = 2;
        $this->game = 1;
        $this->createHitsRepository = Yii::$container->get('app\modules\game\repositories\CreateHitsRepositoryInterface', [$this->player1, $this->game]);
    }

    public function fixtures() {
        return [
            'games' => [
                'class' => GamesFixture::className(),
                'dataFile' => 'tests/fixtures/Games/data/DbCreateHitsRepositoryTest_case.php'
            ],
            'hits' => [
                'class' => HitsFixture::className(),
                'dataFile' => 'tests/fixtures/Hits/data/DbCreateHitsRepositoryTest_case.php'
            ],
        ];
    }

    public function testCreateFirstHit()
    {
        $this->specify("test creation for first hit", function() {
            $hit = $this->createHitsRepository->createFirstHit();
            $this->assertNotNull($hit);
            $this->assertTrue(is_a($hit, '\app\modules\game\models\Hits'));
            $this->assertTrue($hit->value > 1);
        });
    }

    public function testCreateHit()
    {
        $this->specify("test creation for new hit (not winning) - still active game", function() {
            $lastHitValue = 5;
            $hit = $this->createHitsRepository->createHit($lastHitValue);
            $this->assertNotNull($hit);
            $this->assertTrue(is_a($hit, '\app\modules\game\models\Hits'));
            $this->assertTrue($hit->value * 3 - $lastHitValue == +1); // assert adding +1
            $this->assertTrue($hit->value === 2);
            $this->assertFalse($hit->isWinning($this->player1)); // still not winning
            $this->assertTrue($hit->canCreateNewHit()); // can create new hit
            $this->assertTrue($hit->game->status == Games::ACTIVE_STATUS); // the hit game still active
        });

        $this->specify("test creation for new hit (winning) with adding -1", function() {
            $lastHitValue = 4;
            $hit = $this->createHitsRepository->createHit($lastHitValue);
            $this->assertNotNull($hit);
            $this->assertTrue(is_a($hit, '\app\modules\game\models\Hits'));
            $this->assertTrue($hit->value === 1); // last hit && right new value
            $this->assertTrue($hit->value * 3 - $lastHitValue == -1); // assert adding -1
            $this->assertTrue($hit->isWinning($this->player1)); // is winning for player 1
            $this->assertFalse($hit->isWinning($this->player2)); // the other player lose
            $this->assertFalse($hit->canCreateNewHit()); // cann't create new hit
            $this->assertTrue($hit->game->status == Games::INACTIVE_STATUS); // the hit game became inactive
        });

        $this->specify("test creation for new hit (winning) with adding 0", function() {
            $lastHitValue = 3;
            $hit = $this->createHitsRepository->createHit($lastHitValue);
            $this->assertNotNull($hit);
            $this->assertTrue(is_a($hit, '\app\modules\game\models\Hits'));
            $this->assertTrue($hit->value * 3 - $lastHitValue == 0); // assert adding 0
            $this->assertTrue($hit->value === 1); // last hit && right new value
            $this->assertTrue($hit->isWinning($this->player1)); // is winning for player 1
            $this->assertFalse($hit->isWinning($this->player2)); // the other player lose
            $this->assertFalse($hit->canCreateNewHit()); // cann't create new hit
            $this->assertTrue($hit->game->status == Games::INACTIVE_STATUS); // the hit game became inactive
        });

        $this->specify("test creation for new hit (winning) with adding +1", function() {
            $lastHitValue = 2;
            $hit = $this->createHitsRepository->createHit($lastHitValue);
            $this->assertNotNull($hit);
            $this->assertTrue(is_a($hit, '\app\modules\game\models\Hits'));
            $this->assertTrue($hit->value * 3 - $lastHitValue == 1); // assert adding +1
            $this->assertTrue($hit->value === 1); // last hit && right new value
            $this->assertTrue($hit->isWinning($this->player1)); // is winning for player 1
            $this->assertFalse($hit->isWinning($this->player2)); // the other player lose
            $this->assertFalse($hit->canCreateNewHit()); // cann't create new hit
            $this->assertTrue($hit->game->status == Games::INACTIVE_STATUS); // the hit game became inactive
        });
    }

    public function testGetTheNextHitValue()
    {
        $this->specify("test getting thee next value in case of adding -1", function() {
            $lastHitValue = 4;
            $getTheNextHitValueFunction = self::getMethod('getTheNextHitValue');
            $nextValue = $getTheNextHitValueFunction->invokeArgs($this->createHitsRepository, [$lastHitValue]);
            $this->assertTrue($nextValue === 1);
            $this->assertTrue($nextValue * 3 - $lastHitValue == -1); // assert adding -1
        });

        $this->specify("test getting thee next value in case of adding 0", function() {
            $lastHitValue = 3;
            $getTheNextHitValueFunction = self::getMethod('getTheNextHitValue');
            $nextValue = $getTheNextHitValueFunction->invokeArgs($this->createHitsRepository, [$lastHitValue]);
            $this->assertTrue($nextValue === 1);
            $this->assertTrue($nextValue * 3 - $lastHitValue == 0); // assert adding 0
        });

        $this->specify("test getting thee next value in case of adding +1", function() {
            $lastHitValue = 2;
            $getTheNextHitValueFunction = self::getMethod('getTheNextHitValue');
            $nextValue = $getTheNextHitValueFunction->invokeArgs($this->createHitsRepository, [$lastHitValue]);
            $this->assertTrue($nextValue === 1);
            $this->assertTrue($nextValue * 3 - $lastHitValue == 1); // assert adding +1
        });
    }

    public function testInActiveTheGame()
    {
        $this->specify("test negative inactivaing the hit game - no hit defined", function() {
            $lastHitValue = 2;
            $this->expectException(Exception::class);
            $inActiveTheGameFunction = self::getMethod('inActiveTheGame');
            $inActiveTheGameFunction->invokeArgs($this->createHitsRepository, []);
        });

        $this->specify("test positive inactivaing the hit game", function() {
            $lastHitValue = 2;
            $hit = $this->createHitsRepository->createHit($lastHitValue);
            $this->assertTrue($hit->game->status == Games::ACTIVE_STATUS); // the hit game still active here
            $inActiveTheGameFunction = self::getMethod('inActiveTheGame');
            $inActiveTheGameFunction->invokeArgs($this->createHitsRepository, []);
            $this->assertNotNull($hit->game);
            $this->assertTrue($hit->game->status == Games::INACTIVE_STATUS); // the hit game became inactive
        });
    }

    protected static function getMethod($name)
    {
        $class = new ReflectionClass('app\modules\game\repositories\DbCreateHitsRepository');
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}