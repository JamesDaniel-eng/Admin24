<?php

namespace Modules\Employees\Models;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;

class Dismissal extends Model
{
    use Cloneable;

    protected $table = 'employees_dismissals';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'employee_id',
        'type',
        'dismissal_date',
        'reason',
    ];

    public function employees()
    {
        return $this->hasMany('Modules\Employees\Models\Employee');
    }

    public function employee()
    {
        return $this->belongsTo('Modules\Employees\Models\Employee');
    }
}
