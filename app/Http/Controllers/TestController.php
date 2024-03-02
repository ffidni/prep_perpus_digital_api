<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestRequest;
use App\Http\Resources\ApiResponse;
use App\Library\HelperLib;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function postTest(TestRequest $request)
    {

        $image = HelperLib::uploadFile($request->image, "buku", "cover", null);
        return new ApiResponse(200, "Testisng", $request->image);
    }

    public function getTest(TestRequest $request)
    {
        $image = HelperLib::uploadFile($request->image, "buku", "cover");
        return new ApiResponse(200, "Testing", $image);
    }
}
