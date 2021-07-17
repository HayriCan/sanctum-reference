<?php

namespace App\Repository\Eloquent;

use App\Exceptions\CustomException;
use App\Models\Wallet;
use App\Repository\WalletRepositoryInterface;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class WalletRepository implements WalletRepositoryInterface
{
    use ApiResponser;
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Wallet $model
     */
    public function __construct(Wallet $model)
    {
        $this->model = $model;
    }

    /**
     * @throws CustomException
     */
    public function addReward($referrer_id,$invitee_id): array
    {
        DB::beginTransaction();
        try {
            $this->model->create([
                'user_id' => $referrer_id,
                'amount' => config('wallet.rewardReferrer.amount'),
                'currency' => config('wallet.rewardReferrer.currency'),
            ]);

            $this->model->create([
                'user_id' => $invitee_id,
                'amount' => config('wallet.rewardInvitee.amount'),
                'currency' => config('wallet.rewardInvitee.currency'),
            ]);

            DB::commit();
            return $this->getWallet($invitee_id);
        } catch(\Exception $e) {
            DB::rollBack();
            throw new CustomException(null,$e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    public function getWallet($user_id)
    {
        try {
            return array('amount'=>$this->model->where('user_id',$user_id)->sum('amount'),'currency'=>config('wallet.rewardInvitee.currency'));
        } catch(\Exception $e) {
            throw new CustomException(null,"User reward not found",JsonResponse::HTTP_BAD_REQUEST);
        }
    }

}

