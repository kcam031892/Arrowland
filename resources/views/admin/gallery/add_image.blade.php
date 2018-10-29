@extends('layouts.backend.master')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
                              <h1 class="main-title float-left">Add Image</h1>
                              <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active">Add Image</li>
                              </ol>
                              <div class="clearfix"></div>
                      </div>
    </div>
</div>


<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
<div class="card mb-3">


<div class="card-body">

  <form action="{{ url('/admin/gallery/add')}}" data-parsley-validate novalidate method="post" enctype="multipart/form-data">
    {{csrf_field()}}
                                  <div class="form-group">
                                      <label for="userName">Title<span class="text-danger">*</span></label>
                                      <input type="text" name="title" data-parsley-trigger="change" required placeholder="Enter user name" class="form-control" id="userName">
                                  </div>

                                  <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" name="file" required class="form-control">

                                  </div>

                                  <div class="form-group text-right m-b-0">
                                      <button class="btn btn-primary" type="submit">
                                          Submit
                                      </button>
                                      <button type="reset" class="btn btn-secondary m-l-5">
                                          Cancel
                                      </button>
                                  </div>

                      </form>

</div>
</div><!-- end card-->
  </div>

</div>

<style media="screen">

</style>

@endsection

@section('script')
<script type="text/javascript">

  $('#form').parsley();

  $(document).ready(function(){
    'use-strict';
    $('#filer_example2').filer({
        limit: 1,
        maxSize: 15,
        extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd'],
        changeInput: true,
        showThumbs: true,
        addMore: true
    });

  })



</script>
@endsection
