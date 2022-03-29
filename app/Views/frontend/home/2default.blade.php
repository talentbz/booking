@include('frontend.components.header')
<style>
    .table thead th {
        text-align: center;
    }
    .table td, .table th {
        text-align: center;
    }
    @media(max-width: 572px) {
        #safe_svg {
            width: 100px !important;
        }
    }
    .meta-book-footer-btn:hover {
        color: #977A3E !important;
    }
    strong {
        font-weight: bold !important;
    }
    .custom_calendar {
        box-shadow: 0 14px 36px 2px rgb(255 255 255 / 15%) !important;
        -webkit-box-shadow: 0 14px 36px 2px rgb(255 255 255 / 15%) !important;
        width: 100% !important;
    }
    .custom_calendar .left {
        width: 100%;
    } 
    .custom_calendar .left .table-sub-header {
        display: flex;
        justify-content: space-around;
    }
    .custom_calendar .left tbody tr {
        display: flex;
        justify-content: space-around;
    }
    @media(max-width: 991px){
        .show-map-balance {
            display: block !important;
        }
    }
</style>
<?php
enqueue_script('scroll-magic-js');
enqueue_style('image-gallery-css');

global $post;
if (is_null($post)) {
    return;
}
$owner = $post->author;
$customer = get_current_user_id();
if ($owner == $customer) {
    return;
}
enqueue_script('messenger-frontend-js');
enqueue_style('messenger-frontend-css');
$url = get_the_permalink($post->post_id, $post->post_slug, $post->post_type);
$author = get_user_by_id($post->author);
$code = [
    'from_user' => $customer,
    'to_user' => $owner,
    'post_id' => $post->post_id,
    'post_type' => $post->post_type,
    'refer_link' => $url
];
?>

