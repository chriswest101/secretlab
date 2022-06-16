<?php

namespace App\Http\Controllers\Api;

use App\Services\StoreService;
use App\Services\ValidationService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class StoreController extends ApiBaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected StoreService $storeService;
    protected ValidationService $validationService;

    public function __construct(StoreService $storeService, ValidationService $validationService)
    {
        $this->storeService = $storeService;
        $this->validationService = $validationService;
    }

    /**
     * @OA\Get(
     *     operationId="store",
     *     tags={"Store"},
     *     summary="Get a stored key value pair",
     *     path="/api/object",
     *     @OA\Response(response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status_code", type="string", description="StatusCode", example="200"),
     *         @OA\Property(property="message", type="string", description="Message", example="Success"),
     *         @OA\Property(property="data", type="object", description="StoreInformation", ref="#/components/schemas/StoreSchema"),
     *       )
     *     ),
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $data = $this->validationService->getKeyValuePair($request->all());
        $messageBag = $this->validationService->storeValidate($data);
        if ($messageBag->isNotEmpty()) {
            return $this->jsonResponse(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                [
                    'message' => 'Validation failed',
                    'errors' => Arr::collapse($messageBag->toArray()),
                ]
            );
        }

        $data = $this->storeService->store($data);

        return $this->jsonResponse(
            Response::HTTP_OK,
            $data,
            'Success'
        );
    }

    /**
     * @OA\Get(
     *     operationId="get",
     *     tags={"Store"},
     *     summary="Get a stored key value pair",
     *     path="/api/object/{myKey}",
     *     @OA\Parameter(
     *         name="myKey",
     *         in="path",
     *         @OA\Schema(type="string"),
     *         description="Key to search by",
     *         required=true,
     *     ),
     *     @OA\Response(response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status_code", type="string", description="StatusCode", example="200"),
     *         @OA\Property(property="message", type="string", description="Message", example="Success"),
     *         @OA\Property(property="data", type="object", description="StoreInformation", ref="#/components/schemas/StoreSchema"),
     *       )
     *     ),
     * )
     */
    public function get(string $myKey, Request $request): JsonResponse
    {
        $messageBag = $this->validationService->getValidate($request->all());
        if ($messageBag->isNotEmpty()) {
            return $this->jsonResponse(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                [
                    'message' => 'Validation failed',
                    'errors' => Arr::collapse($messageBag->toArray()),
                ]
            );
        }

        if ($request->get('timestamp')) {
            $data = $this->storeService->getByKeyAndTimestamp($myKey, Carbon::createFromTimestamp($request->get('timestamp')));
        } else {
            $data = $this->storeService->getByKey($myKey);
        }

        if (!$data) {
            return $this->jsonResponse(
                Response::HTTP_NOT_FOUND,
                null,
                'Resource Not Found'
            );
        }

        return $this->jsonResponse(
            Response::HTTP_OK,
            $data,
            'Success'
        );
    }

    /**
     * @OA\Get(
     *     operationId="all",
     *     tags={"Store"},
     *     summary="Get all stored key value pairs",
     *     path="/api/object/get_all_records",
     *     @OA\Response(response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status_code", type="string", description="StatusCode", example="200"),
     *         @OA\Property(property="message", type="string", description="Message", example="Success"),
     *         @OA\Property(property="data", type="object", description="StoreInformation", ref="#/components/schemas/StoreSchema"),
     *       )
     *     ),
     * )
     */
    public function all(Request $request): JsonResponse
    {
        $data = $this->storeService->getAll();

        return $this->jsonResponse(
            Response::HTTP_OK,
            $data,
            'Success'
        );
    }
}
