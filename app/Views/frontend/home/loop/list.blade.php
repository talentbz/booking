<div class="hh-service-item home list" data-lng="{{ $item->location_lng }}"
     data-lat="{{ $item->location_lat }}" data-id="{{ $item->post_id }}">
    <div class="item-inner" style="background: #fff;border-radius: 13px;border: 0.6px solid #e7e7e7;">
        <div class="thumbnail-wrapper">
            @if($item->is_featured == 'on')
                <div class="is-featured">{{ get_option('featured_text', __('Featured')) }}</div>
            @endif
            @if(!empty($item->safe_stay) && $item->safe_stay == 'on')
                <div class="category_safe_stay"><img src={{url('images/svg/safe.svg')}} style="width:150px;height:50px !important;"></div>
            @endif
            @if(!empty($item->gallery))
                <?php
                $galleries = explode(',', $item->gallery);
                $featured_image = $item->thumbnail_id;
                if(!empty($featured_image)){
                    array_unshift($galleries, $featured_image);
                }
                ?>
                <div id="hh-item-carousel-{{ $item->post_id }}" class="hh-item-carousel carousel slide"
                     data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        @foreach ($galleries as $key => $imageID)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <a href="{{ get_the_permalink($item->post_id, $item->post_slug) }}"
                                   class="carousel-cell">
                                    <img src="{{ get_attachment_url($imageID, [600, 400]) }}"
                                         alt="{{ get_translate($item->post_title) }}"/>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#hh-item-carousel-{{ $item->post_id }}" role="button"
                       data-slide="prev">
                        <i class="ti-angle-left"></i>
                        <span class="sr-only">{{__('Previous')}}</span>
                    </a>
                    <a class="carousel-control-next" href="#hh-item-carousel-{{ $item->post_id }}" role="button"
                       data-slide="next">
                        <i class="ti-angle-right"></i>
                        <span class="sr-only">{{__('Next')}}</span>
                    </a>
                </div>
            @else
                <a href="{{ get_the_permalink($item->post_id, $item->post_slug) }}" class="no-gallery">
                    <img src="{{ placeholder_image([600, 400]) }}" alt="{{ get_translate($item->post_title)  }}"
                         class="img-fluid"/>
                </a>
            @endif
        </div>
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                @if(enable_review())
                    <div class="rating">
                        <?php
                        $review_number = get_comment_number($item->post_id, 'home');
                        if ($review_number > 0) {
                            echo '<i class="fe-star-on"></i> ';
                            echo '<b>' . esc_attr($item->rating) . '</b> ';
                        }
                        echo '<span>(';
                        echo _n("[0::No reviews][1::%s review][2::%s reviews]", $review_number);
                        echo ')</span>';
                        ?>
                    </div>
                @endif
            </div>
            <div class="category-title-price">
                <h3 class="title" style="font-size: 36px;font-weight:bolder; margin-bottom: 5px;">
                    <a href="{{ get_the_permalink($item->post_id, $item->post_slug) }}">{{ get_translate($item->post_title) }}</a>
                </h3>
                <div style="display: flex; justify-content: center; align-items:center; text-align: center; border: 2px solid #115571; padding: 5px 10px 4px 10px; border-radius: 5px; color: #115571;min-width: 105px;">
                    <div>
                        <p class="unit" style="font-weight:bolder; font-size: 14px;margin-bottom: 0px;">From</p>
                        <p class="price" style="font-weight:bold; font-size: 18px;margin-bottom: 0px;">{{ convert_price($item->base_price) }}</p>
                    </div>
                </div>
            </div>
            
            <p class="address text-overflow"><i class="fe-map-pin mr-1"></i>{{ get_short_address($item) }}</p>
            <div class="facilities">
                <div class="item max-people" style="font-size: 16px;font-weight:400;">
                    <i class="fas fa-user" style="font-size:18px; color:#115571"></i>{{ _n("[0::%s guests][1::%s guest][2::%s guests]", (int)$item->number_of_guest) }}
                </div>
                <div class="item max-bedrooms" style="font-size: 16px;font-weight:400;">
                    <i class="fas fa-bed" style="font-size:18px; color:#115571"></i>{{ _n("[0::%s bedrooms][1::%s bedroom][2::%s bedrooms]", (int)$item->number_of_bedrooms) }}
                </div>
                <div class="item max-baths" style="font-size: 16px;font-weight:400;">
                    <i class="fas fa-restroom" style="font-size:18px; color:#115571"></i>{{ _n("[0::%s bathrooms][1::%s bathroom][2::%s bathrooms]", (int)$item->number_of_bathrooms) }}
                </div>
            </div>
            <div style="border: 1px solid #e2e2e2;margin: 30px 0px 20px 0px;"></div>
            <div id="description" style="padding-left: 5px; font-size: 16px; font-family: 'Source Serif Pro'; color: #808080;">
                {{limitString(get_translate($item->post_description), 500, '...')}}
            </div>
            <div class="meta-footer extra-button-group">
                <a href="{{ get_the_permalink($item->post_id, $item->post_slug) }}" class="btn meta-footer-btn mt-2">
                    <span class="">More info</span>
                </a>
                <div class="sub-extra-button-group">
                    <a href="javascript:void(0)" class="btn meta-reach-footer-btn mt-2" data-toggle="modal" id="reach-host" data-target="#reach-modal-{{$item->post_id}}" data-id="{{$item->post_id}}">
                        <span class="d-inline-block">Reach your host</span>
                    </a>
                    <!-- <a href="javascript:void(0)" class="btn meta-footer-btn" data-toggle="modal" id="book-now" data-target="#book-modal-{{$item->post_id}}" data-id="{{$item->post_id}}">
                        <span class="d-inline-block">Book now</span>
                    </a> -->
                    <a href="{{ get_the_permalink($item->post_id, $item->post_slug) }}" class="btn meta-book-footer-btn mt-2">
                        <span class="d-inline-block">Book now</span>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</div>
