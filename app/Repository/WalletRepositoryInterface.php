<?php

namespace App\Repository;

interface WalletRepositoryInterface
{
    public function addReward($referrer_id,$invitee_id);

    public function getWallet($user_id);

}