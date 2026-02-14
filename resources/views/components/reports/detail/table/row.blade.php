<!-- if it HAS NOT subcategories -->
@if (is_null($node))
    @php
        $rows = $class->row_values[$table_key][$id];
        $account_id = $id;
        $is_account_row = isset($class->general_ledger_report) && is_numeric($account_id) && $class->general_ledger_report;
        // Extract account code if present (format: "CODE - Name")
        $row_name = $class->row_names[$table_key][$id];
        $code = '';
        $name = $row_name;
        if (strpos($row_name, ' - ') !== false) {
            [$code, $name] = explode(' - ', $row_name, 2);
        }
    @endphp

    @if ($row_total = array_sum($rows))
        @if (isset($parent_id))
            <tr class="collapse-sub collapse-sub-report" data-collapse="child-{{ $parent_id }}" data-truncate-marquee>
                <td class="{{ $class->column_name_width }} w-24 py-2 text-left text-black-400 text-sm" style="padding-left: {{ $tree_level * 20 }}px;" title="{{ $row_name }}">
                    @if ($is_account_row && empty($print))
                        <a href="{{ route('reports.show', [$class->general_ledger_report->id]) }}?search=de_account_id:{{ $account_id }}" class="w-full inline-flex items-center gap-4">
                            @if ($code)
                                <span class="w-8 account-code whitespace-nowrap text-right to-black-400 hover:bg-full-2 bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize">{{ $code }}</span>
                                <span class="account-name" data-truncate-marquee>{{ $name }}</span>
                            @else
                                <span>{{ $name }}</span>
                            @endif
                        </a>
                    @else
                        @if ($code)
                            <span class="w-8 account-code whitespace-nowrap text-right to-black-400 hover:bg-full-2 bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize">{{ $code }}</span>
                            <span class="account-name">{{ $name }}</span>
                        @else
                            {{ $name }}
                        @endif
                    @endif
                </td>
        @else
            <tr>
                <td class="{{ $class->column_name_width }} w-24 py-2 text-left text-black-400 text-sm" title="{{ $row_name }}">
                    @if ($is_account_row && empty($print))
                        <a href="{{ route('reports.show', [$class->general_ledger_report->id]) }}?search=de_account_id:{{ $account_id }}" class="w-full inline-flex items-center gap-8">
                            @if ($code)
                                <span class="w-8 account-code whitespace-nowrap text-right to-black-400 hover:bg-full-2 bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize">{{ $code }}</span>
                                <span class="account-name" data-truncate-marquee>{{ $name }}</span>
                            @else
                                <span>{{ $name }}</span>
                            @endif
                        </a>
                    @else
                        @if ($code)
                            <span class="w-8 account-code whitespace-nowrap text-right to-black-400 hover:bg-full-2 bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize">{{ $code }}</span>
                            <span class="account-name">{{ $name }}</span>
                        @else
                            {{ $name }}
                        @endif
                    @endif
                </td>
        @endif

        @foreach($rows as $row)
            <td class="{{ $class->column_value_width }} py-2 ltr:text-right rtl:text-left text-alignment-right text-black-400 text-xs">{{ $class->has_money ? money($row) : $row }}</td>
        @endforeach
        <td class="{{ $class->column_name_width }} py-2 ltr:text-right rtl:text-left text-alignment-right text-black-400 text-xs uppercase">{{ $class->has_money ? money($row_total) : $row }}</td>
    </tr>
    @endif
@endif

