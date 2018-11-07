<?php
/**
* interface for any creating hits repositories
*/
namespace app\modules\game\repositories;

interface CreateHitsRepositoryInterface
{
	public function __construct(int $player, int $gameId);

    public function createFirstHit();

    public function createHit($lastHitValue);
}