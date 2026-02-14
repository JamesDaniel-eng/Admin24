<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Auth{
/**
 * App\Models\Auth\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $title
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Auth\Role> $roles
 * @method static \Illuminate\Database\Eloquent\Builder|Permission action($action = 'read')
 * @method static \Illuminate\Database\Eloquent\Builder|Permission collect($sort = 'display_name')
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission usingSearchString($string)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models\Auth{
/**
 * App\Models\Auth\Role
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string|null $description
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $line_actions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Auth\Permission> $permissions
 * @method static \Illuminate\Database\Eloquent\Builder|Role collect($sort = 'display_name')
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Role usingSearchString($string)
 */
	class Role extends \Eloquent {}
}

namespace App\Models\Auth{
/**
 * App\Models\Auth\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $last_logged_in_at
 * @property string $locale
 * @property string|null $landing_page
 * @property bool $enabled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Common\Company> $companies
 * @property-read \App\Models\Common\Contact|null $contact
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Dashboard> $dashboards
 * @property-read mixed $last_logged
 * @property-read mixed $line_actions
 * @property-read mixed $picture
 * @property-read \App\Models\Auth\UserInvitation|null $invitation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Auth\Permission> $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Auth\Role> $roles
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|User collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|User email($email)
 * @method static \Illuminate\Database\Eloquent\Builder|User enabled()
 * @method static \Database\Factories\User factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|User isCustomer()
 * @method static \Illuminate\Database\Eloquent\Builder|User isEmployee()
 * @method static \Illuminate\Database\Eloquent\Builder|User isNotCustomer()
 * @method static \Illuminate\Database\Eloquent\Builder|User isNotEmployee()
 * @method static \Illuminate\Database\Eloquent\Builder|User isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|User isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|User orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|User usingSearchString($string)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHavePermission()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHaveRole()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Translation\HasLocalePreference {}
}

namespace App\Models\Auth{
/**
 * App\Models\Auth\UserCompany
 *
 * @property int $user_id
 * @property int $company_id
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \App\Models\Auth\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany withoutTrashed()
 */
	class UserCompany extends \Eloquent {}
}

namespace App\Models\Auth{
/**
 * App\Models\Auth\UserDashboard
 *
 * @property int $user_id
 * @property int $dashboard_id
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Dashboard|null $dashboard
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Dashboard> $dashboards
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \App\Models\Auth\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDashboard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDashboard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDashboard onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDashboard query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDashboard withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDashboard withoutTrashed()
 */
	class UserDashboard extends \Eloquent {}
}

namespace App\Models\Auth{
/**
 * App\Models\Auth\UserInvitation
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \App\Models\Auth\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation token($token)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation withoutTrashed()
 */
	class UserInvitation extends \Eloquent {}
}

namespace App\Models\Auth{
/**
 * App\Models\Auth\UserRole
 *
 * @property int $user_id
 * @property int $role_id
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \App\Models\Auth\Role $role
 * @property-read \App\Models\Auth\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole withoutTrashed()
 */
	class UserRole extends \Eloquent {}
}

namespace App\Models\Banking{
/**
 * App\Models\Banking\Account
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property string $name
 * @property string $number
 * @property string $currency_code
 * @property float $opening_balance
 * @property string|null $bank_name
 * @property string|null $bank_phone
 * @property string|null $bank_address
 * @property bool $enabled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Setting\Currency|null $currency
 * @property-read mixed $balance
 * @property-read mixed $expense_balance
 * @property-read mixed $income_balance
 * @property-read mixed $initials
 * @property-read mixed $line_actions
 * @property-read mixed $title
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Banking\Reconciliation> $reconciliations
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Banking\Transaction> $transactions
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Database\Factories\Account factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Account name($name)
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account number($number)
 * @method static \Illuminate\Database\Eloquent\Builder|Account onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Account withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account withoutTrashed()
 */
	class Account extends \Eloquent {}
}

namespace App\Models\Banking{
/**
 * App\Models\Banking\Reconciliation
 *
 * @property int $id
 * @property int $company_id
 * @property int $account_id
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon $ended_at
 * @property float $closing_balance
 * @property array|null $transactions
 * @property bool $reconciled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Banking\Account|null $account
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $line_actions
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Database\Factories\Reconciliation factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reconciliation withoutTrashed()
 */
	class Reconciliation extends \Eloquent {}
}

namespace App\Models\Banking{
/**
 * App\Models\Banking\Transaction
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property string $number
 * @property \Illuminate\Support\Carbon $paid_at
 * @property float $amount
 * @property string $currency_code
 * @property float $currency_rate
 * @property int $account_id
 * @property int|null $document_id
 * @property int|null $contact_id
 * @property int $category_id
 * @property string|null $description
 * @property string $payment_method
 * @property string|null $reference
 * @property int $parent_id
 * @property int|null $split_id
 * @property int $reconciled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Banking\Account|null $account
 * @property-read \App\Models\Document\Document|null $bill
 * @property-read \App\Models\Setting\Category|null $category
 * @property-read \Plank\Mediable\MediableCollection<int, Transaction> $children
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Contact|null $contact
 * @property-read \App\Models\Setting\Currency|null $currency
 * @property-read \App\Models\Document\Document|null $document
 * @property-read mixed $amount_before_tax
 * @property-read mixed $amount_for_account
 * @property-read mixed $amount_for_document
 * @property-read mixed $attachment
 * @property-read mixed $is_splittable
 * @property-read mixed $line_actions
 * @property-read mixed $recurring_status_label
 * @property-read mixed $route_id
 * @property-read mixed $route_name
 * @property-read mixed $tax_ids
 * @property-read mixed $total_tax
 * @property-read mixed $type_title
 * @property-read \App\Models\Document\Document|null $invoice
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read Transaction|null $parent
 * @property-read \App\Models\Common\Recurring|null $recurring
 * @property-read \Plank\Mediable\MediableCollection<int, Transaction> $splits
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Banking\TransactionTax> $taxes
 * @property-read \App\Models\Auth\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction accountId(int $account_id)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction categoryId(int $category_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction contactId(int $contact_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction documentId(int $document_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction expense()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction expenseRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction expenseTransfer()
 * @method static \Database\Factories\Transaction factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction income()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction incomeRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction incomeTransfer()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isDocument()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isNotDocument()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isNotReconciled()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isNotSplit()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isNotTransfer()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isReconciled()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isSplit()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction isTransfer()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction latest()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction number(string $number)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction paid()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction type($types)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withoutTrashed()
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models\Banking{
/**
 * App\Models\Banking\TransactionTax
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property int $transaction_id
 * @property int $tax_id
 * @property string $name
 * @property float $amount
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \App\Models\Setting\Tax|null $tax
 * @property-read \App\Models\Banking\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax expense()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax expenseRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax expenseTransfer()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax income()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax incomeRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax incomeTransfer()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax isDocument()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax isNotDocument()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax isNotSplit()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax isNotTransfer()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax isSplit()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax isTransfer()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax type($types)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionTax withoutTrashed()
 */
	class TransactionTax extends \Eloquent {}
}

