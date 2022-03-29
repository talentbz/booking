<?php
$users = \App\Addons\ChatController::get_inst()->getUsersInChannel($channel_id);
$user_data = get_user_by_id($users['to_user']);
?>
<div class="chats">
    <div class="chat-body">

        <!-- Chat Header Start-->
        <div class="chat-header">
            <!-- Chat Back Button (Visible only in Small Devices) -->
            <button class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted d-xl-none" type="button"
                    data-close="">
                <!-- Default :: Inline SVG -->
                <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>

                <!-- Alternate :: External File link -->
            <!-- <img class="injectable hw-20" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/arrow-left.svg" alt=""> -->
            </button>

            <!-- Chat participant's Name -->
            <div class="media chat-name align-items-center text-truncate">
                <div class="avatar d-none d-sm-inline-block mr-3"><!--avatar-online-->
                    <a data-toggle="tab" href="#customer-info" role="tab" aria-controls="user-info"
                       aria-selected="false">
                        <img src="{{ get_user_avatar($user_data->getUserId(), [48,48]) }}"
                             alt="{{ get_username($user_data->getUserId()) }}">
                    </a>
                </div>

                <div class="media-body align-self-center ">
                    <h6 class="text-truncate mb-0">{{get_username($user_data->getUserId())}}</h6>
                    <!-- <small class="text-muted">Online</small> -->
                </div>
            </div>
        </div>
        <!-- Chat Header End-->

        <!-- Chat Content Start-->
        <div class="chat-content p-2" id="messageBody"
             data-action="{{dashboard_url('messenger/refresh-message')}}"
             data-channel_id="{{ $channel_id }}"
             data-encrypt="{{ hh_encrypt($channel_id) }}">
            <div class="chat-content-render">
                @include("messenger::components.chat-conversation-item")
            </div>
            <!-- Scroll to finish -->
            <div class="chat-finished" id="chat-finished"></div>
        </div>
        <!-- Chat Content End-->

        <!-- Chat Footer Start-->
        <div class="chat-footer">
        <!--            <div class="attachment">
                <div class="dropdown">
                    <button class="btn btn-secondary btn-icon btn-minimal btn-sm" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>

                    &lt;!&ndash; <img class="injectable hw-20" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/plus-circle.svg" alt=""> &ndash;&gt;
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript: void(0);">
                            <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        &lt;!&ndash; <img class="injectable hw-20 mr-2" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/photograph.svg" alt=""> &ndash;&gt;
                            <span>Gallery</span>
                        </a>
                        <a class="dropdown-item" href="javascript: void(0);">
                            <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                            </svg>

                        &lt;!&ndash; <img class="injectable hw-20 mr-2" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/volume-up.svg" alt=""> &ndash;&gt;
                            <span>Audio</span>
                        </a>
                        <a class="dropdown-item" href="javascript: void(0);">
                            <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>

                        &lt;!&ndash; <img class="injectable hw-20 mr-2" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/document.svg" alt=""> &ndash;&gt;
                            <span>Document</span>
                        </a>
                        <a class="dropdown-item" href="javascript: void(0);">
                            <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>

                        &lt;!&ndash; <img class="injectable hw-20 mr-2" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/user.svg" alt=""> &ndash;&gt;
                            <span>Contact</span>
                        </a>
                        <a class="dropdown-item" href="javascript: void(0);">
                            <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>

                        &lt;!&ndash; <img class="injectable hw-20 mr-2" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/location-marker.svg" alt=""> &ndash;&gt;
                            <span>Location</span>
                        </a>
                        <a class="dropdown-item" href="javascript: void(0);">
                            <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>

                        &lt;!&ndash; <img class="injectable hw-20 mr-2" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/chart-square-bar.svg" alt=""> &ndash;&gt;
                            <span>Poll</span>
                        </a>
                    </div>
                </div>
            </div>-->
            <form action="{{ dashboard_url('messenger/messenger-post') }}" class="form form-messenger-input">
                <label class="d-none" for="messageInput"></label>
                <textarea class="form-control emojionearea-form-control" id="messageInput" rows="1"
                          placeholder="{{__('Type your message here...')}}" name="message"></textarea>
                <button id="messageSubmit" type="submit" class="btn btn-primary btn-icon send-icon rounded-circle text-light mb-1"
                        role="button">
                    <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
                <input type="hidden" name="channel_id" value="{{$channel_id}}">
                <input type="hidden" name="encrypt" value="{{hh_encrypt($channel_id)}}">
                <input type="hidden" name="user_id" value="{{get_current_user_id()}}">
            </form>
        </div>
        <!-- Chat Footer End-->
    </div>

    <!-- Chat Info Start -->
    <div class="chat-info">
        <div class="d-flex h-100 flex-column">

            <!-- Chat Info Header Start -->
            <div class="chat-info-header px-2">
                <div class="container-fluid">
                    <ul class="nav justify-content-between align-items-center">
                        <!-- Sidebar Title Start -->
                        <li class="text-center">
                            <h5 class="text-truncate mb-0">Profile Details</h5>
                        </li>
                        <!-- Sidebar Title End -->

                        <!-- Close Sidebar Start -->
                        <li class="nav-item list-inline-item">
                            <a class="nav-link text-muted px-0" href="javascript: void(0);" data-chat-info-close="">
                                <!-- Default :: Inline SVG -->
                                <svg class="hw-22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>

                                <!-- Alternate :: External File link -->
                            <!-- <img class="injectable hw-22" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/x.svg" alt=""> -->

                            </a>
                        </li>
                        <!-- Close Sidebar End -->
                    </ul>
                </div>
            </div>
            <!-- Chat Info Header End  -->

            <!-- Chat Info Body Start  -->
            <div class="hide-scrollbar flex-fill">

                <!-- User Profile Start -->
                <div class="text-center p-3">

                    <!-- User Profile Picture -->
                    <div class="avatar avatar-xl mx-5 mb-3">
                        <img class="avatar-img" src="{{ChatRegister::get_inst()->url}}/assets/media/avatar/2.png"
                             alt="">
                    </div>

                    <!-- User Info -->
                    <h5 class="mb-1">Catherine Richardson</h5>
                    <p class="text-muted d-flex align-items-center justify-content-center">
                        <!-- Default :: Inline SVG -->
                        <svg class="hw-18 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>

                        <!-- Alternate :: External File link -->
                    <!-- <img class="injectable mr-1 hw-18" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/location-marker.svg" alt=""> -->
                        <span>San Fransisco, CA</span>
                    </p>

                    <!-- User Quick Options -->
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="btn btn-outline-default btn-icon rounded-circle mx-1">
                            <!-- Default :: Inline SVG -->
                            <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>

                            <!-- Alternate :: External File link -->
                        <!-- <img class="injectable hw-20" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/user-add.svg" alt=""> -->
                        </div>
                        <div class="btn btn-primary btn-icon rounded-circle text-light mx-1">
                            <!-- Default :: Inline SVG -->
                            <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>

                            <!-- Alternate :: External File link -->
                        <!-- <img class="injectable hw-20" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/heart.svg" alt=""> -->
                        </div>
                        <div class="btn btn-danger btn-icon rounded-circle text-light mx-1">
                            <!-- Default :: Inline SVG -->
                            <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>

                            <!-- Alternate :: External File link -->
                        <!-- <img class="injectable hw-20" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/ban.svg" alt=""> -->
                        </div>
                    </div>
                </div>
                <!-- User Profile End -->

                <!-- User Information Start -->
                <div class="chat-info-group">
                    <a class="chat-info-group-header" data-toggle="collapse" href="#profile-info" role="button"
                       aria-expanded="true" aria-controls="profile-info">
                        <h6 class="mb-0">User Information</h6>

                        <!-- Default :: Inline SVG -->
                        <svg class="hw-20 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>

                        <!-- Alternate :: External File link -->
                    <!-- <img class="injectable text-muted hw-20" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/information-circle.svg" alt=""> -->
                    </a>

                    <div class="chat-info-group-body collapse show" id="profile-info">
                        <div class="chat-info-group-content list-item-has-padding">
                            <!-- List Group Start -->
                            <ul class="list-group list-group-flush ">

                                <!-- List Group Item Start -->
                                <li class="list-group-item border-0">
                                    <p class="small text-muted mb-0">Phone</p>
                                    <p class="mb-0">+01-222-364522</p>
                                </li>
                                <!-- List Group Item End -->

                                <!-- List Group Item Start -->
                                <li class="list-group-item border-0">
                                    <p class="small text-muted mb-0">Email</p>
                                    <p class="mb-0">catherine.richardson@gmail.com</p>
                                </li>
                                <!-- List Group Item End -->

                                <!-- List Group Item Start -->
                                <li class="list-group-item border-0">
                                    <p class="small text-muted mb-0">Address</p>
                                    <p class="mb-0">1134 Ridder Park Road, San Fransisco, CA 94851</p>
                                </li>
                                <!-- List Group Item End -->
                            </ul>
                            <!-- List Group End -->
                        </div>
                    </div>
                </div>
                <!-- User Information End -->

                <!-- Shared Media Start -->
                <div class="chat-info-group">
                    <a class="chat-info-group-header" data-toggle="collapse" href="#shared-media" role="button"
                       aria-expanded="true" aria-controls="shared-media">
                        <h6 class="mb-0">Last Media</h6>

                        <!-- Default :: Inline SVG -->
                        <svg class="hw-20 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>

                        <!-- Alternate :: External File link -->
                    <!-- <img class="injectable text-muted hw-20" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/photograph.svg" alt=""> -->
                    </a>

                    <div class="chat-info-group-body collapse show" id="shared-media">
                        <div class="chat-info-group-content">
                            <!-- Shared Media -->
                            <div class="form-row">
                                <div class="col-4 col-md-2 col-xl-4">
                                    <a href="javascript: void(0);">
                                        <img src="{{ChatRegister::get_inst()->url}}/assets/media/shared-photos/01.jpg"
                                             class="img-fluid rounded border" alt="">
                                    </a>
                                </div>
                                <div class="col-4 col-md-2 col-xl-4">
                                    <a href="javascript: void(0);">
                                        <img src="{{ChatRegister::get_inst()->url}}/assets/media/shared-photos/02.jpg"
                                             class="img-fluid rounded border" alt="">
                                    </a>
                                </div>
                                <div class="col-4 col-md-2 col-xl-4">
                                    <a href="javascript: void(0);">
                                        <img src="{{ChatRegister::get_inst()->url}}/assets/media/shared-photos/03.jpg"
                                             class="img-fluid rounded border" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Shared Media End -->

                <!-- Shared Files Start -->
                <div class="chat-info-group">
                    <a class="chat-info-group-header" data-toggle="collapse" href="#shared-files" role="button"
                       aria-expanded="true" aria-controls="shared-files">
                        <h6 class="mb-0">Documents</h6>

                        <!-- Default :: Inline SVG -->
                        <svg class="hw-20 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>

                        <!-- Alternate :: External File link -->
                    <!-- <img class="injectable text-muted hw-20" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/document.svg" alt=""> -->
                    </a>

                    <div class="chat-info-group-body collapse show" id="shared-files">
                        <div class="chat-info-group-content list-item-has-padding">
                            <!-- List Group Start -->
                            <ul class="list-group list-group-flush">

                                <!-- List Group Item Start -->
                                <li class="list-group-item">
                                    <div class="document">
                                        <div class="btn btn-primary btn-icon rounded-circle text-light mr-2">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                        <!-- <img class="injectable hw-24" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/document.svg" alt=""> -->
                                        </div>

                                        <div class="document-body">
                                            <h6 class="text-truncate">
                                                <a href="javascript: void(0);" class="text-reset"
                                                   title="effects-of-global-warming.docs">Effects-of-global-warming.docs</a>
                                            </h6>

                                            <ul class="list-inline small mb-0">
                                                <li class="list-inline-item">
                                                    <span class="text-muted">79.2 KB</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <span class="text-muted text-uppercase">docs</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="document-options ml-1">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <!-- Default :: Inline SVG -->
                                                    <svg class="hw-20" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                                    </svg>

                                                    <!-- Alternate :: External File link -->
                                                <!-- <img class="injectable hw-20" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/dots-vertical.svg" alt=""> -->
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript: void(0);">Download</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Share</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- List Group Item End -->

                                <!-- List Group Item Start -->
                                <li class="list-group-item">
                                    <div class="document">
                                        <div class="btn btn-primary btn-icon rounded-circle text-light mr-2">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                        <!-- <img class="injectable hw-24" src="{{ChatRegister::get_inst()->url}}/assets/media/icons/excel-file.svg" alt=""> -->
                                        </div>

                                        <div class="document-body">
                                            <h6 class="text-truncate">
                                                <a href="javascript: void(0);" class="text-reset"
                                                   title="global-warming-data-2020.xlxs">Global-warming-data-2020.xlxs</a>
                                            </h6>

                                            <ul class="list-inline small mb-0">
                                                <li class="list-inline-item">
                                                    <span class="text-muted">79.2 KB</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <span class="text-muted text-uppercase">xlxs</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="document-options ml-1">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <!-- Default :: Inline SVG -->
                                                    <svg class="hw-20" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                                    </svg>

                                                    <!-- Alternate :: External File link -->
                                                <!-- <img class="injectable hw-20" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/dots-vertical.svg" alt=""> -->
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript: void(0);">View</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Share</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- List Group Item End -->

                                <!-- List Group Item Start -->
                                <li class="list-group-item">
                                    <div class="document">
                                        <div class="btn btn-primary btn-icon rounded-circle text-light mr-2">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                        <!-- <img class="injectable hw-24" src="{{ChatRegister::get_inst()->url}}/assets/media/icons/powerpoint-file.svg" alt=""> -->
                                        </div>

                                        <div class="document-body">
                                            <h6 class="text-truncate">
                                                <a href="javascript: void(0);" class="text-reset"
                                                   title="great-presentation-on global-warming-2020.ppt">Great-presentation-on
                                                    global-warming-2020.ppt</a>
                                            </h6>

                                            <ul class="list-inline small mb-0">
                                                <li class="list-inline-item">
                                                    <span class="text-muted">79.2 KB</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <span class="text-muted text-uppercase">ppt</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="document-options ml-1">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <!-- Default :: Inline SVG -->
                                                    <svg class="hw-20" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                                    </svg>

                                                    <!-- Alternate :: External File link -->
                                                <!-- <img class="injectable hw-20" src="{{ChatRegister::get_inst()->url}}/assets/media/heroicons/outline/dots-vertical.svg" alt=""> -->
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript: void(0);">Download</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Share</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- List Group Item End -->
                            </ul>
                            <!-- List Group End -->
                        </div>
                    </div>
                </div>
                <!-- Shared Files End -->

            </div>
            <!-- Chat Info Body Start  -->

        </div>
    </div>
    <!-- Chat Info End -->
</div>
