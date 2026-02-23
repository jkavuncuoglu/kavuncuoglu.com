<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Message</title>
    <style>
        body { font-family: sans-serif; color: #1b1b18; background: #f9f9f8; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border: 1px solid #e3e3e0; border-radius: 8px; padding: 32px; }
        h1 { font-size: 1.25rem; margin-bottom: 24px; }
        .field { margin-bottom: 16px; }
        .label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #706f6c; margin-bottom: 4px; }
        .value { font-size: 0.95rem; }
        .message-box { background: #f4f4f2; border-radius: 6px; padding: 16px; white-space: pre-wrap; }
    </style>
</head>
<body>
    <div class="container">
        <h1>New Contact Form Message</h1>

        <div class="field">
            <div class="label">Name</div>
            <div class="value">{{ $contactMessage->name }}</div>
        </div>

        <div class="field">
            <div class="label">Email</div>
            <div class="value"><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></div>
        </div>

        @if($contactMessage->subject)
        <div class="field">
            <div class="label">Subject</div>
            <div class="value">{{ $contactMessage->subject }}</div>
        </div>
        @endif

        <div class="field">
            <div class="label">Message</div>
            <div class="message-box">{{ $contactMessage->message }}</div>
        </div>
    </div>
</body>
</html>
