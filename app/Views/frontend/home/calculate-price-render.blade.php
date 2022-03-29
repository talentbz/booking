<div>
    <h5 style="font-size: 16px; font-weight: 400; color: #808080;">{{ __('Total') }}</h5>
    <div class="price-wrapper ml-auto">
        <span class="price" style="font-size: 36px; color: #115571;">{!! balanceTags(convert_price($total)) !!}</span>
        <input type="hidden" name="total_price" value="{{$total}}" />
    </div>
</div>
