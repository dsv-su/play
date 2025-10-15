DSVPlay error alert,<br><br>

There is a <b>{{ $exception['name'] }}</b> on DSVPlay.<br><br>

<b>Error</b>: {{ $exception['message'] }}<br><br>

<b>File</b>: {{ $exception['file'].":".$exception['line'] }}<br><br>

<b>Time</b> {{ date("Y-m-d H:i:s") }}<br><br>
