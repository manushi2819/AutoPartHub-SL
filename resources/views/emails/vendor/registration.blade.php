<html>
<body>
    <p>Dear {{ $vendor->owner_name }},</p>

    <p>Thank you for registering as a vendor on AutoPartHubSL. Your registration is completed and is now awaiting admin approval.</p>

    <p>Login details:</p>
    <ul>
        <li>Email: {{ $vendor->email }}</li>
        <li>Password: {{ $password }}</li>
    </ul>

    <p>We will notify you once your account is approved.</p>

    <p>Regards,<br>AutoPartHubSL Team</p>
</body>
</html>
