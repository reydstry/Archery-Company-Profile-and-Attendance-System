<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageController extends Controller
{
    /**
     * Display a listing of active packages for public view
     */
    public function index()
    {
        $packages = Package::query()
            ->where('is_active', true)
            ->orderBy('price', 'asc')
            ->get();

        return response()->json([
            'data' => $packages
        ]);
    }

    /**
     * Display the specified package
     */
    public function show(Package $package)
    {
        // Hanya tampilkan paket yang aktif
        if (!$package->is_active) {
            return response()->json([
                'message' => 'Package not found',
            ], 404);
        }

        return response()->json([
            'data' => $package,
        ]);
    }
}
