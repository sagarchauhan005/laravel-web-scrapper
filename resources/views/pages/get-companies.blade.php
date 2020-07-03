@extends('layouts.app')
@section('content')

    <div class="row" id="about-project">
        {{--Selected company types--}}
        <div class="col-md-7"><h4 class="mb-4"><b>{{urldecode(request()->get('type'))}}</b></h4></div>
        <div class="col-md-1 text-right">
            <div class="spinner-border" role="status" style="display: none;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="col-md-2 text-right"><h6 class="mb-4"><b>Total Pages</b> : <span id="total-pages">0</span></h6></div>
        <div class="col-md-2 text-right"><h6 class="mb-4"><b>Current Page</b> : <span id="current-page">0</span></h6></div>

        <div class="col-md-12" id="select-company-type-container" style="height: 550px; overflow-y: scroll;">
            <div id="companies-table" class="load-companies-table" data-link="{{request()->get('link')}}">
                <p>Fetching data....</p>
            </div>
        </div>
        <div class="col-md-12"><br></div>
        <div class="col-md-6"><button type="button" class="btn btn-primary w-100 loadMore" data-page="1" data-link="{{request()->get('link')}}" id="prev">Previous</button></div>
        <div class="col-md-6"><button type="button" class="btn btn-primary w-100 loadMore" data-page="2" data-link="{{request()->get('link')}}" id="next">Next</button></div>
    </div>

@endsection
