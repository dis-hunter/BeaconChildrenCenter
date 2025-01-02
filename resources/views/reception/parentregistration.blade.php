<form action="{{ route('parents.store') }}" method="post">
    @csrf
    <table>
        <!-- Fullname fields -->
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
            <td>Telephone</td>
            <td><input type="text" name="telephone" value="{{ old('telephone') }}"></td>
        </tr>

        <!-- National ID -->
        <tr>
            <td>National ID</td>
            <td><input type="text" name="national_id" value="{{ old('national_id') }}"></td>
        </tr>

        <!-- Employer -->
        <tr>
            <td>Employer</td>
            <td><input type="text" name="employer" value="{{ old('employer') }}"></td>
        </tr>

        <!-- Insurance -->
        <tr>
            <td>Insurance</td>
            <td><input type="text" name="insurance" value="{{ old('insurance') }}"></td>
        </tr>

        <!-- Email -->
        <tr>
            <td>Email</td>
            <td><input type="email" name="email" value="{{ old('email') }}"></td>
        </tr>

        <!-- Relationship -->
        <tr>
            <td>Relationship</td>
            <td>
                <select name="relationship_id">
                    <option value="1" {{ old('relationship_id') == '1' ? 'selected' : '' }}>Parent</option>
                    <option value="2" {{ old('relationship_id') == '2' ? 'selected' : '' }}>Sibling</option>
                    <option value="3" {{ old('relationship_id') == '3' ? 'selected' : '' }}>Friend</option>
                </select>
            </td>
        </tr>

        <!-- Referer -->
        <tr>
            <td>Referer</td>
            <td><input type="text" name="referer" value="{{ old('referer') }}"></td>
        </tr>

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
