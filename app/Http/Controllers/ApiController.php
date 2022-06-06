<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use L5Swagger\GeneratorFactory;

/**
 * @OA\Info(
 *   version="1.0.0@dev",
 *   title="Secretlab Store API",
 *   description="New structure for OPEN API"
 * ),
 * @OA\Server(
 *   url=L5_SWAGGER_CONST_HOST
 * )
 */
class ApiController extends Controller
{
    protected GeneratorFactory $generatorFactory;

    public function __construct(GeneratorFactory $generatorFactory)
    {
        $this->generatorFactory = $generatorFactory;
    }

    public function documentation()
    {
        $generator = $this->generatorFactory->make('secretlab');
        $generator->generateDocs();

        return view('api::documentation');
    }
}
