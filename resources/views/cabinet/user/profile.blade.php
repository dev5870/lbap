@extends('cabinet.layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('cabinet.profile.title') }}</h3>
        </div>
    </div>
        <div class="row">
            <div class="col-xl-3 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="mb-0 card-title h5">{{ __('cabinet.profile.details') }}</div>
                    </div>
                    <div class="text-center card-body"><img src="/static/media/avatar-4.93166a0c.jpg" alt="Stacie Hall"
                                                            class="img-fluid rounded-circle mb-2" width="128"
                                                            height="128">
                        <div class="mb-0 card-title h5">Stacie Hall</div>
                        <div class="text-muted mb-2">Lead Developer</div>
                        <div>
                            <button type="button" class="me-1 btn btn-primary btn-sm">Follow</button>
                            <button type="button" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                Message
                            </button>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="card-title h5">Skills</div>
                        <span class="me-2 my-1 badge bg-primary">HTML</span><span class="me-2 my-1 badge bg-primary">JavaScript</span><span
                            class="me-2 my-1 badge bg-primary">Sass</span><span class="me-2 my-1 badge bg-primary">Angular</span><span
                            class="me-2 my-1 badge bg-primary">Vue</span><span
                            class="me-2 my-1 badge bg-primary">React</span><span class="me-2 my-1 badge bg-primary">Redux</span><span
                            class="me-2 my-1 badge bg-primary">UI</span><span
                            class="me-2 my-1 badge bg-primary">UX</span></div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="card-title h5">About</div>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="me-1">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                Lives in <a href="/dashboard/default">San Francisco, SA</a></li>
                            <li class="mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="me-1">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                                Works at <a href="/dashboard/default">GitHub</a></li>
                            <li class="mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="me-1">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                From <a href="/dashboard/default">Boston</a></li>
                        </ul>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="card-title h5">Elsewhere</div>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-1">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="globe"
                                     class="svg-inline--fa fa-globe fa-w-16 fa-fw me-1" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
                                    <path fill="currentColor"
                                          d="M336.5 160C322 70.7 287.8 8 248 8s-74 62.7-88.5 152h177zM152 256c0 22.2 1.2 43.5 3.3 64h185.3c2.1-20.5 3.3-41.8 3.3-64s-1.2-43.5-3.3-64H155.3c-2.1 20.5-3.3 41.8-3.3 64zm324.7-96c-28.6-67.9-86.5-120.4-158-141.6 24.4 33.8 41.2 84.7 50 141.6h108zM177.2 18.4C105.8 39.6 47.8 92.1 19.3 160h108c8.7-56.9 25.5-107.8 49.9-141.6zM487.4 192H372.7c2.1 21 3.3 42.5 3.3 64s-1.2 43-3.3 64h114.6c5.5-20.5 8.6-41.8 8.6-64s-3.1-43.5-8.5-64zM120 256c0-21.5 1.2-43 3.3-64H8.6C3.2 212.5 0 233.8 0 256s3.2 43.5 8.6 64h114.6c-2-21-3.2-42.5-3.2-64zm39.5 96c14.5 89.3 48.7 152 88.5 152s74-62.7 88.5-152h-177zm159.3 141.6c71.4-21.2 129.4-73.7 158-141.6h-108c-8.8 56.9-25.6 107.8-50 141.6zM19.3 352c28.6 67.9 86.5 120.4 158 141.6-24.4-33.8-41.2-84.7-50-141.6h-108z"></path>
                                </svg>
                                <a href="/dashboard/default">staciehall.co</a></li>
                            <li class="mb-1">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter"
                                     class="svg-inline--fa fa-twitter fa-w-16 fa-fw me-1" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                          d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
                                </svg>
                                <a href="/dashboard/default">Twitter</a></li>
                            <li class="mb-1">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook"
                                     class="svg-inline--fa fa-facebook fa-w-16 fa-fw me-1" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                          d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"></path>
                                </svg>
                                <a href="/dashboard/default">Facebook</a></li>
                            <li class="mb-1">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram"
                                     class="svg-inline--fa fa-instagram fa-w-14 fa-fw me-1" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path fill="currentColor"
                                          d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
                                </svg>
                                <a href="/dashboard/default">Instagram</a></li>
                            <li class="mb-1">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin"
                                     class="svg-inline--fa fa-linkedin fa-w-14 fa-fw me-1" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path fill="currentColor"
                                          d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path>
                                </svg>
                                <a href="/dashboard/default">LinkedIn</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="mb-0 card-title h5">Activities</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex"><img src="/static/media/avatar-5.b309bbe2.jpg" width="36" height="36"
                                                 class="rounded-circle me-2" alt="Ashley Briggs">
                            <div class="flex-grow-1"><small class="float-end text-navy">5m ago</small><strong>Ashley
                                    Briggs</strong> started following <strong>Stacie Hall</strong><br><small
                                    class="text-muted">Today 7:51 pm</small><br></div>
                        </div>
                        <hr>
                        <div class="d-flex"><img src="/static/media/avatar.42a86687.jpg" width="36" height="36"
                                                 class="rounded-circle me-2" alt="Chris Wood">
                            <div class="flex-grow-1"><small class="float-end text-navy">30m ago</small><strong>Chris
                                    Wood</strong> posted something on <strong>Stacie Hall</strong>'s timeline<br><small
                                    class="text-muted">Today 7:21 pm</small>
                                <div class="border text-sm text-muted p-2 mt-1">Etiam rhoncus. Maecenas tempus, tellus
                                    eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed
                                    ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas
                                    nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus.
                                    Nullam quis ante.
                                </div>
                                <button type="button" class="mt-1 btn btn-danger btn-sm">
                                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="heart"
                                         class="svg-inline--fa fa-heart fa-w-16 fa-fw " role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor"
                                              d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z"></path>
                                    </svg>
                                    Like
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex"><img src="/static/media/avatar-4.93166a0c.jpg" width="36" height="36"
                                                 class="rounded-circle me-2" alt="Stacie Hall">
                            <div class="flex-grow-1"><small class="float-end text-navy">1h ago</small><strong>Stacie
                                    Hall</strong> posted a new blog<br><small class="text-muted">Today 6:35 pm</small>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex"><img src="/static/media/avatar-2.6cc481d4.jpg" width="36" height="36"
                                                 class="rounded-circle me-2" alt="Carl Jenkins">
                            <div class="flex-grow-1"><small class="float-end text-navy">3h ago</small><strong>Carl
                                    Jenkins</strong> posted two photos on <strong>Stacie Hall</strong>'s
                                timeline<br><small class="text-muted">Today 5:12 pm</small>
                                <div class="row no-gutters mt-1">
                                    <div class="col-6 col-md-4 col-lg-4 col-xl-3"><img
                                            src="/static/media/unsplash-1.f6b3aeb0.jpg" class="img-fluid pe-2"
                                            alt="Unsplash"></div>
                                    <div class="col-6 col-md-4 col-lg-4 col-xl-3"><img
                                            src="/static/media/unsplash-2.695077e0.jpg" class="img-fluid pe-2"
                                            alt="Unsplash"></div>
                                </div>
                                <button type="button" class="mt-1 btn btn-danger btn-sm">
                                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="heart"
                                         class="svg-inline--fa fa-heart fa-w-16 fa-fw " role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor"
                                              d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z"></path>
                                    </svg>
                                    Like
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex"><img src="/static/media/avatar-2.6cc481d4.jpg" width="36" height="36"
                                                 class="rounded-circle me-2" alt="Carl Jenkins">
                            <div class="flex-grow-1"><small class="float-end text-navy">1d ago</small><strong>Carl
                                    Jenkins</strong> started following <strong>Stacie Hall</strong><br><small
                                    class="text-muted">Yesterday 3:12 pm</small>
                                <div class="d-flex mt-1"><img src="/static/media/avatar-4.93166a0c.jpg" width="36"
                                                              height="36" class="rounded-circle me-2" alt="Stacie Hall">
                                    <div class="flex-grow-1 ps-3">
                                        <div class="border text-sm text-muted p-2 mt-1">Nam quam nunc, blandit vel,
                                            luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt
                                            tempus.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex"><img src="/static/media/avatar-4.93166a0c.jpg" width="36" height="36"
                                                 class="rounded-circle me-2" alt="Stacie Hall">
                            <div class="flex-grow-1"><small class="float-end text-navy">1d ago</small><strong>Stacie
                                    Hall</strong> posted a new blog<br><small class="text-muted">Yesterday 2:43
                                    pm</small></div>
                        </div>
                        <hr>
                        <div class="d-flex"><img src="/static/media/avatar.42a86687.jpg" width="36" height="36"
                                                 class="rounded-circle me-2" alt="Chris Wood">
                            <div class="flex-grow-1"><small class="float-end text-navy">1d ago</small><strong>Chris
                                    Wood</strong> started following <strong>Stacie Hall</strong><br><small
                                    class="text-muted">Yesterdag 1:51 pm</small></div>
                        </div>
                        <hr>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary">Load more</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
