{{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
<div class="text-center mb-4">
    <h3 class="mb-2">Diagnosis Details for {{ $diagnosis->patient->user->firstname }}
        {{ $diagnosis->patient->user->lastname }}</h3>
</div>
<div class="col-md-12">
    <div class="list-group list-group-bordered">

        <div class="list-group-header justify-content-between">
            <div><i class="fas fa-calendar"></i> {{ $diagnosis->created_at->diffForHumans() }}</div>
            <div><i class="fas fa-user"></i> {{ $diagnosis->user->firstname }} {{ $diagnosis->user->lastname }}</div>
            {{-- <span class="ml-3 badge-info badge">Result Ready</span> --}}
        </div>
        <div href="#" class="list-group-item">
            <div class="list-group-item-figure align-items-baseline ">
                <a href="javascript:" class="tile tile-xs tile-circle bg-secondary"><span
                        class="fas fa-file"></span></a>
            </div>
            <div class="list-group-item-body">
                {!! $diagnosis->comments !!}
                {{-- <p><strong><u>ABDOMINO-PELVIC USS</u></strong></p>
                <p>The urinary bladder is moderately distended with urine containing mobile internal echoes and shows
                    increased wall thickness. No calculus noted.</p>
                <p>The prostate is mildly enlarged measuring about 35 ml in volume. However, it shows uniform
                    parenchymal echo pattern. No focal intra-prostatic lesion is noted. </p>
                <p>The kidneys are normal in position, outline and sizes. They show normal parenchymal echogenicity with
                    good cortico-medullary differentiation bilaterally. An oval anechoic cystic lesion is noted in the
                    mid-cortical region suggestive of simple renal cyst. No calculus or back pressure effect noted.</p>
                <p>The liver is normal sized and shows normal parenchymal echo-pattern. No focal mass lesion is
                    demonstrated. The intra-hepatic biliary ducts and vascular channels are within normal limits.</p>
                <p>The spleen, pancreas, gall bladder and para-aortic regions are within normal limits.</p>
                <p>The demonstrated bowel loops are normal in caliber and outline with good peristatic activities. No
                    intra-abdominal mass lesion or collection noted.</p>
                <p><strong><u>CONCLUSIONS</u></strong>; Features suggest:</p>
                <ol>
                    <li>Cystitis as component of UTI.</li>
                    <li>Mild prostatomegaly presumably due to BPH.</li>
                    <li>Right sided simple renal cyst.</li>
                </ol>
                <p>DR. MUJITABA U</p>
                <p>21/11/2023</p> --}}
            </div>

        </div>
        <div href="#" class="list-group-item">
            <div class="list-group-item-figure align-items-baseline ">
                <a href="javascript:" class="tile tile-xs tile-circle bg-secondary"><span
                        class="fa fa-paperclip"></span></a>
            </div>
            {{-- <div class="list-group-item-body">No Attachment</div> --}}
            <img src="{{ $diagnosis->sketch }}" alt="">
        </div>

    </div>
</div>
