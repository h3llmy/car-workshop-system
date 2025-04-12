<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complain;
use App\Http\Requests\Complain\CreateComplainRequest;

class ComplainController extends Controller
{
    public function index() {
        $this->authorize('viewAny', Complain::class);

        $user = auth()->user();
        $complains = collect(); // default empty collection

        if ($user->hasRole('car owner')) {
            $complains = Complain::whereHas('repairProposal.car', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->paginate(10);
        } else {
            $complains = Complain::paginate(10);
        }

        return response()->json([
            'message' => 'Complains fetched successfully',
            'data' => $complains,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function store(CreateComplainRequest $request)
    {
        $complain = Complain::create([
            'description' => $request->description,
            'repair_proposal_id' => $request->repair_proposal_id,
        ]);

        return response()->json([
            'message' => 'Complain created successfully',
            'data' => $complain,
        ]);
    }
}
