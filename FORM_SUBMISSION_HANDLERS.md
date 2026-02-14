# Document/Invoice Form Submission Handlers - Analysis Report

## Overview
This report documents the form submission handlers used for documents (invoices, bills, etc.) in the Akaunting application. The system uses Vue.js components with Axios for form submission and includes custom FormData serialization.

---

## Key Files Identified

### 1. PHP Form Request Validation
**File:** [app/Http/Requests/Document/Document.php](app/Http/Requests/Document/Document.php)

#### Purpose
- Main form request class for document creation and updates
- Handles validation rules for all document types (invoices, bills, etc.)
- Includes logging for debugging request data
- Validates items, dates, amounts, and recurring parameters

#### Key Methods

**`prepareForValidation()`** (Lines 16-36)
- Logs all incoming request data before validation
- Tracks item count, field presence, request size in KB
- Used for debugging form submission issues

**`rules()`** (Lines 44-103)
- Defines validation rules for documents
- Rules for items array: name, price, quantity
- Date validation: `issued_at` must be before `due_at`
- Special handling for quantity field with **max size of 10 or 12 characters**
  ```php
  foreach ($items as $key => $item) {
      $size = 10;
      if (Str::contains($item['quantity'], ['.', ','])) {
          $size = 12;
      }
      $rules['items.' . $key . '.quantity'] = 'required|max:' . $size;
  }
  ```

**`withValidator()`** (Lines 105-137)
- Formats dates after validation errors
- Converts date format for display

**`messages()`** (Lines 139-170)
- Custom validation error messages
- Dimension validation for company logo

### 2. API Controller
**File:** [app/Http/Controllers/Api/Document/Documents.php](app/Http/Controllers/Api/Document/Documents.php)

#### Methods
- **`store(Request $request)`** - Creates new document
- **`update(Document $document, Request $request)`** - Updates existing document
- **`show($id)`** - Retrieves document by ID or document number

Both store and update methods use the Document Form Request for validation.

---

## JavaScript/Vue Form Submission Handlers

### File: `public/js/modules/apps.min.js`

#### FormData Serialization Pattern
The application uses a custom `FormData.prototype.appendRecursive()` method to handle nested form data:

```javascript
FormData.prototype.appendRecursive = function(e) {
    var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null;
    for (var n in e)
        t ? "object" != o(e[n]) && e[n].constructor !== Array || 
            e[n] instanceof File == 1 || e[n] instanceof Blob == 1 ?
            this.append(t + "[" + n + "]", e[n]) :
            this.appendRecursive(e[n], t + "[" + n + "]") :
            "object" != o(e[n]) && e[n].constructor !== Array || 
            e[n] instanceof File == 1 || e[n] instanceof Blob == 1 ?
            this.append(n, e[n]) :
            this.appendRecursive(e[n], n)
};
```

**How it works:**
1. Recursively flattens nested objects/arrays
2. Preserves array notation: `items[0][quantity]`, `items[1][quantity]`, etc.
3. Handles File and Blob objects without recursion
4. Supports both dot notation and bracket notation for nested keys

#### Submit Method Pattern
Found in multiple Vue components (lines 7, 29, 91, 97, 137):

```javascript
onSubmit: function(e) {
    var t = this;
    this.form = e;
    this.loading = true;
    
    var n = this.form.data();  // Get form data as object
    
    // Append recursive function added to FormData
    FormData.prototype.appendRecursive = function(e) { ... };
    
    var r = new FormData;
    r.appendRecursive(n);  // Recursively add all form fields
    
    window.axios({
        method: this.form.method,
        url: this.form.action,
        data: r,
        headers: {
            "X-CSRF-TOKEN": window.Laravel.csrfToken,
            "X-Requested-With": "XMLHttpRequest",
            "Content-Type": "multipart/form-data"
        }
    }).then(function(e) {
        // Handle success
    }).catch(function(e) {
        // Handle error
    });
}
```

---

## Components Using Form Submission

### 1. Item Columns Editor
**Pattern Found:** Line 7
- Edits document item columns
- Uses FormData.appendRecursive for submission
- Reloads page on success: `location.reload()`

