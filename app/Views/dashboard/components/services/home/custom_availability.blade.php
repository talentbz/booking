<?php
$custom_price = isset($custom_price) ? $custom_price : [];
$post_type = isset($post_type) ? $post_type : 'home';
?>
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Start Date')}}</th>
            <th scope="col">{{__('End Date')}}</th>
            <th scope="col">{{__('Status')}}</th>
            <th scope="col" width="100">{{__('Action')}}</th>
        </tr>
        </thead>
        @if (!empty($custom_booked['total']))
            <tbody>
            @foreach ($custom_booked['results'] as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ date('m.d.Y.', $item->start_time) }}</td>
                    <td>{{ date('m.d.Y.', $item->end_time) }}</td>
                    <td>{{ $item->type }}</td>
                    <td>
                        <a href="javascript: void(0)" class="btn btn-danger btn-sm delete-book"
                           data-title="{{__('Delete this item?')}}"
                           data-content="{{__('Are you sure to delete this item?')}}"
                           data-post-type="{{$post_type}}"
                           data-post-id="{{ $post_id }}"
                           data-availiability-id="{{ $item->ID }}">{{__('Delete')}}</a>
                    </td>
                </tr>
            @endforeach
            <tbody>
        @endif
    </table>
</div>
