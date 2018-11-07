<?php
/**
* interface for any creating new game repositories
*/
namespace app\modules\game\repositories;

interface CreateNewGameRepositoryInterface
{
	public function __construct(int $player);

    public function create();
}