@include('frontend.components.review-header')
<?php
enqueue_script('scroll-magic-js');
enqueue_script('agent-tip-js');
?>
<style>
    .table thead th {
        border: 0px;
        text-align: center;
    }
    .table td, .table th {
        border: 0px;
        text-align: center;
    }
</style>

<div class="single-page single-home pb-5">
    
    <div class="container-fluid hh-tip-checkout-page">
        <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-8 col-lg-9 col-content">
                        <div class="home-comment-list mt-3">
                            <h3 class="comment-count">
                                Thanks for your Review!
                            </h3>
                        </div>

                        <div class="post-comment parent-form" id="hh-comment-section">

                            <div class="checkout-content mt-4">
                                <div class="card-box card-border mt-3">
                                    <ul class="nav nav-tabs nav-bordered">
                                        <li class="nav-item">
                                            <a href="#co-customer-information" data-toggle="tab" aria-expanded="false"
                                            class="nav-link active">
                                                {{__('1. Payment amount')}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#co-payment-selection" data-toggle="tab" aria-expanded="true"
                                            class="nav-link">
                                                {{__('2. Payment Selection')}}
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane relative show active" id="co-customer-information">
                                            <div class="comment-form-wrapper " >
                                                <form id="checkout-payment-info" action="{{ url('add-tip-payment') }}" method="post" class="comment-form form-sm form-action form-add-post-comment"
                                                    data-google-captcha="yes">
                                                    <h3 class="comment-title">{{__('You would not be charged yet. Service fees do not apply.')}}</h3>
                                                    @include('common.loading')
                                                    
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <div class="row">
                                                        <div class="form-group col-lg-12">
                                                            <div class="btn-group">
                                                                <button type="button" onclick="setPrice('25')" id="price_5" class="btn btn-outline-info"><span style="padding: 0px 30px;">25 €</span></button>
                                                                <button type="button" onclick="setPrice('50')" id="price_10" class="btn btn-outline-info"><span style="padding: 0px 30px;">50 €</span></button>
                                                                <button type="button" onclick="setPrice('100')" id="price_15" class="btn btn-outline-info"><span style="padding: 0px 30px;">100 €</span></button>
                                                                <div class="btn-group">
                                                                    <button type="button" id="price_custom" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown"><span id="custom_tip_span" style="padding: 0px 30px;">Custom Tip</span>
                                                                    <!-- <input type="text" class="form-control" style="position: absolute; left: 0px; bottom: -28px;"> -->
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <div class="dropdown-item" style="display:flex; justify-content: center;width:200px;">
                                                                            <input type="number" id="custom_price" class="form-control" min="100"/>
                                                                            <button type="button" onclick="setCustomPrice()" class="btn btn-info">Select</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <input type="button" name="sm"
                                                            value="{{__('Payment Select')}}"
                                                            class="btn btn-primary text-uppercase float-right ml-auto waves-effect waves-light btn-complete-payment mt-5 btn-next-payment">
                                                    <a href="{{url('/')}}" class="float-right btn btn-success text-uppercase mt-5 mr-3">{{__('Later')}}</a>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane relative" id="co-payment-selection">
                                            <form id="checkout-payment-info" action="{{ url('add-tip-payment') }}" method="post"
                                                data-google-captcha="yes"
                                                class="form checkout-form checkout-form-payment relative">
                                                <div class="payment-gateways">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <input type="hidden" name="tip_price" id="tip_price" />
                                                    <input type="hidden" name="agent_id" value="{{ $post->author }}"/>
                                                    <input type="hidden" name="comment_id" value="0"/>
                                                    <input type="hidden" name="comment_type" value="{{ $service_type }}"/>
                                                    <input type="hidden" name="service_id" value="{{ $post->post_id }}" />
                                                    @include('common.loading')
                                                    <?php
                                                    $allPayment = get_available_payments();
                                                    ?>
                                                    @if (!empty($allPayment))
                                                        @foreach ($allPayment as $key => $paymentName)
                                                            <div class="payment-item payment-{{ $paymentName::getID() }}">
                                                                <div
                                                                    class="radio radio-success mb-1 mb-md-3 d-flex align-content-center">
                                                                    <input id="payment-{{ $paymentName::getID() }}"
                                                                        class="payment-method"
                                                                        type="radio" name="payment"
                                                                        value="{{ $paymentName::getID() }}"
                                                                        @if($key == 0) checked @endif>
                                                                    <label
                                                                        for="payment-{{ $paymentName::getID() }}">{{ $paymentName::getName() }}</label>
                                                                </div>
                                                                <?php
                                                                $desc = $paymentName::getDescription();
                                                                ?>
                                                                @if (!empty($desc))
                                                                    <div
                                                                        class="payment-desc">{!! balanceTags(nl2br($desc)) !!}</div>
                                                                @endif
                                                                <img src="{{ $paymentName::getLogo() }}"
                                                                    alt="{{ $paymentName::getName() }}"
                                                                    class="payment-logo d-none d-md-inline-block">
                                                                <?php
                                                                $html = $paymentName::getHtml();
                                                                ?>
                                                                @if (!empty($html))
                                                                    <div class="payment-html">{!! balanceTags($html) !!}</div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="tab-footer d-flex align-items-center">
                                                    <a href="javascript: void(0);"
                                                    class="btn-prev-customer c-black"><i
                                                            class="fe-arrow-left mr-2"></i>{{__('Back to Payment Amount')}}
                                                    </a>
                                                    <input type="submit" name="sm"
                                                        value="{{__('Tip now')}}"
                                                        class="btn btn-primary text-uppercase float-right ml-auto waves-effect waves-light btn-complete-payment">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@include('frontend.components.footer')