<div class="single-page single-home pb-5" style="background: #F9F9F9; margin-top: -20px">
    <!-- Gallery -->
    <?php
    $gallery = $post->gallery;
    $thumbnail_id = get_home_thumbnail_id($post->post_id);
    $thumbnailUrl = get_attachment_url($thumbnail_id, 'full');
    $specialPrices = array();
    $periodPrices = array();
    $today = strtotime(date('Y-m-d'));
    foreach ($post->period_stay_date['results'] as $key => $item) {
        if($item->first_minute == 'on' || $item->last_minute == 'on'){
            if($item->start_time > $today) {
                array_push($specialPrices, $item);
            }else if($item->start_time <= $today && $item->end_time >= $today){
                array_push($specialPrices, $item);
            }
        }else {
            array_push($periodPrices, $item);
        }
    }
    $total_array = array();
    foreach ($periodPrices as $item) {
        $special_flag = false;
        foreach ($specialPrices as $value) {
            if($value->start_time >= $item->start_time && $value->end_time <= $item->end_time){
                $special_flag = true;
                // $item->first_minute = 'on';
                // $item->last_minute = 'on';
                // $item->discount_percent = $value->discount_percent;
                $value->price_per_night = $item->price_per_night;
                $value->stay_min_date = $item->stay_min_date;
                array_push($total_array, $item);
                array_push($total_array, $value);
                break;
            }
        }
        if(!$special_flag) {
            array_push($total_array, $item);
        }
    }
    ?>
    <div class="hh-gallery hh-thumbnail has-background-image" data-src="{{ $thumbnailUrl }}" style="background-image: url({{ $thumbnailUrl }})">
        <div class="controls">
            <a href="javascript: void(0);" class="view-gallery item-link"><span>{{__('View Photos')}}</span> <i class="ti-gallery"></i> </a>
        </div>
        <?php
        if (!empty($gallery)) {
            enqueue_script('light-gallery-js');
            enqueue_style('light-gallery-css');

            $gallery = explode(',', $gallery);
            $data = [];
            foreach ($gallery as $key => $val) {
                $url = get_attachment_url($val);
                if (!empty($url)) {
                    $data[] = [
                        'src' => $url
                    ];
                }
            }
            if (!empty($data)) {
                $data = base64_encode(json_encode($data));
                echo '<div class="data-gallery" data-gallery="' . esc_attr($data) . '"></div>';
            }
        }
        ?>
        @if(!empty($post->safe_stay) && $post->safe_stay == 'on')
            <div style="position: absolute; right: 30px; top: 30px;">
                <img id="safe_svg" src={{url('images/svg/safe.svg')}} style="width:250px;">
            </div>
        @endif
        
        <div class="gallery_top_destination"><p>{{get_translate($post->post_title)}}</p>
            <p style="font-size:20px;font-weight: bolder; color: #FFF;"><i class="ti-location-pin" style="font-size: 24px; text-align:center;color: #FFF;"></i> {{get_short_address($post)}} </p>
        </div>
    </div>
    <div class="container">
        <div class="row mt-4">
            <div class="col-12 col-sm-7 col-md-7 col-lg-8 col-content villa-page-content">
                <?php
                    $amenities = $post->tax_home_amenity;
                ?>
                @if (!empty($amenities) && is_object($amenities))
                <div class="row left-sidebar pl-5 pr-5">
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-4 mt-3">
                            <p style="margin-top: -15px; font-size:20px;font-weight: bolder; color: #115571;"><i class="fas fa-user-tie" style="font-size: 24px; color: #115571;"></i><span class="ml-2">{{ _n("[0::%s guests][1::%s guest][2::%s guests]", (int)$post->number_of_guest) }}</span></p>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 mt-3">
                            <p style="margin-top: -15px; font-size:20px;font-weight: bolder; color: #115571;"> <i class="fas fa-bed" style="font-size: 24px; color: #115571;"></i><span class="ml-2">{{ _n("[0::%s bedrooms][1::%s bedrooms][2::%s bedrooms]", (int)$post->number_of_bedrooms) }} </span></p>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 mt-3">
                            <p style="margin-top: -15px; font-size:20px;font-weight: bolder; color: #115571;"> <i class="fas fa-restroom" style="font-size: 24px; color: #115571;"></i><span class="ml-2"> {{ _n("[0::%s bathrooms][1::%s bathrooms][2::%s bathrooms]", (int)$post->number_of_bathrooms) }}</span></p>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 mt-3">
                            <p style="margin-top: -15px; font-size:20px;font-weight: bolder; color: #115571;"><i class="fas fa-ruler-combined" style="font-size: 24px; color: #115571;"></i><span class="ml-2"> {{ $post->size }} {{ get_option('unit_of_measure', 'm2') }}</span></p>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 mt-3">
                            <?php
                                $type = get_term_by('id', $post->home_type);
                                $type_name = $type ? get_translate($type->term_title) : '';
                            ?>
                        
                            <p style="margin-top: -15px; font-size:20px;font-weight: bolder; color: #115571;"> <img src="/images/beach-front.svg" style="width: 24px;color: #115571;"></img><span class="ml-2">@if(!empty($type_name)){{$type_name}} @endif </span></p>
                        </div>
                        
                        <?php 
                            $distance = $post->distance;
                            if(!empty($distance)){
                                $distance = (array)json_decode($distance);
                                $i = 0;
                                foreach ($distance as $key => $value) {
                                    if(!empty($value) && $i == 0){ ?>
                                        <div class="col-12 col-sm-4 col-md-4 mt-3">
                                            <p style="margin-top: -15px; font-size:20px;font-weight: bolder; color: #115571;"><img src="/images/sea-boat.svg" style="width: 24px;color: #115571;"></img><span class="ml-2"> {{$key}}: <span style="font-weight:bold;">{{$value}}</span></span></p>
                                        </div>
                                    <?php 
                                    break;
                                    }
                                }    
                            }
                        ?>
                    </div>
                </div>
                @endif
                <div class="row left-sidebar mt-4 ">
                    <h2 class="heading mt-4 mb-4" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('About Villa')}}</h2>
                    <div style="width:100%; font-size: 15px">
                        {!! balanceTags(get_translate($post->post_content)) !!} 
                    </div>
                    <?php
                    $checkIn = $post->checkin_time;
                    $checkOut = $post->checkout_time;
                    $enableCancellation = $post->enable_cancellation;
                    $enableRules = $post->enable_rules;
                    $rulesOption1 = $post->rules_option1;
                    $rulesOption2 = $post->rules_option2;
                    // $rulesDetail1 = $post->rules_detail1;
                    // $rulesDetail2 = $post->rules_detail2;
                    $cancelBeforeDay = (int)$post->cancel_before;
                    $cancellationDetail = $post->cancellation_detail;
                    ?>
                    <div style="width:100%">
                        @if($checkIn)
                            <div class="item d-inline-block mr-4 mb-3">
                                <span class="font-weight-bold" style="text-transform: uppercase; font-size: 20px; color: #115571;">{{__('Check in')}}</span>
                                <span class="ml-2">{{ $checkIn }}</span>
                            </div>
                        @endif
                        @if ($checkOut)
                            <div class="item d-inline-block mr-4 mb-3">
                                <span class="font-weight-bold" style="text-transform: uppercase; font-size: 20px; color: #115571;">{{__('Check out')}}</span>
                                <span class="ml-2">{{ $checkOut }}</span>
                            </div>
                        @endif       
                    </div>
                    <!-- <div class="qr-code-render mb-3"><?php getQrCode($post->post_id, 'home')?></div> -->
                </div>
                <div class="row left-sidebar amenities mt-3">
                    
                    <div class="row px-3">
                        <div class="col-12 col-sm-12 col-md-12">
                            <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('Facilities & Amenities')}}</h2>
                        </div>
                        <?php
                        $amenities = $post->tax_home_amenity;
                        ?>
                        @if (!empty($amenities) && is_object($amenities))
                            @foreach ($amenities as $amenity)
                            <div class="col-12 col-sm-4 col-md-4 mt-3">
                                <p style="margin-top: -15px; font-size:20px;font-weight: bolder; color: #115571;">
                                    @if (!$amenity->term_icon)
                                        <i class="fe-check" style="font-size: 24px; color: #115571;margin-right: 10px;"></i>
                                    @else
                                        {!! get_icon($amenity->term_icon, '#115571', '24px', '')  !!}
                                    @endif
                                    <!-- <i class="fas fa-ruler-combined" style="font-size: 24px; text-align:center;color: #115571;margin-right: 10px;"></i> -->
                                    <span class="ml-2">{{ get_translate($amenity->term_title) }}</span>
                                </p>
                            </div>
                            @endforeach
                        @endif
                        @if(!empty($post->pool_size) && $post->pool_size > 0) 
                            <div class="col-12 col-sm-4 col-md-4 mt-3">
                                <p style="margin-top: -15px; font-size:20px;font-weight: bolder; color: #115571;">
                                    {!! get_icon('icons1_swimming_pool_svgrepo_com', '#115571', '24px', '')  !!}
                                    <span class="ml-2">Pool Size: {{ $post->pool_size }} m²</span>
                                </p>
                            </div>
                        @endif
                        
                        <?php 
                            $facilities = $post->facilities;
                            if(!empty($facilities)){
                                $facilities = (array)json_decode($facilities);
                                $i = 0;
                                foreach ($facilities as $key => $value) {

                                    if(!empty($value) && $i == 0){ ?>
                                            <div class="col-12 col-sm-12 col-lg-12">
                                                    <h4 class="mt-2 mb-2 facilities-title-responsive" style="font-weight: bold; color: #334F63">{!! balanceTags(ucfirst(strtolower($key))) !!}</h4>
                                                    <div data-toggle="ots-tooltip" style="margin-left:50px; margin-bottom: 20px; text-align: left;">
                                                        <div class="row facilities-item-responsive">
                                                            <?php foreach ($value as $item) { ?>
                                                                <div class="col-12 col-sm-3 col-1g-4" style="padding-right: 30px;">
                                                                    <span style="font-weight: 300; display: list-item; font-size:16px;">{{$item}}</span>
                                                                </div>
                                                            <?php } ?>  
                                                        </div>
                                                    </div>
                                        </div>
                                    <?php 
                                        }
                                        $i++; 
                                }
                            }
                        ?>
                        <div class="load-more-content">
                        <?php 
                            $facilities = $post->facilities;
                            if(!empty($facilities)){
                                $facilities = (array)json_decode($facilities);
                                $i = 0;
                                foreach ($facilities as $key => $value) {
                                    if(!empty($value) && $i != 0){ ?>
                                        <div class="col-12 col-sm-12 col-lg-12 more_detail">
                                            <h4 class="mt-2 mb-2 facilities-title-responsive" style="font-weight: bold; color: #334F63">{!! balanceTags(ucfirst(strtolower($key))) !!}</h4>
                                            <div data-toggle="ots-tooltip" style="margin-left:50px; margin-bottom: 20px; text-align: left;">
                                                <div class="row facilities-item-responsive">
                                                <?php foreach ($value as $item) { ?>
                                                    <div class="col-12 col-sm-3 col-1g-4" style="padding-right: 30px;">
                                                        <span style="font-weight: 300; display: list-item; font-size:16px;">{{$item}}</span>
                                                    </div>
                                                <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                    $i++; 
                                }    
                            }
                        ?>
                        </div>
                        <div class="d-flex col-12 col-sm-12 col-md-12 justify-content-center">
                            <a href="javascript:changeTitle()" class="btn d-flex justify-content-center align-items-center button-load-more">
                                <input type="hidden" id="currentTitle" value="0"/>
                                <span class="d-inline-block" id="loadButton" >LOAD MORE</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row hh-gallery mt-3" style="padding:25px;">
                    <h2 class="heading mt-4 mb-4" style="width: 100%; font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('Gallery')}}</h2>
                    <?php
                    if (!empty($gallery)) {
                        switch (count($gallery)) {
                            case 1:
                                break;
                            case 2:
                                echo '
                                <div class="container">
                                    <div class="row gallery-grid">
                                        <div class="col-6" style="border-radius: 10px;">
                                            <a href="javascript:void(0)" class="view-gallery item-link" style="height:auto;">
                                                <img alt="img_gallery" src="'.get_attachment_url($gallery[0]).'">
                                            </a>                            
                                        </div>
                                        <div class="col-6" style="border-radius: 10px;">
                                            <a href="javascript:void(0)" class="view-gallery item-link" style="height:auto;">
                                                <img alt="img_gallery" src="'.get_attachment_url($gallery[1]).'">
                                            </a> 
                                        </div>
                                    </div>
                                </div>';
                                break;
                            case 3:
                                echo '
                                <div class="container">
                                    <div class="row gallery-grid">
                                        <div class="col-8" style="border-radius: 10px;">
                                            <a href="javascript:void(0)" class="view-gallery item-link">
                                                <img alt="img_gallery" src="'.get_attachment_url($gallery[0]).'">
                                            </a>   
                                            <a href="javascript:void(0)" class="view-gallery item-link">
                                                <img alt="img_gallery" src="'.get_attachment_url($gallery[1]).'">
                                            </a>                         
                                        </div>
                                        <div class="col-4" style="border-radius: 10px;">
                                            <a href="javascript:void(0)" class="view-gallery item-link">
                                                <img alt="img_gallery" src="'.get_attachment_url($gallery[2]).'">
                                            </a>                                        
                                        </div>
                                    </div>
                                </div>';
                                break;
                            default:
                                echo '
                                <div class="container">
                                    <div class="row gallery-grid">
                                        <div class="col-sm-6">
                                            <div class="col-sm-12 col-12" style="border-radius: 10px;">
                                                <a href="javascript:void(0)" class="view-gallery item-link">
                                                    <img alt="img_gallery" src="'.get_attachment_url($gallery[0]).'">
                                                </a>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-sm-12 col-12" style="border-radius: 10px;">
                                                    <a href="javascript:void(0)" class="view-gallery item-link">
                                                        <img alt="img_gallery" src="'.get_attachment_url($gallery[1]).'">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-sm-12 col-12" style="border-radius: 10px;">
                                                <a href="javascript:void(0)" class="view-gallery item-link">
                                                    <img alt="img_gallery" src="'.get_attachment_url($gallery[2]).'">
                                                </a>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-sm-12 col-12" style="border-radius: 10px;">
                                                    <a href="javascript:void(0)" class="view-gallery item-link">
                                                        <img alt="img_gallery" src="'.get_attachment_url($gallery[3]).'">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                break;
                        }        
                        enqueue_script('light-gallery-js');
                        enqueue_style('light-gallery-css');
            
                        $gallery = explode(',', $post->gallery);
                        $data = [];
                        foreach ($gallery as $key => $val) {
                            $url = get_attachment_url($val);
                            if (!empty($url)) {
                                $data[] = [
                                    'src' => $url
                                ];
                            }
                        }
                        if (!empty($data)) {
                            $data = base64_encode(json_encode($data));
                            echo '<div class="data-gallery" data-gallery="' . esc_attr($data) . '"></div>';
                        }            
                    }
                    ?> 
                </div>
                <div class="row left-sidebar mt-3">
                    <div style="widht: 100%;" class="col-12 col-sm-12 col-md-12">
                        <h2 class="heading" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('Avalibility & Pricing')}}</h2>
                        <div class="table-responsive-sm mb-5">
                            <table class="table" id="price_table_list" style="font-size:15px;">
                                <thead>
                                    <tr>
                                        <th scope="col">From</th>
                                        <th scope="col">To</th>
                                        <th scope="col">Per Night Price</th>
                                        <th scope="col">Minimum Stay</th>
                                        <th scope="col">Weekly price</th>
                                    </tr>
                                </thead>
                                @if (!empty($post->period_stay_date['total']))
                                    <tbody>
                                    @foreach ($total_array as $item)
                                        <?php
                                            $base_price = 0;
                                            $i = strtotime(date('d.m.Y'));
                                            $special_flag = false;
                                            
                                            if($item->first_minute == 'on' || $item->last_minute == 'on'){
                                                $special_flag = true;
                                                $base_price = $item->price_per_night;
                                                $special_price = $item->price_per_night * ($item->discount_percent / 100);
                                            }else if($item->price == 0 && $item->price_per_night > 0){
                                                $base_price = $item->price_per_night;
                                            }else {
                                                $base_price = $item->price;    
                                            }
                                        ?>
                                        <tr>
                                            <td>@if($special_flag) <span style="color:#f1556c; line-height: 10px;"> Special Offer</span><br> @endif<span style="@if($special_flag)color:#f1556c; line-height:0px; @else color:#000; @endif ">{{ date('d.m.Y.', $item->start_time) }} </span></td>
                                            <td @if($special_flag) style="padding-top: 25px;" @endif><span style="color:@if($special_flag)#f1556c; @else #000; @endif">{{ date('d.m.Y.', $item->end_time) }}</span></td>
                                            <td>
                                                @if($special_flag) <span style="color:#000; text-decoration: line-through; line-height: 10px;"> {{convert_price(($base_price)) }}</span><br>@endif <span style="@if($special_flag)color:#f1556c; line-height:0px;@else color:#000; @endif">@if($special_flag) {{convert_price(($base_price - $special_price)) }} @else {{convert_price($base_price) }} @endif</span></td>
                                            <td @if($special_flag) style="padding-top: 25px;" @endif>@if($special_flag) <span style="color:#f1556c;"> {{$item->stay_min_date}} </span> @else <span style="color:#000;">{{ $item->stay_min_date }} </span>  @endif</td>
                                            <td @if($special_flag) style="padding-top: 25px;" @endif>
                                                <span style="color:@if($special_flag)#f1556c; @else #000; @endif">@if($special_flag) {{convert_price(($base_price - $special_price) * 7) }} @else {{convert_price($base_price * 7) }} @endif</span></td>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row left-sidebar mt-5" style="padding: 25px; background: '#fff'">
                    <div class="hh-availability-wrapper">
                        <div class="hh-availability availability-date-field" data-home-id="{{ $post->post_id }}">
                            <input type="hidden" class="calendar_input"
                                data-id="{{$post->post_id}}"
                                data-home-id="{{ $post->post_id }}"
                                data-encrypt="{{hh_encrypt($post->post_id)}}"
                                data-action="{{ url('get-inventory-home') }}"
                                data-date-format="{{hh_date_format_moment()}}">
                        </div>
                    </div>
                    <div class="mt-3 question-calendar" style="">
                        <div style="display: flex; justify-content: start; margin-left: 20px;">
                            <div style="width: 30px;height: 30px;background: #115571;border-radius: 5px; margin-right: 10px;"></div>
                            <p>Today</p>
                        </div>
                        <div style="display: flex; justify-content: start;margin-left: 20px;">
                            <div style="width: 30px;height: 30px;background: #F9F9F9;border: 1px solid #DFDFDF;border-radius: 5px; margin-right: 10px;"></div>
                            <p>Available</p>
                        </div>
                        <div style="display: flex; justify-content: start;margin-left: 20px;">
                            <div style="width: 30px;height: 30px;background: #BD180D;border: 1px solid #DFDFDF;border-radius: 5px; margin-right: 10px;"></div>
                            <p>Not available</p>
                        </div>
                    </div>
                    @if(!empty($post->cancellation_field))
                        <p style="text-align: center; border-top: 1px solid #e2e2e2; padding-top: 40px; border-bottom: 1px solid #e2e2e2; padding-bottom: 40px;">{{get_translate($post->cancellation_field)}}</p>
                    @endif

                    @if ($enableCancellation == 'on')
                        <div class="item d-inline-block mr-4 mb-3">
                            <span class="font-weight-bold">{{__('Cancellation:')}}</span>
                            <span class="ml-2 small-info bg-success">{{__('enable')}}</span>
                            <span class="d-inline-block ml-1">{{ sprintf(__('before %s day(s)'), $cancelBeforeDay) }}</span>
                        </div>
                        @if (get_translate($cancellationDetail))
                            <div class="w-100" >{!! balanceTags(get_translate($cancellationDetail)) !!}</div>
                        @endif
                    @endif

                    @if ($enableRules == 'on')
                        @if ($rulesOption1 == 'on')
                            <div class="w-100" >{!! balanceTags(get_translate(get_option('term_rules_en_1'))) !!}</div>
                            <div id="changeRule1Content">
                                <div class="w-100" >
                                {!! balanceTags(get_translate(get_option('term_rules_en_1_loadmore'))) !!}
                                </div>
                                @if ($rulesOption2 == 'on')
                                    <div class="w-100" >{!! balanceTags(get_translate(get_option('term_rules_en_2'))) !!}</div>         
                                    <div class="w-100" >{!! balanceTags(get_translate(get_option('term_rules_en_2_loadmore'))) !!}</div>
                                @endif
                            </div>
                            <div class="d-flex col-12 col-sm-12 col-md-12 justify-content-center">
                                <a href="javascript:changeRule1Title()" class="btn d-flex justify-content-center align-items-center button-load-more">
                                    <input type="hidden" id="currentRule1Title" value="0"/>
                                    <span class="d-inline-block" id="rule1LoadMore" >LOAD MORE</span>
                                </a>
                            </div>
                        @endif
                        @if ($rulesOption2 == 'on' && $rulesOption1 != 'on')
                            <div class="w-100" >{!! balanceTags(get_translate(get_option('term_rules_en_2'))) !!}</div>
                            <div id="changeRule1Content">
                                <div class="w-100" >{!! balanceTags(get_translate(get_option('term_rules_en_2_loadmore'))) !!}</div>
                            </div>
                            <div class="d-flex col-12 col-sm-12 col-md-12 justify-content-center">
                                <a href="javascript:changeRule2Title()" class="btn d-flex justify-content-center align-items-center button-load-more">
                                    <input type="hidden" id="currentRule2Title" value="0"/>
                                    <span class="d-inline-block" id="rule2LoadMore" >LOAD MORE</span>
                                </a>
                            </div>
                        @endif
                    @endif

                    @if($post->gallery_url)
                        <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('Show other images')}}</h2>
                        <div class="video-wrapper">
                            <a href="{{$post->gallery_url}}">Show this homes gallery</a>
                        </div>
                    @endif
                    @if($post->video)
                        <div style="width:100%">
                            <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('Video')}}</h2>
                            <div class="video-wrapper">
                                {!! balanceTags(get_video_embed_url(get_translate($post->video))) !!}
                            </div>
                        </div>
                    @endif
                    @if($post->tiktok)
                        <div style="width:100%">
                            <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('Tik Tok')}}</h2>
                            <div class="video-wrapper">
                                {!! balanceTags($post->tiktok) !!}
                            </div>
                        </div>
                    @endif
                </div>      
                <div class="row mt-5 show-map-balance" style="background: #F9F9F9; border: 0px; padding:20px 0px; display: none;">
                    <h2 class="heading" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('Location')}}</h2>
                    <?php
                    $lat = $post->location_lat;
                    $lng = $post->location_lng;
                    $zoom = $post->location_zoom;

                    enqueue_style('mapbox-gl-css');
                    enqueue_style('mapbox-gl-geocoder-css');
                    enqueue_script('mapbox-gl-js');
                    enqueue_script('mapbox-gl-geocoder-js');
                    ?>
                    <div class="hh-mapbox-single" data-lat="{{ $lat }}"
                        data-lng="{{ $lng }}" data-zoom="{{ $zoom }}"></div>
                    <?php
                    $author = get_user_by_id($post->author);
                    $address = $author->address;
                    $location = $author->location;
                    $country = get_country_by_code($location);
                    $description = $author->description;
                    $video = $author->video;
                    ?>
                    <div class="px-3">
                        <h2 class="heading" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('Distances')}}</h2>
                        <div class="amenities row px-3">
                            <?php 
                                $distance = $post->distance;
                                if(!empty($distance)){
                                    $distance = (array)json_decode($distance);
                                    
                                    foreach ($distance as $key => $value) {
                                        if(!empty($value)){ ?>
                                            <div class="col-12 col-sm-6 col-1g-6 col-md-6" style="padding-right: 10px;">
                                                <h4 class="mt-2 mb-2"><span style="color: #115571">{{$key}}: <span style="font-weight:bold;">{{$value}}</span></span> </h4>
                                            </div>
                                        <?php }
                                    }    
                                }
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-12 col-sm-5 col-md-5 col-lg-4 col-sidebar">
                
                <?php
                enqueue_style('daterangepicker-css');
                enqueue_script('daterangepicker-js');
                enqueue_script('daterangepicker-lang-js');
                enqueue_script('home-villa-js');
                ?>
                <?php
                $booking_form = $post->booking_form;
                $text_external_link = $post->text_external_link;
                $external_link = $post->use_external_link;
                ?>
                <div class="row">
                    <div id="form-book-home" style="margin-top:0px; width: 100%;" class="form-book" data-real-price="{{url('get-home-price-realtime') }}">
                        <div class="popup-booking-form-close">{!! get_icon('001_close', '#fff', '28px', '28px') !!}</div>
                        <!-- <div class="form-head">
                            <div class="price-wrapper">
                                <span class="price">{{ convert_price($post->base_price) }}</span>
                                @if($post->booking_type != 'external_link')
                                    <span class="unit">/{{$post->unit}}</span>
                                @endif
                            </div>
                        </div>     -->     
                        <div class="form-body" style="background:white;">
                            @include('common.loading', ['class' => 'booking-loading'])
                            @if($booking_form == 'instant_enquiry')
                                <ul class="nav nav-tabs nav-bordered row">
                                    <li class="nav-item nav-item-booking-form-instant col">
                                        <a href="#booking-form-instant"
                                        data-toggle="tab"
                                        aria-expanded="false"
                                        class="nav-link @if($booking_form == 'instant_enquiry' ||$booking_form == 'instant') active @endif">
                                            {{__('BOOKING')}}
                                        </a>
                                    </li>
                                    <li class="nav-item nav-item-booking-form-instant col">
                                        <a href="#booking-form-enquiry"
                                        data-toggle="tab"
                                        aria-expanded="false"
                                        class="nav-link @if($booking_form == 'enquiry') active @endif">
                                            {{__('INQUIRY')}}
                                        </a>
                                    </li>
                                </ul>
                            @endif
                            @if($booking_form == 'instant_enquiry')
                                <div class="tab-content">
                                    @endif
                                    @if($booking_form == 'instant_enquiry' || $booking_form == 'instant')
                                        <div
                                            class="tab-pane @if($booking_form == 'instant_enquiry' ||$booking_form == 'instant') active @endif"
                                            id="booking-form-instant">
                                            @if($post->booking_type == 'external_link')
                                                @include('frontend.home.external-form')
                                            @else
                                                @include('frontend.home.booking-form')
                                            @endif
                                        </div>
                                    @endif
                                    @if($booking_form == 'instant_enquiry' || $booking_form == 'enquiry')
                                        <div class="tab-pane @if($booking_form == 'enquiry') active @endif"
                                            id="booking-form-enquiry">
                                            <form action="{{ url('home-send-enquiry-form') }}" data-google-captcha="yes"
                                                data-validation-id="form-send-enquiry"
                                                class="form-action form-sm has-reset" data-loading-from=".form-body">
                                                <div class="form-group">
                                                    <label for="full-name-enquiry-form">{{ __('Full Name') }} <span
                                                            class="text-danger">*</span></label>
                                                    <input id="full-name-enquiry-form" type="text" name="name"
                                                        class="form-control has-validation" data-validation="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email-enquiry-form">{{ __('Email') }} <span
                                                            class="text-danger">*</span></label>
                                                    <input id="email-enquiry-form" type="email" name="email"
                                                        class="form-control has-validation"
                                                        data-validation="required|email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-enquiry-form">{{ __('Message') }} <span
                                                            class="text-danger">*</span></label>
                                                    <textarea id="message-enquiry-form" class="form-control has-validation"
                                                            name="message" data-validation="required"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-primary btn-block text-uppercase"
                                                        name="sm"
                                                        value="{{ __('Send a Request') }}">
                                                </div>
                                                <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                                                <input type="hidden" name="post_encrypt"
                                                    value="{{ hh_encrypt($post->post_id) }}">
                                                <div class="form-message"></div>
                                            </form>
                                        </div>
                                    @endif
                                    @if($booking_form == 'instant_enquiry')
                                </div>
                            @endif
                        </div>
                        <div class="form-body relative" style="margin-top: 30px; background: #115571;">
                            <ul class="nav nav-tabs nav-bordered row" style="padding-bottom:5px;">
                                <li class="nav-item nav-item-booking-form-instant col" style="font-size:18px; padding:13px; color:white; text-align: center;">
                                    {{__('Property Agent')}}
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="row">
                                        <div class="col-6 col-sm-6">
                                            <p style="color: white;font-weight:700 !important; ">{{sprintf(get_user_by_id($author->getUserId())->first_name )}}</p>
                                            <!-- <p style="color:white;">Phone: {{sprintf(get_user_by_id($author->getUserId())->mobile )}}</p> -->
                                            <p style="color: white;">E-mail: {{sprintf(get_user_by_id($author->getUserId())->email )}}</p>
                                            <!-- <a href="javascript:void(0)"
                                               class=" btn btn-contact-host btn-contact-agent d-inline-flex align-items-center button-contact-host-{{ $post->post_type }}"
                                               data-code="{{base64_encode(json_encode($code))}}"
                                               data-action="{{url('messenger/start-message')}}"
                                            > -->
                                            <a href="javascript:void(0)"
                                               class=" btn btn-contact-host btn-contact-agent d-inline-flex align-items-center button-contact-host-{{ $post->post_type }}"
                                               data-toggle="modal" data-target="#inquery-modal" id="contact-agent-id"
                                            >
                                                <span class="d-inline-block meta-book-footer-btn" style="padding: 0.25rem 0.85rem; color: #fff; border: 1px solid #BE9F61; background-color: #BE9F61;">{{sprintf(__('Contact %s'), get_username($author->getUserId()) )}}</span>
                                                <div class="spinner-border spinner-border-sm d-none ml-2" role="status">
                                                    <span class="sr-only">{{__('Loading...')}}</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-6 ">
                                            <div style="float: right; width:100%;">
                                                <img src="{{ get_user_avatar($post->author, [64, 64]) }}" alt="{{ __('User Avatar') }}" class="avatar rounded-circle" style="float:right;">
                                            </div>
                                            <div class="qr-code-render mt-2" style="float: right"><?php getQrCode($post->post_id, 'home')?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-body relative" style="background: #F9F9F9; border: 0px; padding:20px 0px">
                            <h2 class="heading" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('Location')}}</h2>
                            <?php
                            $lat = $post->location_lat;
                            $lng = $post->location_lng;
                            $zoom = $post->location_zoom;

                            enqueue_style('mapbox-gl-css');
                            enqueue_style('mapbox-gl-geocoder-css');
                            enqueue_script('mapbox-gl-js');
                            enqueue_script('mapbox-gl-geocoder-js');
                            ?>
                            <div class="hh-mapbox-single" data-lat="{{ $lat }}"
                                data-lng="{{ $lng }}" data-zoom="{{ $zoom }}"></div>
                            <?php
                            $author = get_user_by_id($post->author);
                            $address = $author->address;
                            $location = $author->location;
                            $country = get_country_by_code($location);
                            $description = $author->description;
                            $video = $author->video;
                            ?>
                        </div>
                        <div class="form-body relative" style="background: #fff; border: 0px;">
                            <h2 class="heading" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('Distances')}}</h2>
                            <div class="amenities row px-3">
                                <?php 
                                    $distance = $post->distance;
                                    if(!empty($distance)){
                                        $distance = (array)json_decode($distance);
                                        
                                        foreach ($distance as $key => $value) {
                                            if(!empty($value)){ ?>
                                                <div class="col-12 col-sm-6 col-1g-6 col-md-6" style="padding-right: 10px;">
                                                    <h4 class="mt-2 mb-2"><span style="color: #115571">{{$key}}: <span style="font-weight:bold;">{{$value}}</span></span> </h4>
                                                </div>
                                            <?php }
                                        }    
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div style="padding: 10px 40px; width: 100%;">
                <?php
                $lat = $post->location_lat;
                $lng = $post->location_lng;
                $list_services = \App\Controllers\Services\HomeController::get_inst()->listOfHomes([
                    'number' => 4,
                    'location' => [
                        'lat' => $lat,
                        'lng' => $lng,
                        'radius' => 25
                    ],
                    'orderby' => 'distance',
                    'order' => 'asc',
                    'not_in' => [$post->post_id]
                ]);
                ?>
                @if(count($list_services['results']))
                    <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;">{{__('Homes Near By')}}</h2>
                    <div class="hh-list-of-services">
                        <div class="row">
                            @foreach($list_services['results'] as $item)
                                <div class="col-12 col-sm-4 col-md-6 col-lg-4" style="padding: 0px 10px;">
                                    @include('frontend.home.loop.grid', ['item' => $item, 'show_distance' => true])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="mobile-book-action">
            <div class="container">
                <div class="action-inner">
                    <div class="action-price-wrapper">
                        <span class="price">{{ convert_price($post->base_price) }}</span>
                        <span class="unit">/{{$post->unit}}</span>
                    </div>
                    <a class="btn btn-primary action-button" id="mobile-check-availability">{{__('Check Availability')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="inquery-modal" class="modal fade modal-no-footer" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase">{{__('Inquery')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('home-send-enquiry-form') }}" data-google-captcha="yes"
                    data-validation-id="form-send-enquiry"
                    class="form-action form-sm has-reset" data-loading-from=".form-body">
                    <div class="form-group">
                        <label for="full-name-enquiry-form">{{ __('Full Name') }} <span
                                class="text-danger">*</span></label>
                        <input id="full-name-enquiry-form" type="text" name="name"
                            class="form-control has-validation" data-validation="required">
                    </div>
                    <div class="form-group">
                        <label for="email-enquiry-form">{{ __('Email') }} <span
                                class="text-danger">*</span></label>
                        <input id="email-enquiry-form" type="email" name="email"
                            class="form-control has-validation"
                            data-validation="required|email">
                    </div>
                    <div class="form-group">
                        <label for="message-enquiry-form">{{ __('Message') }} <span
                                class="text-danger">*</span></label>
                        <textarea id="message-enquiry-form" class="form-control has-validation"
                                name="message" data-validation="required"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-block text-uppercase"
                            name="sm"
                            value="{{ __('Send a Request') }}">
                    </div>
                    <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                    <input type="hidden" name="post_encrypt"
                        value="{{ hh_encrypt($post->post_id) }}">
                    <div class="form-message"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('frontend.components.footer')
