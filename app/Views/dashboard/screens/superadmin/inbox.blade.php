@include('dashboard.components.header')
<div id="wrapper">
    @include('dashboard.components.top-bar')
    @include('dashboard.components.nav')
    <div class="content-page">
        <div class="content">
            @include('dashboard.components.breadcrumb', ['heading' => __('Inbox')])
            {{--Start Content--}}
            <div class="card-box">
                <div class="header-area d-flex align-items-center">
                    <h4 class="header-title mb-0">{{__('Inbox')}}</h4>
                </div>
                <?php
                enqueue_style('inbox-app-css');
                enqueue_style('inbox-all-css');
                enqueue_script('inbox-js');
                ?>
                <div class="email-app mb-4" id="app">
                    @include('dashboard.components.mailnav')
                    <router-view></router-view>
                </div>
            </div>
            {{--End content--}}
            @include('dashboard.components.footer-content')
        </div>
    </div>
</div>
@include('dashboard.components.footer')

