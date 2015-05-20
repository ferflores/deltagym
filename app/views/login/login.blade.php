@extends('layouts.default')

@section('content')
<div style="margin: 0 auto;width:100%;text-align:center">
<h1>Inicio</h1>

    <!-- check for login error flash var -->
    @if (Session::has('flash_error'))
        <div id="flash_error">{{ Session::get('flash_error') }}</div>
    @endif

    {{ Form::open(array('route' => 'login', 'method' => 'POST' )) }}

    <!-- username field -->
    <p>
        {{ Form::label('username', 'Usuario') }}<br/>
        {{ Form::text('username', Input::old('username'), array('class'=>'rounded')) }}
    </p>

    <!-- password field -->
    <p>
        {{ Form::label('password', 'Password') }}<br/>
        {{ Form::password('password',array('class'=>'rounded')) }}
    </p>

    <!-- submit button -->
    <p>{{ Form::submit('Entrar',array('class'=>'ui-button ui-widget ui-state-default ui-corner-all submitButton')) }}</p>

    {{ Form::close() }}
</div>
<script src="{{ asset('/scripts/jquery/jquery1.10.2.js') }}"></script>
<script type="text/javascript">
    $(document).ready( function(){
        $(window).keydown(function(e) {
            if (e.keyCode == 13) {
                $(".submitButton").click();
            }
        });
    } );
</script>
@stop
@endsection

