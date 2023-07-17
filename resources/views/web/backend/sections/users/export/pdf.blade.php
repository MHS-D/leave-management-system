<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
	<title>Users PDF</title>
</head>

<body>
    <h1>Users</h1>

	{{-- NOTE: Not all css styles can be rendered in the PDF (borders for example) --}}
    <table class="table">
        <thead>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Balance</th>
            <th>Total Balance</th>
            <th>Status</th>
            <th>Role</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->latestTransaction?->balance ?? '0' }}</td>
                    <td>{{ $user->total_balance ?? '0' }}</td>
                    <td>{{ ucfirst($user->status_name) }}</td>
                    <td>{{ ucfirst($user->role ?? '---') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
