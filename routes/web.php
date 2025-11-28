<?php
use App\Http\Controllers\GuruController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\QRCodeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// rute landing page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// rute autentikasi
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth')
            ->name('logout');


Route::post('/qr/verify', [QRCodeController::class, 'verify'])->name('qr.verify');

//rute atmin
Route::middleware(['auth', 'role:admin_bk'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/permissions', [AdminController::class, 'permissions'])->name('permissions');
    Route::get('/permissions/export/excel', [AdminController::class, 'exportPermissions'])->name('permissions.export.excel');
        Route::get('/permissions/export', [AdminController::class, 'exportPermissions'])->name('admin.permissions.export.excel');
    Route::get('/permissions/{id}', [AdminController::class, 'permissionDetail'])->name('permission.detail');
    Route::patch('/permissions/{id}/status', [AdminController::class, 'updatePermissionStatus'])->name('permission.update-status');
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::patch('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

    //manage data pengguna
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    //hapus izin
    Route::delete('/permissions/{id}', [AdminController::class, 'destroyPermission'])->name('permission.destroy');
    // bulk delete izin
    Route::post('/permissions/bulk-delete', [AdminController::class, 'bulkDeletePermissions'])->name('permissions.bulk-delete');
    // export excel izin terpilih
    Route::get('/permissions/export/excel-selected', [AdminController::class, 'exportSelectedPermissions'])->name('permissions.export.excel.selected');
});


//rute guru
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/riwayat-izin', [GuruController::class, 'riwayatIzin'])->name('riwayatizin');
    Route::get('/permissions/{id}', [GuruController::class, 'permissionDetail'])->name('permission.detail');
    Route::get('/profile', [GuruController::class, 'profile'])->name('profile');
    Route::patch('/profile', [GuruController::class, 'updateProfile'])->name('profile.update');
    Route::post('/approve/{id}', [GuruController::class, 'approve'])->name('approve');
    Route::post('/reject/{id}', [GuruController::class, 'reject'])->name('reject');
});

// rute role siswa
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/permissions', [StudentController::class, 'permissions'])->name('permissions');
    Route::get('/permissions/create', [StudentController::class, 'createPermission'])->name('permission.create');
    Route::post('/permissions', [StudentController::class, 'storePermission'])->name('permission.store');
    Route::get('/permissions/{id}', [StudentController::class, 'permissionDetail'])->name('permission.detail');
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::patch('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
});

// rute notifikasi
use App\Http\Controllers\NotificationController;
Route::post('/notification/{id}/read', [NotificationController::class, 'markAsRead'])->where('id', '[0-9]+|all')->name('notification.read')->middleware('auth');

// rute qr
Route::middleware('auth')->group(function () {
    Route::get('/qr/{id}', [QRCodeController::class, 'generate'])->name('qr.generate');
});

// halaman detail izin publik (tanpa login)
use App\Http\Controllers\PublicPermissionController;
Route::get('/permissions/{id}', [PublicPermissionController::class, 'show'])->name('public.permission.detail');

//hold me now, im six feet from the edge and I'm thinking 
//maybe six feet ain't so far down