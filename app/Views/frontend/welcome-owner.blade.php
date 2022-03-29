@include('frontend.components.header-blank', ['bodyClass' => 'authentication-bg authentication-bg-pattern'])
<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-pattern mt-5">
                    <div class="card-body p-4">
                        <div class="mt-3 text-center">
                            <img src="/images/logo.png" style="width: 300px; height: 100px;"></img>
                            <h3>{{ __('Thank you for your registration!') }}</h3>
                            <?php
                            $userdata = get_user_by_id($user_id);
                            ?>
                            <p class="text-muted font-16 mt-2">Congratulations on successfully registering for Luxury Croatia Retreat!</p>
                            <!-- <p class="text-muted font-14 mt-2">{!! sprintf(__('An email has been sent to <b>%s</b>.'), $userdata->email) !!}
                                <br/>{{__('Please check your inbox to confirm your login information.')}}</p> -->
                            <a href="{{url('/')}}"
                               class="btn btn-block btn-pink waves-effect waves-light mt-3" style="color: #000;">{{__('Back to Home')}}</a>
                        </div>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<footer class="footer footer-alt">
    {!! balanceTags(get_option('copy_right')) !!}
</footer>
@include('frontend.components.footer-blank')
