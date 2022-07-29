@extends('layouts.app')
@section('content')
<style>
    .price_tab {
        padding: 0 0 0 12px;
    } 
</style>
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
 
    <div class="d-flex flex-column-fluid">
        <div class=" container ">
        <div class=”panel-heading”>You are Cashier User</div>
            <form action="{{route('sales.home')}}" method="get" class="kt-form kt-form--fit mb-0" autocomplete="off">
                <input type="hidden" name="display">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card card-custom card-stretch card-shadowless">
                            <div class="card-header">
                                <div class="card-title">

                                </div>
                                <div class="card-toolbar">
                                    <a href="javascript:void(0);" class="btn btn-primary dropdown-toggle mr-2" data-toggle="collapse" data-target="#collapseOne6">
                                        Search
                                    </a> 
                                    <a href="javascript:void(0)" class="btn btn-primary" id="download_pdf"> Download Pdf</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample6">
                                    <div id="collapseOne6" class="collapse <?php echo !empty($searchVariable) ? 'show' : ''; ?>" data-parent="#accordionExample6">
                                        <div>
                                            <div class="row mb-6">
                                                <div class="col-lg-3  mb-lg-5 mb-6">
                                            
                                                    <label>Status</label>
                                                    <select name="is_active" class="form-control select2init" value="{{$searchVariable['is_active'] ?? ''}}">
                                                        <option value="">All</option>
                                                        <option value="1">Activate</option>
                                                        <option value="0">Deactivate</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 mb-lg-5 mb-6">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" name="name" placeholder=" Name" value="{{$searchVariable['name'] ?? '' }}">
                                                </div>
                                                 
                                            </div>
                                            <div class="row mt-8">
                                                <div class="col-lg-12">
                                                    <button class="btn btn-primary btn-primary--icon" id="kt_search">
                                                        <span>
                                                            <i class="la la-search"></i>
                                                            <span>Search</span>
                                                        </span>
                                                    </button>
                                                    &nbsp;&nbsp;
                                                    <a href='{{ route("cashier.home")}}' class="btn btn-secondary btn-secondary--icon">
                                                        <span>
                                                            <i class="la la-close"></i>
                                                            <span>Clear Search</span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="dataTables_wrapper ">
                                    <div class="table-responsive">
                                        <table class="table dataTable table-head-custom table-head-bg table-borderless table-vertical-center" id="taskTable">
                                            <thead>
                                                <tr class="text-uppercase">
                                                    <th class="{{(($sortBy == 'name' && $order == 'desc') ? 'sorting_desc' : (($sortBy == 'name' && $order == 'asc') ? 'sorting_asc' : 'sorting'))}}">
                                                        <a href="{{route('sales.home',array(	'sortBy' => 'name',
													'order' => ($sortBy == 'name' && $order == 'desc') ? 'asc' : 'desc',	
													$query_string))}}"> Name</a>
                                                    </th>
                                                    <th class="{{(($sortBy == 'created_at' && $order == 'desc') ? 'sorting_desc' : (($sortBy == 'created_at' && $order == 'asc') ? 'sorting_asc' : 'sorting'))}}">
                                                        <a href="{{route('sales.home',array(	'sortBy' => 'created_at',
													'order' => ($sortBy == 'created_at' && $order == 'desc') ? 'asc' : 'desc',	
													$query_string))}}">Added On</a>
                                                    </th>
                                                    <th class="{{(($sortBy == 'is_active' && $order == 'desc') ? 'sorting_desc' : (($sortBy == 'is_active' && $order == 'asc') ? 'sorting_asc' : 'sorting'))}}">
                                                        <a href="{{route('sales.home',array(	'sortBy' => 'is_active',
													'order' => ($sortBy == 'is_active' && $order == 'desc') ? 'asc' : 'desc',	
													$query_string))}}">Status</a>
                                                    </th>
                                                    <th class="{{(($sortBy == 'job_status' && $order == 'desc') ? 'sorting_desc' : (($sortBy == 'job_status' && $order == 'asc') ? 'sorting_asc' : 'sorting'))}}">
                                                        <a href="{{route('sales.home',array(	'sortBy' => 'job_status',
													'order' => ($sortBy == 'job_status' && $order == 'desc') ? 'asc' : 'desc',	
													$query_string))}}">Job Status</a>
                                                    </th>
                                                    <th class="text-right">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!$results->isEmpty())
                                                @foreach($results as $result)
                                                <tr>
                                                     <td>
                                                        <div class="text-dark-75 mb-1 font-size-lg">
                                                            {{ $result->name }}
                                                        </div>
                                                    </td> 
                                                    <td>
                                                        <div class="text-dark-75 mb-1 font-size-lg">
                                                            {{ date('d-m-Y',strtotime($result->created_at)) }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($result->is_active == 1)
                                                        <span class="label label-lg label-light-success label-inline">Activated</span>
                                                        @else
                                                        <span class="label label-lg label-light-danger label-inline">Deactivated</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="text-dark-75 mb-1 font-size-lg">
                                                            {{ $result->job_status }}
                                                        </div>
                                                    </td>
                                                    <td class="text-right pr-2">
                                                        @if($result->amount)
                                                            <div class="text-dark-75 mb-1 font-size-lg">
                                                                {{ $result->amount }}
                                                            </div>
                                                        @else
                                                            <div class="price_edit"></div>
                                                            <a href="javascript:void(0)" class="edit_price price_tab" data-job_id="{{$result->id}}">Add Price</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="6" style="text-align:center;"> {{ trans("Record not found.") }}</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $("#download_pdf").live("click", function () {
            var divContents = $(".dataTables_wrapper").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title></title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    </script>
<script>
        $(document).ready(function() {
            /* SCRIPT FOR UPDATE PRICE */ 
                $(document).on("click",".price_tab",function(){ 
                    console.log('click');
                    if ($(this).hasClass("edit_price")) { 
                        $(this).parent().find('.price_edit').html("<input type='text' class='form-control price_input price_number_only' name='amount' value=''>");
                        $(this).removeClass('edit_price').addClass('save_price');
                        $(this).text('Save');
                    }else{
                        var job_id      =   $(this).data('job_id'); 
                        var price       =   $("input[name=amount]").val();
                        console.log(job_id+'xx'+price); 
                        var element = this;
                        $.ajax({
                            headers     :   {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                            url         :   '{{ route("jobs.updatePrice")}}',
                            method: 'post',
                            data: {
                                'job_id': job_id, 
                                'price':price
                            },
                            beforeSend: function() {
                                // $elem.prop('disabled', true);
                            },
                            success: function(r) {
                                error_array = JSON.stringify(r);
                                datas = JSON.parse(error_array); 
                                console.log(datas['success']);
                                if (datas['success'] == 1) {  
                                    if ($(element).hasClass("save_price")) {
                                         location.reload();
                                    }
                                } else{
                                    alert(datas['message']);
                                }  
                            }
                        });
                    }
                });
                
            /* SCRIPT FOR UPDATE PRICE END*/
        });
    $(document).on("keyup",".price_number_only",function(){
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });
    var focus = 0,
    blur = 0;
    $(document).on("focusout",".price_number_only",function(){
        focus++;
        console.log(this.value);
        if(this.value >= 0){
            this.value = parseFloat(this.value).toFixed(2);
        }else{
            this.value = 0;
        }
    })
</script>
@endsection