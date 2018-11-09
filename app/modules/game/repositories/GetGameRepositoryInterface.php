<?php
/**
* interface for any getting games repositories
*/
namespace app\modules\game\repositories;

interface GetGameRepositoryInterface
{

    public function getLastGame();
}