namespace App\Models\Banking{
/**
 * App\Models\Banking\Transfer
 *
 * @property int $id
 * @property int $company_id
 * @property int $expense_transaction_id
 * @property int $income_transaction_id
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Banking\Transaction|null $expense_transaction
 * @property-read mixed $amount
 * @property-read mixed $attachment
 * @property-read mixed $description
 * @property-read mixed $from_account_id
 * @property-read mixed $from_account_rate
 * @property-read mixed $from_currency_code
 * @property-read mixed $line_actions
 * @property-read mixed $payment_method
 * @property-read mixed $reference
 * @property-read mixed $template_path
 * @property-read mixed $to_account_id
 * @property-read mixed $to_account_rate
 * @property-read mixed $to_currency_code
 * @property-read mixed $transferred_at
 * @property-read \App\Models\Banking\Transaction|null $income_transaction
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Database\Factories\Transfer factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer withoutTrashed()
 */
	class Transfer extends \Eloquent {}
}

namespace App\Models\Common{
/**
 * App\Models\Common\Company
 *
 * @property int $id
 * @property string|null $domain
 * @property bool $enabled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Banking\Account> $accounts
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Setting\Category> $categories
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\ContactPerson> $contact_persons
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Common\Contact> $contacts
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Setting\Currency> $currencies
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Dashboard> $dashboards
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentHistory> $document_histories
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentItemTax> $document_item_taxes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentItem> $document_items
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentTotal> $document_totals
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Document\Document> $documents
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Setting\EmailTemplate> $email_templates
 * @property-read mixed $company_logo
 * @property-read mixed $line_actions
 * @property-read mixed $location
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\ItemTax> $item_taxes
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Common\Item> $items
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Module\ModuleHistory> $module_histories
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Module\Module> $modules
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Banking\Reconciliation> $reconciliations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Recurring> $recurring
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Report> $reports
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Setting\Setting> $settings
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Setting\Tax> $taxes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Banking\TransactionTax> $transaction_taxes
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Banking\Transaction> $transactions
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Banking\Transfer> $transfers
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Auth\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Widget> $widgets
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Company autocomplete($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Company collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Company enabled($value = 1)
 * @method static \Database\Factories\Company factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Company isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Company isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Company source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Company userId($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Company usingSearchString($string)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Company withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Company withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Company withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Company withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Company withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Company withoutTrashed()
 */
	class Company extends \Eloquent implements \Laratrust\Contracts\Ownable {}
}

namespace App\Models\Common{
/**
 * App\Models\Common\Contact
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property string $name
 * @property string|null $email
 * @property int|null $user_id
 * @property string|null $tax_number
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string|null $zip_code
 * @property string|null $state
 * @property string|null $country
 * @property string|null $website
 * @property string $currency_code
 * @property bool $enabled
 * @property string|null $reference
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\ContactPerson> $contact_persons
 * @property-read \App\Models\Setting\Currency|null $currency
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Document\Document> $documents
 * @property-read mixed $has_email
 * @property-read mixed $initials
 * @property-read mixed $line_actions
 * @property-read mixed $location
 * @property-read mixed $logo
 * @property-read mixed $open
 * @property-read mixed $overdue
 * @property-read mixed $unpaid
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Banking\Transaction> $transactions
 * @property-read \App\Models\Auth\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact customer()
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact email($email)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact employee()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Database\Factories\Contact factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact type($types)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact vendor()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Contact withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact withoutTrashed()
 */
	class Contact extends \Eloquent {}
}

namespace App\Models\Common{
/**
 * App\Models\Common\ContactPerson
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property int $contact_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Contact|null $contact
 * @property-read mixed $initials
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson customer()
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson email($email)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson employee()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson type(array $types)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson vendor()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson withoutTrashed()
 */
	class ContactPerson extends \Eloquent {}
}

namespace App\Models\Common{
/**
 * App\Models\Common\Dashboard
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property bool $enabled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $alias
 * @property-read mixed $line_actions
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Auth\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Widget> $widgets
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard alias($alias)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Database\Factories\Dashboard factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard userId($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Dashboard withoutTrashed()
 */
	class Dashboard extends \Eloquent {}
}

namespace App\Models\Common{
/**
 * App\Models\Common\Item
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property string $name
 * @property string|null $sku
 * @property string|null $description
 * @property float|null $sale_price
 * @property float|null $purchase_price
 * @property int|null $category_id
 * @property bool $enabled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Setting\Category|null $category
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentItem> $document_items
 * @property-read mixed $initials
 * @property-read mixed $item_id
 * @property-read mixed $line_actions
 * @property-read mixed $picture
 * @property-read mixed $tax_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\ItemTax> $taxes
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Item autocomplete($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Item billing($billing)
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Database\Factories\Item factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Item name($name)
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item priceType($price_type)
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Item type($type)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item withoutTrashed()
 */
	class Item extends \Eloquent {}
}

namespace App\Models\Common{
/**
 * App\Models\Common\ItemTax
 *
 * @property int $id
 * @property int $company_id
 * @property int $item_id
 * @property int|null $tax_id
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \App\Models\Setting\Tax|null $tax
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTax newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTax newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTax onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTax query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTax withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTax withoutTrashed()
 */
	class ItemTax extends \Eloquent {}
}

namespace App\Models\Common{
/**
 * App\Models\Common\Media
 *
 * @property int $id
 * @property int $company_id
 * @property string $disk
 * @property string $directory
 * @property string $filename
 * @property string $extension
 * @property string $mime_type
 * @property string $aggregate_type
 * @property int $size
 * @property string|null $variant_name
 * @property int|null $original_media_id
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $basename
 * @property-read Media|null $originalMedia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Media> $variants
 * @method static \Illuminate\Database\Eloquent\Builder|Media forPathOnDisk(string $disk, string $path)
 * @method static \Illuminate\Database\Eloquent\Builder|Media inDirectory(string $disk, string $directory, bool $recursive = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Media inOrUnderDirectory(string $disk, string $directory)
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media unordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereBasename(string $basename)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereIsOriginal()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereIsVariant(?string $variant_name = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Media withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Media withoutTrashed()
 */
	class Media extends \Eloquent {}
}

namespace App\Models\Common{
/**
 * App\Models\Common\Notification
 *
 * @property string $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $notifiable
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseNotification read()
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseNotification unread()
 */
	class Notification extends \Eloquent {}
}

namespace App\Models\Common{
/**
 * App\Models\Common\Recurring
 *
 * @property int $id
 * @property int $company_id
 * @property string $recurable_type
 * @property int $recurable_id
 * @property string $frequency
 * @property int $interval
 * @property string $started_at
 * @property string $status
 * @property string $limit_by
 * @property int $limit_count
 * @property string|null $limit_date
 * @property bool $auto_send
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Document\Document> $documents
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $recurable
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Banking\Transaction> $transactions
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring active()
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring bill()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring completed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring document($type)
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring ended()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring expenseTransaction()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring incomeTransaction()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring invoice()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring transaction()
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurring withoutTrashed()
 */
	class Recurring extends \Eloquent {}
}

namespace App\Models\Common{
/**
 * App\Models\Common\Report
 *
 * @property int $id
 * @property int $company_id
 * @property string $class
 * @property string $name
 * @property string $description
 * @property object|null $settings
 * @property int|null $created_by
 * @property string|null $created_from
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $alias
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Report alias($alias)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Report class($class)
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Report expenseSummary()
 * @method static \Illuminate\Database\Eloquent\Builder|Report incomeExpenseSummary()
 * @method static \Illuminate\Database\Eloquent\Builder|Report incomeSummary()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Report profitLoss()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Report taxSummary()
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Report withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Report withoutTrashed()
 */
	class Report extends \Eloquent {}
}

