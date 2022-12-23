<div class="topbar">
    <div class="topbar-item">
        <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
            <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
            <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ auth()->user()->name }}</span>
            <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                @php
                    $names = array_slice(explode(' ', auth()->user()->name), 0, 2);
                    $initials = array_map(function($name) {
                        return substr($name, 0, 1);
                    }, $names);
                    $initial = strtoupper(implode('', $initials))
                @endphp
                <span class="symbol-label font-size-h5 font-weight-bold">{{ $initial }}</span>
            </span>
        </div>
    </div>
</div>
