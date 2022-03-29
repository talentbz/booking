<?php do_action('init'); ?>
<?php do_action('frontend_init'); ?>
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <?php
    $favicon = get_option('favicon');
    $favicon_url = get_attachment_url($favicon);
    ?>
    <link rel="shortcut icon" type="image/png" href="{{ $favicon_url }}"/>
    <title>{{ page_title() }}</title>
    {{ seo_output() }}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;1,400&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <?php do_action('header'); ?>
    <?php do_action('init_header'); ?>
    <?php do_action('init_frontend_header'); ?>
    <?php
    $body_class = isset($bodyClass) ? $bodyClass : '';
    if (is_user_logged_in() && (is_admin() || is_partner())) {
        $body_class .= ' has-admin-bar';
    }
    $tab_services = get_option('sort_search_form', convert_tab_service_to_list_item());
    ?>
</head>
<style>
    #site-navigation {
        display: flex !important; 
        justify-content: center; 
        margin-left: -50px;
    }
    .img-logo {
        width: 240px !important;
        height: 80px !important;
    }
    @media(max-width: 990px) {
        #site-navigation {
            display: none !important; 
        }
    }
    @media(max-width: 576px) {
        .img-logo {
            width: 120px !important;
            height: 50px !important;
        }
        .top-link {
            width: 40px;
            height: 40px;
        }
    }

    .top-link {
        transition: all 0.25s ease-in-out;
        position: fixed;
        bottom: 0;
        right: 0;
        display: inline-flex;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        margin: 0 3em 3em 0;
        border-radius: 50%;
        padding: 0.25em;
        width: 50px;
        height: 50px;
        background-color: #e2e2e2;
        z-index: 100000;
    }
    .top-link.show {
        visibility: visible;
        opacity: 1;
    }
    .top-link.hide {
        visibility: hidden;
        opacity: 0;
    }
    .top-link svg {
        fill: #000;
        width: 24px;
        height: 12px;
    }
    .top-link:hover {
        background-color: #c9c5c5;
    }
    .top-link:hover svg {
        fill: #000000;
    }
</style>
<body class="awe-booking {{is_rtl()? 'rtl': ''}} {{ $body_class }}">
<?php do_action('after_body_frontend'); ?>
<nav id="mobile-navigation" class="main-navigation mobile-natigation d-lg-none"
     aria-label="{{__('Top Menu')}}">
    <div class="menu-primary-container">
        <?php
        if (has_nav_primary()) {
            get_nav([
                'location' => 'primary',
                'walker' => 'main-mobile'
            ]);
        }
        ?>
    </div>