namespace App\Models\Common{
/**
 * App\Models\Common\Widget
 *
 * @property int $id
 * @property int $company_id
 * @property int $dashboard_id
 * @property string $class
 * @property string $name
 * @property int $sort
 * @property object|null $settings
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Dashboard|null $dashboard
 * @property-read mixed $alias
 * @property-read mixed $width
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Auth\User> $users
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget alias($alias)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Database\Factories\Widget factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget withoutTrashed()
 */
	class Widget extends \Eloquent {}
}

namespace App\Models\Document{
/**
 * App\Models\Document\Document
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property string $document_number
 * @property string|null $order_number
 * @property string $status
 * @property \Illuminate\Support\Carbon $issued_at
 * @property \Illuminate\Support\Carbon $due_at
 * @property float $amount
 * @property string $currency_code
 * @property float $currency_rate
 * @property string|null $discount_type
 * @property float|null $discount_rate
 * @property int $category_id
 * @property int $contact_id
 * @property string $contact_name
 * @property string|null $contact_email
 * @property string|null $contact_tax_number
 * @property string|null $contact_phone
 * @property string|null $contact_address
 * @property string|null $contact_city
 * @property string|null $contact_zip_code
 * @property string|null $contact_state
 * @property string|null $contact_country
 * @property string|null $title
 * @property string|null $subheading
 * @property string|null $notes
 * @property string|null $footer
 * @property string|null $template
 * @property string|null $color
 * @property int $parent_id
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Setting\Category|null $category
 * @property-read \Plank\Mediable\MediableCollection<int, Document> $children
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Contact|null $contact
 * @property-read \App\Models\Setting\Currency|null $currency
 * @property-read mixed $amount_due
 * @property-read mixed $amount_without_tax
 * @property-read mixed $attachment
 * @property-read mixed $contact_location
 * @property-read mixed $discount
 * @property-read mixed $line_actions
 * @property-read mixed $paid
 * @property-read mixed $received_at
 * @property-read mixed $reconciled
 * @property-read mixed $recurring_status_label
 * @property-read mixed $sent_at
 * @property-read mixed $status_label
 * @property-read mixed $template_path
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentHistory> $histories
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentItemTax> $item_taxes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentItem> $items
 * @property-read \App\Models\Document\DocumentHistory $last_history
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read Document|null $parent
 * @property-read \App\Models\Common\Recurring|null $recurring
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentTotal> $totals
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Banking\Transaction> $transactions
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Document accrued()
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Document bill()
 * @method static \Illuminate\Database\Eloquent\Builder|Document billRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Document dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Document due($date)
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Database\Factories\Document factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Document future()
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Document invoice()
 * @method static \Illuminate\Database\Eloquent\Builder|Document invoiceRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Document latest()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Document monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document notPaid()
 * @method static \Illuminate\Database\Eloquent\Builder|Document number(string $number)
 * @method static \Illuminate\Database\Eloquent\Builder|Document onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document paid()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Document status(string $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Document type(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Document withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Document withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Document withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Document withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Document withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document withoutTrashed()
 */
	class Document extends \Eloquent {}
}

namespace App\Models\Document{
/**
 * App\Models\Document\DocumentHistory
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property int $document_id
 * @property string $status
 * @property int $notify
 * @property string|null $description
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Document\Document|null $document
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory bill()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory billRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory invoice()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory invoiceRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory status(string $status)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory type(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistory withoutTrashed()
 */
	class DocumentHistory extends \Eloquent {}
}

namespace App\Models\Document{
/**
 * App\Models\Document\DocumentItem
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property int $document_id
 * @property int|null $item_id
 * @property string $name
 * @property string|null $description
 * @property string|null $sku
 * @property float $quantity
 * @property float $price
 * @property float $tax
 * @property string $discount_type
 * @property float $discount_rate
 * @property float $total
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Document\Document|null $document
 * @property-read string $discount
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentItemTax> $taxes
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem bill()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem billRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem invoice()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem invoiceRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem type(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem withoutTrashed()
 */
	class DocumentItem extends \Eloquent {}
}

namespace App\Models\Document{
/**
 * App\Models\Document\DocumentItemTax
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property int $document_id
 * @property int $document_item_id
 * @property int $tax_id
 * @property string $name
 * @property float $amount
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Document\Document|null $document
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \App\Models\Setting\Tax|null $tax
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItemTax bill()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItemTax billRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItemTax invoice()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItemTax invoiceRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItemTax newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItemTax newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItemTax onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItemTax query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItemTax type(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItemTax withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItemTax withoutTrashed()
 */
	class DocumentItemTax extends \Eloquent {}
}

namespace App\Models\Document{
/**
 * App\Models\Document\DocumentTotal
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property int $document_id
 * @property string|null $code
 * @property string $name
 * @property float $amount
 * @property int $sort_order
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Document\Document|null $document
 * @property-read mixed $title
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal bill()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal billRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal code($code)
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal invoice()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal invoiceRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal type(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTotal withoutTrashed()
 */
	class DocumentTotal extends \Eloquent {}
}

namespace App\Models\Module{
/**
 * App\Models\Module\Module
 *
 * @property int $id
 * @property int $company_id
 * @property string $alias
 * @property bool $enabled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Module alias($alias)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Module newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Module query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Module withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Module withoutTrashed()
 */
	class Module extends \Eloquent {}
}

namespace App\Models\Module{
/**
 * App\Models\Module\ModuleHistory
 *
 * @property int $id
 * @property int $company_id
 * @property int $module_id
 * @property string $version
 * @property string|null $description
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Module\Module|null $module
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleHistory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ModuleHistory withoutTrashed()
 */
	class ModuleHistory extends \Eloquent {}
}

namespace App\Models\Setting{
/**
 * App\Models\Setting\Category
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $type
 * @property string $color
 * @property bool $enabled
 * @property int|null $parent_id
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $categories
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Document\Document> $documents
 * @property-read string $color_hex_code
 * @property-read mixed $display_name
 * @property-read mixed $line_actions
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Common\Item> $items
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $sub_categories
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Banking\Transaction> $transactions
 * @method static \App\Builders\Category|Model account($accounts)
 * @method static \App\Builders\Category|Model allCompanies()
 * @method static \App\Builders\Category|Model collect($sort = 'name')
 * @method static \App\Builders\Category|Category collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \App\Builders\Category|Model companyId($company_id)
 * @method static \App\Builders\Category|Model contact($contacts)
 * @method static \App\Builders\Category|Model dateFilter(string $field)
 * @method static \App\Builders\Category|Model disableCache()
 * @method static \App\Builders\Category|Model disabled()
 * @method static \App\Builders\Category|Model enabled()
 * @method static \App\Builders\Category|Category expense()
 * @method static \Database\Factories\Category factory($count = null, $state = [])
 * @method static \App\Builders\Category|Category getWithoutChildren($columns = [])
 * @method static \App\Builders\Category|Category income()
 * @method static \App\Builders\Category|Model isNotOwner()
 * @method static \App\Builders\Category|Model isNotRecurring()
 * @method static \App\Builders\Category|Model isOwner()
 * @method static \App\Builders\Category|Model isRecurring()
 * @method static \App\Builders\Category|Category item()
 * @method static \App\Builders\Category|Model moduleEnabled(string $module)
 * @method static \App\Builders\Category|Model monthsOfYear(string $field)
 * @method static \App\Builders\Category|Category name($name)
 * @method static \App\Builders\Category|Category newModelQuery()
 * @method static \App\Builders\Category|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category onlyTrashed()
 * @method static \App\Builders\Category|Category other()
 * @method static \App\Builders\Category|Category query()
 * @method static \App\Builders\Category|Model reconciled($value = 1)
 * @method static \App\Builders\Category|Model sortable($defaultParameters = null)
 * @method static \App\Builders\Category|Model source($source)
 * @method static \App\Builders\Category|Category type($types)
 * @method static \App\Builders\Category|Model usingSearchString(?string $string = null)
 * @method static \App\Builders\Category|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \App\Builders\Category|Category withSubCategory()
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category withoutTrashed()
 */
	class Category extends \Eloquent {}
}

