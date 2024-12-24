<!DOCTYPE html>
<html>
<head>
    <title>Add Doctor</title>
</head>
<body>
    <form action="/doctors" method="POST">
        @csrf
        <label for="staff_id">Staff ID:</label>
        <input type="text" id="staff_id" name="staff_id" required>

        <label for="specialization">Specialization:</label>
        <input type="text" id="specialization" name="specialization" required>

        <button type="submit">Add Doctor</button>
    </form>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
</body>
</html>
