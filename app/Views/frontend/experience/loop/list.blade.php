<div class="hh-service-item home list" data-lng="{{ $item->location_lng }}"
     data-lat="{{ $item->location_lat }}" data-id="{{ $item->post_id }}">
    <div class="item-inner" style="background: #fff;border-radius: 13px;">
        <div class="thumbnail-wrapper">
            @if($item->is_featured == 'on')
                <div class="is-featured">{{ get_option('featured_text', __('Featured')) }}</div>
            @endif
            @if(!empty($item->safe_stay) && $item->safe_stay == 'on')
                <div class="category_safe_stay"><img src={{url('images/svg/safe.svg')}} style="width:150px;height:50px;"></div>
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
                                <a href="{{ get_the_permalink($item->post_id, $item->post_slug, 'experience') }}"
                                   class="carousel-cell">
                                    <img src="{{ get_attachment_url($imageID, [400, 300]) }}"
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
                <a href="{{ get_the_permalink($item->post_id, $item->post_slug, 'experience') }}" class="no-gallery">
                    <img src="{{ placeholder_image([400, 300]) }}" alt="{{ get_translate($item->post_title)  }}"
                         class="img-fluid"/>
                </a>
            @endif
        </div>
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                @if(enable_review())
                    <div class="rating">
                        <?php
                        $review_number = get_comment_number($item->post_id, 'experience');
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
            <div style="display:flex; justify-content:space-between">
                <h3 class="title" style="font-size: 36px;font-weight:bolder; margin-bottom: 5px;">
                    <a href="{{ get_the_permalink($item->post_id, $item->post_slug, 'experience') }}">{{ get_translate($item->post_title) }}</a>
                </h3>
                <div style="display: flex; justify-content: center; align-items:center; text-align: center; border: 2px solid #115571; padding: 5px 10px 4px 10px; border-radius: 5px; color: #115571;min-width: 105px;">
                    <div>
                        <p class="price" style="font-weight:bold; font-size: 18px;margin-bottom: 0px;">{{ convert_price($item->base_price) }}</p>
                    </div>
                </div>
            </div>
            
            <p class="address text-overflow"><i class="fe-map-pin mr-1"></i>{{ get_short_address($item) }}</p>
           
            <div style="border: 1px solid #e2e2e2;margin: 30px 0px 20px 0px;"></div>
            <div id="description" style="font-size: 16px; font-family: google san; color: #808080;">
                {{limitString(get_translate($item->post_description), 500, '...')}}
            </div>
            <div class="meta-footer">
                
            </div>
        </div>
    </div>
</div>
