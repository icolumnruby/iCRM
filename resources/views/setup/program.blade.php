@extends('layouts/admin')

@section('content')
<div class="row center-align">
  <p class="headline">Choose Program</p>
  <h4>Select the Loyalty Program you wish to run</h4>
  <p class="caption">You can select more than one.</p>
  <form method="POST" action="/setup/program" name="formSelectProgram" id="formSelectProgram" class="col s12" data-parsley-validate>
    <div class="row flex-row select-cards">
      <div class="col s12 m4">
        <input type="checkbox" name="selectProgram" value="loyalty" id="checkLoyalty" />
        <label class="card" for="checkLoyalty">

          <div class="card-content">
            <i class="medium material-icons">loyalty</i>
            <p class="card-title center-align">Loyalty Points System</p>
            <p>Run your own loyalty system based on points. The more your shoppers spend the more points they collect. You can reward them on their points collection.</p>
          </div>
        </label>
      </div>
      <div class="col s12 m4">
        <input type="checkbox" name="selectProgram" value="gwp" id="checkGWP" />
        <label class="card" for="checkGWP">
          <div class="card-content">
            <i class="medium material-icons">card_giftcard</i>
            <p class="card-title center-align">Gift With Purchase</p>
            <p>I am a very simple card. I am good at containing small bits of information.
            I am convenient because I require little markup to use effectively.</p>
          </div>
        </label>
      </div>
      <div class="col s12 m4">
        <input type="checkbox" name="selectProgram" value="luckyDraw" id="checkDraw" />
        <label class="card" for="checkDraw">
          <div class="card-content">
            <i class="medium material-icons">mood</i>
            <p class="card-title center-align">Lucky Draw</p>
            <p>I am a very simple card. I am good at containing small bits of information.
            I am convenient because I require little markup to use effectively.</p>
          </div>
        </label>
      </div>
    </div>
  <a href="{{url('setup')}}" class="btn brand-ghost">Back</a>
  <button type="submit" class="btn brand-gradient" name="selectProgram">Next</button>
  </form>
</div>

@stop
