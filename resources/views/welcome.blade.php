<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Image Dehazing </title>
    @vite('resources/css/app.css')
</head>
<body class=" flex flex-col min-h-screen justify-center items-center " >
    <div>
        <div class=" my-4">
            <header class=" text-xl font-semibold text-center "> Image Dehazing using <span class=" font-semibold text-purple-800"> Opencv </span> </header>
        </div>
        <hr>
        <div class=" py-6 bg-gray-400 rounded shadow-md px-6" >
            <form action="{{ route('dehaze_route') }}" enctype="multipart/form-data" method="POST" >
                @csrf
                <div class=" flex flex-col space-y-4">
                    <label for=""> Select Image </label>
                    <input name="HazeImage"  type="file" accept="image/*" onchange="previewImage(event)">

                </div>
                <div class="my-4 rounded overflow-hidden">
                    <img id="preview" src="#" alt="Preview" style="display: none;" class="max-w-xs">
                </div>

                @if (session('dehazed_path'))
                    <div class=" flex flex-col space-y-3 ">
                        <header> Dehazed Image </header>
                        <div class="my-4 rounded overflow-hidden">
                            <img id="preview" src="{{ asset(session('dehazed_path')) }}" alt="Preview" class="max-w-xs">
                        </div>
                    </div>
                @endif

                <div class=" my-4 ">
                    <input type="submit" value="Dehaze" class=" bg-purple-900 text-white px-6 py-2 rounded shadow ">
                </div>
            </form>
        </div>
    </div>
    <script>
        function previewImage(event) {
                var reader = new FileReader();
                var image = document.getElementById('preview');

                reader.onload = function() {
                    if (reader.readyState == 2) {
                        image.src = reader.result;
                        image.style.display = 'block';
                    }
                }

                reader.readAsDataURL(event.target.files[0]);
            }


    </script>
</body>
</html>
