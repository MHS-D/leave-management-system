<div class="row">
    @foreach ($statistics as $statistic)
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="fw-bolder mb-75">{{ $statistic['value'] }}</h3>
                        <span>{{ $statistic['label'] }}</span>
                    </div>
                    <div class="avatar bg-{{ $statistic['color'] }} p-50">
                        <span class="avatar-content">
                            <i class="font-medium-4 {{ $statistic['icon'] }}"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
