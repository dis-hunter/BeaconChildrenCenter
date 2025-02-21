<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>403 Forbidden</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            padding-top: 10%;
        }
        h1 {
            font-size: 100px;
            color: #dc3545;
        }
        p {
            font-size: 24px;
            color: #6c757d;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-size: 20px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>403</h1>
    <p>Oops! You don't have permission to access this page.</p>
    <a href="{{ url('/') }}">Go Back Home</a>
</body>
</html>
