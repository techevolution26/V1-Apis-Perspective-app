<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Register</title>
</head>
<body>
    <h1>Test API Registration</h1>
    <form id="registerForm">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br>
        <button type="submit">Register</button>
    </form>


    <script>
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {
                name: formData.get('name')
                , email: formData.get('email')
                , password: formData.get('password')
                , password_confirmation: formData.get('password_confirmation')
            , };

            try {
                const response = await fetch('/api/register', {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'Accept': 'application/json'
                    , }
                    , body: JSON.stringify(data)
                , });

                const result = await response.json();
                alert("Success: " + JSON.stringify(result));
            } catch (err) {
                console.error(err);
                alert("Failed to register: " + err.message);
            }
        });

    </script>
</body>
</html>
