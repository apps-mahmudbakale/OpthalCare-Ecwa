<div class="modal-header">
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <button type="button" class="btn btn-primary" onclick="printDiagnosis()">Print</button>
</div>
<div class="modal-body" id="diagnosisContent">
  <div class="text-center mb-4">
    <h3 class="mb-2">Diagnosis Details for {{ $diagnosis->patient->user->firstname }} {{ $diagnosis->patient->user->lastname }}</h3>
    <p><strong>ICD-10 Code:</strong> {{ $diagnosis->ICD->number ?? 'Not specified' }}</p>
  </div>
  <div class="col-md-12">
    <div class="list-group list-group-bordered">
      <div class="list-group-header justify-content-between">
        <div><i class="fas fa-calendar"></i> {{ $diagnosis->created_at->diffForHumans() }}</div>
        <div><i class="fas fa-user"></i> {{ $diagnosis->user->firstname }} {{ $diagnosis->user->lastname }}</div>
      </div>
      <div href="#" class="list-group-item">
        <div class="list-group-item-figure align-items-baseline">
          <a href="javascript:" class="tile tile-xs tile-circle bg-secondary">
            <span class="fas fa-file"></span>
          </a>
        </div>
        <div class="list-group-item-body">
          <h6>History</h6>
          {!! $diagnosis->comments !!}
          <h6>Examination</h6>
          <table class="table table-striped table-bordered">
            <thead class="table-dark">
            <tr>
              <th></th>
              <th>(RE)</th>
              <th>(LE)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td width="70%">UNCORRECTED</td>
              <td>{{ $diagnosis->uncorrected_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->uncorrected_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">PIN HOLE</td>
              <td>{{ $diagnosis->pinhole_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->pinhole_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">VA WITH GLASSES</td>
              <td>{{ $diagnosis->va_glass_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->va_glass_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">NEAR VISION</td>
              <td>{{ $diagnosis->near_vision_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->near_vision_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">LID</td>
              <td>{{ $diagnosis->lid_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->lid_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">GLOBE</td>
              <td>{{ $diagnosis->globe_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->globe_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">EOMM</td>
              <td>{{ $diagnosis->eomm_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->eomm_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">CONJUNCTIVA</td>
              <td>{{ $diagnosis->conjuctiva_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->conjuctiva_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">CORNEA</td>
              <td>{{ $diagnosis->cornea_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->cornea_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">ANTERIOR CHA</td>
              <td>{{ $diagnosis->anterior_cha_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->anterior_cha_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">IRIS</td>
              <td>{{ $diagnosis->iris_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->iris_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">PUPIL</td>
              <td>{{ $diagnosis->pupil_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->pupil_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">LENS</td>
              <td>{{ $diagnosis->lens_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->lens_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">IOP</td>
              <td>{{ $diagnosis->iop_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->iop_left ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td width="70%">VITREOUS</td>
              <td>{{ $diagnosis->vitreous_right ?? 'N/A' }}</td>
              <td>{{ $diagnosis->vitreous_left ?? 'N/A' }}</td>
            </tr>
            </tbody>
          </table>
          <h6>Disability</h6>
          <p>{{ $diagnosis->disability ?? 'No disability noted' }}</p>
          <h6>Assessment</h6>
          <p>{{ $diagnosis->assessment ?? 'No assessment provided' }}</p>
          <h6>Treatment Plan</h6>
          <p>{{ $diagnosis->treatment_plan ?? 'No treatment plan specified' }}</p>
          <h6>Additional Note</h6>
          <p>{{ $diagnosis->additional_note ?? 'No additional notes' }}</p>
        </div>
      </div>
      <div href="#" class="list-group-item">
        <div class="list-group-item-figure align-items-baseline">
          <a href="javascript:" class="tile tile-xs tile-circle bg-secondary">
            <span class="fa fa-paperclip"></span>
          </a>
        </div>
        <div class="list-group-item-body">
          <img src="{{ $diagnosis->sketch }}" alt="Diagnosis Sketch">
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function printDiagnosis() {
    // Get the content of the modal body
    const content = document.getElementById('diagnosisContent').innerHTML;

    // Open a new window
    const printWindow = window.open('', '_blank', 'width=800,height=600');

    // Write the content to the new window with basic styling
    printWindow.document.write(`
            <html>
                <head>
                    <title>Diagnosis Report</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #343a40;
                            color: white;
                        }
                        h6 {
                            margin-top: 15px;
                            margin-bottom: 5px;
                        }
                        .text-center {
                            text-align: center;
                        }
                        img {
                            max-width: 100%;
                            height: auto;
                        }
                    </style>
                </head>
                <body>
                    ${content}
                </body>
            </html>
        `);

    // Close the document stream and trigger print
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
  }
</script>
