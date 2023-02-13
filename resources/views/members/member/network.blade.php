@extends('core.app')
@section('title', __('Jaringan Member'))

@push('css')
    <link href="{{ asset('css/trees.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Jaringan Member</h5>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Jaringan {{ $member->name }}</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div class="trees">
                        <div class="trees__container">
                            <div class="tree">
                                <div class="node">
                                    <a href="#" class="node__link" alt="{{ $networks['name'] }}"></a>
                                    <div class="node__container">
                                        <div class="node__image">
                                            <img src="{{ $networks['image'] }}"
                                                alt="{{ $networks['name'] }}"
                                            />
                                        </div>
                                        <div class="node__content">
                                            <span class="node__title">{{ $networks['name'] }}</span>
                                            <span class="node__subtitle">{{ $networks['member_type'] }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if (count($networks['downlines']) > 0)
                                    <div class="tree__children">
                                        @foreach ($networks['downlines'] as $first_gen_member)
                                            <div class="tree">
                                                <div class="node">
                                                    <a href="{{ route('members.network', $first_gen_member['id']) }}" class="node__link" alt="{{ $first_gen_member['name'] }}"></a>
                                                    <div class="node__container">
                                                        <div class="node__image">
                                                            <img src="{{ $first_gen_member['image'] }}"
                                                                alt="{{ $first_gen_member['name'] }}"
                                                            />
                                                        </div>
                                                        <div class="node__content">
                                                            <span class="node__title">{{ $first_gen_member['name'] }}</span>
                                                            <span class="node__subtitle">{{ $first_gen_member['member_type'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if (count($first_gen_member['downlines']) > 0)
                                                    <div class="tree__children">
                                                        @foreach ($first_gen_member['downlines'] as $second_gen_member)
                                                            <div class="tree">
                                                                <div class="node">
                                                                    <a href="{{ route('members.network', $second_gen_member['id']) }}" class="node__link" alt="{{ $second_gen_member['name'] }}"></a>
                                                                    <div class="node__container">
                                                                        <div class="node__image">
                                                                            <img src="{{ $second_gen_member['image'] }}"
                                                                                alt="{{ $second_gen_member['name'] }}"
                                                                            />
                                                                        </div>
                                                                        <div class="node__content">
                                                                            <span class="node__title">{{ $second_gen_member['name'] }}</span>
                                                                            <span class="node__subtitle">{{ $second_gen_member['member_type'] }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @if (count($second_gen_member['downlines']) > 0)
                                                                    <div class="tree__children">
                                                                        @foreach ($second_gen_member['downlines'] as $third_gen_member)
                                                                            <div class="tree">
                                                                                <div class="node">
                                                                                    <a href="{{ route('members.network', $third_gen_member['id']) }}" class="node__link" alt="{{ $third_gen_member['name'] }}"></a>
                                                                                    <div class="node__container">
                                                                                        <div class="node__image">
                                                                                            <img src="{{ $third_gen_member['image'] }}"
                                                                                                alt="{{ $third_gen_member['name'] }}"
                                                                                            />
                                                                                        </div>
                                                                                        <div class="node__content">
                                                                                            <span class="node__title">{{ $third_gen_member['name'] }}</span>
                                                                                            <span class="node__subtitle">{{ $third_gen_member['member_type'] }}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else 
                                                    <div class="tree__children">
                                                        <div class="tree">
                                                            <div class="node">
                                                                <div class="node__container">
                                                                    <div class="node__image node__image--secondary">
                                                                        <img src="{{ url('/static/avatars/avatar.png') }}"
                                                                            alt="No Member"
                                                                        />
                                                                    </div>
                                                                    <div class="node__content">
                                                                        <span class="node__title node__title--secondary">Jaringan Kosong</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else 
                                    <div class="tree__children">
                                        <div class="tree">
                                            <div class="node">
                                                <div class="node__container">
                                                    <div class="node__image node__image--secondary">
                                                        <img src="{{ url('/static/avatars/avatar.png') }}"
                                                            alt="No Member"
                                                        />
                                                    </div>
                                                    <div class="node__content">
                                                        <span class="node__title node__title--secondary">Jaringan Kosong</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush