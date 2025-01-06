<div>
    <?php
    function printArray($array, $prefix = '') {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                echo $prefix . $key . ": <br>";
                printArray($value, $prefix . '&nbsp;&nbsp;&nbsp;'); // Indent nested values
            } else {
                echo $prefix . $key . ": " . htmlspecialchars($value) . "<br>";
            }
        }
    }
    ?>

    <?php
    // Convert the $parent Eloquent model to an array before passing it to the function
    printArray($parent->toArray());
    ?>
</div>
<?php /**PATH D:\github\BeaconChildrenCenter\resources\views/reception/visits.blade.php ENDPATH**/ ?>