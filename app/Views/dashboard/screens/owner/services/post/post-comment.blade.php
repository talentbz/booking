@include('dashboard.components.header')
<?php
enqueue_style('confirm-css');
enqueue_script('confirm-js');
?>
<div id="wrapper">
    @include('dashboard.components.top-bar')
    @include('dashboard.components.nav')
    <div class="content-page">
        <div class="content">
            @include('dashboard.components.breadcrumb', ['heading' => __('Comments')])
            {{--Start Content--}}
            <div class="card-box">
                <div class="header-area d-flex align-items-center">
                    <h4 class="header-title mb-0">{{__('Comments')}}</h4>
                    <form class="form-inline right d-none d-sm-block" method="get">
                        <div class="form-group">
                            <?php

                            $search = request()->get('_s');
                            ?>
                            <input type="text" class="form-control" name="_s"
                                   value="{{ $search }}"
                                   placeholder="{{__('Search by id, title')}}">
                        </div>
                        <button type="submit" class="btn btn-default"><i class="ti-search"></i></button>
                    </form>
                </div>
                <?php
                enqueue_style('datatables-css');
                enqueue_script('datatables-js');
                enqueue_script('pdfmake-js');
                enqueue_script('vfs-fonts-js');
                ?>
                <?php
                $tableColumns = [
                    __('Post Title'),
                    __('Comment'),
                    __('User'),
                    __('Created At'),
                    __('Status')
                ];
                ?>
                <table class="table table-large mb-0 dt-responsive nowrap w-100"
                       data-paging="false"
                       data-pdf-name="{{__('Export to PDF')}}"
                       data-cols="{{ base64_encode(json_encode($tableColumns)) }}"
                       data-ordering="false">
                    <thead>
                    <tr>
                        <th data-priority="1">
                            {{__('Post Title')}}
                        </th>
                        <th data-priority="2" width="40%">
                            {{__('Comment Content')}}
                        </th>
                        <th data-priority="2">
                            {{__('Username')}}
                        </th>
                        <th data-priority="2">
                            {{__('Created At')}}
                        </th>
                        <th data-priority="3" class="">
                            <div class="dropdown">
                                <a class="dropdown-toggle not-show-caret" id="dropdownFilterStatus"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{__('Status')}}
                                    <i class="icon-arrow-down"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownFilterStatus">
                                    <a class="dropdown-item"
                                       href="{{ remove_query_arg('status') }}">{{__('All')}}</a>
                                    <?php
                                    $status = comment_status_info();
                                    foreach ($status as $key => $_status) {
                                    $url = add_query_arg('status', $key);
                                    ?>
                                    <a class="dropdown-item"
                                       href="{{ $url }}">{{ $_status['name'] }}</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </th>
                        <th data-priority="-1" class="text-center">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($comments['total'])
                        @foreach ($comments['results'] as $item)
                            <tr>
                                <td class="align-middle">
                                    <a href="{{ get_the_permalink($item->post_id, $item->post_slug, 'post') }}">{{ get_translate($item->post_title)  }}</a>
                                </td>
                                <td class="align-middle">
                                    {{ $item->comment_content }}
                                </td>
                                <td class="align-middle">
                                    {{ $item->comment_name }}
                                </td>
                                <td class="align-middle">
                                    {{ date(hh_date_format(), $item->created_at) }}
                                </td>
                                <td class="align-middle">
                                    <div class="service-status {{ $item->status }} status-icon"
                                         data-toggle="tooltip" data-placement="right" title=""
                                         data-original-title="{{ comment_status_info($item->status)['name'] }}"><span
                                            class="d-none">{{ comment_status_info($item->status)['name'] }}</span>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="dropdown dropleft">
                                        <a href="javascript: void(0)" class="dropdown-toggle table-action-link"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="ti-settings"></i></a>
                                        <div class="dropdown-menu">
                                            <?php
                                            $data = [
                                                'serviceID' => $item->comment_id,
                                                'serviceEncrypt' => hh_encrypt($item->comment_id)
                                            ];
                                            ?>

                                            <a class="dropdown-item hh-link-action hh-link-delete-review text-danger"
                                               data-action="{{ dashboard_url('delete-review-item') }}"
                                               data-parent="tr"
                                               data-is-delete="true"
                                               data-params="{{ base64_encode(json_encode($data)) }}"
                                               data-confirm="yes"
                                               data-confirm-title="{{__('Confirm Delete')}}"
                                               data-confirm-question="{{__('Are you sure want to delete this review?')}}"
                                               data-confirm-button="{{__('Delete it!')}}"
                                               href="javascript: void(0)">{{__('Delete')}}</a>

                                            <?php
                                            $service_status_info = comment_status_info();
                                            ?>
                                            @foreach($service_status_info as $key => $status)
                                                @if($key != $item->status)
                                                    <?php
                                                    $data = [
                                                        'serviceID' => $item->comment_id,
                                                        'serviceEncrypt' => hh_encrypt($item->comment_id),
                                                        'status' => $key
                                                    ];
                                                    ?>
                                                    <a class="dropdown-item hh-link-action hh-link-change-status-review"
                                                       data-action="{{ dashboard_url('change-review-status') }}"
                                                       data-parent="tr"
                                                       data-is-delete="false"
                                                       data-params="{{ base64_encode(json_encode($data)) }}"
                                                       href="javascript: void(0)">{{ __('Change to :status', ['status' => $status['name']]) }}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="d-none"></td>
                            <td class="d-none"></td>
                            <td class="d-none"></td>
                            <td class="d-none"></td>
                            <td class="d-none"></td>
                            <td colspan="6">
                                <h4 class="mt-3 text-center">{{__('No comments yet.')}}</h4>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="clearfix mt-2">
                    {{ dashboard_pagination(['total' => $comments['total']]) }}
                </div>
            </div>
            {{--End content--}}
            @include('dashboard.components.footer-content')
        </div>
    </div>
</div>
@include('dashboard.components.footer')
