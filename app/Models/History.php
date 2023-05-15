<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
