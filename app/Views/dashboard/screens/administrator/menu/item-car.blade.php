@if(is_enable_service('car'))
    <div class="hh-add-menu-box overflow-hidden">
        <h5 class="title d-flex align-items-center justify-content-between">{{__('Car')}} <i
                class="fe-chevron-down"></i></h5>
        <div class="menu-content-wrapper">
            <div class="content">
                <?php
                $all_posts = get_all_posts('car');
                if($all_posts['total'] > 0){
                foreach ($all_posts['results'] as $k => $item){
                ?>
                <div class="checkbox  checkbox-success mb-2">
                    <input type="checkbox"
                           class="hh-add-menu-item"
                           name="menu_item[]"
                           value="{{ $item->post_id }}"
                           data-id="{{ $item->post_id  }}"
                           data-url="{{ get_car_permalink($item->post_id, $item->post_slug)  }}"
                           data-type="car"
                           data-name="{{ get_translate($item->post_title) }}"
                           id="menu_item_car_{{ $item->post_id  }}"/>
                    <label for="menu_item_car_{{ $item->post_id  }}">{{ get_translate($item->post_title) }}</label>
                </div>
                <?php
                }
                }else {
                    echo __('No car found');
                }
                ?>
            </div>
            @if($all_posts['total'] > 0)
                <a href="#" class="btn btn-success btn-sm mt-2 right hh-btn-add-menu-item">{{__('Add to menu')}}</a>
            @endif
        </div>
    </div>
@endif
