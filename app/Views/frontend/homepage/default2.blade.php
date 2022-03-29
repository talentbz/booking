@include('frontend.components.header')
<?php
enqueue_style('home-slider');
enqueue_script('home-slider');

enqueue_style('mapbox-gl-css');
enqueue_style('mapbox-gl-geocoder-css');
enqueue_script('mapbox-gl-js');
enqueue_script('mapbox-gl-geocoder-js');

enqueue_style('daterangepicker-css');
enqueue_script('daterangepicker-js');
enqueue_script('daterangepicker-lang-js');

enqueue_style('iconrange-slider');
enqueue_script('iconrange-slider');

enqueue_script('owl-carousel');
enqueue_style('owl-carousel');
enqueue_style('owl-carousel-theme');

enqueue_script('checkout-js');

$tab_services = get_option('sort_search_form', convert_tab_service_to_list_item());
?>
<style>
    .dropdown-item.active, .dropdown-item:active{
        background-color: #115571;
        color: #fff;
    }
    .daterangepicker.dropdown-menu {
        z-index: 1000000000 !important;
    }
#carousel_1 {
  position: relative;
  height: 550px;
  overflow: hidden;
}
#carousel_1 div {
  position: absolute;
  transition: transform 1s, left 1s, opacity 1s, z-index 0s;
  opacity: 1;
}
#carousel_1 div img {
    width: 100%;
    height: 100%;
    transition: width 1s;
    border-radius: 13px;
}
#carousel_1 div.hideLeft {
  left: 0%;
  opacity: 0;
  transform: translateY(50%) translateX(-50%);
}
#carousel_1 div.hideLeft img {
  width: 100%;
}
#carousel_1 div.hideRight {
  left: 100%;
  opacity: 0;
  transform: translateY(50%) translateX(-50%);
}
#carousel_1 div.hideRight img {
  width: 100%;
}
#carousel_1 div.prev {
  z-index: 5;
  left: -3%;
  transform: translateY(52px) translateX(-50%);
  opacity: 0.8;
  height: 438px;
  width: 50%;
}
#carousel_1 div.prev img {
    width: 100%;
    height: 100%;
}

#carousel_1 div.prevLeftSecond {
  z-index: 4;
  left: 15%;
  transform: translateY(50%) translateX(-50%);
  opacity: 0.7;
  display: none;
}
#carousel_1 div.prevLeftSecond img {
  width: 100%;
}
#carousel_1 div.selected {
  z-index: 10;
  left: 50%;
  transform: translateY(0px) translateX(-50%);
  width: 50%;
  height: 540px;
}
#carousel_1 div.next {
    z-index: 5;
    left: 103%;
    transform: translateY(52px) translateX(-50%);
    opacity: 0.8;
    height: 438px;
    width: 50%;
}
#carousel_1 div.next img {
    width: 100%;
    height: 100%;
}
#carousel_1 div.nextRightSecond {
  z-index: 4;
  left: 85%;
  transform: translateY(50%) translateX(-50%);
  opacity: 0.7;
  display: none;
}
#carousel_1 div.nextRightSecond img {
  width: 300px;
}
.buttons {
    bottom: 10px;
    display: flex;
    justify-content: center;
}
.slider {
  position: relative;
  height: 700px;
  overflow: hidden;
  background: #fff;
}
.slider > ul {
  position: relative;
  list-style: none;
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  display: flex;
  transform: translateX(-33.3333333333%);
}

.slider > ul > li {
    position: relative;
    width: 31%;
    height: 100%;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 300px;
    flex-shrink: 0;
    padding: 0px 30px;
    border-radius: 13px;
    left: -180px;
}

.slider > ul > li > div {
    width: 100%;
    height: 100%;
}

.slider > ul > li > div > img {
  width: 100%;
  height: 100%;
  border-radius: 13px;
}

.slider-nav .prev,
.slider-nav .next {
  position: absolute;
  background: slategrey;
  height: 40px;
  width: 40px;
  top: 50%;
  transform: translateY(-50%);
}

.transition {
  transition: transform 0.5s ease;
}

.left1 {
  transform: translateX(-100%);
}

.right1 {
  transform: translateX(100%);
}


.gallery {
  width: 100%;
}

.gallery-container {
  align-items: center;
  display: flex;
  height: 550px;
  margin: 0 auto;
  position: relative;
}

.gallery-item {
  height: 150px;
  opacity: 0;
  position: absolute;
  transition: all 0.3s ease-in-out;
  width: 150px;
  z-index: 0;
}

.gallery-item-1 {
  left: 15%;
  opacity: .4;
  transform: translateX(-50%);
  display: none;
}

.gallery-item-2,
.gallery-item-4 {
    height: 438px;
    opacity: 1;
    width: 50%;
    z-index: 1;
    top: 56px;
    border-radius: 13px;
    opacity: 0.8;
}

.gallery-item-2 {
  left: -3%;
  transform: translateX(-50%);
}

.gallery-item-3 {
  box-shadow: 0 0 30px rgba(255, 255, 255, 0.6), 0 0 60px rgba(255, 255, 255, 0.45), 0 0 110px rgba(255, 255, 255, 0.25), 0 0 100px rgba(255, 255, 255, 0.1);
  height: 540px;
  opacity: 1;
  left: 50%;
  transform: translateX(-50%);
  width: 50%;
  z-index: 2;
  border-radius: 13px;
}

.gallery-item-4 {
  left: 103%;
  transform: translateX(-50%);
}

@media(max-width: 880px) {
    .gallery-item-2, .gallery-item-4 {
      display: none;
    }
    .gallery-item-3 {
      width: 100%;
      left: 0;
      height: calc(100vw / 1.7);
      transform: translateX(0);
    }
    #carousel_1 div.selected {
      z-index: 10;
      left: 0px important;
      width: 100%;
      height: calc(100vw / 1.7);
    }
    #carousel_1 div.prev {
      display: none;
    }
    #carousel_1 div.next {
      display: none;
    }
    .gallery-container {
      height: calc(100vw / 1.5);
    }
    #carousel_1 {
      height: calc(100vw / 1.5);
    }
}

@media(max-width: 325px) {
  #carousel_1 div.selected {
    height: 200px;
  }
  .gallery-item-3 {
    height: 200px;
  }
  .gallery-container {
    height: 200px;
  }
}

.gallery-item-5 {
  left: 85%;
  opacity: .4;
  transform: translateX(-50%);
  display: none;
}

.gallery-controls {
  display: flex;
  justify-content: center;
  margin: 30px 0;
}

.gallery-controls button {
  background-color: transparent;
  border: 0;
  cursor: pointer;
  font-size: 16px;
  margin: 0 20px;
  padding: 0 12px;
  text-transform: capitalize;
}

.gallery-controls button:focus {
  outline: none;
}

.gallery-controls-previous::before {
  border: solid #000;
  border-width: 0 2px 2px 0;
  content: '';
  display: inline-block;
  height: 4px;
  left: -10px;
  padding: 2px;
  position: absolute;
  top: 0;
  transform: rotate(135deg) translateY(-50%);
  transition: left 0.15s ease-in-out;
  width: 4px;
}

.gallery-controls-previous:hover::before {
  left: -18px;
}

.gallery-controls-next::before {
  border: solid #000;
  border-width: 0 2px 2px 0;
  content: '';
  display: inline-block;
  height: 4px;
  padding: 2px;
  position: absolute;
  right: -10px;
  top: 50%;
  transform: rotate(-45deg) translateY(-50%);
  transition: right 0.15s ease-in-out;
  width: 4px;
}

.gallery-controls-next:hover::before {
  right: -18px;
}