namespace App\Models\Setting{
/**
 * App\Models\Setting\Currency
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $code
 * @property float $rate
 * @property string|null $precision
 * @property string|null $symbol
 * @property int $symbol_first
 * @property string|null $decimal_mark
 * @property string|null $thousands_separator
 * @property bool $enabled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Banking\Account> $accounts
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Common\Contact> $contacts
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Document\Document> $documents
 * @property-read mixed $line_actions
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Banking\Transaction> $transactions
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency code($code)
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Database\Factories\Currency factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency withoutTrashed()
 */
	class Currency extends \Eloquent {}
}

namespace App\Models\Setting{
/**
 * App\Models\Setting\EmailTemplate
 *
 * @property int $id
 * @property int $company_id
 * @property string $alias
 * @property string $class
 * @property string $name
 * @property string $subject
 * @property string $body
 * @property string|null $params
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $group
 * @property-read mixed $title
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate alias($alias)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate moduleAlias($alias)
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate withoutTrashed()
 */
	class EmailTemplate extends \Eloquent {}
}

namespace App\Models\Setting{
/**
 * App\Models\Setting\Setting
 *
 * @property int $id
 * @property int $company_id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting prefix($prefix = 'company')
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting withoutTrashed()
 */
	class Setting extends \Eloquent {}
}

namespace App\Models\Setting{
/**
 * App\Models\Setting\Tax
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property float $rate
 * @property string $type
 * @property bool $enabled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentItemTax> $document_items
 * @property-read mixed $line_actions
 * @property-read mixed $title
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\ItemTax> $items
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax compound()
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Database\Factories\Tax factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Tax fixed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax inclusive()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax name($name)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax normal()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax notRate($rate)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax notWithholding()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax rate($rate)
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax type($types)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax withholding()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax withoutTrashed()
 */
	class Tax extends \Eloquent {}
}

namespace Modules\Admin24\Models{
/**
 * Modules\Admin24\Models\CoreItem
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property string $name
 * @property string|null $sku
 * @property string|null $description
 * @property float|null $sale_price
 * @property float|null $purchase_price
 * @property int|null $category_id
 * @property bool $enabled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Setting\Category|null $category
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentItem> $document_items
 * @property-read mixed $initials
 * @property-read mixed $item_id
 * @property-read mixed $line_actions
 * @property-read mixed $picture
 * @property-read mixed $tax_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\ItemTax> $taxes
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Item autocomplete($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Item billing($billing)
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Item name($name)
 * @method static \Illuminate\Database\Eloquent\Builder|CoreItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CoreItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CoreItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item priceType($price_type)
 * @method static \Illuminate\Database\Eloquent\Builder|CoreItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Item type($type)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|CoreItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CoreItem withoutTrashed()
 */
	class CoreItem extends \Eloquent {}
}

namespace Modules\Admin24\Models{
/**
 * Modules\Admin24\Models\History
 *
 * @property int $id
 * @property int $company_id
 * @property int $user_id
 * @property int $item_id
 * @property int $warehouse_id
 * @property string $type_type
 * @property int $type_id
 * @property float $quantity
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Document\DocumentItem|null $document_item
 * @property-read mixed $action_route
 * @property-read mixed $action_text
 * @property-read mixed $action_type
 * @property-read mixed $action_url
 * @property-read mixed $number
 * @property-read mixed $operation_type
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $type
 * @property-read \Modules\Inventory\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|History document()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|History newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|History query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|History withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|History withoutTrashed()
 */
	class History extends \Eloquent {}
}

namespace Modules\Admin24\Models{
/**
 * Modules\Admin24\Models\Item
 *
 * @property int $id
 * @property int $company_id
 * @property int $item_id
 * @property float|null $opening_stock
 * @property float|null $opening_stock_value
 * @property float|null $reorder_level
 * @property string|null $barcode
 * @property int|null $vendor_id
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $sku
 * @property int|null $warehouse_id
 * @property int $default_warehouse
 * @property string|null $unit
 * @property int|null $returnable
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $line_actions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\History> $histories
 * @property-read \Modules\Inventory\Models\History|null $history
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\VariantValue> $values
 * @property-read \Modules\Inventory\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\Inventory\Database\Factories\Item factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item withoutTrashed()
 */
	class Item extends \Eloquent {}
}

namespace Modules\Admin24\Models{
/**
 * Modules\Admin24\Models\TransferOrderHistory
 *
 * @property int $id
 * @property int $company_id
 * @property int $created_by
 * @property int $transfer_order_id
 * @property string $status
 * @property string|null $created_from
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Inventory\Models\TransferOrder|null $transfer_order
 * @property-read \App\Models\Auth\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory withoutTrashed()
 */
	class TransferOrderHistory extends \Eloquent {}
}

namespace Modules\Admin24\Models{
/**
 * Modules\Admin24\Models\TransferOrderItem
 *
 * @property int $id
 * @property int $company_id
 * @property int $transfer_order_id
 * @property int $item_id
 * @property float $item_quantity
 * @property float|null $transfer_quantity
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Inventory\Models\TransferOrder|null $transfer_order
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem withoutTrashed()
 */
	class TransferOrderItem extends \Eloquent {}
}

namespace Modules\CompositeItems\Models{
/**
 * Modules\CompositeItems\Models\CompositeItem
 *
 * @property int $id
 * @property int $company_id
 * @property int $item_id
 * @property string|null $sku
 * @property string|null $barcode
 * @property string|null $unit
 * @property int|null $returnable
 * @property int|null $track_inventory
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\CompositeItems\Models\Item> $composite_items
 * @property-read mixed $line_actions
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem canTrack()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CompositeItem withoutTrashed()
 */
	class CompositeItem extends \Eloquent {}
}

namespace Modules\CompositeItems\Models{
/**
 * Modules\CompositeItems\Models\DocumentItem
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property int $document_id
 * @property int $item_id
 * @property int $document_item_id
 * @property int|null $warehouse_id
 * @property float|null $quantity
 * @property float $price
 * @property float $tax
 * @property string $discount_type
 * @property float $discount_rate
 * @property float $total
 * @property string|null $created_by
 * @property string|null $created_from
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Document\Document|null $document
 * @property-read \App\Models\Document\DocumentItem|null $document_item
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentItem> $document_items
 * @property-read string $discount
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Inventory\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem withoutTrashed()
 */
	class DocumentItem extends \Eloquent {}
}

