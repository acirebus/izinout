<?php
//ekspor data perizinan terpilih ke file excel
namespace App\Exports;

use App\Models\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PermissionsExport implements FromCollection, WithHeadings
{
    protected $status;
    protected $search;
    protected $className;
    protected $ids;

    public function __construct($status = null, $search = null, $className = null, $ids = null)
    {
        $this->status = $status;
        $this->search = $search;
        $this->className = $className;
        $this->ids = $ids;
    }

    public function collection()
    {
        $query = Permission::with(['student.user']);
        if ($this->ids && is_array($this->ids) && count($this->ids) > 0) {
            $query->whereIn('permission_id', $this->ids);
        } else {
            if ($this->status && $this->status !== 'all') {
                $query->where('status', $this->status);
            }
            if ($this->search) {
                $query->where(function($q) {
                    $q->whereHas('student.user', function($subQ) {
                        $subQ->where('name', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('student', function($subQ) {
                        $subQ->where('class_name', 'like', "%{$this->search}%")
                              ->orWhere('reason', 'like', "%{$this->search}%");
                    });
                });
            }
            if ($this->className) {
                $query->whereHas('student', function($q) {
                    $q->where('class_name', $this->className);
                });
            }
        }
        return $query->get()->map(function($p) {
            return [
                'ID' => $p->permission_id,
                'Nama Siswa' => $p->student->user->name ?? '-',
                'Kelas' => $p->student->class_name ?? '-',
                'Alasan' => $p->reason,
                'Waktu Mulai' => $p->time_start ? $p->time_start->format('d/m/Y H:i') : '-',
                'Waktu Selesai' => $p->auto_time_end ? $p->auto_time_end->format('d/m/Y H:i') : '-',
                'Status' => $p->status,
                'Diajukan' => $p->created_at ? $p->created_at->format('d/m/Y H:i') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID', 'Nama Siswa', 'Kelas', 'Alasan', 'Waktu Mulai', 'Waktu Selesai', 'Status', 'Diajukan'
        ];
    }
}