.gallery-nav {
  bottom: -15px;
  display: flex;
  justify-content: center;
  list-style: none;
  padding: 0;
  position: absolute;
  width: 100%;
}

.gallery-nav li {
  background: #ccc;
  border-radius: 50%;
  height: 10px;
  margin: 0 16px;
  width: 10px;
}

.gallery-nav li.gallery-item-selected {
  background: #555;
}

.nav-link.active {
    color: #fffcfc;
    background: #115571;
    border-radius: 50px;
}

.our_guest {
  padding: 0px 110px;
}

@media(max-width: 880px){
  .our_guest {
    padding: 0px 0px;
  }
}

.number_cal {
  font-size: 48px;
  color: #115571; 
  font-weight: bolder;
}

.sub_number_cal {
  color: rgba(127,127,127,1); 
  font-size: 20px; 
  font-weight: bolder;
}

.introduction_home {
  background: #fff;
  box-shadow: 7px 4px 19px 1px #f7f1f1;
  border-radius: 10px; 
  width:80%;
}

@media(max-width: 880px) {
  .number_cal {
    font-size: 30px;
  }
  .sub_number_cal {
    font-size: 15px; 
  }
  .introduction_home {
    width:100%;
  }
  .read-more {
    width: 150px;
    font-size: 15px;
  }
}

#myTab .nav-item .nav-link {
    font-size: 20px;
}

#demo {
  width:100%; 
  height:750px;
}

#demo .carousel-item img {
  height: 750px; 
  width: 100%; 
  background-image: ;
  background-size: cover;
}

#start_date_display {
  display: flex; 
  justify-content: center; 
  font-size:20px; 
  color: #115571;
}

#search_guest_option {
  display: flex; 
  justify-content: center; 
  font-size: 20px; 
  color: #115571;
  border: 0px;
  margin-top: -13px;
  font-weight: 300;
}

#end_date_display {
   display: flex; 
   justify-content: center; 
   font-size:20px; 
   color: #115571;
}

.introduction_home img {
  border-radius: 20px; 
  width:100%; 
  height:400px;
}

.category_view {
  display:flex; 
  justify-content: space-between;
} 
 
  .box-part {
    background: #FFF;
    border-radius: 0;
    padding: 15px 20px;
    margin: 10px 0px;
    min-height:235px;
    border-radius: 5px;
    border-radius: 5;
    moz-box-shadow: 0 5px 2px rgb(0 0 0 / 1%);
    -webkit-box-shadow: 0 5px 2px rgb(0 0 0 / 1%);
    box-shadow: 0 5px 2px rgb(0 0 0 / 1%); 
}
.box-part .text{
    text-align: left;
    line-height: 25px; 
    font-size: 16px;
    color: rgba(127,127,127,1);
    margin-top: 18px;

}
.box-part img {
    display: inline-block;
    text-align: left;
    float: left;
}
.box-part .title{
     display: inline-block;
}

@media(max-width: 570px) {
  #myTab .nav-item .nav-link {
      font-size: 15px;
  }
  #demo {
    width:100%; 
    height:488px;
  }
  #demo .carousel-item img {
    height: 488px; 
  }
  #date_advanced span {
    margin-top: 5px;
    font-size: 10px;
  }
  #date_advanced i {
    font-size: 12px;
  }
  #start_date_display {
    margin-top: 7px;
    font-size: 15px;
  }
  #end_date_display {
    margin-top: 7px;
    font-size: 15px;
  }
  #search_guest_option {
    margin-top: -7px;
    font-size: 15px;
  }
  #date_advanced .fa-sort-down {
    margin-top: 5px;
  }
  .introduction_home img{
    height: 300px;
  }
  #myTab {
    flex-direction: column!important;
  }
  #myTab .nav-item {
    padding: 10px;
    width: 100%;
  }
  .category_view {
    display: contents;
  }
  .attachment-full {
    height: 100% !important;
  }
  .safe_stay img{
    width: 150px;
  }
}
@media(max-width: 766px) {
  .category_item {
    margin-top: 10px;
  }
}
@media(max-width: 576px) {
  .is-featured {
    font-size: 18px;
  }
  .gallery-facility {
    font-size: 12px;
  }
  .gallery-price {
    font-size: 12px;
  }
  .gallery-price1 {
    font-size: 12px;
  }
}
</style>

