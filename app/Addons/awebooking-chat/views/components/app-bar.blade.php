<?php
$users = \App\Addons\ChatController::get_inst()->getUsersInChannel($channel_id);
$user_data = get_user_by_id($users['to_user']);
?>
<div class="appbar">
    <div class="appbar-wrapper hide-scrollbar">

        <!-- Chat Back Button (Visible only in Small Devices) -->
        <div class="d-flex justify-content-center border-bottom w-100">
            <button class="btn btn-secondary btn-icon m-0 btn-minimal btn-sm text-muted d-xl-none" type="button"
                    data-apps-close="">
                <!-- Default :: Inline SVG -->
                <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>

            </button>
        </div>


        <div class="appbar-head">
            <!-- Default :: Inline SVG -->
            <svg class="hw-20" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>

            <h6 class="mb-0 mt-1">Apps</h6>
        </div>


        <!-- Appbar Nav Start -->
        <ul class="nav nav-minimal appbar-nav" id="appNavTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link d-block d-xl-none" id="customer-info-tab" data-toggle="tab" href="#customer-info"
                   role="tab"
                   aria-controls="translator" aria-selected="true">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="translator-tab" data-toggle="tab" href="#translator" role="tab"
                   aria-controls="translator" aria-selected="true">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="translator-tab" data-toggle="tab" href="#translator" role="tab"
                   aria-controls="translator" aria-selected="true">
                    inbox
                </a>
            </li>
        </ul>
        <!-- Appbar Nav End -->
    </div>

    <!-- Tab panes -->
    <div class="tab-content appnavbar-content">
        <div class="tab-pane h-100 active" id="customer-info" role="tabpanel">
            <div class="appnavbar-content-wrapper">
                <div class="appnavbar-scrollable-wrapper">
                    <div class="appnavbar-heading sticky-top">
                        <ul class="nav justify-content-between align-items-center">
                            <!-- Sidebar Title Start -->
                            <li class="text-center">
                                <img class="rounded-circle"
                                     src="{{ get_user_avatar($user_data->getUserId(), [48,48]) }}"
                                     alt="{{ get_username($user_data->getUserId()) }}">
                            </li>
                            <!-- Sidebar Title End -->

                            <!-- Close Sidebar Start -->
                            <li class="nav-item list-inline-item">
                                <div data-appcontent-close="">
                                    <!-- Default :: Inline SVG -->
                                    <svg class="hw-22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </li>
                            <!-- Close Sidebar End -->
                        </ul>
                    </div>
                    <div class="appnavbar-body">
                        <div class="p-2 mt-2">
                            <div class="card text-lefth-100 w-100">
                                <!-- List Group Start -->
                                <ul class="list-group list-group-flush">
                                    <!-- List Group Item Start -->
                                    <li class="list-group-item py-2">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <p class="small text-muted mb-0">{{__('Full Name')}}</p>
                                                <p class="mb-0">{{get_username($user_data->getUserId())}}</p>
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
                                                <p class="mb-0">{{ $user_data->email }}</p>
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
                                                <p class="mb-0">{{$user_data->mobile}}</p>
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
                                                <p class="mb-0">{{$user_data->address}}</p>
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
                                                <p class="mb-0">{{ get_country_by_code($user_data->location)['name'] }}</p>
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
                                @if($user_data->description)
                                    <!-- List Group Item Start -->
                                        <li class="list-group-item py-2">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <p class="small text-muted mb-0">{{__('About me')}}</p>
                                                    <p class="mb-0">{!! balanceTags(nl2br($user_data->description)) !!}</p>
                                                </div>
                                                <!-- Default :: Inline SVG -->
                                                <svg class="text-muted" xmlns="http://www.w3.org/2000/svg" height="20"
                                                     width="20"
                                                     fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                                </svg>
                                            </div>
                                        </li>
                                        <!-- List Group Item End -->
                                    @endif
                                </ul>
                                <!-- List Group End -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane h-100" id="translator" role="tabpanel" aria-labelledby="translator-tab">
            <div class="appnavbar-content-wrapper">
                <div class="appnavbar-scrollable-wrapper">
                    <div class="appnavbar-heading sticky-top">
                        <ul class="nav justify-content-between align-items-center">
                            <!-- Sidebar Title Start -->
                            <li class="text-center">
                                <h5 class="text-truncate mb-0">{{__('Translator')}}</h5>
                            </li>
                            <!-- Sidebar Title End -->

                            <!-- Close Sidebar Start -->
                            <li class="nav-item list-inline-item">
                                <div data-appcontent-close="">
                                    <!-- Default :: Inline SVG -->
                                    <svg class="hw-22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </li>
                            <!-- Close Sidebar End -->
                        </ul>
                    </div>
                    <form action="{{dashboard_url('messenger/translator')}}" class="form-translator relative">
                        @include("messenger::loading")
                        <div class="appnavbar-body">
                            <div class="appnavbar-body-title">
                                <div class="dropdown button-language-wrapper w-100">
                                    <!-- Dropdown Button Start -->
                                    <button class="btn btn-outline-default btn-block dropdown-toggle button-language-from" type="button"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" data-language="en">{{__('English')}}
                                    </button>
                                    <!-- Dropdown Button End -->

                                    <!-- Dropdown Menu Start -->
                                    <div class="dropdown-menu">
                                        @foreach(get_translator_languages() as $key => $name)
                                            <a class="dropdown-item" href="javascript: void(0)"
                                               data-lang="{{$key}}">{{trim($name)}}</a>
                                        @endforeach
                                    </div>
                                    <!-- Dropdown Menu End -->
                                </div>

                                <svg class="injetable hw-16 text-muted mx-1" xmlns="http://www.w3.org/2000/svg" height="24" width="24"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>

                                <div class="dropdown button-language-wrapper w-100">
                                    <!-- Dropdown Button Start -->
                                    <button class="btn btn-outline-default btn-block dropdown-toggle button-language-to" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" data-language="en"
                                            aria-expanded="false">{{__('English')}}
                                    </button>
                                    <!-- Dropdown Button End -->

                                    <!-- Dropdown Menu Start -->
                                    <div class="dropdown-menu">
                                        @foreach(get_translator_languages() as $key => $name)
                                            <a class="dropdown-item" href="javascript: void(0)"
                                               data-lang="{{$key}}">{{$name}}</a>
                                        @endforeach
                                    </div>
                                    <!-- Dropdown Menu End -->
                                </div>
                            </div>

                            <div class="translator-container p-2">
                                <div class="form-group">
                                    <label for="translate-text">{{__('Write text here')}}</label>
                                    <textarea id="translate-text" class="form-control" rows="6"
                                              name="translate_text"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="translate-text-results">{{__('Results')}}</label>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="translate-text-result mb-0"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="appnavbar-footer">
                            <button type="submit" class="btn btn-primary btn-block">{{__('Translate')}}</button>
                            <input type="hidden" name="language_from" value="en">
                            <input type="hidden" name="language_to" value="en">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
