<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class History extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function getdataAttribute(): array
    {
        return json_decode($this->attributes['data'] ?? '[]', true) ?? [];
    }
    public function setdataAttribute(array $data): void
    {
        $this->attributes['data'] = json_encode($data);
    }

    public static function store(array $data) : array
    {
        DB::beginTransaction();

        try {
            self::create($data);
            DB::commit();
            return ['status' => true];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
    
}
