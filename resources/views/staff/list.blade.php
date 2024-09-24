@extends('Backend.Layout.app')

@section('breadcrumb', 'Medicine List')
@section('title', 'Staff')

@section('main-content')   

  <div class="container-fluid py-4">
      
    <!-- table List -->
    <div class="card card-info mt-4 mb-4 p-4">
      <div class="card-body">
        <div class="card-header mb-2 p-0"> 
          <h3 class="card-title">Drug Buyer </h3>
        </div>

        <div class="table-responsive">
          <table id="datatablesSimpleOne" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Drug Name</th>
                <th>Contact #</th>
                <th>Purchase by</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr data-info='{"drug": "Ecstasy", "contact": "+123456789", "buyer": "HealthPlus", "status": "Pending"}'>
                <td>Ecstasy</td>
                <td>+123456789</td>
                <td>HealthPlus</td>
                <td><span class="status-circle pending"></span>Pending</td>
              </tr>
              <tr data-info='{"drug": "Heroin", "contact": "+987654321", "buyer": "Medicare", "status": "Intransit"}'>
                <td>Heroin</td>
                <td>+987654321</td>
                <td>Medicare</td>
                <td><span class="status-circle intransit"></span>Intransit</td>
              </tr>
              <tr data-info='{"drug": "Marijuana", "contact": "+1122334455", "buyer": "PharmaCorp", "status": "Delivered"}'>
                <td>Marijuana</td>
                <td>+1122334455</td>
                <td>PharmaCorp</td>
                <td><span class="status-circle delivered"></span>Delivered</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- end -->

    <!-- Modal for displaying details -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="infoModalLabel">Drug Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p><strong>Drug Name:</strong> <span id="modalDrugName"></span></p>
            <p><strong>Contact #:</strong> <span id="modalContact"></span></p>
            <p><strong>Purchase by:</strong> <span id="modalBuyer"></span></p>
            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end Modal -->
    
    <!-- footer -->
    <footer class="footer pt-3">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              © <script>
                document.write(new Date().getFullYear())
              </script>,
              made with <i class="fa fa-heart"></i> by
              <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
              for a better web.
            </div>
          </div>

          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="https://creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- end footer -->

  </div>

@endsection

@push('custom-scripts')
<!-- Add Bootstrap JS for modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // JavaScript to handle row click and show modal
  document.querySelectorAll('#datatablesSimpleOne tbody tr').forEach(row => {
    row.addEventListener('click', function() {
      // Get the data from the row
      const data = JSON.parse(this.getAttribute('data-info'));

      // Populate the modal with the row's data
      document.getElementById('modalDrugName').textContent = data.drug;
      document.getElementById('modalContact').textContent = data.contact;
      document.getElementById('modalBuyer').textContent = data.buyer;
      document.getElementById('modalStatus').textContent = data.status;

      // Show the modal
      var modal = new bootstrap.Modal(document.getElementById('infoModal'));
      modal.show();
    });
  });
</script>
@endpush
