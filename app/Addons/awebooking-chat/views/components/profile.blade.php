<?php
$current_user = get_current_user_data();
$user_id = $current_user->getUserId();
?>
<div class="tab-pane" id="profile-content">
    <div class="d-flex flex-column h-100">
        <div class="hide-scrollbar">
            <!-- Sidebar Header Start -->
            <div class="sidebar-header sticky-top p-2 pt-3 mb-3">
                <h5 class="font-weight-semibold">{{__('Profile')}}</h5>
                <p class="text-muted mb-0">{{__('Personal Information & Settings')}}</p>
            </div>
            <!-- Sidebar Header end -->

            <!-- Sidebar Content Start -->
            <div class="container-xl">
                <div class="row">
                    <div class="col">

                        <!-- Card Start -->
                        <div class="card card-body card-bg-5">

                            <!-- Card Details Start -->
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar avatar-lg mb-3">
                                    <img class="avatar-img" src="{{ get_user_avatar($user_id) }}"
                                         alt="{{ get_username($user_id) }}">
                                </div>

                                <div class="d-flex flex-column align-items-center">
                                    <h5>{{get_username($user_id)}}</h5>
                                </div>

                                <div class="d-flex">
                                    <a href="{{ logout_url(dashboard_url('/')) }}" class="btn btn-outline-default mx-1">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-18 d-none d-sm-inline-block" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>{{__('Logout')}}</span>
                                    </a>
                                    <button class="btn btn-outline-default mx-1 d-xl-none"
                                            data-profile-edit="" type="button">
                                        <!-- Default :: Inline SVG -->
                                        <svg class="hw-18 d-none d-sm-inline-block" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span>{{__('Dashboard')}}</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Card Details End -->
                        </div>
                        <!-- Card End -->

                        <!-- Card Start -->
                        <div class="card mt-3">

                            <!-- List Group Start -->
                            <ul class="list-group list-group-flush">

                                <!-- List Group Item Start -->
                                <li class="list-group-item py-2">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <p class="small text-muted mb-0">{{__('Full Name')}}</p>
                                            <p class="mb-0">{{get_username($current_user->getUserId())}}</p>
                                        </div>
                                        <!-- Default :: Inline SVG -->
                                        <svg class="text-muted hw-20 ml-1" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </li>
                                <!-- List Group Item End -->

                                <!-- List Group Item Start -->
                                <li class="list-group-item py-2">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <p class="small text-muted mb-0">{{__('Email')}}</p>
                                            <p class="mb-0">{{$current_user->email}}</p>
                                        </div>

                                        <!-- Default :: Inline SVG -->
                                        <svg class="text-muted hw-20 ml-1" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </li>
                                <!-- List Group Item End -->

                                <!-- List Group Item Start -->
                                <li class="list-group-item py-2">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <p class="small text-muted mb-0">{{__('Mobile')}}</p>
                                            <p class="mb-0">{{$current_user->mobile}}</p>
                                        </div>
                                        <!-- Default :: Inline SVG -->
                                        <svg class="text-muted hw-20 ml-1" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                </li>
                                <!-- List Group Item End -->

                                <!-- List Group Item Start -->
                                <li class="list-group-item pt-2">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <p class="small text-muted mb-0">{{__('Address')}}</p>
                                            <p class="mb-0">{{$current_user->address}}</p>
                                        </div>
                                        <!-- Default :: Inline SVG -->
                                        <svg class="text-muted hw-20 ml-1" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>
                                </li>
                                <!-- List Group Item End -->

                                <!-- List Group Item Start -->
                                <li class="list-group-item py-2">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <p class="small text-muted mb-0">{{__('Location')}}</p>
                                            <p class="mb-0">{{ get_country_by_code($current_user->location)['name'] }}</p>
                                        </div>
                                        <!-- Default :: Inline SVG -->
                                        <svg class="text-muted hw-20 ml-1" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </li>
                                <!-- List Group Item End -->
                            </ul>
                            <!-- List Group End -->

                        </div>
                        <!-- Card End -->
                    @if($current_user->description)
                        <!-- Card Start -->
                            <div class="card my-3">

                                <!-- List Group Start -->
                                <ul class="list-group list-group-flush">

                                    <!-- List Group Item Start -->
                                    <li class="list-group-item py-2">
                                        <p class="small text-muted mb-0">{{__('About Me')}}</p>
                                        <p class="font-size-sm font-weight-medium">
                                            {!! balanceTags(nl2br($current_user->description)) !!}
                                        </p>
                                    </li>
                                    <!-- List Group Item End -->
                                </ul>
                                <!-- List Group End -->
                            </div>
                            <!-- Card End -->
                        @endif
                    </div>
                </div>
            </div>
            <!-- Sidebar Content End -->
        </div>
    </div>
</div>
