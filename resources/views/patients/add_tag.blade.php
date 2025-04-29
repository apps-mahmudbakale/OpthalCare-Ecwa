<h1 class="text-center">Add Patient Tag</h1>
<form action="{{route('app.patients.tag.post')}}" method="post">
  @csrf
  <input type="hidden" name="patient_id" value="{{$patient->id}}">
  <label for="">Select Tag</label>
  <select name="tag_id" id="" class="form-control">
    @foreach(\App\Models\Tag::all() as $tag)
    <option value="{{$tag->id}}">{{ $tag->name }}</option>
    @endforeach
  </select>
  <p></p>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
  </div>
</form>
