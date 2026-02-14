
<script type="text/javascript">
    var item_selected = {!! ($item_selected) ? json_encode($item_selected): '[]' !!};
    var item_default_composite_items = {!! isset($item_default_composite_items) ? json_encode($item_default_composite_items): '{}' !!};
    var item_selected_composite_items = {!! isset($item_selected_composite_items) ? json_encode($item_selected_composite_items): '{}' !!};
    var inventory_enabled = {!! isset($inventory_enabled) && $inventory_enabled ? 'true' : 'false' !!};
</script>
