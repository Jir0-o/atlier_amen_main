<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkVariant extends Model
{
    protected $fillable = ['work_id', 'sku', 'price', 'stock'];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'work_variant_attribute_value');
    }

    public function combinationText(): string
    {
        $g = $this->attributeValues->groupBy(fn($v) => $v->attribute->name);
        return $g->map(fn($vals, $attr) => $attr.': '.$vals->pluck('value')->join(', '))
                 ->values()
                 ->join(' / ');
    }
}
