<?php
/**
* interface for any creating new game repositories
*/
namespace app\modules\game\repositories;

interface GetGameRepositoryInterface
{

    public function getLastGame();
}