</nav><!-- #site-navigation -->
@include('common.loading', ['class' => 'page-loading'])
@if(!is_user_logged_in())
    <div id="hh-login-modal" class="modal fade modal-no-footer" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase">{{__('Login')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <form id="hh-login-form" class="form form-sm form-action" action="{{ url('auth/login') }}"
                          data-validation-id="form-login"
                          data-reload-time="1500"
                          method="post">
                        @include('common.loading')
                        <div class="form-group mb-3">
                            <label for="email-login-form">{{__('Email address')}}</label>
                            <input class="form-control has-validation" data-validation="required" type="text"
                                   id="email-login-form" name="email" placeholder="{{__('Enter your email')}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password-login-form">{{__('Password')}}</label>
                            <input class="form-control has-validation" data-validation="required|min:6:ms"
                                   type="password" id="password-login-form" name="password"
                                   placeholder="{{__('Enter your password')}}">
                        </div>
                        <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkbox-signin-login-form"
                                       checked>
                                <label class="custom-control-label"
                                       for="checkbox-signin-login-form">{{__('Remember me')}}</label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-center">
                            {!! referer_field(false) !!}
                            <button class="btn btn-primary btn-block text-uppercase"
                                    type="submit"> {{__('Log In')}}</button>
                        </div>
                        <div class="form-message"></div>
                        @if(has_social_login())
                            <div class="text-center">
                                <p class="mt-3 text-muted">{{__('Log in with')}}</p>
                                <ul class="social-list list-inline mt-3 mb-0">
                                    @if(social_enable('facebook'))
                                        <li class="list-inline-item">
                                            <a href="{{ FacebookLogin::get_inst()->getLoginUrl() }}"
                                               class="social-list-item border-primary text-primary"><i
                                                    class="mdi mdi-facebook"></i></a>
                                        </li>
                                    @endif
                                    @if(social_enable('google'))
                                        <li class="list-inline-item">
                                            <a href="{{ GoogleLogin::get_inst()->getLoginUrl() }}"
                                               class="social-list-item border-danger text-danger"><i
                                                    class="mdi mdi-google"></i></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                        <div class="mt-3 d-sm-flex align-items-center justify-content-between">
                            <p>{{__('Don\'t have an account?')}}
                                <a href="javascript: void(0)" data-toggle="modal" data-target="#hh-register-modal"
                                   class="font-weight-bold">{{__('Sign Up')}}</a>
                            </p>
                            <p>
                                <a href="javascript: void(0)" data-toggle="modal" data-target="#hh-fogot-password-modal"
                                   class="font-weight-bold">{{__('Reset Password')}}</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->
    <div id="hh-register-modal" class="modal fade modal-no-footer" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase">{{__('Sign Up')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <form id="hh-sign-up-form" action="{{ url('auth/sign-up') }}" method="post" data-reload-time="1500"
                          data-validation-id="form-sign-up"
                          class="form form-action">
                        @include('common.loading')
                        <div class="form-group">
                            <label for="first-name-reg-form">{{__('First Name')}}</label>
                            <input class="form-control" type="text" id="first-name-reg-form" name="first_name"
                                   placeholder="{{__('First Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="last-name-reg-form">{{__('Last Name')}}</label>
                            <input class="form-control" type="text" id="last-name-reg-form" name="last_name"
                                   placeholder="{{__('Last Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="email-address-reg-form">{{__('Email address')}}</label>
                            <input class="form-control has-validation" data-validation="required|email" type="email"
                                   id="email-address-reg-form" name="email" placeholder="{{__('Email')}}">
                        </div>
                        <div class="form-group">
                            <label for="password-reg-form">{{__('Password')}}</label>
                            <input class="form-control has-validation" data-validation="required|min:6:ms"
                                   name="password" type="password" id="password-reg-form"
                                   placeholder="{{__('Password')}}">
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-success">
                                <input type="checkbox" id="reg-term-condition" name="term_condition" value="1">
                                <label for="reg-term-condition">
                                    {!! sprintf(__('I accept %s'), '<a class="c-pink" href="'.get_the_permalink(get_option('term_condition_page'), '', 'page').'" class="text-dark">'. __('Terms and Conditions') .'</a>') !!}
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block text-uppercase"
                                    type="submit"> {{__('Sign Up')}}</button>
                        </div>
                        <div class="form-message"></div>
                        <div class="mt-3 d-sm-flex align-items-center justify-content-between">
                            <p>{{__('Have an account?')}}
                                <a href="javascript: void(0)" data-toggle="modal" data-target="#hh-login-modal"
                                   class="font-weight-bold">{{__('Log In')}}</a>
                            </p>
                        </div>
                    </form>

                    @if(has_social_login())
                        <div class="text-center">
                            <h5 class="mt-3 text-muted">{{__('Sign up using')}}</h5>
                            <ul class="social-list list-inline mt-3 mb-0">
                                @if(social_enable('facebook'))
                                    <li class="list-inline-item">
                                        <a href="{{ FacebookLogin::get_inst()->getLoginUrl() }}"
                                           class="social-list-item border-primary text-primary"><i
                                                class="mdi mdi-facebook"></i></a>
                                    </li>
                                @endif
                                @if(social_enable('google'))
                                    <li class="list-inline-item">
                                        <a href="{{ GoogleLogin::get_inst()->getLoginUrl() }}"
                                           class="social-list-item border-danger text-danger"><i
                                                class="mdi mdi-google"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div><!-- /.modal -->
    <div id="hh-owner-regist-modal" class="modal fade modal-no-footer" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase">{{__('Owner Sign Up')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <form id="hh-sign-up-form" action="{{ url('become-a-owner') }}" method="post" data-reload-time="1500"
                          data-validation-id="form-owner-sign-up"
                          class="form form-action">
                        @include('common.loading')
                        <div class="form-group">
                            <label for="first-name-owner-reg-form">{{__('First Name')}}</label>
                            <input class="form-control" type="text" id="first-name-owner-reg-form" name="first_name"
                                   placeholder="{{__('First Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="last-name-owner-reg-form">{{__('Last Name')}}</label>
                            <input class="form-control" type="text" id="last-name-owner-reg-form" name="last_name"
                                   placeholder="{{__('Last Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="email-address-owner-reg-form">{{__('Email address')}}</label>
                            <input class="form-control has-validation" data-validation="required|email" type="email"
                                   id="email-address-owner-reg-form" name="email" placeholder="{{__('Email')}}">
                        </div>
                        <div class="form-group">
                            <label for="password-owner-reg-form">{{__('Password')}}</label>
                            <input class="form-control has-validation" data-validation="required|min:6:ms"
                                   name="password" type="password" id="password-owner-reg-form"
                                   placeholder="{{__('Password')}}">
                        </div>
                        <div class="form-group">
                            <label for="become-owner-gender">{{__('Gender')}} <span
                                    class="text-danger">*</span></label>
                            <select name="gender" id="become-owner-gender" class="form-control"
                                    data-plugin="customselect">
                                <option value="male">{{__('Male')}}</option>
                                <option value="female">{{__('Female')}}</option>
                                <option value="other">{{__('Other')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mobile-owner-reg-form">{{__('Mobile')}}</label>
                            <input class="form-control has-validation" data-validation="required|min6:ms" type="text"
                                   id="mobile-owner-reg-form" name="phone" placeholder="{{__('Mobile')}}">
                        </div>
                        <div class="form-group">
                            <label for="address-owner-reg-form">{{__('Address')}}</label>
                            <input class="form-control has-validation" data-validation="required|min6:ms" type="text"
                                   id="address-owner-reg-form" name="address" placeholder="{{__('Address')}}">
                        </div>
                        <div class="form-group">
                            <label for="city-owner-reg-form">{{__('City')}}</label>
                            <input class="form-control has-validation" data-validation="required|min6:ms" type="text"
                                   id="city-owner-reg-form" name="city" placeholder="{{__('City')}}">
                        </div>
                        <div class="form-group">
                            <label for="become-owner-location">{{__('Country')}}</label>
                            <?php
                            enqueue_script('nice-select-js');
                            enqueue_style('nice-select-css');
                            $countries = list_countries1();
                            ?>
                            <select name="location" id="become-owner-location"
                                    class="form-control wide" data-plugin="customselect">
                                @foreach($countries as $key => $value)
                                    <option value="{{ $key }}"
                                            data-icon="{{ $value['flag24'] }}">{{ $value['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-success">
                                <input type="checkbox" id="owner-reg-term-condition" name="term_condition" value="1">
                                <label for="owner-reg-term-condition">
                                    {!! sprintf(__('I accept %s'), '<a class="c-pink" href="'.get_the_permalink(get_option('term_condition_page'), '', 'page').'" class="text-dark">'. __('Terms and Conditions') .'</a>') !!}
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block text-uppercase"
                                    type="submit"> {{__('Sign Up')}}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div id="hh-partner-regist-modal" class="modal fade modal-no-footer" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase">{{__('Agent Sign Up')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <form id="hh-sign-up-form" action="{{ url('become-a-host') }}" method="post" data-reload-time="1500"
                          data-validation-id="form-become-a-host"
                          class="form form-action">
                        @include('common.loading')
                        <div class="form-group">
                            <label for="first-name-owner-reg-form">{{__('First Name')}}</label>
                            <input class="form-control" type="text" id="first-name-owner-reg-form" name="first_name"
                                   placeholder="{{__('First Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="last-name-owner-reg-form">{{__('Last Name')}}</label>
                            <input class="form-control" type="text" id="last-name-owner-reg-form" name="last_name"
                                   placeholder="{{__('Last Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="email-address-owner-reg-form">{{__('Email address')}}</label>
                            <input class="form-control has-validation" data-validation="required|email" type="email"
                                   id="email-address-owner-reg-form" name="email" placeholder="{{__('Email')}}">
                        </div>
                        <div class="form-group">
                            <label for="password-owner-reg-form">{{__('Password')}}</label>
                            <input class="form-control has-validation" data-validation="required|min:6:ms"
                                   name="password" type="password" id="password-owner-reg-form"
                                   placeholder="{{__('Password')}}">
                        </div>
                        <div class="form-group">
                            <label for="become-owner-gender">{{__('Gender')}} <span
                                    class="text-danger">*</span></label>
                            <select name="gender" id="become-owner-gender" class="form-control"
                                    data-plugin="customselect">
                                <option value="male">{{__('Male')}}</option>
                                <option value="female">{{__('Female')}}</option>
                                <option value="other">{{__('Other')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mobile-owner-reg-form">{{__('Mobile')}}</label>
                            <input class="form-control has-validation" data-validation="required|min6:ms" type="text"
                                   id="mobile-owner-reg-form" name="phone" placeholder="{{__('Mobile')}}">
                        </div>
                        <div class="form-group">
                            <label for="address-owner-reg-form">{{__('Address')}}</label>
                            <input class="form-control has-validation" data-validation="required|min6:ms" type="text"
                                   id="address-owner-reg-form" name="address" placeholder="{{__('Address')}}">
                        </div>
                        <div class="form-group">
                            <label for="city-owner-reg-form">{{__('City')}}</label>
                            <input class="form-control has-validation" data-validation="required|min6:ms" type="text"
                                   id="city-owner-reg-form" name="city" placeholder="{{__('City')}}">
                        </div>
                        <div class="form-group">
                            <label for="become-owner-location">{{__('Country')}}</label>
                            <?php
                            enqueue_script('nice-select-js');
                            enqueue_style('nice-select-css');
                            $countries = list_countries();
                            ?>
                            <select name="location" id="become-owner-location"
                                    class="form-control wide" data-plugin="customselect">
                                @foreach($countries as $key => $value)
                                    <option value="{{ $key }}"
                                            data-icon="{{ $value['flag24'] }}">{{ $value['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-success">
                                <input type="checkbox" id="owner-reg-agent-term-condition" name="term_condition" value="1">
                                <label for="owner-reg-agent-term-condition">
                                    {!! sprintf(__('I accept %s'), '<a class="c-pink" href="'.get_the_permalink(get_option('term_condition_page'), '', 'page').'" class="text-dark">'. __('Terms and Conditions') .'</a>') !!}
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block text-uppercase"
                                    type="submit"> {{__('Become a Partner')}}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div id="hh-fogot-password-modal" class="modal fade modal-no-footer" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase">{{__('Reset Password')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <form id="hh-reset-password-form" action="{{ url('auth/reset-password') }}" method="post"
                          data-validation-id="form-reset-password"
                          data-reload-time="1500"
                          class="form form-action">
                        @include('common.loading')
                        <div class="form-group">
                            <label for="email-address-reset-pass-form">{{__('Email address')}}</label>
                            <input class="form-control has-validation" data-validation="required|email" type="email"
                                   id="email-address-reset-pass-form" name="email" placeholder="{{__('Email')}}">
                        </div>
                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block text-uppercase"
                                    type="submit"> {{__('Reset Password')}}</button>
                        </div>
                        <div class="form-message"></div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->
@endif
<?php
$langs = get_languages(true);
$currencies = list_currencies();
$current_lang = get_current_language();
?>
<div id="hh-modal-global" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header no-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i>
                </button>
            </div>
            <div class="modal-body">
                @if(count($langs))
                    <h4 class="title mt-0">{{__('Select Language')}}</h4>
                    <ul class="list-unstyled list-languages row mt-3">
                        @foreach($langs as $key => $lang)
                            @if($current_lang == $lang['code'])
                                <li class="col-6 col-md-4 mb-3 item current">
                                    <a href="javascript: void(0)">{{__($lang['name'])}}</a>
                                </li>
                            @else
                                <li class="col-6 col-md-4 mb-3 item">
                                    <a href="{{add_query_arg('lang', $lang['code'], current_url())}}">{{$lang['name']}}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
                <!-- @if(count($currencies))
                    <h4 class="title mt-0">{{__('Select Currency')}}</h4>
                    <ul class="list-unstyled list-currencies row mt-3">
                        @foreach($currencies as $key => $currency)
                            @if($currency['unit'] == current_currency('unit'))
                                <li class="col-6 col-md-4 mb-3 item current">
                                    <a href="javascript: void(0)">
                                        <span class="symbol">{{$currency['unit']}} - {{$currency['symbol']}}</span>
                                        <span class="name">{{get_translate($currency['name'])}}</span></a>
                                </li>
                            @else
                                <li class="col-6 col-md-4 mb-3 item">
                                    <a href="{{add_query_arg('currency', $currency['unit'], current_url())}}">
                                        <span class="symbol">{{$currency['unit']}} - {{$currency['symbol']}}</span>
                                        <span class="name">{{get_translate($currency['name'])}}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="body-wrapper">
    <?php
    $sticky = get_option('enable_sticky', 'off');
    $classSticky = '';
    if ($sticky == 'on') {
        enqueue_script('sticky-js');
        $classSticky = 'has-sticky';
    }
    ?>
    <!-- <header id="header" class="header {{$classSticky}}"> -->
    <div class="header-wrapper">
        <header id="header" class="header header-home {{$classSticky}}">
        <span class="d-block d-lg-none" id="toggle-mobile-menu"><span class="top"></span><span class="center"></span><span
                class="bottom"></span></span>
            <a href="{{ url('/') }}" id="logo">
                <?php
                $logo = get_option('logo');
                $logo_url = asset('images/logo.png');
                ?>
                <!-- <img src="{{ $logo_url }}" alt="img-logo" class="img-logo"> -->
                <img alt="img-logo" class="img-logo home-img-logo">
            </a>
            <!-- <nav id="site-navigation" class="main-navigation d-none d-lg-block"
                 aria-label="Primary Menu"> -->
            <nav id="site-navigation" class="main-navigation d-none d-lg-block" 
                 aria-label="Primary Menu">
                <div class="menu-prmary-container">
                    <?php
                    if (has_nav_primary()) {
                        get_nav([
                            'location' => 'primary',
                            'walker' => 'main'
                        ]);
                    }
                    ?>
                </div>
            </nav><!-- #site-navigation -->
            <div id="right-navigation" class="right-navigation">
                <ul class="list-unstyled topnav-menu mb-0">
                    <!-- @if(count($langs) || count($currencies))
                        <li class="dropdown global-list mr-1">
                            <a class="nav-item nav-item--global dropdown-toggle" href="javascript: void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <i class="ti-angle-down" style="color: #115571;"></i>
                                <span class="ml-1" style="text-transform: uppercase;color: #115571;"><?php print_r(get_current_language());?></span>
                            </a>
                            <div class="dropdown-menu">
                                @foreach($langs as $key => $lang)
                                    @if($current_lang == $lang['code'])
                                        <a class="dropdown-item active" href="javascript: void(0)">{{__($lang['name'])}}</a>
                                    @else
                                        <a class="dropdown-item" href="{{add_query_arg('lang', $lang['code'], current_url())}}">{{$lang['name']}}</a>
                                    @endif
                                @endforeach
                            </div>
                        </li>
                    @endif -->
                    @if (is_user_logged_in())
                        <?php
                        $noti = Notifications::get_inst()->countNotificationByUser(get_current_user_id());
                        $user_id = get_current_user_id();
                        $args = [
                            'user_id' => $user_id,
                            'user_encrypt' => hh_encrypt($user_id)
                        ];
                        $userData = get_current_user_data();
                        ?>
                        <li id="hh-dropdown-notification" class="dropdown notification-list"
                            data-action="{{ url('get-notifications') }}"
                            data-params="{{ base64_encode(json_encode($args)) }}">
                            <a class="nav-item dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"
                               role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="fe-bell noti-icon"></i>
                                @if($noti['total'])
                                    <span
                                        class="badge badge-danger rounded-circle noti-icon-badge">{{ $noti['total'] }}</span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">{{__('Notification')}}</h5>
                                </div>
                                <div class="slimscroll noti-scroll">
                                    <div class="notification-render">
                                    </div>
                                </div>
                                <!-- All-->
                                <a href="{{ dashboard_url('all-notifications') }}"
                                   class="dropdown-item text-center text-primary notify-item notify-all">
                                    {{__('View all')}}
                                    <i class="fi-arrow-right"></i>
                                </a>
                            </div>
                        </li>
                        <li class="dropdown notification-list">
                            <a class="nav-item dropdown-toggle nav-user waves-effect waves-light" data-toggle="dropdown"
                               href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ get_user_avatar($userData->getUserId(), [32,32]) }}" alt="user-image"
                                     class="rounded-circle">
                                <span class="pro-user-name ml-1">
                                {{ get_username($userData->getUserId()) }} <i class="ti-angle-down"></i>
                            </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow">{{__('Welcome !')}}</h6>
                                </div>
                                <!-- item-->
                                <a href="{{ dashboard_url('profile') }}" class="dropdown-item notify-item">
                                    <i class="fe-user"></i>
                                    <span>{{__('Profile')}}</span>
                                </a>
                            @if(is_admin() || is_partner())
                                @if(is_enable_service('home'))
                                    <!-- item-->
                                        <a href="{{ dashboard_url('my-home') }}" class="dropdown-item notify-item">
                                            <i class="fe-book-open"></i>
                                            <span>{{__('My Homes')}}</span>
                                        </a>
                                @endif
                                @if(is_enable_service('experience'))
                                    <!-- item-->
                                        <a href="{{ dashboard_url('my-experience') }}" class="dropdown-item notify-item">
                                            <i class="fe-book-open"></i>
                                            <span>{{__('My Experiences')}}</span>
                                        </a>
                                @endif
                                @if(is_enable_service('car'))
                                    <!-- item-->
                                        <a href="{{ dashboard_url('my-car') }}" class="dropdown-item notify-item">
                                            <i class="fe-book-open"></i>
                                            <span>{{__('My Cars')}}</span>
                                        </a>
                                @endif
                            @endif
                            @if(is_admin())
                                <!-- item-->
                                    <a href="{{ dashboard_url('settings') }}" class="dropdown-item notify-item">
                                        <i class="fe-settings "></i>
                                        <span>{{__('Settings')}}</span>
                                    </a>
                            @endif
                            <!-- item-->
                            <?php
                            $data = [
                                'user_id' => $userData->getUserId(),
                                'redirect_url' => current_url()
                            ];
                            ?>
                            <!-- item-->
                                <a href="{{ dashboard_url('/') }}" class="dropdown-item notify-item">
                                    <i class="fe-stop-circle "></i>
                                    <span>{{__('Dashboard')}}</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0)" data-action="{{ auth_url('logout') }}"
                                   data-params="{{ base64_encode(json_encode($data)) }}"
                                   class="dropdown-item notify-item hh-link-action">
                                    <i class="fe-log-out"></i>
                                    <span>{{__('Logout')}}</span>
                                </a>
                            </div>
                        </li>
                    @else
                            <!-- GGH repaired -->
                        <!-- @if(get_option('enable_partner_registration', 'on') == 'on')
                            <li class="d-none d-lg-block li-become mr-1">
                                <a href="javascript: void(0);" data-toggle="modal" data-target="#hh-partner-regist-modal"
                                   class="nav-item become-a-host">{{__('Become a Partner')}}</a>
                            </li>
                            <li class="d-none d-lg-block li-become mr-1">
                                <a href="javascript: void(0);" data-toggle="modal" data-target="#hh-owner-regist-modal"
                                   class="nav-item become-a-host">{{__('Become a Owner')}}</a>
                            </li>
                        @endif
                        <li class="dropdown global-list mr-1 mobile_login_others">
                            @if(get_option('enable_partner_registration', 'on') == 'on')
                                <a class="nav-item nav-item--global dropdown-toggle" href="javascript: void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    
                                    <i class="ti-angle-down" style="color: #115571;"></i>
                                    <span class="ml-1" style="text-transform: uppercase;color: #115571;">Other Login</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a href="javascript: void(0);" data-toggle="modal" data-target="#hh-partner-regist-modal" class="nav-item become-a-host">{{__('Become a Partner')}}</a>
                                    <a href="javascript: void(0);" data-toggle="modal" data-target="#hh-owner-regist-modal"
                                   class="nav-item become-a-host">{{__('Become a Owner')}}</a>
                                </div>
                            @endif
                            
                        </li> -->
                        <li class="li-login">
                            <a href="javascript: void(0);" class="nav-item become-a-host" style="padding-right: 15px !important;"
                               data-toggle="modal"
                               data-target="#hh-login-modal"><i class="fa fa-user"></i></a>
                        </li>
                        
                    @endif
                </ul>
            </div>
        </header>
        @if(!empty($tab_services))
            <div class="hh-search-form-wrapper pr-3 pl-3">
                <div class="row homepage_image_title" style="">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div id="story_talk" class="col-sm-12 col-md-12">
                                <!-- <p style="color: white;">Welcome to Luxury Croatia Retreats</p> -->
                                <?php $blog_title = get_option('blog_title');
                                $blog_content = get_option('blog_content');
                                ?>
                                <h1 style="color: white;font-size: 65px; line-height: 70px;">{{get_translate($blog_title)}}</h1>
                                <div class="mt-5">
                                    <p style="color:white; font-size: 16px;line-height: 20px;">{{get_translate($blog_content)}}</p>
                                </div>
                            </div>
                            <div id="date_advanced" class="col-12 col-sm-12 col-md-12 col-lg-8 mt-4">
                                <div class="row mb-1 pt-1" style="border-radius: 10px; background: white;box-shadow: 0px 18px 17px -3px #edebeb;">
                                    <div class="col-4 col-sm-4 col-md-4 mt-1" style="border-right:1px solid #a39e9e; cursor: pointer;" id="start_range_date">
                                        <div style="display: flex; justify-content: center;font-color: #808080;">
                                            <i class="far fa-calendar-alt mr-2 pt-1"></i><span>Check in</span><i class="fas fa-sort-down ml-2"></i>
                                        </div>
                                        <div style="" id="start_date_display">
                                            22/07/2022
                                        </div>
                                    </div>
                                    <input type="hidden" id="start_checkin">
                                    <div class="col-4 col-sm-4 col-md-4 mt-1" style="border-right:1px solid #a39e9e; cursor: pointer;" id="end_range_date">
                                        <div style="display: flex; justify-content: center;font-color: #808080;">
                                            <i class="far fa-calendar-alt mr-2 pt-1"></i><span>Check out</span><i class="fas fa-sort-down ml-2"></i>
                                        </div>
                                        <div id="end_date_display">
                                            22/07/2022
                                        </div>
                                    </div>
                                    <input type="hidden" id="end_checkout">
                                    <div class="col-4 col-sm-4 col-md-4 mt-1 guest-group">
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
                            <div class="carousel slide col-12 col-sm-12 col-md-12 col-lg-4 mt-4" data-ride="carousel" id="advanced_search_cover">
                                <div>
                                    <div class="advanced_search" onclick="javascript:searchFunc();">
                                        <div style="width:100%; font-size: 25px; color: #fff; line-height: 15px;">
                                            <p style="text-align:center;margin-bottom: 0px;">Search</p>
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
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-sm-12 col-md-12 col-lg-6">
                        <div id="demo" class="carousel slide" data-ride="carousel" style="height: 697px !important;">
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
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div> 
                    </div>-->
                </div>
                    
            </div>
        @endif
    </div>
    <a class="top-link hide" href="" id="js-top">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 6"><path d="M12 6H0l6-6z"/></svg>
    </a>
    <div id="content-area">