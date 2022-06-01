<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>File Uploader</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>

<body>
    <div class="py-10 font-serif">
        <header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">File Uploader</h1>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="px-4 py-8 sm:px-0">
                    <form action="{{ route('fileUpload') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="chooseFile">
                            <label class="custom-file-label" for="chooseFile">Select file</label>
                        </div>
                        <div class="pt-4">
                            <button type="submit" name="submit"
                                class="rounded-sm px-2 py-0.5 bg-gray-100 border  border-gray-500">
                                Upload Files
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
