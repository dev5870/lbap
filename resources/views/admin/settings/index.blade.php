@extends('layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.tochka.settings.title') }}</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <dt class="">{{ __('title.settings.telegram') }}</dt>
                        <hr/>
                        <div class="col-6">
                            @if (!$tgSubscribe)
                                <p>
                                    Для начала работы перейдите к боту <strong><a href="https://t.me/{{ $bot }}" target="_blank">{{ '@' . $bot }}</a></strong>, нажмите <strong>/start</strong> и обновите данные с помощью кнопки ниже.
                                <br />
                                    Отправьте сообщение: <strong>/login</strong>
                                </p>
                                <div>
                                    Введите код, полученный в ответном сообщении:
                                </div>
                                <dd class="col-4">
                                    <div class="">
                                        <form method="POST" class="input-group" action="{{ Route('admin.settings.general.tg') }}">
                                            @csrf
                                            <input type="text" value="" class="form-control" name="token">
                                            <button class="btn btn-success" type="submit">
                                                {{ __('title.btn.save') }}
                                            </button>
                                        </form>
                                    </div>
                                </dd>
                            @else
                                <form method="POST" action="{{ Route('admin.settings.general.tg-services') }}">
                                    @csrf
                                    @foreach($tgServices as $service)
                                        <div class="form-check form-switch">
                                            <input type="checkbox"
                                                   name="tg_services[]" value="{{ $service->id }}"
                                                   @if (!empty($tgSubscribes[$service->id])) checked="checked" @endif
                                                   id="tg-service-{{ $service->id }}"
                                                   class="form-check-input"/>

                                            <label for="tg-service-{{ $service->id }}"  class="form-check-label">
                                                {{ $service->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    <button class="btn btn-success" type="submit">
                                        {{ __('title.btn.save') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="col-6">
                            <a href="{{ Route('admin.settings.general.tg-set-webhook') }}">
                                <button type="button" class="btn btn-sm btn-outline-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-refresh-cw align-middle me-2">
                                        <polyline points="23 4 23 10 17 10"></polyline>
                                        <polyline points="1 20 1 14 7 14"></polyline>
                                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                    </svg>
                                    {{ __('message.settings.set_tg_webhook') }}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
