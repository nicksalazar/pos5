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
        'third_code',
        'created_at',
        'updated_at',

    ];

    

}
