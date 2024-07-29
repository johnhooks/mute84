<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>File Uploader</title>

    @vite(['resources/css/app.css'])

    <style>
        body {
            background-image: linear-gradient(45deg,
                    hsl(240deg 100% 20%) 0%,
                    hsl(289deg 100% 21%) 11%,
                    hsl(315deg 100% 27%) 22%,
                    hsl(329deg 100% 36%) 33%,
                    hsl(337deg 100% 43%) 44%,
                    hsl(357deg 91% 59%) 56%,
                    hsl(17deg 100% 59%) 67%,
                    hsl(34deg 100% 53%) 78%,
                    hsl(45deg 100% 50%) 89%,
                    hsl(55deg 100% 50%) 100%);
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <div class="py-10 font-serif">
        <header>
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">File Uploader</h1>
            </div>
        </header>
        <main>
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                        <div>
                            <label for="chooseFile">Select file</label>
                            <input type="file" name="file" id="chooseFile" class="block sm:text-sm" />
                        </div>
                        <div class="pt-4">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="block sm:text-sm"
                                value="{{ old('name') }}" />
                        </div>
                        <div class="pt-4">
                            <button type="submit" name="submit"
                                class="rounded-sm px-2 py-0.5 bg-gray-100 border  border-gray-500 sm:text-sm">
                                Upload File
                            </button>
                        </div>
                        <div class="pt-4">
                            <a href="{{ url('/dashboard') }}"
                                class="rounded-sm px-2 py-1 bg-gray-100 border  border-gray-500 sm:text-sm">Back
                                to Dashboard</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
