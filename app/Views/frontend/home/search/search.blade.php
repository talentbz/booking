@include('frontend.components.header')
<?php
enqueue_style('mapbox-gl-css');
enqueue_style('mapbox-gl-geocoder-css');
enqueue_script('mapbox-gl-js');
enqueue_script('mapbox-gl-geocoder-js');
enqueue_script('search-home-js');

$showmap = request()->get('showmap', 'yes');
?>
<style>
    .slimScrollBar {
        background: #115571 !important;
        opacity: 0.8 !important;
    }
    @media(max-width: 679px) {
        .awe-booking .hh-search-result .hh-search-content-wrapper.no-map .hh-search-results-render .hh-search-content .hh-service-item.list .item-inner .thumbnail-wrapper img {
            height: calc(100vw / 1.7) !important;
        }
    }
</style>
<div class="hh-search-result" data-url="{{ get_home_search_page()}}" style="background: #F9F9F9;">
    <div class="banner" style="width: 100%; height: 110px;">
    </div>
    @include('frontend.home.search.search_bar')
    <div class="hh-search-content-wrapper no-map mt-5 mb-5">
        <p class="mb-5" style="text-align:center; font-size: 36px; font-weight: bolder;">Discover our Villas</p>
        @include('common.loading')
        <div class="hh-search-results-render" data-url="{{ get_home_search_page() }}">
            <div class="render">
                <div class="hh-search-results-string">
                    <span class="item-found">{{__('Searching home...')}}</span>
                </div>
                <div class="hh-search-content">
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
