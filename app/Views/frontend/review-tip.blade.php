@include('frontend.components.review-header')
<?php
enqueue_script('scroll-magic-js');
?>
<style>
    .table thead th {
        border: 0px;
        text-align: center;
    }
    .table td, .table th {
        border: 0px;
        text-align: center;
    }
</style>

<div class="single-page single-home pb-5">
    
    <div class="container-fluid hh-gallery">
        <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-8 col-lg-9 col-content">
                        @include('frontend.agent-review-tip')
                    </div>
                </div>
        </div>
    </div>
</div>
@include('frontend.components.footer')
