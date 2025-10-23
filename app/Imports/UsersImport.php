<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip baris kosong
        if (empty($row['nama']) || empty($row['email'])) {
            return null;
        }

        return new User([
            'name' => $this->toString($row['nama']),
            'email' => $this->toString($row['email']),
            'nrp' => $this->toString($row['nrp'] ?? null),
            'role' => $this->toString($row['role'] ?? 'member'),
            'kelompok' => $this->toString($row['kelompok'] ?? null),
            'hobi' => $this->toString($row['hobi'] ?? null),
            'password' => Hash::make($this->toString($row['password'] ?? 'password123')),
            'tempat_lahir' => $this->toString($row['tempat_lahir'] ?? null),
            'tanggal_lahir' => $this->parseDate($row['tanggal_lahir'] ?? null),
            'jenis_kelamin' => $this->toString($row['jenis_kelamin'] ?? null),
            'alamat_asal' => $this->toString($row['alamat_asal'] ?? null),
            'alamat_surabaya' => $this->toString($row['alamat_surabaya'] ?? null),
            'nama_ortu' => $this->toString($row['nama_ortu'] ?? null),
            'alamat_ortu' => $this->toString($row['alamat_ortu'] ?? null),
            'no_hp_ortu' => $this->toString($row['no_hp_ortu'] ?? null),
            'no_hp' => $this->toString($row['no_hp'] ?? null),
        ]);
    }

    /**
     * Convert value to string safely (handles numeric values from Excel)
     */
    private function toString($value)
    {
        if ($value === null || $value === '') {
            return null;
        }
        
        // Convert to string and trim whitespace
        return trim((string) $value);
    }

    /**
     * Parse berbagai format tanggal ke format MySQL (Y-m-d)
     */
    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            // Array format tanggal yang umum digunakan
            $formats = [
                'd F Y',           // 06 September 2006
                'd M Y',           // 06 Sep 2006
                'd/m/Y',           // 06/09/2006
                'd-m-Y',           // 06-09-2006
                'Y-m-d',           // 2006-09-06 (MySQL format)
                'm/d/Y',           // 09/06/2006 (US format)
                'Y/m/d',           // 2006/09/06
                'd.m.Y',           // 06.09.2006
            ];

            // Coba parsing dengan berbagai format
            foreach ($formats as $format) {
                try {
                    $parsedDate = Carbon::createFromFormat($format, $date);
                    if ($parsedDate) {
                        return $parsedDate->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            // Jika tidak ada format yang cocok, coba parse otomatis dengan Carbon
            $parsedDate = Carbon::parse($date);
            return $parsedDate->format('Y-m-d');

        } catch (\Exception $e) {
            // Jika parsing gagal, return null
            return null;
        }
    }

    /**
     * Validation rules untuk import
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'nrp' => 'nullable|max:20|unique:users,nrp',
            'role' => 'nullable|in:member,admin,superadmin',
            'kelompok' => 'nullable|max:50',
        ];
    }

    /**
     * Custom error messages
     */
    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'nrp.unique' => 'NRP sudah terdaftar',
            'role.in' => 'Role harus: member, admin, atau superadmin',
        ];
    }
}