namespace Modules\CompositeItems\Models{
/**
 * Modules\CompositeItems\Models\Item
 *
 * @property int $id
 * @property int $company_id
 * @property int $item_id
 * @property int $composite_item_id
 * @property float $quantity
 * @property int|null $warehouse_id
 * @property string|null $created_by
 * @property string|null $created_from
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Modules\CompositeItems\Models\CompositeItem|null $composite_items
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item withoutTrashed()
 */
	class Item extends \Eloquent {}
}

namespace Modules\DoubleEntry\Models{
/**
 * Modules\DoubleEntry\Models\Account
 *
 * @property int $id
 * @property int $company_id
 * @property int $type_id
 * @property int|null $account_id
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property bool $enabled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Account> $accounts
 * @property-read \Modules\DoubleEntry\Models\AccountBank|null $bank
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $balance
 * @property-read mixed $balance_colorized
 * @property-read mixed $balance_linked_general_ledger
 * @property-read mixed $balance_without_subaccounts
 * @property-read mixed $balance_without_subaccounts_colorized
 * @property-read mixed $child_nodes
 * @property-read mixed $credit_total
 * @property-read mixed $debit_total
 * @property-read mixed $general_ledger_report
 * @property-read mixed $line_actions
 * @property-read mixed $name_linked_general_ledger
 * @property-read mixed $opening_balance
 * @property-read mixed $trans_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\DoubleEntry\Models\Ledger> $ledgers
 * @property-read \App\Models\Auth\User|null $owner
 * @property-write mixed $end_date
 * @property-write mixed $start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Account> $sub_accounts
 * @property-read \Modules\DoubleEntry\Models\AccountTax|null $tax
 * @property-read \Modules\DoubleEntry\Models\Type|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Account code($code)
 * @method static \Illuminate\Database\Eloquent\Builder|Account collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Account collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Account dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\DoubleEntry\Database\Factories\Account factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Account inType($types)
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Account isNotSubAccount()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Account monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Account withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account withoutTrashed()
 */
	class Account extends \Eloquent {}
}

namespace Modules\DoubleEntry\Models{
/**
 * Modules\DoubleEntry\Models\AccountBank
 *
 * @property int $id
 * @property int $company_id
 * @property int $account_id
 * @property int $bank_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\DoubleEntry\Models\Account|null $account
 * @property-read \App\Models\Banking\Account|null $bank
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountBank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountBank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountBank onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountBank query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountBank withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountBank withoutTrashed()
 */
	class AccountBank extends \Eloquent {}
}

namespace Modules\DoubleEntry\Models{
/**
 * Modules\DoubleEntry\Models\AccountItem
 *
 * @property int $id
 * @property int $company_id
 * @property int $account_id
 * @property int $item_id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\DoubleEntry\Models\Account|null $account
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem withoutTrashed()
 */
	class AccountItem extends \Eloquent {}
}

namespace Modules\DoubleEntry\Models{
/**
 * Modules\DoubleEntry\Models\AccountTax
 *
 * @property int $id
 * @property int $company_id
 * @property int $account_id
 * @property int $tax_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\DoubleEntry\Models\Account|null $account
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \App\Models\Setting\Tax|null $tax
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountTax newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountTax newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountTax onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountTax query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountTax withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountTax withoutTrashed()
 */
	class AccountTax extends \Eloquent {}
}

namespace Modules\DoubleEntry\Models{
/**
 * Modules\DoubleEntry\Models\DEClass
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\DoubleEntry\Models\Account> $accounts
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\DoubleEntry\Models\Type> $types
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|DEClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DEClass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DEClass onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DEClass query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DEClass withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DEClass withoutTrashed()
 */
	class DEClass extends \Eloquent {}
}

namespace Modules\DoubleEntry\Models{
/**
 * Modules\DoubleEntry\Models\Journal
 *
 * @property int $id
 * @property int $company_id
 * @property string $paid_at
 * @property float $amount
 * @property string $description
 * @property string|null $reference
 * @property string|null $journal_number
 * @property string|null $basis
 * @property string|null $currency_code
 * @property float|null $currency_rate
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $attachment
 * @property-read mixed $line_actions
 * @property-read mixed $number
 * @property-read mixed $reconciled
 * @property-read \Modules\DoubleEntry\Models\Ledger|null $ledger
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\DoubleEntry\Models\Ledger> $ledgers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\DoubleEntry\Database\Factories\Journal factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Journal withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal withoutTrashed()
 */
	class Journal extends \Eloquent {}
}

namespace Modules\DoubleEntry\Models{
/**
 * Modules\DoubleEntry\Models\Ledger
 *
 * @property int $id
 * @property int $company_id
 * @property int $account_id
 * @property int|null $transaction_id
 * @property string $ledgerable_type
 * @property int $ledgerable_id
 * @property string $issued_at
 * @property string $entry_type
 * @property float|null $debit
 * @property float|null $credit
 * @property string|null $reference
 * @property string|null $notes
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\DoubleEntry\Models\Account|null $account
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $description
 * @property-read mixed $ledgerable_link
 * @property-read mixed $transaction_label
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $ledgerable
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \App\Models\Banking\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Ledger accrual()
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Ledger cash()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Ledger contact($contact)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Ledger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ledger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ledger onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ledger query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Ledger record($id, $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Ledger withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ledger withoutTrashed()
 */
	class Ledger extends \Eloquent {}
}

namespace Modules\DoubleEntry\Models{
/**
 * Modules\DoubleEntry\Models\RecurringLedger
 *
 * @property int $id
 * @property int $company_id
 * @property int $account_id
 * @property int|null $transaction_id
 * @property string $ledgerable_type
 * @property int $ledgerable_id
 * @property string $issued_at
 * @property string $entry_type
 * @property float|null $debit
 * @property float|null $credit
 * @property string|null $reference
 * @property string|null $notes
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\DoubleEntry\Models\Account|null $account
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $description
 * @property-read mixed $ledgerable_link
 * @property-read mixed $transaction_label
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $ledgerable
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \App\Models\Banking\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|RecurringLedger accrual()
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|RecurringLedger cash()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|RecurringLedger contact($contact)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|RecurringLedger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecurringLedger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecurringLedger onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RecurringLedger query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|RecurringLedger record($id, $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|RecurringLedger withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RecurringLedger withoutTrashed()
 */
	class RecurringLedger extends \Eloquent {}
}

namespace Modules\DoubleEntry\Models{
/**
 * Modules\DoubleEntry\Models\Type
 *
 * @property int $id
 * @property int $class_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\DoubleEntry\Models\Account> $accounts
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Modules\DoubleEntry\Models\DEClass|null $declass
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Type newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Type newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Type onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Type query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Type withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Type withoutTrashed()
 */
	class Type extends \Eloquent {}
}

