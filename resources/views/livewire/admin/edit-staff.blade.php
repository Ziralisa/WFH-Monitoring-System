<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            background-color: white;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #343a40;
        }
        .form-group label {
            font-weight: 500;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .back-button {
            margin-bottom: 20px; /* Space below the button */
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Back Button -->
    <a href="{{ route('admin.staff-list') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <h1>Edit Staff Details</h1>

    <!-- Form for updating staff details -->
    <form method="POST" action="{{ route('admin.staff.update', $staff->id) }}">
        @csrf
        @method('PUT') <!-- Use PUT for updates -->
        
        <!-- Name Input -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $staff->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Input -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $staff->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Phone Input -->
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $staff->phone) }}" required>
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Location Input -->
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $staff->location) }}" required>
            @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Update Button -->
        <button type="submit" class="btn btn-success btn-block">Update Staff</button>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
