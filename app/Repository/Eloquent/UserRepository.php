<?php

namespace App\Repository\Eloquent;

use App\Exceptions\CustomException;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\ReferenceCodeRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\WalletRepositoryInterface;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    use ApiResponser;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var ReferenceCodeRepositoryInterface
     */
    protected $referenceCodeRepository;

    /**
     * @var WalletRepositoryInterface
     */
    protected $walletRepository;

    private $ref_code = null;
    private $referrer_id = null;
    private $wallet = array('amount'=>0,'currency'=>'TRY');

    /**
     * BaseRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model,
        ReferenceCodeRepositoryInterface $referenceCodeRepository,
        WalletRepositoryInterface $walletRepository
    )
    {
        $this->model = $model;
        $this->referenceCodeRepository = $referenceCodeRepository;
        $this->walletRepository = $walletRepository;
    }

    /**
     * @throws CustomException
     */
    public function storeUser(StoreUserRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            if ($request->filled('ref_code')){
                $this->ref_code = $this->referenceCodeRepository->getRefCodeIdByCode($request->ref_code);
                $this->referrer_id = $this->referenceCodeRepository->passiveRefCode($this->ref_code);
            }

            $user = $this->model->create([
                'name' => $request->name,
                'password' => $request->password,
                'email' => $request->email,
                'ref_code_id' => $this->ref_code
            ]);

            if (!is_null($this->referrer_id)){
                $this->wallet = $this->walletRepository->addReward($this->referrer_id,$user->id);
            }

            DB::commit();
            return $this->success(['token'=> $this->createAuthToken($user),'user' => (new UserResource($user)),'wallet'=>$this->wallet],"User Created",JsonResponse::HTTP_CREATED);
        } catch(\Exception $e) {
            DB::rollBack();
            throw new CustomException(null,$e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    public function createAuthToken($model)
    {
        return $model->createToken('API Token')->plainTextToken;
    }

    /**
     * @throws CustomException
     */
    public function loginUser(LoginUserRequest $request): JsonResponse
    {
        $user = User::where('email',$request->email)->first();
        if (is_null($user)){
            throw new CustomException(null,'User not found', JsonResponse::HTTP_BAD_REQUEST);
        }

        if (!auth()->attempt($request->only(['email','password']))) {
            throw new CustomException(null,'Credentials not match', JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->success(['token'=> $this->createAuthToken(Auth::user()),'user' => (new UserResource($user)),'wallet'=>$this->walletRepository->getWallet($user->id)],"User logged in",JsonResponse::HTTP_OK);
    }
}
