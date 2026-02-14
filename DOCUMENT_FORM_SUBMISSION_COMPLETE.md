# Complete Document Form Submission Architecture

## Overview
This document describes the complete form submission pipeline for document (invoice/bill) creation and updates in the Akaunting system.

---

## 1. Form Rendering Layer

### Form Component Template
**File:** [resources/views/components/form/index.blade.php](resources/views/components/form/index.blade.php)

The base form component binds to a dynamic Vue method using the `@submit.prevent` directive:

```blade
<form 
    :id="$formId"
    :action="$formRoute"
    :method="$formMethod"
    @submit.prevent="{{ $submit }}"
>
    @csrf
    @method($method)
    ...
</form>
```

**Key Properties:**
- `$formId` - Unique form identifier (passed from parent component)
- `$formRoute` - API endpoint for form submission (calculated dynamically)
- `$formMethod` - HTTP method (POST for create, PUT for update)
- `{{ $submit }}` - Vue method name that handles form submission
- `@csrf` - Laravel CSRF token
- `@method()` - HTTP method override for non-POST requests

---

## 2. Form Configuration Component

### Document Form Component Class
**File:** [app/Abstracts/View/Components/Documents/Form.php](app/Abstracts/View/Components/Documents/Form.php)

```php
class Form extends Component
{
    // Form properties
    public $formId;
    public $formRoute;
    public $formMethod;
    
    public function __construct(
        Type $type,
        ?Model $model = null,
        ?string $formId = null,
        ?string $formRoute = null,
        ?string $formMethod = null,
        ...
    ) {
        // Constructor runs when component is instantiated
        $this->formId = $formId;
        $this->formRoute = $this->getFormRoute($type, $formRoute, $model);
        $this->formMethod = $this->getFormMethod($type, $formMethod, $model);
    }
}
```

**Form Variables Assignment (Lines 336-338):**
```php
$this->formId = $formId;
$this->formRoute = $this->getFormRoute($type, $formRoute, $this->model);
$this->formMethod = $this->getFormMethod($type, $formMethod, $this->model);
```

**Route Determination Logic:**
- **Create:** Route is `/api/document/{type}` (e.g., `/api/document/invoice`)
- **Update:** Route is `/api/document/{type}/{id}` (e.g., `/api/document/invoice/123`)
- Routes are determined by `getFormRoute()` helper method in ViewComponents trait

**Method Determination Logic:**
- **Create:** `POST`
- **Update:** `PUT`
- Methods are determined by `getFormMethod()` helper method in ViewComponents trait

---

## 3. Form Content Template

### Document Form Content
**File:** [resources/views/components/documents/form/content.blade.php](resources/views/components/documents/form/content.blade.php)

```blade
<x-form
    :id="$formId"
    :route="$formRoute"
    method="{{ $formMethod }}"
    submit="onSubmit"
    class="space-y-4"
>
    <!-- Company selection -->
    <x-documents.form.company-section />
    
    <!-- Main details (amount, dates, etc) -->
    <x-documents.form.details-section />
    
    <!-- Items (line items) -->
    <x-documents.form.items-section />
    
    <!-- Submit buttons -->
    <x-documents.form.buttons />
</x-form>
```

---

## 4. Vue Form Submission Handler

### Form Submission Method
**Location:** [public/js/common/companies.min.js](public/js/common/companies.min.js) (lines 7, 29, 91, 97, 137)

The Vue component instance has a form object with these properties:
```javascript
this.form = {
    method: 'POST',      // HTTP method from form element
    action: '/api/document/invoice',  // Submission URL
    loading: false,      // Loading state flag
    data: function() {   // Method to get form data
        // Returns all form field values as object
    }
}
```

