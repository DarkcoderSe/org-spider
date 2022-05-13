<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Lead Generation System</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mt-4 pt-4">
                    <h2>
                        LinkedIn Org Spider
                    </h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-5 mt-4">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ URL::to('/import') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Import File <span class="text-danger">( xlsx files only )</span> </label>
                                        <input type="file" name="file" class="form-control" placeholder="Import Excel File" required>

                                        @if ($errors->any('file'))
                                        <span class="text-danger small">
                                            {{ $errors->first('file') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Import') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>

            @if (session('message'))
            <div class="row justify-content-center">
                <div class="col-md-5 mt-4">
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('message') }}
                    </div>

                    <script>
                        $(".alert").alert();
                    </script>
                </div>
            </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-5 mt-4" id="notify">

                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {
                setInterval(() => {
                    $.get('check-export', function(response) {
                        let nonExportedOrgs = Number(response['nonExportedOrgs']);
                        let exportedOrgs = Number(response['exportedOrgs']);
                        let totalOrgs = nonExportedOrgs + exportedOrgs;
                        if (totalOrgs > 0) {
                            if (totalOrgs == exportedOrgs) {
                                $('#notify').html(`<div class="alert alert-primary" role="alert">
                                                        <strong>Download Ready</strong> : Your list is ready to download, Please <a href="">Click here to Download</a>
                                                    </div>`);
                            }
                            // else {
                            //     $('#notify').html(`<div class="alert alert-primary" role="alert">
                            //                             <strong>Download Ready</strong> : Your list is ready to download, Please <a href="">Click here to Download</a>
                            //                         </div>`);
                            // }
                        }
                    });
                }, 60000);
            });
        </script>
    </body>
</html>
