<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nrp',
        'email',
        'password',
        'profile_photo',
        'role',
        'jabatan',
        'pj_number',
        'status',
        'kelompok',
        'hobi',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat_asal',
        'alamat_surabaya',
        'nama_ortu',
        'alamat_ortu',
        'no_hp_ortu',
        'no_hp',
        'golongan_darah',
        'alergi',
        'riwayat_penyakit',
    ];
    
    /**
     * Check if user is superadmin
     */
    public function isSuperadmin()
    {
        return $this->role === 'superadmin';
    }
    
    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    /**
     * Check if user is member
     */
    public function isMember()
    {
        return $this->role === 'member';
    }
    
    /**
     * Submissions relationship
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    
    /**
     * Scores relationship
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    
    /**
     * Hitung KPI (Kumulatif Poin Individu) = Total semua PI
     * PI per assignment = (has_submission ? 1 : 0) × GDK total multiplier
     */
    public function getKpiAttribute()
    {
        // Get all assignments
        $assignments = Assignment::with('gdkFlowchart.metode.materi.nilai')->get();
        
        $totalPI = 0;
        foreach ($assignments as $assignment) {
            // Check if user has submitted this assignment
            $hasSubmission = $this->submissions()->where('assignment_id', $assignment->id)->exists();
            
            // Get GDK multiplier
            $gdkMultiplier = 0;
            if ($assignment->gdkFlowchart && $assignment->gdkFlowchart->metode) {
                $gdkMultiplier = $assignment->gdkFlowchart->total_multiplier;
            }
            
            // Calculate PI for this assignment
            $pi = ($hasSubmission ? 1 : 0) * $gdkMultiplier;
            $totalPI += $pi;
        }
        
        return $totalPI;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get full jabatan label with PJ number if applicable
     */
    public function getJabatanLabelAttribute()
    {
        if ($this->jabatan === 'PJ' && $this->pj_number !== null) {
            return 'PJ-' . $this->pj_number;
        }
        return $this->jabatan;
    }
}
