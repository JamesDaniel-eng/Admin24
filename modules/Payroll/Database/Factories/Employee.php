<?php

namespace Modules\Payroll\Database\Factories;

use App\Abstracts\Factory;
use App\Models\Common\Contact;
use App\Utilities\Date;
use Modules\Payroll\Models\Employee\Employee as Model;

class Employee extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    public function definition(): array
    {
        $contact = Contact::type('employee')->enabled()->inRandomOrder()->first();
        if (!$contact) {
            $contact = Contact::factory()->type('employee')->create();
        }

        $contact_at = $this->faker->dateTimeBetween(now()->startOfYear(), now()->endOfYear())->format('Y-m-d');

        $date = Date::parse($contact_at)->addDays(10)->format('Y-m-d');

        $genders = [
            'male'   => trans('employees::employees.male'),
            'female' => trans('employees::employees.female'),
            'other'  => trans('employees::employees.other')
        ];

        return [
            'name'                => $this->faker->name,
            'company_id'          => $this->company->id,
            'contact_id'          => $contact->id,
            'birth_day'           => $date,
            'hired_at'            => $date,
            'email'               => $this->faker->safeEmail,
            'enabled'             => 1,
            'currency_code'       => setting('default.currency'),
            'amount'              => $this->faker->randomFloat(2, 10, 20),
            'phone'               => $this->faker->phoneNumber,
            'salary_type'         => 'monthly',
            'department_id'       => 1,
            'gender'              => $this->faker->randomElement($genders),
            'bank_account_number' => $this->faker->iban(),
        ];
    }
}
