<div class="text-center mb-4">
    <h3 class="mb-2">Diagnosis Details for {{ $diagnosis->patient->user->firstname }} {{ $diagnosis->patient->user->lastname }}</h3>
    <p><strong>ICD-10 Code:</strong> {{ $diagnosis->ICD->number ?? 'Not specified' }}</p>
  </div>
        <div class="list-group-item-figure align-items-baseline">
          <a href="javascript:" class="tile tile-xs tile-circle bg-secondary">
            <span class="fas fa-file"></span>
          </a>
        </div>
        <div class="list-group-item-body">
          <h6>History</h6>
          {!! $diagnosis->history !!}
          <h6>Examination</h6>
          <div class="gynae-details-view">

              @if ($diagnosis->lmp || $diagnosis->edd || $diagnosis->ga)
                  <h5 class="bg-label-primary p-2 mb-2 fw-bold text-uppercase small">Pregnancy Overview</h5>
                  <table class="table table-bordered mb-4">
                      <tbody>
                          @if ($diagnosis->lmp)
                          <tr>
                              <td width="50%" class="fw-bold">LMP (Last Menstrual Period)</td>
                              <td>{{ $diagnosis->lmp }}</td>
                          </tr>
                          @endif
                          @if ($diagnosis->edd)
                          <tr>
                              <td class="fw-bold">EDD (Estimated Due Date)</td>
                              <td>{{ $diagnosis->edd }}</td>
                          </tr>
                          @endif
                          @if ($diagnosis->ga)
                          <tr>
                              <td class="fw-bold">GA (Gestational Age)</td>
                              <td>{{ $diagnosis->ga }}</td>
                          </tr>
                          @endif
                      </tbody>
                  </table>
              @endif

              @if ($diagnosis->gravidity || $diagnosis->parity || $diagnosis->last_delivery_date)
                  <h5 class="bg-label-info p-2 mb-2 fw-bold text-uppercase small">Obstetric History</h5>
                  <table class="table table-bordered mb-4">
                      <tbody>
                          @if ($diagnosis->gravidity)
                          <tr>
                              <td width="50%" class="fw-bold">Gravidity</td>
                              <td>{{ $diagnosis->gravidity }}</td>
                          </tr>
                          @endif
                          @if ($diagnosis->parity)
                          <tr>
                              <td class="fw-bold">Parity</td>
                              <td>{{ $diagnosis->parity }}</td>
                          </tr>
                          @endif
                          @if ($diagnosis->last_delivery_date)
                          <tr>
                              <td class="fw-bold">Last Delivery Date</td>
                              <td>{{ $diagnosis->last_delivery_date }}</td>
                          </tr>
                          @endif
                      </tbody>
                  </table>
              @endif

              @if ($diagnosis->menstrual_history || $diagnosis->pelvic_examination)
                  <h5 class="bg-label-secondary p-2 mb-2 fw-bold text-uppercase small">Specialist Findings</h5>
                  <table class="table table-bordered mb-4">
                      <tbody>
                          @if ($diagnosis->menstrual_history)
                          <tr>
                              <td width="50%" class="fw-bold">Menstrual History</td>
                              <td>{{ $diagnosis->menstrual_history }}</td>
                          </tr>
                          @endif
                          @if ($diagnosis->pelvic_examination)
                          <tr>
                              <td class="fw-bold">Pelvic Examination</td>
                              <td>{{ $diagnosis->pelvic_examination }}</td>
                          </tr>
                          @endif
                      </tbody>
                  </table>
              @endif

          </div>

          <h6>General Examination</h6>
          <p>{{ $diagnosis->general_examination ?? 'No general examination provided' }}</p>
          <h6>Disability</h6>
          <p>{{ $diagnosis->disability ?? 'No disability noted' }}</p>
          <h6>Assessment</h6>
          <p>{{ $diagnosis->assessment ?? 'No assessment provided' }}</p>
          <h6>Treatment Plan</h6>
          <p>{{ $diagnosis->treatment ?? 'No treatment plan specified' }}</p>
          <h6>Additional Note</h6>
          <p>{{ $diagnosis->comments ?? 'No additional notes' }}</p>
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

