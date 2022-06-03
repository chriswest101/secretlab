<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use L5Swagger\ConfigFactory;
use L5Swagger\GeneratorFactory;

/**
 * @OA\Info(
 *   version="1.0.0@dev",
 *   title="Secretlab Store API",
 *   description="New structure for OPEN API"
 * )
 */
class ApiController extends Controller
{
    protected GeneratorFactory $generatorFactory;
    private ConfigFactory $configFactory;

    public function __construct(GeneratorFactory $generatorFactory, ConfigFactory $configFactory)
    {
        $this->generatorFactory = $generatorFactory;
        $this->configFactory = $configFactory;
    }

    public function documentation()
    {
        $generator = $this->generatorFactory->make('default');
        $generator->generateDocs();

        return view('api::documentation');
    }
}
