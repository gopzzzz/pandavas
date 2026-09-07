@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1>Blogs</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Blogs
                        </li>

                    </ol>
                </div>

            </div>

        </div>
    </section>


    <!-- Main Content -->
    <section class="content">

        <div class="container-fluid">

            {{-- Success Message --}}
            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Validation Errors --}}
            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        Blogs List
                    </h3>


                    <!-- ADD BUTTON -->
                    <button type="button"
                            class="btn btn-primary float-right"
                            data-toggle="modal"
                            data-target="#addBlogModal">

                        <i class="fas fa-plus"></i>
                        Add Blog

                    </button>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th>ID</th>
                                    <th>Blog Name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($blogs as $blog)

                                    <tr>

                                        <td>
                                            {{ $blog->id }}
                                        </td>

                                        <td>
                                            {{ $blog->blogname }}
                                        </td>

                                        <td>
                                            {{ $blog->description }}
                                        </td>

                                        <td>

                                            {{ $blog->image }}

                                            <br>

                                            <img src="{{ asset('uploads/' . $blog->image) }}"
                                                 width="100"
                                                 height="70"
                                                 style="object-fit: cover; margin-top:5px;">

                                        </td>


                                        <td>

                                            <!-- EDIT BUTTON -->
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#editBlogModal{{ $blog->id }}">

                                                <i class="fas fa-edit"></i>
                                                Edit

                                            </button>


                                            <!-- DELETE BUTTON -->
                                            <form action="{{ route('blogs.destroy', $blog->id) }}"
                                                  method="POST"
                                                  style="display:inline-block;">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-primary btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this blog?')">

                                                    <i class="fas fa-trash"></i>
                                                    Delete

                                                </button>

                                            </form>

                                        </td>

                                    </tr>


                                    <!-- ========================= -->
                                    <!-- EDIT MODAL -->
                                    <!-- ========================= -->

                                    <div class="modal fade"
                                         id="editBlogModal{{ $blog->id }}">

                                        <div class="modal-dialog modal-lg">

                                            <div class="modal-content">


                                                <div class="modal-header">

                                                    <h4 class="modal-title">
                                                        Edit Blog
                                                    </h4>

                                                    <button type="button"
                                                            class="close"
                                                            data-dismiss="modal">

                                                        <span>&times;</span>

                                                    </button>

                                                </div>


                                                <form method="POST"
                                                      action="{{ route('blogs.update', $blog->id) }}">

                                                    @csrf
                                                    @method('PUT')


                                                    <div class="modal-body">


                                                        <!-- Blog Name -->

                                                        <div class="form-group">

                                                            <label>
                                                                Blog Name
                                                            </label>

                                                            <input type="text"
                                                                   name="blogname"
                                                                   class="form-control"
                                                                   value="{{ $blog->blogname }}"
                                                                   required>

                                                        </div>


                                                        <!-- Description -->

                                                        <div class="form-group">

                                                            <label>
                                                                Description
                                                            </label>

                                                            <textarea name="description"
                                                                      class="form-control"
                                                                      rows="5"
                                                                      required>{{ $blog->description }}</textarea>

                                                        </div>


                                                        <!-- Image Name -->

                                                        <div class="form-group">

                                                            <label>
                                                                Image Name
                                                            </label>

                                                            <input type="text"
                                                                   name="image"
                                                                   class="form-control"
                                                                   value="{{ $blog->image }}"
                                                                   placeholder="Enter image name"
                                                                   required>

                                                            <small class="text-muted">
                                                                Copy the image filename from the uploads folder and paste it here.
                                                            </small>

                                                        </div>


                                                        <!-- Current Image -->

                                                        <div class="form-group">

                                                            <label>
                                                                Current Image
                                                            </label>

                                                            <br>

                                                            <img src="{{ asset('uploads/' . $blog->image) }}"
                                                                 width="150"
                                                                 height="100"
                                                                 style="object-fit: cover;">

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

                                                            Update

                                                        </button>

                                                    </div>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <tr>

                                        <td colspan="5"
                                            class="text-center">

                                            No blogs found.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>


<!-- ================================================= -->
<!-- ADD BLOG MODAL -->
<!-- ================================================= -->

<div class="modal fade"
     id="addBlogModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">

                <h4 class="modal-title">
                    Add Blog
                </h4>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            <form method="POST"
                  action="{{ route('blogs.store') }}">

                @csrf


                <div class="modal-body">


                    <!-- Blog Name -->

                    <div class="form-group">

                        <label>
                            Blog Name
                        </label>

                        <input type="text"
                               name="blogname"
                               class="form-control"
                               placeholder="Enter blog name"
                               required>

                    </div>


                    <!-- Description -->

                    <div class="form-group">

                        <label>
                            Description
                        </label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Enter blog description"
                                  required></textarea>

                    </div>


                    <!-- Image Name -->

                    <div class="form-group">

                        <label>
                            Image Name
                        </label>

                        <input type="text"
                               name="image"
                               class="form-control"
                               placeholder="Enter image filename"
                               required>

                        <small class="text-muted">
                            Copy the image filename from the uploads folder and paste it here.
                        </small>

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

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection