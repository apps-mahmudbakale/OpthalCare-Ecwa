<style>
  .dropdown-item3 {
    display: block;
    width: 100%;
    padding: 0.5rem 1rem;
    clear: both;
    font-weight: 400;
    color: #191927;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    line-height: 1.375;
    width: calc(100% - 1rem);
    margin: 0.25rem 0.5rem;
    border-radius: 0.375rem;
  }

  h1 {
    text-align: center;
    color: #fff;
    margin: 40px;
  }

  .accordion {
    margin-bottom: 10px;
  }

  .accordion-btn {
    position: relative;
    background: linear-gradient(72.47deg, #7367f0 22.16%, rgba(115, 103, 240, 0.7) 76.47%);
    border: none;
    padding: 15px 20px;
    text-align: left;
    cursor: pointer;
    font-weight: bold;
    box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.25);
    list-style-image: none;
    border-radius: 7px;
    color: white;
  }

  .accordion-btn::-webkit-details-marker {
    background: none;
    color: transparent;
  }

  .accordion-btn::after {
    content: "›";
    position: absolute;
    top: 50%;
    right: 10px;
    font-size: 35px;
    font-family: monospace;
    width: 35px;
    height: 35px;
    text-align: center;
    border-radius: 50%;
    border: 2px solid #ffffff;
    transform: translate(0%, -50%) rotate(0deg);
    box-sizing: border-box;
    display: flex;
    align-items: center;
    padding-bottom: 4px;
    padding-left: 2px;
    justify-content: center;
    font-weight: normal;
    transition: all .3s ease;
    color: white;
  }

  .accordion-content {
    background-color: #ffffff;
    box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.25);
    padding: 15px;
  }

  .accordion[open] .accordion-btn::after {
    transform: translate(0%, -50%) rotate(90deg);
  }

  .accordion[open] summary ~ * {
    overflow: hidden;
    animation: heightUp 1s ease-in-out;
  }

  @keyframes heightUp {
    0% {
      max-height: 0;
    }

    100% {
      max-height: 2000px;
    }
  }

  .accordion-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .accordion-header h3 {
    margin: 0;
    flex-grow: 1;
  }
  .invoice-box {
    max-width: 800px;
    margin: auto;
    padding: 30px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .15);
    font-size: 16px;
    line-height: 24px;
    font-family: -apple-system, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    color: #555;
  }

  .invoice-box table {
    width: 100%;
    line-height: inherit;
    text-align: left;
  }

  .invoice-box table td {
    vertical-align: top;
  }

  .invoice-box table tr td:last-child {
    text-align: right;
  }

  .invoice-box table tr.top table td {}

  .invoice-box table tr.top table td.title {
    font-size: 45px;
    line-height: 45px;
    color: #333;
  }

  .invoice-box table tr.information table td {}

  .invoice-box table tr.heading td {
    background: #eee;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
  }

  .invoice-box table tr.details td {
    padding-bottom: 20px;
  }

  .invoice-box table tr.item td {
    border-bottom: 1px solid #eee;
  }

  .invoice-box table tr.item.last td {
    border-bottom: none;
  }

  .invoice-box table tr.total td:last-child {
    border-top: 2px solid #eee;
    font-weight: bold;
  }

  @media only screen and (max-width: 600px) {
    .invoice-box table tr.top table td {
      width: 100%;
      display: block;
      text-align: center;
    }

    .invoice-box table tr.information table td {
      width: 100%;
      display: block;
      text-align: center;
    }
  }

  /** RTL **/
  .rtl {
    direction: rtl;
    font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
  }

  .rtl table {
    text-align: right;
  }

  .rtl table tr td:last-child {
    text-align: left;
  }

  .footnote {
    font-size: smaller;
    text-align: center;
    margin-top: 100px;
  }

  .text-muted {
    color: gray;
  }

  .spacer {
    margin-top: 50px
  }
</style>
<div>
  @foreach ($requests as $request)
  <details class="accordion">
    <summary class="accordion-btn">{{ $request->created_at->format('d M Y h:i A') }}</summary>
    <div class="accordion-content p-2">
      <div class="accordion-header mb-3">
        <h3 class="mb-2">Lab Investigation for {{ \App\Models\Patient::find($request->patient_id)->user->firstname }} {{ \App\Models\Patient::find($request->patient_id)->user->lastname }}</h3>
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-icon btn-light waves-effect waves-light"
                    data-bs-toggle="dropdown" data-boundary="viewport" aria-expanded="false"
                    aria-haspopup="true">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu" style="">
              <li><button class="dropdown-item" data-request-url="{{route('app.lab.edit', $request->id)}}" data-toggle="modal"
                          data-target="#global-modal"
                >Edit </button></li>
              <li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <l><button class="dropdown-item3 text-bg-danger" id="delete" data-delete-url="{{route('app.lab.destroy', $request->id)}}">Delete</button></l>
            </ul>
          </div>
      </div>
      <p class="text-muted">Recorded By  {{ $request->user->firstname ." ". $request->user->lastname }} on {{ $request->created_at->format('d M Y h:i A') }}</p>
      <div class="invoice-box">
      {!! $request->findings->result ?? '' !!}
      <div class="spacer"></div>
        @if($request->findings->image)
        <img src="{{$request->findings->image}}" alt="">
        @endif
      </div>
    </div>
  </details>
  @endforeach
</div>

<script>
  window.addEventListener('DOMContentLoaded', function () {
    // Select all relevant inputs, textareas, selects, and checkboxes
    const inputs = document.querySelectorAll('.row input, .row textarea, .row select, input[name="notify_patient"], input[name="referral_hospital"]');

    inputs.forEach(el => {
      // Apply 'readonly' where applicable
      if (
        el.tagName === 'INPUT' &&
        ['text', 'datetime-local', 'time'].includes(el.type)
      ) {
        el.readOnly = true;
      } else if (el.tagName === 'TEXTAREA') {
        el.readOnly = true;
      } else {
        // For select, checkbox, others — use 'disabled'
        el.disabled = true;
      }
    });
  });
</script>

