<li class="nav-item {{ request()->is($item['active_criteria'] ?? '') ? 'active' : '' }}">
    <a class="d-flex align-items-center" href="{{ isset($item['route']) ? route($item['route']) : '#/' }}">
        <i data-feather="{{ $item['icon'] }}"></i>
        <span class="menu-title text-truncate" data-i18n="{{ $item['label'] }}">
            {{ getSideBarTransalted($item['label']) }}
        </span>
        @if (isset($item['badge']['content']))
        <span class="badge badge-{{ $item['badge']['type'] ?? 'light-warning' }} rounded-pill ms-auto me-1">{{ $item['badge']['content'] }}</span>
        @endif
    </a>

    @if (count($item['children'] ?? []) > 0)
    <ul class="menu-content">
        @foreach ($item['children'] as $childItem)
        <li class="{{ $childItem['is_current'] == true ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{ route($childItem['route']) }}">
                <i data-feather="{{ $childItem['icon'] ?? 'circle' }}"></i>
                <span class="menu-item text-truncate" data-i18n="{{ $childItem['label'] }}">
                    {{ getSideBarTransalted($item['label']) }}
                </span>
            </a>
        </li>
        @endforeach
    </ul>
    @endif
</li>
