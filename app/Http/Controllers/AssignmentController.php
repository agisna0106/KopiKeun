<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Cart;
use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    /**
     * Display a listing of assignments.
     */
    public function index(): View
    {
        $assignments = Assignment::with([
            'employee.user',
            'cart',
            'region',
        ])
            ->latest('start_date')
            ->latest()
            ->get();

        return view('assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new assignment.
     */
    public function create(): View
    {
        $employees = Employee::with('user')
            ->where('status', 'Active')
            ->orderBy('employee_code')
            ->get();

        $carts = Cart::where('status', 'active')
            ->orderBy('name')
            ->get();

        $regions = Region::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('assignments.create', compact(
            'employees',
            'carts',
            'regions'
        ));
    }

    /**
     * Store a newly created assignment.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => [
                'required',
                'exists:employees,id',
            ],

            'cart_id' => [
                'required',
                'exists:carts,id',
            ],

            'region_id' => [
                'required',
                'exists:regions,id',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Prevent Multiple Active Assignments
        |--------------------------------------------------------------------------
        */

        if ($validated['status'] === 'active') {

            $activeAssignmentExists = Assignment::where(
                'employee_id',
                $validated['employee_id']
            )
                ->where('status', 'active')
                ->exists();

            if ($activeAssignmentExists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'employee_id' =>
                            'This employee already has an active assignment.',
                    ]);
            }
        }

        Assignment::create($validated);

        return redirect()
            ->route('assignments.index')
            ->with('success', 'Assignment created successfully.');
    }

    /**
     * Show the form for editing the specified assignment.
     */
    public function edit(Assignment $assignment): View
    {
        $employees = Employee::with('user')
            ->where(function ($query) use ($assignment) {
                $query->where('status', 'Active')
                    ->orWhere('id', $assignment->employee_id);
            })
            ->orderBy('employee_code')
            ->get();

        $carts = Cart::where(function ($query) use ($assignment) {
            $query->where('status', 'active')
                ->orWhere('id', $assignment->cart_id);
        })
            ->orderBy('name')
            ->get();

        $regions = Region::where(function ($query) use ($assignment) {
            $query->where('status', 'active')
                ->orWhere('id', $assignment->region_id);
        })
            ->orderBy('name')
            ->get();

        return view('assignments.edit', compact(
            'assignment',
            'employees',
            'carts',
            'regions'
        ));
    }

    /**
     * Update the specified assignment.
     */
    public function update(
        Request $request,
        Assignment $assignment
    ): RedirectResponse {
        $validated = $request->validate([
            'employee_id' => [
                'required',
                'exists:employees,id',
            ],

            'cart_id' => [
                'required',
                'exists:carts,id',
            ],

            'region_id' => [
                'required',
                'exists:regions,id',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Prevent Multiple Active Assignments
        |--------------------------------------------------------------------------
        */

        if ($validated['status'] === 'active') {

            $activeAssignmentExists = Assignment::where(
                'employee_id',
                $validated['employee_id']
            )
                ->where('status', 'active')
                ->where('id', '!=', $assignment->id)
                ->exists();

            if ($activeAssignmentExists) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'employee_id' =>
                            'This employee already has another active assignment.',
                    ]);
            }
        }

        $assignment->update($validated);

        return redirect()
            ->route('assignments.index')
            ->with('success', 'Assignment updated successfully.');
    }
}
