<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <!-- SEO Meta Tags-->
    <meta name="keywords" content="quicky, chat, messenger, conversation, social, communication"/>
    <meta name="description"
          content="Quicky is a Bootstrap based modern and fully responsive Messaging template to help build Messaging or Chat application fast and easy."/>
    <meta name="subject" content="communication">
    <meta name="revised" content="Tuesday, November 10th, 2020, 08:00 am"/>
    <title>{{ page_title() }}</title>
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180"
          href="{{ChatRegister::get_inst()->url}}/assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
          href="{{ChatRegister::get_inst()->url}}/assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
          href="{{ChatRegister::get_inst()->url}}/assets/img/favicon-16x16.png">
    <link rel="shortcut icon" href="{{ChatRegister::get_inst()->url}}/assets/img/favicon.ico"/>
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ChatRegister::get_inst()->url}}/assets/webfonts/inter/inter.css">
    <link rel="stylesheet" href="{{ChatRegister::get_inst()->url}}/assets/css/app.min.css">
    <link rel="stylesheet" href="{{ChatRegister::get_inst()->url}}/assets/css/style.css">
    <?php
        $messenger_params = [
            'refresh_time' => (int) get_opt('messenger_refresh_time', 1)
        ];
    ?>
    <script>
        var messenger_params = <?php echo json_encode($messenger_params); ?>
    </script>
</head>

<body class="chats-tab-open">

<!-- Main Layout Start -->
<div class="main-layout">
    <!-- Navigation Start -->
