@extends('cabinet.layouts.default', ['title' => __('cabinet.menu.edit')])
@section('content')
    <div class="p-0 container-fluid">
        <h1 class="h3 mb-3">
            {{ __('cabinet.menu.edit') }}
        </h1>
        <form class="" method="POST" action="{{ Route('cabinet.profile.update', $profile) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xl-3 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="mb-0 card-title h5">
                                {{ __('cabinet.profile.details') }}
                            </div>
                        </div>
                        <div class="text-center card-body">
                            <img src="{{ $file ?? asset('assets/img/logo.png') }}" alt="user"
                                 class="img-fluid rounded-circle mb-2" width="128" height="128">
                            <div class="mb-0 card-title h5">
                                <input name="username" value="{{ $profile->username }}" placeholder="Stacie Hall"
                                       style="width: 120px">
                            </div>
                            <div class="text-muted mb-2">
                                <input name="about" value="{{ $profile->about }}" placeholder="Lead Developer"
                                       style="width: 120px">
                            </div>
                        </div>
                        <hr class="my-0">
                        <div class="card-body">
                            <div class="card-title h5">
                                {{ __('cabinet.profile.skills') }}
                            </div>
                            <textarea name="skill" placeholder="Separated by commas"
                                      style="width: 170px">{{ $profile->skill }}</textarea>
                        </div>
                        <hr class="my-0">
                        <div class="card-body">
                            <div class="card-title h5">
                                {{ __('cabinet.profile.city') }}
                            </div>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="me-1">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    <input name="city" value="{{ $profile->city }}" placeholder="Lives in ..."
                                           style="width: 120px">
                            </ul>
                        </div>
                        <hr class="my-0">
                        <div class="card-body">
                            <div class="card-title h5">
                                {{ __('cabinet.profile.tg') }}
                            </div>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                         viewBox="0 0 24 24">
                                        <path
                                            d="M 20.302734 2.984375 C 20.013769 2.996945 19.748583 3.080055 19.515625 3.171875 C 19.300407 3.256634 18.52754 3.5814726 17.296875 4.0976562 C 16.06621 4.61384 14.435476 5.2982348 12.697266 6.0292969 C 9.2208449 7.4914211 5.314238 9.1361259 3.3125 9.9785156 C 3.243759 10.007156 2.9645852 10.092621 2.65625 10.328125 C 2.3471996 10.564176 2.0039062 11.076462 2.0039062 11.636719 C 2.0039062 12.088671 2.2295201 12.548966 2.5019531 12.8125 C 2.7743861 13.076034 3.0504903 13.199244 3.28125 13.291016 L 3.28125 13.289062 C 4.0612776 13.599827 6.3906939 14.531938 6.9453125 14.753906 C 7.1420423 15.343433 7.9865895 17.867278 8.1875 18.501953 L 8.1855469 18.501953 C 8.3275588 18.951162 8.4659791 19.243913 8.6582031 19.488281 C 8.7543151 19.610465 8.8690398 19.721184 9.0097656 19.808594 C 9.0637596 19.842134 9.1235454 19.868148 9.1835938 19.892578 C 9.191962 19.896131 9.2005867 19.897012 9.2089844 19.900391 L 9.1855469 19.894531 C 9.2029579 19.901531 9.2185841 19.911859 9.2363281 19.917969 C 9.2652427 19.927926 9.2852873 19.927599 9.3242188 19.935547 C 9.4612233 19.977694 9.5979794 20.005859 9.7246094 20.005859 C 10.26822 20.005859 10.601562 19.710937 10.601562 19.710938 L 10.623047 19.695312 L 12.970703 17.708984 L 15.845703 20.369141 C 15.898217 20.443289 16.309604 21 17.261719 21 C 17.829844 21 18.279025 20.718791 18.566406 20.423828 C 18.853787 20.128866 19.032804 19.82706 19.113281 19.417969 L 19.115234 19.416016 C 19.179414 19.085834 21.931641 5.265625 21.931641 5.265625 L 21.925781 5.2890625 C 22.011441 4.9067171 22.036735 4.5369631 21.935547 4.1601562 C 21.834358 3.7833495 21.561271 3.4156252 21.232422 3.2226562 C 20.903572 3.0296874 20.591699 2.9718046 20.302734 2.984375 z M 19.908203 5.1738281 C 19.799442 5.7198576 17.33401 18.105877 17.181641 18.882812 L 13.029297 15.041016 L 10.222656 17.414062 L 11 14.375 C 11 14.375 16.362547 8.9468594 16.685547 8.6308594 C 16.945547 8.3778594 17 8.2891719 17 8.2011719 C 17 8.0841719 16.939781 8 16.800781 8 C 16.675781 8 16.506016 8.1197812 16.416016 8.1757812 C 15.272368 8.8887854 10.401283 11.664685 8.0058594 13.027344 C 7.8617016 12.96954 5.6973962 12.100458 4.53125 11.634766 C 6.6055146 10.76177 10.161156 9.2658083 13.472656 7.8730469 C 15.210571 7.142109 16.840822 6.4570977 18.070312 5.9414062 C 19.108158 5.5060977 19.649538 5.2807035 19.908203 5.1738281 z M 17.152344 19.025391 C 17.152344 19.025391 17.154297 19.025391 17.154297 19.025391 C 17.154252 19.025621 17.152444 19.03095 17.152344 19.03125 C 17.153615 19.024789 17.15139 19.03045 17.152344 19.025391 z"></path>
                                    </svg>
                                    <input name="telegram" value="{{ $profile->telegram }}" placeholder="@your_tg"
                                           style="width: 120px">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="mb-0 card-title h5">
                                {{ __('cabinet.profile.description') }}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <img src="{{ $file ?? asset('assets/img/logo.png') }}" alt="user"
                                     class="rounded-circle me-2" width="36" height="36">
                                <div class="flex-grow-1">
                                    <strong>{{ $profile->username }}</strong>
                                    {{ __('cabinet.profile.info_1') }}
                                    <br>
                                    <div class="border text-sm text-muted p-2 mt-1">
                                        <textarea name="description" placeholder="tell us about yourself"
                                                  style="width: 98%">{{ $profile->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('title.btn.update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
