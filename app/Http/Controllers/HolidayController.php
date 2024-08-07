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
            "location" => ["required", "string"],
            "date" => ["required", "date"],
            "participants" => "integer",
        ]);

        $data['user_id'] = $request->user()->id;

        return Holiday::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $holiday = Holiday::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

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
        ]);

        $holiday = Holiday::where('id', $id)
            ->where('user_id', $request->user()->id)
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
        $holiday = Holiday::where('id',$id)
            ->where('user_id', $request->user()->id)
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
