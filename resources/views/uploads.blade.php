@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Uploads</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Uploads
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>


    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


            <!-- Validation Errors -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <!-- Add Button -->
            <div class="mb-3">
                <button type="button"
                        class="btn btn-primary"
                        data-toggle="modal"
                        data-target="#addUploadModal">
                    <i class="fas fa-plus"></i>
                    Add Image
                </button>
            </div>


            <!-- Uploads Table -->
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Uploaded Images</h3>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th width="70">ID</th>
                                <th>Image</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($uploads as $upload)

                                <tr>

                                    <td>
                                        {{ $upload->id }}
                                    </td>

                                    <td>

                                        <img src="{{ asset('uploads/' . $upload->image) }}"
                                             alt="{{ $upload->image }}"
                                             style="width:100px; height:70px; object-fit:cover;"
                                             class="img-thumbnail">

                                        <div class="mt-2">
                                            <strong>
                                                {{ $upload->image }}
                                            </strong>
                                        </div>

                                    </td>

                                    <td>

                                        <!-- Copy Image Name -->
                                        <button type="button"
                                                class="btn btn-info btn-sm"
                                                onclick="copyImageName('{{ $upload->image }}')">

                                            <i class="fas fa-copy"></i>
                                            Copy Image Name

                                        </button>


                                        <!-- Delete -->
                                        <form action="{{ route('uploads.destroy', $upload->id) }}"
                                              method="POST"
                                              style="display:inline-block;"
                                              onsubmit="return confirm('Are you sure you want to delete this image?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-primary btn-sm">

                                                <i class="fas fa-trash"></i>
                                                Delete

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3" class="text-center">
                                        No images uploaded.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </section>

</div>


<!-- ========================= -->
<!-- ADD IMAGE MODAL -->
<!-- ========================= -->

<div class="modal fade" id="addUploadModal">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">
                    Add Image
                </h4>

                <button type="button"
                        class="close"
                        data-dismiss="modal">
                    <span>&times;</span>
                </button>

            </div>


            <form action="{{ route('uploads.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="modal-body">

                    <div class="form-group">

                        <label>
                            Select Image
                        </label>

                        <input type="file"
                               name="image"
                               class="form-control"
                               accept="image/*"
                               required>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Close
                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-upload"></i>
                        Upload

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- ========================= -->
<!-- COPY IMAGE NAME SCRIPT -->
<!-- ========================= -->

<script>

function copyImageName(imageName)
{
    navigator.clipboard.writeText(imageName).then(function() {

        alert('Image name copied: ' + imageName);

    }).catch(function() {

        // Fallback
        var textArea = document.createElement("textarea");

        textArea.value = imageName;

        document.body.appendChild(textArea);

        textArea.select();

        document.execCommand('copy');

        document.body.removeChild(textArea);

        alert('Image name copied: ' + imageName);
    });
}

</script>

@endsection