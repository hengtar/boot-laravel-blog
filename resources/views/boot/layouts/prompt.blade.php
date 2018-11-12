<div id="ShowInfo">
    @if(Session::get('success'))
        <div class="alert alert-success alert-dismissable col-sm-2" style="float: right">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>成功! </strong> &nbsp;&nbsp;{{ Session::get('success') }}
        </div>
    @endif

    @if(Session::get('error'))
        <div class="alert alert-danger alert-dismissable col-sm-2" style="float: right">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>失败! </strong> &nbsp;&nbsp;{{ Session::get('error') }}
        </div>
    @endif

    <div class="alert alert-danger alert-dismissable col-sm-2" style="float: right; display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>失败! </strong> &nbsp;&nbsp; <span id="info"></span>
    </div>

        <div class="alert alert-success alert-dismissable col-sm-2" style="float: right; display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>成功! </strong> &nbsp;&nbsp; <span id="info-success"></span>
        </div>
</div>