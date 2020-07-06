@extends('layouts.app')
@section('content')

    <div class="row" id="about-project">
        {{--Basic Data--}}
        <div class="col-md-12 card info-card">
            <h4 class="mb-4"><b>{{$company['heading']}}</b></h4>
            <p>{{$company['description']}}</p>
        </div>

        {{--Company Info--}}
        <div class="col-md-12 card info-card">
            <h5 class="table-heading"># Company Information</h5>
            <table class="table table-bordered information-table">
                <tbody>
                 @foreach($company['information'] as $info)
                  <tr><td>{{$info['table-heading']}}</td><td>{{$info['table-data']}}</td></tr>
                  @endforeach
                </tbody>
            </table>
        </div>

        {{--Contact Info--}}
        <div class="col-md-12 card info-card">
            <h5 class="table-heading"># Contact Information</h5>
            <table class="table table-bordered information-table">
                <tbody>
                @foreach($company['contact'] as $info)
                    <tr><td>{{$info['table-heading']}}</td><td>{{$info['table-data']}}</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{--Compliance Info--}}
        <div class="col-md-12 card info-card">
            <h5 class="table-heading"># Compliance Information</h5>
            <table class="table table-bordered information-table">
                <tbody>
                @foreach($company['compliance'] as $info)
                    <tr><td>{{$info['table-heading']}}</td><td>{{$info['table-data']}}</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{--Location Info--}}
        <div class="col-md-12 card info-card">
            <h5 class="table-heading"># Location Information</h5>
            <table class="table table-bordered information-table">
                <tbody>
                @foreach($company['location'] as $info)
                    <tr><td>{{$info['table-heading']}}</td><td>{{$info['table-data']}}</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{--Classification Info--}}
        <div class="col-md-12 card info-card">
            <h5 class="table-heading"># Classification Information</h5>
            <table class="table table-bordered information-table">
                <tbody>
                @foreach($company['classification'] as $info)
                    <tr><td>{{$info['table-heading']}}</td><td>{{$info['table-data']}}</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{--Directors Info--}}
        <div class="col-md-12 card info-card">
            <h5 class="table-heading"># Directors Information</h5>
            <table class="table table-bordered information-table">
                <tbody>
                <tr>
                    <th>Director Identification Number</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Date of Appointment</th>
                    <th>Profile</th>
                </tr>
                @foreach($company['directors'] as $info)
                    <tr>
                        @foreach($info as $row)
                            <td>{{$row['table-data']}}</td>
                         @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{--Faqs Info--}}
        <div class="col-md-12 card info-card">
            <h5 class="table-heading"># Frequently Asked Questions</h5>
            <table class="table table-bordered information-table">
                <tbody>
                @foreach($company['faqs'] as $info)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title" id="faqs-title">{{$info['questions']}}</h5>
                            <p class="card-text">{{$info['answers']}}</p>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

@endsection
