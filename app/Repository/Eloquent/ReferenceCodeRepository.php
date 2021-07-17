<?php

namespace App\Repository\Eloquent;

use App\Exceptions\CustomException;
use App\Models\ReferenceCode;
use App\Repository\ReferenceCodeRepositoryInterface;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ReferenceCodeRepository implements ReferenceCodeRepositoryInterface
{
    use ApiResponser;
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param ReferenceCode $model
     */
    public function __construct(ReferenceCode $model)
    {
        $this->model = $model;
    }

    /**
     * @throws CustomException
     */
    public function createRefCode($user_id){
        DB::beginTransaction();
        try {
            $ref_code = $this->model->create([
                'code' => $this->generateRefCode(),
                'referrer_id' => $user_id,
            ]);

            DB::commit();
            return $ref_code->code;
        } catch(\Exception $e) {
            DB::rollBack();
            throw new CustomException(null,$e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @throws CustomException
     */
    public function getRefCodeIdByCode($code)
    {
        try {
            return $this->model->where('code',$code)->where('active',true)->firstOrFail()->id;
        } catch(\Exception $e) {
            throw new CustomException(null,"Reference number not found",JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @throws CustomException
     */
    public function passiveRefCode($id)
    {
        DB::beginTransaction();
        try {
            $record = $this->model->findOrFail($id);
            $record->update(['active'=>false]);

            DB::commit();
            return $record->referrer_id;
        } catch(\Exception $e) {
            DB::rollBack();
            throw new CustomException(null,"Reference number not found",JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    public function generateRefCode(): string
    {
        return strtoupper(uniqid('S'));
    }
}

