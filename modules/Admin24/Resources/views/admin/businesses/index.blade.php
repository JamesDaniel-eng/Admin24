<x-layouts.admin>
    <x-slot name="title">Companies</x-slot>

    <x-slot name="favorite"
        title="Client Businesses"
        icon="account_tree"
        route="admin24.businesses"
    ></x-slot>

    <x-slot name="buttons">
        <x-link href="{{ route('admin24.business.add') }}" kind="primary" id="index-more-actions-new-company">
            Add Business
        </x-link>
    </x-slot>
    <x-slot name="content">
        <x-form.container>
            <x-form.section>
                <x-slot name="head">
                    <x-form.section.head title="Client Businesses" description="Here you can manage all <b>Client Businesses</b>." />
                </x-slot>
            </x-form.section>
        </x-form.container>
        <x-index.container>
            <x-index.search
                search-string="App\Models\Common\Company"
                bulk-action="App\BulkActions\Common\Companies"
            />

            <x-table>
                <x-table.thead>
                    <x-table.tr>
                        <x-table.th kind="bulkaction">
                            <x-index.bulkaction.all />
                        </x-table.th>

                        <x-table.th class="w-2/12 sm:w-1/12">
                            <x-sortablelink column="id" title="{{ trans('general.id') }}" />
                        </x-table.th>

                        <x-table.th class="w-8/12 sm:w-4/12">
                            <x-slot name="first" class="flex items-center">
                                <x-sortablelink column="name" title="Business {{ trans('general.name') }}" />
                            </x-slot>
                            <x-slot name="second">
                                <x-sortablelink column="email" title="Business Email" />
                            </x-slot>
                        </x-table.th>

                        <x-table.th class="w-4/12" hidden-mobile>
                            <x-slot name="first">
                                <x-sortablelink column="type" title="Business Type" />
                            </x-slot>
                            <x-slot name="second">
                                <x-sortablelink column="method" title="Bookkeeping Method" />
                            </x-slot>
                        </x-table.th>

                        <x-table.th class="w-3/12" kind="right">
                            <x-slot name="first">
                                <x-sortablelink column="sub_no" title="Subscription Number" />
                            </x-slot>
                            <x-slot name="second">
                                <x-sortablelink column="reg_no" title="Registration Number" />
                            </x-slot>
                        </x-table.th>
                    </x-table.tr>
                </x-table.thead>

                <x-table.tbody>
                    @if(!empty($businesses))
                    @foreach($businesses as $item)
                        <x-table.tr href="#">
                            <x-table.td kind="bulkaction">
                                @if ((company_id() != $item->id))
                                    <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->name }}" />
                                @else
                                    <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->name }}" disabled="true" />
                                @endif
                            </x-table.td>

                            <x-table.td class="w-2/12 sm:w-1/12">
                                {{ $item->id }}
                            </x-table.td>

                            <x-table.td class="w-8/12 sm:w-4/12">
                                <x-slot name="first" class="flex" override="class">
                                    <div class="font-bold truncate">
                                        {{ $item->name }}
                                    </div>
                                </x-slot>
                                <x-slot name="second">
                                    @if ($item->email)
                                        {{ $item->email }}
                                    @else
                                        <x-empty-data />
                                    @endif
                                </x-slot>
                            </x-table.td>

                            <x-table.td class="w-4/12" hidden-mobile>
                                <x-slot name="first">
                                    @if ($item->type)
                                        {{ $item->type }}
                                    @else
                                        <x-empty-data />
                                    @endif
                                </x-slot>
                                <x-slot name="second">
                                    @if ($item->bk_method)
                                        {{ $item->bk_method }}
                                    @else
                                        <x-empty-data />
                                    @endif
                                </x-slot>
                            </x-table.td>

                            <x-table.td class="w-3/12" kind="amount">
                                <x-slot name="first">
                                    @if ($item->sub_no)
                                        {{ $item->sub_no }}
                                    @else
                                        <x-empty-data />
                                    @endif
                                </x-slot>
                                <x-slot name="second">
                                    @if ($item->reg_no)
                                        {{ $item->reg_no }}
                                    @else
                                        <x-empty-data />
                                    @endif
                                </x-slot>
                            </x-table.td>

                            <x-table.td kind="action">
                                <x-table.actions :model="$item" />
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                    @endif
                </x-table.tbody>
            </x-table>
            
        </x-index.container>
    </x-slot>

</x-layouts.admin>
