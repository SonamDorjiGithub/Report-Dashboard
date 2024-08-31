@foreach($dailyStatistics as $dailyStatistic)
    @if($dailyStatistic->subs_activated > 0)
    <div class="col-sm-1 stats" style="background-color:lavender;">
        <strong>Subscriber Activated</strong> {{$dailyStatistic->subs_activated}}
    </div>
    @endif
    @if($dailyStatistic->subs_deactivated)
    <div class="col-sm-1 stats" style="background-color:lavenderblush;">
        <strong>Subscriber Deactivated</strong> {{$dailyStatistic->subs_deactivated}}
    </div>
    @endif
    @if($dailyStatistic->total_subs > 0)
    <div class="col-sm-1 stats" style="background-color:lavender;">
        <strong>Total Subscriber</strong> {{$dailyStatistic->total_subs}}
    </div>
    @endif
    @if($dailyStatistic->leasedline_subs > 0)
    <div class="col-sm-1 stats" style="background-color:lavenderblush;">
        <strong>Leasedline Subscriber</strong>{{$dailyStatistic->leasedline_subs}}
    </div>
    @endif
    @if($dailyStatistic->total_vlr_subs > 0)
    <div class="col-sm-1 stats" style="background-color:lavender;">
        <strong>Total VLR Subscriber</strong> {{$dailyStatistic->total_vlr_subs}}
    </div>
    @endif
    @if($dailyStatistic->active_subs_cbs > 0)
    <div class="col-sm-1 stats" style="background-color:lavenderblush;">
        <strong>Active Subscriber</strong> {{$dailyStatistic->active_subs_cbs}}
    </div>
    @endif
    @if($dailyStatistic->powered_on_subs > 0)
    <div class="col-sm-1 stats" style="background-color:lavender;">
        <strong>Powered On Subs</strong> {{$dailyStatistic->powered_on_subs}}
    </div>
    @endif
@endforeach
