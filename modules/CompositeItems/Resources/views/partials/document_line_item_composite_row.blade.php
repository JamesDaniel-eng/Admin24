@foreach ($compositeItems as  $compositeItem)
<tr class="composite-item-row" style="background-color: #f8f9fa; height: 28px;">
    <td class="item text text-alignment-left text-left max-w-0" style="padding: 4px 0 4px 10px; line-height: 1.2;">
        <div class="small-text text-muted" style="display: flex; align-items: center; margin: 0;">
            @if (!$print)
            <span class="material-icons-outlined" style="font-size: 14px; color: #6c757d; margin-right: 6px;">subdirectory_arrow_right</span>
            @endif
            <span style="font-size: 0.85em;">
                @if($compositeItem->item)
                    {{ $compositeItem->item->name }}
                @else
                    {{ $compositeItem->name ?? 'Composite Item' }}
                @endif
            </span>
        </div>
        @if(!empty($compositeItem->description))
            <div class="small-text text-muted" style="font-size: 0.75em; margin-left: 20px; margin-top: 2px; line-height: 1.1;">
                {{ $compositeItem->description }}
            </div>
        @endif
    </td>

    @if (! $hideQuantity)
        <td class="quantity text text-alignment-right text-right" style="padding: 4px 8px; line-height: 1.2;">
            <span class="small-text text-muted" style="font-size: 0.85em;">{{ $compositeItem->quantity }}</span>
        </td>
    @endif

    @if (! $hidePrice)
        <td class="price text text-alignment-right text-right" style="padding: 4px 8px; line-height: 1.2;">
            <span class="small-text text-muted" style="font-size: 0.85em;">
                <x-money :amount="$compositeItem->price" :currency="$document->currency_code" />
            </span>
        </td>
    @endif

    @if (! $hideDiscount)
        @if (in_array(setting('localisation.discount_location', 'total'), ['item', 'both']))
            @if ($compositeItem->discount_type === 'percentage')
                <td class="discount text text-alignment-right text-right" style="padding: 4px 8px; line-height: 1.2;">
                    @php
                        $text_discount = '';

                        if (setting('localisation.percent_position') == 'before') {
                            $text_discount .= '%';
                        }

                        $text_discount .= $compositeItem->discount;

                        if (setting('localisation.percent_position') == 'after') {
                            $text_discount .= '%';
                        }
                    @endphp

                    <span class="small-text text-muted" style="font-size: 0.85em;">{{ $text_discount }}</span>
                </td>
            @else
                <td class="discount text text-alignment-right text-right" style="padding: 4px 8px; line-height: 1.2;">
                    <span class="small-text text-muted" style="font-size: 0.85em;">
                        <x-money :amount="$compositeItem->discount" :currency="$document->currency_code" />
                    </span>
                </td>
            @endif
        @endif
    @endif

    @if (! $hideAmount)
        <td class="total text text-alignment-right text-right" style="padding: 4px 8px; line-height: 1.2;">
            <span class="small-text text-muted" style="font-size: 0.85em;">
                <x-money :amount="$compositeItem->total" :currency="$document->currency_code" />
            </span>
        </td>
    @endif
</tr>
@endforeach