**onSubmit Handler Pattern:**
```javascript
onSubmit: function(e) {
    this.form = e;  // Form object from @submit.prevent
    this.form.loading = true;  // Set loading flag
    
    // 1. Get all form data as object
    var data = this.form.data();
    
    // 2. Define FormData recursive append method
    FormData.prototype.appendRecursive = function(obj) {
        var prefix = arguments.length > 1 ? arguments[1] : null;
        
        for (var key in obj) {
            var value = obj[key];
            var fullKey = prefix ? prefix + "[" + key + "]" : key;
            
            // Handle nested objects and arrays recursively
            if (typeof value === 'object' && value !== null && 
                value.constructor !== Array &&
                !(value instanceof File) && !(value instanceof Blob)) {
                // Recursively append nested object
                this.appendRecursive(value, fullKey);
            } else if (value instanceof Array && 
                       !(value instanceof File) && !(value instanceof Blob)) {
                // For arrays, use bracket notation
                this.appendRecursive(value, fullKey);
            } else {
                // Append primitive value or File/Blob
                this.append(fullKey, value);
            }
        }
    };
    
    // 3. Create FormData and append all data recursively
    var formData = new FormData();
    formData.appendRecursive(data);
    
    // 4. Submit via axios with CSRF token and proper headers
    window.axios({
        method: this.form.method,        // POST or PUT
        url: this.form.action,           // API endpoint
        data: formData,                  // Serialized form data
        headers: {
            "X-CSRF-TOKEN": window.Laravel.csrfToken,
            "X-Requested-With": "XMLHttpRequest",
            "Content-Type": "multipart/form-data"
        }
    })
    .then(this.onSuccess.bind(this))
    .catch(this.onFail.bind(this))
}
```

---

## 5. FormData Serialization

### How Nested Fields Are Handled

**Input Example:**
```javascript
{
    contact_id: 5,
    currency_code: "USD",
    items: [
        {
            item_id: 10,
            quantity: 5,
            price: 100.00
        },
        {
            item_id: 20,
            quantity: 3,
            price: 150.00
        }
    ],
    taxes: [
        {
            tax_id: 1,
            rate: 10
        }
    ]
}
```

**FormData Serialization Result:**
```
contact_id=5
currency_code=USD
items[0][item_id]=10
items[0][quantity]=5
items[0][price]=100
items[1][item_id]=20
items[1][quantity]=3
items[1][price]=150
taxes[0][tax_id]=1
taxes[0][rate]=10
```

**Benefits:**
- Preserves array field structure with bracket notation
- Compatible with Laravel form request array validation
- Handles file uploads in nested structures
- Recursive approach works with deeply nested objects

---

## 6. Server-Side Request Validation

### Form Request Class
**File:** [app/Http/Requests/Document/Document.php](app/Http/Requests/Document/Document.php)

**Preparation & Logging (Lines 15-35):**
```php
protected function prepareForValidation()
{
    parent::prepareForValidation();
    
    $all_data = $this->all();
    Log::info('Document Request - Before Validation', [
        'method' => $this->getMethod(),
        'url' => $this->url(),
        'items_count' => count($this->get('items', [])),
        'has_issued_at' => isset($all_data['issued_at']),
        'has_due_at' => isset($all_data['due_at']),
        'has_currency_code' => isset($all_data['currency_code']),
        'has_contact_id' => isset($all_data['contact_id']),
        'has_category_id' => isset($all_data['category_id']),
        'all_keys' => array_keys($all_data),
        'issued_at_value' => $this->get('issued_at'),
        'due_at_value' => $this->get('due_at'),
        'currency_code_value' => $this->get('currency_code'),
        'all_data' => $all_data,
        'request_size_kb' => strlen(json_encode($all_data)) / 1024,
    ]);
}
```

**Log Location:** `storage/logs/laravel-*.log`

**Validation Rules (Sample):**
```php
public function rules()
{
    // Quantity fields limited to 10 characters (12 with decimals)
    'items.*.quantity' => 'required|numeric|max:10',
    
    // Date validation
    'issued_at' => 'required|date',
    'due_at' => 'required|date|after_or_equal:issued_at',
    
    // Contact and currency
    'contact_id' => 'required|exists:contacts',
    'currency_code' => 'required|in:' . implode(',', $currencies)
}
```

---

## 7. Complete Data Flow Diagram

