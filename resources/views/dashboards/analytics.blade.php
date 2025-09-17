<x-app-layout >
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Total Orders</h4>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div id="order-chart-02" class="order-chart-02">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Sales Overview</h4>
                        </div>
                    </div>
                    <div class="card-body h-100 ">
                        <div id="sales-chart-01" class="sales-chart-01">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-xl-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6 ">
                        <div class="card card-block card-stretch back-img ">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class=" align-items-center card-total-sale ">
                                        <div class="border bg-warning rounded iq-icon-box">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                height="25" width="25" class="mb-1">
                                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                                            </svg>
                                        </div>
                                        <div
                                            class="d-flex align-items-center  card-total-sale justify-content-between mt-3">
                                            <div class="card-text">
                                                <h5>Profit</h5>
                                                <h3>23457</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vector-img"><img src="{{ asset('images/product/profit.png') }}"
                                            class="avatar-80 rounded" alt="user"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card card-block card-stretch back-img ">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class=" align-items-center card-total-sale ">
                                        <div class="border bg-secondary rounded iq-icon-box">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                height="25" width="25" class="mb-1">
                                                <path
                                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                            </svg>
                                        </div>
                                        <div
                                            class="d-flex align-items-center  card-total-sale justify-content-between mt-3">
                                            <div class="card-text">
                                                <h5>Performance</h5>
                                                <h3>78%</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vector-img"><img src="{{ asset('images/product/perfomance.png') }}"
                                            class="avatar-80 rounded" alt="user"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="card card-block card-stretch back-img">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class=" align-items-center card-total-sale ">
                                        <div class="border bg-primary rounded iq-icon-box">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                height="25" width="25" class="mb-1">
                                                <path
                                                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                            </svg>
                                        </div>
                                        <div
                                            class="d-flex align-items-center  card-total-sale justify-content-between mt-3">
                                            <div class="card-text">
                                                <h5>Total Orders</h5>
                                                <h3>3234</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vector-img"><img src="{{ asset('images/product/totaloder.png') }}"
                                            class="avatar-80 rounded" alt="user"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 ">
                        <div class="card card-block card-stretch back-img">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class=" align-items-center card-total-sale ">
    
                                        <div class="border bg-success rounded iq-icon-box">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                height="25" width="25" class="mb-1">
                                                <path
                                                    d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div
                                            class="d-flex align-items-center  card-total-sale justify-content-between mt-3">
                                            <div class="card-text">
                                                <h5>Total Loss</h5>
                                                <h3>245</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="vector-img"><img src="{{ asset('images/product/loss.png') }}"
                                            class="avatar-80 rounded" alt="user"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Yearly Sales Report</h4>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div id="yearly-chart-03" class="yearly-chart-03">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xl-4">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Like By Country</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="like-chart-05">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xl-4">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Visited By Channels</h4>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div id="visited-chart-05" class="visited-chart-05">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xl-4">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Total Revenue</h4>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div id="revenue-chart-06" class="revenue-chart-06">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page end  -->
    </div>
</x-app-layout>
