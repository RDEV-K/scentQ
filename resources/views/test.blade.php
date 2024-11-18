<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-6">
                <form action="/test" method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                      <label for="formFileLg" class="form-label">Large file input example</label>
                      <input class="form-control form-control-lg" id="formFileLg" type="file" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 btn-lg">Store Image</button>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-6">
                <ul class="list-group">
                    @forelse($files as $file)
                    <li class="list-group-item">
                        <a href="{{ Storage::disk('digitalocean')->url($file) }}" target="_blank">
                            {{ Storage::disk('digitalocean')->url($file) }}
                        </a>
                    </li>
                    @empty
                        <em>No files to display.</em>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>
