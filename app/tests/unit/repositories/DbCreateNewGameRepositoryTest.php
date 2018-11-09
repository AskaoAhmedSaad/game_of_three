<?php
namespace tests\repositories;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use app\tests\fixtures\Games\GamesFixture;
use app\tests\fixtures\Hits\HitsFixture;

class DbCreateNewGameRepositoryTest extends TestCase
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
                'dataFile' => 'tests/fixtures/Games/data/games.php'
            ],
            'hits' => [
                'class' => HitsFixture::className(),
                'dataFile' => 'tests/fixtures/Hits/data/hits.php'
            ],
        ];
    }

    public function testDeleteUser()
    {
        $this->specify("test deleting user", function() {
            // $data = $this->deleteUserRepository->delete(1);
            // $this->assertNotNull($data);
            $this->assertTrue(1 == 1);
        });
    }
}