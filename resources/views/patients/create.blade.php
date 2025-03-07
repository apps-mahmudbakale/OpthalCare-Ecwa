@extends('layouts/layoutMaster')

@section('title', 'Patients - Create Patient')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Patients/</span> Create Patient</h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create Patient</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.patients.store') }}" method="POST">
                        @csrf
                      <input type="text" name="temp_id" value="{{$data->id}}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="firstname">First Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="firstname" value="{{ old('firstname') ?? $data->first_name }}" id="firstname"
                                    class="form-control @error('firstname') is-invalid @enderror" placeholder="First Name">
                                @if ($errors->has('firstname'))
                                    <div class="text-danger">
                                        {{ $errors->first('firstname') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="middlename">Middle Name</label>
                                <input type="text" name="middlename" value="{{ old('middlename') ?? $data->middle_name }}" id="middlename"
                                    class="form-control" placeholder="Midddle Name">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="lastname">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="lastname" value="{{ old('lastname') ??  $data->last_name }}" id="lastname"
                                    class="form-control  @error('lastname') is-invalid @enderror" placeholder="Last Name">
                                @if ($errors->has('lastname'))
                                    <div class="text-danger">
                                        {{ $errors->first('lastname') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">

                                <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email') ?? $data->email }}" id="email"
                                    class="form-control  @error('email') is-invalid @enderror" placeholder="Email">
                                @if ($errors->has('email'))
                                    <div class="text-danger">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="phone">Phone <span class="text-danger">*</span></label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') ?? $data->phone }}"
                                    class="form-control @error('phone') is-invalid @enderror"" placeholder="Phone">
                                @if ($errors->has('phone'))
                                    <div class="text-danger">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="gender">Gender <span class="text-danger">*</span></label>
                                <select name="gender" id=""
                                    class="form-control @error('gender') is-invalid @enderror">
                                  <option value="{{$data->gender}}" selected>{{$data->gender}}</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <div class="text-danger">
                                        {{ $errors->first('gender') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="date_of_birth" class="form-label"> Date of Birth <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') ?? $data->date_of_birth }}"
                                    class="form-control @error('date_of_birth') is-invalid @enderror">
                                @if ($errors->has('date_of_birth'))
                                    <div class="text-danger">
                                        {{ $errors->first('date_of_birth') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="religion_id">Religion <span
                                        class="text-danger">*</span></label>
                                <select name="religion_id" id="religion_id"
                                    class="form-control @error('religion_id') is-invalid @enderror">
                                    <option value="" selected>Select Religion...</option>
                                    @foreach ($religions as $religion)
                                        <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('religion_id'))
                                    <div class="text-danger">
                                        {{ $errors->first('religion_id') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="marital_status">Marital Status <span
                                        class="text-danger">*</span></label>
                                <select name="marital_status" id="marital_status"
                                    class="form-control @error('marital_status') is-invalid @enderror">
                                    <option value="" selected>Select Marital Status...</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                </select>
                                @if ($errors->has('marital_status'))
                                    <div class="text-danger">
                                        {{ $errors->first('marital_status') }}
                                    </div>
                                @endif
                            </div>
                          <div class="col-md-4">
                            <label class="form-label" for="marital_status">Tribe <span
                                class="text-danger">*</span></label>
                            <select name="tribe" id="marital_status"
                                    class="form-control @error('marital_status') is-invalid @enderror">
                              <option value="" selected>Select Tribe...</option>
                              <option value="Hausa">Hausa</option>
                              <option value="Igbo">Igbo</option>
                              <option value="Yoruba">Yoruba</option>
                              <option value="Ijaw">Ijaw</option>
                              <option value="Kanuri">Kanuri</option>
                              <option value="Ibibio">Ibibio</option>
                              <option value="Fulani">Fulani</option>
                              <option value="Tiv">Tiv</option>
                              <option value="Others">Others</option>
                            </select>
                            @if ($errors->has('tribe'))
                            <div class="text-danger">
                              {{ $errors->first('tribe') }}
                            </div>
                            @endif
                          </div>
                          <div class="col-md-4">
                            <label for="residential_address" class="form-label">Disability<span
                                class="text-danger">*</span></label>
                            <input name="disability" id="residential_address"
                                   class="form-control @error('residential_address') is-invalid @enderror">
                          </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Occupation <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="occupation" value="{{ old('occupation') }}"
                                    class="form-control @error('occupation') is-invalid @enderror"
                                    placeholder="Occupation">
{{--                                @if ($errors->has('occupation'))--}}
{{--                                    <div class="text-danger">--}}
{{--                                        {{ $errors->first('occupation') }}--}}
{{--                                    </div>--}}
{{--                                @endif--}}
                            </div>
                            <div class="col-md-4">
                                <label for="state_r" class="form-label">State of Residence<span
                                        class="text-danger">*</span></label>
                                <select name="state_of_residence" id="state_r"
                                    class="form-control @error('state_of_residence') is-invalid @enderror">
                                    <option value="" selected>Select State...</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state }}">{{ $state }}</option>
                                    @endforeach
                                </select>
{{--                                @if ($errors->has('state_of_residence'))--}}
{{--                                    <div class="text-danger">--}}
{{--                                        {{ $errors->first('state_of_residence') }}--}}
{{--                                    </div>--}}
{{--                                @endif--}}
                            </div>
                            <div class="col-md-4">
                                <label for="lga_r" class="form-label">LGA<span class="text-danger">*</span></label>
                                <select name="lga_of_residence" id="lga_r"
                                    class="form-control @error('lga_of_residence') is-invalid @enderror"></select>
{{--                                @if ($errors->has('lga_of_residence'))--}}
{{--                                    <div class="text-danger">--}}
{{--                                        {{ $errors->first('lga_of_residence') }}--}}
{{--                                    </div>--}}
{{--                                @endif--}}
                            </div>
                            <div class="col-md-4">
                                <label for="residential_address" class="form-label">Residential Address <span
                                        class="text-danger">*</span></label>
                                <input name="residential_address" id="residential_address"
                                    class="form-control @error('residential_address') is-invalid @enderror">
{{--                                @if ($errors->has('residential_address'))--}}
{{--                                    <div class="text-danger">--}}
{{--                                        {{ $errors->first('residential_address') }}--}}
{{--                                    </div>--}}
{{--                                @endif--}}
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="nok_name">Next of Kin's Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="next_of_kin_name"
                                    class="form-control @error('next_of_kin_name') is-invalid @enderror">
                                @if ($errors->has('next_of_kin_name'))
                                    <div class="text-danger">
                                        {{ $errors->first('next_of_kin_name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="nok_relation">Next of Kin's Relationship <span
                                        class="text-danger">*</span></label>
                                <select name="next_of_kin_relation" id="nok_relation"
                                    class="form-control @error('next_of_kin_relation') is-invalid @enderror">
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Husband">Husband</option>
                                </select>
                                @if ($errors->has('next_of_kin_relation'))
                                    <div class="text-danger">
                                        {{ $errors->first('next_of_kin_relation') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="nok_phone" class="form-label">Next of Kin's Phone<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="next_of_kin_phone"
                                    class="form-control @error('next_of_kin_phone') is-invalid @enderror">
                                @if ($errors->has('next_of_kin_phone'))
                                    <div class="text-danger">
                                        {{ $errors->first('next_of_kin_phone') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <label for="nok_address" class="form-label">Next of Kin's Address <span
                                        class="text-danger">*</span></label>
                                <input name="next_of_kin_address" id=""
                                    class="form-control @error('next_of_kin_address') is-invalid @enderror">
                                @if ($errors->has('next_of_kin_address'))
                                    <div class="text-danger">
                                        {{ $errors->first('next_of_kin_address') }}
                                    </div>
                                @endif
                            </div>
                            @if (app(App\Settings\SystemSettings::class)->insurance_providers)
                                <div class="col-md-4">

                                    <label class="form-label" for="hmo_plan">HMO Plan </label>
                                    <select name="hmo_id" id="" class="form-control">
                                        <option value="" selected>Select HMO Plan...</option>
                                        @foreach ($hmos as $hmo)
                                            <option value="{{ $hmo->id }}">{{ $hmo->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">

                                    <label class="form-label" for="hmo_depend">Dependent? </label>
                                    <select name="dependent" id="hmo_depend" class="form-control">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-4">

                                    <label class="form-label" for="principal_id">Principal ID</label>
                                    <input type="text" name="principal_id" id="principal_id" class="form-control"
                                        placeholder="HMO Principal ID">
                                </div>
                            @endif
                        </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Sumbit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        const state_r = document.getElementById('state_r');
        const lga_r = document.getElementById('lga_r');

        state_r.addEventListener('change', () => {
            var state_value = state_r.value;

            fetch('/getLGA/' + state_value)
                .then((res) => res.json())
                .then(data => {
                    console.log(data);
                    lga_r.length = 0;

                    let defaultOption = document.createElement('option');
                    defaultOption.text = 'Choose LGA';

                    lga_r.add(defaultOption);
                    lga_r.selectedIndex = 0;

                    document.getElementById("lga_r").innerHTML = "";
                    let option;
                    for (let i = 0; i < data.length; i++) {
                        option = document.createElement('option');
                        option.text = data[i];
                        option.value = data[i];
                        lga_r.add(option);
                    }
                })
                .catch(error => {
                    console.log(error);
                });

        });


        const state_o = document.getElementById('state_o');
        const lga_o = document.getElementById('lga_o');

        state_o.addEventListener('change', () => {
            var state_value = state_o.value;

            fetch('/getLGA/' + state_value)
                .then((res) => res.json())
                .then(data => {
                    console.log(data);
                    lga_o.length = 0;

                    let defaultOption = document.createElement('option');
                    defaultOption.text = 'Choose LGA';

                    lga_o.add(defaultOption);
                    lga_o.selectedIndex = 0;

                    document.getElementById("lga_o").innerHTML = "";
                    let option;
                    for (let i = 0; i < data.length; i++) {
                        option = document.createElement('option');
                        option.text = data[i];
                        option.value = data[i];
                        lga_o.add(option);
                    }
                })
                .catch(error => {
                    console.log(error);
                });

        });
    </script>

@endsection
