<html>
<body>
    <p>Admin,</p>

    <p>A new vendor has registered and is awaiting admin approval.</p>

    <p>Vendor details:</p>
    <ul>
        <li>Shop name: {{ $vendor->shop_name }}</li>
        <li>Owner name: {{ $vendor->owner_name }}</li>
        <li>Email: {{ $vendor->email }}</li>
        <li>Phone: {{ $vendor->phone }}</li>
        <li>NIC: {{ $vendor->nic }}</li>
    </ul>

    <p>Please review and approve the account in the admin panel.</p>

    <p>Regards,<br>AutoPartHubSL System</p>
</body>
</html>
