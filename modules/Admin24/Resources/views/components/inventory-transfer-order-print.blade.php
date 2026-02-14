<x-layouts.print>
    <x-slot name="title">
        {{ trans_choice('inventory::general.transfer_orders', 1) . ': ' . $transfer_order->transfer_order_number }}
    </x-slot>

    <x-slot name="content">   
        <div class="w-full lg:w-7/12">
            <div class="p-7 shadow-2xl rounded-2xl">
                {{-- company information--}}
                <table class="border-bottom-1">
                    <tr>
                        <td style="width:20%; padding: 0 0 15px 0;" valign="top">
                            <img src="{{ company()->logo }}" height="70" width="70" alt="{{ setting('company.name') }}" />
                        </td>
                
                        <td class="text" style="width: 80%; padding: 0 0 15px 0;">
                            <h2 class="text-semibold text">
                                {{ setting('company.name') }}
                            </h2>
            
                            <p>{!! (setting('company.address')) !!}</p>
            
                            @if (setting('company.tax_number'))
                                <p>
                                    {{ trans('general.tax_number') }}: {{ setting('company.tax_number') }}
                                </p>
                            @endif
            
                            @if (setting('company.phone'))
                                <p>
                                    {{ setting('company.phone') }}
                                </p>
                            @endif
            
                            <p>{{ setting('company.email') }}</p>
                        </td>
                    </tr>
                </table>

                {{-- title information --}}
                <table>
                    <tr>
                        <td style="width: 60%; padding: 15px 0 15px 0;">
                            <h2 style="font-size: 12px; font-weight:600;">
                                {{ trans('inventory::general.information') }}
                            </h2>
                        </td>
                    </tr>
                </table>
                
                <table>
                    <tr>
                        <td valign="top" style="width: 30%; margin: 0px; padding: 8px 4px 0 0; font-size: 12px; font-weight:600;">
                            {{ trans('inventory::transferorders.source_warehouse') }}:
                        </td>
            
                        <td valign="top" class="border-bottom-dashed-black" style="width:70%; margin: 0px; padding:  8px 0 0 0; font-size: 12px;">
                            {{ $transfer_order->source_warehouse->name }}
                        </td>
                    </tr>
            
                    <tr>
                        <td valign="top" style="width: 30%; margin: 0px; padding: 8px 4px 0 0; font-size: 12px; font-weight:600;">
                            {{ trans('inventory::transferorders.destination_warehouse') }}:
                        </td>
            
                        <td valign="top" class="border-bottom-dashed-black" style="width:70%; margin: 0px; padding:  8px 0 0 0; font-size: 12px;">
                            {{ $transfer_order->destination_warehouse->name }}
                        </td>
                    </tr>
            
                    <tr>
                        <td valign="top" style="width: 30%; margin: 0px; padding: 8px 4px 0 0; font-size: 12px; font-weight:600;">
                            {{ trans('inventory::transferorders.name') }}:
                        </td>
            
                        <td valign="top" class="border-bottom-dashed-black" style="width:70%; margin: 0px; padding:  8px 0 0 0; font-size: 12px;">
                            {{ $transfer_order->transfer_order }}
                        </td>
                    </tr>
            
                    <tr>
                        <td valign="top" style="width: 30%; margin: 0px; padding: 8px 4px 0 0; font-size: 12px; font-weight:600;">
                            {{ trans('inventory::transferorders.number') }}:
                        </td>
            
                        <td valign="top" class="border-bottom-dashed-black" style="width:70%; margin: 0px; padding:  8px 0 0 0; font-size: 12px;">
                            {{ $transfer_order->transfer_order_number }}
                        </td>
                    </tr>
            
                    <tr>
                        <td valign="top" style="width: 30%; margin: 0px; padding: 8px 4px 0 0; font-size: 12px; font-weight:600;">
                            {{ trans('inventory::transferorders.date') }}:
                        </td>
            
                        <td valign="top" class="border-bottom-dashed-black" style="width:70%; margin: 0px; padding:  8px 0 0 0; font-size: 12px;">
                            <x-date date="{{ $transfer_order->date }}" />
                        </td>
                    </tr>
                </table>
                
                <div class="row">
                    <div class="col-100">
                        <div class="text extra-spacing">
                            <table class="lines">
                                <thead style="background-color:#55588b !important; -webkit-print-color-adjust: exact;">
                                    <tr>
                                        <th class="text text-semibold text-left text-white" style="border-radius: 10px 0px 0px 10px; width: 40%;">
                                            {{ trans_choice('general.items', 2)}}
                                        </th>
        
                                        <th class="text text-semibold text-white text-center" style="border-radius: 0px;  width: 20%;">
                                            {{ trans('inventory::general.quantity')}}
                                        </th>

                                        <th class="text text-semibold text-white text-center" style="border-radius: 0px;  width: 20%;">
                                            {{ trans('admin24::general.unit_price')}}
                                        </th>

                                        <th class="text text-semibold text-white text-right" style="border-radius: 0px 10px 10px 0px;  width: 20%;">
                                            {{ trans('admin24::general.total')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($transfer_order->transfer_order_items->count())
                                        @foreach($transfer_order->transfer_order_items as $item)
                                            <tr>
                                                <td class="text">
                                                    {{ $item->item->name}} <br/>
                                                </td>
                                        
                                                <td class="text text-center">
                                                    {{ $item->transfer_quantity }}
                                                </td>

                                                <td class="text text-center">
                                                    {{ $item->sale_price }}
                                                </td>

                                                <td class="text text-right">
                                                    {{ $item->total_amt }}
                                                </td>
                                                </tr>
                                        @endforeach
                                            <tr colspan="2" style="border-bottom: 0px !important;">
                                                <td colspan="3" class="text text-semibold text-right text-lg">
                                                    {{ trans('admin24::general.total')}}
                                                </td>
                                                <td class="text text-semibold text-right text-lg">
                                                    {{ $transfer_order->total_transfer }}
                                                </td>
                                            </tr>
                                    @else
                                        <tr>
                                            <td colspan="5" class="text text-center empty-items">
                                                {{ trans('documents.empty_items') }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </x-slot>
</x-layout-print>