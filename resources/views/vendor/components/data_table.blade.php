@section('styles')
    @include('layouts.datatables2_css')
    {{--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">--}}
    <!-- test ButtonCss -->
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">--}}
    <!-- endTest -->
    <style type="text/css">
        table.dataTable tfoot th, table.dataTable tfoot td {
            border-top: 1px solid #d63141;
        }
        table.dataTable thead th, table.dataTable thead td {
            border-bottom: 1px solid #d63141;
        }
        .dt-buttons.btn-group{
            display: block;
            float:right;
            padding: 5px;
        }
        .btn.btn-default.buttons-excel{ background-color: rgb(69, 244, 66);}

        .pagination>.active>a,
        .pagination>.active>a:focus,
        .pagination>.active>a:hover,
        .pagination>.active>span,
        .pagination>.active>span:focus,
        .pagination>.active>span:hover {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #722d94;
            border-color:#722d94;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
        }

        .table>thead:first-child>tr:first-child>th {
            border-top: 0;
            color:#fff;
            background-color: #722d94;
        }

        .dataTables_info {
            clear: both;
            /* float */
            padding-top: 0.755em;
        }

        .dataTables_paginate .paging_simple_numbers{
            text-align: left;
        }

        table.dataTable tfoot th,
        table.dataTable tfoot td {
            background-color: #d9d9d9;
        }

        div.dataTables_filter{
            text-align: center;

            margin-top: 5px;
            margin-top: 5px;
            /*display:none;*/
        }
        .dataTables_filter >label {
            /*display: none;*/
        }

        .pagination>li>a,
        .pagination>li>span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            /*color: rgb(241, 126, 21);*/
            color:#722d94;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        /*modal*//*;color: rgb(241, 126, 21)*/
        .modal-header.filter{background-color: #000;color: #c9c3c3;}
        .modal-header.filter > button.close {
            -webkit-appearance: none;
            padding: 0;
            cursor: pointer;
            color:#c9c3c3;
            border: 0;
        }
        .modal-header.filter .modal-title {
            top: 10px;
            right: 0;
            bottom: 0;
            left: 0; }
        .modal-body {
            padding: 0;
            /*position: absolute;*/
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
        table.dataTable th.dt-center,
        table.dataTable td.dt-center,
        table.dataTable td.dataTables_empty {
            text-align: left;
        }
        .select2-container .select2-selection--single {
            height: 33px;
        }
        .select2-container--default .select2-selection--single {
            padding: 6px;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 31px;
        }
        .column-math li {
            cursor: pointer;
        }
        .column-math-input {
            min-width: 70px;
        }
        .query {
            border: 1px solid #dedede;
            margin: 15px;
            padding: 15px;
        }
        .tab-pane {
            margin-top: 15px;
        }
        .checkbox+.checkbox, .radio+.radio {
             margin-top: 0 !important;
        }
        .checkbox, .radio {
            margin-top: 0 !important;
        }
        .checkbox label.line-through {
            text-decoration: line-through;
            color: #999;
        }
    </style>
@endsection

@php
    $columnsFilter = array_pluck($items['dataTable']['columns'], 'title', 'name');

    $queryData = $items['page']['presentations'][0]['component']['dataSource']['dataQuery']->toArray();

    $queryData = array_map(function ($value) {
        unset($value['id']);
        unset($value['data_source_id']);
        unset($value['created_by']);
        unset($value['updated_by']);
        unset($value['created_at']);
        unset($value['updated_at']);
        unset($value['deleted_at']);

        return $value;
    }, $queryData);

    $columnsData = $items['dataTable']['columnsUniqueData'];
    $allColumnData = $items['data']->first()->toArray();
@endphp

<h3 align="center" style="margin-top: 70px">{{ $items['page']['title'] }}</h3>

<!-- Large modal -->
<button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target=".bs-example-modal-lg">Custom Filter</button>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Custom Filter</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-12" style="margin-top: 15px">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#filter" aria-controls="filter" role="tab" data-toggle="tab">Filter</a></li>
                        <li role="presentation"><a href="#select" aria-controls="select" role="tab" data-toggle="tab">Exclude</a></li>
                        {{--<li role="presentation"><a href="#search" aria-controls="search" role="tab" data-toggle="tab">Search</a></li>--}}
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="filter">
                            <div class="datatable-filter col-sm-12">
                                <!-- Filter DataTable -->
                                <div class="row">
                                    <div class="filter-wrapper">
                                        <div id="query0" class="query">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group" style="width: 100%">
                                                        {!! Form::label('command', 'Command:') !!}
                                                        {!! Form::select('query0', [
                                                            'where' => 'where',
                                                            'orWhere' => 'orWhere',
                                                            'whereRaw' => 'whereRaw',
                                                            'whereNull' => 'whereNull',
                                                            'whereNotNull' => 'whereNotNull',
                                                            'whereIn' => 'whereIn',
                                                            'whereNotIn' => 'whereNotIn',
                                                            'whereBetween' => 'whereBetween',
                                                            'whereNotBetween' => 'whereNotBetween',
                                                            'whereDate' => 'whereDate',
                                                            'whereMonth' => 'whereMonth',
                                                            'whereDay' => 'whereDay',
                                                            'whereYear' => 'whereYear',
                                                            'whereTime' => 'whereTime',
                                                            'groupBy' => 'groupBy'
                                                        ], null, ['class' => 'form-control select2 command']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="field-group form-group" style="width: 100%">
                                                        {!! Form::label('column', 'Column:') !!}
                                                        {!! Form::select('query0', $columnsFilter, null, ['class' => 'field form-control select2']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="operator form-group" style="width: 100%">
                                                        {!! Form::label('operator', 'Operator:') !!}
                                                        {!! Form::select('query0', [
                                                            '' => '',
                                                            '=' => '=',
                                                            '>' => '>',
                                                            '<' => '<',
                                                            '>=' => '>=',
                                                            '<=' => '<=',
                                                            '!=' => '!=',
                                                            '<>' => '<>',
                                                            'LIKE' => 'LIKE',
                                                            'NOT LIKE' => 'NOT LIKE'
                                                        ], null, ['class' => 'form-control select2']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <div class="value form-group" style="width: 100%">
                                                            {!! Form::label('value', 'Value:') !!}
                                                            {!! Form::text('query0', null, ['class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="form-group" style="width: 100%">
                                                        <div class="btn-group-query">
                                                            <div class="form-group">
                                                                {!! Form::label('action', 'Action:') !!}
                                                                <button type="button" class="btn-delete btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8"></div>
                                    <div class="form-group col-sm-2">
                                        <button type="button" class="form-control btn-add-filter btn btn-info"><i class="fa fa-plus"></i> Add Filter</button>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <button type="submit" class="form-control btn btn-primary btn-submit">Submit</button>
                                    </div>
                                </div>
                                <!-- End Filter DataTable -->
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="select">
                            <div class="col-sm-12">
                                <div class="form-group">
                                {!! Form::label('columns', 'Columns:') !!}
                                </div>
                                @php($idx = 0)
                                @foreach($columnsFilter as $item)
                                    <div class="checkbox col-sm-3">
                                        <label>
                                            <input class="toggle-vis" type="checkbox" name="{{$item}}" data-column="{{$idx}}" value="{{$idx}}"> {{$item}}
                                        </label>
                                    </div>
                                    @php($idx++)
                                @endforeach
                            </div>
                        </div>
                        {{--<div role="tabpanel" class="tab-pane" id="search">
                            <div class="col-sm-12">
                                <div class="form-group" style="width: 100%">
                                    {!! Form::label('search', 'Search:') !!}
                                    {!! Form::text('search', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                @foreach($columnsFilter as $item)
                                    <div class="checkbox col-sm-3">
                                        <label>
                                            <input type="checkbox" name="{{$item}}"> {{$item}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>--}}
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>

<div class="custom-table-wrapper" id="custom-table-wrapper" style="display: none">
    <table class="table table-bordered" id="custom-table">
        <thead>
        <tr>
            @foreach($columnsFilter as $item)
                <th>{{$item}}</th>
            @endforeach
        </tr>
        </thead>
        <tfoot><tr></tr></tfoot>
    </table>
</div>

{!! $dataTable->table(['class' => 'table table-bordered', 'width' => '100%'], true) !!}

{{--<!-- modal filter -->
@if(!empty($items['data']))
    @include('vendor.components.filterBydate')
@endif--}}

@section('scripts')
@include('layouts.datatables_js')
{!! $dataTable->scripts() !!}

{{--<script src="http://cdn.datatables.net/plug-ins/1.10.16/dataRender/datetime.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>--}}

<!-- Button TestJs -->
{{--<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js
"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js
"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js

"></script>--}}
<!-- endTsts -->


<script>
    $(document).ready(function () {
        if(localStorage.getItem('filter')) {
            var filterData = JSON.parse(localStorage.getItem('filter'));
            renderCustomDataTable(filterData);

            // handling custom filter form
            $('.filter-wrapper').empty();

            $.each(filterData, function (index, item) {
                var queryForm = `
                    <div id="query`+index+`" class="query `+[item.column]+`">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="command-group form-group" style="width: 100%">
                                    {!! Form::label('command', 'Command:') !!}
                                    {!! Form::select('query`+index+`', [
                                        'where' => 'where',
                                        'orWhere' => 'orWhere',
                                        'whereRaw' => 'whereRaw',
                                        'whereNull' => 'whereNull',
                                        'whereNotNull' => 'whereNotNull',
                                        'whereIn' => 'whereIn',
                                        'whereNotIn' => 'whereNotIn',
                                        'whereBetween' => 'whereBetween',
                                        'whereNotBetween' => 'whereNotBetween',
                                        'whereDate' => 'whereDate',
                                        'whereMonth' => 'whereMonth',
                                        'whereDay' => 'whereDay',
                                        'whereYear' => 'whereYear',
                                        'whereTime' => 'whereTime',
                                        'groupBy' => 'groupBy'
                                    ], null, ['class' => 'form-control select2 command']) !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="column-group form-group" style="width: 100%">
                                    {!! Form::label('column', 'Column:') !!}
                                    {!! Form::select('query`+index+`', $columnsFilter, null, ['class' => 'column form-control select2']) !!}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="operator-group form-group" style="width: 100%">
                                    {!! Form::label('operator', 'Operator:') !!}
                                    {!! Form::select('query`+index+`', [
                                        '' => '',
                                        '=' => '=',
                                        '>' => '>',
                                        '<' => '<',
                                        '>=' => '>=',
                                        '<=' => '<=',
                                        '!=' => '!=',
                                        '<>' => '<>',
                                        'LIKE' => 'LIKE',
                                        'NOT LIKE' => 'NOT LIKE'
                                    ], null, ['class' => 'form-control select2 operator']) !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="value form-group" style="width: 100%">
                                        {!! Form::label('value', 'Value:') !!}
                                        <input type="text" class="form-control" name="query`+index+`" value="`+item.value+`" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-group" style="width: 100%">
                                    <div class="btn-group-query">
                                        <div class="form-group">
                                            {!! Form::label('action', 'Action:') !!}
                                            <button type="button" class="btn-delete btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('.filter-wrapper').append(queryForm);

                $('#query'+index).find('.command').val(item.command);
                $('#query'+index).find('.column').val(item.column);
                $('#query'+index).find('.operator').val(item.operator);
            });
        }
    });

    var slug = '{{ $items['page']->slug }}';
    var columns = @json($columnsFilter);
    {{--var dataQueryServer = @json($queryData);--}}

    var tableCustom;

    $(document).on('submit', 'form', function (e) {
        e.preventDefault();
        var addFilter = [];
        var output = [];

        // get all input of form filter
        $(this).serializeArray().forEach(function(value) {
            var existing = output.filter(function(v, i) {
                return v.name == value.name;
            });
            if (existing.length) {
                var existingIndex = output.indexOf(existing[0]);
                output[existingIndex].value = output[existingIndex].value.concat(value.value);
            } else {
                if (typeof value.value == 'string')
                    value.value = [value.value];
                output.push(value);
            }
        });

        // get additional query filter
        $.each(output, function (index, item) {
            if(item.name.indexOf('query') != -1){
                addFilter.push({command: item.value[0], column: item.value[1], operator: item.value[2] ? item.value[2] : null, value: item.value[3] ? item.value[3] : null})
            }
        });

        localStorage.setItem('filter', JSON.stringify(addFilter));

        renderCustomDataTable(addFilter);
    });

    function renderCustomDataTable(dataFilter) {
        var columnsDataTable = [];

        $('#custom-table-wrapper').show();
        $('#dataTableBuilder_wrapper').hide();



        // handing custom datatable
        $.each(columns, function (index, item) {
            columnsDataTable.push({data: item, name: item});
        });

        if(tableCustom) {
            tableCustom.destroy();
        }
           

       
        // end handling custom datatable
          $.ajax({
            type: 'get',
            url: '{{ url('getDataTable?slug=') }}'+slug,
            }).done(function (res) {




                tableCustom = $('#custom-table').DataTable({
                processing: true,
                serverSide: true,
                dom:'Blifrtp',
                button:['excel'],
                {{--ajax: '{{ url('getDataTable?slug=') }}'+slug+'&filter='+encodeURIComponent(JSON.stringify(dataQueryMerge)),--}}
                ajax: {
                url: '{{ url('getDataTable?slug=') }}'+slug,
                data: function (d) {
                    d.filter = dataFilter;

                }/*,
                success: function (res) {
                    console.log(res);
                }*/
                },
                columns: columnsDataTable
                });
                    var columnsData=[];
                    var dtColumn=[];
                    var hdColumn=[];


                    //HeadColumn Name
                    $.each(res.data[0],function(k,v){
                    hdColumn.push(k);
                    });

                    var result = {};

                     $.each(hdColumn,function(ix,itm){
                         result[itm] = [];
             
                         $.each(res.data,function(i,t){
                             result[itm].push(t[itm]);
                         });

                    });

                    var dist={};

                    $.each(result,function(a,b){
                    dist[a] = [];
                        b= b.filter(function(e){return e != undefined});

                          $.each($.unique(b),function(c,d){
                             dist[a].push(d);
                            
                          });

                    });
                  
            // dataTable selection
              
            //dataTable Append search selection and Input
             if($('.column-search-custom').length < 1){
                console.log(true)
             
                $('#custom-table').append('<div></div>');
                $('#custom-table thead').append('<tr class="column-search-custom" style="background-color:#d9d9d9;"></tr>');

                $('#custom-table thead th').each(function() {
                 var title = $(this).text();
                 titleTemp.push(title);
                 if(title === 'Action') {
                     $('.column-search-custom').append('<td></td>');
                 }
                 else {
                     $('.column-search-custom').append('<td id="'+title+'"><input class="form-control" type="text" placeholder="Search '+title+'" /></td>');
                 }
                //datatable select2 column search
                $.each(dist, function (index, item) {
                 var itemArray = Object.keys(item).map(function(x) { return item[x]; });
                    
                 if (itemArray.length <= 30 && itemArray.length > 0){
                  
                     $('#'+index).empty();
                     $('#'+index).append('<select class="form-control select2" style="width:100%"><select>');

                     var option = '<option></option>';
                     $.each(item, function (idx, itm) {
                         option += '<option value="'+itm+'">'+itm+'</option>';
                     });

                     var el = $('#'+index+' select').append(option);

                     el.select2();
                 }
                }); //endsSelection
               
                }); //end Custom Table Head
               
            }//end if Condition Exist Element .column-search-custom

                //count Function
                // handling column math
                    var allColumnData = res.data;
                    //console.log(allColumnData)

                    $(document).on('click', '.column-math li', function (e) {
                        e.preventDefault();

                        var value = $(this).find('a').attr('class');
                        var column = $(this).parents('.column-math').data('column');

                        var getArrayColumn = allColumnData.map(function(i){
                                
                            return i[column];
                        });
                        

                        $(this).parents('.column-math').find('.column-math-input').val(columnMath(getArrayColumn, value));
                    });

                    var columnMath = function(arr, r) {
                        var sum = 0;
                        var count = 0;
                        var max = 0;
                        var min;
                          //grep function to remove null value
                           arr = $.grep(arr, function(n, i){
                              return (n !== "" && n != null);
                            });
                        for(var i = 0; i < arr.length; i++) {
                            if (arr[i].match(/^[0-9]+$/) !== null) {
                                sum += parseInt(arr[i]);
                                count++;
                                max = parseInt(arr[i]) > max ? parseInt(arr[i]) : max;
                                if(i === 0) {
                                    min = parseInt(arr[i]);
                                } else {
                                    min = parseInt(arr[i]) > min ? min : parseInt(arr[i]);
                                }
                            }
                        }

                        if(r === 'count') {
                            return count;
                        } else if(r === 'avg') {
                            return sum/count;
                        } else if(r === 'max') {
                            return max;
                        } else if(r === 'min') {
                            return min;
                        } else {
                            return sum;
                        }
                    };

                    $('#custom-table tfoot tr').empty();

                    $.each(dist, function(index, item) {
                        var columnTypeNum = false;
                        var uniqueItemArray = Object.keys(item).map(function(x) { return item[x]; });

                        $.each(uniqueItemArray, function(idx,itm) {
                            var isItemNum = /^[0-9]+$/.test(itm);

                            if(isItemNum) {
                                columnTypeNum = true;
                            }
                        });

                        if(columnTypeNum){
                            $('#custom-table tfoot tr').append(`
                                <th>
                                    <div class="input-group column-math" data-column="`+index+`">
                                        <div class="input-group-btn dropup">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Math <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a class="sum">SUM</a></li>
                                                <li><a class="count">COUNT</a></li>
                                                <li><a class="avg">AVG</a></li>
                                                <li><a class="max">MAX</a></li>
                                                <li><a class="min">MIN</a></li>
                                            </ul>
                                        </div>
                                        <input type="text" class="form-control column-math-input">
                                    </div>
                                </th>
                            `);
                        } else {
                            $('#custom-table tfoot tr').append('<th></th>');
                        }
                    });

                    $(document).on('click', '.column-math li', function () {
                        var mathText = $(this).find('a').text();

                        $(this).parents('.column-math').find('button').html(mathText+' <span class="caret"></span>');
                    });
                    //end handling column math

                //endCountFunction
                //searching function
                var idx = 0;
                tableCustom.columns().every(function() {
                     var that = this;

                     $('input', $('.column-search-custom td').get(idx)).on('keyup change', function() {
                         if (that.search() !== this.value) {
                            //console.log(this.value);
                             that
                                 .search(this.value)
                                 .draw();
                         }
                     });

                     $('select', $('.column-search-custom td').get(idx)).on('keyup change', function() {
                         if (that.search() !== this.value) {
                             //console.log(this.value);
                             that
                                 .search(this.value)
                                 .draw();
                         }
                     });

                     idx++;
                 });

                //ends



            });


       
        $('#custom-table').wrap('<div class="table-responsive col-md-12"></div>');
        $('.table-responsive').before('<div class="clearfix"></div>');
    }

    // delete filter
    $(document).on('click', '.btn-delete', function () {
        $(this).parents('.query').remove();
    });

    // handling data query definition form
    var idx = $('.filter-wrapper .query').length - 1;

    $('.btn-add-filter').on('click', function() {
        idx++;
        var queryForm = `
            <div id="query`+idx+`" class="query">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group" style="width: 100%">
                            {!! Form::label('command', 'Command:') !!}
                            {!! Form::select('query`+idx+`', [
                                'where' => 'where',
                                'orWhere' => 'orWhere',
                                'whereRaw' => 'whereRaw',
                                'whereNull' => 'whereNull',
                                'whereNotNull' => 'whereNotNull',
                                'whereIn' => 'whereIn',
                                'whereNotIn' => 'whereNotIn',
                                'whereBetween' => 'whereBetween',
                                'whereNotBetween' => 'whereNotBetween',
                                'whereDate' => 'whereDate',
                                'whereMonth' => 'whereMonth',
                                'whereDay' => 'whereDay',
                                'whereYear' => 'whereYear',
                                'whereTime' => 'whereTime',
                                'groupBy' => 'groupBy'
                            ], null, ['class' => 'form-control select2 command']) !!}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="field-group form-group" style="width: 100%">
                            {!! Form::label('column', 'Column:') !!}
                            {!! Form::select('query`+idx+`', $columnsFilter, null, ['class' => 'field form-control select2']) !!}
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="operator form-group" style="width: 100%">
                            {!! Form::label('operator', 'Operator:') !!}
                            {!! Form::select('query`+idx+`', [
                                '' => '',
                                '=' => '=',
                                '>' => '>',
                                '<' => '<',
                                '>=' => '>=',
                                '<=' => '<=',
                                '!=' => '!=',
                                '<>' => '<>',
                                'LIKE' => 'LIKE',
                                'NOT LIKE' => 'NOT LIKE'
                            ], null, ['class' => 'form-control select2']) !!}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="value form-group" style="width: 100%">
                                {!! Form::label('value', 'Value:') !!}
                                {!! Form::text('query`+idx+`', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group" style="width: 100%">
                            <div class="btn-group-query">
                                <div class="form-group">
                                    {!! Form::label('action', 'Action:') !!}
                                    <button type="button" class="btn-delete btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('.filter-wrapper').append(queryForm);
    });
    // end handling data query definition form
</script>

<script>
    var columnsData = @json($columnsData);
    var titleTemp = [];

    $('#dataTableBuilder').append('<div></div>');
    $('#dataTableBuilder thead').append('<tr class="column-search" style="background-color:#d9d9d9;"></tr>');

    $('#dataTableBuilder thead th').each(function() {
        var title = $(this).text();
        titleTemp.push(title);
        if(title === 'Action') {
            $('.column-search').append('<td></td>');
        }
        else {
            $('.column-search').append('<td id="'+title+'"><input class="form-control" type="text" placeholder="Search '+title+'" /></td>');
        }
    });

    // datatable select2 column search
    $.each(columnsData, function (index, item) {
        var itemArray = Object.keys(item).map(function(x) { return item[x]; });
        if (itemArray.length <= 30 && itemArray.length > 0){
            $('#'+index).empty();
            $('#'+index).append('<select class="form-control select2" style="width:100%"><select>');

            var option = '<option></option>';
            $.each(item, function (idx, itm) {
                option += '<option value="'+itm+'">'+itm+'</option>';
            });

             var el = $('#'+index+' select').append(option);

             el.select2();
        }
    });
    // end datatable select2 column search

    // handling column math
    var allColumnData = @json($allColumnData);
    
    $(document).on('click', '.column-math li', function (e) {
        e.preventDefault();

        var value = $(this).find('a').attr('class');
        var column = $(this).parents('.column-math').data('column');

        var getArrayColumn = allColumnData.map(function(i){
            return i[column];
        });

        $(this).parents('.column-math').find('.column-math-input').val(columnMath(getArrayColumn, value));
    });

    var columnMath = function(arr, r) {
        var sum = 0;
        var count = 0;
        var max = 0;
        var min;
            
        for(var i = 0; i < arr.length; i++) {
            if (arr[i].match(/^[0-9]+$/) !== null) {
                sum += parseInt(arr[i]);
                count++;
                max = parseInt(arr[i]) > max ? parseInt(arr[i]) : max;
                if(i === 0) {
                    min = parseInt(arr[i]);
                } else {
                    min = parseInt(arr[i]) > min ? min : parseInt(arr[i]);
                }
            }
        }

        if(r === 'count') {
            return count;
        } else if(r === 'avg') {
            return sum/count;
        } else if(r === 'max') {
            return max;
        } else if(r === 'min') {
            return min;
        } else {
            return sum;
        }
    };

    $('#dataTableBuilder tfoot tr').empty();

    $.each(columnsData, function(index, item) {
        var columnTypeNum = false;
        var uniqueItemArray = Object.keys(item).map(function(x) { return item[x]; });

        $.each(uniqueItemArray, function(idx,itm) {
            var isItemNum = /^[0-9]+$/.test(itm);

            if(isItemNum) {
                columnTypeNum = true;
            }
        });

        if(columnTypeNum){
            $('#dataTableBuilder tfoot tr').append(`
                <th>
                    <div class="input-group column-math" data-column="`+index+`">
                        <div class="input-group-btn dropup">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Math <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a class="sum">SUM</a></li>
                                <li><a class="count">COUNT</a></li>
                                <li><a class="avg">AVG</a></li>
                                <li><a class="max">MAX</a></li>
                                <li><a class="min">MIN</a></li>
                            </ul>
                        </div>
                        <input type="text" class="form-control column-math-input">
                    </div>
                </th>
            `);
        } else {
            $('#dataTableBuilder tfoot tr').append('<th></th>');
        }
    });

    $(document).on('click', '.column-math li', function () {
        var mathText = $(this).find('a').text();

        $(this).parents('.column-math').find('button').html(mathText+' <span class="caret"></span>');
    });
    // end hanling column math

    // $('.column-sum').append('<td><select class="form-control"><option ></option><option value="sum" >SUM</option><option value="avg" >AVG</option><option value="max" >MAX</option><option value="min" >MIN</option></select>'+titleTemp[titleIndex]+'</td>');
    // titleIndex += 1;

    //$('.column-sum').append('<td><select class="form-control"><option ></option><option value="sum" >SUM</option><option value="avg" >AVG</option><option value="max" >MAX</option><option value="min" >MIN</option></select></td>')

    //  $('#dataTableBuilder tfoot th').each(function() {
    //     var title = $(this).text();
    //     if(title === 'Action') {
    //         $('.column-search-select').append('<td></td>');
    //     } else {
    //          var select=$('.column-search-select').append('<td><select><option value=""></option></select></td>');
    //          // .on( 'change', function () {
    //          //        var val = $.fn.dataTable.util.escapeRegex(
    //          //            $(this).val();
    //          //        });

    //     }
    //     console.log(select)
    // });

    var table = $('#dataTableBuilder').DataTable();

    var idx = 0;
    table.columns().every(function() {
        var that = this;

        $('input', $('.column-search td').get(idx)).on('keyup change', function() {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });

        $('select', $('.column-search td').get(idx)).on('keyup change', function() {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });

        idx++;
    });

    var dataHiddenColumn = [];

    $(document).on('change', '.toggle-vis', function() {
        if($(this).prop('checked')) {
            dataHiddenColumn[$(this).val()] = $(this).val();
        } else {
            delete dataHiddenColumn[$(this).val()];
        }

        localStorage.setItem('hiddenColumn', JSON.stringify(dataHiddenColumn));

        hideColumn($(this).val(), table);
        hideColumn($(this).val(), tableCustom);
    });

    function hideColumn(idx, table) {
        var el = $('[data-column="'+idx+'"]');

        if($(el).prop('checked')) {
            $(el).parent().addClass('line-through');

            $('thead .column-search').find('td:nth-child('+(parseInt(el.val())+1)+')').hide();
            $('thead .column-search-custom').find('td:nth-child('+(parseInt(el.val())+1)+')').hide();
            $('tfoot').find('th:nth-child('+(parseInt(el.val())+1)+')').hide();
        } else {
            $(el).parent().removeClass('line-through');

            $('thead .column-search').find('td:nth-child('+(parseInt(el.val())+1)+')').show();
            $('thead .column-search-custom').find('td:nth-child('+(parseInt(el.val())+1)+')').show();
            $('tfoot ').find('th:nth-child('+(parseInt(el.val())+1)+')').show();

        }

        // Get the column API object
        var column = table.column($(el).val());

        // Toggle the visibility
        column.visible(!column.visible());
    }

    $('#dataTableBuilder').wrap('<div class="table-responsive"></div>');
    $('.table-responsive').before('<div class="clearfix"></div>');
</script>
@endsection