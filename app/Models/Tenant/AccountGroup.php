<?php

namespace App\Models\Tenant;

/**
 * App\Models\Tenant\PersonType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tenant\Person[] $person
 * @property-read int|null $person_count
 * @method static \Illuminate\Database\Eloquent\Builder|PersonType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonType query()
 * @mixin \Eloquent
 */
class AccountGroup extends ModelTenant
{
    protected $fillable = [
        'code',
        'description',
        'type',

    ];

    public function account_movements()
    {
        return $this->hasMany(AccountGroup::class);
    }

    public function scopeInUse($query,$id)
    {
        $datos= AccountMovement::where('account_group_id','=',$id)->count()>0?true:false;
        return $datos;
    }
    

}
