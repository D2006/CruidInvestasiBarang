<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->session()->get('user_id');

        // Summary counts
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalSuperadmins = User::where('role', 'superadmin')->count();

        $totalItems = Barang::count();
        $myItems = $userId ? Barang::where('owner_id', $userId)->count() : 0;

        // Recent items (limit 6)
        $recentItems = Barang::with('owner')->orderBy('created_at', 'desc')->take(6)->get();

        // Compute items per role (aggregate)
        $itemsPerRole = [
            'superadmin' => 0,
            'admin' => 0,
            'user' => 0,
        ];

        $itemsByOwner = Barang::selectRaw('count(*) as total, owner_id')
            ->whereNotNull('owner_id')
            ->groupBy('owner_id')
            ->pluck('total', 'owner_id');

        if ($itemsByOwner->count()) {
            $owners = User::whereIn('id', $itemsByOwner->keys())->get(['id', 'role']);
            foreach ($owners as $owner) {
                $count = $itemsByOwner->get($owner->id) ?? 0;
                if (isset($itemsPerRole[$owner->role])) {
                    $itemsPerRole[$owner->role] += $count;
                }
            }
        }

        // Build arrays for Chart.js but only include roles with count > 0
        $roleColors = [
            'superadmin' => '#6f42c1',
            'admin'      => '#0d6efd',
            'user'       => '#20c997',
        ];

        $chartLabels = [];
        $chartData = [];
        $chartColors = [];
        foreach ($itemsPerRole as $roleKey => $val) {
            if ($val > 0) {
                $chartLabels[] = ucfirst($roleKey);
                $chartData[] = $val;
                $chartColors[] = $roleColors[$roleKey] ?? '#888';
            }
        }

        return view('dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalSuperadmins',
            'totalItems',
            'myItems',
            'recentItems',
            'itemsPerRole',
            'chartLabels',
            'chartData',
            'chartColors'
        ));
    }
}
