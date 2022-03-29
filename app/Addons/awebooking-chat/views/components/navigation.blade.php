<div class="navigation navbar navbar-light bg-primary">
    <!-- Logo Start -->
    <a class="logo d-none d-xl-block bg-light rounded p-1" href="{{dashboard_url('/')}}">
        <?php
        $logo = get_option('dashboard_logo');
        $logo_url = get_attachment_url($logo);
        ?>
        <img src="{{ $logo_url }}" alt="{{get_attachment_alt($logo)}}">
    </a>
    <!-- Logo End -->

    <!-- Main Nav Start -->
    <ul class="nav nav-minimal flex-row flex-grow-1 justify-content-between flex-xl-column justify-content-xl-start mt-xl-4"
        id="mainNavTab" role="tablist">

        <!-- Chats Tab Start -->
        <li class="nav-item">
            <a class="nav-link p-0 py-xl-3 active" id="chats-tab" href="#chats-content" title="Chats">
                <!-- Default :: Inline SVG -->
                <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                </svg>
            </a>
        </li>
        <!-- Chats Tab End -->

        <!-- Profile Tab Start -->
        <li class="nav-item">
            <a class="nav-link p-0 py-xl-3" id="profile-tab" href="#profile-content" title="Profile">
                <!-- Default :: Inline SVG -->
                <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </a>
        </li>
        <!-- Profile Tab End -->
    @if(is_admin())
        <!-- Settings tab Start -->
            <li class="nav-item">
                <a class="nav-link p-0 py-xl-3" id="settings-tab" href="#settings-content" title="Profile">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </a>
            </li>
            <!-- Settings tab End -->
        @endif
    </ul>
    <!-- Main Nav End -->
</div>
