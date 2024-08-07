<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Services\PdfService;
use Illuminate\Http\Request;

class HolidayController extends Controller
{

    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->user()->holidays()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => ["required", "string"],
            "description" => ["required", "string"],
            "date" => ["required", "date"],
            "participants" => "integer",
            "user_id" => ['required', "exists:users,id"]
        ]);

        return Holiday::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $holiday = Holiday::find($id);
        if (!$holiday) {
            return response()->json(['message' => 'Holiday not found.'], 404);
        }

        return response()->json($holiday);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            "title" => ["string"],
            "description" => ["string"],
            "date" => ["date"],
            "participants" => "integer",
            "user_id" => ['required', "exists:users,id"]
        ]);

        $holiday = Holiday::where('id', $id)
            ->where('user_id', $data['user_id'])
            ->first();

        if (!$holiday) {
            return response()->json(['message' => 'Holiday not found.'], 404);
        }

        $holiday->update($data);

        return response()->json($holiday);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $data = $request->validate([
            "user_id" => ['required', "exists:users,id"]
        ]);

        $holiday = Holiday::where('id',$id)
            ->where('user_id', $data['user_id'])
            ->first();

        if (!$holiday) {
            return response()->json(['message' => 'Holiday not found.'], 404);
        }

        $holiday->delete();

        return response()->json(['message' => 'Holiday deleted successfully.']);
    }

    public function generatePdf(Request $request) {
        $holidays = $request->user()->holidays()->get();
        
        return $this->pdfService->generatePdf($holidays->toArray());
    }

}
