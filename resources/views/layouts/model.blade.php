<!-- Button trigger modal -->
<i style="font-size: 21px;
    color: #295E4E;
    cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bx bx-show"></i>
{{-- <button type="button" class="btn btn-primary" >
  </button> --}}

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="
        overflow-x: hidden;
        height: 420px;
        overflow-y: scroll;
        margin-left: -9px;">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
        </div>
        <div class="modal-body">
          @php
          $privacy=App\Models\Privacy::get(["privacy_ar","privacy_en"])[0];
          @endphp
        {!! App::isLocale('ar') ? $privacy->privacy_ar : $privacy->privacy_en !!}
        </div>

      </div>
    </div>
  </div>



