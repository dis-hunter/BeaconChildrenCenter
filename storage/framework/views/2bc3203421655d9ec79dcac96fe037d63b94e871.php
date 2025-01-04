<!-- Search Form -->
 <h2>welcome</h2>
<form action="<?php echo e(route('parent.get-children')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <table>
        <tr>
            <td>Search by Telephone</td>
            <td><input type="text" name="telephone" placeholder="Enter Telephone" value="<?php echo e(old('telephone')); ?>"></td>
            <td><input type="submit" value="Search"></td>
        </tr>
    </table>
</form>

<!-- Error Message -->
<?php if(session()->has('error')): ?>
<p style="color: red;">
    <?php echo e(session()->get('error')); ?>

</p>
<?php endif; ?>

<?php if(isset($children) && $children->count() > 0): ?>
    <h3>Children Records</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($child->id); ?></td>
                    <td><?php echo e(json_decode($child->fullname)->firstname); ?> <?php echo e(json_decode($child->fullname)->surname); ?></td>
                    <td><?php echo e($child->dob); ?></td>
                    <td><?php echo e($child->gender_id); ?></td>
                    <td>
                        <form action="<?php echo e(route('children.create')); ?>" method="get">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="child_id" value="<?php echo e($child->id); ?>">
                            <button type="submit">Select</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>

<label for="specialization">Select Specialization:</label>
<select name="specialization_id" id="specialization">
    <option value="">-- Select Specialization --</option>
</select>



<!--  -->


<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log("welcome");
        fetch('/specializations') // Adjust the URL if needed
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const specializations = data.data;
                    console.log("this is:",specialization);
                    const dropdown = document.getElementById('specialization');

                    // Clear existing options
                    dropdown.innerHTML = '<option value="">-- Select Specialization --</option>';

                    // Populate dropdown
                    specializations.forEach(specialization => {
                        const option = document.createElement('option');
                        option.value = specialization.id;
                        option.textContent = specialization.specialization;
                        dropdown.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching specializations:', error);
            });
    });
    const dropdown = document.getElementById('specialization');
dropdown.addEventListener('change', async function() {
    try {
        const selectedId = this.value;
        console.log('Selected Specialization ID:', selectedId);

        if (!selectedId) {
            console.log('No specialization selected');
            return;
        }

        // First fetch - getting doctors
        const doctorsResponse = await fetch(`http://127.0.0.1:8000/doctors?specialization_id=${selectedId}`);
        if (!doctorsResponse.ok) {
            throw new Error(`HTTP error! status: ${doctorsResponse.status}`);
        }
        
        const doctorsData = await doctorsResponse.json();
        console.log('Doctors response:', doctorsData);

        if (doctorsData.status === 'success' && doctorsData.data) {
            const staffIds = doctorsData.data.map(doctor => doctor.staff_id);
            console.log('Staff IDs to fetch:', staffIds);

            if (staffIds.length === 0) {
                console.log('No staff IDs found');
                return;
            }

            // Second fetch - getting staff names
            const staffResponse = await fetch(`http://127.0.0.1:8000/staff/names?staff_ids=${staffIds.join(',')}`);
            
            // Log the raw response for debugging
            console.log('Raw staff response:', staffResponse);
            
            if (!staffResponse.ok) {
                // Try to get error details if available
                const errorText = await staffResponse.text();
                console.error('Staff response error:', errorText);
                throw new Error(`Staff fetch failed: ${staffResponse.status}`);
            }

            const staffData = await staffResponse.json();
            console.log('Staff data:', staffData);
            
            // Handle the staff data here
            if (staffData.status === 'success') {
                // Update your UI with the staff data
                console.log('Successfully fetched staff:', staffData.data);
            }
        }
    } catch (error) {
        console.error('Error in fetch operation:', error);
        // Handle the error appropriately in your UI
    }
});


</script>
<?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/Receiptionist/visits.blade.php ENDPATH**/ ?>