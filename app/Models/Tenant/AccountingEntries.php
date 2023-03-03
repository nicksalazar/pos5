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
class AccountingEntries extends ModelTenant

{
    protected $table='accounting_entries';
    protected $fillable = [
        'id',
        'user_id',
        'seat',
        'seat_general',
        'seat_line',
        'seat_date',
        'account_movement_id',
        'types_accounting_entrie_id',
        'comment',
        'serie',
        'number',
        'debe',
        'haber',
        'seat_cost',
        'revised1',
        'user_revised1',
        'revised2',
        'user_revised2',
        'currency_code',
        'doctype',
        'is_client',
        'person_id',
        'created_at',
        'updated_at',

    ];

    public function scopeWhereTypeUser($query, $params= [])
    {
        if(isset($params['user_id'])) {
            $user_id = (int)$params['user_id'];
            $user = User::find($user_id);
            if(!$user) {
                $user = new User();
            }
        }
        else {
            $user = auth()->user();
        }
        return ($user->type == 'seller') ? $query->where('user_id', $user->id) : null;
    }

    public function scopeTipo($query,$user)
    {
        return $query->where('seat_general',$user);
    }

    public function usuario($query)
    {
        $user = User::find($query->user_id);
        return $query->where('user_id', $user->id);
    }

    public function detalles()
    {
        return $this->hasMany(AccountingEntries::class,'seat_general', 'seat_general');
    }
    public function cuenta()
    {
        return $this->belongsTo(AccountingEntries::class, 'seat_general', 'seat_general');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type_account()
    {
        return $this->belongsTo(TypesAccountingEntries::class,'types_accounting_entrie_id','id');
    }
    
}