<div id="reach-modal-{{$item->post_id}}" class="modal fade modal-no-footer" tabindex="-1" role="dialog"
         aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase">{{__('Send inquiry')}}</h4>
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
                    <input type="hidden" name="post_id" value="{{ $item->post_id }}">
                    <input type="hidden" name="post_encrypt"
                        value="{{ hh_encrypt($item->post_id) }}">
                    <div class="form-message"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="book-modal-{{$item->post_id}}" class="modal fade modal-no-footer" tabindex="-1" role="dialog"
         aria-hidden="true">
    <?php
    enqueue_style('daterangepicker-css');
    enqueue_script('daterangepicker-js');
    enqueue_script('daterangepicker-lang-js');
    ?>
    <?php
    $booking_form = $item->booking_form;
    $text_external_link = $item->text_external_link;
    $external_link = $item->use_external_link;
    ?>
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase">{{__('Send inquiry')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <form class="form-action" action="{{ url('add-to-cart-home') }}" method="post"data-loading-from=".form-body" data-validation-id="form-add-cart">
                    @if($item->booking_type == 'per_night')
                        <div class="form-group">
                            <div class="date-wrapper date-double"
                                 data-date-format="{{ hh_date_format_moment() }}"
                                 data-action="{{ url('get-home-availability-single') }}" style="border: 0px;">
                                <input type="text" class="input-hidden check-in-out-field"
                                       name="checkInOut" data-home-id="{{ $item->post_id }}"
                                       data-home-encrypt="{{ hh_encrypt($item->post_id) }}">
                                <input type="text" class="input-hidden check-in-field"
                                       name="checkIn">
                                <input type="text" class="input-hidden check-out-field"
                                       name="checkOut">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="checkinout" style="font-size: 18px; font-weight: bolder;">{{ __('Check-in') }}</label>
                                        <p class="check-in-render" style="width:100%; border: 1px solid #e2e2e2; border-radius: 5px;"
                                        data-date-format="DD.MM.YYYY."></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="checkinout" style="font-size: 18px; font-weight: bolder;">{{ __('Check-out') }}</label>
                                        <p class="check-out-render" style="width:100%; border: 1px solid #e2e2e2; border-radius: 5px;"
                                        data-date-format="DD.MM.YYYY."></p>
                                    </div>
                                </div>
                                
                                <!-- <span class="divider"></span> -->
                                
                            </div>
                        </div>
                    @elseif($item->booking_type == 'per_hour')
                        <div class="form-group">
                            <label for="checkinout">{{__('Check In')}}</label>
                            <div class="date-wrapper date-single"
                                 data-date-format="{{ hh_date_format_moment() }}"
                                 data-action-time="{{ url('get-home-availability-time-single') }}"
                                 data-action="{{ url('get-home-availability-single') }}">
                                <input type="text"
                                       class="input-hidden check-in-out-single-field"
                                       name="checkInOut" data-home-id="{{ $item->post_id }}"
                                       data-home-encrypt="{{ hh_encrypt($item->post_id) }}">
                                <input type="text" class="input-hidden check-in-field"
                                       name="checkIn">
                                <input type="text" class="input-hidden check-out-field"
                                       name="checkOut">
                                <span class="check-in-render"
                                      data-date-format="{{ hh_date_format_moment() }}"></span>
                            </div>
                        </div>
                        <div class="form-group form-group-date-time d-none">
                            <label>{{ __('Time') }}</label>
                            <div class="date-wrapper date-time">
                                <div class="date-render check-in-render"
                                     data-time-format="{{ hh_time_format() }}">
                                    <div class="render">{{__('Start Time')}}</div>
                                    <div class="dropdown-time">

                                    </div>
                                    <input type="hidden" name="startTime" value=""
                                           class="input-checkin"/>
                                </div>
                                <span class="divider"></span>
                                <div class="date-render check-out-render"
                                     data-time-format="{{ hh_time_format() }}">
                                    <div class="render">{{__('End Time')}}</div>
                                    <div class="dropdown-time">

                                    </div>
                                    <input type="hidden" name="endTime" value=""
                                           class="input-checkin"/>
                                </div>
                            </div>
                        </div>
                    @endif
                    <?php
                    $max_guest = (int)$item->number_of_guest;
                    ?>
                    <div class="form-group">
                        <label for="guest" style="font-size: 18px; font-weight: bolder;">{{__('Guests')}}</label>
                        <div
                            class="guest-group @if($item->enable_extra_guest == 'on') has-extra-guest @endif">
                            <button type="button" class="btn btn-light dropdown-toggle"
                                    data-toggle="dropdown"
                                    data-text-guest="{{__('Guest')}}"
                                    data-text-guests="{{__('Guests')}}"
                                    data-text-infant="{{__('Infant')}}"
                                    data-text-infants="{{__('Infants')}}"
                                    aria-haspopup="true" aria-expanded="false">
                                &nbsp;
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="group">
                                    <span class="pull-left">{{__('Adults')}}</span>
                                    <div class="control-item">
                                        <i class="decrease ti-minus"></i>
                                        <input type="number" min="1" step="1"
                                            max="{{ $max_guest }}"
                                            name="num_adults"
                                            value="1">
                                        <i class="increase ti-plus"></i>
                                    </div>
                                </div>
                                <div class="group">
                                    <span class="pull-left">{{__('Children')}}</span>
                                    <div class="control-item">
                                        <i class="decrease ti-minus"></i>
                                        <input type="number" min="0" step="1"
                                            max="{{ $max_guest }}"
                                            name="num_children"
                                            value="0">
                                        <i class="increase ti-plus"></i>
                                    </div>
                                </div>
                                <div class="group">
                                    <span class="pull-left">{{__('Infants')}}</span>
                                    <div class="control-item">
                                        <i class="decrease ti-minus"></i>
                                        <input type="number" min="0" step="1"
                                            max="{{ $max_guest }}"
                                            name="num_infants"
                                            value="0">
                                        <i class="increase ti-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group form-render">
                    </div>
                    <div class="form-group mt-2">
                        <input type="hidden" name="homeID" value="{{ $item->post_id }}">
                        <input type="hidden" name="homeEncrypt"
                               value="{{ hh_encrypt($item->post_id) }}">
                        <input type="submit" class="btn btn-primary btn-block text-uppercase" style="font-size: 18px; background: #115571; border: 0px; margin-top: 18px;"
                               name="sm"
                               value="{{__('Book Now')}}">
                    </div>
                    <div class="form-message"></div>
                </form>
            </div>
        </div>
    </div>
</div>
