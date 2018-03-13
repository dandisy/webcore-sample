@section('styles')
    <style>
        section .container:first-child {
            margin-top: 50px;
        }
        .panel-group .panel {
            border-radius: 0;
        }
        .panel-default {
            border-color: #ddd;
        }
        .panel {
            background: none;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        .panel-heading {
            border: none;
            border-radius: 0;
        }
        .panel-heading{
            background-color: rgb(18, 176, 41);
            box-shadow:inset 0 0 0 99999px rgba(255,255,255,0.2);
        }
        .panel-heading:hover{
            box-shadow:none;
        }
        .accordion .panel-heading h3 {
            margin-top: 10px;
            text-align: center;
        }
        .accordion a:hover,
        .accordion a:focus {
            text-decoration: none;
        }
        .accordion .panel-heading a {
            color: white;
            font-weight: bold;
            display: block;
        }
        .accreditation .panel-heading,
        .gbk-access-gate .panel-heading,
        .jiexpo-access-gate .panel-heading,
        .jkt-access-gate .panel-heading   {
            background-color: #afd271;
        }
        .arrival-departure .panel-heading {
            background-color: #00b9be;
        }
        .staff-volunteer .panel-heading {
            background-color: #f7941d;
        }
        .transportation .panel-heading {
            background-color: #2b93d0;
        }
        .athletes-service .panel-heading {
            background-color: #f04565;
        }
        .sport-entry .panel-heading {
            background-color: #793393;
        }
        .help-desk .panel-heading {
            background-color: #2b93d0;
        }
    </style>
@endsection

<div class="container">
    <div class="col-sm-12">
        <div class="panel-group accordion {{$items['data'][$item['component_id']][0]['tag']}}" id="accordion-{{$items['data'][$item['component_id']][0]['tag']}}">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>
                        <a data-toggle="collapse" data-parent="#accordion-{{$items['data'][$item['component_id']][0]['tag']}}" href="#content-accordion-{{$items['data'][$item['component_id']][0]['tag']}}">{{strtoupper($items['data'][$item['component_id']][0]['tag'])}}</a>
                    </h3>
                </div>
                <div id="content-accordion-{{$items['data'][$item['component_id']][0]['tag']}}" class="panel-collapse collapse">
                    <div class="panel-body">
                        @foreach($items['data'][$item['component_id']] as $value)
                            <div class="panel panel-default">
                                <a href="{{url('page/'.$value['slug'])}}" class="panel-body" style="display: block">
                                    <h4>{{$value['title']}}</h4>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>