namespace Modules\Employees\Models{
/**
 * Modules\Employees\Models\Department
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property int|null $manager_id
 * @property int|null $parent_id
 * @property string|null $description
 * @property bool $enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Department> $departments
 * @property-read \Plank\Mediable\MediableCollection<int, \Modules\Employees\Models\Employee> $employees
 * @property-read mixed $line_actions
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Department> $sub_departments
 * @property-read \App\Models\Auth\User|null $user
 * @method static \Modules\Employees\Builders\Department|Model account($accounts)
 * @method static \Modules\Employees\Builders\Department|Model allCompanies()
 * @method static \Modules\Employees\Builders\Department|Model collect($sort = 'name')
 * @method static \Modules\Employees\Builders\Department|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Modules\Employees\Builders\Department|Model companyId($company_id)
 * @method static \Modules\Employees\Builders\Department|Model contact($contacts)
 * @method static \Modules\Employees\Builders\Department|Model dateFilter(string $field)
 * @method static \Modules\Employees\Builders\Department|Model disableCache()
 * @method static \Modules\Employees\Builders\Department|Model disabled()
 * @method static \Modules\Employees\Builders\Department|Model enabled()
 * @method static \Modules\Employees\Database\Factories\Department factory($count = null, $state = [])
 * @method static \Modules\Employees\Builders\Department|Department getWithoutChildren($columns = [])
 * @method static \Modules\Employees\Builders\Department|Model isNotOwner()
 * @method static \Modules\Employees\Builders\Department|Model isNotRecurring()
 * @method static \Modules\Employees\Builders\Department|Model isOwner()
 * @method static \Modules\Employees\Builders\Department|Model isRecurring()
 * @method static \Modules\Employees\Builders\Department|Model moduleEnabled(string $module)
 * @method static \Modules\Employees\Builders\Department|Model monthsOfYear(string $field)
 * @method static \Modules\Employees\Builders\Department|Department name($name)
 * @method static \Modules\Employees\Builders\Department|Department newModelQuery()
 * @method static \Modules\Employees\Builders\Department|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department onlyTrashed()
 * @method static \Modules\Employees\Builders\Department|Department query()
 * @method static \Modules\Employees\Builders\Department|Model reconciled($value = 1)
 * @method static \Modules\Employees\Builders\Department|Model sortable($defaultParameters = null)
 * @method static \Modules\Employees\Builders\Department|Model source($source)
 * @method static \Modules\Employees\Builders\Department|Model usingSearchString(?string $string = null)
 * @method static \Modules\Employees\Builders\Department|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Modules\Employees\Builders\Department|Department withSubDepartment()
 * @method static \Illuminate\Database\Eloquent\Builder|Department withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Department withoutTrashed()
 */
	class Department extends \Eloquent {}
}

namespace Modules\Employees\Models{
/**
 * Modules\Employees\Models\Dismissal
 *
 * @property int $id
 * @property int $company_id
 * @property int $employee_id
 * @property string $type
 * @property string $dismissal_date
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Modules\Employees\Models\Employee|null $employee
 * @property-read \Plank\Mediable\MediableCollection<int, \Modules\Employees\Models\Employee> $employees
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Dismissal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dismissal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dismissal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Dismissal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dismissal withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Dismissal withoutTrashed()
 */
	class Dismissal extends \Eloquent {}
}

namespace Modules\Employees\Models{
/**
 * Modules\Employees\Models\Employee
 *
 * @property int $id
 * @property int $company_id
 * @property int $contact_id
 * @property string $birth_day
 * @property string $gender
 * @property int $department_id
 * @property float $amount
 * @property string|null $salary_type
 * @property string $hired_at
 * @property string|null $bank_account_number
 * @property int $dismissed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Contact|null $contact
 * @property-read \Modules\Employees\Models\Department|null $department
 * @property-read \Modules\Employees\Models\Dismissal|null $dismissal
 * @property-read mixed $attachment
 * @property-read mixed $email
 * @property-read mixed $line_actions
 * @property-read mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee enabled()
 * @method static \Modules\Employees\Database\Factories\Employee factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withoutTrashed()
 */
	class Employee extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\Adjustment
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $date
 * @property string $adjustment_number
 * @property int $warehouse_id
 * @property string|null $description
 * @property string $reason
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\AdjustmentItem> $adjustment_items
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $line_actions
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Inventory\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\Inventory\Database\Factories\Adjustment factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Adjustment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Adjustment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Adjustment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Adjustment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Adjustment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Adjustment withoutTrashed()
 */
	class Adjustment extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\AdjustmentItem
 *
 * @property int $id
 * @property int $company_id
 * @property int $adjustment_id
 * @property int $item_id
 * @property float $item_quantity
 * @property float $adjusted_quantity
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem withoutTrashed()
 */
	class AdjustmentItem extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\BillItem
 *
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem withoutTrashed()
 */
	class BillItem extends \Eloquent {}
}

