<?php

namespace App\Http\Controllers\Api;

use App\Services\StoreService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class StoreController extends ApiBaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected StoreService $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
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
        $messageBag = $this->validate($request->all());
        if ($messageBag->isNotEmpty()) {
            return $this->jsonResponse(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                [
                    'message' => 'Validation failed',
                    'errors' => Arr::collapse($messageBag->toArray()),
                ]
            );
        }

        $data = $this->storeService->store($request->all());

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
        if ($request->get('timestamp')) {
            $data = $this->storeService->getByKeyAndTimestamp($myKey, Carbon::createFromTimestampUTC($request->get('timestamp')));
        } else {
            $data = $this->storeService->getByKey($myKey);
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

    private function validate(array $data): MessageBag
    {
        $rules = [
            "mykey" => "required|max:255",
            "value" => "required|max:65535",
            "timestamp" => "sometimes|required|numeric",
        ];

        return Validator::make($data, $rules)->errors();
    }
}
