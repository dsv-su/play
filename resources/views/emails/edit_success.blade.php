Meddelande om Redigering<br><br>

Din presentation med titeln: <b>{{ $presentation['title'] }}</b> har redigerats.
<br><br>
Om du vill göra ytterligare redigeringar, använd länken längst ner i detta meddelande (eller kopiera den här länken och klistra in den i din webbläsare).
<br><br>
---
<br>
Notice of Editing<br><br>

Your presentation with title: <b>{{ $presentation['title_en'] }}</b> has been edited.
<br><br>
If you would like to make additional edits, please use the link at the bottom of this message (or copy and paste this link into your browser).
<br><br>
---
<br><br>

{{URL::to('/').'/edit/'.$presentation->id}}

<br><br>
---
<br>
Detta är ett automatiskt e-postmeddelande, vänligen svara inte på detta e-postmeddelande.
<br>
This is an automated email, please do not reply to this email.
<br><br>
Om du behöver ytterligare support, vänligen kontakta oss via <b>helpdesk@dsv.su.se</b>
<br>
If you need additional support, please contact us via <b>helpdesk@dsv.su.se</b>
<br><br>
{{ date("Y-m-d H:i:s") }} - {{ $presentation['id'] }}<br><br>