namespace Modules\Inventory\Models\Common{
/**
 * Modules\Inventory\Models\Common\Item
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property string $name
 * @property string|null $sku
 * @property string|null $description
 * @property float|null $sale_price
 * @property float|null $purchase_price
 * @property int|null $category_id
 * @property bool $enabled
 * @property string|null $created_from
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Setting\Category|null $category
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentItem> $document_items
 * @property-read mixed $barcode
 * @property-read mixed $initials
 * @property-read mixed $item_id
 * @property-read mixed $line_actions
 * @property-read mixed $picture
 * @property-read mixed $tax_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\Item> $inventories
 * @property-read \Modules\Inventory\Models\Item|null $inventory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\ItemTax> $taxes
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Item autocomplete($filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Item billing($billing)
 * @method static \Illuminate\Database\Eloquent\Builder|Item collecct($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Database\Factories\Item factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Item name($name)
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item priceType($price_type)
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Item type($type)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Item withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item withoutTrashed()
 */
	class Item extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\DocumentItem
 *
 * @property int $id
 * @property int $company_id
 * @property string $type
 * @property int $document_id
 * @property int $item_id
 * @property int|null $warehouse_id
 * @property float|null $quantity
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $document_item_id
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Document\Document|null $document
 * @property-read \App\Models\Document\DocumentItem|null $document_item
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document\DocumentItem> $document_items
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentItem withoutTrashed()
 */
	class DocumentItem extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\History
 *
 * @property int $id
 * @property int $company_id
 * @property int $user_id
 * @property int $item_id
 * @property int $warehouse_id
 * @property string $type_type
 * @property int $type_id
 * @property float $quantity
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Document\DocumentItem|null $document_item
 * @property-read mixed $action_route
 * @property-read mixed $action_text
 * @property-read mixed $action_type
 * @property-read mixed $action_url
 * @property-read mixed $number
 * @property-read mixed $operation_type
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $type
 * @property-read \Modules\Inventory\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|History document()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|History newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|History onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|History query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|History withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|History withoutTrashed()
 */
	class History extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\InvoiceItem
 *
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem withoutTrashed()
 */
	class InvoiceItem extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\Item
 *
 * @property int $id
 * @property int $company_id
 * @property int $item_id
 * @property float|null $opening_stock
 * @property float|null $opening_stock_value
 * @property float|null $reorder_level
 * @property string|null $barcode
 * @property int|null $vendor_id
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $sku
 * @property int|null $warehouse_id
 * @property int $default_warehouse
 * @property string|null $unit
 * @property int|null $returnable
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $line_actions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\History> $histories
 * @property-read \Modules\Inventory\Models\History|null $history
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\VariantValue> $values
 * @property-read \Modules\Inventory\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\Inventory\Database\Factories\Item factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item withoutTrashed()
 */
	class Item extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\ItemGroup
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string|null $description
 * @property int|null $category_id
 * @property int|null $tax_id
 * @property bool $enabled
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Setting\Category|null $category
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $line_actions
 * @property-read mixed $picture
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\ItemGroupItem> $items
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\VariantValue> $values
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\ItemGroupVariantValue> $variant_values
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\ItemGroupVariant> $variants
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\Inventory\Database\Factories\ItemGroups factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroup withoutTrashed()
 */
	class ItemGroup extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\ItemGroupItem
 *
 * @property int $id
 * @property int $company_id
 * @property int $item_id
 * @property int $item_group_id
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $tax_ids
 * @property-read \Modules\Inventory\Models\Item|null $inventory_item
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\ItemTax> $taxes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\ItemGroupVariantValue> $values
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\ItemGroupVariant> $variants
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupItem withoutTrashed()
 */
	class ItemGroupItem extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\ItemGroupVariant
 *
 * @property int $id
 * @property int $company_id
 * @property int $item_group_id
 * @property int $variant_id
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\ItemGroupVariantValue> $values
 * @property-read \Modules\Inventory\Models\Variant|null $variant
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\VariantValue> $variant_values
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariant withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariant withoutTrashed()
 */
	class ItemGroupVariant extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\ItemGroupVariantValue
 *
 * @property int $id
 * @property int $company_id
 * @property int $item_group_id
 * @property int|null $item_group_variant_id
 * @property int $variant_id
 * @property int $variant_value_id
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $item_id
 * @property int|null $item_group_item_id
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Modules\Inventory\Models\ItemGroupItem|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariantValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariantValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariantValue onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariantValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariantValue withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemGroupVariantValue withoutTrashed()
 */
	class ItemGroupVariantValue extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\Manufacturer
 *
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Plank\Mediable\MediableCollection<int, \App\Models\Common\Item> $items
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\ManufacturerVendor> $manufacturer_vendors
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Manufacturer withoutTrashed()
 */
	class Manufacturer extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\ManufacturerItem
 *
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \Modules\Inventory\Models\Manufacturer|null $manufacturer
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerItem withoutTrashed()
 */
	class ManufacturerItem extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\ManufacturerVendor
 *
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Modules\Inventory\Models\Manufacturer|null $manufacturer
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \App\Models\Common\Contact|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerVendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerVendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerVendor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerVendor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerVendor withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturerVendor withoutTrashed()
 */
	class ManufacturerVendor extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\TransferOrder
 *
 * @property int $id
 * @property int $company_id
 * @property int|null $item_id
 * @property string|null $date
 * @property string $transfer_order
 * @property string|null $reason
 * @property float|null $transfer_quantity
 * @property int $source_warehouse_id
 * @property int $destination_warehouse_id
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $transfer_order_number
 * @property string $status
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Modules\Inventory\Models\Warehouse|null $destination_warehouse
 * @property-read mixed $in_transfer
 * @property-read mixed $item_quantity
 * @property-read mixed $line_actions
 * @property-read mixed $ready
 * @property-read string $status_label
 * @property-read mixed $transferred
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\TransferOrderHistory> $histories
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Inventory\Models\Warehouse|null $source_warehouse
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\TransferOrderItem> $transfer_order_items
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\Inventory\Database\Factories\TransferOrder factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrder withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrder withoutTrashed()
 */
	class TransferOrder extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\TransferOrderHistory
 *
 * @property int $id
 * @property int $company_id
 * @property int $created_by
 * @property int $transfer_order_id
 * @property string $status
 * @property string|null $created_from
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Inventory\Models\TransferOrder|null $transfer_order
 * @property-read \App\Models\Auth\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderHistory withoutTrashed()
 */
	class TransferOrderHistory extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\TransferOrderItem
 *
 * @property int $id
 * @property int $company_id
 * @property int $transfer_order_id
 * @property int $item_id
 * @property float $item_quantity
 * @property float|null $transfer_quantity
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Inventory\Models\TransferOrder|null $transfer_order
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TransferOrderItem withoutTrashed()
 */
	class TransferOrderItem extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\Variant
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string|null $type
 * @property bool $enabled
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $line_actions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\ItemGroupVariant> $item_groups
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\VariantValue> $values
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\Inventory\Database\Factories\Variant factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Variant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Variant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Variant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Variant withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Variant withoutTrashed()
 */
	class Variant extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\VariantValue
 *
 * @property int $id
 * @property int $company_id
 * @property int $variant_id
 * @property string $name
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Inventory\Models\Variant|null $variant
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantValue onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantValue withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantValue withoutTrashed()
 */
	class VariantValue extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\Warehouse
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property bool $enabled
 * @property string|null $zip_code
 * @property string|null $state
 * @property string|null $created_from
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $description
 * @property string|null $country
 * @property string|null $city
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $core_items
 * @property-read mixed $default_warehouse
 * @property-read mixed $history_pagination
 * @property-read mixed $initials
 * @property-read mixed $item_pagination
 * @property-read mixed $line_actions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\History> $histories
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Inventory\Models\Item> $items
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\Inventory\Database\Factories\Warehouse factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse withoutTrashed()
 */
	class Warehouse extends \Eloquent {}
}

namespace Modules\Inventory\Models{
/**
 * Modules\Inventory\Models\WarehouseItem
 *
 * @property-read \App\Models\Common\Company|null $company
 * @property-read mixed $quantity
 * @property-read \App\Models\Common\Item|null $item
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Inventory\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WarehouseItem withoutTrashed()
 */
	class WarehouseItem extends \Eloquent {}
}

namespace Modules\Payroll\Models\Employee{
/**
 * Modules\Payroll\Models\Employee\Benefit
 *
 * @property int $id
 * @property int $company_id
 * @property int $employee_id
 * @property string $type
 * @property float $amount
 * @property string $currency_code
 * @property string|null $recurring
 * @property string|null $description
 * @property int|null $from_date
 * @property int|null $to_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Modules\Payroll\Models\Employee\Employee|null $employee
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Payroll\Models\Setting\PayItem $pay_item
 * @property-read \Plank\Mediable\MediableCollection<int, \Modules\Payroll\Models\RunPayroll\RunPayroll> $run_payrolls
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit withoutTrashed()
 */
	class Benefit extends \Eloquent {}
}

namespace Modules\Payroll\Models\Employee{
/**
 * Modules\Payroll\Models\Employee\Deduction
 *
 * @property int $id
 * @property int $company_id
 * @property int $employee_id
 * @property string $type
 * @property float $amount
 * @property string $currency_code
 * @property string|null $recurring
 * @property string|null $description
 * @property int|null $from_date
 * @property int|null $to_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Modules\Payroll\Models\Employee\Employee|null $employee
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Payroll\Models\Setting\PayItem $pay_item
 * @property-read \Plank\Mediable\MediableCollection<int, \Modules\Payroll\Models\RunPayroll\RunPayroll> $run_payrolls
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction withoutTrashed()
 */
	class Deduction extends \Eloquent {}
}

namespace Modules\Payroll\Models\Employee{
/**
 * Modules\Payroll\Models\Employee\Employee
 *
 * @property int $id
 * @property int $company_id
 * @property int $contact_id
 * @property string $birth_day
 * @property string $gender
 * @property int $department_id
 * @property float $amount
 * @property string|null $salary_type
 * @property string $hired_at
 * @property string|null $bank_account_number
 * @property int $dismissed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payroll\Models\Employee\Benefit> $benefits
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Common\Contact|null $contact
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payroll\Models\Employee\Deduction> $deductions
 * @property-read \Modules\Employees\Models\Department|null $department
 * @property-read \Modules\Employees\Models\Dismissal|null $dismissal
 * @property-read mixed $attachment
 * @property-read mixed $email
 * @property-read mixed $line_actions
 * @property-read mixed $name
 * @property-read float $total_benefits
 * @property-read float $total_deductions
 * @property-read float $totals
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payroll\Models\RunPayroll\RunPayrollEmployee> $payrollPayment
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee enabled()
 * @method static \Modules\Employees\Database\Factories\Employee factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withoutTrashed()
 */
	class Employee extends \Eloquent {}
}

