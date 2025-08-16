@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="content-wrapper">
    <h3 class="font-weight-bold">About</h3>
    {{-- Form + Preview --}}
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form id="aboutForm" action="{{ route('adminAbout.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Title --}}
                            <div class="col-md-6 mb-3">
                                <label for="about_title" class="form-label">Title</label>
                                <input type="text" name="title" id="about_title" class="form-control"
                                    value="{{ $about->title ?? '' }}">
                                <span class="text-danger error-text title_error"></span>
                            </div>

                            {{-- Image --}}
                            <div class="col-md-6 mb-3">
                                <label for="about_image" class="form-label">Image</label>
                                <input type="file" name="image" id="about_image" class="form-control" accept="image/*">
                                <span class="text-danger error-text image_error"></span>
                            </div>

                            {{-- Body --}}
                            <div class="col-md-12 mb-3">
                                <label for="body" class="form-label">About Body</label>
                                <textarea id="body" name="body" class="form-control" rows="6">{!! $about->body ?? '' !!}</textarea>
                                <span class="text-danger error-text body_error"></span>
                            </div>

                            {{-- Live Image Preview --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label d-block">Preview Image</label>
                                <img id="about_image_preview"
                                    src="{{ $about->image_url ?? 'https://via.placeholder.com/300x200?text=No+Image' }}"
                                    alt="About Image Preview"
                                    style="max-width:300px; width: 100%; height:auto; border:1px solid #ddd; padding:4px;">
                            </div>

                            <div class="col-md-12">
                                <button type="submit" id="aboutSaveBtn" class="btn btn-primary w-100">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Live Body Preview Card --}}
        {{-- <div class="col-md-4 grid-margin stretch-card"> 
            <div class="card">
                <div class="card-header">Live Preview</div>
                <div class="card-body">
                    <h4 id="aboutPreviewTitle">{{ $about->title ?? 'About Title' }}</h4>
                    <div id="aboutPreviewBody" class="small text-muted" style="white-space:pre-line;">
                        {!! $about->body ?? 'Your about description will appear here...' !!}
                    </div>
                    @if(!empty($about?->image_url))
                        <img id="aboutPreviewImage"
                             src="{{ $about->image_url }}"
                             alt="About Preview"
                             class="img-fluid mt-3">
                    @else
                        <img id="aboutPreviewImage"
                             src="https://via.placeholder.com/300x200?text=Preview"
                             alt="About Preview"
                             class="img-fluid mt-3">
                    @endif
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection

@push('scripts')
<script>

let aboutEditor;

ClassicEditor
    .create(document.querySelector('#body'))
    .then(editor => {
        aboutEditor = editor;
    })
    .catch(error => {
        console.error(error);
    });

$(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Live preview: title/body
    $('#about_title').on('input', function(){
        $('#aboutPreviewTitle').text($(this).val() || 'About Title');
    });

    $('#about_body').on('input', function(){
        $('#aboutPreviewBody').text($(this).val() || 'Your about description will appear here...');
    });

    // Live image preview on file select
    $('#about_image').on('change', function(e){
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(evt){
            $('#about_image_preview').attr('src', evt.target.result);
            $('#aboutPreviewImage').attr('src', evt.target.result);
        };
        reader.readAsDataURL(file);
    });

    // Submit form via AJAX (FormData for file upload)
    $('#aboutForm').on('submit', function(e){
        e.preventDefault();

        const form = this;
        const $btn = $('#aboutSaveBtn');
        $btn.prop('disabled', true).text('Saving...');

        clearErrors();

        let formData = new FormData(form); // includes file
        formData.set('body', aboutEditor.getData());

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            processData: false, // required for FormData
            contentType: false, // required for FormData
            dataType: 'json'
        })
        .done(function(resp){
            if (resp.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    text: resp.message,
                    timer: 1200,
                    showConfirmButton: false
                }).then(() => {
                    // You asked: reload page after save
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Unexpected Response',
                    text: 'Please try again.'
                });
            }
        })
        .fail(function(xhr){
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors || {};
                showErrors(errors);

                // Show first error in SweetAlert
                const firstError = Object.values(errors).flat()[0] || 'Validation error.';
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: firstError
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong.'
                });
            }
        })
        .always(function(){
            $btn.prop('disabled', false).text('Save');
        });
    });

    function clearErrors() {
        $('.error-text').text('');
    }

    function showErrors(errors) {
        $.each(errors, function(field, messages){
            $('.' + field + '_error').text(messages[0]);
        });
    }
});
</script>
@endpush