```
┌─────────────────────────────────────────────────────────────┐
│  User Form Interaction                                       │
│  (Type contact, amount, items, select dates, etc)            │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│  Blade Form Component (x-form)                              │
│  @submit.prevent="{{ $submit }}"                            │
│  Creates form element with:                                 │
│  - action: $formRoute                                       │
│  - method: $formMethod                                      │
│  - id: $formId                                              │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│  Vue.js Component                                           │
│  Intercepts @submit.prevent and calls:                      │
│  onSubmit(formElement)                                      │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│  Form Data Serialization                                    │
│  1. Get all form field values: this.form.data()             │
│  2. Extend FormData with appendRecursive() method           │
│  3. Recursively flatten nested objects to FormData:         │
│     items[0][quantity], items[0][price], etc               │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│  AJAX Submission via Axios                                  │
│  window.axios({                                             │
│    method: 'POST' or 'PUT',                                 │
│    url: '/api/document/invoice' or '/api/document/bill',   │
│    data: formData,                                          │
│    headers: {                                               │
│      'X-CSRF-TOKEN': token,                                 │
│      'X-Requested-With': 'XMLHttpRequest',                  │
│      'Content-Type': 'multipart/form-data'                  │
│    }                                                        │
│  })                                                         │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│  Server-Side Processing                                     │
│  1. Laravel receives request                                │
│  2. Form Request prepareForValidation() logs all data       │
│  3. Validates using rules()                                 │
│  4. Processes and saves document                            │
│  5. Returns JSON response                                   │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│  Response Handling                                          │
│  onSuccess() or onFail()                                    │
│  - Success: Redirect or reload                              │
│  - Failure: Display validation errors                       │
└─────────────────────────────────────────────────────────────┘
```

---

## 8. Form Variables Reference

| Variable | Purpose | Value Example | Set In |
|----------|---------|----------------|--------|
| `$formId` | HTML form ID attribute | `document-form-1` | Component constructor |
| `$formRoute` | API endpoint for submission | `/api/document/invoice` | `getFormRoute()` method |
| `$formMethod` | HTTP method | `POST` or `PUT` | `getFormMethod()` method |
| `$submit` | Vue method name | `onSubmit` | Form content template |

---

## 9. Key Implementation Files Summary

| File | Purpose | Key Components |
|------|---------|-----------------|
| [resources/views/components/form/index.blade.php](resources/views/components/form/index.blade.php) | Base form template | `@submit.prevent`, `@csrf`, form attributes |
| [resources/views/components/documents/form/content.blade.php](resources/views/components/documents/form/content.blade.php) | Document form layout | Sections for company, details, items, buttons |
| [app/Abstracts/View/Components/Documents/Form.php](app/Abstracts/View/Components/Documents/Form.php) | Component initialization | Constructor, form variable setup |
| [public/js/common/companies.min.js](public/js/common/companies.min.js) | Form submission handler | `onSubmit`, FormData serialization, axios call |
| [app/Http/Requests/Document/Document.php](app/Http/Requests/Document/Document.php) | Validation & logging | `prepareForValidation()`, `rules()` |

---

## 10. Debugging Form Submission Issues

### Enable Logging
The form request logs all incoming data before validation. Check logs for:

```bash
tail -f storage/logs/laravel-*.log | grep "Document Request"
```

### Log Output Includes
- HTTP method and URL
- Item count
- Presence of key fields (issued_at, due_at, currency_code, etc)
- Full request data payload
- Request size in KB

### Common Issues

**Issue: Form submits but validation fails**
- Check `prepareForValidation()` logs for actual data received
- Verify FormData serialization is working (check browser Network tab)
- Confirm CSRF token is included in headers

**Issue: Nested items not serializing correctly**
- Verify FormData.appendRecursive() is extending FormData.prototype
- Check browser console for JavaScript errors
- Confirm items are in correct array format before submission

**Issue: File uploads not included**
- FormData handles File objects natively
- Check that file input is included in form.data()
- Verify multipart/form-data header is set

---

## 11. Form Submission Method Names

The `$submit` variable contains the Vue method name to execute. Common methods:

- `onSubmit` - Standard form submission
- `onSubmitViaSendEmail` - Submit and send via email (from buttons component)
- Custom methods in specific components

The method is referenced dynamically in the template, allowing different components to have different submission handlers.

---

## 12. API Endpoints

### Document Creation
- **Endpoint:** `POST /api/document/{type}`
- **Types:** `invoice`, `bill`
- **Example:** `POST /api/document/invoice`
- **Response:** JSON with created document data

### Document Update
- **Endpoint:** `PUT /api/document/{type}/{id}`
- **Example:** `PUT /api/document/invoice/123`
- **Response:** JSON with updated document data

Both endpoints are handled by the same Form Request validation class.

---

## Summary

The form submission architecture uses:
1. **Blade component system** for template structure with dynamic variables
2. **PHP component classes** for initialization and form configuration
3. **Vue.js** for client-side form handling and submission interception
4. **FormData API** with custom recursive serialization for nested data
5. **Axios** for AJAX submission with CSRF protection
6. **Laravel Form Request** for server-side validation and logging

This architecture provides a clean separation of concerns between rendering, client-side handling, and server-side validation.