namespace Modules\Payroll\Models\PayCalendar{
/**
 * Modules\Payroll\Models\PayCalendar\Employee
 *
 * @property int $id
 * @property int $company_id
 * @property int $pay_calendar_id
 * @property int $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Modules\Payroll\Models\Employee\Employee|null $employee
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Payroll\Models\PayCalendar\PayCalendar|null $pay_calendar
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withoutTrashed()
 */
	class Employee extends \Eloquent {}
}

namespace Modules\Payroll\Models\PayCalendar{
/**
 * Modules\Payroll\Models\PayCalendar\PayCalendar
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $type
 * @property string $pay_day_mode
 * @property string|null $pay_day
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Setting\Currency|null $currency
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payroll\Models\PayCalendar\Employee> $employees
 * @property-read mixed $line_actions
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Plank\Mediable\MediableCollection<int, \Modules\Payroll\Models\RunPayroll\RunPayroll> $run_payrolls
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\Payroll\Database\Factories\PayCalendar factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|PayCalendar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayCalendar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayCalendar onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PayCalendar query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PayCalendar withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PayCalendar withoutTrashed()
 */
	class PayCalendar extends \Eloquent {}
}

namespace Modules\Payroll\Models\RunPayroll{
/**
 * Modules\Payroll\Models\RunPayroll\RunPayroll
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $from_date
 * @property \Illuminate\Support\Carbon $to_date
 * @property \Illuminate\Support\Carbon $payment_date
 * @property int|null $payment_id
 * @property int $pay_calendar_id
 * @property int $category_id
 * @property int $account_id
 * @property string $payment_method
 * @property string $currency_code
 * @property float $currency_rate
 * @property float $amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Banking\Account|null $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payroll\Models\RunPayroll\RunPayrollEmployeeBenefit> $benefits
 * @property-read \App\Models\Setting\Category|null $category
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \App\Models\Setting\Currency|null $currency
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payroll\Models\RunPayroll\RunPayrollEmployeeDeduction> $deductions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payroll\Models\RunPayroll\RunPayrollEmployee> $employees
 * @property-read mixed $attachment
 * @property-read mixed $line_actions
 * @property-read string $status_label
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Common\Media> $media
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Payroll\Models\PayCalendar\PayCalendar|null $pay_calendar
 * @property-read \App\Models\Banking\Transaction|null $payment
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Plank\Mediable\MediableCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\Payroll\Database\Factories\RunPayroll factory($count = null, $state = [])
 * @method static \Plank\Mediable\MediableCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll withMediaMatchAll($tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayroll withoutTrashed()
 */
	class RunPayroll extends \Eloquent {}
}

namespace Modules\Payroll\Models\RunPayroll{
/**
 * Modules\Payroll\Models\RunPayroll\RunPayrollEmployee
 *
 * @property int $id
 * @property int $company_id
 * @property int $employee_id
 * @property int $pay_calendar_id
 * @property int $run_payroll_id
 * @property float $salary
 * @property float $benefit
 * @property float $deduction
 * @property float $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payroll\Models\RunPayroll\RunPayrollEmployeeBenefit> $benefits
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payroll\Models\RunPayroll\RunPayrollEmployeeDeduction> $deductions
 * @property-read \Modules\Payroll\Models\Employee\Employee|null $employee
 * @property-read mixed $total_benefits
 * @property-read mixed $total_deductions
 * @property-read mixed $totals
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Payroll\Models\PayCalendar\PayCalendar|null $pay_calendar
 * @property-read \Modules\Payroll\Models\RunPayroll\RunPayroll|null $run_payroll
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployee withoutTrashed()
 */
	class RunPayrollEmployee extends \Eloquent {}
}

namespace Modules\Payroll\Models\RunPayroll{
/**
 * Modules\Payroll\Models\RunPayroll\RunPayrollEmployeeBenefit
 *
 * @property int $id
 * @property int $company_id
 * @property int $employee_id
 * @property int|null $employee_benefit_id
 * @property int $pay_calendar_id
 * @property int $run_payroll_id
 * @property string $type
 * @property float $amount
 * @property string $currency_code
 * @property float $currency_rate
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\Payroll\Models\Employee\Benefit|null $benefit
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Modules\Payroll\Models\Employee\Employee|null $employee
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Payroll\Models\PayCalendar\PayCalendar|null $pay_calendar
 * @property-read \Modules\Payroll\Models\Setting\PayItem $pay_item
 * @property-read \Modules\Payroll\Models\RunPayroll\RunPayroll|null $run_payroll
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeBenefit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeBenefit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeBenefit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeBenefit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeBenefit withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeBenefit withoutTrashed()
 */
	class RunPayrollEmployeeBenefit extends \Eloquent {}
}

namespace Modules\Payroll\Models\RunPayroll{
/**
 * Modules\Payroll\Models\RunPayroll\RunPayrollEmployeeDeduction
 *
 * @property int $id
 * @property int $company_id
 * @property int $employee_id
 * @property int|null $employee_deduction_id
 * @property int $pay_calendar_id
 * @property int $run_payroll_id
 * @property string $type
 * @property float $amount
 * @property string $currency_code
 * @property float $currency_rate
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Modules\Payroll\Models\Employee\Deduction|null $deduction
 * @property-read \Modules\Payroll\Models\Employee\Employee|null $employee
 * @property-read \App\Models\Auth\User|null $owner
 * @property-read \Modules\Payroll\Models\PayCalendar\PayCalendar|null $pay_calendar
 * @property-read \Modules\Payroll\Models\Setting\PayItem $pay_item
 * @property-read \Modules\Payroll\Models\RunPayroll\RunPayroll|null $run_payroll
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeDeduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeDeduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeDeduction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeDeduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeDeduction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RunPayrollEmployeeDeduction withoutTrashed()
 */
	class RunPayrollEmployeeDeduction extends \Eloquent {}
}

namespace Modules\Payroll\Models\Setting{
/**
 * Modules\Payroll\Models\Setting\PayItem
 *
 * @property int $id
 * @property int $company_id
 * @property string $pay_type
 * @property string $pay_item
 * @property string $amount_type
 * @property string|null $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payroll\Models\Employee\Benefit> $benefits
 * @property-read \App\Models\Common\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payroll\Models\Employee\Deduction> $deductions
 * @property-read \App\Models\Auth\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Model account($accounts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model allCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem benefit()
 * @method static \Illuminate\Database\Eloquent\Builder|Model collect($sort = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|Model collectForExport($ids = [], $sort = 'name', $id_field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Model companyId($company_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Model contact($contacts)
 * @method static \Illuminate\Database\Eloquent\Builder|Model dateFilter(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem deduction()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|Model disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Model enabled()
 * @method static \Modules\Payroll\Database\Factories\PayItem factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isNotRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isOwner()
 * @method static \Illuminate\Database\Eloquent\Builder|Model isRecurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Model moduleEnabled(string $module)
 * @method static \Illuminate\Database\Eloquent\Builder|Model monthsOfYear(string $field)
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model reconciled($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|Model usingSearchString(?string $string = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem withoutTrashed()
 */
	class PayItem extends \Eloquent {}
}

