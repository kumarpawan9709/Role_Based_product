@extends('layouts.app')
@section('content')
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
            
    <div class="d-flex flex-column-fluid">
        <div class=" container ">
            <form action="{{route($model.'.store')}}" method="post" class="mws-form" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="card card-custom gutter-b">     
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-group">
                                   <lable for="name">Name</lable><span class="text-danger"> * </span>
                                    <input type="text" name="name" class="form-control form-control-solid form-control-lg @error('name') is-invalid @enderror" value="{{old('name')}}">
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <lable for="name">Email</lable><span class="text-danger"> * </span>
                                    <input type="text" name="email" class="form-control form-control-solid form-control-lg @error('email') is-invalid @enderror" value="{{old('email')}}">
                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-group">
                                   <lable for="name">Phone</lable><span class="text-danger"> * </span>
                                    <input type="text" name="phone" class="form-control form-control-solid form-control-lg @error('phone') is-invalid @enderror" value="{{old('phone')}}">
                                    @if ($errors->has('phone'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group ">
                                    <label for="exampleFormControlTextarea5">Comment</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea5" name="comment" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between border-top mt-5 pt-10">
                            <div>
                                <button button type="submit" class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection