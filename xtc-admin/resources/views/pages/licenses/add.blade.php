@extends('layout.master')

@push('plugin-styles')
  <!-- Plugin css import here -->
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Inputs</h6>
            <div class="mb-3">
              <label for="exampleInputNumber1" class="form-label">Number Input</label>
              <input id="key-count" type="number" class="form-control" id="exampleInputNumber1" value="1" min="1" max="200" required>
            </div>
            <form method="POST" action="/api/license/store">
                <div class="mb-3">
                    <label for="days" class="form-label">Subscription time (days)</label>
                    <input id="days" name="days" type="number" class="form-control" id="days" value="1" min="1" max="999" required>
                </div>
                <div class="mb-3">
                <label for="exampleFormControlSelect1" class="form-label">Key separator</label>
                <select id="separator" name="separator" class="form-select" id="exampleFormControlSelect1">
                    <option value="," selected="">,</option>
                    <option value="|">|</option>
                    <option value=".">.</option>
                    <option value=";">;</option>
                    <option value=":">:</option>
                    <option value="x">New line</option>
                </select>
                </div>

                <div class="mb-3">
                <label for="exampleFormControlSelect1" class="form-label">Product</label>
                <select id="pid" name="pid" class="form-select" id="exampleFormControlSelect1" required>
                    <option selected="" disabled="">Select a product</option>
                    @foreach ($products as $product)
                        <option value="{{$product->pid}}">{{$product->product_name}}</option>
                    @endforeach
                </select>
                </div>

                <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Keys</label>
                <textarea class="form-control" name="keys" id="keys" rows="5" required></textarea>
                </div>
                <button class="btn btn-success" type="button" onclick="generateLicenseKeys()">Generate</button>
                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('plugin-scripts')
  <!-- Plugin js import here -->
@endpush

@push('custom-scripts')
<script>
    function makeid(length) {
        let result = '';
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        const charactersLength = characters.length;
        let counter = 0;
        while (counter < length) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        counter += 1;
        }
        return result;
    }

    function generateLicenseKeys() {
        $('#keys').val("");
        var licenseKeys = makeid(5) + '-' + makeid(5) + '-' + makeid(5) + '-' + makeid(5);
        if ($("#separator").val() == "x"){
            for (let i = 0; i < $("#key-count").val() - 1; i++) {
                licenseKeys = licenseKeys + "\n" + makeid(5) + '-' + makeid(5) + '-' + makeid(5) + '-' + makeid(5);
            }
        }
        else
        {
            for (let i = 0; i < $("#key-count").val() - 1; i++) {
                licenseKeys = licenseKeys + $('#separator').val() + makeid(5) + '-' + makeid(5) + '-' + makeid(5) + '-' + makeid(5) ;
            }
        }
        $('#keys').val(licenseKeys);

    }
</script>
@endpush
