<?php exit; ?>
[2021-10-30 11:31:03] ERROR: Form 1251 > Mailchimp API error: 400 Bad Request. Invalid Resource. Your merge fields were invalid. 
- YNAME : Please enter a value

Request: 
POST https://us8.api.mailchimp.com/3.0/lists/a909edc3b7/members

{"status":"pending","email_address":"caot********@gm***.com","interests":{},"merge_fields":{},"email_type":"html","ip_signup":"192.168.64.1","tags":[]}

Response: 
400 Bad Request
{"type":"https://mailchimp.com/developer/marketing/docs/errors/","title":"Invalid Resource","status":400,"detail":"Your merge fields were invalid.","instance":"fe2519c6-aa41-79af-c255-7f3b2a29c72b","errors":[{"field":"YNAME","message":"Please enter a value"}]}
