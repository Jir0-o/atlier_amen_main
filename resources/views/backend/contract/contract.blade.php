@extends('layouts.app')

@section('title', 'Contract')

@section('content')
<div class="content-wrapper">
    <h3 class="font-weight-bold">Contact</h3>
    <div class="row">
        {{-- Form --}}
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form id="contractForm" action="{{ route('adminContract.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Background Image --}}
                        <div class="mb-3">
                            <label class="form-label">Background Image</label>
                            <input type="file" name="background_image" id="background_image" class="form-control" accept="image/*">
                            @if(!empty($contract?->background_image))
                                <img src="{{ asset($contract?->background_image) }}" alt="Background" style="max-width: 100%; margin-top:10px;">
                            @endif
                            <span class="text-danger error-text background_image_error"></span>
                        </div>

                        {{-- User Image --}}
                        <div class="mb-3">
                            <label class="form-label">User Image</label>
                            <input type="file" name="user_image" id="user_image" class="form-control" accept="image/*">
                            @if(!empty($contract?->user_image))
                                <img src="{{ asset($contract->user_image) }}" alt="User" style="max-width: 120px; margin-top:10px; border-radius:50%;">
                            @endif
                            <span class="text-danger error-text user_image_error"></span>
                        </div>

                        {{-- Poem --}}
                        <div class="mb-3">
                            <label class="form-label">Poem</label>
                            <textarea id="poem" name="poem" class="form-control" rows="6">{!! $contract->poem ?? '' !!}</textarea>
                            <span class="text-danger error-text poem_error"></span>
                        </div>

                        <button type="submit" id="contractSaveBtn" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Preview --}}
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">Live Preview</div>
                <div class="card-body p-0">
                    <div id="previewBackgroundWrapper" 
                        style="height: 300px; 
                                background-image: linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)), 
                                                url('{{ $contract?->background_image ? asset($contract->background_image) : '/frontend-css/img/webimg/bg-contact.jpg' }}');
                                background-size: cover; 
                                background-position: center; 
                                display: flex; 
                                justify-content: center; 
                                align-items: center;
                                text-align: center;
                                color: #fff;">
                        <div>
                            <img id="previewUser" class="contact-profile mb-3" 
                                src="{{ $contract?->user_image ? asset($contract->user_image) : '/frontend-css/img/webimg/img-cat-1.png' }}" 
                                alt="Profile" 
                                style="width:120px; border-radius:50%; border:2px solid #fff;">

                            <blockquote class="cormorant" style="font-size: 20px; line-height: 1.5; margin: 0;">
                                {!! $contract?->poem ?? 'This was a blockquote,<br>so the user should add a poem in there.' !!}
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
let poemEditor;
ClassicEditor.create(document.querySelector('#poem'))
.then(editor => { poemEditor = editor; })
.catch(err => console.error(err));

$(function(){
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // Live Background Preview
    $('#background_image').on('change', function(e){
        const file = this.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = e => $('#previewBackgroundWrapper').css('background-image', `linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)), url(${e.target.result})`);
            reader.readAsDataURL(file);
        }
    });

    // Live User Image Preview
    $('#user_image').on('change', function(e){
        const file = this.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = e => $('#previewUser').attr('src', e.target.result);
            reader.readAsDataURL(file);
        }
    });

    // Poem Live Preview
    setInterval(() => {
        $('#previewPoem q').html(poemEditor.getData() || 'This was a blockquote,<br>so the user should add a poem in there.');
    }, 500);

    // Form submit AJAX
    $('#contractForm').on('submit', function(e){
        e.preventDefault();
        const form = this;
        const $btn = $('#contractSaveBtn').prop('disabled', true).text('Saving...');
        clearErrors();

        let formData = new FormData(form);
        formData.set('poem', poemEditor.getData());

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json'
        })
        .done(resp => {
            if(resp.status === 'success'){
                Swal.fire({ icon: 'success', title: 'Saved!', text: resp.message, timer:1200, showConfirmButton:false })
            }
        })
        .fail(xhr => {
            if(xhr.status === 422){
                const errors = xhr.responseJSON.errors;
                showErrors(errors);
                Swal.fire({ icon:'error', title:'Validation Error', text:Object.values(errors).flat()[0] });
            } else {
                Swal.fire({ icon:'error', title:'Error', text:'Something went wrong.' });
            }
        })
        .always(()=> $btn.prop('disabled', false).text('Save'));
    });

    function clearErrors(){ $('.error-text').text(''); }
    function showErrors(errors){
        $.each(errors, (field,msg)=> $('.'+field+'_error').text(msg[0]));
    }
});
</script>
@endpush
