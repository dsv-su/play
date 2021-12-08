Upload notification<br><br>

Your presentation with title: <b>{{ $presentation['title'] }}</b> has been uploaded successfully and is active on DSVPlay.
<br><br>

If you would like to change the presentation setting, use this link (or copy this link and paste it in your browser):
<br><br>
{{URL::to('/').'/edit/'.$presentation->id}}

<br><br>
---
<br>
This is an automated email, please do not reply to this email.
<br>
If you need additional support, please contact us via <b>helpdesk@dsv.su.se</b>
<br><br>
{{ date("Y-m-d H:i:s") }} - {{ $presentation['id'] }}<br><br>
