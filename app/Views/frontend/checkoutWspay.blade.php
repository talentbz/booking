@include('frontend.components.header')
<?php
enqueue_script('select2-js');
enqueue_style('select2-css');
enqueue_style('flag-icon-css');
enqueue_script('country-js');
?>

<?php

$ctr = list_countries($booking->country);
?>
<div class="hh-checkout-page pb-4">
    @include('frontend.components.breadcrumb', ['currentPage' => 'Checkout', 'inContainer' => true])
    <div class="container">
        @if ($cart)
            <div class="row">
                <div class="col-12 text-center">
              
                    <form action="https://formtest.wspay.biz/Authorization.aspx" method="POST" name="pay" id="wcwspay-form">
                        <input type="hidden" name="ShopID" value="{{$setting->wspay_shopid}}" />
                        <input type="hidden" name="ShoppingCartID"  value="{{$booking->ID}}" />
                        <input type="hidden" name="TotalAmount"   value="<?php echo $booking->total; ?>" /> 
                        <input type="hidden" name="Signature"  value="<?php echo $signature; ?>" />
                        <input type="hidden" name="ReturnURL" value="{{route('wspaySuccess')}}" />
                        <input type="hidden" name="ReturnErrorURL" value="{{route('wspayReturn')}}" />
                        <input type="hidden" name="CancelURL" value="{{route('check-out')}}" />
                        <input type="hidden" name="Lang" value="EN" />
                        <input type="hidden" name="CustomerFirstName" value="{{$booking->first_name}}" />
                        <input type="hidden" name="CustomerLastName" value="{{$booking->last_name}}" />
                        <input type="hidden" name="CustomerAddress" value="{{$booking->address}}" />
                        <input type="hidden" name="CustomerCity" value="{{$booking->city}}" />
                        <input type="hidden" name="CustomerZIP" value="{{$booking->zipcode}}" />
                        <input type="hidden" name="CustomerCountry" value="<?php if(isset($ctr['code'])){ echo $ctr['code'];  } ?>" />
                        <input type="hidden" name="CustomerEmail" value="{{$booking->email}}" />
                        <input type="hidden" name="CustomerPhone" value="{{$booking->phone}}" />
                        <div class="wspay-controls">
                            <input class="btn btn-success " type="submit" value="Proceed to WSPay (Test Only)" />
                            
                        </div>
                    </form>
                    
                </div>
            </div>
        @else
            <div class="mt-4">
                @include('common.alert', ['type' => 'danger', 'message' => __('The cart is empty')])
            </div>
        @endif
    </div>
</div>
@include('frontend.components.footer')
