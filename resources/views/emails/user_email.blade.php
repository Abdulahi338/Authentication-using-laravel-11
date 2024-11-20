<!DOCTYPE html>
<html>
<head>
    <title>{{ $emailDetails['subject'] }}</title>
</head>
<body>
    <p>{{ $emailDetails['content'] }}</p>
    <p>Sent to: {{ $emailDetails['to'] }}</p>
</body>
</html>
