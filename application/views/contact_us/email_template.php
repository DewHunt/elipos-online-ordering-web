<div>
    <style>
        table th,td { border: none; }
    </style>
    <h1 style="text-align: center">Message From Contact Us</h1>
    <table style="width:100%">
        <tr><th>Name:</th><td><?= !empty($name) ? $name : ''; ?></td></tr>
        <tr><th>Email address:</th><td><?= !empty($email) ? $email : ''; ?></td></tr>
        <tr><th>Mobile:</th><td><?= !empty($mobile) ? $mobile : ''; ?></td></tr>
        <tr><th>Message:</th><td><?= !empty($message) ? $message : ''; ?></td></tr>
    </table>
</div>