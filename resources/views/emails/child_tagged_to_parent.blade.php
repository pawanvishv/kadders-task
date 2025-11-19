<!DOCTYPE html>
<html>
<head>
    <title>Child Tagged</title>
</head>
<body>
    <p>Hi {{ $parent->first_name }},</p>
    <p>Your child {{ $child->first_name }} has been tagged to you.</p>
    <p>Thank you!</p>
</body>
</html>
