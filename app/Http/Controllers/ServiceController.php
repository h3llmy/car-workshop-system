<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Service::class);

        $service = Service::paginate(10);

        return response()->json([
            'message' => 'Success',
            'data' => $service,
        ]);
    }

    public function done(Service $service)
    {
        $this->authorize('done', Service::class);

        $service->is_done = true;
        $service->save();

        return response()->json([
            'message' => 'Success',
            'data' => $service,
        ]);
    }
}
