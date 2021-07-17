<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Jobs\SendInvitationJob;
use App\Repository\ReferenceCodeRepositoryInterface;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group User Actions
 *
 * API endpoints for user actions
 *
 */
class SendInvitation extends Controller
{
    use ApiResponser;

    protected $referenceCodeRepository;

    public function __construct(ReferenceCodeRepositoryInterface $referenceCodeRepository)
    {
        $this->referenceCodeRepository = $referenceCodeRepository;
    }

    /**
     * Send Invitation Code Endpoint.
     *
     * @bodyParam   email    string  required    The email of the  invitee.      Example: invitee@example.com
     *
     * @response 201 {"error":false,"message":"Invitation Mail Has Been Sent","data":null}
     * @response 422 {"error":true,"message":"InvitationRequest validation failed","data":{"email":["The email field is required."]}}
     */
    public function __invoke(InvitationRequest $request): JsonResponse
    {
        $ref_code = $this->referenceCodeRepository->createRefCode($request->user()->id);
        SendInvitationJob::dispatch($request->email,$ref_code);

        return $this->success(null,"Invitation Mail Has Been Sent",JsonResponse::HTTP_OK);
    }
}
