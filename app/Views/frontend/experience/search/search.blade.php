@include('frontend.components.header')
<?php
enqueue_style('mapbox-gl-css');
enqueue_style('mapbox-gl-geocoder-css');
enqueue_script('mapbox-gl-js');
enqueue_script('mapbox-gl-geocoder-js');
enqueue_script('search-experience-js');

$showmap = request()->get('showmap', 'yes');
?>
<div class="hh-search-result search-result-experience" data-url="{{ get_experience_search_page()}}" style="background: #F9F9F9;">
    <div class="banner" style="width: 100%; height: 315px;background: #eee url('https://salmaretravel.agency/storage/u-2/2021/11/16/1-3-1637065796.jpg') center center/cover no-repeat;">
    </div>
    @include('frontend.experience.search.search-bar')
    <div class="hh-search-content-wrapper @if($showmap == 'no') no-map @endif mt-5 mb-5">
        <p class="mb-5" style="text-align:center; font-size: 36px; font-weight: bolder;">DISCOVER OUR EXPERIENCE</p>
        @include('common.loading')
        <div class="hh-search-results-render" data-url="{{ get_experience_search_page() }}">
            <div class="render">
                <div class="hh-search-results-string">
                    <span class="item-found">{{__('Searching experience...')}}</span>
                </div>
                <div class="hh-search-content" style="margin:auto">
                    <div class="service-item list">

                    </div>
                </div>
                <div class="hh-search-pagination">

                </div>
            </div>
        </div>
        <div class="hh-search-results-map">
            <?php
            $lat = request()->get('lat');
            $lng = request()->get('lng');
            $zoom = request()->get('zoom', 10);
            $in_map = true;
            ?>
            <div class="hh-mapbox-search" data-lat="{{ $lat }}"
                 data-lng="{{ $lng }}" data-zoom="{{ $zoom }}"></div>
            <div class="hh-close-map-popup" id="hide-map-mobile">{{__('Close')}}</div>
            <div class="hh-map-tooltip">
                <div class="checkbox checkbox-success">
                    <input id="chk-map-move" type="checkbox" name="map_move" value="1">
                    <label for="chk-map-move">{{__('Search as I move the map')}}</label>
                </div>
                @include('common.loading')
            </div>
        </div>
    </div>
</div>
@include('frontend.components.footer')
