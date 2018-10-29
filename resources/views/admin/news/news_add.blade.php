@extends('layouts.backend.master')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
                              <h1 class="main-title float-left">Add News</h1>
                              <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active">Add News</li>
                              </ol>
                              <div class="clearfix"></div>
                      </div>
    </div>
</div>


<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
<div class="card mb-3">
<!-- <div class="card-header">
<h3><i class="fa fa-hand-pointer-o"></i> Form validator</h3>
A simple demo form that uses most of supported Parsley elements to show how to bind, configure and validate them properly.
</div> -->

<div class="card-body">

  <form action="{{ url('/admin/news/add') }}" data-parsley-validate novalidate method="post" enctype="multipart/form-data">
    {{csrf_field()}}
                                  <div class="form-group">
                                      <label for="userName">Title<span class="text-danger">*</span></label>
                                      <input type="text" name="title" data-parsley-trigger="change" required placeholder="Enter title" class="form-control">
                                  </div>

                                  <div class="form-group">
                                      <label for="userName">Message<span class="text-danger">*</span></label>
                                      <textarea name="message" rows="8" cols="80" data-parsley-trigger="change" required placeholder="Enter Message" class="form-control" ></textarea>
                                  </div>

                                  <div class="form-group">
                                    <label for="">Image <span class="text-danger">*</span>  </label>
                                    <input type="file" name="file" class="form-control" required>

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

  $('form').parsley();

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

  });


  $('form').on('submit',function(e){

    e.preventDefault();

    var data = new FormData($(this)[0]);
    var type = $(this).attr('method');
    var url = $(this).attr('action');

    $.ajax({
      type:type,
      url:url,
      data:data,
      dataType:'JSON',
      contentType:false,
      enctype:'multipart/form-data',
      processData:false,
      beforeSend:function(){
        $('.se-pre-con').show();

      },
      error:function(xhr){
        console.log(xhr.statusText + xhr.responseText);
        messageAlert(xhr.responseText,'danger');
      },
      success:function(msg) {
        if(msg.message == "Success") {
          messageAlert('Successfully Added!','success');
          $('form')[0].reset();

        }else {
          alert('Failed');
        }
      },
      complete:function(){
        $('.se-pre-con').hide();
      }

    });




  });





</script>
@endsection
