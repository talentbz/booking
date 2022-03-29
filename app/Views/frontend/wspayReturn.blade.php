@include('frontend.components.header')
<?php
enqueue_script('select2-js');
enqueue_style('select2-css');
enqueue_style('flag-icon-css');
enqueue_script('country-js');
?>


<div class="hh-checkout-page pb-4">
    @include('frontend.components.breadcrumb', ['currentPage' => 'Wspay', 'inContainer' => true])
    <div class="container" style="padding-top:100px;">
            @if(request()->input('Success')==1)
            <div class="alert alert-success text-center" role="alert">
              Payment Success <br/>Transaction id <br/> {{request()->input('WsPayOrderId')}}
            </div>
            @else
            
            <div class="alert alert-danger text-center" role="alert">
              Payment Failed <br/>
              {{request()->input('ErrorMessage')}}<br/>
              {{request()->input('ErrorCodes')}}<br/>
            </div>
            
            @endif

    </div>
</div>

<script>
    function redirect(){
        window.location.replace("{{route('thank-you', request()->get('ShoppingCartID') )}}");
    }
    
    @if(request()->input('Success')==1)
     setTimeout(redirect, 5000);
    @endif
     
</script>
@include('frontend.components.footer')
