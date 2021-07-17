<?php

namespace App\Repository;

interface ReferenceCodeRepositoryInterface
{
    public function createRefCode($user_id);

    public function getRefCodeIdByCode($code);

    public function passiveRefCode($id);
}