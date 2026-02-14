@php
    $itemsData = $items->map(function ($item) {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'code' => $item->sku,
            'price' => $item->purchase_price ?? 0,
        ];
    })->values();
    
    // Determine flow type (create or return)
    $flowType = $flow ?? 'create';
@endphp
<x-layouts.admin>
    <x-slot name="title">{{ trans_choice('inventory::general.pot', 2) }}</x-slot>

    <x-slot name="favorite"
        title="{{ trans_choice('inventory::general.pot', 2) }}"
        icon="point_of_sale"
        route="inventory.pot.index"
    ></x-slot>

    <x-slot name="content">
        <!-- Alert Container -->
        <div id="alertContainer"></div>

        <div class="pot-container" id="potApp">
            <div class="col">
                <p class="text-muted mb-0">
                    {{ trans('inventory::general.pot_display') }} 
                    @if($flowType === 'return')
                        - {{ trans('inventory::general.pot_text.create_return') }}
                    @else
                        - {{ trans('inventory::general.pot_text.create_transfer') }}
                    @endif
                </p>
            </div>
            <form id="transferOrderForm" method="POST" action="{{ route('inventory.pot.store') }}">
                @csrf
                <div class="pot-layout">
                <!-- Left Column: Items Section -->
                <div class="pot-items-section">
                    <!-- Items Grid -->
                    <div class="pot-card">
                        <div class="pot-card-header">
                            <div class="pot-items-header">
                                @if($flowType === 'return')
                                    <div class="pot-account-display max-w-56 min-w-56">
                                        <label>{{ trans_choice('general.debit_accounts', 1) }}</label>
                                        <div class="pot-account-value" id="debitAccDisplay">
                                            <span class="pot-account-text">{{ trans('general.not_selected') }}</span>
                                        </div>
                                        <input type="hidden" id="debitAcc" name="debitAcc" value="">
                                    </div>
                                @else
                                    <div class="pot-account-display max-w-56 min-w-56">
                                        <label>{{ trans_choice('general.credit_accounts', 1) }}</label>
                                        <div class="pot-account-value" id="creditAccDisplay">
                                            <span class="pot-account-text">{{ trans('general.not_selected') }}</span>
                                        </div>
                                        <input type="hidden" id="creditAcc" name="creditAcc" value="">
                                    </div>
                                @endif
                                <div class="pot-accounts-settings max-w-24">
                                    <button type="button" class="pot-settings-btn" id="accountSettingsBtn" title="{{ trans('general.settings') }}">
                                        <i class="material-icons">settings</i>
                                    </button>
                                </div>
                                <div class="pot-items-selected-count max-w-48 min-w-48">
                                    <span class="pot-count-label">SELECTED ITEMS</span>
                                    <span class="pot-count-value" id="selectedItemsCount">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="pot-card-body" style="position: relative;">
                            <!-- Preloader -->
                            <div id="potPreloader" class="pot-preloader" style="display: none;">
                                <img src="{{ asset('public/img/admin24-loading.gif') }}" class="pot-preloader-img" alt="Loading..." />
                            </div>
                            <!-- Warehouse Selection Overlay -->
                            <div id="warehouseOverlay" class="pot-warehouse-overlay">
                                <div class="pot-warehouse-overlay-content text-sm">
                                    Please select a source warehouse first
                                </div>
                            </div>
                            <div id="itemsGrid" class="pot-items-grid">
                                @forelse($items as $item)
                                    <div class="pot-item-card" data-item-id="{{ $item->id }}" data-item-name="{{ $item->name }}" data-item-code="{{ $item->sku }}" data-item-price="{{ $item->purchase_price ?? 0 }}">
                                        <div class="pot-item-name">{{ $item->name }}</div>
                                        <div class="pot-item-code">{{ $item->sku }}</div>
                                        <div class="pot-item-info">
                                            <span class="pot-item-qty">Qty: {{ $item->inventory_count ?? 0 }}</span>
                                            <span class="pot-item-price">{{ $currency->symbol }}{{ number_format($item->purchase_price ?? 0, 2) }}</span>
                                        </div>
                                        <button type="button" class="pot-item-remove-btn" onclick="potApp.removeItemFromSelection(event)" style="display: none;" title="Remove from selection">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </div>
                                @empty
                                    <p class="pot-no-items">{{ trans('general.no_records') }}</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="pot-card-footer">
                            <div class="pot-items-footer">
                                <div>
                                    <x-searchable-select
                                        id="sourceWarehouse"
                                        name="sourceWarehouse"
                                        label="{{ trans_choice('inventory::general.warehouses', 1) }}"
                                        :options="collect($warehouses)->map(fn($name, $id) => ['id' => $id, 'label' => $name])->values()"
                                    />
                                </div>
                                <div class="pot-form-group">
                                    <label>{{ trans('general.search') }}</label>
                                    <input type="text" id="itemSearch" class="pot-input pot-header-input" placeholder="Item name or code...">
                                </div>                                
                                <div class="pot-items-total">
                                    <span class="pot-count-label">AVAILABLE ITEMS</span>
                                    <span class="pot-count-value" id="totalItemsCount">{{ $items->count() }}</span>
                                </div>
                                <div class="pot-items-pagination">
                                    <button type="button" class="pot-nav-btn" id="itemsNavUp" onclick="potApp.navigateItemsPage(-1)" title="Previous page">
                                        <i class="material-icons">chevron_left</i>
                                    </button>
                                    <button type="button" class="pot-nav-btn" id="itemsNavDown" onclick="potApp.navigateItemsPage(1)" title="Next page">
                                        <i class="material-icons">chevron_right</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Cart/Order Summary -->
                <div class="pot-cart-section">
                    <div class="pot-card pot-sticky">
                        <div class="pot-card-header pot-header-primary">
                            <div class="pot-header-content">
                                <h3 class="pot-card-title">{{ trans_choice('inventory::general.transfer_orders', 1) }}</h3>
                                <div class="pot-header-right">                                    
                                    <div class="pot-header-destination-text">
                                        <div class="pot-destination-label">{{ trans('inventory::general.destination_warehouse') }}</div>
                                        <div class="pot-destination-name" id="destinationWarehouseName">Select warehouse</div>
                                    </div>
                                    <i class="material-icons pot-header-icon">warehouse</i>
                                </div>
                            </div>
                        </div>

                        <div class="pot-card-body pot-form-group">
                            <!-- Transfer Details -->
                            <div class="pot-form-group">
                                <label>{{ trans('general.date') }}</label>
                                <input type="date" id="transferDate" class="pot-input text-sm" value="{{ now()->toDateString() }}">
                            </div>

                            <div class="pot-form-group">
                                <x-searchable-select
                                    id="destinationWarehouse"
                                    name="destinationWarehouse"
                                    label="{{ trans('inventory::general.destination_warehouse') }}"
                                    :options="collect($warehouses)->map(fn($name, $id) => ['id' => $id, 'label' => $name])->values()"
                                />
                            </div>

                            <hr class="pot-divider">

                            <!-- Cart Items -->
                            <div class="pot-cart-items">
                                <div class="pot-cart-header-top">
                                    <h4 class="pot-cart-title">{{ trans_choice('inventory::general.items', 2) }}</h4>
                                    <div class="pot-item-count" id="itemCount">0</div>
                                </div>
                                <div class="pot-cart-item-nav">
                                    <button type="button" class="pot-nav-btn" id="cartNavUp" onclick="potApp.navigateCart(-1)" disabled title="Previous item">
                                        <i class="material-icons">keyboard_arrow_up</i>
                                    </button>
                                    <div id="cartItems" class="pot-cart-list">
                                        <p class="pot-empty-cart">{{ trans('general.no_records') }}</p>
                                    </div>
                                    <button type="button" class="pot-nav-btn" id="cartNavDown" onclick="potApp.navigateCart(1)" disabled title="Next item">
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </button>
                                </div>
                            </div>

                            <hr class="pot-divider">

                            <!-- Totals -->
                            <div class="pot-totals">
                                <div class="pot-total-row">
                                    <span>{{ trans_choice('inventory::general.items', 2) }}:</span>
                                    <span id="totalItems">0</span>
                                </div>
                                <div class="pot-total-row">
                                    <span>{{ trans('inventory::general.quantity') }}:</span>
                                    <span id="totalQty">0</span>
                                </div>
                                <div class="pot-total-row pot-grand-total">
                                    <span>{{ trans_choice('general.totals', 1) }}:</span>
                                    <span id="totalValue">{{ $currency->symbol }}0.00</span>
                                </div>
                            </div>
                        </div>

                        <div class="pot-card-footer">
                            <a href="{{ route('inventory.pot.index') }}" class="pot-btn pot-btn-secondary pot-btn-full">
                                {{ trans('general.cancel') }}
                            </a>
                            <button type="button" id="submitTransfer" class="pot-btn pot-btn-primary pot-btn-full" disabled>
                                {{ trans('general.create') }}
                            </button>
                            <button type="button" id="clearCart" class="pot-btn pot-btn-outline pot-btn-full pot-btn-sm">
                                {{ trans('general.clear') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            </form>

            <!-- Account Settings Modal -->
            <div class="account-modal-overlay" id="accountSettingsModal">
                <div class="account-modal">
                    <div class="account-modal-header">
                        <h5 class="account-modal-title">{{ trans_choice('general.settings', 2) }}</h5>
                        <button type="button" class="account-modal-close" id="closeAccountModalBtn" aria-label="Close">&times;</button>
                    </div>
                    <div class="account-modal-body">
                        @if($flowType === 'return')
                            <x-searchable-select
                                id="modalDebitAcc"
                                name="modalDebitAcc"
                                label="{{ trans_choice('general.debit_accounts', 1) }}"
                                :options="collect($accounts)->map(fn($name, $id) => ['id' => $id, 'label' => $name])->values()"
                            />
                        @else
                            <x-searchable-select
                                id="modalCreditAcc"
                                name="modalCreditAcc"
                                label="{{ trans_choice('general.credit_accounts', 1) }}"
                                :options="collect($accounts)->map(fn($name, $id) => ['id' => $id, 'label' => $name])->values()"
                            />
                        @endif
                    </div>
                    <div class="account-modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelAccountSettingsBtn">{{ trans('general.cancel') }}</button>
                        <button type="button" class="btn btn-primary" id="saveAccountSettingsBtn">{{ trans('general.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @push('stylesheet')
    <style>
        /* Alert Container */
        #alertContainer {
            position: fixed;
            bottom: 30px;
            right: 30px;
            max-width: 400px;
            z-index: 9999;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-left-width: 4px;
            border-radius: 4px;
            animation: slideIn 0.3s ease-in-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(400px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-success {
            background-color: #f0fff4;
            border-color: #48bb78;
            color: #2f855a;
        }

        .alert-error, .alert-danger {
            background-color: #fff5f5;
            border-color: #f56565;
            color: #c53030;
        }

        .alert-warning {
            background-color: #fffaf0;
            border-color: #ed8936;
            color: #c05621;
        }

        .alert-info {
            background-color: #ebf8ff;
            border-color: #4299e1;
            color: #2c5282;
        }

        .alert-close {
            float: right;
            cursor: pointer;
            font-size: 1.5rem;
            font-weight: bold;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .alert-close:hover {
            opacity: 1;
        }

        .pot-container {
            padding: 0;
        }

        .pot-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            align-items: center;
        }

        .pot-items-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 24px;
        }

        .pot-cart-section {
            display: flex;
            flex-direction: column;
        }

        .pot-card {
            width: 100%;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .pot-card-header {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .pot-card-header.pot-header-primary {
            background: linear-gradient(135deg, #3b4f69 0%, #40979d 100%);
            border-bottom: none;
            padding: 16px;
        }

        .pot-header-content {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 24px;
            align-items: center;
        }

        .pot-header-right {
            display: grid;
            grid-template-columns: 9fr 1fr;
            gap: 5px;
            align-items: center;
        }

        .pot-header-destination-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
            text-align: right;
            justify-content: center;
        }

        .pot-destination-label {
            font-size: 10px;
            color: white;
            opacity: 0.85;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
            line-height: 1.2;
        }

        .pot-destination-name {
            font-size: 12px;
            color: white;
            font-weight: 700;
            opacity: 0.95;
            line-height: 1.2;
        }

        .pot-header-icon {
            font-size: 28px !important;
            color: white;
            opacity: 0.9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pot-card-header.pot-header-primary .pot-card-title {
            color: white;
        }

        .pot-card-title {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
        }

        .pot-card-body {
            padding: 16px;
        }

        .pot-card-footer {
            padding: 16px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .pot-search-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .pot-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .pot-form-group label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .pot-input {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
        }

        .pot-input:focus {
            outline: none;
            border-color: #3b4f69;
            box-shadow: 0 0 0 3px rgba(59, 79, 105, 0.1);
        }

        .pot-header-input {
            padding: 6px 10px;
            font-size: 13px;
        }

        .pot-card-header .pot-form-group {
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .pot-card-header .pot-form-group label,
        .pot-card-footer .pot-form-group label {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .pot-items-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            transition: transform 0.3s ease;
            overflow: hidden;
            min-height: 468px;
            align-content: start;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .pot-items-header {
            display: grid;
            grid-template-columns: 2fr 1fr 2fr;
            gap: 16px;
            align-items: flex-end;
        }

        .pot-account-display {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .pot-account-display label {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin: 0;
        }

        .pot-account-value {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: white;
            min-height: 36px;
            display: flex;
            align-items: center;
            overflow: hidden;
            width: 100%;
            box-sizing: border-box;
            min-width: 0;
        }

        .pot-account-text {
            color: #6b7280;
            font-weight: 500;
            white-space: nowrap;
            display: inline-block;
            width: 100%;
        }

        .pot-account-value:not(:hover) .pot-account-text {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pot-account-value:hover .pot-account-text.is-overflowing {
            animation: accountMarquee linear infinite;
        }

        @keyframes accountMarquee {
            0% {
                transform: translateX(0);
            }
            var(--scroll-percent) {
                transform: translateX(calc(-1 * var(--scroll-distance, 0px)));
            }
            100% {
                transform: translateX(calc(-1 * var(--scroll-distance, 0px)));
            }
        }

        .pot-account-value.selected .pot-account-text {
            color: #374151;
            font-weight: 600;
        }

        .pot-accounts-settings {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            min-height: 44px;
        }

        .pot-settings-btn {
            width: 40px;
            height: 40px;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            color: #6b7280;
        }

        .pot-settings-btn:hover {
            background: #f3f4f6;
            border-color: #3b4f69;
            color: #3b4f69;
        }

        .pot-settings-btn .material-icons {
            font-size: 20px !important;
        }

        .pot-items-title {
            font-size: 22px;
            font-weight: 800;
            color: #1f2937;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .pot-items-selected-count {
            display: flex;
            flex-direction: column;
            gap: 2px;
            text-align: right;
        }

        .pot-items-footer {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .pot-count-label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .pot-count-value {
            font-size: 18px;
            font-weight: 800;
            color: #3b4f69;
        }

        .pot-items-footer {
            display: grid;
            grid-template-columns: 1.5fr 1.5fr auto auto;
            gap: 16px;
            align-items: center;
        }

        .pot-items-total {
            display: flex;
            flex-direction: column;
            text-align: right;
            gap: 2px;
        }

        .pot-items-pagination {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .pot-items-pagination .pot-nav-btn {
            width: 44px;
            height: 44px;
        }

        .pot-items-pagination .material-icons {
            font-size: 20px !important;
        }

        .pot-item-card {
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 140px;
        }

        .pot-item-card:hover {
            border-color: #3b4f69;
            box-shadow: 0 4px 12px rgba(59, 79, 105, 0.1);
        }

        .pot-item-card.selected {
            border-color: #40979d;
            background: rgba(64, 151, 157, 0.08);
            box-shadow: 0 0 0 3px rgba(64, 151, 157, 0.15);
            position: relative;
        }

        .pot-item-card.pot-item-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pot-item-card.pot-item-disabled:hover {
            border-color: #e5e7eb;
            box-shadow: none;
        }

        .pot-item-card .pot-item-remove-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #ef4444;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            padding: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        .pot-item-card .pot-item-remove-btn:hover {
            background: #dc2626;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
            transform: scale(1.1);
        }

        .pot-item-card .pot-item-remove-btn i {
            font-size: 18px;
        }

        .pot-item-name {
            font-weight: 600;
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 4px;
            flex-shrink: 0;
        }

        .pot-item-code {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
            flex-shrink: 0;
        }

        .pot-item-info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: auto;
        }

        .pot-item-qty {
            color: #6b7280;
        }

        .pot-item-price {
            color: #3b4f69;
            font-weight: 600;
        }

        .pot-no-items {
            text-align: center;
            color: #9ca3af;
            padding: 40px 0;
        }

        .pot-destination {
            padding-bottom: 16px;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 16px;
        }

        .pot-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .pot-destination-value {
            font-weight: 600;
            color: #3b4f69;
            margin: 0;
        }

        .pot-divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 16px 0;
        }

        #cartItems {
            width: 100%;
            min-height: 85px;
            align-content: center;
        }

        .pot-cart-items {
            margin-bottom: 16px;
        }

        .pot-cart-header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .pot-cart-title {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .pot-item-count {
            font-size: 22px;
            font-weight: 700;
            color: #3b4f69;
        }

        .pot-cart-item-nav {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .pot-nav-btn {
            width: 44px;
            height: 44px;
            padding: 0;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: white;
            color: #3b4f69;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pot-nav-btn .material-icons {
            font-size: 22px !important;
            color: inherit;
        }

        .pot-nav-btn:hover:not(:disabled) {
            border-color: #3b4f69;
            background: #f9fafb;
        }

        .pot-nav-btn:active:not(:disabled) {
            background: #3b4f69;
            color: white;
        }

        .pot-nav-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .pot-empty-cart {
            text-align: center;
            color: #9ca3af;
            padding: 20px 0;
            margin: 0;
            font-size: 13px;
        }

        .pot-cart-item {
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background: #f9fafb;
            font-size: 13px;
        }

        .pot-cart-item-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 8px;
        }

        .pot-cart-item-name {
            font-weight: 600;
            color: #1f2937;
        }

        .pot-cart-item-code {
            font-size: 11px;
            color: #6b7280;
        }

        .pot-cart-item-qty-input {
            width: 50px;
            padding: 4px 6px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 12px;
            text-align: center;
        }

        .pot-qty-control {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pot-qty-btn {
            width: 28px;
            height: 28px;
            padding: 0;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            background: white;
            color: #3b4f69;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .pot-qty-btn:hover {
            border-color: #3b4f69;
            background: #f9fafb;
        }

        .pot-qty-btn:active {
            background: #3b4f69;
            color: white;
        }

        .pot-totals {
            background: #f9fafb;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 16px;
        }

        .pot-total-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            padding: 6px 0;
            color: #6b7280;
        }

        .pot-grand-total {
            border-top: 1px solid #d1d5db;
            padding-top: 8px;
            margin-top: 8px;
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
        }

        .pot-btn {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.2s ease;
        }

        .pot-btn-primary {
            background: linear-gradient(135deg, #3b4f69 0%, #40979d 100%);
            color: white;
        }

        .pot-btn-primary:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 79, 105, 0.3);
        }

        .pot-btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pot-btn-secondary {
            background: #6b7280;
            color: white;
        }

        .pot-btn-secondary:hover {
            background: #4b5563;
        }

        .pot-btn-outline {
            background: transparent;
            border: 1px solid #d1d5db;
            color: #6b7280;
        }

        .pot-btn-outline:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        .pot-btn-full {
            width: 100%;
        }

        .pot-btn-sm {
            padding: 8px 12px;
            font-size: 13px;
        }

        .pot-sticky {
            position: sticky;
            top: 20px;
        }

        /* Warehouse selection overlay */
        .pot-warehouse-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 40;
            pointer-events: all;
        }

        .pot-warehouse-overlay-content {
            text-align: center;
            color: #6b7280;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        /* Preloader within grid */
        .pot-preloader {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            pointer-events: all;
        }

        .pot-preloader-img {
            width: 120px;
            height: 120px;
        }

        .pot-btn-remove {
            background: #ef4444;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            padding: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
            flex-shrink: 0;
        }

        .pot-btn-remove:hover {
            background: #dc2626;
            box-shadow: 0 3px 10px rgba(239, 68, 68, 0.4);
            transform: scale(1.1);
        }

        .pot-select-account,
        #sourceWarehouse {
            width: 100%;
            max-width: 100%;
        }

        .pot-btn-remove i {
            font-size: 10px;
        }

        @media (max-width: 1024px) {
            .pot-layout {
                grid-template-columns: 1fr;
            }

            .pot-items-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }

            .pot-sticky {
                position: static;
            }
        }

        /* Account Settings Modal */
        .account-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .account-modal-overlay.show {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .account-modal {
            background: white;
            border-radius: 8px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 90%;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .account-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .account-modal-title {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }

        .account-modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6b7280;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }

        .account-modal-close:hover {
            color: #1f2937;
        }

        .account-modal-body {
            padding: 20px;
        }

        .account-modal-body .form-group {
            margin-bottom: 16px;
        }

        .account-modal-body .form-group:last-child {
            margin-bottom: 0;
        }

        .account-modal-body label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }

        .account-modal-body .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .account-modal-footer {
            display: flex;
            gap: 12px;
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            justify-content: flex-end;
        }

        .account-modal-footer .btn {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 100px;
        }

        .account-modal-footer .btn-primary {
            background: linear-gradient(135deg, #3b4f69 0%, #40979d 100%);
            color: white;
            box-shadow: 0 2px 4px rgba(59, 79, 105, 0.2);
        }

        .account-modal-footer .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(59, 79, 105, 0.3);
        }

        .account-modal-footer .btn-primary:active {
            transform: translateY(0);
        }

        .account-modal-footer .btn-secondary {
            background: #6b7280;
            color: white;
            box-shadow: 0 2px 4px rgba(107, 114, 128, 0.2);
        }

        .account-modal-footer .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(107, 114, 128, 0.3);
        }

        .account-modal-footer .btn-secondary:active {
            transform: translateY(0);
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        const itemsData = @json($itemsData);
        const flowType = '{{ $flowType }}';  // 'create' or 'return'
        
        const potApp = {
            currency: '{{ $currency->symbol }}',
            flow: flowType,
            cart: [],
            items: itemsData,
            selectedItemIds: new Set(),
            currentCartIndex: 0,
            currentItemsPage: 0,
            itemsPerPage: 9,
            visibleItemsCount: 0,
            touchStartX: 0,
            touchStartY: 0,

            init() {
                // Initialize all cards with data-filtered attribute
                document.querySelectorAll('.pot-item-card').forEach(card => {
                    card.setAttribute('data-filtered', '0');
                    card.addEventListener('click', () => this.addToCart(card));
                });
                
                // Set initial visible count
                this.visibleItemsCount = document.querySelectorAll('.pot-item-card').length;

                document.getElementById('clearCart').addEventListener('click', () => this.clearCart());
                document.getElementById('submitTransfer').addEventListener('click', () => this.submitTransfer());
                document.getElementById('itemSearch').addEventListener('input', () => this.filterItems());
                
                // Load preset accounts from localStorage based on flow type
                this.loadPresetAccounts();
                
                // Listen for source warehouse changes to update item quantities using MutationObserver
                const sourceWarehouseInput = document.querySelector('input[name="sourceWarehouse"]');
                if (sourceWarehouseInput) {
                    let lastValue = sourceWarehouseInput.value;
                    
                    // Watch for value attribute changes
                    const observer = new MutationObserver((mutations) => {
                        const newValue = sourceWarehouseInput.value;
                        if (newValue !== lastValue) {
                            lastValue = newValue;
                            this.updateItemQuantities();
                        }
                    });
                    
                    observer.observe(sourceWarehouseInput, {
                        attributes: true,
                        attributeFilter: ['value']
                    });
                    
                    // Also listen for change event as fallback
                    sourceWarehouseInput.addEventListener('change', () => {
                        const sourceVal = sourceWarehouseInput.value;
                        const destInput = document.querySelector('input[name="destinationWarehouse"]');
                        const destVal = destInput ? destInput.value : '';
                        this.savePresetWarehouses(sourceVal, destVal);
                        this.updateItemQuantities();
                    });
                }
                
                // Listen for destination warehouse changes from the hidden input
                const destWarehouseInput = document.querySelector('input[name="destinationWarehouse"]');
                if (destWarehouseInput) {
                    destWarehouseInput.addEventListener('change', (e) => {
                        // Save to localStorage
                        const sourceInput = document.querySelector('input[name="sourceWarehouse"]');
                        const sourceVal = sourceInput ? sourceInput.value : '';
                        const destVal = destWarehouseInput.value;
                        this.savePresetWarehouses(sourceVal, destVal);
                        
                        // Get the value from the event detail (passed by searchable-select component)
                        if (e.detail && e.detail.value) {
                            this.updateDestinationWarehouseNameWithValue(e.detail.value, e.detail.label);
                        } else {
                            // Fallback to reading from the hidden input
                            this.updateDestinationWarehouseName();
                        }
                    });
                }
                
                // Touch events for swipe navigation
                const itemsGrid = document.getElementById('itemsGrid');
                itemsGrid.addEventListener('touchstart', (e) => this.handleTouchStart(e), false);
                itemsGrid.addEventListener('touchend', (e) => this.handleTouchEnd(e), false);
                
                // Wheel events for scroll navigation
                itemsGrid.addEventListener('wheel', (e) => this.handleWheel(e), false);
                
                // Account settings button
                const accountSettingsBtn = document.getElementById('accountSettingsBtn');
                if (accountSettingsBtn) {
                    accountSettingsBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.openAccountSettingsModal();
                    });
                }
                
                // Modal buttons
                const saveAccountSettingsBtn = document.getElementById('saveAccountSettingsBtn');
                if (saveAccountSettingsBtn) {
                    saveAccountSettingsBtn.addEventListener('click', () => {
                        let debitAcc = '';
                        let creditAcc = '';
                        
                        // Get the relevant account based on flow type
                        if (this.flow === 'create') {
                            const modalCreditInput = document.querySelector('input[name="modalCreditAcc"]');
                            creditAcc = modalCreditInput ? modalCreditInput.value : '';
                            
                            if (!creditAcc) {
                                this.showAlert('{{ trans("general.select") }} {{ trans_choice("general.credit_accounts", 1) }}', 'warning');
                                return;
                            }
                        } else {
                            const modalDebitInput = document.querySelector('input[name="modalDebitAcc"]');
                            debitAcc = modalDebitInput ? modalDebitInput.value : '';
                            
                            if (!debitAcc) {
                                this.showAlert('{{ trans("general.select") }} {{ trans_choice("general.debit_accounts", 1) }}', 'warning');
                                return;
                            }
                        }
                        
                        this.updateAccountSelections(debitAcc, creditAcc);
                        this.savePresetAccounts(debitAcc, creditAcc);
                        const modal = document.getElementById('accountSettingsModal');
                        this.closeAccountModal(modal);
                    });
                }
                
                const cancelAccountSettingsBtn = document.getElementById('cancelAccountSettingsBtn');
                if (cancelAccountSettingsBtn) {
                    cancelAccountSettingsBtn.addEventListener('click', () => {
                        const modal = document.getElementById('accountSettingsModal');
                        this.closeAccountModal(modal);
                    });
                }
                
                const closeAccountModalBtn = document.getElementById('closeAccountModalBtn');
                if (closeAccountModalBtn) {
                    closeAccountModalBtn.addEventListener('click', () => {
                        const modal = document.getElementById('accountSettingsModal');
                        this.closeAccountModal(modal);
                    });
                }
                
                // Close on overlay click
                const modal = document.getElementById('accountSettingsModal');
                if (modal) {
                    modal.addEventListener('click', (e) => {
                        if (e.target === modal) {
                            this.closeAccountModal(modal);
                        }
                    });
                }
                
                // Initialize items pagination
                this.updateItemsVisibility();
                
                // Load preset warehouses after all listeners and UI components are ready
                this.loadPresetWarehouses();
            },

            loadPresetAccounts() {
                const storageKey = 'potFlowAccounts_' + this.flow;
                const saved = localStorage.getItem(storageKey);
                
                if (saved) {
                    try {
                        const { debitAcc, creditAcc } = JSON.parse(saved);
                        this.updateAccountSelections(debitAcc || '', creditAcc || '');
                    } catch (e) {
                        console.error('Error loading preset accounts:', e);
                    }
                }
            },

            savePresetAccounts(debitAccId, creditAccId) {
                const storageKey = 'potFlowAccounts_' + this.flow;
                localStorage.setItem(storageKey, JSON.stringify({
                    debitAcc: debitAccId,
                    creditAcc: creditAccId
                }));
            },

            loadPresetWarehouses() {
                const storageKey = 'potFlowWarehouses_' + this.flow;
                const saved = localStorage.getItem(storageKey);
                const self = this;
                
                if (saved) {
                    try {
                        const { sourceWarehouse, destinationWarehouse } = JSON.parse(saved);
                        
                        if (sourceWarehouse) {
                            const sourceInput = document.querySelector('input[name="sourceWarehouse"]');
                            if (sourceInput) {
                                sourceInput.value = sourceWarehouse;
                                // Defer updateItemQuantities to allow searchable-select component to fully initialize
                                setTimeout(() => {
                                    self.updateItemQuantities();
                                }, 500);
                            }
                        }
                        
                        if (destinationWarehouse) {
                            const destInput = document.querySelector('input[name="destinationWarehouse"]');
                            if (destInput) {
                                destInput.value = destinationWarehouse;
                                destInput.dispatchEvent(new Event('change', { bubbles: true }));
                            }
                        }
                    } catch (e) {
                        console.error('Error loading preset warehouses:', e);
                    }
                }
            },

            savePresetWarehouses(sourceWarehouseId, destinationWarehouseId) {
                const storageKey = 'potFlowWarehouses_' + this.flow;
                localStorage.setItem(storageKey, JSON.stringify({
                    sourceWarehouse: sourceWarehouseId,
                    destinationWarehouse: destinationWarehouseId
                }));
            },

            openAccountSettingsModal() {
                // Pre-populate modal selects with current values based on flow type
                if (this.flow === 'create') {
                    const creditAccId = document.getElementById('creditAcc').value;
                    if (creditAccId) {
                        const modalCreditInput = document.querySelector('input[name="modalCreditAcc"]');
                        if (modalCreditInput) {
                            modalCreditInput.value = creditAccId;
                        }
                    }
                } else {
                    const debitAccId = document.getElementById('debitAcc').value;
                    if (debitAccId) {
                        const modalDebitInput = document.querySelector('input[name="modalDebitAcc"]');
                        if (modalDebitInput) {
                            modalDebitInput.value = debitAccId;
                        }
                    }
                }
                
                // Show modal
                const modal = document.getElementById('accountSettingsModal');
                modal.classList.add('show');
            },

            closeAccountModal(modal) {
                modal.classList.remove('show');
            },

            updateAccountSelections(debitAccId, creditAccId) {
                const accountsData = @json(collect($accounts)->map(fn($name, $id) => ['id' => $id, 'label' => $name])->values());
                
                // Update hidden inputs (only if they exist for the current flow)
                const debitAccInput = document.getElementById('debitAcc');
                const creditAccInput = document.getElementById('creditAcc');
                
                if (debitAccInput) {
                    debitAccInput.value = debitAccId;
                }
                if (creditAccInput) {
                    creditAccInput.value = creditAccId;
                }
                
                // Update display text based on flow type
                if (this.flow === 'create') {
                    const creditDisplay = document.getElementById('creditAccDisplay');
                    if (creditDisplay) {
                        if (creditAccId) {
                            const creditAccLabel = accountsData.find(a => a.id == creditAccId)?.label || '';
                            creditDisplay.innerHTML = `<span class="pot-account-text">${creditAccLabel}</span>`;
                            creditDisplay.classList.add('selected');
                        } else {
                            creditDisplay.innerHTML = `<span class="pot-account-text">{{ trans('general.not_selected') }}</span>`;
                            creditDisplay.classList.remove('selected');
                        }
                        this.updateAccountMarquee(creditDisplay);
                    }
                } else {
                    const debitDisplay = document.getElementById('debitAccDisplay');
                    if (debitDisplay) {
                        if (debitAccId) {
                            const debitAccLabel = accountsData.find(a => a.id == debitAccId)?.label || '';
                            debitDisplay.innerHTML = `<span class="pot-account-text">${debitAccLabel}</span>`;
                            debitDisplay.classList.add('selected');
                        } else {
                            debitDisplay.innerHTML = `<span class="pot-account-text">{{ trans('general.not_selected') }}</span>`;
                            debitDisplay.classList.remove('selected');
                        }
                        this.updateAccountMarquee(debitDisplay);
                    }
                }
            },

            updateAccountMarquee(displayElement) {
                const textSpan = displayElement.querySelector('.pot-account-text');
                if (!textSpan) return;
                
                // Check if text is overflowing
                const isOverflowing = textSpan.scrollWidth > displayElement.offsetWidth;
                
                if (isOverflowing) {
                    textSpan.classList.add('is-overflowing');
                    // Calculate scroll distance: scroll until 10px gap from right edge
                    const scrollDistance = textSpan.scrollWidth - (displayElement.offsetWidth - 10);
                    const scrollTime = (scrollDistance / 50) * 1000; // Time to scroll in milliseconds
                    const pauseTime = 3000; // 3 second pause after scrolling
                    const totalDuration = scrollTime + pauseTime;
                    const scrollPercent = (scrollTime / totalDuration) * 100;
                    
                    textSpan.style.setProperty('--scroll-distance', scrollDistance + 'px');
                    textSpan.style.setProperty('--scroll-percent', scrollPercent);
                    textSpan.style.animationDuration = totalDuration + 'ms';
                } else {
                    textSpan.classList.remove('is-overflowing');
                }
            },

            addToCart(card) {
                const itemId = parseInt(card.dataset.itemId);
                const itemName = card.dataset.itemName;
                const itemCode = card.dataset.itemCode;
                const itemPrice = parseFloat(card.dataset.itemPrice);
                const expenseAccountId = card.dataset.expenseAccountId || null;

                const existingIndex = this.cart.findIndex(item => item.id === itemId);

                if (existingIndex !== -1) {
                    // Item exists: remove it from current position
                    const [existingItem] = this.cart.splice(existingIndex, 1);
                    // Increment quantity
                    existingItem.quantity++;
                    // Add it to the front
                    this.cart.unshift(existingItem);
                } else {
                    // New item: add to the beginning of cart
                    this.cart.unshift({
                        id: itemId,
                        name: itemName,
                        code: itemCode,
                        price: itemPrice,
                        expense_account_id: expenseAccountId,
                        quantity: 1
                    });
                    this.selectedItemIds.add(itemId);
                }
                
                // Always display the newly tapped item
                this.currentCartIndex = 0;

                this.updateCart();
                this.updateItemSelection();
            },

            updateCart() {
                const cartContainer = document.getElementById('cartItems');
                const itemCountEl = document.getElementById('itemCount');
                const navUpBtn = document.getElementById('cartNavUp');
                const navDownBtn = document.getElementById('cartNavDown');

                if (this.cart.length === 0) {
                    cartContainer.innerHTML = '<p class="pot-empty-cart">No items added yet</p>';
                    itemCountEl.textContent = '0';
                    document.getElementById('submitTransfer').disabled = true;
                    navUpBtn.disabled = true;
                    navDownBtn.disabled = true;
                    this.currentCartIndex = 0;
                } else {
                    // Ensure currentCartIndex is valid
                    if (this.currentCartIndex >= this.cart.length) {
                        this.currentCartIndex = this.cart.length - 1;
                    }
                    
                    const item = this.cart[this.currentCartIndex];
                    itemCountEl.textContent = this.cart.length;
                    
                    // Display only the current item
                    cartContainer.innerHTML = `
                        <div class="pot-cart-item">
                            <div class="pot-cart-item-header">
                                <div>
                                    <div class="pot-cart-item-name">${item.name}</div>
                                    <div class="pot-cart-item-code">${item.code}</div>
                                </div>
                                <button class="pot-btn-remove" onclick="potApp.removeFromCart(${this.currentCartIndex})" title="Remove">
                                    <i class="material-icons">close</i>
                                </button>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; align-items: center;">
                                <div class="pot-qty-control">
                                    <button class="pot-qty-btn" onclick="potApp.decreaseQuantity(${this.currentCartIndex})">−</button>
                                    <input type="number" class="pot-cart-item-qty-input" value="${item.quantity}" min="0" step="0.1" onchange="potApp.updateQuantity(${this.currentCartIndex}, this.value)">
                                    <button class="pot-qty-btn" onclick="potApp.increaseQuantity(${this.currentCartIndex})">+</button>
                                </div>
                                <div style="text-align: right; font-size: 12px; color: #3b4f69; font-weight: 600;">
                                    ${this.currency}${(item.price * item.quantity).toFixed(2)}
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Update navigation button states
                    navUpBtn.disabled = this.currentCartIndex === 0;
                    navDownBtn.disabled = this.currentCartIndex === this.cart.length - 1;
                    
                    document.getElementById('submitTransfer').disabled = false;
                }

                this.updateTotals();
            },

            navigateCart(direction) {
                this.currentCartIndex += direction;
                if (this.currentCartIndex < 0) this.currentCartIndex = 0;
                if (this.currentCartIndex >= this.cart.length) this.currentCartIndex = this.cart.length - 1;
                this.updateCart();
            },

            removeFromCart(index) {
                const itemId = this.cart[index].id;
                this.cart.splice(index, 1);
                this.selectedItemIds.delete(itemId);
                
                // Adjust currentCartIndex after removal
                if (this.currentCartIndex >= this.cart.length && this.cart.length > 0) {
                    this.currentCartIndex = this.cart.length - 1;
                } else if (this.cart.length === 0) {
                    this.currentCartIndex = 0;
                }
                
                this.updateCart();
                this.updateItemSelection();
            },

            increaseQuantity(index) {
                this.cart[index].quantity = parseFloat((this.cart[index].quantity + 0.1).toFixed(2));
                this.updateCart();
            },

            decreaseQuantity(index) {
                if (this.cart[index].quantity > 0.1) {
                    this.cart[index].quantity = parseFloat((this.cart[index].quantity - 0.1).toFixed(2));
                    this.updateCart();
                }
            },

            updateQuantity(index, value) {
                const qty = parseFloat(value) || 0;
                if (qty > 0) {
                    this.cart[index].quantity = qty;
                    this.updateTotals();
                }
            },

            updateTotals() {
                const totalItems = this.cart.length;
                const totalQty = this.cart.reduce((sum, item) => sum + item.quantity, 0);
                const totalValue = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

                document.getElementById('totalItems').textContent = totalItems;
                document.getElementById('totalQty').textContent = totalQty;
                document.getElementById('totalValue').textContent = `${this.currency}${totalValue.toFixed(2)}`;
            },

            clearCart() {
                if (confirm('Clear all items from cart?')) {
                    this.cart = [];
                    this.selectedItemIds.clear();
                    this.updateCart();
                    this.updateItemSelection();
                }
            },

            removeItemFromSelection(event) {
                event.stopPropagation();
                const card = event.currentTarget.closest('.pot-item-card');
                const itemId = parseInt(card.dataset.itemId);
                
                // Find and remove from cart
                const cartIndex = this.cart.findIndex(item => item.id === itemId);
                if (cartIndex !== -1) {
                    this.removeFromCart(cartIndex);
                }
            },

            updateItemSelection() {
                document.querySelectorAll('.pot-item-card').forEach(card => {
                    const itemId = parseInt(card.dataset.itemId);
                    const removeBtn = card.querySelector('.pot-item-remove-btn');
                    
                    if (this.selectedItemIds.has(itemId)) {
                        card.classList.add('selected');
                        if (removeBtn) removeBtn.style.display = 'flex';
                    } else {
                        card.classList.remove('selected');
                        if (removeBtn) removeBtn.style.display = 'none';
                    }
                });
                // Update selected items count
                document.getElementById('selectedItemsCount').textContent = this.selectedItemIds.size;
            },

            handleTouchStart(e) {
                this.touchStartX = e.changedTouches[0].screenX;
                this.touchStartY = e.changedTouches[0].screenY;
            },

            handleTouchEnd(e) {
                const touchEndX = e.changedTouches[0].screenX;
                const touchEndY = e.changedTouches[0].screenY;
                const diffX = this.touchStartX - touchEndX;
                const diffY = this.touchStartY - touchEndY;
                const threshold = 50;

                // Swipe left or up = next page
                if ((diffX > threshold || diffY > threshold) && (diffX > Math.abs(diffY) || diffY > Math.abs(diffX))) {
                    if (diffX > threshold) this.navigateItemsPage(1); // Swipe left
                    else if (diffY > threshold) this.navigateItemsPage(1); // Swipe up
                }
                // Swipe right or down = previous page
                else if ((diffX < -threshold || diffY < -threshold) && (Math.abs(diffX) > Math.abs(diffY) || Math.abs(diffY) > Math.abs(diffX))) {
                    if (diffX < -threshold) this.navigateItemsPage(-1); // Swipe right
                    else if (diffY < -threshold) this.navigateItemsPage(-1); // Swipe down
                }
            },

            handleWheel(e) {
                e.preventDefault();
                if (e.deltaY > 0 || e.deltaX > 0) {
                    this.navigateItemsPage(1); // Scroll down/right = next page
                } else if (e.deltaY < 0 || e.deltaX < 0) {
                    this.navigateItemsPage(-1); // Scroll up/left = previous page
                }
            },

            updateItemQuantities() {
                const sourceWarehouseInput = document.querySelector('input[name="sourceWarehouse"]');
                const warehouseId = sourceWarehouseInput ? sourceWarehouseInput.value : '';
                const warehouseOverlay = document.getElementById('warehouseOverlay');
                const self = this;
                
                if (!warehouseId) {
                    // Show overlay and disable all items if no warehouse selected
                    if (warehouseOverlay) warehouseOverlay.style.display = 'flex';
                    document.querySelectorAll('.pot-item-card').forEach(card => {
                        card.classList.add('pot-item-disabled');
                        card.style.pointerEvents = 'none';
                        card.style.opacity = '0.5';
                        const qtySpan = card.querySelector('.pot-item-qty');
                        if (qtySpan) {
                            qtySpan.textContent = 'Qty: 0';
                        }
                    });
                    return;
                }

                // Hide the overlay now that a warehouse is selected
                if (warehouseOverlay) warehouseOverlay.style.display = 'none';

                // Clear cart when warehouse changes
                self.cart = [];
                self.selectedItemIds.clear();
                self.updateCart();
                self.updateItemSelection();

                // Fetch inventory for all items in the selected warehouse
                fetch(`{{ route('inventory.pot.get-warehouse-items') }}?warehouse_id=${warehouseId}`)
                    .then(response => response.json())
                    .then(warehouseItems => {
                        // Create maps for quick lookup
                        const itemQuantityMap = {};
                        const itemExpenseAccountMap = {};
                        warehouseItems.forEach(item => {
                            itemQuantityMap[item.id] = item.quantity;
                            itemExpenseAccountMap[item.id] = item.expense_account_id;
                        });

                        // Update all item cards with warehouse quantities and expense accounts
                        document.querySelectorAll('.pot-item-card').forEach(card => {
                            const itemId = parseInt(card.dataset.itemId);
                            const quantity = itemQuantityMap[itemId];
                            const expenseAccountId = itemExpenseAccountMap[itemId];
                            
                            // Store expense account ID in card dataset
                            if (expenseAccountId) {
                                card.dataset.expenseAccountId = expenseAccountId;
                            }
                            
                            // Update quantity display
                            const qtySpan = card.querySelector('.pot-item-qty');
                            if (qtySpan) {
                                qtySpan.textContent = `Qty: ${quantity !== undefined ? quantity : 0}`;
                            }
                            
                            // Disable card if quantity is not available or 0
                            if (quantity === undefined || quantity === 0 || quantity <= 0) {
                                card.classList.add('pot-item-disabled');
                                card.style.pointerEvents = 'none';
                                card.style.opacity = '0.5';
                            } else {
                                card.classList.remove('pot-item-disabled');
                                card.style.pointerEvents = 'auto';
                                card.style.opacity = '1';
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching warehouse items:', error);
                        // On error, show all items as available
                        document.querySelectorAll('.pot-item-card').forEach(card => {
                            card.classList.remove('pot-item-disabled');
                            card.style.pointerEvents = 'auto';
                            card.style.opacity = '1';
                        });
                    });
            },

            filterItems() {
                // Get warehouse value from the hidden input created by searchable-select component
                const warehouseInput = document.querySelector('input[name="sourceWarehouse"]');
                const warehouse = warehouseInput ? warehouseInput.value : '';
                const search = document.getElementById('itemSearch').value.toLowerCase();
                const cards = document.querySelectorAll('.pot-item-card');
                
                let filteredCount = 0;
                cards.forEach(card => {
                    const name = card.dataset.itemName.toLowerCase();
                    const code = card.dataset.itemCode.toLowerCase();
                    
                    const matchesSearch = !search || name.includes(search) || code.includes(search);
                    const matchesWarehouse = !warehouse || true; // Filter by warehouse if needed
                    
                    const isVisible = matchesSearch && matchesWarehouse;
                    card.setAttribute('data-filtered', isVisible ? '0' : '1');
                    if (isVisible) filteredCount++;
                });
                
                // Store the count of items passing search filter
                this.visibleItemsCount = filteredCount;
                
                // Reset to first page after filtering
                this.currentItemsPage = 0;
                this.updateItemsVisibility();
            },

            navigateItemsPage(direction) {
                const totalPages = Math.max(1, Math.ceil(this.visibleItemsCount / this.itemsPerPage));
                this.currentItemsPage += direction;
                if (this.currentItemsPage < 0) this.currentItemsPage = 0;
                if (this.currentItemsPage >= totalPages) this.currentItemsPage = totalPages - 1;
                this.updateItemsVisibility();
            },

            updateItemsVisibility() {
                const cards = document.querySelectorAll('.pot-item-card');
                const start = this.currentItemsPage * this.itemsPerPage;
                const end = start + this.itemsPerPage;
                
                // Apply pagination: show/hide based on current page and filter status
                let visibleIndex = 0;
                cards.forEach((card) => {
                    const isFiltered = card.getAttribute('data-filtered') === '1';
                    
                    // If filtered out by search, keep it hidden
                    if (isFiltered) {
                        card.style.display = 'none';
                        return;
                    }
                    
                    // Otherwise, show if within current page range
                    if (visibleIndex >= start && visibleIndex < end) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                    visibleIndex++;
                });
                
                // Update button states
                const totalPages = Math.max(1, Math.ceil(this.visibleItemsCount / this.itemsPerPage));
                const navUpBtn = document.getElementById('itemsNavUp');
                const navDownBtn = document.getElementById('itemsNavDown');
                
                if (navUpBtn && navDownBtn) {
                    navUpBtn.disabled = this.currentItemsPage === 0;
                    navDownBtn.disabled = this.currentItemsPage >= totalPages - 1;
                }
            },

            showAlert(message, type = 'success', duration = 5000) {
                const container = document.getElementById('alertContainer');
                const alertClasses = {
                    'success': 'alert-success',
                    'error': 'alert-error',
                    'danger': 'alert-error',
                    'warning': 'alert-warning',
                    'info': 'alert-info'
                };

                const alertEl = document.createElement('div');
                alertEl.className = `alert ${alertClasses[type] || 'alert-success'}`;
                alertEl.innerHTML = `
                    <span>${message}</span>
                    <span class="alert-close" onclick="this.parentElement.remove();">&times;</span>
                `;

                container.appendChild(alertEl);

                if (duration > 0) {
                    let timeoutId;
                    
                    // Function to start the auto-close timer
                    const startTimer = () => {
                        timeoutId = setTimeout(() => {
                            if (alertEl.parentElement) {
                                alertEl.remove();
                            }
                        }, duration);
                    };
                    
                    // Function to clear the timer
                    const clearTimer = () => {
                        if (timeoutId) {
                            clearTimeout(timeoutId);
                        }
                    };
                    
                    // Add hover event listeners
                    alertEl.addEventListener('mouseenter', () => {
                        clearTimer();
                    });
                    
                    alertEl.addEventListener('mouseleave', () => {
                        startTimer();
                    });
                    
                    // Start the initial timer
                    startTimer();
                }

                return alertEl;
            },

            clearForm() {
                // Clear cart and selections
                this.cart = [];
                this.selectedItemIds.clear();
                
                // Clear form fields (accounts, dates, etc) but preserve warehouse selections
                const form = document.getElementById('transferOrderForm');
                const inputs = form.querySelectorAll('input:not([name="sourceWarehouse"]):not([name="destinationWarehouse"])');
                inputs.forEach(input => {
                    if (input.type === 'hidden' || input.type === 'date') {
                        input.value = '';
                    }
                });
                
                // Update UI for empty cart
                this.updateCart();
                this.updateItemSelection();
                
                // Refresh item quantities from the warehouse to show updated stock after transfer
                this.updateItemQuantities();
            },

            submitTransfer() {
                console.log('submitTransfer() called for flow:', this.flow);
                const self = this; // Preserve context for Promise handlers
                
                if (this.cart.length === 0) {
                    this.showAlert('Add items to transfer', 'warning');
                    return;
                }

                // Get form values - with error handling
                let debitAcc, creditAcc, sourceWarehouse, destinationWarehouse, transferDate;
                
                try {
                    const debitAccInput = document.querySelector('input[name="debitAcc"]');
                    const creditAccInput = document.querySelector('input[name="creditAcc"]');
                    const sourceWareInput = document.querySelector('input[name="sourceWarehouse"]');
                    const destWareInput = document.querySelector('input[name="destinationWarehouse"]');
                    
                    debitAcc = debitAccInput ? debitAccInput.value : '';
                    creditAcc = creditAccInput ? creditAccInput.value : '';
                    sourceWarehouse = sourceWareInput ? sourceWareInput.value : '';
                    destinationWarehouse = destWareInput ? destWareInput.value : '';
                    
                    // Remove 'null' string if present (from searchable-select initial value)
                    if (debitAcc === 'null') debitAcc = '';
                    if (creditAcc === 'null') creditAcc = '';
                    if (sourceWarehouse === 'null') sourceWarehouse = '';
                    if (destinationWarehouse === 'null') destinationWarehouse = '';
                    
                    console.log('Form values (cleaned):', { debitAcc, creditAcc, sourceWarehouse, destinationWarehouse, flow: this.flow });
                    
                    transferDate = document.getElementById('transferDate').value;
                } catch (e) {
                    console.error('Error reading form values:', e);
                    this.showAlert('Error reading form data', 'error');
                    return;
                }

                // Validate required fields based on flow type
                if (this.flow === 'create') {
                    // Create flow: requires credit account
                    if (!creditAcc || creditAcc.trim() === '') {
                        console.warn('Credit account not selected for create flow');
                        this.showAlert('Please set the Credit Account in Settings', 'error');
                        return;
                    }
                } else if (this.flow === 'return') {
                    // Return flow: requires debit account
                    if (!debitAcc || debitAcc.trim() === '') {
                        console.warn('Debit account not selected for return flow');
                        this.showAlert('Please set the Debit Account in Settings', 'error');
                        return;
                    }
                }

                // Validate common required fields
                if (!sourceWarehouse || sourceWarehouse.trim() === '') {
                    console.warn('Source warehouse not selected');
                    this.showAlert('Please select a Source Warehouse', 'error');
                    return;
                }
                if (!destinationWarehouse || destinationWarehouse.trim() === '') {
                    console.warn('Destination warehouse not selected');
                    this.showAlert('Please select a Destination Warehouse', 'error');
                    return;
                }
                if (sourceWarehouse === destinationWarehouse) {
                    console.warn('Source and destination warehouses are the same');
                    this.showAlert('Source and Destination warehouses cannot be the same', 'error');
                    return;
                }

                console.log('All validations passed for ' + this.flow + ' flow, proceeding with submission');

                // Show preloader
                const preloader = document.getElementById('potPreloader');
                if (preloader) {
                    preloader.style.display = 'flex';
                }

                // Calculate total transfer amount
                const totalAmount = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

                // Prepare form data using FormData for multipart submission
                const formData = new FormData(document.getElementById('transferOrderForm'));
                
                // Add transfer data
                formData.append('date', transferDate);
                formData.append('debit_account_id', debitAcc);
                formData.append('credit_account_id', creditAcc);
                formData.append('source_warehouse_id', sourceWarehouse);
                formData.append('destination_warehouse_id', destinationWarehouse);
                formData.append('total_amount', totalAmount);
                formData.append('flow_type', this.flow);

                // Add items as JSON in a single field
                formData.append('items_json', JSON.stringify(this.cart.map(item => ({
                    item_id: item.id,
                    item_quantity: item.quantity,
                    transfer_quantity: item.quantity,
                    item_name: item.name,
                    item_code: item.code,
                    item_price: item.price,
                    expense_account_id: item.expense_account_id
                }))));

                console.log('Submitting transfer order for flow:', this.flow);

                // Helper function to hide preloader
                const hidePreloader = () => {
                    if (preloader) {
                        preloader.style.display = 'none';
                    }
                };

                // Submit via Axios if available, otherwise fallback to fetch
                if (typeof axios !== 'undefined') {
                    // Create axios config with proper headers for FormData
                    const config = {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                            // Don't set Content-Type - let the browser set it with the boundary
                        }
                    };
                    
                    axios.post('{{ route("inventory.pot.store") }}', formData, config)
                    .then(response => {
                        console.log('Response received:', response);
                        if (response.data.success) {
                            const transferOrderNumber = response.data.transfer_order_number || 'N/A';
                            const journalEntryNumber = response.data.journal_entry_number || 'N/A';
                            const successMessage = `<strong>Success:</strong><br>Transfer Order <span style="font-weight: 700; font-size: 0.875rem; color: #059669;">${transferOrderNumber}</span> Created!<br>Journal Entry <span style="font-weight: 700; font-size: 0.875rem; color: #059669;">${journalEntryNumber}</span> Added!`;
                            self.showAlert(successMessage, 'success', 15000);
                            self.clearForm();
                        } else {
                            // Show validation errors if available
                            if (response.data.errors) {
                                console.error('Validation errors:', response.data.errors);
                                let errorMessages = [];
                                for (const field in response.data.errors) {
                                    errorMessages.push(`<strong>${field}:</strong> ${response.data.errors[field].join(', ')}`);
                                }
                                self.showAlert(errorMessages.join('<br>'), 'error', 5000);
                            } else {
                                self.showAlert('Error: ' + (response.data.message || 'Failed to create transfer order'), 'error');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Axios Error:', error);
                        if (error.response?.data?.errors) {
                            console.error('Validation errors:', error.response.data.errors);
                            let errorMessages = [];
                            for (const field in error.response.data.errors) {
                                errorMessages.push(`<strong>${field}:</strong> ${error.response.data.errors[field].join(', ')}`);
                            }
                            self.showAlert(errorMessages.join('<br>'), 'error', 5000);
                        } else if (error.response?.data?.message) {
                            self.showAlert('Error: ' + error.response.data.message, 'error');
                        } else {
                            const message = error.message || 'Error submitting transfer order';
                            console.error('Error message:', message);
                            self.showAlert('Error: ' + message, 'error');
                        }
                    })
                    .finally(() => {
                        hidePreloader();
                    });
                } else {
                    // Fallback to fetch
                    fetch('{{ route("inventory.pot.store") }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        console.log('Fetch response status:', response.status);
                        if (!response.ok && response.status !== 422) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Fetch response data:', data);
                        if (data.success) {
                            const transferOrderNumber = data.transfer_order_number || 'N/A';
                            const journalEntryNumber = data.journal_entry_number || 'N/A';
                            const successMessage = `<strong>Success:</strong><br>Transfer Order <span style="font-weight: 700; font-size: 0.875rem; color: #059669;">${transferOrderNumber}</span> Created!<br>Journal Entry <span style="font-weight: 700; font-size: 0.875rem; color: #059669;">${journalEntryNumber}</span> Added!`;
                            self.showAlert(successMessage, 'success', 15000);
                            self.clearForm();
                        } else {
                            // Show validation errors if available
                            if (data.errors) {
                                console.error('Validation errors:', data.errors);
                                let errorMessages = [];
                                for (const field in data.errors) {
                                    errorMessages.push(`<strong>${field}:</strong> ${data.errors[field].join(', ')}`);
                                }
                                self.showAlert(errorMessages.join('<br>'), 'error', 5000);
                            } else {
                                self.showAlert('Error: ' + (data.message || 'Failed to create transfer order'), 'error');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        self.showAlert('Error submitting transfer order: ' + error.message, 'error');
                    })
                    .finally(() => {
                        hidePreloader();
                    });
                }
            },

            updateDestinationWarehouseNameWithValue(warehouseId, warehouseLabel) {
                // Use the value passed from the event to avoid timing issues
                if (warehouseId && warehouseLabel) {
                    document.getElementById('destinationWarehouseName').textContent = warehouseLabel;
                } else {
                    document.getElementById('destinationWarehouseName').textContent = 'Select warehouse';
                }
            },

            updateDestinationWarehouseName() {
                // Get the destination warehouse value from the hidden input
                const destWarehouseInput = document.querySelector('input[name="destinationWarehouse"]');
                const destWarehouseId = destWarehouseInput ? destWarehouseInput.value : '';
                
                if (destWarehouseId) {
                    // Find the warehouse name from the select component's options
                    const destContainer = document.querySelector('[data-name="destinationWarehouse"]');
                    if (destContainer) {
                        const options = JSON.parse(destContainer.dataset.options || '[]');
                        const selected = options.find(opt => opt.id == destWarehouseId);
                        if (selected) {
                            document.getElementById('destinationWarehouseName').textContent = selected.label;
                        }
                    }
                } else {
                    document.getElementById('destinationWarehouseName').textContent = 'Select warehouse';
                }
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            potApp.init();
        });
    </script>
    @endpush
</x-layouts.admin>
