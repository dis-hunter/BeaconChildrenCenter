<!-- Search Form -->
<form action="{{ route('parents.search') }}" method="post">
    @csrf
    <table>
        <tr>
            <td>Search by Telephone</td>
            <td><input type="text" name="telephone" placeholder="Enter Telephone" value="{{ old('telephone') }}"></td>
            <td><input type="submit" value="Search"></td>
        </tr>
    </table>
</form>

<!-- Error Message -->
@if(session()->has('error'))
<p style="color: red;">
    {{ session()->get('error') }}
</p>
@endif

@if(isset($parent))
    <h3>Parent Record</h3>
    <table border="1">
        <tr>
            <td>Full Name</td>
            <td>{{ json_decode($parent->fullname)->firstname }} {{ json_decode($parent->fullname)->middlename }} {{ json_decode($parent->fullname)->surname }}</td>
        </tr>
        <tr>
            <td>Telephone</td>
            <td>{{ $parent->telephone }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $parent->email }}</td>
        </tr>
        <tr>
            <td>Action</td>
            <td>
                <form action="{{ route('children.create') }}" method="get">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $parent->id }}">
                    <button type="submit">Use This Parent</button>
                </form>
            </td>
        </tr>
    </table>
@endif

<form action="{{ route('children.store') }}" method="post">
    @csrf
    <input type="hidden" name="parent_id" value="{{ request('parent_id') }}">
    <!-- Rest of the form fields -->
    <tr>
        <td>First Name</td>
        <td><input type="text" name="firstname" value="{{ old('firstname') }}"></td>
    </tr>
    <tr>
        <td>Middle Name</td>
        <td><input type="text" name="middlename" value="{{ old('middlename') }}"></td>
    </tr>
    <tr>
        <td>Surname</td>
        <td><input type="text" name="surname" value="{{ old('surname') }}"></td>
    </tr>

        
        <!-- Date of Birth -->
        <tr>
            <td>Date of Birth</td>
            <td><input type="date" name="dob" value="{{ old('dob') }}"></td>
        </tr>

        <!-- Gender Dropdown -->
        <tr>
            <td>Gender</td>
            <td>
                <select name="gender_id">
                    <option value="1" {{ old('gender_id') == '1' ? 'selected' : '' }}>Male</option>
                    <option value="2" {{ old('gender_id') == '2' ? 'selected' : '' }}>Female</option>
                </select>
            </td>
        </tr>

        <!-- Telephone -->
        <tr>
            <td>birth Certificate</td>
            <td><input type="text" name="birth_cert" value="{{ old('birth_cert') }}"></td>
        </tr>

        <!-- National ID -->
        <tr>
            <td>Registration_number</td>
            <td><input type="text" name="registration_number" value="{{ old('registration_number') }}"></td>
        </tr>

        <!-- Employer -->
       
        <!-- Submit Button -->
        <tr>
            <td></td>
            <td><input type="submit" value="Register"></td>
        </tr>
    </table>

    <!-- Success Message -->
    @if(session()->has('success'))
    <p style="color: blue;">
        {{ session()->get('success') }}
    </p>
    @endif
</form>
