<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Student List</h2>
    <table>
        <thead>
            <tr>
                <th>S/N</th>
                <th>First Name</th>
                <th>Other Name</th>
                <th>Last Name</th>
                <th>Matric No</th>
                <th>Phone Number</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->first_name }}</td>
                    <td>{{ $student->other_name }}</td>
                    <td>{{ $student->last_name }}</td>
                    <td>{{ $student->matric_no }}</td>
                    <td>{{ $student->phone_number }}</td>
                    <td>{{ ucfirst($student->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
