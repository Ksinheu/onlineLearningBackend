@extends('layouts.master')
@section('content')
    <div class="col-12 home-content">
        @if ($errors->any())
      <script>
          Swal.fire({
          title: 'Error!',
          text: 'Something went wrong.',
          icon: 'error',
          confirmButtonText: 'Retry'
      });
      </script>
  @endif

  @if(session('success'))
  <script>
      Swal.fire({
        toast: true,
        position: 'bottom-end',
          title: 'Success!',
          text: '{{ session('success') }}',
          icon: 'success',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
      });
  </script>
  @endif

  <div class="card p-5">
    <div class="mb-3">
        <a href="{{route('payment_method.create')}}" class="btn btn-success" data-bs-toggle="modal"
        data-bs-target="#uploadModal"><i class="fa-solid fa-plus"></i> បង្កើត</a>
    </div>
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="uploadModalLabel">បញ្ចូលព័ត៌មានថ្មីៗ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payment_method.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    
                        <div class="mb-3">
                            <label for="name_bank">ឈ្មោះធនាគា:</label>
                            <input type="text" name="name_bank" class="form-control" id="name_bank" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="number_bank">លេខកុងធនាគា:</label>
                            <input type="number" name="number_bank" class="form-control" id="number_bank" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="QR_code">QR Code:</label>
                            <input type="file" name="QR_code" class="form-control" id="QR_code" accept="image/*" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="phone_number">លេខទូរស័ព្ទ:</label>
                            <input type="text" name="phone_number" class="form-control" id="phone_number" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="status">Status:</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending">Pending</option>
                                <option value="active">Active</option>
                            </select>
                        </div>
                    
                       <div class="text-center"><button type="submit" class="btn btn-success">Create Payment Method</button></div> 
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    {{-- edit --}}
    
    <table class="table table-hover">
      <thead>
        <th>ID</th>
        <th>ឈ្មោះធនាគា</th>
        <th>លេខធនាគា</th>
        <th>QR-Code</th>
        <th>លេខទូរស័ព្ទ</th>
        <th>status</th>
        <th>option</th>
      </thead>
      <tbody>
        @foreach($payment_method as $payment_methods)
        <tr>
            <td>{{$payment_methods->id}}</td>
            <td>{{$payment_methods->name_bank}}</td>
            <td>{{$payment_methods->number_bank}}</td>
            <td><img src="{{ Storage::url($payment_methods->QR_code) }}" alt="" width="50px" height="50px"></td>
            <td>{{$payment_methods->phone_number}}</td>
            <td>{{$payment_methods->status}}</td>
            <td>
              <a href="{{route('payment_method.show',$payment_methods->id)}}" class="btn btn-warning"><i class="fa-solid fa-eye"></i></a>
              <a href="{{route('payment_method.edit',$payment_methods->id)}}" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
              <form action="{{ route('payment_method.destroy', $payment_methods->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-deleted" data-id="{{$payment_methods->id}}" data-name="{{$payment_methods->name_bank}}"><i class="fa-solid fa-trash"></i></button>
            </form>
             </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<script>
// SweetAlert delete confirmation
document.addEventListener('DOMContentLoaded', function () {
  const deleteButtons = document.querySelectorAll('.btn-deleted');
  deleteButtons.forEach(button => {
      button.addEventListener('click', function (e) {
          e.preventDefault();
          const sliderId = this.getAttribute('data-id');
          const sliderImage = this.getAttribute('data-name');
          
          Swal.fire({
              title: 'Are you sure?',
              text: `You are about to delete ${sliderImage}. This action cannot be undone.`,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
              if (result.isConfirmed) {
                  // Proceed with deletion
                  const deleteForm = document.createElement('form');
                  deleteForm.action = `{{ url('payment_method/${sliderId}') }}`;
                  deleteForm.method = 'POST';
                  deleteForm.innerHTML = `@csrf @method('DELETE')`;
                  document.body.appendChild(deleteForm);
                  deleteForm.submit();
              }
          });
      });
  });
})
</script>
    </div>
@endsection