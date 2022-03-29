<?php
$logo_footer = get_option('footer_logo');
if (empty($logo_footer)) {
    $logo_footer = get_option('logo');
}
$list_social = get_option('list_social');
$screen = current_screen();
$setup_mailc_api = get_option('mailchimp_api_key');
$setup_mailc_list_id = get_option('mailchimp_list');
enqueue_script('nice-select-js');
enqueue_style('nice-select-css');
?>
</div>
<style>
 .footer_contact p a {
     color: #fff;
 }
 #become-a-host-id:hover {
    color: #DCD0BA;
 }
 #become-a-owner-id:hover {
    color: #DCD0BA;
 }
</style>
<footer id="footer" class="{{ $screen == 'home-search-result' ? 'hide-footer' : '' }}">
    <div class="container">
        <div class="row footer_contact">
            <div class="col-lg-4 col-md-12">
                @if(!empty($logo_footer))
                    <img src="{{ asset('images/footer-logo.png') }}" alt="footer logo" class="footer-logo" style="width: 370px; height: 115px"/>
                @endif
                <!-- <ul class="menu ml-3">		
                    <li class="menu-item menu-item-1 ">
                        <a href="#"><i class="fas fa-envelope mr-2"></i>test@gmail.com</a>
                    </li>
                    <li class="menu-item menu-item-2 ">
                        <a href="#"><i class="fas fa-phone-volume mr-2"></i>+3556970982</a>
                    </li>
                    <li class="menu-item menu-item-3 ">
                        <a href="#"><i class="fas fa-home mr-2"></i>Ros Angels Blab androe 3th street</a>
                    </li>
                </ul> -->
                <div style="color: #fff">
                {!! balanceTags(get_option('contact_detail')) !!}
                </div>
                
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <h4 class="footer-title">{{ get_option('footer_menu1_label') }}</h4>
                        <div class="under_stack"></div>
                        <div class="row">
                            <div class="col-12 col-lg-6 col-md-12">
                                <?php
                                $menu_id = get_option('footer_menu1');
                                get_nav_by_id($menu_id);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class=" col-12 col-lg-6 col-md-12">
                        <h4 class="footer-title">{{ get_option('footer_menu2_label') }}</h4>
                        <div class="under_stack"></div>
                        <div class="row">
                            <div class="col-12 col-lg-6 col-md-12">
                                <?php
                                $menu_id = get_option('footer_menu2');
                                get_nav_by_id($menu_id);
                                ?>
                            </div>
                        </div>
                    </div>
                        <!-- <h4 class="footer-title">{{ get_option('footer_menu2_label') }}</h4> -->
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <!-- @if(!empty($setup_mailc_api) && !empty($setup_mailc_list_id))
                    <h4 class="footer-title">{{ get_option('footer_subscribe_label') }}</h4>
                    <div class="under_stack"></div>
                    <form action="{{ url('subscribe-email') }}" class="subscribe-form form-sm form-action"
                          data-validation-id="form-subscribe"
                          method="post" data-reload-time="1000">
                        <input type="email" id="mc-email" name="email" placeholder="{{__('Enter your email')}}"
                               class="form-control has-validation" data-validation="required"/>
                        <button type="submit">SUBSCRIBE <span class="hh-loading"></span></button>
                        <div class="form-message"></div>
                    </form>
                @else
                    <small><i>{{__('Please setup Mailchimp in Settings')}}</i></small>
                @endif -->
                <h4 class="footer-title">Become our partner</h4>
                <div class="under_stack"></div>
                @if(get_option('enable_partner_registration', 'on') == 'on')
                    <a href="javascript: void(0);" data-toggle="modal" data-target="#hh-partner-regist-modal" id="become-a-host-id" style="padding: 15px 15px; background: #D0C0A3; color: #115571; border-radius: 5px; height: auto; line-height: 45px; font-size: 15px; font-weight: bolder;"
                               class="nav-item become-a-host">{{__('Become a Partner')}}</a>
                    <a href="javascript: void(0);" data-toggle="modal" data-target="#hh-owner-regist-modal" id="become-a-owner-id" style="padding: 15px 15px; background: #D0C0A3; color: #115571; border-radius: 5px; height: auto; line-height: 45px; font-size: 15px; font-weight: bolder;"
                               class="nav-item become-a-host">{{__('Become a Owner')}}</a>
                        <li class="d-none d-lg-block li-become mr-1">
                            
                        </li>
                        <li class="d-none d-lg-block li-become mr-1">
                            
                        </li>
                @endif
                @if(!empty($list_social))
                    <ul class="social mt-3">
                        @foreach($list_social as $item)
                            <li>
                                <a href="{{ $item['social_link'] }}">
                                    {!! get_icon($item['social_icon']) !!}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="">
                            <svg height="24px" width="24px" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xodm="http://www.corel.com/coreldraw/odm/2003"><defs><style type="text/css">
   <![CDATA[
    .fil1 {fill:white}
    .fil0 {fill:url(#id0)}
   ]]>
  </style><linearGradient gradientUnits="userSpaceOnUse" id="id0" x1="67.83" x2="474.19" y1="82.42" y2="389.98"><stop offset="0" style="stop-opacity:1; stop-color:#67C4CE"/><stop offset="1" style="stop-opacity:1; stop-color:#E62A58"/></linearGradient></defs><g id="Layer_x0020_1"><g id="_2515485150816"><path class="fil0" d="M256 0c141.39,0 256,114.61 256,256 0,141.39 -114.61,256 -256,256 -141.39,0 -256,-114.61 -256,-256 0,-141.39 114.61,-256 256,-256z"/><path class="fil1" d="M313.5 106.01c0.01,4.58 1.36,70.83 70.87,74.96 0,19.1 0.02,32.95 0.02,51.18 -5.26,0.3 -45.76,-2.64 -70.97,-25.12l-0.08 99.64c0.96,69.16 -49.93,111.24 -116.46,96.7 -114.71,-34.31 -76.59,-204.44 38.59,-186.24 0,54.93 0.03,-0.01 0.03,54.93 -47.58,-7 -63.5,32.58 -50.85,60.93 11.5,25.8 58.88,31.39 75.41,-5.01 1.87,-7.12 2.8,-15.25 2.8,-24.37l0 -197.85 50.64 0.25z"/></g></g></svg>
                            </a>
                        </li>
                    </ul>
                @endif
                <ul class="social mt-3"> 
                    <li>
                    <li>
                        <a href="https://play.google.com/store/apps/details?id=com.luxurycroatiaretreats.app"><img style="width:250px; height:75px;" src="/images/payment/google-play-store.jpg"></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="copy-right d-flex align-items-center justify-content-center" style = "flex-direction: column;">
            <div>
                <ul class="social mt-3" style="background:white;"> 
                    <li>
                        <a href="https://www.mastercard.us/en-us.html"><img src="/images/payment/kartice-id-check.jpg"></a>
                    </li>
                    <li>
                        <a href="http://www.pbzcard.hr/media/53827/vbv_hr.html"><img src="/images/payment/visa-secure.jpg"></a>
                    </li>
                    <li>
                        <a href=""><img src="/images/payment/american-express.jpg"></a>
                    </li>
                    <li>
                        <a href="https://www.diners.hr/hr"><img src="/images/payment/diners-club.jpg"></a>
                    </li>
                    <li>
                        <a href="http://www.visa.com.hr/ "><img src="/images/payment/visa-kartica.jpg"></a>
                    </li>
                    
                    <li>
                        <a href="http://www.mastercard.com/hr/"><img src="/images/payment/mastercard.jpg"></a>
                    </li>
                    
                    <li>
                        <a href="http://www.maestrocard.com/hr/"><img src="/images/payment/maestro.jpg"></a>
                    </li>
                </ul>
            </div>
            <div>
                <ul style="margin-top: 0.5rem;"> 
                        <a href="https://www.wspay.info/"><img src="/images/payment/wspayment.jpg" style="width:60px; height:60px;"></a>
                </ul>
            </div>
            <div class="clearfix text-center" style="color: #fff;">
                {!! balanceTags(get_option('copy_right')) !!}
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center pb-3">
            <div class="clearfix text-center" style="color: #fff;">
                <a href="https://www.123dizajn.com" style="color: #fff;">Developed by 123 design</a>
            </div>
        </div>
    </div>
</footer>
</div>
<?php do_action('footer'); ?>
<?php do_action('init_footer'); ?>
<?php do_action('init_frontend_footer'); ?>
<script src="{{asset('js/typeahead.js')}}"></script>
<script src="{{asset('js/typeahead_data.js')}}"></script>
<script src="{{asset('js/frontend.js')}}"></script>
</body>
</html>
