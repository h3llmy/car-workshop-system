<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RepairProposal;
use App\Http\Requests\RepairProposal\CreateRepairProposalRequest;
use App\Http\Requests\RepairProposal\UpdateRepairProposalRequest;
use App\Http\Requests\RepairProposal\AcceptRepairProposal;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class RepairProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', RepairProposal::class);

        $repairProposal = RepairProposal::paginate(10);
        return response()->json([
            'message' => 'get all repair proposals success',
            'data' => $repairProposal
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRepairProposalRequest $request)
    {
        $repairProposal = RepairProposal::create([
            'car_id' => $request->car_id,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'create repair proposal success',
            'data' => $repairProposal
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairProposal $repairProposal)
    {
        $this->authorize('view', $repairProposal);
        return response()->json([
            'message' => 'get repair proposal success',
            'data' => $repairProposal
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepairProposalRequest $request, RepairProposal $repairProposal)
    {
        if ($repairProposal->is_approved) {
            return response()->json([
                'message' => 'You cannot update an approved repair proposal'
            ], 400);
        }

        $repairProposal->update([
            'car_id' => $request->car_id,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'update repair proposal success',
            'data' => $repairProposal
        ]);
    }

    /**
     * Super Admin accept the proposal
     */
    public function accept(AcceptRepairProposal $request, RepairProposal $repairProposal)
    {
        $this->authorize('accept', RepairProposal::class);

        if ($repairProposal->is_approved) {
            return response()->json([
                'message' => 'repair proposal already approved'
            ], 400);
        }

        DB::beginTransaction();

        try {
            $repairProposal->update([
                'is_approved' => true,
            ]);

            $servicesData = collect($request->services)
                ->map(function ($service) use ($repairProposal) {
                    return [
                        'name' => $service['name'],
                        'price' => $service['price'],
                        'description' => $service['description'],
                        'repair_proposal_id' => $repairProposal->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })->toArray();

            Service::insert($servicesData);

            // TODO
            if ($this->checkAllServiceDone($repairProposal)) {
                # code...
            }

            DB::commit();

            return response()->json([
                'message' => 'accept repair proposal success',
                'data' => $repairProposal->load('services'),
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'failed to accept repair proposal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairProposal $repairProposal)
    {
        $this->authorize('delete', $repairProposal);
        
        $repairProposal->delete();

        return response()->json([
            'message' => 'delete repair proposal success'
        ]);
    }

    private function checkAllServiceDone(RepairProposal $repairProposal)
    {
        $repairProposal->load('services');

        foreach ($repairProposal->services as $service) {
            if (!$service->is_done) {
                return false;
            }
        }

        return true;
    }
}
