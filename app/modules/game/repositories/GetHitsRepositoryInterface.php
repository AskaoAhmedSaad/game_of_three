<?php
/**
* interface for any geting hits repositories
*/
namespace app\modules\game\repositories;

interface GetHitsRepositoryInterface
{
    public function getLastGameHit();
}