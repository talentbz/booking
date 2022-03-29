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

<div class="single-page single-home pb-5" style="background: #F9F9F9">
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
    <div class="hh-gallery hh-thumbnail has-background-image" data-src="{{ $thumbnailUrl }}"
         style="background-image: url({{ $thumbnailUrl }})">
        <div class="controls">
            <a href="javascript: void(0);" class="view-gallery item-link"><span>{{__('View Photos')}}</span> <i
                    class="ti-gallery"></i> </a>
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
        <p><span class="gallery_top_destination">{{get_translate($post->post_title)}}</span></p>
    </div>
    <?php
        $amenities = $post->tax_home_amenity;
    ?>
    @if (!empty($amenities) && is_object($amenities))
    <div class="container-fluid pt-3" style="background: linear-gradient( #115571, white);">
        <div class="summary_info" style="">
            
            <div style="width:100%; border-radius: 13px;">
                <div class="featured-amenities mt-2 mb-2" style="display: flex; justify-content: center;">
                    <div class="item" style="text-align:center;margin-right: 50px;">
                        <div style="margin-top: -30px;">
                            <i class="ti-location-pin" style="font-size: 24px; text-align:center;color: #FFF;"></i>
                            <p style="margin-top: -15px;text-align:center; font-size:20px;font-weight: bolder; color: #FFF;"> {{get_short_address($post)}} </p>
                        </div>
                    </div>
                    <div class="item" style="text-align:center;margin-right: 50px;">
                        <div style="margin-top: -30px;">
                            <i class="fas fa-user-tie" style="font-size: 24px; text-align:center;color: #FFF;"></i>
                            <p style="margin-top: -15px;text-align:center; font-size:20px;font-weight: bolder; color: #FFF;"> {{ _n("[0::%s guests][1::%s guest][2::%s guests]", (int)$post->number_of_guest) }} </p>
                        </div>
                    </div>
                    <div class="item" style="text-align:center;margin-right: 50px;">
                        <div style="margin-top: -30px;">
                            <i class="fas fa-bed" style="font-size: 24px; text-align:center;color: #FFF;"></i>
                            <p style="margin-top: -15px;text-align:center; font-size:20px;font-weight: bolder; color: #FFF;"> {{ _n("[0::%s bedrooms][1::%s bedrooms][2::%s bedrooms]", (int)$post->number_of_bedrooms) }} </p>
                        </div>
                    </div>
                    <div class="item" style="text-align:center;margin-right: 50px;">
                        <div style="margin-top: -30px;">
                            <i class="fas fa-restroom" style="font-size: 24px; text-align:center;color: #FFF;"></i>
                            <p style="margin-top: -15px;text-align:center; font-size:20px;font-weight: bolder; color: #FFF;"> {{ _n("[0::%s bathrooms][1::%s bathrooms][2::%s bathrooms]", (int)$post->number_of_bathrooms) }} </p>
                        </div>
                    </div>
                    <div class="item" style="text-align:center;margin-right: 50px;">
                        <div style="margin-top: -30px;">
                            <i class="fas fa-ruler-combined" style="font-size: 24px; text-align:center;color: #FFF;"></i>
                            <p style="margin-top: -15px;text-align:center; font-size:20px;font-weight: bolder; color: #FFF;"> {{ $post->size }} {{ get_option('unit_of_measure', 'm2') }} </p>
                        </div>
                    </div>
                    <!-- <div class="item" style="text-align:center;margin-right: 50px;">
                        <div style="margin-top: -30px;">
                            <i class="fas fa-hand-holding-usd" style="font-size: 24px; text-align:center;color: #FFF;"></i>
                            <p style="margin-top: -15px;text-align:center; font-size:20px;font-weight: bolder; color: #FFF;"> {{convert_price($post->base_price) }}  </p>
                        </div>
                    </div> -->
                    <?php
                        $type = get_term_by('id', $post->home_type);
                        $type_name = $type ? get_translate($type->term_title) : '';
                    ?>
                    <div class="item" style="text-align:center;">
                        <div style="margin-top: -30px;">
                            <i class="fas fa-hotel" style="font-size: 24px; text-align:center;color: #FFF;"></i>
                            <p style="margin-top: -15px;text-align:center; font-size:20px;font-weight: bolder; color: #FFF;"> @if(!empty($type_name)){{$type_name}} @endif </p>
                        </div>
                    </div>
                </div>
            
            </div>
            
        </div>
        <div class="featured-amenities mt-2 mb-2 non-mobile-resp-featured">
            @foreach ($amenities as $amenity)
                <div class="item" style="text-align: center;">
                    <div style="margin-top: -30px;">
                    @if (!$amenity->term_icon)
                        <i class="fe-check" style="color: #115571; font-size: 24px;"></i>
                    @else
                        {!! get_icon($amenity->term_icon, '#115571', '30px', '')  !!}
                    @endif
                        <!-- <i class="ti-location-pin" style="font-size: 24px; text-align:center;color: #FFF;"></i> -->
                        <p style="text-align:center; font-size:20px;font-weight: bolder; color: #334F63;"> {{ get_translate($amenity->term_title) }} </p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row featured-amenities mobile-resp-featured">
            @foreach ($amenities as $amenity)
                <div class="col-4" style="text-align: center;">
                    <div class="item" style="text-align: center;">
                        <div style="margin-top: 20px;">
                        @if (!$amenity->term_icon)
                            <i class="fe-check" style="color: #115571; font-size: 24px;"></i>
                        @else
                            {!! get_icon($amenity->term_icon, '#115571', '30px', '')  !!}
                        @endif
                            <!-- <i class="ti-location-pin" style="font-size: 24px; text-align:center;color: #FFF;"></i> -->
                            <p style="text-align:center; font-size:20px;font-weight: bolder; color: #334F63;"> {{ get_translate($amenity->term_title) }} </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
    <div class="container-fluid mt-5 hh-gallery" style="margin-top: -2rem !important;">
    <h2 class="heading mt-4 mb-4" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;text-transform: uppercase;">{{__('GALLERY')}}</h2>
        <div class="row">
            <div class="col-sm-12 col-md-12">
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
                                                    <a href="javascript:void(0)" class="view-gallery item-link" style="height:calc(50% - 4px);">
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
                                                <div class="col-sm-6 col-12" style="border-radius: 10px;">
                                                    <a href="javascript:void(0)" class="view-gallery item-link">
                                                        <img alt="img_gallery" src="'.get_attachment_url($gallery[3]).'">
                                                    </a>
                                                </div>
                                                <div class="col-sm-6 col-12" style="border-radius: 10px;">
                                                    <a href="javascript:void(0)" class="view-gallery item-link">
                                                        <img alt="img_gallery" src="'.get_attachment_url($gallery[4]).'">
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
            </div>
        </div>
        <div class="container mt-5" style="background: #fff; border-radius:13px; box-shadow: 7px 4px 19px 1px #f7f1f1;">
            <div class="row pr-3 pl-3">
                <div class="col-12 col-sm-7 col-md-7 col-lg-8 col-content" style="padding:0px 40px 0px 20px;">
                    <h2 class="heading mt-4 mb-4" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;text-transform: uppercase;">{{__('ABOUT VILLA')}}</h2>
                    <p class="mb-4" style="font-weight: 300; font-size:16px;">{{ strip_tags(get_translate($post->post_content)) }}</p>   
                    <?php
                    $checkIn = $post->checkin_time;
                    $checkOut = $post->checkout_time;
                    $enableCancellation = $post->enable_cancellation;
                    $enableRules = $post->enable_rules;
                    $rulesOption1 = $post->rules_option1;
                    $rulesOption2 = $post->rules_option2;
                    $rulesDetail1 = $post->rules_detail1;
                    $rulesDetail2 = $post->rules_detail2;
                    $cancelBeforeDay = (int)$post->cancel_before;
                    $cancellationDetail = $post->cancellation_detail;
                    ?>
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
                    <div class="qr-code-render mb-3"><?php getQrCode($post->post_id, 'home')?></div>
                    <div class="mt-5 mb-5" style="clear:both; border-bottom:1px solid #CACACA;"></div>
                    <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;text-transform: uppercase;">{{__('Facilities')}}</h2>
                    <div class="col-6 col-sm-4 col-lg-3">
                    </div>
                    <div class="amenities row">
                        <?php 
                            $facilities = $post->facilities;
                            if(!empty($facilities)){
                                $facilities = (array)json_decode($facilities);
                                foreach ($facilities as $key => $value) {
                                    if(!empty($value)){ ?>
                                            <div class="col-12 col-sm-12 col-lg-12">
                                            <h4 class="mt-2 mb-2" style="font-weight: bold; color: #334F63">{!! balanceTags($key) !!}</h4>
                                            <div data-toggle="ots-tooltip" style="margin-left:50px; margin-bottom: 20px; text-align: left;">
                                                <div class="row">
                                                <?php foreach ($value as $item) { ?>
                                                    <div class="col-12 col-sm-3 col-1g-4" style="padding-right: 30px;">
                                                        <span style="font-weight: 300; display: list-item; font-size:16px;">{{$item}}</span>
                                                    </div>
                                                <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }    
                            }
                        ?>
                    </div>
                    <div class="mt-5 mb-5" style="clear:both; border-bottom:1px solid #CACACA;"></div>
                    <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;text-transform: uppercase;">{{__('DISTANCE')}}</h2>
                    <div class="amenities row">
                        <?php 
                            $distance = $post->distance;
                            if(!empty($distance)){
                                $distance = (array)json_decode($distance);
                                
                                foreach ($distance as $key => $value) {
                                    if(!empty($value)){ ?>
                                        <div class="col-12 col-sm-3 col-1g-4" style="padding-right: 30px;">
                                            <h4 class="mt-2 mb-2"><span style="font-weight: bold; color: #115571">{{$key}}: </span> {{$value}}</h4>
                                        </div>
                                    <?php }
                                }    
                            }
                        ?>
                    </div>
                    <div class="mt-5 mb-5" style="clear:both; border-bottom:1px solid #CACACA;"></div>
                    <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;text-transform: uppercase;">{{__('Avalibilty & Pricing')}}</h2>
                    <div class="table-responsive-sm mb-5">
                        <table class="table" id="price_table_list">
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
                                        <td>@if($special_flag) <p style="color:#f1556c; line-height: 10px;"> Special Offer</p> @endif<p style="@if($special_flag)color:#f1556c; line-height:0px; @else color:#000; @endif ">{{ date('d.m.Y.', $item->start_time) }} </p></td>
                                        <td><p style="color:@if($special_flag)#f1556c; @else #000; @endif">{{ date('d.m.Y.', $item->end_time) }}</p></td>
                                        <td>
                                            @if($special_flag) <p style="color:#000; text-decoration: line-through; line-height: 10px;"> {{convert_price(($base_price)) }}</p> @endif <p style="@if($special_flag)color:#f1556c; line-height:0px;@else color:#000; @endif">@if($special_flag) {{convert_price(($base_price - $special_price)) }} @else {{convert_price($base_price) }} @endif</p></td>
                                        <td>@if($special_flag) <p style="color:#f1556c;"> {{$item->stay_min_date}} </p> @else <p style="color:#000;">{{ $item->stay_min_date }} </p>  @endif</td>
                                        <td>
                                            <p style="color:@if($special_flag)#f1556c; @else #000; @endif">@if($special_flag) {{convert_price(($base_price - $special_price) * 7) }} @else {{convert_price($base_price * 7) }} @endif</p></td>
                                        </td>
                                    </tr>
                                @endforeach
                                <tbody>
                            @endif
                        </table>
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
                            <div class="w-100" style="border-bottom: 1px solid #e2e2e2; padding-bottom: 40px;">{!! balanceTags(get_translate($cancellationDetail)) !!}</div>
                        @endif
                    @endif

                    @if ($enableRules == 'on')
                        @if ($rulesOption1)
                            @if(!empty($rulesDetail1))
                                <div class="w-100" style="padding-top: 40px; border-bottom: 1px solid #e2e2e2; padding-bottom: 40px;">{!! $rulesDetail1 !!}</div>
                            @endif
                        @endif
                        @if ($rulesOption2)
                            @if(!empty($rulesDetail2))
                                <div class="w-100" style="padding-top: 40px; border-bottom: 1px solid #e2e2e2; padding-bottom: 40px;">{!! $rulesDetail2 !!}</div>
                            @endif
                        @endif
                    @endif

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
                    @if($post->gallery_url)
                        <div class="mt-5 mb-5" style="clear:both; border-bottom:1px solid #CACACA;"></div>
                        <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;text-transform: uppercase;">{{__('Show other images')}}</h2>
                        <div class="video-wrapper">
                            <a href="{{$post->gallery_url}}">Show this homes gallery</a>
                        </div>
                    @endif
                    @if($post->video)
                        <div class="mt-5 mb-5" style="clear:both; border-bottom:1px solid #CACACA;"></div>
                        <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;text-transform: uppercase;">{{__('VIDEO')}}</h2>
                        <div class="video-wrapper">
                            {!! balanceTags(get_video_embed_url(get_translate($post->video))) !!}
                        </div>
                    @endif
                    @if($post->tiktok)
                        <div class="mt-5 mb-5" style="clear:both; border-bottom:1px solid #CACACA;"></div>
                        <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;text-transform: uppercase;">{{__('Tik Tok')}}</h2>
                        <div class="video-wrapper">
                            {!! balanceTags($post->tiktok) !!}
                        </div>
                    @endif
                    <div class="mt-5 mb-5" style="clear:both; border-bottom:1px solid #CACACA;"></div>
                    <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;text-transform: uppercase;">{{__('LOCATION')}}</h2>
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
                    <div class="w-100 mt-3"></div>
                   <!--  @if(!empty($video))
                        <div class="clearfix mt-2"> -->
                            <?php 
                            // echo preg_replace("/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe src=\"//www.youtube.com/embed/$2\" allowfullscreen width='100%' height='500'></iframe>",$video); 
                            ?>
                        <!-- </div>
                    @endif -->
                    
                </div>
                <div class="col-12 col-sm-5 col-md-5 col-lg-4 col-sidebar">
                    <?php
                    enqueue_style('daterangepicker-css');
                    enqueue_script('daterangepicker-js');
                    enqueue_script('daterangepicker-lang-js');
                    ?>
                    <?php
                    $booking_form = $post->booking_form;
                    $text_external_link = $post->text_external_link;
                    $external_link = $post->use_external_link;
                    ?>
                    <div id="form-book-home" class="form-book"
                        data-real-price="{{ url('get-home-price-realtime') }}">
                        <!-- <div class="popup-booking-form-close">{!! get_icon('001_close', '#FFFFFF', '28px', '28px') !!}</div>
                        <div class="form-head">
                            <div class="price-wrapper">
                                <span class="price">{{ convert_price($post->base_price) }}</span>
                                @if($post->booking_type != 'external_link')
                                    <span class="unit">/{{$post->unit}}</span>
                                @endif
                            </div>
                        </div> -->
                        <div class="form-body relative">
                            @include('common.loading', ['class' => 'booking-loading'])
                            @if($booking_form == 'instant_enquiry')
                                <ul class="nav nav-tabs nav-bordered row">
                                    <li class="nav-item nav-item-booking-form-instant col">
                                        <a href="#booking-form-instant"
                                        data-toggle="tab"
                                        aria-expanded="false"
                                        class="nav-link @if($booking_form == 'instant_enquiry' ||$booking_form == 'instant') active @endif">
                                            <!-- @if($post->booking_type == 'external_link')
                                                {{ __('External') }}
                                            @else
                                                {{ __('Instant') }}
                                            @endif -->
                                            {{__('BOOKING')}}
                                        </a>
                                    </li>
                                    <li class="nav-item nav-item-booking-form-instant col">
                                        <a href="#booking-form-enquiry"
                                        data-toggle="tab"
                                        aria-expanded="false"
                                        class="nav-link @if($booking_form == 'enquiry') active @endif">
                                            <!-- {{ __('Enquiry') }} -->
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

                        <div class="form-body relative" style="margin-top: 10px; background: #ced4da;">
                            <ul class="nav nav-tabs nav-bordered row" style="padding-bottom:20px;">
                                <li class="nav-item nav-item-booking-form-instant col" style="border-bottom:2px solid #115571; padding:13px; color:#115571">
                                    {{__('PROPERTY AGENT')}}
                                </li>
                                <li class="nav-item nav-item-booking-form-instant col">
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="row">
                                        <div class="col-6 col-sm-6">
                                            <p style="font-weight:700 !important; ">{{sprintf(get_user_by_id($author->getUserId())->first_name )}}</p>
                                            <p style="">Phone: {{sprintf(get_user_by_id($author->getUserId())->mobile )}}</p>
                                            <p style="">E-mail: {{sprintf(get_user_by_id($author->getUserId())->email )}}</p>
                                            <a href="javascript:void(0)"
                                               class="btn btn-contact-host btn-contact-agent d-inline-flex align-items-center button-contact-host-{{ $post->post_type }}"
                                               data-code="{{base64_encode(json_encode($code))}}"
                                               data-action="{{url('messenger/start-message')}}"
                                            >
                                                <span class="d-inline-block">{{sprintf(__('Contact %s'), get_username($author->getUserId()) )}}</span>
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
                    </div>
                </div>
            </div>
            <div class="mt-5 mb-5" style="clear:both; border-bottom:1px solid #CACACA;"></div>
            <div style="padding: 10px 40px;">
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
                    <h2 class="heading mb-5" style="font-size:40px; font-weight:bolder; text-align:center; color: #115571;text-transform: uppercase;">{{__('Homes Near By')}}</h2>
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
                <div class="hosted-author">
                    <div class="media">
                        <img src="{{ get_user_avatar($post->author, [64, 64]) }}" alt="{{ __('User Avatar') }}"
                            class="avatar rounded-circle mr-3">
                        <div class="media-body">
                            <h2 class="heading mt-0 mb-1"><a data-toggle="collapse" href="javascript: ;" role="button" aria-expanded="false" aria-controls="collapseExample">{{sprintf(__('Hosted by %s'), get_username($author->getUserId()) )}}</a></h2>
                            @if(!empty($address) || !empty($location))
                                <p class="location-author d-flex align-items-center">
                                    @if(!empty($address)) {{$address}} @endif
                                    
                                    <span class="d-none d-sm-inline-block"><span class="dot"></span>{{ sprintf(__('Joined in %s'), date(hh_date_format(), strtotime($author->created_at))) }}</span>
                                </p>
                            @endif
                        </div>
                        <div style="flex:2;">
                            <img src="{{asset('images/verified_stamp.jpg')}}" style="width:100px;"></img>
                        </div>
                        
                    </div>
                    <?php do_action('hh_owner_information'); ?>
                    @if(!empty($description))
                        <div class="clearfix mt-2">
                            {!! balanceTags(nl2br($description)) !!}
                        </div>
                    @endif
                    
                </div>
                @if(enable_review())
                    <div class="row">
                        <div class="col-12 col-sm-8 col-md-8 col-lg-9 col-content">
                            @include('frontend.home.review')
                        </div>
                        <div class="col-12 col-sm-8 col-md-8 col-lg-9 col-content">
                            <div class="collapse" id="collapseExample">
                                @include('frontend.home.agent-review')
                            </div>
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
@include('frontend.components.footer')
