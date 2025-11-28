<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Response;

class QRCodeController extends Controller
{
    /**
     * generate qr
     */
    public function generate($id): Response
    {
        $permission = Permission::with(['student.user'])
            ->where('status', 'approved')
            ->where('permission_id', $id)
            ->firstOrFail();

    // membuat data qr berupa url langsung ke detail izin
        $url = url('/permissions/' . $permission->permission_id);

    // generate qr
        $qrCode = QrCode::format('svg')
            ->size(300)
            ->generate($url);
        // Pastikan tidak ada spasi/kosong sebelum deklarasi XML
        $qrCode = ltrim($qrCode);
        return response($qrCode, 200)
            ->header('Content-Type', 'image/svg+xml');
    }

    /**
     * verifikasi qr
     */
    public function verify(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        try {
            $data = json_decode($request->qr_data, true);
            
            if (!$data || !isset($data['id'])) {
                return response()->json([
                    'valid' => false,
                    'message' => 'QR Code is not valid.'
                ]);
            }

            $permission = Permission::with(['student.user'])
                ->where('permission_id', $data['id'])
                ->first();

            if (!$permission) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Permission not found.'
                ]);
            }

            if ($permission->status !== 'approved') {
                return response()->json([
                    'valid' => false,
                    'message' => 'Permission not approved.'
                ]);
            }

            // cek apakah izin aktif
            $isActive = $permission->time_end ? now()->lte($permission->time_end) : true;

            return response()->json([
                'valid' => true,
                'active' => $isActive,
                'permission' => [
                    'id' => $permission->permission_id,
                    'student_name' => $permission->student->user->name,
                    'student_number' => $permission->student->student_number,
                    'class_name' => $permission->student->class_name,
                    'reason' => $permission->reason,
                    'time_start' => $permission->time_start->format('Y-m-d H:i'),
                    'time_end' => $permission->time_end ? $permission->time_end->format('Y-m-d H:i') : null,
                    'status' => $permission->status,
                ],
                'message' => $isActive ? 'Permission is valid and active.' : 'Permission is valid but has expired.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => 'QR Code cannot be verified.'
            ]);
        }
    }
}