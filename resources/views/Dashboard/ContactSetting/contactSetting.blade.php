@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    Contact Setting
@endsection
@section('content')
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 16px;
        }

        .dropify-wrapper .dropify-message .dropify-error {
            font-size: 16px;
        }

        .dropify-wrapper .dropify-clear,
        .dropify-wrapper .dropify-preview .dropify-render .dropify-infos .dropify-infos-inner .dropify-filename,
        .dropify-wrapper .dropify-preview .dropify-render .dropify-infos .dropify-infos-inner .dropify-infos-message {
            font-size: 16px;
        }

        textarea {
            height: 150px;
        }

        img {
            max-width: 200px;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Contact Setting</h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('dashboard') }}">Back</a>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('updateContactSetting') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <!-- Phone Field -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="phoneInput" class="form-label">Phone</label>
                                                <input type="text" class="form-control" name="phone"
                                                    value="{{ $contact->phone ?? '' }}"
                                                    placeholder="Phone No: +966557052333" id="phoneInput" pattern="\d{8}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="thirdSectionTitleAr" class="form-label">Facebook</label>
                                                <input style="height: 112px" type="text" class="form-control" name="facebook"
                                                    value="{{ $contact->facebook ?? '' }}" placeholder="Facebook Link"
                                                    id="thirdSectionTitleAr" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Icon</label>
                                                <input type="file" class="form-control dropify" data-height="100"
                                                    id="imageInput" accept="image/*" name="face_image">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                @if (isset($contact->face_image))
                                                    <img style="height: 100px;border-radius: 50%" class="mt-4" src="{{ asset('images/' . $contact->face_image) }}">
                                                @endif
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="thirdSectionTitleAr" class="form-label">Whatsapp</label>
                                                <input style="height: 112px" type="text" class="form-control" name="whatsapp"
                                                    value="{{ $contact->whatsapp ?? '' }}" placeholder="Whatsapp Link"
                                                    id="thirdSectionTitleAr" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Icon</label>
                                                <input type="file" class="form-control dropify" data-height="100"
                                                    id="imageInput" accept="image/*" name="whats_image">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                @if (isset($contact->whats_image))
                                                    <img style="height: 100px;border-radius: 50%" class="mt-4" src="{{ asset('images/' . $contact->whats_image) }}">
                                                @endif
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="thirdSectionTitleAr" class="form-label">Twitter</label>
                                                <input style="height: 112px" type="text" class="form-control" name="twitter"
                                                    value="{{ $contact->twitter ?? '' }}" placeholder="Twitter Link"
                                                    id="thirdSectionTitleAr" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Icon</label>
                                                <input type="file" class="form-control dropify" data-height="100"
                                                    id="imageInput" accept="image/*" name="twitter_image">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                @if (isset($contact->twitter_image))
                                                    <img style="height: 100px;border-radius: 50%" class="mt-4" src="{{ asset('images/' . $contact->twitter_image) }}">
                                                @endif
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="thirdSectionTitleAr" class="form-label">Instagram</label>
                                                <input style="height: 112px" type="text" class="form-control" name="instagram"
                                                    value="{{ $contact->instagram ?? '' }}" placeholder="Instagram Link"
                                                    id="thirdSectionTitleAr" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Icon</label>
                                                <input type="file" class="form-control dropify" data-height="100"
                                                    id="imageInput" accept="image/*" name="instagram_image">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                @if (isset($contact->instagram_image))
                                                    <img style="height: 100px;border-radius: 50%" class="mt-4" src="{{ asset('images/' . $contact->instagram_image) }}">
                                                @endif
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="thirdSectionTitleAr" class="form-label">Snapchat</label>
                                                <input style="height: 112px" type="text" class="form-control" name="snapchat"
                                                    value="{{ $contact->snapchat ?? '' }}" placeholder="Snapchat Link"
                                                    id="thirdSectionTitleAr" required>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Icon</label>
                                                <input type="file" class="form-control dropify" data-height="100"
                                                    id="imageInput" accept="image/*" name="snapchat_image">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                @if (isset($contact->snapchat_image))
                                                    <img style="height: 100px;border-radius: 50%" class="mt-4" src="{{ asset('images/' . $contact->snapchat_image) }}">
                                                @endif
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                </form>

                            </div>
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>


    <script>
        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });
    </script>
@endpush
