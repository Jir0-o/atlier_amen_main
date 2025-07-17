@extends('layouts.guest')

@section('title', 'Contact Us')

@section('content')

<!-- main content start -->
<main>
    <div class="content">
        <!-- contact content start -->
        <section class="contact-form">
            <div class="row p-0 m-0">
                <div class="col-sm-6 col-md-5 p-0 bg-l" 
                    style="background-image: linear-gradient(rgb(0 0 0 / 50%), rgb(0 0 0 / 50%)), url('{{ $contact->background_image ? asset($contact->background_image) : '/frontend-css/img/webimg/bg-contact.jpg' }}');">
                    <div class="d-flex justify-content-center align-items-center flex-column h-100">
                        <center data-aos="zoom-out" data-aos-duration="2000">
                            <img class="contact-profile mb-3" 
                                src="{{ $contact->user_image ? asset($contact->user_image) : '/frontend-css/img/webimg/img-cat-1.png' }}" 
                                alt="Profile of artist" style="width:120px; border-radius:50%; border:2px solid #fff;">
                            
                            <blockquote class="cormorant" style="color:#fff; font-size:20px; line-height:1.5;">
                                {!! $contact->poem ?? 'This was a blockquote,<br>so the user should add a poem in there.' !!}
                            </blockquote>
                        </center>
                    </div>
                </div>
                <div class="col-sm-6 col-md-7 p-0 bg-r">
                    <div class="form-box p-4 overflow-hidden">
                        <form id="contactForm" action="{{ route('contact-message.store') }}" method="POST" class="row" data-aos="fade-down-left" data-aos-delay="1000" data-aos-duration="2000">
                            @csrf
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="contact_name">Full Name: <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" type="text" id="contact_name" placeholder="Write your full name..." required>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="contact_email">Email: <span class="text-danger">*</span></label>
                                <input class="form-control" name="email" type="email" id="contact_email" placeholder="Write your email..." required>
                                <span class="text-danger error-text email_error"></span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="contact_number">Contact:</label>
                                <input class="form-control" name="number" type="text" id="contact_number" placeholder="Phone / WhatsApp...">
                                <span class="text-danger error-text number_error"></span>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label" for="contact_message">Message:</label>
                                <textarea class="form-control" name="message" id="contact_message" rows="3" placeholder="Write your message..."></textarea>
                                <span class="text-danger error-text message_error"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column">
                                    <button type="submit" class="btn btn-outline-light" id="contactSubmitBtn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact content end -->
    </div>
</main>
<!-- main content end -->
@push('scripts')
<script>
$(function(){

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#contactForm').on('submit', function(e){
        e.preventDefault();

        const $form = $(this);
        const $btn  = $('#contactSubmitBtn');

        clearContactErrors();
        $btn.prop('disabled', true).text('Sending...');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(), 
            dataType: 'json'
        })
        .done(function(resp){
            if (resp.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Sent!',
                    text: resp.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                // Reset form
                $form[0].reset();
            } else {
               
                Swal.fire({
                    icon: 'warning',
                    title: 'Unexpected Response',
                    text: resp.message || 'Please try again.'
                });
            }
        })
        .fail(function(xhr){
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors || {};
                showContactErrors(errors);

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
                    text: 'Something went wrong. Please try again.'
                });
            }
        })
        .always(function(){
            $btn.prop('disabled', false).text('Submit');
        });
    });

    function clearContactErrors(){
        $('#contactForm .error-text').text('');
    }

    function showContactErrors(errors){
        $.each(errors, function(field, messages){
            $('#contactForm .' + field + '_error').text(messages[0]);
        });
    }

});
</script>
@endpush
@endsection