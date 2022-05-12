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
        </div>
    </body>
</html>