<div class="home-page" style="background:#f9f9f9;">
    @if(!empty($tab_services))
        <div class="hh-search-form-wrapper pr-3 pl-3">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="row" style="background: #fff;">
                        <div id="story_talk" class="col-sm-12 col-md-12" style="padding: 120px 150px 0px 100px;">
                            <p style="color: #115571;">Welcome to Luxury Croatia Retreats</p>
                            <?php $blog_title = get_option('blog_title');
                            $blog_content = get_option('blog_content');
                            ?>
                            <h1 style="font-size: 65px; font-weight: bold; line-height: 70px;">{{get_translate($blog_title)}}</h1>
                            <div class="mt-5">
                                <p style="color: #808080; font-size: 16px;line-height: 20px;">{{get_translate($blog_content)}}</p>
                            </div>
                        </div>
                        <div id="date_advanced" class="col-sm-12 col-md-12 mt-5" style="padding-left: 150px;">
                            <div class="row mb-5 pb-2" style="box-shadow: 0px 18px 17px -3px #edebeb;">
                                <div class="col-4 col-sm-4 col-md-4" style="border-right:1px solid #a39e9e; cursor: pointer;" id="start_range_date">
                                    <div style="display: flex; justify-content: center;font-color: #808080;">
                                        <i class="far fa-calendar-alt mr-2 pt-1"></i><span>Check in</span><i class="fas fa-sort-down ml-2"></i>
                                    </div>
                                    <div style="" id="start_date_display">
                                        22/07/2022
                                    </div>
                                </div>
                                <input type="hidden" id="start_checkin">
                                <div class="col-4 col-sm-4 col-md-4" style="border-right:1px solid #a39e9e; cursor: pointer;" id="end_range_date">
                                    <div style="display: flex; justify-content: center;font-color: #808080;">
                                        <i class="far fa-calendar-alt mr-2 pt-1"></i><span>Check out</span><i class="fas fa-sort-down ml-2"></i>
                                    </div>
                                    <div id="end_date_display">
                                        22/07/2022
                                    </div>
                                </div>
                                <input type="hidden" id="end_checkout">
                                <div class="col-4 col-sm-4 col-md-4 guest-group">
                                    <div style="display: flex; justify-content: center;font-color: #808080; cursor:pointer;" data-toggle="dropdown">
                                        <i class="fas fa-user-alt mr-2 pt-1"></i><span>Guest</span><i class="fas fa-sort-down ml-2"></i>
                                    </div>
                                    <div class="btn btn-light dropdown-toggle" id="search_guest_option" data-text-guest="{{__('Guest')}}"
                                            data-text-guests="{{__('Guests')}}"
                                            data-text-infant="{{__('Infant')}}"
                                            data-text-infants="{{__('Infants')}}">
                                        0 Guests
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="group">
                                            <span class="pull-left">{{__('Adults')}}</span>
                                            <div class="control-item">
                                                <i class="decrease ti-minus"></i>
                                                <input type="number" min="1" step="1" max="15" id="num_adults" name="num_adults" value="1">
                                                <i class="increase ti-plus"></i>
                                            </div>
                                        </div>
                                        <div class="group">
                                            <span class="pull-left">{{__('Children')}}</span>
                                            <div class="control-item">
                                                <i class="decrease ti-minus"></i>
                                                <input type="number" min="0" step="1" max="15" name="num_children" id="num_children" 
                                                    value="0">
                                                <i class="increase ti-plus"></i>
                                            </div>
                                        </div>
                                        <div class="group">
                                            <span class="pull-left">{{__('Infants')}}</span>
                                            <div class="control-item">
                                                <i class="decrease ti-minus"></i>
                                                <input type="number" min="0" step="1" max="10" name="num_infants" id="num_infants" value="0">
                                                <i class="increase ti-plus"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" id="checkinoutfield" style="width: 100%; visibility: hidden; margin-top: -30px;"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div id="demo" class="carousel slide" data-ride="carousel">
                        <div class="advanced_search" onclick="javascript:searchFunc();">
                            <div style="width:100%; font-size: 25px; color: #fff; line-height: 15px;">
                                <p style="text-align:center">Search</p>
                            </div>
                        </div>
                        <form id="searchForm" action="{{ get_home_search_page() }}" method="get">
                            <input type="hidden" id="request_checkIn" name="checkIn"/>
                            <input type="hidden" id="request_checkOut" name="checkOut"/>
                            <input type="hidden" id="num_adults1" name="num_adults"/>
                            <input type="hidden" id="num_children1" name="num_children"/>
                            <input type="hidden" id="num_infants1" name="num_infants"/>
                        </form>
                        <a class="advanced_search_bellow" href="javascript:;" data-toggle="modal" data-target="#myModal">
                          <span>Advanced Search</span>
                        </a>
                        <div class="carousel-inner" style="border-bottom-left-radius: 55px;">
                            <?php
                            $sliders = get_option('home_slider');
                            $sliders = explode(',', $sliders);
                            ?>
                            @if(!empty($sliders) && is_array($sliders))
                                @foreach($sliders as $index=>$id)
                                    <?php
                                    $url = get_attachment_url($id);
                                    ?>
                                    <div class="carousel-item @if ($index==0)active @endif ">
                                        <img src="{{ $url }}" alt="Los Angeles">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
                
        </div>
    @endif
    
    <div class="container">
        <div class="row pt-5 pb-5">
            <div class="col-12 col-sm-4 col-md-4" style="text-align:center; line-height: 30px;">  
                	<div class="box-part text-center"> 
                        <img src="{{url('images/superp-support.png')}}" />
						<div class="title">
							<h4>SUPER SUPPORT</h4>
						</div> 
						<div class="text">
						<p class="">Through the app of Luxury Croatia Retreats from the moment of your booking and your vacation in Croatia, your assigned agent is available for all questions.</p>
						</div> 
					 </div>
            </div>
            <div class="col-12 col-sm-4 col-md-4" style="text-align:center; line-height: 30px;">
               <div class="box-part text-center"> 
                        <img src="{{url('images/verification-of-villa.png')}}" /> 
						<div class="title">
							<h4>VERIFICATION OF VILLA</h4>
						</div> 
						<div class="text">
						<p class="">Every accommodation at Luxury Croatia Retreats has been verified and approved to meet your expectations.</p>
						</div> 
					 </div>
            </div>
            <div class="col-12 col-sm-4 col-md-4" style="text-align:center; line-height: 30px;">
                <div class="box-part text-center"> 
                        <img src="{{url('images/safe-booking.png')}}" /> 
						<div class="title">
							<h4>SAFE BOOKING</h4>
						</div> 
						<div class="text">
						<p class="">Luxury Croatia Retreats offer 100% security. If the villa chosen by the guest is significantly different than on the Luxury Croatia Retreats website, the guest is entitled to a full refund.</p>
						</div> 
					 </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12" style="display:flex; justify-content: center;">
                <div class="row mt-5 pb-3 introduction_home">
                    <div class="col-12 col-sm-12 col-md-6" style="margin-top:-70px; display:flex; justify-content: center;">
                        <img src="{{url('images/dashboard_1.jpg')}}" style=""></img>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6" style="display:flex; align-items:center;padding: 0px 40px;">
                        <div>
                            <?php $sub_blog_title = get_option('sub_blog_title');
                            $sub_blog_content = get_option('sub_blog_content');
                            ?>
                            <h2 style="font-size:44px;color: #000;">{{get_translate($sub_blog_title)}}</h2>
                            <p style="font-size: 16px; color: rgba(127,127,127,1);">
                            {{get_translate($sub_blog_content)}}
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-5" style="background: #e2e2e2;padding: 15px; border-radius: 15px;">
            <ul class="nav" id="myTab" role="tablist">
                <li class="nav-item mr-2">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Featured</a>
                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">First-Minute</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Last-Minute</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content mt-3" id="myTabContent">
        
        <div class="tab-pane container-fluid fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="mr-5 mb-5" style="text-align: right;">
                <a href="{{url('home-search-result?is_featured=on')}}" class="read-more" style="color: #115571;font-size: 20px;">{{__('See More')}} {!! balanceTags(get_icon('002_right_arrow', '#115571', '24px', '')) !!}</a>
            </div>
            <?php 
                $featuredHomes = \App\Controllers\Services\HomeController::get_inst()->listOfHomes($data = array('is_featured'=>'on', 'number'=> 6));
            ?>
                @if($featuredHomes['total'] > 0)
                    @if($featuredHomes['total'] >= 4) 
                        <div class="gallery">
                            <div class="gallery-container" id="featured_list_gallery">
                            @foreach($featuredHomes['results'] as $key => $value)
                                        <div class="gallery-item gallery-item-{{$key + 1}}">
                                            <div class="is-featured">Featured</div>
                                            @if(!empty($value->safe_stay) && $value->safe_stay == 'on')
                                            <div class="safe_stay"><img src={{url('images/svg/safe.svg')}} style="width:200px;"></div>
                                            @endif
                                            <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                                <img style="width:100%; height: 100%;border-radius: 13px;" src="{{$value->media_url}}" data-index="{{$key + 1}}">
                                            </a>
                                            <figcaption class="carsuel-effect1">
                                                <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                                    <p class="gallery-title">{{get_translate($value->post_title)}}</p>
                                                </a>
                                                <div style="display:flex; justify-content: space-between; position: relative;">
                                                    <div class="gallery-facility">
                                                        <div class="mr-3" style="position: relative;">
                                                            <i class="fas fa-bed"></i> <span>{{$value->number_of_bedrooms}}</span>
                                                        </div>
                                                        <div class="mr-3" style="position: relative;">
                                                            <i class="fas fa-user"></i> <span>{{$value->number_of_guest}}</span>
                                                        </div>
                                                        <div style="position: relative;">
                                                            <i class="fas fa-city"></i> <span>{{get_translate($value->location_city)}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="gallery-price1">{{convert_price($value->base_price)}} / night</div>
                                                </div>
                                            </figcaption>
                                        </div>
                            @endforeach
                            </div>
                            <div class="buttons mt-3" id="galler_buttons">
                                <a href="javascript:void(0)" class="gallery-controls-previous"><i class="fal fa-long-arrow-left mr-3" style="font-size: 30px; color: #D9BA7A"></i></a>
                                <a href="javascript:void(0)" class="gallery-controls-next"><i class="fal fa-long-arrow-right" style="font-size: 30px; color: #D9BA7A"></i></a>
                            </div>
                        </div>
                    @elseif($featuredHomes['total'] == 3) 
                        <div class="gallery">
                            <div class="gallery-container" id="featured_list_gallery">
                            @foreach($featuredHomes['results'] as $key => $value)
                                        <div class="gallery-item gallery-item-{{$key + 2}}">
                                            <div class="is-featured">Featured</div>
                                            @if(!empty($value->safe_stay) && $value->safe_stay == 'on')
                                            <div class="safe_stay"><img src={{url('images/svg/safe.svg')}} style="width:200px;"></div>
                                            @endif
                                            <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                                <img style="width:100%; height: 100%;border-radius: 13px;" src="{{$value->media_url}}" data-index="{{$key + 2}}">
                                            </a>
                                            <figcaption class="carsuel-effect1">
                                                <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                                    <p class="gallery-title">{{get_translate($value->post_title)}}</p>
                                                </a>
                                                <div style="display:flex; justify-content: space-between; position: relative;">
                                                    <div class="gallery-facility">
                                                        <div class="mr-3" style="position: relative;">
                                                            <i class="fas fa-bed"></i> <span>{{$value->number_of_bedrooms}}</span>
                                                        </div>
                                                        <div class="mr-3" style="position: relative;">
                                                            <i class="fas fa-user"></i> <span>{{$value->number_of_guest}}</span>
                                                        </div>
                                                        <div style="position: relative;">
                                                            <i class="fas fa-city"></i> <span>{{get_translate($value->location_city)}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="gallery-price1">{{convert_price($value->base_price)}} / night</div>
                                                </div>
                                            </figcaption>
                                        </div>
                            @endforeach
                            </div>
                            <div class="buttons mt-3" id="galler_buttons">
                                <a href="javascript:void(0)" class="gallery-controls-previous"><i class="fal fa-long-arrow-left mr-3" style="font-size: 30px; color: #D9BA7A"></i></a>
                                <a href="javascript:void(0)" class="gallery-controls-next"><i class="fal fa-long-arrow-right" style="font-size: 30px; color: #D9BA7A"></i></a>
                            </div>
                        </div>
                    @else
                        <div id="carousel_1">
                            @foreach($featuredHomes['results'] as $key => $value)
                                <div class="@if($key == 0) selected @elseif($key == 1) next @elseif($key == 2) nextRightSecond @else hideRight @endif">
                                    <div class="is-featured">Featured</div>
                                    <img src="{{$value->media_url}}">
                                    <figcaption class="carsuel-effect">
                                        <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                            <p style="color: #fff;">{{get_translate($value->post_title)}}</p>
                                        </a>
                                        <div style="display:flex; justify-content: space-between; position: relative;">
                                            <div class="gallery-facility">
                                                <div class="mr-3" style="position: relative;">
                                                    <i class="fas fa-bed"></i> <span>{{$value->number_of_bedrooms}}</span>
                                                </div>
                                                <div class="mr-3" style="position: relative;">
                                                    <i class="fas fa-user"></i> <span>{{$value->number_of_guest}}</span>
                                                </div>
                                                <div style="position: relative;">
                                                    <i class="fas fa-city"></i> <span>{{get_translate($value->location_city)}}</span>
                                                </div>
                                            </div>
                                            <div class="gallery-price">{{convert_price($value->base_price)}} / night</div>
                                        </div>
                                    </figcaption>
                                </div>
                            @endforeach
                        </div>
                        <div class="buttons mt-3">
                            <a href="javascript:void(0)" class="prev1"><i class="fal fa-long-arrow-left mr-3" style="font-size: 30px; color: #D9BA7A"></i></a>
                            <a href="javascript:void(0)" class="next1"><i class="fal fa-long-arrow-right" style="font-size: 30px; color: #D9BA7A"></i></a>
                        </div>
                    @endif
                @endif
        </div>
        <div class="tab-pane container-fluid fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="mr-5 mb-5" style="text-align: right;">
                <a href="{{url('home-search-result?first_minute=on')}}" class="read-more" style="color: #115571;font-size: 20px;">{{__('See More')}} {!! balanceTags(get_icon('002_right_arrow', '#115571', '24px', '')) !!}</a>
            </div>
            <?php 
                $SpecialOffering = \App\Controllers\Services\HomeController::get_inst()->getSpecialOffering($data = array('table'=>'first_minute', 'number'=> 6));
            ?>
            @if($SpecialOffering['total'] > 0)
                @if($SpecialOffering['total'] >= 4) 
                    <div class="gallery">
                        <div class="gallery-container" id="first_minute_gallery">
                            @foreach($SpecialOffering['results'] as $key => $value)
                                    <div class="gallery-item gallery-item-{{$key + 1}}">
                                        <div class="is-featured">{{$value->discount_percent}}%</div>
                                        <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                            <img style="width:100%; height: 100%;border-radius: 13px;" src="{{$value->media_url}}" data-index="{{$key + 1}}">
                                        </a>
                                        <figcaption class="carsuel-effect1">
                                            <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                                <p class="gallery-title">{{get_translate($value->post_title)}}</p>
                                            </a>
                                            <div style="display:flex; justify-content: space-between; position: relative;">
                                                <div class="gallery-facility">
                                                    <div class="mr-3" style="position: relative;">
                                                        <i class="fas fa-bed"></i> <span>{{$value->number_of_bedrooms}}</span>
                                                    </div>
                                                    <div class="mr-3" style="position: relative;">
                                                        <i class="fas fa-user"></i> <span>{{$value->number_of_guest}}</span>
                                                    </div>
                                                    <div style="position: relative;">
                                                        <i class="fas fa-city"></i> <span>{{get_translate($value->location_city)}}</span>
                                                    </div>
                                                </div>
                                                <div class="gallery-price1">{{convert_price($value->base_price)}} / night</div>
                                            </div>
                                        </figcaption>
                                    </div>
                            @endforeach
                        </div>
                        <div class="buttons mt-3" id="galler_buttons">
                            <a href="javascript:void(0)" class="gallery-controls-previous"><i class="fal fa-long-arrow-left mr-3" style="font-size: 30px; color: #D9BA7A"></i></a>
                            <a href="javascript:void(0)" class="gallery-controls-next"><i class="fal fa-long-arrow-right" style="font-size: 30px; color: #D9BA7A"></i></a>
                        </div>
                    </div>
                @elseif($SpecialOffering['total'] == 3)
                    <div class="gallery">
                        <div class="gallery-container" id="first_minute_gallery">
                            @foreach($SpecialOffering['results'] as $key => $value)
                                    <div class="gallery-item gallery-item-{{$key + 2}}">
                                        <div class="is-featured">{{$value->discount_percent}}%</div>
                                        <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                            <img style="width:100%; height: 100%;border-radius: 13px;" src="{{$value->media_url}}" data-index="{{$key + 2}}">
                                        </a>
                                        <figcaption class="carsuel-effect1">
                                            <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                                <p class="gallery-title">{{get_translate($value->post_title)}}</p>
                                            </a>
                                            <div style="display:flex; justify-content: space-between; position: relative;">
                                                <div class="gallery-facility">
                                                    <div class="mr-3" style="position: relative;">
                                                        <i class="fas fa-bed"></i> <span>{{$value->number_of_bedrooms}}</span>
                                                    </div>
                                                    <div class="mr-3" style="position: relative;">
                                                        <i class="fas fa-user"></i> <span>{{$value->number_of_guest}}</span>
                                                    </div>
                                                    <div style="position: relative;">
                                                        <i class="fas fa-city"></i> <span>{{get_translate($value->location_city)}}</span>
                                                    </div>
                                                </div>
                                                <div class="gallery-price1">{{convert_price($value->base_price)}} / night</div>
                                            </div>
                                        </figcaption>
                                    </div>
                            @endforeach
                        </div>
                        <div class="buttons mt-3" id="galler_buttons">
                            <a href="javascript:void(0)" class="gallery-controls-previous"><i class="fal fa-long-arrow-left mr-3" style="font-size: 30px; color: #D9BA7A"></i></a>
                            <a href="javascript:void(0)" class="gallery-controls-next"><i class="fal fa-long-arrow-right" style="font-size: 30px; color: #D9BA7A"></i></a>
                        </div>
                    </div>
                @else 
                    <div id="carousel_1">
                        @foreach($SpecialOffering['results'] as $key => $value)

                            <div class="@if($key == 0) selected @elseif($key == 1) next @elseif($key == 2) nextRightSecond @else hideRight @endif">
                                <div class="is-featured">{{$value->discount_percent}}%</div>
                                <img src="{{$value->media_url}}">
                                <figcaption class="carsuel-effect">
                                    <p style="font-size: 28px; font-weight: bolder;">{{get_translate($value->post_title)}}</p>
                                    <div style="display:flex; justify-content: space-between; position: relative;">
                                        <div class="gallery-facility">
                                            <div class="mr-3" style="position: relative;">
                                                <i class="fas fa-bed"></i> <span>{{$value->number_of_bedrooms}}</span>
                                            </div>
                                            <div class="mr-3" style="position: relative;">
                                                <i class="fas fa-user"></i> <span>{{$value->number_of_guest}}</span>
                                            </div>
                                            <div style="position: relative;">
                                                <i class="fas fa-city"></i> <span>{{get_translate($value->location_city)}}</span>
                                            </div>
                                        </div>
                                        <div class="gallery-price">{{convert_price($value->base_price)}} / night</div>
                                    </div>
                                </figcaption>
                            </div>
                        @endforeach
                    </div>
                    <div class="buttons mt-3">
                        <a href="javascript:void(0)" class="prev1"><i class="fal fa-long-arrow-left mr-3" style="font-size: 30px; color: #D9BA7A"></i></a>
                        <a href="javascript:void(0)" class="next1"><i class="fal fa-long-arrow-right" style="font-size: 30px; color: #D9BA7A"></i></a>
                    </div>
                @endif
            @endif
        </div>
        <div class="tab-pane container-fluid fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="mr-5 mb-5" style="text-align: right;">
                <a href="{{url('home-search-result?last_minute=on')}}" class="read-more" style="color: #115571;font-size: 20px;">{{__('See More')}} {!! balanceTags(get_icon('002_right_arrow', '#115571', '24px', '')) !!}</a>
            </div>
            <?php 
                $SpecialOffering = \App\Controllers\Services\HomeController::get_inst()->getSpecialOffering($data = array('table'=>'last_minute', 'number'=> 6));
            ?>
            @if($SpecialOffering['total'] > 0)
            @if($SpecialOffering['total'] >= 4) 
                    <div class="gallery">
                        <div class="gallery-container" id="last_minute_gallery">
                            @foreach($SpecialOffering['results'] as $key => $value)
                                    <div class="gallery-item gallery-item-{{$key + 1}}">
                                        <div class="is-featured">{{$value->discount_percent}}%</div>
                                        <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                            <img style="width:100%; height: 100%;border-radius: 13px;" src="{{$value->media_url}}" data-index="{{$key + 1}}">
                                        </a>
                                        <figcaption class="carsuel-effect1">
                                            <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                                <p class="gallery-title">{{get_translate($value->post_title)}}</p>
                                            </a>
                                            <div style="display:flex; justify-content: space-between; position: relative;">
                                                <div class="gallery-facility">
                                                    <div class="mr-3" style="position: relative;">
                                                        <i class="fas fa-bed"></i> <span>{{$value->number_of_bedrooms}}</span>
                                                    </div>
                                                    <div class="mr-3" style="position: relative;">
                                                        <i class="fas fa-user"></i> <span>{{$value->number_of_guest}}</span>
                                                    </div>
                                                    <div style="position: relative;">
                                                        <i class="fas fa-city"></i> <span>{{get_translate($value->location_city)}}</span>
                                                    </div>
                                                </div>
                                                <div class="gallery-price1">{{convert_price($value->base_price)}} / night</div>
                                            </div>
                                        </figcaption>
                                    </div>
                            @endforeach
                        </div>
                        <div class="buttons mt-3" id="galler_buttons">
                            <a href="javascript:void(0)" class="gallery-controls-previous"><i class="fal fa-long-arrow-left mr-3" style="font-size: 30px; color: #D9BA7A"></i></a>
                            <a href="javascript:void(0)" class="gallery-controls-next"><i class="fal fa-long-arrow-right" style="font-size: 30px; color: #D9BA7A"></i></a>
                        </div>
                    </div>
                @elseif($SpecialOffering['total'] == 3)
                    <div class="gallery">
                        <div class="gallery-container" id="last_minute_gallery">
                            @foreach($SpecialOffering['results'] as $key => $value)
                                    <div class="gallery-item gallery-item-{{$key + 2}}">
                                        <div class="is-featured">{{$value->discount_percent}}%</div>
                                        <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                            <img style="width:100%; height: 100%;border-radius: 13px;" src="{{$value->media_url}}" data-index="{{$key + 2}}">
                                        </a>
                                        <figcaption class="carsuel-effect1">
                                            <a href="{{ get_the_permalink($value->post_id, $value->post_slug) }}" >
                                                <p class="gallery-title">{{get_translate($value->post_title)}}</p>
                                            </a>
                                            <div style="display:flex; justify-content: space-between; position: relative;">
                                                <div class="gallery-facility">
                                                    <div class="mr-3" style="position: relative;">
                                                        <i class="fas fa-bed"></i> <span>{{$value->number_of_bedrooms}}</span>
                                                    </div>
                                                    <div class="mr-3" style="position: relative;">
                                                        <i class="fas fa-user"></i> <span>{{$value->number_of_guest}}</span>
                                                    </div>
                                                    <div style="position: relative;">
                                                        <i class="fas fa-city"></i> <span>{{get_translate($value->location_city)}}</span>
                                                    </div>
                                                </div>
                                                <div class="gallery-price1">{{convert_price($value->base_price)}} / night</div>
                                            </div>
                                        </figcaption>
                                    </div>
                            @endforeach
                        </div>
                        <div class="buttons mt-3" id="galler_buttons">
                            <a href="javascript:void(0)" class="gallery-controls-previous"><i class="fal fa-long-arrow-left mr-3" style="font-size: 30px; color: #D9BA7A"></i></a>
                            <a href="javascript:void(0)" class="gallery-controls-next"><i class="fal fa-long-arrow-right" style="font-size: 30px; color: #D9BA7A"></i></a>
                        </div>
                    </div>
                @else 
                    <div id="carousel_1">
                        @foreach($SpecialOffering['results'] as $key => $value)

                            <div class="@if($key == 0) selected @elseif($key == 1) next @elseif($key == 2) nextRightSecond @else hideRight @endif">
                                <div class="is-featured">{{$value->discount_percent}}%</div>
                                <img src="{{$value->media_url}}">
                                <figcaption class="carsuel-effect">
                                    <p style="font-size: 28px; font-weight: bolder;">{{get_translate($value->post_title)}}</p>
                                    <div style="display:flex; justify-content: space-between; position: relative;">
                                        <div class="gallery-facility">
                                            <div class="mr-3" style="position: relative;">
                                                <i class="fas fa-bed"></i> <span>{{$value->number_of_bedrooms}}</span>
                                            </div>
                                            <div class="mr-3" style="position: relative;">
                                                <i class="fas fa-user"></i> <span>{{$value->number_of_guest}}</span>
                                            </div>
                                            <div style="position: relative;">
                                                <i class="fas fa-city"></i> <span>{{get_translate($value->location_city)}}</span>
                                            </div>
                                        </div>
                                        <div class="gallery-price">{{convert_price($value->base_price)}} / night</div>
                                    </div>
                                </figcaption>
                            </div>
                        @endforeach
                    </div>
                    <div class="buttons mt-3">
                        <a href="javascript:void(0)" class="prev1"><i class="fal fa-long-arrow-left mr-3" style="font-size: 30px; color: #D9BA7A"></i></a>
                        <a href="javascript:void(0)" class="next1"><i class="fal fa-long-arrow-right" style="font-size: 30px; color: #D9BA7A"></i></a>
                    </div>
                @endif
            @endif
        </div>
    </div>
    <div class="container-fluid" style="background:#fff;">
        <div class="container mt-5">
            <div class="row mt-5">
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="mt-3 category_view" style="">
                        <h2 style="font-size: 36px; font-weight: bolder;">Collections of best Luxury Villas</h2>
                        <a href="home-search-result" class="read-more mt-3" style="color: #115571;font-size: 20px;">{{__('See More')}} {!! balanceTags(get_icon('002_right_arrow', '#115571', '24px', '')) !!}</a>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-sm-12 col-md-4">
                            <div style="position: relative;">
                                <a href="home-search-result?home-type=154">
                                <img width="100%" height="825px" style="border-radius: 10px;" src="{{asset('images/frontline-beauty-and-beaches.jpg')}}" class="vc_single_image-img attachment-full" alt="Frontline and near the beach Villas" loading="lazy">
                                <figcaption class="category-text"><span>Frontline and near the beach Villas</span></figcaption>
                                </a>
                            </div>
                            
                        </div>
                        <div class="col-md-8 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 category_item">
                                    <div style="position: relative;">
                                        <a href="home-search-result?home-type=155">
                                            <img width="100%" height="400" style="border-radius: 10px;" src="{{asset('images/families_villas.jpg')}}" class="vc_single_image-img attachment-full" alt="Family Villas for Rent" loading="lazy">
                                            <figcaption class="category-text">Family Villas for Rent</figcaption>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 category_item">
                                    <div style="position: relative;">
                                        <a href="home-search-result?home-type=156">
                                            <img width="100%" height="400" style="border-radius: 10px;" src="{{asset('images/services.jpg')}}" class="vc_single_image-img attachment-full" alt="Villas with extra services" loading="lazy">
                                            <figcaption class="category-text">Villas with extra services</figcaption>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-6 category_item">
                                    <div style="position: relative;">
                                        <a href="home-search-result?home-type=157">
                                            <img width="100%" height="400" style="border-radius: 10px;" src="{{asset('images/countryside.jpg')}}" class="vc_single_image-img attachment-full" alt="Countryside Villas" loading="lazy">
                                            <figcaption class="category-text">Countryside Villas</figcaption>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 category_item">
                                    <div style="position: relative;">
                                        <a href="home-search-result?home-type=158">
                                            <img width="100%" height="400" style="border-radius: 10px;" src="{{asset('images/small.jpg')}}" class="vc_single_image-img attachment-full" alt="Small Villas for Rent" loading="lazy">
                                            <figcaption class="category-text">Small Villas for Rent</figcaption>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-5" style="background:#f9f9f9">
              
    <h2 class="h3 mt-0 c-black text-center mb-5" style="font-size:36px; font-weight: bold;">{{__('Top destination')}}</h2>            
    <!-- <div class='main'>
        <div class='slider-container'>
            <div class='slider'>
                <ul>
                    <li>
                        <div>
                            <img class="YVj9w ht4YT" src="https://media.istockphoto.com/photos/family-new-home-picture-id1292863259?b=1&amp;k=20&amp;m=1292863259&amp;s=170667a&amp;w=0&amp;h=eqOFVf9M1ydMzbzxyo_1VjuRyaUDQnL8QpKjLbIUOog=" title="Family new home.">
                            <figcaption class="gallery_top_destination">Free breakfast for 1 week</figcaption>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img class="YVj9w ht4YT" src="https://media.istockphoto.com/photos/interior-design-architecture-computer-generated-image-of-living-room-picture-id1298332246?b=1&amp;k=20&amp;m=1298332246&amp;s=170667a&amp;w=0&amp;h=O8vzCIUTdru3Y1cQo3TbRjRo6sAznICYVExyTk5XrOo=" title="Interior Design. Architecture. Computer generated image of living room. Architectural Visualization. 3D rendering.">
                            <figcaption class="gallery_top_destination">Free breakfast for 1 week</figcaption>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img class="YVj9w ht4YT" src="https://media.istockphoto.com/photos/cant-wait-to-see-the-room-picture-id1202673019?b=1&amp;k=20&amp;m=1202673019&amp;s=170667a&amp;w=0&amp;h=AJsuPHTsiS0q7YAMBNRj-dqlhb5IpnzGhyfKWOv3Wn0=" title="Can't wait to see the room">
                            <figcaption class="gallery_top_destination">Free breakfast for 1 week</figcaption>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img class="MosaicAsset-module__thumb___tdc6z" src="https://media.istockphoto.com/photos/estate-agent-giving-house-keys-to-woman-and-sign-agreement-in-office-picture-id1130829500?k=20&amp;m=1130829500&amp;s=612x612&amp;w=0&amp;h=pRvjEVrgrHX2HJYqj7kU3k1rJLgztCV2rizKr7pd5Ec=" alt="агент по недвижимости дает ключи от дома женщине и подписать соглашение в офисе - house for rent стоковые фото и изображения">
                            <figcaption class="gallery_top_destination">Free breakfast for 1 week</figcaption>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img class="YVj9w ht4YT" src="https://media.istockphoto.com/photos/cant-wait-to-see-the-room-picture-id1202673019?b=1&amp;k=20&amp;m=1202673019&amp;s=170667a&amp;w=0&amp;h=AJsuPHTsiS0q7YAMBNRj-dqlhb5IpnzGhyfKWOv3Wn0=" title="Can't wait to see the room">
                            <figcaption class="gallery_top_destination">Free breakfast for 1 week</figcaption>
                        </div>  
                    </li>
                </ul>
                
            
            </div>
            <div class="buttons mt-4">
                <a class='prev' style="cursor: pointer"><i class="fal fa-long-arrow-left mr-3" style="font-size: 30px; color: #D9BA7A"></i></a>
                <a class='next' style="cursor: pointer"><i class="fal fa-long-arrow-right" style="font-size: 30px; color: #D9BA7A"></i></a>
            </div>
        </div>
    </div> -->
    <?php
    $locations = get_option('top_destination');
    ?>
    @if(!empty($locations))
        <div class="hh-list-destinations" >
            <?php
            $responsive = [
                0 => [
                    'items' => 1
                ],
                768 => [
                    'items' => 2
                ],
                992 => [
                    'items' => 3
                ],
            ];
            ?>
            <div class="hh-carousel carousel-padding nav-style2"
                    data-responsive="{{ base64_encode(json_encode($responsive)) }}" data-margin="15" data-loop="0">
                <div class="owl-carousel">
                    @foreach($locations as $location)
                        <?php
                        $lat = $location['lat'];
                        $lng = $location['lng'];
                        $address = get_translate($location['name']);
                        if (isset($location['service']) && !empty($location['service'])) {
                            $services = explode(',', $location['service']);
                        } else {
                            $services = [];
                        }

                        $location_query = [
                            'lat' => $lat,
                            'lng' => $lng,
                            'address' => urlencode($address),
                        ];
                        $location_url = url('/');
                        if (count($services) == 0) {
                            $enable_services = get_enabled_service_keys();
                            if (count($enable_services)) {
                                $location_url = get_search_page($enable_services[0]);
                            } else {
                                $location_url = '';
                            }
                        } elseif (count($services) == 1 && is_enable_service($services[0])) {
                            $location_url = get_search_page($services[0]);
                        } elseif (count($services) > 1) {
                            $enable_services = [];
                            foreach ($services as $service) {
                                if (is_enable_service($service)) {
                                    $enable_services[] = $service;
                                }
                            }
                            if (count($enable_services)) {
                                $location_url = get_search_page($enable_services[0]);
                            } else {
                                $location_url = '';
                            }
                        }
                        if (!empty($location_url)) {
                            $location_url = add_query_arg($location_query, $location_url);
                        } else {
                            $location_url = 'javascript: void(0)';
                        }

                        $rand = rand(1, 6);
                        ?>
                        <div class="item mx-3" style="padding: 20px; background: #fff; border-radius: 13px;">
                            <div class="hh-destination-item">
                                <a href="{{ $location_url }}">
                                    <div class="thumbnail has-matchHeight">
                                        <div class="thumbnail-outer">
                                            <div class="thumbnail-inner">
                                                <img src="{{ get_attachment_url($location['image']) }}"
                                                        alt="{{ get_attachment_alt($location['image'] ) }}"
                                                        class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="detail">
                                            <h2 class="text-center des-paterm-{{$rand}}">{{ $address }}</h2>
                                            @if(count($services) > 1)
                                                <div
                                                    class="count-services d-flex align-items-center justify-content-center mt-3">
                                                    <?php
                                                    foreach($services as $service){
                                                    if (!is_enable_service($service)) {
                                                        continue;
                                                    }
                                                    if ($service == 'home') {
                                                        $location_query['bookingType'] = 'per_night';
                                                    }
                                                    $location_url = get_search_page($service);
                                                    $location_url = add_query_arg($location_query, $location_url);
                                                    $radius = get_option($service . '_search_radius', 25);
                                                    $controller = '\\App\\Controllers\\Services\\' . ucfirst($service) . 'Controller';
                                                    $method = 'listOf' . ucfirst($service) . 's';
                                                    $list_services = $controller::get_inst()->$method([
                                                        'location' => [
                                                            'lat' => $lat,
                                                            'lng' => $lng,
                                                            'radius' => $radius
                                                        ],
                                                    ]);
                                                    $service_info = post_type_info($service);
                                                    ?>

                                                    <div class="item item-{{$service}}">
                                                        <a href="{{$location_url}}">
                                                            <span class="count">{{$list_services['total']}}</span>
                                                            <span
                                                                class="service">{{__($service_info['names'])}}</span>
                                                        </a>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @if(!empty($location['content']))
                            <div><p style="padding: 20px;">{!! balanceTags($location['content']) !!}</p></div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="owl-nav">
                    <a href="javascript:void(0)"
                        class="prev"><i class="ti-angle-left"></i></a>
                    <a href="javascript:void(0)"
                        class="next"><i class="ti-angle-right"></i></a>
                </div>
            </div>
        </div>
    @endif
</div>


<div class="container-fluid">
    <!-- <?php
        $experience_types = get_terms('experience-type', true);
    ?>
    @if(count($experience_types) > 0)
        <h2 class="h3 mt-0 c-black text-center pt-4 mt-4" style="font-size:36px; font-weight: bolder;">{{__('Find Experience, Rent a boat, Rent a car...')}}</h2>
        <div class="hh-list-terms mt-3">
            @if(count($experience_types))
                <?php
                $responsive = [
                    0 => [
                        'items' => 1
                    ],
                    768 => [
                        'items' => 2
                    ],
                    992 => [
                        'items' => 3
                    ],
                    1200 => [
                        'items' => 4
                    ]
                ];
                ?>
                <div class="hh-carousel carousel-padding nav-style2"
                        data-responsive="{{ base64_encode(json_encode($responsive)) }}" data-margin="15" data-loop="0">
                    <div class="owl-carousel">
                        @foreach($experience_types as $item)
                            <?php
                            $url = get_attachment_url($item->term_image, [350, 300]);
                            ?>
                            <div class="item">
                                <div class="hh-term-item">
                                    <a href="{{ get_experience_search_page('?experience-type=' . $item->term_id) }}">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="thumbnail has-matchHeight">
                                                    <div class="thumbnail-outer">
                                                        <div class="thumbnail-inner">
                                                            <img src="{{ $url }}"
                                                                    alt="{{ get_attachment_alt($item->term_image ) }}"
                                                                    class="img-fluid">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex align-items-center">
                                                <div class="clearfix">
                                                    <h4>{{ get_translate($item->term_title) }}</h4>
                                                    <?php
                                                    $home_count = count_experience_in_experience_type($item->term_id);
                                                    ?>
                                                    <p class="text-muted">{{ sprintf(__('%s Experiences'), $home_count) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="owl-nav">
                        <a href="javascript:void(0)"
                            class="prev"><i class="ti-angle-left"></i></a>
                        <a href="javascript:void(0)"
                            class="next"><i class="ti-angle-right"></i></a>
                    </div>
                </div>
            @endif
        </div>
    @endif -->
    <?php
    $testimonials = get_option('testimonial', []);
    $responsive = [
        0 => [
            'items' => 1
        ],
        768 => [
            'items' => 2
        ],
        992 => [
            'items' => 2
        ],
        1200 => [
            'items' => 3
        ],
    ];

    $testimonial_bgr = get_option('testimonial_background', '#fff');
    ?>
    @if(count($testimonials))
        <div class="section section-background pt-4 mt-4" style="background: #f9f9f9;">
            <h2 class="h3 mt-0 c-black text-center" style="font-size:36px; font-weight: bolder;">{{__('OUR GUEST LOVE US')}}</h2>
            <div class="hh-testimonials">
                <div class="hh-carousel carousel-padding nav-style2"
                        data-responsive="{{ base64_encode(json_encode($responsive)) }}" data-margin="30" data-loop="0">
                    <div class="owl-carousel our_guest">
                        @foreach($testimonials as $testimonial)
                            <div class="item">
                                <div class="testimonial-item">
                                    <div class="testimonial-inner">
                                        <div class="author-rate">
                                            @include('frontend.components.star', ['rate' => (int) $testimonial['author_rate']])
                                        </div>
                                        <div class="author-comment">
                                            {{ get_translate($testimonial['author_comment']) }}
                                        </div>
                                        
                                        <!-- @if($testimonial['date'])
                                            <div
                                                class="author-date">{{sprintf(__('on %s'), date(hh_date_format(), strtotime($testimonial['date'])))}}</div>
                                        @endif -->
                                        <div class="mt-3" style="display:flex; justify-content: space-between;">
                                            <div style="display:flex; justify-content:start">
                                                <img
                                                    src="{{ get_attachment_url($testimonial['author_avatar'], [80, 80]) }}"
                                                    alt="{{get_translate( $testimonial['author_name']) }}"
                                                    class="img-fluid mr-2" style="border-radius: 50%; max-width: 80px;">
                                                <h2 class="author-name">
                                                    {{ get_translate($testimonial['author_name']) }}
                                                </h2>
                                            </div>
                                            <i class="mdi mdi-format-quote-open hh-icon" style="font-size: 50px; color: #AAA;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="buttons" style="padding-bottom: 50px;">
                        <a href="javascript:void(0)" class="prev"><i class="fal fa-long-arrow-left mr-3" style="font-size: 30px; color: #D9BA7A"></i></a>
                        <a href="javascript:void(0)" class="next"><i class="fal fa-long-arrow-right" style="font-size: 30px; color: #D9BA7A"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<div class="modal fade " id="myModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">{{__('Advanced Search')}}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="hh-search-form">
                <form action="{{ url('get-advanced-search') }}" class="form mt-3" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-12 col-sm-6">
                            <?php
                            $minmax = \App\Controllers\Services\HomeController::get_inst()->getMinMaxPrice();
                            $currencySymbol = current_currency('symbol');
                            $currencyPos = current_currency('position');
                            ?>
                            <div class="form-group">
                                <label>{{__('Price Range')}}</label>
                                <input type="text" name="price_filter"
                                    data-plugin="ion-range-slider"
                                    data-prefix="{{ $currencyPos == 'left' ? $currencySymbol : ''}}"
                                    data-postfix="{{ $currencyPos == 'right' ? $currencySymbol : ''}}"
                                    data-min="{{ $minmax['min'] }}"
                                    data-max="{{ $minmax['max'] }}"
                                    data-from="{{ $minmax['min'] }}"
                                    data-to="{{ $minmax['max'] }}"
                                    data-skin="round">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-sm-6">
                            <div class="form-group">
                                <label>{{__('Where')}}</label>
                                <input type="text" id="demo5" name="address" class="form-control typeahead" autocomplete="off" placeholder="{{__('Enter a location ...')}}">
                                <div class="map d-none"></div>
                                <input type="hidden" name="lat" value="">
                                <input type="hidden" name="lng" value="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-sm-6">
                            <div class="form-group form-group-date">
                                <label>{{__('Check In/Out')}}</label>
                                <div class="date-wrapper date date-double" data-date-format="{{ hh_date_format_moment() }}">
                                    <input type="text" class="input-hidden check-in-out-field" name="checkInOut">
                                    <input type="text" class="input-hidden check-in-field" name="checkIn">
                                    <input type="text" class="input-hidden check-out-field" name="checkOut">
                                    <span class="check-in-render"
                                        data-date-format="DD.MM.YYYY."></span>
                                    <span class="divider"></span>
                                    <span class="check-out-render"
                                        data-date-format="DD.MM.YYYY."></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-sm-6">
                            <div class="form-group">
                                <label>{{__('Guests')}}</label>
                                <div class="guest-group">
                                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown"
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
                                                <input type="number" min="1" step="1" max="15" name="num_adults" value="1">
                                                <i class="increase ti-plus"></i>
                                            </div>
                                        </div>
                                        <div class="group">
                                            <span class="pull-left">{{__('Children')}}</span>
                                            <div class="control-item">
                                                <i class="decrease ti-minus"></i>
                                                <input type="number" min="0" step="1" max="15" name="num_children"
                                                    value="0">
                                                <i class="increase ti-plus"></i>
                                            </div>
                                        </div>
                                        <div class="group">
                                            <span class="pull-left">{{__('Infants')}}</span>
                                            <div class="control-item">
                                                <i class="decrease ti-minus"></i>
                                                <input type="number" min="0" step="1" max="10" name="num_infants" value="0">
                                                <i class="increase ti-plus"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-sm-6">
                            <div class="row">
                                <div class="col-6 col-sm-6">
                                    <div class="form-group">
                                        <label>{{__('Bedrooms')}}</label>
                                        <select class="form-control" name="bedrooms">
                                            <option value="">Any</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6+</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6">
                                    <div class="form-group">
                                        <label>{{__('Bathrooms')}}</label>
                                        <select class="form-control" name="bathrooms">
                                            <option value="">Any</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3+</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <?php
                                $terms = get_home_terms_filter();
                            ?>
                            @if (!empty($terms))
                                @foreach ($terms as $term_name => $term)
                                    <?php
                                    $tax = request()->get($term_name);
                                    $tax_arr = [];
                                    if (!empty($tax)) {
                                        $tax_arr = explode(',', $tax);
                                    }
                                    ?>
                                    <div class="item-filter-wrapper" data-type="{{ $term_name }}">
                                        @if (!empty($term['items']) && $term['label'] != 'Home Facilities Fields')
                                            <div class="label" style="text-transform: uppercase; font-weight: bold; color: #115571; padding: 10px 0px;">@if($term['label'] == 'Home Amenity') AMENITIES @elseif($term['label'] == 'Home Type') TYPE @else {{ $term['label'] }} @endif</div>
                                            <?php
                                                $idName = str_replace(' ', '-', str_replace(['[', ']'], '_', $term['label']));
                                            ?>
                                            <div class="content" id="{{$idName}}">
                                                <div class="row">
                                                    @foreach ($term['items'] as $term_id => $term_title)
                                                        <?php
                                                        $checked = '';
                                                        if (in_array($term_id, $tax_arr)) {
                                                            $checked = 'checked';
                                                        }
                                                        ?>
                                                        <div class="col-lg-4 mb-1">
                                                            <div class="item checkbox  checkbox-success ">
                                                                <input type="checkbox" value="{{ $term_id }}" onchange="checkStatus('{{ $idName }}', {{$term_id}})"
                                                                    id="{{$term_name}}{{ $term_id }}" {{ $checked }}/>
                                                                <label
                                                                    for="{{ $term_name }}{{ $term_id }}">{!! balanceTags($term_title) !!}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        <input type="hidden" name="{{ $term_name }}" value="{{ $tax }}"/>
                                        
                                    </div>
                                @endforeach
                                <div class="" id="special-offer">
                                    <div class="label" style="text-transform: uppercase; font-weight: bold; color: #115571; padding: 10px 0px;">Special Offer</div>
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-lg-4 mb-1">
                                                <div class="item checkbox  checkbox-success ">
                                                    <input type="checkbox" value="on" onchange="changeSpecial('first_minute')"
                                                        id="first_minute" name="first_minute"/>
                                                    <label
                                                        for="first_minute">FIRST MINUTE</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-1">
                                                <div class="item checkbox  checkbox-success ">
                                                    <input type="checkbox" value="on" onchange="changeSpecial('last_minute')"
                                                        id="last_minute" name="last_minute"/>
                                                    <label
                                                        for="last_minute">LAST MINUTE</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $facilities_list = get_terms('home-advanced'); 
                                ?>
                                <div class="item-filter-wrapper" id="home-facilities">
                                    <!-- <div class="label">Home Facilities</div> -->
                                        
                                    <?php 
                                    foreach ($facilities_list as $key => $value) { ?>
                                        <div class="label" style="text-transform: uppercase; font-weight: bold; color: #115571; padding: 10px 0px;">{{$value['title']}}</div>
                                        <div class="content">
                                            <div class="row">
                                            <?php $sub_val = json_decode($value['selection_val']);
                                            
                                                if(!empty($sub_val)){
                                                    foreach ($sub_val as $k=>$item) { 
                                                        foreach ($item as $tmp) {
                                                            $idName = str_replace(' ', '-', str_replace(['[', ']'], '_', $k)); ?>
                                                            <div class="col-lg-4 mb-1">
                                                                <div class="item checkbox  checkbox-success ">
                                                                    <input type="checkbox" value="{{$tmp}}" onchange="checkFacility()"
                                                                        id="{{$idName}}_{{$tmp}}"/>
                                                                    <label
                                                                        for="{{$idName}}_{{$tmp}}">{{ $tmp }}</label>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                        ?>
                                                        
                                                    <?php }
                                                }
                                            ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                       
                                </div>
                            @endif
                        </div>
                    </div>
                    <input type="hidden" name="amenity_val" id="amenity_val">
                    <input type="hidden" name="facility_val" id="facility_val">
                    <input type="hidden" name="hometype_val" id="hometype_val">
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success" style="background: #115571; border: 0px;">Apply</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            
        </div>
        
      </div>
    </div>
</div>
  <script>
      // external js: flickity.pkgd.js

  </script>
@include('frontend.components.footer')
