<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="text-center text-primary fs-5 p-3">បញ្ចូលព័ត៌មានថ្មីៗ</div>
    @if(session('imagePath'))
    <p>Uploaded Image:</p>
    <img src="{{ asset('storage/' . session('imagePath')) }}" width="200">
    @endif
        <form action="{{ route('news.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" class="form-control" name="imageNews" required>   
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</div>
</body>
</html>