@extends('admin.layout.master')
@section('content')
<div class='container-fluid'>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- <div class="col-sm-6">
                    <h1>500 Error Page</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">500 Error Page</li>
                    </ol>
                </div> -->
            </div>
        </div>
    </section>
    <section class="content"align='center'>
        <div class="row">
            <div class='col-md-12'>
                <!-- <h2 class="headline text-danger">500</h2> -->
                <div class="col-md-12" align='center'>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <h3 style="text-transform: uppercase;"><i class="fas fa-exclamation-triangle text-danger"></i> Oops! You Have No Privilege To View This Page.</h3>
                    <!-- <p>
                        We will work on fixing that right away.
                        Meanwhile, you may
                    </p> -->

                </div>
            </div>
        </div>       








        


    </section>
</div><!-- /.row -->
@endsection

@push('pagescripts')

@endpush