Meddelande om uppladdning<br><br>

Din presentation med titeln: <b>{{ $presentation['title'] }}</b> har laddats upp på DSVPlay. För att göra din presentation synlig måste du aktivera synlighet.
<br><br>
Om du vill aktivera synlighet eller ändra presentationsinställningen, använd den här länken (eller kopiera den här länken och klistra in den i din webbläsare):
<br><br>
---
<br>
Upload notification<br><br>

Your presentation with title: <b>{{ $presentation['title_en'] }}</b> has been uploaded successfully to DSVPlay. To make your presentation visible, you need to enable visibility.
<br><br>
If you would like to enable visibility or change the presentation setting, use this link (or copy this link and paste it in your browser):
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