@include("messenger::components.navigation")
<!-- Navigation End -->

    <!-- Sidebar Start -->
    <aside class="sidebar">
        <!-- Tab Content Start -->
        <div class="tab-content">
            <!-- Chat Tab Content Start -->
            <div class="tab-pane active" id="chats-content">
                <div class="d-flex flex-column h-100">
                    <div class="hide-scrollbar h-100" id="chatContactsList">

                        <!-- Chat Header Start -->
                        <div class="sidebar-header sticky-top p-2 pt-3">

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="chat-heading d-flex align-items-center">
                                    <h5 class="font-weight-semibold mb-0">{{__('Inbox')}}</h5>
                                    @if(isset($channel_id))
                                    <a href="#" class="d-inline-block d-xl-none text-muted ml-2" data-close title="{{__('Back')}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                        </svg>
                                    </a>
                                        @endif
                                </div>

                                <ul class="nav flex-nowrap">
                                    <li class="nav-item list-inline-item d-block d-xl-none mr-1">
                                        <a class="nav-link text-muted px-1" title="{{__('New conversation')}}" href="#" role="button" data-toggle="modal"
                                           data-target="#startConversation">
                                            <svg class="hw-20" xmlns="http://www.w3.org/2000/svg" height="24" width="24"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                        </a>
                                    </li>

                                    <li class="nav-item list-inline-item d-block d-xl-none mr-1">
                                        <a class="nav-link text-muted px-1" href="#" title="{{__('Appbar')}}"
                                           data-toggle-appbar="">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-20" fill="none" stroke-linecap="round"
                                                 stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path
                                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Sidebar Header Start -->
                            @include("messenger::components.search-channel")
                            <!-- Sidebar Header End -->
                        </div>
                        <!-- Chat Header End -->

                        <!-- Chat Contact List Start -->
                        @include("messenger::components.contacts-tab")
                        <!-- Chat Contact List End -->
                    </div>
                </div>
            </div>
            <!-- Chats Tab Content End -->
            <!-- Profile Tab Content Start -->
            @include("messenger::components.profile")
            <!-- Profile Tab Content End -->
            @if(is_admin())
            <!-- Settings Tab Content Start -->
            @include("messenger::components.settings")
                @endif
        </div>
        <!-- Tab Content End -->
    </aside>
    <!-- Sidebar End -->

    <!-- Main Start -->
    <main class="main @if(isset($channel_id)) main-visible @endif">
        <!-- Chats Page Start -->
        @if(isset($channel_id))
            @include("messenger::components.conversation")
        @else
            @include("messenger::components.welcome")
        @endif
        <!-- Chats Page End -->
    </main>
    <!-- Main End -->
    <!-- Apps Bar-->
    @if(isset($channel_id))
        @include("messenger::components.app-bar")
    @endif

    <div class="backdrop"></div>

    <!-- All Modals Start -->

    <!-- Modal 1 :: Start a Conversation-->
    @include("messenger::components.new-chat")

    <!-- Modal 4 :: Notifications -->

    <!-- Modal 5 :: Add Note -->
    <div class="modal modal-lg-fullscreen fade" id="addNoteModal" tabindex="-1" role="dialog"
         aria-labelledby="addNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNoteModalLabel">Add new note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="addNoteName" class="col-form-label">Note title:</label>
                            <input type="text" class="form-control" id="addNoteName" value=""
                                   placeholder="Add note title here">
                        </div>
                        <div class="form-group">
                            <label for="addNoteDetails" class="col-form-label">Note details:</label>
                            <textarea class="form-control hide-scrollbar" id="addNoteDetails" rows="4"
                                      placeholder="Add note descriptions"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Note tag:</label>
                            <select class="custom-select font-size-sm shadow-none">
                                <option selected>Personal</option>
                                <option value="1">Important</option>
                                <option value="2">Work</option>
                                <option value="3">Favourite</option>
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Add task</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 6 :: Edit Task -->
    <div class="modal modal-lg-fullscreen fade" id="taskModal" tabindex="-1" role="dialog"
         aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Edit task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="editTaskName" class="col-form-label">Task name:</label>
                            <input type="text" class="form-control" id="editTaskName" value="Dinner with friends"
                                   placeholder="Add task name here">
                        </div>
                        <div class="form-group">
                            <label for="editTaskDetails" class="col-form-label">Task details:</label>
                            <textarea class="form-control hide-scrollbar" id="editTaskDetails" rows="4"
                                      placeholder="Add task descriptions">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis temporibus vel, molestiae nobis dolor aut sapiente. Vero possimus molestias consequatur quod, quo rem autem molestiae, accusantium nemo culpa eos doloremque?
                        </textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Finish</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 7 :: Add Task -->
    <div class="modal modal-lg-fullscreen fade" id="addTaskModal" tabindex="-1" role="dialog"
         aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Add new task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="addTaskName" class="col-form-label">Task name:</label>
                            <input type="text" class="form-control" id="addTaskName" value=""
                                   placeholder="Add task name here">
                        </div>
                        <div class="form-group">
                            <label for="addTaskDetails" class="col-form-label">Task details:</label>
                            <textarea class="form-control hide-scrollbar" id="addTaskDetails" rows="4"
                                      placeholder="Add task descriptions"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Add task</button>
                </div>
            </div>
        </div>
    </div>

    <!-- All Modals End -->

</div>
<!-- Main Layout End -->

<!-- Javascript Files -->
<script src="{{ChatRegister::get_inst()->url}}/assets/vendors/jquery/jquery-3.5.0.min.js"></script>
<script src="{{ChatRegister::get_inst()->url}}/assets/vendors/bootstrap/bootstrap.bundle.min.js"></script>
<script src="{{ChatRegister::get_inst()->url}}/assets/vendors/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="{{ChatRegister::get_inst()->url}}/assets/vendors/svg-inject/svg-inject.min.js"></script>
<script src="{{ChatRegister::get_inst()->url}}/assets/vendors/modal-stepes/modal-steps.min.js"></script>
<script src="{{ChatRegister::get_inst()->url}}/assets/vendors/emojione/emojionearea.min.js"></script>
<script src="{{ChatRegister::get_inst()->url}}/assets/js/app.js"></script>
<script src="{{ChatRegister::get_inst()->url}}/assets/js/messenger.js"></script>
</body>
</html>
