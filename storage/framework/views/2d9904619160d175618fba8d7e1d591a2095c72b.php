<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="container">
    <h2>📋 Post-Triage Queue</h2>

    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr>
               
                <th>Patient Name</th>
                
            </tr>
        </thead>
        <tbody id="post-triage-list">
            <tr>
                <td colspan="6" style="text-align: center;">Loading...</td>
            </tr>
        </tbody>
    </table>
</div>

<script src="<?php echo e(asset('js/postTriageQueue.js')); ?>"></script>

</body>
</html>

<?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/postTriageQueue.blade.php ENDPATH**/ ?>