<!-- if it HAS subcategories -->
@if (is_array($node))
    <!-- parent part -->
    @php
        $parent_row_values = $class->row_values[$table_key][$id];
        $row_name = $class->row_names[$table_key][$id];
        $code = '';
        $name = $row_name;
        if (strpos($row_name, ' - ') !== false) {
            [$code, $name] = explode(' - ', $row_name, 2);
        }

        // Iterate only through direct children (not recursive) to avoid double-counting
        foreach ($node as $key => $value) {
            if ($key == $id) {
                continue;
            }

            if (isset($class->row_values[$table_key][$key])) {
                foreach ($class->row_values[$table_key][$key] as $date => $amount) {
                    $parent_row_values[$date] += $amount;
                }
            }
        }
    @endphp

    @if ($row_total = array_sum($parent_row_values))
        @if (isset($parent_id))
            <tr class="hover:bg-gray-100 border-b collapse-sub collapse-sub-report" data-collapse="child-{{ $parent_id }}">
                <td class="{{ $class->column_name_width }} w-24 py-2 text-left text-black-400" style="padding-left: {{ $tree_level * 20 }}px;" title="{{ $row_name }}">
        @else
            <tr class="hover:bg-gray-100 border-b">
                <td class="{{ $class->column_name_width }} w-24 py-2 text-left text-black-400" title="{{ $row_name }}">
        @endif

        <div class="w-full flex items-center gap-2 text-sm">
            @php
                $parent_account_id = $id;
                $is_account_row = isset($class->general_ledger_report) && is_numeric($parent_account_id) && $class->general_ledger_report;
            @endphp
            @if ($is_account_row && empty($print))
                <a href="{{ route('reports.show', [$class->general_ledger_report->id]) }}?search=de_account_id:{{ $parent_account_id }}" class="w-full inline-flex items-center gap-4">
                    @if ($code)
                        <span class="w-8 account-code whitespace-nowrap text-right to-black-400 hover:bg-full-2 bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize">{{ $code }}</span>
                        <span class="account-name" data-truncate-marquee>{{ $name }}</span>
                    @else
                        <span>{{ $name }}</span>
                    @endif
                </a>
            @else
                @if ($code)
                    <span class="w-8 account-code whitespace-nowrap text-right to-black-400 hover:bg-full-2 bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize">{{ $code }}</span>
                    <span class="account-name" data-truncate-marquee>{{ $name }}</span>
                @else
                    <span>{{ $name }}</span>
                @endif
            @endif
            @if (empty($print) && array_sum($parent_row_values) != array_sum($class->row_values[$table_key][$id]))
                <button type="button" class="align-text-top flex" node="child-{{ $id }}" onClick="toggleSub('child-{{ $id }}', event)">
                    <span class="material-icons transform rotate-90 transition-all text-lg leading-none mt-.05">expand_less</span>
                </button>
            @endif
        </div>

        </td>
        @foreach($parent_row_values as $row)
            <td class="{{ $class->column_value_width }} py-2 ltr:text-right rtl:text-left text-alignment-right text-black-400 text-xs">{{ $class->has_money ? money($row) : $row }}</td>
        @endforeach
        <td class="{{ $class->column_name_width }} py-2 ltr:text-right rtl:text-left text-alignment-right text-black-400 text-xs uppercase">{{ $class->has_money ? money($row_total) : $row }}</td>
    </tr>
    @endif

    <!-- no categories part -->
    @php $rows = $class->row_values[$table_key][$id]; @endphp
    @if (($row_total = array_sum($rows)) && array_sum($parent_row_values) != array_sum($rows))
    <tr class="hover:bg-gray-100 border-b collapse-sub collapse-sub-report text-sm" data-collapse="child-{{ $id }}">
        <td class="{{ $class->column_name_width }} py-2 text-left text-black-400" style="padding-left: {{ ($tree_level + 1) * 20 }}px;" title="{{ $row_name }}">
            @php
                $leaf_account_id = $id;
                $is_account_row_leaf = isset($class->general_ledger_report) && is_numeric($leaf_account_id) && $class->general_ledger_report;
            @endphp
            @if ($is_account_row_leaf && empty($print))
                <a href="{{ route('reports.show', [$class->general_ledger_report->id]) }}?search=de_account_id:{{ $leaf_account_id }}" class="w-full inline-flex items-center gap-4">
                    @if ($code)
                        <span class="w-8 account-code whitespace-nowrap text-right hover:bg-gray-100 border-b">{{ $code }}</span>
                        <span class="account-name" data-truncate-marquee>{{ $name }}</span>
                    @else
                        <span>{{ $name }}</span>
                    @endif
                </a>
            @else
                @if ($code)
                    <span class="w-8 account-code whitespace-nowrap text-right hover:bg-gray-100 border-b">{{ $code }}</span>
                    <span class="account-name" data-truncate-marquee>{{ $name }}</span>
                @else
                    {{ $name }}
                @endif
            @endif
        </td>
        @foreach($rows as $row)
            <td class="{{ $class->column_value_width }} py-2 ltr:text-right rtl:text-left text-alignment-right text-black-400 text-xs">{{ $class->has_money ? money($row) : $row }}</td>
        @endforeach
        <td class="{{ $class->column_name_width }} py-2 ltr:text-right rtl:text-left text-alignment-right text-black-400 text-xs uppercase">{{ $class->has_money ? money($row_total) : $row }}</td>
    </tr>
    @endif

    <!-- subcategories part -->
    @php
        $parent_id = $id;
        $tree_level++;
    @endphp

    @foreach($node as $id => $node)
        @if ($parent_id != $id)
            @include($class->views['detail.table.row'], ['parent_id' => $parent_id, 'tree_level' => $tree_level])
        @endif
    @endforeach
@endif
