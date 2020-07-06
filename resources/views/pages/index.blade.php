@extends('layouts.app')
@section('content')
    <div id="about-project">
        <div class="row card info-card">
            <div class="col-md-12">
                <h4><b>Laravel web scrapper</b></h4>
                <p>I started this project to create a small level web-scrapper</p>
                <p>The web scrapper scraps all the data as you visit each and every link.</p>
                <p><b>For any issue</b> : Please refer to the readme file for this github repo</p>
                <p><b>Target:</b> http://www.mycorporateinfo.com/ </p>
            </div>
        </div>
    </div>
    <hr>

    <div class="row" id="companies-row">
        {{--Select company type Row--}}
        <div class="col-md-12 card info-card">
            <h4 class="mb-4"><b>Select a company</b></h4>
            <ul class="list-group">
                @foreach($companies as $company)
                        <li class="list-group-item company-item" data-link="{{$company['link']}}" data-id="{{$company['cmp_id']}}" data-name="{{urlencode($company['name'])}}">
                            {{$company['name']}}
                        </li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection
