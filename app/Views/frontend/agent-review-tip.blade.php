<div class="home-comment-list mt-3">
    <h3 class="comment-count">
       {{$service_type}} : {{ get_translate($post->post_title) }}
    </h3>
</div>
@if(agent_user_can_review($post->author, get_current_user_id(), $service_type))
    <div class="post-comment parent-form" id="hh-comment-section">
        <div class="comment-form-wrapper">
            <form action="{{ url('add-agent-tip-comment') }}" class="comment-form"
                  method="post" >
                <h3 class="comment-title">{{__('Public Feedback')}}</h3>
                <h2>Share your experience with the community, to help them make better decisiions</h2>
                @include('common.loading')
                <input type="hidden" name="agent_id" value="{{ $post->author }}"/>
                <input type="hidden" name="comment_id" value="0"/>
                <input type="hidden" name="comment_type" value="{{ $service_type }}"/>
                <input type="hidden" name="service_id" value="{{ $post->post_id }}" />
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="row">
                    <div class="form-group col-lg-6">
                        <h3>Communication with Seller</h3>
                        <p>How responsive was the seller during the process?</p>
                    </div>
                    <div class="form-group col-lg-6 mt-3">
                        <div class="review-select-rate">
                            <div class="fas-star">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <input type="hidden" name="communication_star" value="5" class="review_star">
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <h3>Service as Described</h3>
                        <p>Did the result match the Gig's description?</p>
                    </div>
                    <div class="form-group col-lg-6 mt-3">
                        <div class="review-select-rate">
                            <div class="fas-star">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <input type="hidden" name="service_star" value="5" class="review_star">
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <h3>Buy again and Recommend</h3>
                        <p>Would you recommend buying the Gig?</p>
                    </div>
                    <div class="form-group col-lg-6 mt-3">
                        <div class="review-select-rate">
                            <div class="fas-star">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <input type="hidden" name="recommend_star" value="5" class="review_star">
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <input id="comment-title" type="text" name="comment_title" class="form-control has-validation"
                               placeholder="{{__('Comment title*')}}" data-validation="required"/>
                    </div>
                    <div class="form-group col-lg-12">
                    <textarea id="comment-content" name="comment_content" placeholder="{{__('Comment*')}}"
                              class="form-control has-validation" data-validation="required"></textarea>
                    </div>
                </div>
                <div class="form-message"></div>
                <button type="submit" class="btn btn-primary text-uppercase">{{__('Send Feedback')}}</button>
            </form>
        </div>
    </div>
@endif
