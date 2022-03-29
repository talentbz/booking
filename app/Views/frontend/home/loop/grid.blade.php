<div class="hh-service-item home grid" data-plugin="matchHeight">
    <a href="{{ get_the_permalink($item->post_id, $item->post_slug) }}">
        <div class="thumbnail">
            @if($item->is_featured == 'on')
                <div class="is-featured">{{ get_option('featured_text', __('Featured')) }}</div>
            @endif
            <div class="thumbnail-outer">
                <div class="thumbnail-inner">
                    <img src="{{ get_attachment_url($item->thumbnail_id, [650, 550]) }}"
                         alt="{{ get_attachment_alt($item->thumbnail_id ) }}"
                         class="img-fluid">
                </div>
            </div>
            <!-- <div class="author">
                <img src="{{ get_user_avatar($item->author, [45, 45]) }}" alt="{{ get_username($item->author) }}">
            </div> -->
        </div>
    </a>
    <div class="detail">
        <div class="home-grid-title-price">
            <h2 class="title text-overflow" style="text-align: center;">
                <a href="{{ get_home_permalink($item->post_id, $item->post_slug) }}" style="font-size: 20px; font-weight:bolder;">{{ get_translate($item->post_title) }}</a>
            </h2>
            <div style="line-height: 5px;text-align: center;border: 2px solid #115571;padding: 0px 10px;border-radius: 5px;height: 35px;color: #115571; display: flex; align-items: center; margin-top: 15px; justify-content: center;">
                <span class="price" style="font-weight:bold; font-size: 16px;">{{convert_price($item->base_price)}} / Per night</span>
            </div>
        </div>
        
        @if($item->location_address)
            <p class="text-muted text-overflow mb-1"><i class="fe-map-pin mr-1"></i>
                {{ get_short_address($item) }}
                @if(isset($show_distance) && $show_distance && isset($item->distance))
                    <?php
                    $distance = round($item->distance, 2);
                    ?>
                    <strong>({{ $distance }}{{__('km')}})</strong>
                @endif
            </p>
        @endif
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
        <div class="w-100 mt-1"></div>
        <div class="d-flex justify-content-between align-items-center">
            @if(enable_review())
                <div class="rating">
                    <?php
                    $review_number = get_comment_number($item->post_id, 'home');
                    if ($review_number > 0) {
                        echo '<i class="fe-star-on" style="color: #ffdc00;"></i> ';
                        echo '<b>' . esc_attr($item->rating) . '</b> ';
                    }
                    echo '<span>(';
                    echo _n("[0::No reviews][1::%s review][2::%s reviews]", $review_number);
                    echo ')</span>';
                    ?>
                </div>
            @endif
        </div>
    </div>
</div>
