@props(['title', 'text', 'message'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
<table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto;">
    <tr>
        <td align="center" style="padding: 40px 0;">
            <h1 style="font-size: 36px; font-weight: bold;">Tabely</h1>
            <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="Logo" width="128" height="160">
        </td>
    </tr>
    <tr>
        <td align="center" style="padding: 20px;">
            <p style="font-size: 18px;">{{ $text }}</p>
            {{ $slot }}
        </td>
    </tr>
    <tr>
        <td align="center" style="padding:30px;font-size:14px;color:#777;">
            © {{ date('Y') }} Tabely. All rights reserved.
        </td>
    </tr>
</table>
</body>
</html>
