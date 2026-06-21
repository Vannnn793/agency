<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth - Talent Agency</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f9fafb;
            font-family: 'Inter', sans-serif;
        }

        .auth-container {
            min-height: 100vh;
        }

        .auth-left {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            color: white;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-right {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 100%;
            max-width: 400px;
            border-radius: 12px;
            padding: 30px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        input, select {
            border-radius: 8px !important;
        }
    </style>
</head>
<body>

<div class="container-fluid auth-container">
    <div class="row h-100">

        <!-- LEFT -->
        <div class="col-md-6 auth-left d-none d-md-flex">
            <div>
                <h1 class="fw-bold">Talent Agency</h1>
                <p>Connecting companies with top-tier talent.</p>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-md-6 auth-right">
            @yield('content')
        </div>

    </div>
</div>

</body>
</html>