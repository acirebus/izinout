<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PublicPermissionController extends Controller
{
    /**
     * halaman izin (publik)
     */
    public function show($id)
    {
        $permission = Permission::with(['student.user'])
            ->where('permission_id', $id)
            ->firstOrFail();

        return view('public.permission-detail', compact('permission'));
    }
}