### 2. Company Form Editor
**Pattern Found:** Line 29
- Modal for editing company information
- Submits via Axios with FormData
- Updates parent component data on success

### 3. Item Selector/Add Component
**Pattern Found:** Line 91
- Allows adding new items to documents
- Searches items via autocomplete with **LIMIT of 10 items**:
  ```javascript
  n += " limit:10"  // Hard-coded item limit in search results
  ```
- Uses FormData for submission

### 4. Custom Item Addition
**Pattern Found:** Line 97
- Inline item creation
- FormData submission for adding new items

### 5. Document Modal Submit
**Pattern Found:** Line 137
- Generic modal submission handler
- Used for various document-related forms
- FormData serialization for nested data

---

## Potential Form Field Truncation Issues

### 1. **Quantity Field Max Length** 
- **Location:** [Document.php](app/Http/Requests/Document/Document.php) Lines 119-122
- **Issue:** Quantity fields are limited to **10 characters** (12 if they contain decimals)
- **Impact:** Large quantities or calculations may be truncated

### 2. **Item Search Limit**
- **Location:** `public/js/modules/apps.min.js` Line 97
- **Issue:** Item autocomplete searches return **maximum 10 items**
- **Impact:** Users with many items may not see all options

### 3. **FormData Recursive Limitation**
- **Potential Issue:** Large nested arrays might cause memory or processing issues
- **No explicit item count limit** found in FormData code
- **Could be limited by:** PHP `max_input_vars`, `post_max_size`, `memory_limit`

---

## Request/Response Flow

### Document Creation Flow
```
User fills form → Vue Component
    ↓
form.submit() → onSubmit() method
    ↓
FormData.appendRecursive() serializes all fields
    ↓
window.axios.post() via FormData
    ↓
App\Http\Requests\Document\Document prepareForValidation()
    ↓
Document::rules() validates data
    ↓
CreateDocument job processes valid request
    ↓
Database transaction updates/creates records
    ↓
JSON response with Document resource
    ↓
Frontend receives response and updates UI
```

---

## Headers and Configuration

**CSRF Protection:**
- Header: `X-CSRF-TOKEN: window.Laravel.csrfToken`
- Provided by Laravel middleware

**Content Type:**
- Explicitly set to: `multipart/form-data`
- Required for file uploads and nested form data

**Request Logging:**
- Logs are written in `prepareForValidation()`
- Includes: method, URL, all data, item count, request size
- Useful for debugging submission issues

---

## Code Locations Summary

| Component | Location | Lines | Purpose |
|-----------|----------|-------|---------|
| Document Form Request | [app/Http/Requests/Document/Document.php](app/Http/Requests/Document/Document.php) | 11-186 | Validation & logging |
| Document API Controller | [app/Http/Controllers/Api/Document/Documents.php](app/Http/Controllers/Api/Document/Documents.php) | 1-96 | API endpoints |
| Form Submit Pattern | public/js/modules/apps.min.js | 7, 29, 91, 97, 137 | Vue submit handlers |
| FormData Serializer | public/js/modules/apps.min.js | Multiple | Recursive field flattening |

---

## Recommendations for Investigation

1. **Check PHP Configuration** for `max_input_vars`, `post_max_size` limits
2. **Review Log Files** at `storage/logs/` for form submission errors
3. **Test with Large Item Counts** to identify truncation points
4. **Monitor Network Tab** in browser DevTools to see actual FormData being sent
5. **Check Database Constraints** for field max lengths and value limits
6. **Review Customer Support Tickets** for patterns of lost form data

---

## Related Requests/Models

- [DocumentAddItem.php](app/Http/Requests/Document/DocumentAddItem.php) - Adding items
- [DocumentItem.php](app/Http/Requests/Document/DocumentItem.php) - Item validation
- [DocumentTotal.php](app/Http/Requests/Document/DocumentTotal.php) - Total calculations
- [DocumentItemTax.php](app/Http/Requests/Document/DocumentItemTax.php) - Tax handling

