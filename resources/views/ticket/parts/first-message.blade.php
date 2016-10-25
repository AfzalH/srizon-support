<div class="box box-info focus-element">
    <div class="box-header with-border">
        <h3 class="box-title title-collapse" data-widget="collapse">You've just created a new
            ticket!</h3>

        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <h5><i class="fa fa-check fa-green"></i> You are the owner of this Ticket</h5>
        <h5><i class="fa fa-check fa-green"></i> You can add post/data to this Ticket</h5>
        <h5><i class="fa fa-check fa-green"></i> You will be <strong>identified
                automatically</strong> by browser cookie for 7 days</h5>
        <h5><i class="fa fa-check fa-green"></i> You can identify yourself again using the
            <strong>secret key</strong> below</h5>


        <div class="input-group">
            <div class="input-group-btn">
                <button type="button" class="btn btn-success"><i class="fa fa-key"></i> Secret
                    Key
                </button>
            </div>
            <input size="15" type="text" class="form-control" value="{{$ticket->secret}}">
        </div>
        <br>

        <p><i class="fa fa-warning"></i> <strong>Copy and Save the Key.</strong> You may need it
            to identify yourself as the Ticket Owner</p>
    </div>
</div>
<div class="defocus"></div>