@extends('layouts.suplay')
@section('content')
<div class="py-12">
    <!-- Chart's container -->
    <div id="chart" style="height: 300px;"></div>
    <script src="{{asset('./js/dsvplay.js')}}"></script>
    <!-- Your application script -->
    @if($stats->created_at ?? false)
        <script>
            const chart = new Chartisan({
                el: '#chart',
                url: "@chart('my_chart')" + "?id={{$videoid}}",
                hooks: new ChartisanHooks()
                    .colors(['#4299E1','#FE0045','#C07EF1','#67C560','#ECC94B'])
                    .legend()
                    .title('{{$stats->created_at->format('d M Y')}} - {{$stats->updated_at->format('d M Y')}}')
                    .datasets('bar')
                    .axis(true)
            });
        </script>
    @else
        <script>
            const chart = new Chartisan({
                el: '#chart',
                url: "@chart('my_chart')" + "?id={{$videoid}}",
                hooks: new ChartisanHooks()
                    .colors(['#4299E1','#FE0045','#C07EF1','#67C560','#ECC94B'])
                    .legend()
                    .title('Missing data')
                    .datasets('bar')
                    .axis(true)
            });
        </script>
    @endif


</div>
<a type="button" class="btn btn-sm"
   href="{{ url()->previous() }}">Return Back
</a>
@endsection
