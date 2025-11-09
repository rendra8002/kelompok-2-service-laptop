<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with(['customer', 'laptop'])->latest()->take(10)->get();

        // Statistik dashboard
        $totalCustomers = \App\Models\User::where('role', 'costumer')->count();
        $totalTechnicians = \App\Models\User::where('role', 'technician')->count();
        $totalLaptops = \App\Models\Laptop::count();
        $totalServices = \App\Models\Service::count();
        $servicesInProgress = \App\Models\Service::where('status', 'process')->count();
        $finishedServices = \App\Models\Service::where('status', 'finished')->count();
        $totalIncome = \App\Models\Service::sum('total_cost');

        return view('pages.home', compact(
            'services',
            'totalCustomers',
            'totalTechnicians',
            'totalLaptops',
            'totalServices',
            'servicesInProgress',
            'finishedServices',
            'totalIncome'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
