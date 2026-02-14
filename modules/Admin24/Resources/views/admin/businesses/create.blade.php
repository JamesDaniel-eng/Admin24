<x-layouts.admin>
    <x-slot name="title">Create a new Business</x-slot>

    <x-slot name="favorite"
        title="Client Businesses"
        icon="account_tree"
        route="admin24.businesses"
    ></x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form.section>
                <x-slot name="head">
                    <x-form.section.head title="Client Businesses" description="Here you can manage all <b>Client Businesses</b>." />
                </x-slot>
            </x-form.section>
        </x-form.container>
        <x-index.container>            
            
        </x-index.container>
    </x-slot>

</x-layouts.admin>
